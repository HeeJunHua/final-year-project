@extends('layouts.dashboard')

@section('title')
    Event Redistribution History
@endsection

@section('page_title')
    Event Redistribution History
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('event.redistribution.history') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="search">Search:</label>
                                    <input type="text" name="search" class="form-control"
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="form-group row mx-0">
                <div class="col-md-11">
                    <a href="{{ route('event.redistribution.history.status', 'pending') }}"
                       class="btn {{ $status === 'pending' ? 'btn-warning' : 'btn-default' }} btn-lg">Pending</a>
                    <a href="{{ route('event.redistribution.history.status', 'declined') }}"
                       class="btn {{ $status === 'declined' ? 'btn-warning' : 'btn-default' }} btn-lg">Declined</a>
                    <a href="{{ route('event.redistribution.history.status', 'approved') }}"
                       class="btn {{ $status === 'approved' ? 'btn-warning' : 'btn-default' }} btn-lg">Approved</a>
                    <a href="{{ route('event.redistribution.history.status', 'completed') }}"
                       class="btn {{ $status === 'completed' ? 'btn-warning' : 'btn-default' }} btn-lg">Completed</a>
                    <a href="{{ route('event.redistribution.history.status', 'all') }}"
                       class="btn {{ $status === 'all' ? 'btn-warning' : 'btn-default' }} btn-lg">All</a>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">
                        @if ($status == 'pending')
                            Pending Event Redistribution
                        @elseif($status == 'declined')
                            Declined Event Redistribution
                        @elseif($status == 'approved')
                            Accepted Event Redistribution
                        @elseif($status == 'completed')
                            Completed Event Redistribution
                        @elseif($status == 'all')
                            All Event Redistribution Status
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if ($eventRedistributions->isEmpty())
                        <div class="redeem-voucher">
                            <div class="row">
                                <div class="col-lg-12">
                                    Your event redistribution history is empty...
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($eventRedistributions as $eventRedistribution)
                            <div class="event-redistribution card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-2">Event Name: {{ $eventRedistribution->event_name }} ({{ $eventRedistribution->status }})</h5>
                                    <p>Event Date: {{ \Carbon\Carbon::parse($eventRedistribution->event_date)->format('l, F j, Y \a\t g:i A') }}</p>
                                    <p>Location: {{ $eventRedistribution->location }}</p>
                                    <p>People Quantity: {{ $eventRedistribution->people_quantity }}</p>
                                    <p>Leftovers Description: {{ $eventRedistribution->leftovers_description }}</p>
                                    <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#details_{{ $loop->iteration }}">Toggle Details</button>
                                </div>

                                <div class="card-body collapse" id="details_{{ $loop->iteration }}">
                                    <div class="food-items table-responsive">
                                        @if ($eventRedistribution->foodItems->isEmpty())
                                            <p class="text-muted">No food items in this event redistribution.</p>
                                        @else
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 30%;">Food Item</th>
                                                    <th style="width: 30%;">Quantity</th>
                                                    <th style="width: 20%;">Category</th>
                                                    <th style="width: 20%;">Expiry Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($eventRedistribution->foodItems as $foodItem)
                                                    <tr>
                                                        <td>{{ $foodItem->food_item_name }}</td>
                                                        <td>{{ $foodItem->food_item_quantity }}</td>
                                                        <td>{{ $foodItem->food_item_category }}</td>
                                                        <td>
                                                            @if ($foodItem->has_expiry_date)
                                                                {{ $foodItem->food_item_expiry_date }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center card-footer">
                                    @if ($eventRedistribution->status == 'approved')
                                        <div class="button">
                                            <a href="{{ route('complete.event.redistribution', ['id' => $eventRedistribution->id]) }}" class="btn btn-primary m-2" style="text-decoration: none;">Complete Event Redistribution</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
