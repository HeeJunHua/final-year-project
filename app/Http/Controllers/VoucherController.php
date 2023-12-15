<?php

namespace App\Http\Controllers;

use App\Models\Vouchers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //check admin
    private function isAdmin()
    {
        if (auth()->user()->user_role != "admin") {
            return redirect()->route('user.dashboard')->with('error', 'No Permission');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //check if is admin
        $this->isAdmin();
        // per page
        $perPage = 10;

        // start a query
        $query = Vouchers::query();

        // Search voucher name
        if ($request->has('search')) {
            $query->where('voucher_code', 'like', '%' . $request->input('search') . '%');
        }

        // Search voucher status
        if ($request->has('status') && $request->input('status') != "All") {
            $query->where('voucher_status', 'like', $request->input('status'));
        }

        // paginate
        $records = $query->paginate($perPage);

        // Status option
        $status = ['All' => 'All', 'Ongoing' => 'Ongoing', 'Pass' => 'Pass', 'Clear' => 'Clear'];

        // return view with data
        return view('voucher/index', ['records' => $records, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //check if is admin
        $this->isAdmin();

        return View::make('voucher.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //check if is admin
        $this->isAdmin();

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

            //validate
            $request->validate([
                'voucher_code' => 'required|string|max:255',
                'voucher_name' => 'required|string|max:255',
                'voucher_description' => 'required|string',
                'voucher_point_value' => 'required|numeric|min:1',
                'voucher_quantity' => 'required|numeric|min:1',
                'voucher_expiry_date' => 'required|date',
            ], $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // new record
        $record = new Vouchers();

        //update field
        $record->voucher_code = $request->input('voucher_code');
        $record->voucher_name = $request->input('voucher_name');
        $record->voucher_description = $request->input('voucher_description');
        $record->voucher_point_value = $request->input('voucher_point_value');
        $record->voucher_quantity = $request->input('voucher_quantity');
        $record->voucher_expiry_date = $request->input('voucher_expiry_date');
        $record->voucher_status = "Ongoing";

        //save
        $record->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'voucher.index', 'status' => 'success', 'message' => 'Voucher created successfully'])], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //check if is admin
        $this->isAdmin();

        //get record
        $record = Vouchers::find($id);

        return View::make('voucher.view', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //check if is admin
        $this->isAdmin();

        //get record
        $record = Vouchers::find($id);

        return View::make('voucher.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //check if is admin
        $this->isAdmin();

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

            //validate
            $request->validate([
                'voucher_code' => 'required|string|max:255',
                'voucher_name' => 'required|string|max:255',
                'voucher_description' => 'required|string',
                'voucher_point_value' => 'required|numeric|min:1',
                'voucher_quantity' => 'required|numeric|min:1',
                'voucher_expiry_date' => 'required|date',
            ], $customErrorMessages);
        } catch (ValidationException $exception) {
            //if validate error, return json, http error 422 code
            return response()->json(['errors' => $exception->errors()], 422);
        }

        // Find the record
        $record = Vouchers::find($id);

        //update field
        $record->voucher_code = $request->input('voucher_code');
        $record->voucher_name = $request->input('voucher_name');
        $record->voucher_description = $request->input('voucher_description');
        $record->voucher_point_value = $request->input('voucher_point_value');
        $record->voucher_quantity = $request->input('voucher_quantity');
        $record->voucher_expiry_date = $request->input('voucher_expiry_date');

        //save
        $record->save();

        //return url for js to redirect, redirect to global function = user.redirect
        return response()->json(['route' => route('user.redirect', ['route' => 'voucher.index', 'status' => 'success', 'message' => 'Voucher updated successfully'])], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vouchers $voucher)
    {
        //check if is admin
        $this->isAdmin();

        // delete
        try {
            $voucher->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher deleted successfully.');
    }

    public function report(Request $request)
    {
        //check if is admin
        $this->isAdmin();
        
        // per page
        $perPage = 30;

        // paginate
        $records = Vouchers::withCount('redemptions')->paginate($perPage);

        // return view with data
        return View::make('voucher/report', compact('records'));
    }
}
