<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventRedistribution;
use App\Models\FoodDonation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRedistributionApproved;
use App\Mail\EventRedistributionDeclined;
use App\Mail\FoodDonationAccepted;
use App\Mail\FoodDonationDeclined;

class AdminController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users(Request $request)
    {
        // Start with an empty query
        $query = User::where('user_role', '!=', 'admin');

        // Search by username, first name, last name, and email
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sort by criteria
        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $query->orderBy($sortField);
        }

        // Fetch users based on the query
        $users = $query->get();

        // Pass the users data to the view
        return view('admin/admin_user_view', ['users' => $users]);
    }

    public function edit(Request $request)
    {
        $userId = $request->input('id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('edit.user')->with('error', 'User not found');
        }

        $customErrorMessages = [
            'required' => 'The :attribute field is required.',
            'min' => 'The :attribute must have at least :min characters.',
            'max' => 'The :attribute must not exceed :max characters.',
            'email' => 'The :attribute must be a valid email address.',
            'unique' => 'The :attribute is already in use.',
            'confirmed' => 'The :attribute confirmation does not match.',
            'in' => 'Invalid :attribute value.',
            'image' => 'The :attribute must be an image file.',
            'mimes' => 'The :attribute must be a JPEG or PNG image.',
            'max' => 'The :attribute must not be larger than :max kilobytes.',
            'regex' => 'Invalid contact number format. It should match the pattern +1234567890.',
        ];


        // Validate the form data with custom error messages
        $request->validate([
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'password' => 'required|min:8|confirmed',
            'contact_number' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
            ],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed',
            'user_role' => 'nullable|in:user,admin',
            'user_photo' => 'image|mimes:jpeg,jpg,png|max:2048',
        ], $customErrorMessages);

        // Handle profile photo upload (if provided)
        if ($request->hasFile('user_photo')) {
            $userPhoto = $request->file('user_photo');
            $extension = $userPhoto->getClientOriginalExtension();

            // Generate a unique filename for the image, e.g., user_id_timestamp.jpg
            $fileName = auth()->id() . '_' . time() . '.' . $extension;

            // Store the file in the public storage and use the generated filename
            $userPhoto->storeAs('public/profile_photos', $fileName);


            // Update the user's user_photo with the generated filename
            $user->user_photo = $fileName;
        }

        // Update the user's data
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->username = $request->first_name . ' ' . $request->last_name;

        // Save the user
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'User details updated successfully');
    }

    public function delete(Request $request)
    {
        // Find the user with the given ID and delete
        $userId = $request->input('id');
        $user = User::find($userId);
        $user->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'User deleted successfully');
    }



    public function foodDonationList(Request $request)
    {
        $search = $request->input('search');

        $foodDonations = FoodDonation::with(['foodItems', 'user'])
            ->where('food_donation_status', 'pending')
            ->when($search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    // Conditions for the related User model
                    $subquery->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('username', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });

                    // Condition for the food_item_name column in the FoodItem model
                    $subquery->orWhereHas('foodItems', function ($foodItemQuery) use ($search) {
                        $foodItemQuery->where('food_item_name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->get();

        $report = FoodDonation::all();

        return view('admin.admin_food_donation_view', compact('foodDonations', 'report'));
    }


    public function updateFoodDonationStatus(Request $request, $id)
    {
        $foodDonation = FoodDonation::find($id);

        if (!$foodDonation) {
            return redirect()->back()->with('error', 'Food donation not found.');
        }

            $user = $foodDonation->user;
        if ($request->action == 'accept') {
            $title = "Food Donation Accepted";
            $content = "Your food donation on date " . $foodDonation->food_donation_date .  " has been accepted";
            $foodDonation->food_donation_status = 'approved';

            Mail::to($user->email)->send(new FoodDonationAccepted($foodDonation));
        } elseif ($request->action == 'decline') {
            $title = "Food Donation Declined";
            $content = "Your food donation on date " . $foodDonation->food_donation_date .  " has been declined";
            $foodDonation->food_donation_status = 'rejected';

            Mail::to($user->email)->send(new FoodDonationDeclined($foodDonation));
        }

        Notification::createNotification($user, $title, $content);
        $foodDonation->save();

        return redirect()->back()->with('success', 'Food donation status updated successfully.');
    }


    public function eventRedistributionList(Request $request)
    {
        $query = EventRedistribution::where('status', 'pending');
    
        $search = $request->input('search');
    
        if ($search) {
            // Add conditions for searching, for example, searching by event_name
            $query->where('event_name', 'like', '%' . $search . '%');
        }
    
        $eventRedistribution = $query->get();
    
        return view('admin.admin_event_redistribution_view', ['eventRedistribution' => $eventRedistribution]);
    }

    public function getRedistributionReport(Request $request)
    {
        $redistributionId = $request->input('redistributionId');
        $redistribution = EventRedistribution::with('foodItems')->find($redistributionId);

        return view('admin.redistribution_report_modal_content', ['redistribution' => $redistribution]);
    }

    public function showAllRedistributionReports()
    {
        $allRedistributions = EventRedistribution::with(['foodItems', 'user'])->orderBy('user_id')->get();
        return view('admin.all_redistributions_report', ['allRedistributions' => $allRedistributions]);
    }


    public function updateEventRedistributionStatus(Request $request, $id)
    {
        $eventRedistribution = EventRedistribution::findOrFail($id);

        // Validate the request if needed
        $user = $eventRedistribution->user;
        if ($request->has('action')) {
            $action = $request->input('action');

            // Update the status based on the action
            if ($action === 'approve') {
                $title = "Event Redistribution Accepted";
                $content = "Your event redistribution on date " . $eventRedistribution->event_date .  " has been accepted";
                $eventRedistribution->status = 'approved';

                Mail::to($user->email)->send(new EventRedistributionApproved($eventRedistribution));

            } elseif ($action === 'decline') {
                $title = "Event Redistribution Declined";
                $content = "Your event redistribution on date " . $eventRedistribution->event_date .  " has been declined";
                $eventRedistribution->status = 'rejected';

                Mail::to($user->email)->send(new EventRedistributionDeclined($eventRedistribution));
            }
            Notification::createNotification($user, $title, $content);
            // Save the changes
            $eventRedistribution->save();
        }

        // Redirect back to the event redistribution list
        return redirect()->route('admin.eventRedistributionList')->with('success', 'Successfully updated the pending submission.');
    }




}
