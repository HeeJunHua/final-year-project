<?php

namespace App\Http\Controllers;

use App\Mail\ReceiptMail;
use App\Models\Announcement;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\CompletionForm;
use App\Models\Donation;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Payment;
use App\Models\Point;
use App\Models\Redemption;
use App\Models\Volunteer;
use App\Models\Vouchers;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class EventController extends Controller {
    public function __construct() {
        //must login, except the function
        $this->middleware('auth', ['except' => ['eventDetail', 'getDonor', 'share', 'allevent']]);
    }

    //to check if admin
    private function isAdmin() {
        $result = false;
        if(auth()->user()->user_role == "admin") {
            $result = true;
        }

        return $result;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // per page
        $perPage = 10;

        // start a query
        $query = Event::query();

        //if not admin take own record only
        if($this->isAdmin() == false) {
            $query->where('user_id', auth()->user()->id);
        }

        // Search event name
        if($request->has('search')) {
            $query->where('event_name', 'like', '%'.$request->input('search').'%');
        }

        // Search event status
        if($request->has('status') && $request->input('status') != "All") {
            $query->where('event_status', 'like', $request->input('status'));
        }

        //total sum
        $total = $query->sum('target_goal');

        // paginate
        $records = $query->with('category')->orderBy('created_at', 'desc')->paginate($perPage);

        // Status option
        $status = ['All' => 'All', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        // return view with data
        return view('event/index', ['records' => $records, 'status' => $status, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //get category
        $categories = Category::pluck('category_name', 'id');

        //status
        $status = ['Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        //return view
        return View::make('event.add', compact('categories', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
            ];

            //rules
            $rules = [
                'event_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'event_description' => 'required|string',
                'event_location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'target_goal' => 'required|numeric|min:0',
                'cover_image' => 'image|mimes:jpeg,jpg,png|max:2048',
                'attachment' => 'sometimes|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime|max:20480',
                'event_attachment.*' => 'max:2048',
            ];

            //if got announcement
            if($request->ann == "1") {
                $rules["ann_text"] = 'required|string';
                $rules["ann_contact_phone"] = [
                    'required',
                    'string',
                    'max:20',
                    'min:10',
                    'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
                ];
                $rules["ann_contact_email"] = ['required', 'email'];
            }

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // new record
        $record = new Event();

        if($request->hasFile('cover_image')) {
            $picture = $request->file('cover_image');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/events', $fileName);

            // Update the picture with the generated filename
            $record->cover_image = $fileName;
        }

        //update field
        $record->event_name = $request->input('event_name');
        $record->category_id = $request->input('category_id');
        $record->event_description = $request->input('event_description');
        $record->event_location = $request->input('event_location');
        $record->start_date = $request->input('start_date');
        $record->end_date = $request->input('end_date');
        $record->target_goal = $request->input('target_goal');
        $record->user_id = Auth::user()->id;
        $record->event_status = 'Pending';
        if($request->has('event_status') && !empty($request->input('event_status'))) {
            $record->event_status = $request->input('event_status');
        }

        //save
        $record->save();

        //attachment
        if($request->hasFile('attachment')) {
            $picture = $request->file('attachment');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/event_attachment', $fileName);

            // Update the picture with the generated filename

            $attachment = new EventImage();
            $attachment->event_id = $record->id;
            $attachment->image_path = $fileName;

            //save
            $attachment->save();
        }

        //event attachment
        if($request->hasFile('event_attachment')) {
            foreach($request->file('event_attachment') as $file) {
                $orifileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
                $fileName = auth()->id().'_'.time().'.'.$extension;

                // Store the file in the public storage and use the generated filename
                $file->storeAs('public/attachment', $fileName);

                // Update the file with the generated filename
                $attachment = new Attachment();
                $attachment->event_id = $record->id;
                $attachment->name = $orifileName;
                $attachment->path = $fileName;

                //save
                $attachment->save();
            }
        }

        //Announcement
        if($request->ann == "1") {
            $ann = new Announcement();
            $ann->user_id = Auth::user()->id;
            $ann->event_id = $record->id;
            $ann->ann_text = $request->input('ann_text');
            $ann->ann_contact_phone = $request->input('ann_contact_phone');
            $ann->ann_contact_email = $request->input('ann_contact_email');

            //save
            $ann->save();
        }

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'event.index', 'status' => 'success', 'message' => 'Event created successfully'])], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //get record
        $record = Event::with('category', 'announcements', 'eventImages', 'attachment')->find($id);

        return View::make('event.view', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //get record
        $record = Event::with('announcements', 'eventImages', 'attachment')->find($id);

        //get category
        $categories = Category::pluck('category_name', 'id');

        //status
        $status = ['Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        return View::make('event.edit', compact('record', 'categories', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
            ];

            //rules
            $rules = [
                'event_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'event_description' => 'required|string',
                'event_location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'target_goal' => 'required|numeric|min:0',
                'cover_image' => 'image|mimes:jpeg,jpg,png|max:2048',
                'attachment' => 'sometimes|mimetypes:image/jpeg,image/png,video/mp4,video/quicktime|max:20480',
                'event_attachment.*' => 'max:2048',
            ];

            //if got announcement
            if($request->ann == "1") {
                $rules["ann_text"] = 'required|string';
                $rules["ann_contact_phone"] = [
                    'required',
                    'string',
                    'max:20',
                    'min:10',
                    'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
                ];
                $rules["ann_contact_email"] = ['required', 'email'];
            }

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // Find the record
        $record = Event::find($id);

        if($request->hasFile('cover_image')) {
            $picture = $request->file('cover_image');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/events', $fileName);

            // Update the picture with the generated filename
            $record->cover_image = $fileName;
        }

        //update field
        $record->event_name = $request->input('event_name');
        $record->category_id = $request->input('category_id');
        $record->event_description = $request->input('event_description');
        $record->event_location = $request->input('event_location');
        $record->start_date = $request->input('start_date');
        $record->end_date = $request->input('end_date');
        $record->target_goal = $request->input('target_goal');
        if($request->has('event_status') && !empty($request->input('event_status'))) {
            $record->event_status = $request->input('event_status');
        }

        //save
        $record->save();

        //existing
        if($request->has('att') && !empty($request->input('att'))) {
            foreach($request->input('att') as $value) {
                $att = EventImage::find($value);
                //if file exist, delete the file
                if(file_exists(public_path('storage/event_attachment/'.$att->image_path))) {
                    unlink('storage/event_attachment/'.$att->image_path);
                }
                //delete
                $att->delete();
            }
        }

        //attachment
        if($request->hasFile('attachment')) {
            $picture = $request->file('attachment');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/event_attachment', $fileName);

            // Update the picture with the generated filename

            $attachment = new EventImage();
            $attachment->event_id = $record->id;
            $attachment->image_path = $fileName;

            //save
            $attachment->save();
        }

        //existing event attachment
        if($request->has('event_attachment') && !empty($request->input('event_attachment'))) {
            foreach($request->input('event_attachment') as $value) {
                $att = Attachment::find($value);
                //if file exist, delete the file
                if(file_exists(public_path('storage/attachment/'.$att->image_path))) {
                    unlink('storage/attachment/'.$att->image_path);
                }
                //delete
                $att->delete();
            }
        }

        //event attachment
        if($request->hasFile('event_attachment')) {
            foreach($request->file('event_attachment') as $file) {
                $orifileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
                $fileName = auth()->id().'_'.time().'.'.$extension;

                // Store the file in the public storage and use the generated filename
                $file->storeAs('public/attachment', $fileName);

                // Update the file with the generated filename
                $attachment = new Attachment();
                $attachment->event_id = $record->id;
                $attachment->name = $orifileName;
                $attachment->path = $fileName;

                //save
                $attachment->save();
            }
        }

        //Announcement

        //find existing
        $ann = Announcement::where('event_id', $record->id)->first();

        if($request->ann == "1") {
            //if no announcement
            if(!$ann) {
                $ann = new Announcement();
                $ann->user_id = Auth::user()->id;
                $ann->event_id = $record->id;
            }

            //update field
            $ann->ann_text = $request->input('ann_text');
            $ann->ann_contact_phone = $request->input('ann_contact_phone');
            $ann->ann_contact_email = $request->input('ann_contact_email');

            //save
            $ann->save();
        } else {
            if($ann) {
                $ann->delete();
            }
        }

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'event.index', 'status' => 'success', 'message' => 'Event updated successfully'])], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event) {
        //check if admin
        if($this->isAdmin() == false) {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }

        // delete
        try {
            $event->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
    }

    public function respond(string $id, string $status) {
        //check if admin
        if($this->isAdmin() == false) {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }

        //initial if wrong parameter
        $route = "event.index";
        $alert = "error";
        $message = "Invalid Parameter";

        switch($status) {
            case 'Approved':
            case 'Rejected':
                //get the record
                $record = Event::find($id);
                //update status
                $record->event_status = $status;
                //save
                $record->save();

                //change alert
                $alert = "success";
                //change message
                $message = 'Event '.strtolower($status).' successfully.';
                break;
        }

        return redirect()->route($route)->with($alert, $message);
    }

    //landing event detail
    public function eventDetail(string $id) {
        //get record with donation sum, latest 5 donation record, total donation count
        $record = Event::withSum('donations', 'donation_amount')->with([
            'announcements',
            'eventImages',
            'category',
            'user',
            'donations' => function ($query) {
                $query->latest('created_at')->take(5);
            },
            'donations.user'
        ])->withCount('donations')->find($id);

        return view('landing/eventdetail', compact('record'));
    }

    //get all donor for the event
    public function getDonor(string $id) {
        //get record
        $record = Event::with([
            'donations' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->withSum('donations', 'donation_amount')->find($id);

        return View::make('landing/getdonor', compact('record'));
    }

    //share
    public function share(string $id) {
        //get record
        $record = Event::find($id);

        return View::make('landing/share', compact('record'));
    }

    //donate
    public function donate(string $id) {
        //get record
        $record = Event::find($id);

        //amount
        $amount = [100 => 100, 200 => 200, 500 => 500, 1000 => 1000, 1500 => 1500];

        return view('landing/donate', compact('record', 'amount'));
    }

    //payment
    public function payment(string $id, string $method) {
        //get record
        $record = Event::find($id);

        return View::make('landing/payment', compact('record', 'method'));
    }

    public function makepayment(Request $request) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
            ];

            //rules
            $rules = [
                'amount' => 'required|numeric|min:1',
                'method' => 'required|string|max:50',
                'name' => 'required|string|max:255',
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'min:10',
                    'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
                ],
                'email' => ['required', 'email'],
                'cc1' => 'sometimes|required|numeric',
                'cc2' => 'sometimes|required|numeric',
                'cc3' => 'sometimes|required|numeric',
                'cc4' => 'sometimes|required|numeric',
                'cvv' => 'sometimes|required|numeric',
                'ex_m' => 'sometimes|required|numeric',
                'ex_y' => 'sometimes|required|numeric',
                'card_name' => 'sometimes|required|string|max:255',
                // 'pp_email' => ['sometimes', 'required', 'email'],
                // 'pp_password' => 'sometimes|required|string|max:255',
            ];

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // new record
        // $record = new Donation();
        $record = new Payment();

        //update field
        $record->event_id = $request->input('event_id');
        $record->user_id = Auth::user()->id;
        $record->points_earned = floor($request->input('amount') / 10);
        $record->donation_amount = $request->input('amount');
        $record->payment_method = $request->input('method');
        $record->donation_date = date('Y-m-d');
        $record->name = $request->input('name');
        $record->phone = $request->input('phone');
        $record->email = $request->input('email');
        $record->status = 0;

        //save
        $record->save();

        if($record->payment_method=="PayPal"){
            return response()->json(['route' => $this->paypal($record->donation_amount, 'MYR', $record->id)], 200);
        }else if($record->payment_method=="Credit Card"){
            return response()->json(['route' => $this->donationsuccess($record->id)], 200);
        }else{
            return response()->json(['route' => route('paymenterror', ['message' => 'Invalid Payment Method'])], 200);
        }
    }

    //receipt
    public function receipt(string $id) {
        //get record
        $record = Donation::with(['event'])->find($id);

        return view('landing/receipt', compact('record'));
    }

    //history
    public function history(Request $request) {
        // per page
        $perPage = 10;

        // start a query
        $query = Donation::query();

        if(!$this->isAdmin()) {
            $query->where('user_id', auth()->user()->id);
        }

        // Search event name
        if($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('event', function ($query) use ($search) {
                $query->where('event_name', 'like', '%'.$search.'%');
            });
        }

        $total = $query->sum('donation_amount');

        // paginate
        $records = $query->orderBy('created_at', 'desc')->with(['event', 'user'])->paginate($perPage);

        // return view with data
        return view('event/history', ['records' => $records, 'total' => $total]);
    }

    //report page
    public function report(Request $request) {
        // per page
        $perPage = 10;

        // start a query
        $query = Event::query();

        if($this->isAdmin() == false) {
            $query->where('user_id', auth()->user()->id);
        }

        // Search event name
        if($request->has('search')) {
            $query->where('event_name', 'like', '%'.$request->input('search').'%');
        }

        // Search event status
        if($request->has('status') && $request->input('status') != "All") {
            $query->where('event_status', 'like', $request->input('status'));
        }

        $total = $query->sum('target_goal');

        // paginate
        $records = $query->with('category')->orderBy('created_at', 'desc')->paginate($perPage);

        // Status option
        $status = ['All' => 'All', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        // return view with data
        return view('event/report', ['records' => $records, 'status' => $status, 'total' => $total]);
    }

    //redeem page
    public function redeem(string $status, Request $request) {
        // Find vouchers where the expiry date is more than today
        $vouchersToUpdate = Vouchers::where('voucher_expiry_date', '<', now())->get();

        // Update the status for each voucher
        foreach($vouchersToUpdate as $voucher) {
            $voucher->update(['voucher_status' => 'Pass']);
        }

        // per page
        $perPage = 10;

        // start a query
        $query = Vouchers::query();

        // Search event name
        if($request->has('search')) {
            $query->where('voucher_code', 'like', '%'.$request->input('search').'%');
        }

        switch($status) {
            case "Pass":
                $query->where('voucher_status', 'like', "Pass")->orWhere('voucher_expiry_date', '<', now());
                break;
            case "Clear":
                $query->whereHas('redemptions', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })->with(['redemptions']);
                break;
            case "Ongoing":
            default:
                $query->where('voucher_status', 'like', "Ongoing")->where('voucher_expiry_date', '>=', now())->whereDoesntHave('redemptions', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                break;
        }

        // paginate
        $records = $query->withCount('redemptions')->orderBy('voucher_expiry_date', 'asc')->paginate($perPage);

        $point_cr = Donation::where('user_id', auth()->user()->id)->sum('points_earned');
        $point_dr = Redemption::where('user_id', auth()->user()->id)->sum('redeemed_points');
        $balance = $point_cr - $point_dr;

        // return view with data
        return view('event/redeem', ['records' => $records, 'status' => $status, 'total' => $point_cr, 'balance' => $balance]);
    }

    //redeem voucher
    public function redeemVoucher(string $id) {
        // Find the voucher
        $voucher = Vouchers::find($id);

        $point_cr = Donation::where('user_id', auth()->user()->id)->sum('points_earned');
        $point_dr = Redemption::where('user_id', auth()->user()->id)->sum('redeemed_points');
        $balance = $point_cr - $point_dr;

        if($voucher->voucher_point_value > $balance) {
            return redirect()->route('event.redeem', 'Ongoing')->with('error', 'Insufficient Point');
        }

        // new record
        $record = new Redemption();

        //update field
        $record->voucher_id = $voucher->id;
        $record->user_id = Auth::user()->id;
        $record->redemption_date = date('Y-m-d');
        $record->redeemed_points = $voucher->voucher_point_value;

        //save
        $record->save();

        // new record
        $point = new Point();

        //update field
        $point->event_id = null;
        $point->user_id = Auth::user()->id;
        $point->donation_id = null;
        $point->redemption_id = $record->id;
        $point->point = $voucher->voucher_point_value;
        $point->transaction_type = "DR";

        //save
        $point->save();

        $redeemed = $voucher->redemptions()->count();
        if($redeemed >= $voucher->voucher_quantity) {
            $voucher->voucher_status = "Clear";
            $voucher->save();
        }

        return redirect()->route('event.redeem', 'Clear')->with('success', 'Voucher Redeem Successful');
    }

    //point history
    public function pointhistory() {
        // per page
        $perPage = 30;

        // paginate
        $records = Point::where('user_id', auth()->user()->id)->with('event', 'redemption.voucher')->orderBy('created_at', 'desc')->paginate($perPage);

        // return view with data
        return View::make('event.pointhistory', compact('records'));
    }

    //report detail
    public function reportdetail(string $id) {
        //get record with sum of donation, donation count and all donation record
        $record = Event::withSum('donations', 'donation_amount')
            ->with([
                'donations' => function ($query) {
                    $query->orderByDesc('created_at');
                }
            ])
            ->withCount('donations')
            ->find($id);

        //take 10 days latest
        $enddate = date("Y-m-d");
        if($record->end_date < now()) {
            $enddate = $record->end_date;
        }

        $endDateCarbon = Carbon::parse($enddate);

        $latestDates = $totalsum = [];
        $latestDates[] = $enddate;

        for($i = 0; $i < 9; $i++) {
            $latestDates[] = $endDateCarbon->subDay()->toDateString();
        }

        $latestDates = array_reverse($latestDates);

        //find each total per day
        foreach($latestDates as $key => $value) {
            $sum = Donation::where('event_id', $id)->where('created_at', '>=', "{$value} 00:00:00")->where('created_at', '<=', "{$value} 23:59:59")->sum('donation_amount');
            $totalsum[] = $sum;
        }

        return View::make('event.reportdetail', compact('record', 'latestDates', 'totalsum'));
    }

    public function allevent($status, Request $request) {
        $perPage = 8;

        // start a query
        $query = Event::query();

        switch($status) {
            case "Clear":
                //get event
                $query->withSum('donations', 'donation_amount')
                    ->where('event_status', 'Approved') //approved
                    ->whereRaw('(select ifnull(sum(donation_amount),0) from donations where event_id = events.id) >= events.target_goal'); //is not fully donate
                break;
            case "Pass":
                //get event
                $query->withSum('donations', 'donation_amount')
                    ->where('event_status', 'Approved') //approved
                    ->where('end_date', '<', now()); // expire
                break;
            case "Ongoing":
            default:
                //get event
                $query->withSum('donations', 'donation_amount')
                    ->where('event_status', 'Approved') //approved
                    ->where('start_date', '<=', now()) //not expire
                    ->where('end_date', '>=', now()) //not expire
                    ->whereRaw('(select ifnull(sum(donation_amount),0) from donations where event_id = events.id) < events.target_goal'); //is not fully donate
        }

        //search event name
        if($request->has('search')) {
            $query->where('event_name', 'like', '%'.$request->input('search').'%');
        }

        // Search event status
        if($request->has('category') && $request->input('category') != "All") {
            $query->where('category_id', $request->input('category'));
        }

        $events = $query->orderBy('created_at', 'desc')->paginate($perPage);

        //get category
        $category = Category::pluck('category_name', 'id');

        return view('landing.allevent', compact('events', 'category', 'status'));
    }

    //redeem confirm
    public function confirmredeem(string $id) {
        $voucher = Vouchers::find($id);

        //make route link
        $route = route('event.redeemvoucher', ['id' => $id]);

        return View::make('event.confirmredeem', compact('route', 'voucher'));
    }

    //register volunteer
    public function registervolunteer(Announcement $announcement) {
        if($announcement->event->user_id == auth()->user()->id) {
            //redirect
            return redirect()->route('fundraise_home_page')->with('error', 'Can not register own event.');
        }

        $query = Event::query();
        $event_id = $query->withSum('donations', 'donation_amount')
            ->where('event_status', 'Approved') //approved
            ->where('start_date', '<=', now()) //not expire
            ->where('end_date', '>=', now()) //not expire
            ->whereRaw('(select ifnull(sum(donation_amount),0) from donations where event_id = events.id) < events.target_goal') //is not fully donate
            ->pluck('id', 'id')->toArray();
        if(in_array($announcement->event_id, $event_id) == false) {
            //redirect
            return redirect()->route('fundraise_home_page')->with('error', 'The event has already closed');
        }

        $register = Volunteer::where('event_id', $announcement->event_id)->where('user_id', auth()->user()->id)->count();
        if($register > 0) {
            //redirect
            return redirect()->route('fundraise_home_page')->with('error', 'You already register for this event.');
        }

        return View::make('landing/volunteer', compact('announcement'));
    }

    //store volunteer
    public function storevolunteer(Request $request, Announcement $announcement) {
        if($announcement->event->user_id == auth()->user()->id) {
            //redirect
            return redirect()->route('fundraise_home_page')->with('error', 'Can not register own event.');
        }

        //custom message
        $customErrorMessages = [
            'required' => 'The :attribute field is required.',
            'min' => 'The :attribute must have at least :min characters.',
            'max_length' => 'The :attribute must not exceed :max characters.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute is already in use.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'in' => 'Invalid :attribute value.',
            'image' => 'The :attribute must be an image file.',
            'mimes' => 'The :attribute must be a JPEG or PNG image.',
            'max_size' => 'The :attribute must not be larger than :max kilobytes.',
            'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
            'numeric' => 'The :attribute must be a number.',
            'after_or_equal' => 'Exceed date range',
            'before_or_equal' => 'Exceed date range'
        ];

        //rules
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
            ],
            'email' => 'required|email|max:255',
            'skill' => 'required|string',
            'interest' => 'required|string',
            'start_date' => 'required|date|after_or_equal:'.$announcement->event->start_date,
            'end_date' => 'required|date|before_or_equal:'.$announcement->event->end_date
        ];

        //validate
        $request->validate($rules, $customErrorMessages);

        //assign to field
        $data = new Volunteer();
        $data->event_id = $announcement->event_id;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->skill = $request->skill;
        $data->interest = $request->interest;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->status = "Pending";
        $data->user_id = auth()->user()->id;

        //save
        $data->save();

        //redirect
        return redirect()->route('fundraise_home_page')->with('success', 'Volunteer Register Successful');
    }

    //volunteer
    public function volunteer(string $type, Request $request) {
        //check if admin
        if($type == "completionform" && $this->isAdmin() == false) {
            return redirect()->route('event.volunteer', ['type' => 'myevent'])->with('error', 'No Permission');
        }

        //find event created by this user
        $event_id = Event::where('user_id', auth()->user()->id)->pluck('id', 'id')->toArray();

        // per page
        $perPage = 10;

        // start a query
        $query = Volunteer::query();

        // Search volunteer name
        if($request->has('search')) {
            $query->where('name', 'like', '%'.$request->input('search').'%');
        }

        // Search volunteer status
        if($request->has('search') && $request->has('search') != "All") {
            $query->where('status', $request->input('status'));
        }

        switch($type) {
            case "myevent":
                $query->whereIn('event_id', $event_id);
                break;
            case "completionform":
                $query->has('completion_form');
                break;
            case "myregister":
            default:
                $query->where('user_id', auth()->user()->id);
                break;
        }

        // paginate
        $records = $query->with('event.category', 'completion_form')->orderBy('created_at', 'desc')->paginate($perPage);

        //status
        $status = ['Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        // return view with data
        return view('event/volunteer', ['records' => $records, 'type' => $type, 'status' => $status]);
    }

    //view volunteer
    public function viewvolunteer(string $id) {
        //get record
        $record = Volunteer::with('event.category')->find($id);

        return View::make('event.viewvolunteer', compact('record'));
    }

    //approve/reject volunteer
    public function respondvolunteer(string $id, string $status) {
        //get the record
        $record = Volunteer::with('event')->find($id);

        //check if admin
        if(in_array($record->status, ['Pending']) == false || ($record->event->user_id != auth()->user()->id)) {
            return redirect()->route('event.volunteer', ['type' => 'myevent'])->with('error', 'No Permission');
        }

        //initial if wrong parameter
        $route = "event.volunteer";
        $alert = "error";
        $message = "Invalid Parameter";

        switch($status) {
            case 'Approved':
            case 'Rejected':
                //update status
                $record->status = $status;
                //save
                $record->save();

                //change alert
                $alert = "success";
                //change message
                $message = 'Event '.strtolower($status).' successfully.';
                break;
        }

        return redirect()->route($route, ['type' => 'myevent'])->with($alert, $message);
    }


    public function destroyvolunteer(Volunteer $volunteer) {
        //check if admin
        if($this->isAdmin() == false || auth()->user()->id != $volunteer->user_id) {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }

        // delete
        try {
            $volunteer->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('event.volunteer', ['type' => 'myevent'])->with('success', 'Volunteer deleted successfully.');
    }

    //view volunteer
    public function editvolunteer(string $id) {
        //get record
        $record = Volunteer::with('event.category')->find($id);

        //status
        $status = ['Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        return View::make('event.editvolunteer', compact('record', 'status'));
    }

    //update volunteer
    public function updatevolunteer(Volunteer $volunteer, Request $request) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
                'after_or_equal' => 'Exceed date range',
                'before_or_equal' => 'Exceed date range'
            ];

            //rules
            $rules = [
                'name' => 'required|string|max:255',
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'min:10',
                    'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
                ],
                'email' => 'required|email|max:255',
                'skill' => 'required|string',
                'interest' => 'required|string',
                'start_date' => 'required|date|after_or_equal:'.$volunteer->event->start_date,
                'end_date' => 'required|date|before_or_equal:'.$volunteer->event->end_date
            ];

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        $volunteer->name = $request->name;
        $volunteer->phone = $request->phone;
        $volunteer->email = $request->email;
        $volunteer->skill = $request->skill;
        $volunteer->interest = $request->interest;
        $volunteer->start_date = $request->start_date;
        $volunteer->end_date = $request->end_date;
        if($request->has('status')) {
            $volunteer->status = $request->status;
        }

        //save
        $volunteer->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'volunteer', 'status' => 'success', 'message' => 'Volunteer updated successfully'])], 200);
    }

    //add completion form
    public function addcompletion(Volunteer $volunteer) {
        //get record
        $record = $volunteer;

        return view('event/addcompletion', ['record' => $record]);
    }

    //add completion form
    public function storecompletion(Volunteer $volunteer, Request $request) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
                'after_or_equal' => 'Exceed date range',
                'before_or_equal' => 'Exceed date range'
            ];

            //rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'role' => 'required|string',
                'skill' => 'required|string',
                'task' => 'required|string',
                'achievement' => 'required|string',
                'hour' => 'required|numeric|min:0',
                'attachment.*' => 'max:2048',
            ];

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        $completion = new CompletionForm();
        $completion->volunteer_id = $volunteer->id;
        $completion->name = $request->name;
        $completion->email = $request->email;
        $completion->role = $request->role;
        $completion->skill = $request->skill;
        $completion->task = $request->task;
        $completion->achievement = $request->achievement;
        $completion->hour = $request->hour;
        $completion->status = "Pending";

        $completion->user_id = auth()->user()->id;

        //attachment
        if($request->hasFile('attachment')) {
            $picture = $request->file('attachment');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/completion_attachment', $fileName);

            // Update the picture with the generated filename

            $completion->path = $fileName;
        }

        //save
        $completion->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'volunteer', 'status' => 'success', 'message' => 'Volunteer updated successfully'])], 200);
    }

    //edit completion form
    public function editcompletion(CompletionForm $completionform) {
        //get record
        $completionform->load('volunteer.event.category');
        $record = $completionform;

        return view('event/editcompletion', ['record' => $record]);
    }

    //update completion form
    public function updatecompletion(CompletionForm $completionform, Request $request) {
        //validate data
        try {
            //custom message
            $customErrorMessages = [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must have at least :min characters.',
                'max_length' => 'The :attribute must not exceed :max characters.',
                'email' => 'The :attribute must be a valid email address.',
                'unique' => 'The :attribute is already in use.',
                'confirmed' => 'The :attribute confirmation does not match.',
                'in' => 'Invalid :attribute value.',
                'image' => 'The :attribute must be an image file.',
                'mimes' => 'The :attribute must be a JPEG or PNG image.',
                'max_size' => 'The :attribute must not be larger than :max kilobytes.',
                'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
                'numeric' => 'The :attribute must be a number.',
                'after_or_equal' => 'Exceed date range',
                'before_or_equal' => 'Exceed date range'
            ];

            //rules
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'role' => 'required|string',
                'skill' => 'required|string',
                'task' => 'required|string',
                'achievement' => 'required|string',
                'hour' => 'required|numeric|min:0',
                'attachment.*' => 'max:2048',
            ];

            //validate
            $request->validate($rules, $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        $completionform->name = $request->name;
        $completionform->email = $request->email;
        $completionform->role = $request->role;
        $completionform->skill = $request->skill;
        $completionform->task = $request->task;
        $completionform->achievement = $request->achievement;
        $completionform->hour = $request->hour;
        $completionform->status = "Pending";

        //attachment
        if($request->hasFile('attachment')) {
            $picture = $request->file('attachment');
            $extension = $picture->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id().'_'.time().'.'.$extension;

            // Store the file in the public storage and use the generated filename
            $picture->storeAs('public/completion_attachment', $fileName);

            // Update the picture with the generated filename

            $completionform->path = $fileName;
        }

        //save
        $completionform->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'volunteer', 'status' => 'success', 'message' => 'Volunteer updated successfully'])], 200);
    }

    //delete completion form
    public function destroycompletionform(CompletionForm $completionform) {
        //check if admin
        if($this->isAdmin() == false || $completionform->status != 'Pending') {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }

        // delete
        try {
            $completionform->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('event.volunteer', ['type' => 'myevent'])->with('success', 'Completion form deleted successfully.');
    }

    //view completion form
    public function viewcompletion(CompletionForm $completionform) {
        //get record
        $completionform->load('volunteer.event.category');
        $record = $completionform;

        return view('event/viewcompletion', ['record' => $record]);
    }

    public function respondcompletion(CompletionForm $completionform, string $status) {
        //check if admin
        if($this->isAdmin() == false) {
            return redirect()->route('event.volunteer', ['type' => 'myevent'])->with('error', 'No Permission');
        }

        //initial if wrong parameter
        $route = "event.volunteer";
        $alert = "error";
        $message = "Invalid Parameter";

        switch($status) {
            case 'Approved':
            case 'Rejected':
                //update status
                $completionform->status = $status;
                //save
                $completionform->update();

                //change alert
                $alert = "success";
                //change message
                $message = 'Completion form '.strtolower($status).' successfully.';
                break;
        }

        return redirect()->route($route, ['type' => 'completionform'])->with($alert, $message);
    }

    //view cert
    public function cert(CompletionForm $completionform) {
        //get record
        $completionform->load('volunteer.event.category');
        $record = $completionform;

        return view('event/cert', ['record' => $record]);
    }

    //volunteer report page
    public function reportvolunteer(Request $request) {
        // per page
        $perPage = 10;

        // start a query
        $query = Event::query();

        if($this->isAdmin() == false) {
            $query->where('user_id', auth()->user()->id);
        }

        // Search event name
        if($request->has('search')) {
            $query->where('event_name', 'like', '%'.$request->input('search').'%');
        }

        // Search event status
        if($request->has('status') && $request->input('status') != "All") {
            $query->where('event_status', 'like', $request->input('status'));
        }

        $total = $query->sum('target_goal');

        // paginate
        $records = $query->with('category')->orderBy('created_at', 'desc')->paginate($perPage);

        // Status option
        $status = ['All' => 'All', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Pending' => 'Pending'];

        // return view with data
        return view('event/reportvolunteer', ['records' => $records, 'status' => $status, 'total' => $total]);
    }

    //volunteer report
    public function reportdetailvolunteer(string $id) {
        //get record with sum of donation, donation count and all donation record
        $record = Event::with([
            'volunteer' => function ($query) {
                $query->orderByDesc('created_at');
            }
        ])->withCount('volunteer')->find($id);

        //take 10 days latest
        $enddate = date("Y-m-d");
        if($record->end_date < now()) {
            $enddate = $record->end_date;
        }

        $endDateCarbon = Carbon::parse($enddate);

        $latestDates = $totalcount = [];
        $latestDates[] = $enddate;

        for($i = 0; $i < 9; $i++) {
            $latestDates[] = $endDateCarbon->subDay()->toDateString();
        }

        $latestDates = array_reverse($latestDates);

        //find each total per day
        foreach($latestDates as $key => $value) {
            $count = Volunteer::where('event_id', $id)->where('created_at', '>=', "{$value} 00:00:00")->where('created_at', '<=', "{$value} 23:59:59")->count();
            $totalcount[] = $count;
        }

        return View::make('event.reportdetailvolunteer', compact('record', 'latestDates', 'totalcount'));
    }
}
