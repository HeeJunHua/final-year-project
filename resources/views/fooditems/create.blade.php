@extends('layouts.fundraise_layout')
@section('title')
    <title>Create Food Item</title>
@endsection

@section('style')
    <style>
        .customer-invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545; /* Red color for error messages, you can customize this */
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Add Food Item</h5>
            </div>
            <div class="card-body">
        
                <form action="{{ route('food_items.store') }}" method="post" id="addFoodItemForm">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->id ?? null }}">
                    <div class="mb-3">
                        <label for="food_item_name" class="form-label">
                            Food Item Name
                            <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                title="Enter the name of the food item."></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="name-addon">
                                <i class="fas fa-hamburger"></i>
                            </span>
                            <input type="text" class="form-control @error('food_item_name') is-invalid @enderror"
                                id="food_item_name" name="food_item_name" value="{{ old('food_item_name') }}"
                                placeholder="E.g., Canned Soup" required>
                            @error('food_item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="mb-3">
                        <label for="food_item_category" class="form-label">
                            Food Item Category
                            <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                title="Select the category of the food item."></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="category-addon">
                                <i class="fas fa-utensils"></i>
                            </span>
                            <select
                                class="form-select @error('food_item_category') is-invalid @enderror custom-select"
                                id="food_item_category" name="food_item_category" aria-describedby="category-addon"
                                required>
                                <option value="" selected disabled>Select Food Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        {{ old('food_item_category') == $category ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $category)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('food_item_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="mb-3">
                        <label for="food_item_quantity" class="form-label">
                            Quantity
                            <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                title="Enter the quantity of the food item."></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="quantity-addon">
                                <i class="fas fa-sort-numeric-up"></i>
                            </span>
                            <input type="number"
                                class="form-control @error('food_item_quantity') is-invalid @enderror"
                                id="food_item_quantity" name="food_item_quantity"
                                value="{{ old('food_item_quantity') }}" placeholder="E.g., 10" required>
                            @error('food_item_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="mb-3">
                        <label class="form-label">
                            Does it have an Expiry Date?
                            <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                title="Select 'Yes' if the food item has an expiry date, otherwise select 'No'."></i>
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_expiry_date" id="expiry_yes"
                                value="1" {{ old('has_expiry_date') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="expiry_yes">
                                <i class="fa fa-check"></i> Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_expiry_date" id="expiry_no"
                                value="0" {{ old('has_expiry_date') == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="expiry_no">
                                <i class="fa fa-times"></i> No
                            </label>
                        </div>
                        @error('has_expiry_date')
                            <div class="customer-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="mb-3 expiry-date-input" id="expiryDateInput" style="display: {{ old('has_expiry_date') == '1' ? 'block' : 'none' }}">
                        <label for="food_item_expiry_date" class="form-label">
                            Expiry Date
                            <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                title="Enter the expiry date of the food item."></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="expiry-date-addon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="date"
                                class="form-control @error('food_item_expiry_date') is-invalid @enderror"
                                id="food_item_expiry_date" name="food_item_expiry_date"
                                value="{{ old('food_item_expiry_date') }}"
                                {{ old('has_expiry_date') == '0' ? 'disabled' : '' }}>
                            @if (old('has_expiry_date') == '1' && old('food_item_expiry_date') == null)
                                <div class="invalid-feedback">Expiry date cannot be empty when you select 'Yes.'</div>
                            @endif
                            @error('food_item_expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="submitForm()">Add Food Item</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // For adding new food item date input
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle the display of expiry date input and enable/disable it
        function toggleExpiryDateInput() {
            var expiryDateInput = document.getElementById('expiryDateInput');
            var expiryYesRadio = document.getElementById('expiry_yes');
            var expiryNoRadio = document.getElementById('expiry_no');
            var expiryDate = document.getElementById('food_item_expiry_date');

            // Display expiry date input if 'Yes' is selected, otherwise hide it and enable/disable
            if (expiryYesRadio.checked) {
                expiryDateInput.style.display = 'block';
                expiryDate.removeAttribute('disabled');
            } else {
                expiryDateInput.style.display = 'none';
                expiryDate.setAttribute('disabled', 'disabled');
                expiryDate.value = ''; // Clear the date input
            }
        }

        // Attach event listener to radio buttons
        var expiryYesRadio = document.getElementById('expiry_yes');
        var expiryNoRadio = document.getElementById('expiry_no');

        expiryYesRadio.addEventListener('change', toggleExpiryDateInput);
        expiryNoRadio.addEventListener('change', toggleExpiryDateInput);

        // Initial call to set the initial state based on the default value
        toggleExpiryDateInput();
    });

    // Your existing function to submit the form
    function submitForm() {
        document.getElementById('addFoodItemForm').submit();
    }

    // For adding new food item expiry date input
    const expiryDateInput = document.getElementById('food_item_expiry_date');

    // Set the minimum date to one week from the current date
    const currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 3); // 2 Days from the current date

    const formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD

    expiryDateInput.setAttribute('min', formattedDate);

</script>

@endsection
