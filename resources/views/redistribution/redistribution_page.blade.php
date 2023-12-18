@extends('layouts.fundraise_layout')

@section('title')
    <title>Event Redistribution Page</title>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .redistributionContainer {
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        .mb-4 a {
            text-decoration: none;
        }

        .mb-4 a:hover {
            text-decoration: underline;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background-color: #007bff;
            color: black;
            font-weight: bold;
            padding: 1rem;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #007bff;
        }

        .btn-danger {
            color: #fff;
        }

        p {
            margin-bottom: 10px;
        }

        .no-events {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #555;
        }

        .redistributionContainer {
            min-height: 500px;
        }

        .event-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-details {
            flex: 1;
            padding-right: 20px;
        }

        .event-details p {
            margin-bottom: 5px;
        }

        .event-actions {
            display: flex;
            align-items: center;
        }

        .event-actions form {
            margin-left: 10px;
            display: flex;
            align-items: center;
        }

        .event-actions form button {
            margin-left: 10px;
        }

        .fa-icon {
            margin-right: 5px;
        }

        .btn-primary[disabled],
        .btn-primary:disabled {
            background-color: #007bff;
            opacity: 0.7;
        }
    </style>
@endsection

@section('content')
    <div class="container redistributionContainer">

        <div class="mb-4 row">
            <div class="col-md-10">
                <h2>Event Redistribution</h2>
            </div>
            <div class="col-md-2">
                <a href="{{ route('events.create') }}" class="btn btn-primary"><i class="fas fa-plus fa-icon"></i>Create New
                    Event</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Welcome to Our Event Redistribution Page</h5>
            </div>
            <div class="card-body">
                <p>Welcome to the Food Event Redistribution page, an essential component of our Fundraising & Food Waste
                    Reduction System.</p>
                <p>This page empowers you to manage and optimize the distribution of surplus food from events,
                    fostering a sustainable and community-driven approach to reduce food waste.</p>
                <p>Together, we can alleviate hunger and build a stronger, more compassionate community.</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Your Events</h3>
            </div>
            <div class="card-body">
                @if ($incompleteEvents->isEmpty() && $pastSubmittedEvents->isEmpty() && $completedEvents->isEmpty())
                    <div class="card mb-3">
                        <div class="text-center m-4">
                            <h4 class="text-center">No events found.</h4>
                        </div>
                    </div>
                @endif
                @forelse($incompleteEvents as $event)
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-sm-12 card-header m-2">
                                <h4>Past Submitted Events</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="card-body">
                                    <h3>Status: {{ ucfirst($event->status) }}</h3>
                                    <p>Event Name : {{ $event->event_name }}</p>
                                    <p>Redistribution Date: {{ $event->event_date }}</p>
                                    <p>Location: {{ $event->location }}</p>
                                    <p>People Quantity: {{ $event->people_quantity }}</p>
                                    <p>Leftovers Description: {{ $event->leftovers_description }}</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="text-end mt-4">
                                    <form action="{{ route('events.edit', $event->id) }}" method="get" class="mb-2 d-inline">
                                        <button type="submit" class="btn btn-warning m-2">
                                            <i class="fas fa-edit fa-icon"></i> Edit Event
                                        </button>
                                    </form>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="post" class="mb-2 d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger m-2">
                                            <i class="fas fa-trash fa-icon"></i> Delete Event
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row g-0 mx-2 my-2">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2">Food Items:</h6>
                                        <form action="{{ route('fooditems.create', ['event_id' => $event->id]) }}" method="get" class="mb-2">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-plus fa-icon"></i></button>
                                        </form>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Has Expiry Date?</th>
                                                <th>Expiry Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($event->foodItems->isNotEmpty())
                                                @foreach ($event->foodItems as $foodItem)
                                                    <tr>
                                                        <td>{{ $foodItem->food_item_name }}</td>
                                                        <td>{{ $foodItem->food_item_category }}</td>
                                                        <td>{{ $foodItem->food_item_quantity }}</td>
                                                        <td>{{ $foodItem->has_expiry_date ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $foodItem->food_item_expiry_date ?? 'N/A' }}</td>
                                                        <td>
                                                            <form action="{{ route('fooditems.edit', $foodItem->id) }}" method="get" class="d-inline">
                                                                <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</button>
                                                            </form>
                                                            <form action="{{ route('fooditems.destroy', $foodItem->id) }}" method="post" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">
                                                        <span class="text-danger"><strong>Please add food items to proceed
                                                                for event submission.</strong></span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="m-4">
                            <div class="d-flex align-items-center justify-content-center">
                                <form action="{{ route('events.submit', ['eventId' => $event->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" id="submitEventButton" {{ $event->foodItems->isEmpty() ? 'disabled' : '' }}>
                                        <i class="fas fa-paper-plane fa-icon"></i> Submit Event
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
                @forelse($pastSubmittedEvents as $event)
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-sm-12 card-header m-2">
                                <h4>Past Submitted Events</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="card-body">
                                    <h3>Status: {{ ucfirst($event->status) }}</h3>
                                    <p>{{ $event->event_name }}</p>
                                    <p>Description: {{ $event->leftovers_description }}</p>
                                    <p>Redistribution Date: {{ $event->event_date }}</p>
                                    <p>Location: {{ $event->location }}</p>
                                    <p>People Quantity: {{ $event->people_quantity }}</p>
                                    <p>Leftovers Description: {{ $event->leftovers_description }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row g-0 mx-2 my-2">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2">Food Items:</h6>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Has Expiry Date?</th>
                                                <th>Expiry Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($event->foodItems->isNotEmpty())
                                                @foreach ($event->foodItems as $foodItem)
                                                    <tr>
                                                        <td>{{ $foodItem->food_item_name }}</td>
                                                        <td>{{ $foodItem->food_item_category }}</td>
                                                        <td>{{ $foodItem->food_item_quantity }}</td>
                                                        <td>{{ $foodItem->has_expiry_date ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $foodItem->food_item_expiry_date ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">
                                                        <span class="text-danger"><strong>Please add food items to proceed
                                                                for event submission.</strong></span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center card-footer">
                            @if ($event->status == 'approved')
                                <div class="button">
                                    <a href="{{ route('complete.event.redistribution', ['id' => $event->id]) }}" class="btn btn-primary m-2" style="text-decoration: none;">Complete Event Redistribution</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                @endforelse
                @forelse($completedEvents as $event)
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-sm-12 card-header m-2">
                                <h4>Completed Events Redistribution</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 card-header m-2">
                                <h5>Thank you for your participations. We appreciate your donation</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="card-body">
                                    <h3>Status: {{ ucfirst($event->status) }}</h3>
                                    <h5>{{ $event->event_name }}</h5>
                                    <p>Description: {{ $event->leftovers_description }}</p>
                                    <p>Redistribution Date: {{ $event->event_date }}</p>
                                    <p>Location: {{ $event->location }}</p>
                                    <p>People Quantity: {{ $event->people_quantity }}</p>
                                    <p>Leftovers Description: {{ $event->leftovers_description }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row g-0 mx-2 my-2">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2">Food Items:</h6>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Has Expiry Date?</th>
                                                <th>Expiry Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($event->foodItems->isNotEmpty())
                                                @foreach ($event->foodItems as $foodItem)
                                                    <tr>
                                                        <td>{{ $foodItem->food_item_name }}</td>
                                                        <td>{{ $foodItem->food_item_category }}</td>
                                                        <td>{{ $foodItem->food_item_quantity }}</td>
                                                        <td>{{ $foodItem->has_expiry_date ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $foodItem->food_item_expiry_date ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3">
                                                        <span class="text-danger"><strong>Please add food items to proceed
                                                                for event submission.</strong></span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

        </div>
    </div>
    </div>
@endsection