<?php

namespace App\Http\Controllers;

use App\Models\EventRedistribution;
use App\Models\FoodItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class EventRedistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function eventRedistributionHistory(Request $request, $status = 'all')
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
    
        $query = $user->eventRedistributions()->with('foodItems'); // Assuming you have a relationship named 'foodItems'
    
        // Apply search filter for food_item_name
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('event_name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('people_quantity', 'like', '%' . $search . '%')
                    ->orWhere('leftovers_description', 'like', '%' . $search . '%')
                    ->orWhereHas('foodItems', function ($foodItemsQuery) use ($search) {
                        $foodItemsQuery->where('food_item_name', 'like', '%' . $search . '%')
                            ->orWhere('food_item_category', 'like', '%' . $search . '%')
                            ->orWhere('food_item_expiry_date', 'like', '%' . $search . '%');
                        // Add additional columns as needed
                    });
            });
        }
        
    
        // Apply status filter
        if ($status != 'all') {
            $query->where('status', $status); // Adjust 'status' to your actual field name
        }
    
        $eventRedistributions = $query->get();
        return view('redistribution.event_redistribution_history', compact('eventRedistributions', 'status'));
    }



    public function index()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
    
        // Get events with incomplete status
        $incompleteEvents = $user->eventRedistributions()->where('status', 'incomplete')->orderBy('created_at', 'desc')->get();
    
        // Get past submitted events with statuses 'declined', 'pending', and 'approved'
        $pastSubmittedEvents = $user->eventRedistributions()
            ->whereIn('status', ['declined', 'pending', 'approved'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Get completed events
        $completedEvents = $user->eventRedistributions()
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('redistribution.redistribution_page', compact('incompleteEvents', 'pastSubmittedEvents', 'completedEvents'));
    }

    public function create()
    {
        return view('redistribution/event_redistribution_creation');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'event_name' => 'required|string|min:3|max:255',
            'event_date' => 'required|date|after:+2 days', 
            'location' => 'required|string|min:5|max:255', 
            'people_quantity' => 'required|integer|min:1',   
            'leftovers_description' => 'nullable|string',
        ], [
            'event_name.required' => 'Please enter the event name.',
            'event_name.min' => 'The event name must be at least :min characters.',
            'event_name.max' => 'The event name may not be greater than :max characters.',
            'event_date.required' => 'Please select the event date.',
            'event_date.after' => 'The event date must be at least 2 days in the future.',
            'location.required' => 'Please enter the event location.',
            'location.min' => 'The location must be at least :min characters.',
            'location.max' => 'The location may not be greater than :max characters.',
            'people_quantity.required' => 'Please enter the number of people.',
            'people_quantity.min' => 'The number of people must be at least :min.',
        ]);
    
        $event = EventRedistribution::create([
            'user_id' => $user->id,
            'event_name' => $request->input('event_name'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
            'people_quantity' => $request->input('people_quantity'),
            'leftovers_description' => $request->input('leftovers_description'),
        ]);

        return redirect()->route('fooditems.create', $event->id)->with('success', 'Event created successfully. Please add food item to proceed.');
    }

    public function edit(EventRedistribution $event)
    {

        return view('redistribution/event_redistribution_edit', compact('event'));
    }

    public function update(Request $request, EventRedistribution $event)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string|min:3|max:255',
            'event_date' => 'required|date|after:+2 days', 
            'location' => 'required|string|min:5|max:255', 
            'people_quantity' => 'required|integer|min:1',   
            'leftovers_description' => 'nullable|string',
        ], [
            'event_name.required' => 'Please enter the event name.',
            'event_name.min' => 'The event name must be at least :min characters.',
            'event_name.max' => 'The event name may not be greater than :max characters.',
            'event_date.required' => 'Please select the event date.',
            'event_date.after' => 'The event date must be at least 2 days in the future.',
            'location.required' => 'Please enter the event location.',
            'location.min' => 'The location must be at least :min characters.',
            'location.max' => 'The location may not be greater than :max characters.',
            'people_quantity.required' => 'Please enter the number of people.',
            'people_quantity.min' => 'The number of people must be at least :min.',
        ]);
    
        $event->update($validatedData);
    
        return redirect()->route('redistribution.page', $event->id)->with('success', 'Event updated successfully. Please add food item to proceed.');
    }
    
    public function destroy(EventRedistribution $event)
    {
        // Delete related food items
        $event->foodItems()->delete();
    
        // Delete the event
        $event->delete();
    
        return redirect()->route('redistribution.page')->with('success', 'Event and related food items deleted successfully.');
    }


    public function submit($eventId)
    {
        // Fetch the event
        $event = EventRedistribution::findOrFail($eventId);
    
        // Update the event status to pending
        $event->update(['status' => 'pending']);
    
        // Update all food items associated with the event to set 'donated' to true
        $event->foodItems->each(function ($foodItem) {
            $foodItem->update(['donated' => true]);
        });

        /** @var \App\Models\User $user **/
        $user = auth()->user();
        $title = "Event Distribution Successfully Submmited";
        $content = "Your submission is currently pending on admin approval.";
        Notification::createNotification($user, $title, $content);
        
        return redirect()->route('redistribution.page')->with('success', 'Event and related food items marked as donated successfully.');
    }

    public function createFoodItems($eventId)
    {
        // Fetch the event
        $event = EventRedistribution::findOrFail($eventId);
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];
        //redirect them to create food item page
        return view('fooditems.create', compact('event','categories'));
    }
    
    public function editFoodItem($itemId)
    {
        $categories = ['vegetables', 'fruits', 'grains', 'proteins', 'dairy', 'snacks', 'beverages', 'canned_goods', 'dry_goods', 'frozen_foods', 'baked_goods', 'sweets'];
    
        // Find the food item by ID
        $foodItem = FoodItems::findOrFail($itemId);

        $event_id = $foodItem->itemable_id;
    
        // Pass the food item and categories to the view
        return view('fooditems.edit', compact('foodItem', 'event_id', 'categories'));
    }

    // Controller method
    public function destroyFoodItem($itemId){
        // Find the food item by ID
        $foodItem = FoodItems::find($itemId);

        // Check if the food item exists
        if (!$foodItem) {
            return redirect()->route('food.donation')->with('error', 'Food item not found');
        }
        // Delete the food item
        $foodItem->delete();

        // Redirect back to the food donation page
        return redirect()->route('redistribution.page')->with('success', 'Food item deleted successfully');
    }

    public function completeEventRedistribution(Request $request, $id)
    {
        $eventRedistribution = EventRedistribution::findOrFail($id);

        // Check if the event date has passed
        if ($eventRedistribution->event_date > now()) {
            // Redirect or handle the case where completion is not allowed before the event date
            return redirect()->route('event.redistribution.history')->with('error', 'Your are not allowed to mark as completion before event date');
        }

        // Check if the event redistribution is not already completed
        if (!$eventRedistribution->completed_at) {
            // Implement logic to mark the event redistribution as completed
            $eventRedistribution->status = 'completed';
            $eventRedistribution->completed_at = now(); // or use Carbon::now() for customization
            $eventRedistribution->save();

            $user = $eventRedistribution->user;
            $title = "Event Distribution Is Completed";
            $content = "Thank you for participating in the event redistribution";
            Notification::createNotification($user, $title, $content);
            // You may want to redirect the user to a thank you page or any other appropriate action
            return redirect()->route('event.redistribution.history')->with('success', 'Thank You For Participating In The Event Redistribution.');
        }

        // If the event is already completed, you can handle this case accordingly
        return redirect()->route('event.redistribution.history')->with('error', 'Your event had already been completed.');
    }
}
