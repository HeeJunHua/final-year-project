<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    @include('top_nav_bar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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

        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
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
        <h2>Edit Event</h2>
        <form action="{{ route('events.update', $event->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="event_name" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="{{ old('event_name', $event->event_name) }}" required>
                <small class="hint">Enter a unique and descriptive name for your event.</small>
                @error('event_name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="{{ old('event_date', $event->event_date) }}" required>
                    <small class="hint">Choose the date and time for your event.</small>
                    @error('event_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $event->location) }}" required>
                    <small class="hint">Specify the location where the event will take place.</small>
                    @error('location')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="food_amount" class="form-label">Food Amount</label>
                    <input type="number" class="form-control" id="food_amount" name="food_amount" value="{{ old('food_amount', $event->food_amount) }}" required>
                    <small class="hint">Enter the amount of food you plan to redistribute (e.g., 0.1 kg).</small>
                    @error('food_amount')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="food_amount_unit" required>
                        <option value="quantity" {{ old('food_amount_unit', $event->food_amount_unit) == 'quantity' ? 'selected' : '' }}>Quantity</option>
                        <option value="kg" {{ old('food_amount_unit', $event->food_amount_unit) == 'kg' ? 'selected' : '' }}>Kilograms</option>
                    </select>
                    <small class="hint">Select the unit for the food.</small>
                    @error('food_amount_unit')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="people_quantity" class="form-label">People Quantity</label>
                    <input type="number" step="any" class="form-control" id="people_quantity" name="people_quantity" value="{{ old('people_quantity', $event->people_quantity) }}" required>
                    <small class="hint">Specify the estimated number of people the food will serve.</small>
                    @error('people_quantity')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="leftovers_description" class="form-label">Leftovers Description</label>
                <textarea class="form-control" id="leftovers_description" name="leftovers_description" rows="3">{{ old('leftovers_description', $event->leftovers_description) }}</textarea>
                <small class="hint">Provide additional details about the leftovers (if any).</small>
                @error('leftovers_description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
