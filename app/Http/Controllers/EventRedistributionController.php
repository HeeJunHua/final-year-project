<?php

namespace App\Http\Controllers;

use App\Models\EventRedistribution;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRedistributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $events = $user->eventRedistributions()->orderBy('created_at', 'desc')->get();

        return view('redistribution_page', compact('events'));
    }

    public function create()
    {
        return view('event_redistribution_creation');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'event_name' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'food_amount_unit' => 'required|in:quantity,kg',
            'food_amount' => 'required|numeric|min:2',
            'people_quantity' => 'required|integer|min:1',
            'leftovers_description' => 'nullable|string',
        ], [
            'event_name.required' => 'Please enter the event name.',
            'event_date.required' => 'Please select the event date.',
            'location.required' => 'Please enter the event location.',
            'food_amount_unit.required' => 'Please select the unit for food amount.',
            'food_amount.required' => 'Please enter the food amount.',
            'food_amount.numeric' => 'The food amount must be a number.',
            'food_amount.min' => 'The food amount must be at least 2.',
            'people_quantity.required' => 'Please enter the number of people.',
            'people_quantity.integer' => 'The number of people must be a whole number.',
            'people_quantity.min' => 'The number of people must be at least 1.',
        ]);

        $event = EventRedistribution::create([
            'user_id' => $user->id,
            'event_name' => $request->input('event_name'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
            'food_amount_unit' => $request->input('food_amount_unit'),
            'food_amount' => $request->input('food_amount'),
            'people_quantity' => $request->input('people_quantity'),
            'leftovers_description' => $request->input('leftovers_description'),
        ]);

        return redirect()->route('redistribution.page', $event->id)->with('success', 'Event created successfully. Review and submit.');
    }

    public function edit(EventRedistribution $event)
    {

        return view('event_redistribution_edit', compact('event'));
    }

    public function update(Request $request, EventRedistribution $event)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'food_amount_unit' => 'required|in:quantity,kg',
            'food_amount' => 'required|numeric|min:2',
            'people_quantity' => 'required|integer|min:1',
            'leftovers_description' => 'nullable|string',
        ], [
            'event_name.required' => 'Please enter the event name.',
            'event_date.required' => 'Please select the event date.',
            'location.required' => 'Please enter the event location.',
            'food_amount_unit.required' => 'Please select the unit for food amount.',
            'food_amount.required' => 'Please enter the food amount.',
            'food_amount.numeric' => 'The food amount must be a number.',
            'food_amount.min' => 'The food amount must be at least 2.',
            'people_quantity.required' => 'Please enter the number of people.',
            'people_quantity.integer' => 'The number of people must be a whole number.',
            'people_quantity.min' => 'The number of people must be at least 1.',
        ]);
    
        $event->update($validatedData);
    
        return redirect()->route('redistribution.page', $event->id)->with('success', 'Event updated successfully. Review and submit.');
    }
    
    public function destroy(EventRedistribution $event)
    {
        try {
            $event->delete();
        } catch (QueryException $exception) {
            return redirect()->back()->with('error', 'Delete fail. There is data link with this record.');
        }

        return redirect()->route('redistribution.page')->with('success', 'Event deleted successfully.');
    }
}
