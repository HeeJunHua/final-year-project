@extends('layouts.fundraise_layout')

@section('title')
    <title>Create Event for Redistribution</title>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            margin-top: 50px;
        }

        h2 {
            color: #007bff;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .hint {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .note {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 5px;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            border-radius: 0.5rem;
            height: 50px;
        }

        .form-control:focus {
            box-shadow: none;
        }


        #event_date.form-control{
            height: 37.78px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="card-header">
            <h5 class="mb-2">Create Event for Redistribution</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="post" class="needs-validation mb-3" novalidate>
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" required>
                        <small class="hint">Enter a unique and descriptive name for your event.</small>
                        @error('event_name')
                            <div class="note">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="event_date" class="form-label">Event Date</label>
                        <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                            title="Event date must be at least 2 days from the current date."></i>
                        <div class="input-group row">
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                            <small class="hint">Choose an end date and time for your event.</small>
                            @error('event_date')
                                <div class="note">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <iframe id="google-map-iframe" width="100%" height="300" allowfullscreen scrolling="no" class="mb-2"></iframe>
                    <label for="location" class="form-label">Enter Your Address:</label>
                    <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                        title="Specify the location where the event will take place."></i>
                    <input type="text" id="location" name="location" class="form-control"
                        placeholder="Enter your event location">
                    @error('location')
                        <div class="note">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-3">
                        <label for="people_quantity" class="form-label">People Attending :</label>
                        <div class="input-group col-md-12">
                            <input type="number" step="any" class="form-control" id="people_quantity" name="people_quantity" required>
                        </div>
                        <small class="hint">Specify the estimated number of people the food will serve.</small>
                        @error('people_quantity')
                            <div class="note">{{ $message }}</div>
                        @enderror
                </div>
                <div class="mb-3">
                    <label for="leftovers_description" class="form-label">Leftovers Description</label>
                    <textarea class="form-control" id="leftovers_description" name="leftovers_description" rows="3"></textarea>
                    <small class="hint">Provide additional details about the leftovers (if any). (e.g., Vegetarian options
                        available)</small>
                    @error('leftovers_description')
                        <div class="note">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save and Continue</button>
                </div>
            </form>
        </div>
        
    </div>
@endsection

@section('scripts')
        <!-- Include Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Include your additional scripts here -->
        <script>
            function addFoodItem() {
                // Clone the food item template and append it to the container
                var template = document.getElementById('food-item-template');
                var container = document.getElementById('food-items-container');
                var clone = document.importNode(template.content, true);
                container.appendChild(clone);
            }
    
            function removeFoodItem(button) {
                // Remove the parent row when the "Remove" button is clicked
                var row = button.closest('.row');
                row.remove();
            }
        </script>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Include Bootstrap JS (Assuming you have Bootstrap installed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript to disable dates less than one week from the current date -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eventDateInput = document.getElementById('event_date');

            // Set the minimum date to one week from the current date
            const currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 3);

            const formattedDate = currentDate.toISOString().slice(0, 16); // Format as YYYY-MM-DDTHH:mm

            eventDateInput.setAttribute('min', formattedDate);
        });

        // Custom JavaScript to handle location and map
        document.addEventListener('DOMContentLoaded', function() {
            var locationInput = document.getElementById('location');
            var iframe = document.getElementById('google-map-iframe');
            var userLatitude;
            var userLongitude;

            // Get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        userLatitude = position.coords.latitude;
                        userLongitude = position.coords.longitude;

                        // Set the default location to user's current location
                        updateAddressAndIframe(userLatitude, userLongitude);
                    },
                    function(error) {
                        console.error('Error getting user location:', error.message);
                        // Handle the error as needed
                    }
                );
            } else {
                console.error('Geolocation is not supported by this browser.');
            }

            // Event listener for location input change
            locationInput.addEventListener('change', function() {
                // Use OpenCage Geocoding API to get the coordinates from the address
                var address = locationInput.value;
                fetch(
                        `https://api.opencagedata.com/geocode/v1/json?q=${address}&key=4f3005eb1c14413e90227198cc7fc899`
                    )
                    .then(response => response.json())
                    .then(data => {
                        if (data.results.length > 0) {
                            var coordinates = data.results[0].geometry;
                            userLatitude = coordinates.lat;
                            userLongitude = coordinates.lng;

                            // Update the iframe based on the new coordinates
                            updateIframe(userLatitude, userLongitude);
                        } else {
                            console.error('Geocoding failed. Please check the entered address.');
                        }
                    })
                    .catch(error => {
                        console.error('Error during geocoding:', error);
                    });
            });

            function updateAddressAndIframe(latitude, longitude) {
                // Use OpenCage Geocoding API to get the address from the coordinates
                fetch(
                        `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=4f3005eb1c14413e90227198cc7fc899`
                    )
                    .then(response => response.json())
                    .then(data => {
                        if (data.results.length > 0) {
                            var address = data.results[0].formatted;
                            locationInput.value = address;

                            // Use a basic Google Maps URL for the iframe with a marker
                            var mapUrl =
                                `https://maps.google.com/maps?q=${latitude},${longitude}&output=embed&gestureHandling=none`;
                            iframe.src = mapUrl;
                        } else {
                            console.error('Geocoding failed. Please check the entered coordinates.');
                        }
                    })
                    .catch(error => {
                        console.error('Error during geocoding:', error);
                    });
            }

            function updateIframe(latitude, longitude) {
                // Use a basic Google Maps URL for the iframe with a marker
                var mapUrl =
                    `https://maps.google.com/maps?q=${latitude},${longitude}&output=embed&gestureHandling=none`;
                iframe.src = mapUrl;
            }
        });
    </script>
@endsection
