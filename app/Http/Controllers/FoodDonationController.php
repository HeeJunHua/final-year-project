<?php

namespace App\Http\Controllers;

use App\Models\FoodItems;
use App\Models\FoodDonation;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
class FoodDonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function foodDonationHistory()
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        if ($user) {
            $donations = $user->foodDonations()->with('foodItem')->get();
            return view('food_donation_list', compact('donations'));
        }else{
            return redirect()->route('fundraise_home_page')->with('error', 'Please login to continue...');
        }
    }

    public function showFoodDonationForm()
    {
        /** @var \App\Models\User $user **/
        // Get the authenticated user
        $user = Auth::user();

        $foodItems = $user->foodItems()->notDonated()->get();

        return view('food_donation_page', compact('foodItems'));
    }

    public function create()
    {
        return view('food_items_creation');
    }

    public function store(Request $request)
    {
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];
        $request->validate([
            'food_item_name' => 'required|string|max:255',
            'food_item_category' => ['required', 'string', 'max:255', Rule::in($categories)],
            'food_item_quantity' => 'required|integer|min:1',
            'food_item_expiry_date' => 'required|date|after_or_equal:' . now()->addWeek()->toDateString(),
        ]);

        /** @var \App\Models\User $user **/
        // Get the authenticated user
        $user = auth()->user();

        // Create a new food item associated with the user
        $user->foodItems()->create($request->all());

        return redirect()->route('food.donation')->with('success', 'Food item created successfully');
    }


    public function edit(FoodItems $food_item)
    {
        return view('food_items_edit', compact('food_item'));
    }

    public function update(Request $request, FoodItems $food_item)
    {
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];
        $request->validate([
            'food_item_name' => 'required|string|max:255',
            'food_item_category' => ['required', 'string', 'max:255', Rule::in($categories)],
            'food_item_quantity' => 'required|integer|min:1',
            'food_item_expiry_date' => 'required|date|after_or_equal:' . now()->addWeek()->toDateString(), 
        ]);
    
        /** @var \App\Models\User $user **/
        // Get the authenticated user
        $user = auth()->user();

        // Find the specific food item by ID and update it
        $user->foodItems()->where('id', $food_item->id)->update($request->except(['_token', '_method']));


    
        return redirect()->route('food.donation')->with('success', 'Food item updated successfully');
    }

    public function destroy(FoodItems $food_item)
    {
        try {
            $food_item->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('food.donation')->with('success', 'Food item deleted successfully');
    }

    
    public function makeDonation()
    {
        /** @var \App\Models\User $user **/
        // Get authenticated user
        $user = Auth::user();
    
        // Get authenticated user's food items
        $userFoodItems = $user->foodItems;
        // Check if user has food items to donate
        if ($userFoodItems->isNotEmpty()) {
            // Attach user's food items to the donation record
            foreach ($userFoodItems as $foodItem) {
                if($foodItem->donated ==  false){
                    $foodDonation = new FoodDonation();
                    $foodDonation->user_id = $user->id;
                    $foodDonation->food_item_id = $foodItem->id;
                    $foodDonation->food_donation_date = Carbon::now()->toDateTimeString();
                    $foodDonation->food_donation_status = 'pending';
                    $foodDonation->save();
                    
                    // Mark the food item as donated
                    $foodItem->update(['donated' => true]);
                }
            }
        }
        return redirect()->route('food.donation')->with('success', 'Donation successful. Thank you for your generosity!');
    }
}
