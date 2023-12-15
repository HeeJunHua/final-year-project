<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event for Redistribution</title>
    @include('top_nav_bar')

    <!-- Include Bootstrap CSS (Assuming you have Bootstrap installed) -->
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

        .btn-primary {
            border-radius: 0.5rem;
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Create Event for Redistribution</h2>
        <form action="{{ route('events.store') }}" method="post" class="needs-validation" novalidate>
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
                    <small class="note">(Note: Event date must be at least 1 week from the current date.)</small>
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
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
                <small class="hint">Specify the location where the event will take place.</small>
                @error('location')
                    <div class="note">{{ $message }}</div>
                @enderror
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="food_amount" class="form-label">Food Amount</label>
                    <input type="number" class="form-control" id="food_amount" name="food_amount" required>
                    <small class="hint">Enter the amount of food you plan to redistribute.</small>
                    @error('food_amount')
                        <div class="note">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="food_amount_unit" required>
                        <option value="quantity">Quantity</option>
                        <option value="kg">Kilograms</option>
                    </select>
                    <small class="hint">Select the unit for the food.</small>
                    @error('food_amount_unit')
                        <div class="note">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="people_quantity" class="form-label">People Attending :</label>
                    <input type="number" step="any" class="form-control" id="people_quantity" name="people_quantity" required>
                    <small class="hint">Specify the estimated number of people the food will serve.</small>
                    @error('people_quantity')
                        <div class="note">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="leftovers_description" class="form-label">Leftovers Description</label>
                <textarea class="form-control" id="leftovers_description" name="leftovers_description" rows="3"></textarea>
                <small class="hint">Provide additional details about the leftovers (if any). (e.g., Vegetarian options available)</small>
                @error('leftovers_description')
                    <div class="note">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Create Event</button>
            </div>
        </form>
    </div>
    <!-- Include Bootstrap JS (Assuming you have Bootstrap installed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript to disable dates less than one week from the current date -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const eventDateInput = document.getElementById('event_date');

            // Set the minimum date to one week from the current date
            const currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 7);

            const formattedDate = currentDate.toISOString().slice(0, 16); // Format as YYYY-MM-DDTHH:mm

            eventDateInput.setAttribute('min', formattedDate);
        });
    </script>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
