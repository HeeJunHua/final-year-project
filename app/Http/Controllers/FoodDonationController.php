<?php

namespace App\Http\Controllers;

use App\Models\FoodItems;
use App\Models\FoodDonation;
use App\Models\EventRedistribution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Models\Point;

class FoodDonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function foodDonationHistory(Request $request, $status = 'all')
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
    
        $query = $user->foodDonations()->with('foodItems');
    
        // Apply search filter for food_item_name
        $search = $request->input('search');
        if ($search) {
            $query->whereHas('foodItems', function ($foodItemsQuery) use ($search) {
                $foodItemsQuery->where('food_item_name', 'like', '%' . $search . '%');
            });
        }
    
        // Apply status filter
        if ($status != 'all') {
            $query->where('food_donation_status', $status);
        }
    
        $donations = $query->get();
        
        
        return view('food.food_donation_list', compact('donations', 'status'));
    }
    

    public function showFoodDonationForm()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];
        $foodItems = $user->foodItems()->notDonated()->get();

        foreach ($foodItems as $food) {
            if ($food->has_expiry_date && $food->food_item_expiry_date < now()->addDays(2)) {
                $foodItemUser = $food->user;
                $title = "Food Item Expired";
                $content = "Your " . $food->food_item_name . " has expired and removed from food item donation list.";
                Notification::createNotification($foodItemUser, $title, $content);

                $food->delete();

            }
        }
        return view('food.food_donation_page', compact('foodItems', 'categories'));
    }


    public function store(Request $request)
    {
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];

        // Validate the request data
        $request->validate([
            'food_item_name' => 'required|string|max:255',
            'food_item_category' => ['required', 'string', 'max:255', Rule::in($categories)],
            'food_item_quantity' => 'required|integer|min:1',
            'has_expiry_date' => 'required|boolean', // Ensure the radio button is selected
            'food_item_expiry_date' => $request->has_expiry_date ? 'required|date|after_or_equal:' . now()->addDays(3)->toDateString() : '', 
        ], [
            'has_expiry_date.required' => 'Please choose whether the food item has an expiry date or not.',
            'food_item_expiry_date.required' => 'The expiry date is required when "Yes" is selected.',
            'food_item_category.in' => 'Please select a valid food category.',
        ]);

        /** @var \App\Models\User $user **/
        // Get the authenticated user
        $user = auth()->user();

        // Check if the request contains an event ID
        $eventId = $request->input('event_id');


        // Create a new food item associated with the user
        $foodItemData = $request->only(['food_item_name', 'food_item_category', 'food_item_quantity']);
        $foodItemData['has_expiry_date'] = $request->has_expiry_date;
        $foodItemData['food_item_expiry_date'] = $request->has_expiry_date ? $request->input('food_item_expiry_date') : null;
        // dd($foodItemData);

        if ($eventId) {
            // If an event ID is present, associate the food item with the event
            $event = EventRedistribution::findOrFail($eventId);
            $foodItemData['user_id'] = auth()->id();
            $event->foodItems()->create($foodItemData);
            return redirect()->route('redistribution.page')->with('success', 'Successfully inserted food items');
        }

        $user->foodItems()->create($foodItemData);

        return redirect()->route('food.donation')->with('success', 'Food item created successfully');
    }


    public function update(Request $request, FoodItems $foodItem)
    {
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];

        $validator = Validator::make($request->all(), [
            'food_item_name' => 'required|string|max:255',
            'food_item_category' => ['required', 'string', Rule::in($categories)],
            'food_item_quantity' => 'required|integer|min:1',
            'has_expiry_date2' => 'required|boolean',
            'food_item_expiry_date' => $request->has_expiry_date2 ? 'required|date|after_or_equal:' . now()->addDays(3)->toDateString() : '',
        ], [
            'has_expiry_date2.required' => 'Please choose whether the food item has an expiry date or not.',
            'food_item_expiry_date.required' => 'The expiry date is required when "Yes" is selected.',
            'food_item_category.in' => 'Please select a valid food category.',
        ]);

        // Check if the request contains an event ID
        $eventId = $request->input('event_id');

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());

            if ($eventId) {
                // Redirect back to the edit form with errors and input
                return redirect()->route('fooditems.edit', ['itemId' => $foodItem->id])
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', $errorMessages);
            }

            return redirect()->route('food.donation')
                ->with('error', $errorMessages);
        }

        // Update the food item
        $foodItem->update([
            'food_item_name' => $request->input('food_item_name'),
            'food_item_category' => $request->input('food_item_category'),
            'food_item_quantity' => $request->input('food_item_quantity'),
            'has_expiry_date' => $request->has_expiry_date2,
            'food_item_expiry_date' => $request->has_expiry_date2 ? $request->food_item_expiry_date : null,
        ]);


        if ($eventId) {
            // Redirect back to the edit form with errors and input
            return redirect()->route('redistribution.page')->with('success', 'Successfully updated food item');
        }
        return redirect()->route('food.donation')->with('success', 'Food item updated successfully');
    }


    public function destroy(FoodItems $food_item)
    {
        $food_item->delete();
        return redirect()->route('food.donation')->with('success', 'Food item deleted successfully');
    }

    public function showAddressForm(Request $request)
    {
        // Check if the CSRF token is valid
        if ($request->session()->token() !== $request->input('_token')) {
            // Token is not valid, return an error response
            return redirect()->route('food.donation')->with('error', 'Invalid Token Session');
        }
        $foodBanks = DB::table('food_banks')->select('id', 'name', 'latitude', 'longitude')->get();

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        // Get authenticated user's undonated food items
        $userFoodItems = $user->foodItems()->notDonated()->get();

        // Check if user has undonated food items to donate
        if ($userFoodItems->isNotEmpty()) {
            return view('food.food_donation_confirmation', compact('foodBanks'));
        }
        return redirect()->route('food.donation')->with('error', 'Empty food items found...');
    }



    // Function to allow all food items to be submitted
    public function makeDonation(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'location' => 'required|string|max:255',
            'donation_date_time' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    // Custom validation rule to check if donation date and time are ahead of current time
                    $donationDateTime = strtotime($value);
                    $currentDateTime = now()->timestamp;
                    
                    // Check if the donation date and time are at least 2 days ahead
                    $minDateTime = strtotime('+2 days', $currentDateTime);
        
                    if ($donationDateTime <= $minDateTime) {
                        $fail('The donation date and time must be at least 2 days ahead from the current date and time.');
                    }
                },
            ],
        ], [
            'location.required' => 'The location field is required.',
            'location.string' => 'The location must be a string.',
            'location.max' => 'The location may not be greater than :max characters.',
            'donation_date_time.required' => 'The donation date and time field is required.',
            'donation_date_time.date_format' => 'Invalid date and time format.',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
        
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages);
        }

        /** @var \App\Models\User $user **/
        $user = auth()->user();

        // Get authenticated user's undonated food items
        $userFoodItems = $user->foodItems()->notDonated()->get();

        // Check if user has undonated food items to donate
        if ($userFoodItems->isNotEmpty()) {
            $totalQuantity = $userFoodItems->sum('food_item_quantity');
            // Create a single donation record for all undonated food items
            $foodDonation = new FoodDonation();
            $foodDonation->user_id = $user->id;
            $foodDonation->food_donation_date = $request->input('donation_date_time');
            $foodDonation->food_donation_status = 'pending';
            $foodDonation->total_quantity = $totalQuantity;
            $foodDonation->food_bank_id = $request->input('food_bank_id');
            $foodDonation->save(); 

            // Update all undonated food items with the donation ID and associate them with the food donation
            $userFoodItems->each(function ($foodItem) use ($foodDonation) {
                $foodItem->update([
                    'donated' => true,
                    'itemable_id' => $foodDonation->id,
                    'itemable_type' => FoodDonation::class,
                ]);
            });
            $title = "Food Donation Successfully Submmited";
            $content = "Your submission is currently pending on admin approval.";
            Notification::createNotification($user, $title, $content);
        }

        return redirect()->route('food.donation')->with('success', 'Donation successful. Thank you for your generosity!');
    }
    public function completeFoodDonation(Request $request, $id)
    {
        $foodDonation = FoodDonation::findOrFail($id);
        // Check if the event date has passed
        if ($foodDonation->food_donation_date > now()->addDays(1)) {
            // Redirect or handle the case where completion is not allowed before the event date
            return redirect()->route('food.donation.history')->with('error', 'Your are not allowed to mark as completion before donation date');
        }
        // Check if the event redistribution is not already completed
        if (!$foodDonation->completed_at) {
            // Implement logic to mark the event redistribution as completed
            $foodDonation->food_donation_status = 'completed';
            $foodDonation->completed_at = now(); // or use Carbon::now() for customization
            $foodDonation->save();
            $point = new Point();
            //update field
            $point->event_id = null;
            $point->user_id = $foodDonation->user->id;
            $point->donation_id = null;
            $point->redemption_id = null;
            $point->food_donation_id = $foodDonation->id;
            $point->event_redistribution_id = null;
            $point->point = floor($foodDonation->total_quantity / 10);
            $point->transaction_type = "DR";
            //save
            $point->save();
            $user = $foodDonation->user;
            $title = "Food Donation Is Completed";
            $content = "Thank you for participating in the food donation";
            Notification::createNotification($user, $title, $content);
            // You may want to redirect the user to a thank you page or any other appropriate action
            return redirect()->route('food.donation.history')->with('success', 'Thank You For Participating For Food Donation. ' . $point->point . " points will be awarded for your contribution.");
        }

        // If the event is already completed, you can handle this case accordingly
        return redirect()->route('food.donation.history')->with('error', 'Your food donation had already been completed.');
    }
}
