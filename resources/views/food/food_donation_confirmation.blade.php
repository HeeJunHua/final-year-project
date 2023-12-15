@extends('layouts.app')

@section('title')
    <title>Food Donation Page</title>
@endsection

@section('content')

    <div class="container mt-5">
        <form action="{{ route('food_items.makeDonation') }}" method="post">
            @csrf

            <div class="mb-3">
                {{-- Embed Google Map to Show Location --}}
                <iframe id="google-map-iframe" width="100%" height="300" allowfullscreen></iframe>
            </div>

            <div class="mb-3">
                {{-- Location Input for User's Address --}}
                <label for="locationInput" class="form-label">Enter Your Address:</label>
                <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                    title="The address will serve as location towards the nearest food bank available"></i>
                <input type="text" id="locationInput" name="location" class="form-control"
                    placeholder="Enter your location">
            </div>

            <div class="mb-3">
                {{-- Date and Time Input --}}
                <label for="donation_date_time" class="form-label">Select Date and Time for Donation :</label>
                <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                    title="Submission approval will requires minimum 2 days for response"></i>
                <input type="datetime-local" id="donation_date_time" name="donation_date_time" class="form-control">
            </div>

            <div class="mb-3">
                {{-- Food Bank Selection --}}
                <label for="foodBankSelect" class="form-label">Select Nearby Food Bank :</label>
                <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                    title="Nearest food bank will be selected automatically to the nearest address."></i>
                <select id="foodBankSelect" name="food_bank_id" class="form-control">
                    @foreach ($foodBanks as $foodBank)
                        <option value="{{ $foodBank->id }}" data-latitude="{{ $foodBank->latitude }}"
                            data-longitude="{{ $foodBank->longitude }}">
                            {{ $foodBank->name }} {{ $foodBank->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                {{-- Cancel Button --}}
                <a href="{{ route('food.donation') }}" class="btn btn-secondary">Cancel</a>

                {{-- Confirm Donation Button --}}
                <button type="submit" class="btn btn-success">Confirm Submit</button>
            </div>

        </form>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const eventDateInput = document.getElementById('donation_date_time');

            // Set the minimum date to one week from the current date
            const currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 2);

            const formattedDate = currentDate.toISOString().slice(0, 16);

            eventDateInput.setAttribute('min', formattedDate);


            var locationInput = document.getElementById('locationInput');
            var foodBankSelect = document.getElementById('foodBankSelect');
            var iframe = document.getElementById('google-map-iframe');
            var userLatitude;
            var userLongitude;
            var foodBanks = @json($foodBanks);

            // Function to calculate distance between two sets of latitude and longitude
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radius of the Earth in kilometers
                const dLat = (lat2 - lat1) * (Math.PI / 180);
                const dLon = (lon2 - lon1) * (Math.PI / 180);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.sin(dLon / 2) * Math
                    .sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distance = R * c; // Distance in kilometers

                return distance;
            }

            // Function to find the nearest food bank
            function findNearestFoodBank(userLatitude, userLongitude) {
                var nearestFoodBank = null;
                var shortestDistance = Infinity;

                // Log user coordinates
                console.log('User Coordinates:', userLatitude, userLongitude);
                if (Array.isArray(foodBanks)) {
                    for (var i = 0; i < foodBanks.length; i++) {
                        var foodBank = foodBanks[i];
                        var distance = calculateDistance(userLatitude, userLongitude, foodBank.latitude, foodBank
                            .longitude);

                        // Log distance for each food bank
                        console.log(foodBank.name, 'Distance:', distance);

                        // Update nearest food bank if the distance is shorter
                        if (distance < shortestDistance) {
                            nearestFoodBank = foodBank;
                            shortestDistance = distance;
                        }
                    }
                } else {

                    console.error('foodBanks is not an array or is undefined.');
                }

                return nearestFoodBank;
            }

            // Get user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        userLatitude = position.coords.latitude;
                        userLongitude = position.coords.longitude;

                        // Set the default location to user's current location
                        updateAddressAndIframe(userLatitude, userLongitude);

                        // Calculate and display the nearest food bank in the console log
                        var nearestFoodBank = findNearestFoodBank(userLatitude, userLongitude);
                        console.log('Nearest Food Bank:', nearestFoodBank);

                        // Automatically select and disable the nearest food bank in the food bank select
                        if (nearestFoodBank) {
                            var optionToSelect = Array.from(foodBankSelect.options).find(option => option
                                .value === nearestFoodBank.id.toString());
                            if (optionToSelect) {
                                optionToSelect.selected = true;
                            }
                        }
                    },
                    function(error) {
                        console.error('Error getting user location:', error.message);
                        // Handle the error as needed
                    }
                );
            } else {
                console.error('Geolocation is not supported by this browser.');
            }

            // Optional: Add an event listener to handle user input for the food bank selection
            foodBankSelect.addEventListener('change', function() {
                // Get the selected food bank's coordinates
                var selectedOption = foodBankSelect.options[foodBankSelect.selectedIndex];
                var foodBankLatitude = parseFloat(selectedOption.getAttribute('data-latitude'));
                var foodBankLongitude = parseFloat(selectedOption.getAttribute('data-longitude'));

                // Find the nearest food bank
                var nearestFoodBank = findNearestFoodBank(userLatitude, userLongitude);

                // Log the nearest food bank or use it as needed
                console.log('Nearest Food Bank:', nearestFoodBank);

                // Call the updateIframe function with the selected food bank's location
                updateIframe(nearestFoodBank.latitude, nearestFoodBank.longitude);
            });

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

                            // Update the iframe and selected food bank based on the new coordinates
                            updateAddressAndIframe(userLatitude, userLongitude);
                            var nearestFoodBank = findNearestFoodBank(userLatitude, userLongitude);
                            // Automatically select and make the nearest food bank in the food bank select readonly
                            if (nearestFoodBank) {
                                var optionToSelect = Array.from(foodBankSelect.options).find(option => option
                                    .value === nearestFoodBank.id.toString());
                                if (optionToSelect) {
                                    optionToSelect.selected = true;
                                    // foodBankSelect.setAttribute('readonly', 'readonly');
                                    // foodBankSelect.addEventListener('mousedown', function(event) {
                                    //     event.preventDefault();
                                    // });
                                }
                            }
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
                            var mapUrl = `https://maps.google.com/maps?q=${latitude},${longitude}&output=embed`;
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
                var mapUrl = `https://maps.google.com/maps?q=${latitude},${longitude}&output=embed`;
                iframe.src = mapUrl;
            }
        });
    </script>
@endsection
