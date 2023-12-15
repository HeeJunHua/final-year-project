@section('title')
Food Donation Management
@endsection

@section('page_title')
Food Donation Management
@endsection

@extends('layouts.dashboard')
@section('content')
    {{-- <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"> --}}

    <style>
        /* Custom styling for better visibility */
        .user-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            transition: box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .user-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .details-section {
            text-align: right;
        }

        .btn-accept {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-decline {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-accept, .btn-decline {
            width: 100%;
            margin-top: 10px;
        }

        .status-accepted {
            color: #28a745;
            font-weight: bold;
        }

    </style>

    <div class="row">
        @if($foodDonation->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    Currently, there are no pending requests.
                </div>
            </div>
        @else
            @foreach($foodDonation as $donation)
                <div class="col-md-6">
                    <div class="card user-card">
                        <div class="card-body">
                            <div>
                                <h4 class="card-title">{{ $donation->foodItem->food_item_name }}</h4>
                                <p class="card-text"><i class="fas fa-user"></i> User: {{ $donation->user->username }}</p>
                                <p class="card-text"><i class="fa-solid fa-envelope"></i> Email : {{ $donation->user->email }}</p>
                                <p class="card-text"><i class="far fa-calendar-alt"></i> Donation Request Date: {{ $donation->food_donation_date instanceof \DateTime ? $donation->food_donation_date->format('F j, Y H:i A') : $donation->food_donation_date }}</p>
                                <p class="card-text"><i class="far fa-calendar-times"></i> Expiry Date: {{ $donation->foodItem->food_item_expiry_date instanceof \DateTime ? $donation->foodItem->food_item_expiry_date->format('F j, Y') : $donation->foodItem->food_item_expiry_date }}</p>
                                
                                <!-- Calculate and display the remaining days until expiry date -->
                                @php
                                    $expiryDate = new \Carbon\Carbon($donation->foodItem->food_item_expiry_date);
                                    $remainingDays = $expiryDate->diffInDays(\Carbon\Carbon::now());
                                @endphp
                                <p class="card-text"><i class="fas fa-info-circle"></i> Remaining Days: {{ $remainingDays }} days</p>
                                
                                <p class="card-text"><i class="fas fa-info-circle"></i> Status: <span class="{{ $donation->food_donation_status == 'accepted' ? 'status-accepted' : '' }}">{{ $donation->food_donation_status }}</span></p>
                            </div>

                            <!-- Add button to show detailed information -->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $donation->id }}">
                                <i class="fas fa-info"></i> Details
                            </a>
                        </div>
                        <div class="card-footer">
                            <!-- Add form for accepting/declining donation -->
                            <form action="{{ route('admin.foodDonation.update', $donation->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="accept" class="btn btn-accept"><i class="fas fa-check"></i> Accept</button>
                                <button type="submit" name="action" value="decline" class="btn btn-decline"><i class="fas fa-times"></i> Decline</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Details Modal -->
                <div class="modal fade" id="detailsModal{{ $donation->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $donation->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel{{ $donation->id }}">Food Items Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Food Item Category:</strong> {{ $donation->foodItem->food_item_category }}</p>
                                <p><strong>Food Quantity:</strong> {{ $donation->foodItem->food_item_quantity }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Include Bootstrap JS (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
