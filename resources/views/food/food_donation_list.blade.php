@section('title')
    Food Donation History
@endsection

@section('page_title')
    Food Donation History
@endsection

@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('food.donation.history') }}" method="GET">
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
                    <a href="{{ route('food.donation.history.status', 'pending') }}"
                        class="btn {{ $status === 'pending' ? 'btn-warning' : 'btn-default' }} btn-lg">Pending</a>
                    <a href="{{ route('food.donation.history.status', 'rejected') }}"
                        class="btn {{ $status === 'rejected' ? 'btn-warning' : 'btn-default' }} btn-lg">Rejected</a>
                    <a href="{{ route('food.donation.history.status', 'approved') }}"
                        class="btn {{ $status === 'approved' ? 'btn-warning' : 'btn-default' }} btn-lg">Approved</a>
                    <a href="{{ route('food.donation.history.status', 'completed') }}"
                        class="btn {{ $status === 'completed' ? 'btn-warning' : 'btn-default' }} btn-lg">Completed</a>
                    <a href="{{ route('food.donation.history.status', 'all') }}"
                        class="btn {{ $status === 'all' ? 'btn-warning' : 'btn-default' }} btn-lg">All</a>
                </div>
            </div>
            
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">
                        @if ($status == 'pending')
                            Pending Food Donation
                        @elseif($status == 'rejected')
                            Declined Food Donation
                        @elseif($status == 'approved')
                            Successful Food Donation
                        @elseif($status == 'completed')
                            Successful Food Donation
                        @elseif($status == 'all')
                            All Food Donation Status
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if ($donations->isEmpty())
                        <div class="redeem-voucher">
                            <div class="row">
                                <div class="col-lg-12">
                                    Your food donation is empty...
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($donations as $donation)
                            <div class="food-donation card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-2">Donation Date : {{ $donation->food_donation_date }}</h5>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="mb-1">Donation Status : {{ $donation->food_donation_status }}</h5>
                                    <div class="food-items table-responsive">
                                        @if ($donation->foodItems->isEmpty())
                                            <p class="text-muted">No food items in this donation.</p>
                                        @else
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="width: 30%;">Name</th>
                                                        <th style="width: 30%;">Category</th>
                                                        <th style="width: 20%;">Quantity</th>
                                                        <th style="width: 20%;">Expiry Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($donation->foodItems as $foodItem)
                                                        <tr>
                                                            <td>{{ $foodItem->food_item_name }}</td>
                                                            <td>{{ $foodItem->food_item_category }}</td>
                                                            <td>{{ $foodItem->food_item_quantity }}</td>
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
                                    @if ($donation->food_donation_status == 'approved')
                                        <div class="button">
                                            <a href="{{ route('complete.food.donation', ['id' => $donation->id]) }}" class="btn btn-primary m-2" style="text-decoration: none;">Complete Food Donation</a>
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