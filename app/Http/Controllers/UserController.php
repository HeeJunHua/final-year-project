<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Event;
use App\Models\Redemption;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Mail\ProductExpiryMail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['redirectToPage', 'home', 'announcementDetail', 'showRegistrationForm', 'register', 'showLoginForm', 'login', 'logout']]);
    }

    public function showRegistrationForm()
    {
        return view('auth/account/register_page');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|confirmed',
            'contact_number' => [
                'required',
                'string',
                'max:20',
                'min:10',
                'regex:/^\+(?:\d{1,4})?(?:[ -]?\d{2,4}){1,5}$/',
            ],
        ], [
            'first_name.min' => 'First name must have at least 2 characters.',
            'first_name.max' => 'First name must not exceed 50 characters.',
            'last_name.min' => 'Last name must have at least 2 characters.',
            'last_name.max' => 'Last name must not exceed 50 characters.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Passwords do not match.',
            'contact_number.max' => 'Contact number must not exceed 20 characters.',
            'contact_number.regex' => 'Invalid contact number format.',
        ]);

        $defaultUserRole = 'user';
        $defaultProfileIcon = 'default_profile_icon.png';

        $username = $request->first_name . ' ' . $request->last_name;

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->user_role = $defaultUserRole;
        $user->username = $username;
        $user->user_photo = $defaultProfileIcon;
        $user->password = Hash::make($request->password);

        // Generate and set the verification token
        $user->verification_token = Str::random(32);

        $user->save();


        // Generate the verification URL (you need to implement this logic)
        $verificationUrl = $this->generateVerificationUrl($user);

        // Send a welcome email to the user with the verification link
        Mail::to($user->email)->send(new WelcomeEmail($verificationUrl));

        return redirect()->route('login.form')->with('success', 'Registration successful');
    }

    private function generateVerificationUrl($user)
    {
        return route('verification.verify', ['token' => $user->verification_token]);
    }


    public function showLoginForm()
    {
        $user = Auth::user();

        if ($user) {
            return redirect()->route('fundraise_home_page')->with('error', 'You are already logged in... Please log out to switch account');
        }
        return view('auth/account/login_page '); // Return the login form view
    }

    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // Check if "Remember Me" is selected

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed, redirect to the dashboard or desired page
            return redirect('/')->with('success', 'Login successful');
        } else {
            // Authentication failed, redirect back with an error message
            return redirect()->back()->withErrors(['login' => 'Invalid login credentials'])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('fundraise_home_page')->with('success', 'Logged out successfully');
    }

    public function update(Request $request)
    {
        // check if this is from dashboard
        $is_dashboard = 0;
        if (isset($request->is_dashboard) && $request->is_dashboard == 1) {
            $is_dashboard = 1;
        }

        $user = Auth::user();

        if (!$user) {
            // is dashboard
            if ($is_dashboard == 1) {
                return redirect()->route('user.dashboard')->with('error', 'User not found');
            }
            return redirect()->route('edit.user')->with('error', 'User not found');
        }

        // Define custom error messages for each validation rule
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

        /** @var \App\Models\User $user **/
        // Save the user
        $user->save();

        // is dashboard
        if ($is_dashboard == 1) {
            return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully');
        }
        return redirect()->route('edit.user')->with('success', 'Profile updated successfully');
    }

    //dashboard for all
    public function dashboard()
    {
        //initial value
        $donation = $fund = $point = 0;

        //donation
        $donation = Donation::where('user_id', auth()->user()->id)->sum('donation_amount');

        //event
        $fund = Event::where(['user_id' => auth()->user()->id, 'event_status' => 'Approved'])->sum('target_goal');

        //donation
        $point_cr = Donation::where('user_id', auth()->user()->id)->sum('points_earned');
        $point_dr = Redemption::where('user_id', auth()->user()->id)->sum('redeemed_points');
        $point = $point_cr - $point_dr;

        return view('dashboard/dashboard', compact('donation', 'fund', 'point', 'point_cr', 'point_dr'));
    }

    //profile page
    public function profile()
    {
        $user = auth()->user(); // Get the currently authenticated user
        return view('dashboard/profile', compact('user'));
    }

    //global redirect function
    public function redirectToPage($route, $status, $message)
    {
        switch ($route) {
            case "volunteer":
                //redirect to function with alert and message
                return redirect()->route('event.volunteer', ['type' => 'myregister'])->with($status, $message);
            default:
                //redirect to function with alert and message
                return redirect()->route($route)->with($status, $message);
        }
    }

    //landing page
    public function home()
    {
        $user = Auth::user();
        $userNotifications = Notification::where('user_id', auth()->id())
            ->where('notification_read', false)
            ->get();


        // This is not a good idea to put but i will just put here as incomplete function
        // It should be used in a service or cron so this function is bad for future use

        if ($user) {
            // Check if the user has an inventory
            if ($user->inventory) {
                // Check if any product in the inventory is near expiring
                $nearExpiringProducts = $user->inventory->products()
                    ->where('product_status', 'good')
                    ->where('product_expiry_date', '<=', now()->addDays(7))
                    ->where('product_expiry_date', '>', now())
                    ->get();

                $expiringProducts = $user->inventory->products()
                    ->whereIn('product_status', ['good', 'near_expiring'])
                    ->where('product_expiry_date', '<', now())
                    ->get();

                // If there are near expiring products, create a notification and send an email
                if ($nearExpiringProducts->isNotEmpty()) {

                    // Loop through each near-expiring product and send a notification
                    foreach ($nearExpiringProducts as $product) {
                        $title = "Near Expired Item Found";
                        $content = "Your product" . $product->product_name . " is near to expiration.";
                        // Create a notification for each product
                        Notification::createNotification($user, $title, $content);

                        // Send a notification to the user for each product
                        Mail::to($user->email)->send(new ProductExpiryMail($user, $product));
                        $product->update(['product_status' => 'near_expiry']);
                    }
                }
                if ($expiringProducts->isNotEmpty()) {

                    // Loop through each near-expiring product and send a notification
                    foreach ($expiringProducts as $product) {
                        $title = "Expired Item Found";
                        $content = "Your product" . $product->product_name . " is expired.";
                        // Create a notification for each product
                        Notification::createNotification($user, $title, $content);

                        // Send a notification to the user for each product
                        Mail::to($user->email)->send(new ProductExpiryMail($user, $product));
                        $product->update(['product_status' => 'expired']);
                    }
                }
            }
        }



        //get event
        $events = Event::withSum('donations', 'donation_amount')
            ->where('event_status', 'Approved') //approved
            ->where('start_date', '<=', now()) //not expire
            ->where('end_date', '>=', now()) //not expire
            ->whereRaw('(select ifnull(sum(donation_amount),0) from donations where event_id = events.id) < events.target_goal') //is not fully donate
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        //get announcement
        $announcements = Announcement::with(['event', 'event.donations'])
            ->whereHas('event', function ($query) {
                $query->where('start_date', '<=', now())->where('end_date', '>=', now()) //not expire
                    ->where(DB::raw('(select ifnull(sum(donation_amount),0) from donations where event_id = events.id)'), '<', DB::raw('events.target_goal')); //is not fully donate
            })
            ->get();

        //get category
        $category = Category::orderBy('created_at', 'desc')->take(6)->get();

        return view('fundraise_home_page', compact('events', 'announcements', 'category', 'userNotifications'));
    }

    public function announcementDetail(string $id)
    {
        //get record
        $record = Announcement::with('event')->find($id);

        return View::make('announcementDetail', compact('record'));
    }
}
