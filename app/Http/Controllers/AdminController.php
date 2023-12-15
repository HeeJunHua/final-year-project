<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EventRedistribution;
use App\Models\FoodDonation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin_dashboard');
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
        return view('admin_user_view', ['users' => $users]);
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

        try {
            $user->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        // Redirect back with success message
        return redirect()->back()->with('success', 'User deleted successfully');
    }



    public function foodDonationList(){
        $foodDonation = FoodDonation::where('food_donation_status', '=', 'pending')->get();
        return view('admin_food_donation_view', ['foodDonation' => $foodDonation]);
    }

    public function updateFoodDonationStatus(Request $request, $id)
    {
        $foodDonation = FoodDonation::find($id);
        
        if (!$foodDonation) {
            return redirect()->back()->with('error', 'Food donation not found.');
        }

        if ($request->action == 'accept') {
            $foodDonation->food_donation_status = 'accepted';
        } elseif ($request->action == 'decline') {
            $foodDonation->food_donation_status = 'declined';
        }

        $foodDonation->save();

        return redirect()->back()->with('success', 'Food donation status updated successfully.');
    }
    
    
    public function eventRedistributionList()
    {
        $eventRedistribution = EventRedistribution::where('status', '=', 'pending')->get();
        return view('admin_event_redistribution_view', ['eventRedistribution' => $eventRedistribution]);
    }
    
    public function updateEventRedistributionStatus(Request $request, $id)
    {
        $eventRedistribution = EventRedistribution::findOrFail($id);
    
        // Validate the request if needed
    
        if ($request->has('action')) {
            $action = $request->input('action');
    
            // Update the status based on the action
            if ($action === 'approve') {
                $eventRedistribution->status = 'approved';
            } elseif ($action === 'decline') {
                $eventRedistribution->status = 'rejected';
            }
    
            // Save the changes
            $eventRedistribution->save();
        }
    
        // Redirect back to the event redistribution list
        return redirect()->route('admin.eventRedistributionList');
    }

}
