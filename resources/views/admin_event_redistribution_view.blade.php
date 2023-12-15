@section('title')
Event Redistribution Management
@endsection

@section('page_title')
Event Redistribution Management
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

        .btn-approve {
            background-color: #28a745;
            color: #fff;
            border: none;
        }

        .btn-decline {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-approve, .btn-decline {
            width: 100%;
            margin-top: 10px;
        }

        .status-approved {
            color: #28a745;
            font-weight: bold;
        }

        .status-declined {
            color: #dc3545;
            font-weight: bold;
        }

    </style>

    <div class="row">
        @if($eventRedistribution->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    Currently, there are no pending event redistributions.
                </div>
            </div>
        @else
            @foreach($eventRedistribution as $redistribution)
                <div class="col-md-6">
                    <div class="card user-card">
                        <div class="card-body">
                            <div>
                                <h4 class="card-title">{{ $redistribution->event_name }}</h4>
                                <p class="card-text"><i class="fas fa-user"></i> User: {{ $redistribution->user->username }}</p>
                                <p class="card-text"><i class="far fa-calendar-alt"></i> Event Date: {{ $redistribution->event_date }}</p>
                                <p class="card-text"><i class="fas fa-map-marker-alt"></i> Location: {{ $redistribution->location }}</p>
                                <p class="card-text"><i class="fas fa-utensils"></i> Food Amount: {{ $redistribution->food_amount }} {{ $redistribution->food_amount_unit }}</p>
                                
                                <p class="card-text"><i class="fas fa-info-circle"></i> Status: <span class="{{ $redistribution->status == 'approved' ? 'status-approved' : ($redistribution->status == 'declined' ? 'status-declined' : '') }}">{{ $redistribution->status }}</span></p>
                            </div>

                            <!-- Add button to show detailed information -->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $redistribution->id }}">
                                <i class="fas fa-info"></i> Details
                            </a>
                        </div>
                        <div class="card-footer">
                            <!-- Add form for approving/declining event redistribution -->
                            <form action="{{ route('admin.updateEventRedistributionStatus', $redistribution->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="approve" class="btn btn-approve"><i class="fas fa-check"></i> Approve</button>
                                <button type="submit" name="action" value="decline" class="btn btn-decline"><i class="fas fa-times"></i> Decline</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Details Modal -->
                <div class="modal fade" id="detailsModal{{ $redistribution->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $redistribution->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailsModalLabel{{ $redistribution->id }}">Event Redistribution Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>People Quantity:</strong> {{ $redistribution->people_quantity }}</p>
                                <p><strong>Leftovers Description:</strong> {{ $redistribution->leftovers_description }}</p>
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
