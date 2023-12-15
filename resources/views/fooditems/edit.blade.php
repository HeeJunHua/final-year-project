@extends('layouts.app')

@section('title')
    <title>Edit Food Item</title>
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
                <h5 class="mb-0">Edit Food Item</h5>
            </div>
            <div class="card-body">
                <!-- Edit Form -->
                <form action="{{ route('food_items.update', $foodItem) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="event_id" value="{{ $event_id ?? null }}">
                    <!-- Food Item Name -->
                    <div class="form-group">
                        <label for="food_item_name">Food Item Name:</label>
                        <input type="text" id="food_item_name" name="food_item_name"
                            class="form-control @error('food_item_name') is-invalid @enderror"
                            value="{{ old('food_item_name', $foodItem->food_item_name) }}">
                        @error('food_item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Food Item Category -->
                    <div class="form-group">
                        <label for="food_item_category">Food Item Category:</label>
                        <select id="food_item_category" name="food_item_category"
                            class="form-control @error('food_item_category') is-invalid @enderror" required>
                            <option value="" disabled>Select Food Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ old('food_item_category', $foodItem->food_item_category) == $category ? 'selected' : '' }}>
                                    {{ ucfirst($category) }}
                                </option>
                            @endforeach
                        </select>
                        @error('food_item_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Food Item Quantity -->
                    <div class="form-group">
                        <label for="food_item_quantity">Food Item Quantity:</label>
                        <input type="number" id="food_item_quantity" name="food_item_quantity"
                            class="form-control @error('food_item_quantity') is-invalid @enderror"
                            value="{{ old('food_item_quantity', $foodItem->food_item_quantity) }}" min="1" required>
                        @error('food_item_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Has Expiry Date -->
                    <div class="form-group">
                        <label for="has_expiry_date2">Does it have an Expiry Date?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_expiry_date2"
                                id="expiry_yes{{ $foodItem->id }}" value="1"
                                {{ old('has_expiry_date2', $foodItem->has_expiry_date) == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="expiry_yes{{ $foodItem->id }}">
                                <i class="fa fa-check"></i> Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_expiry_date2"
                                id="expiry_no{{ $foodItem->id }}" value="0"
                                {{ old('has_expiry_date2', $foodItem->has_expiry_date) == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="expiry_no{{ $foodItem->id }}">
                                <i class="fa fa-times"></i> No
                            </label>
                        </div>
                        @error('has_expiry_date2')
                            <div class="custom-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Expiry Date Input -->
                    <div class="form-group" id="expiryDateInput{{ $foodItem->id }}"
                        style="display: {{ old('has_expiry_date2', $foodItem->has_expiry_date) == '1' ? 'block' : 'none' }}">
                        <label for="food_item_expiry_date">Expiry Date:</label>
                        <input type="date" id="food_item_expiry_date" name="food_item_expiry_date"
                            class="form-control @error('food_item_expiry_date') is-invalid @enderror"
                            value="{{ old('food_item_expiry_date', $foodItem->food_item_expiry_date) }}">
                        @if (old('has_expiry_date2', $foodItem->has_expiry_date) == '1' &&
                                old('food_item_expiry_date', $foodItem->food_item_expiry_date) == null)
                            <div class="invalid-feedback">Expiry date cannot be empty when you select 'Yes.'</div>
                        @endif
                        @error('food_item_expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Food Item</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
    // Function to toggle the display of expiry date input and enable/disable it
    function toggleExpiryDateInputEdit() {
        var expiryYesRadio = document.querySelector('[name="has_expiry_date2"]:checked');
        var expiryDateInput = document.getElementById('expiryDateInput{{ $foodItem->id }}');
        var expiryDate = document.getElementById('food_item_expiry_date');

        // Display expiry date input if 'Yes' is selected, otherwise hide it and enable/disable
        if (expiryYesRadio && expiryYesRadio.value === '1') {
            expiryDateInput.style.display = 'block';
            expiryDate.removeAttribute('disabled');
        } else {
            expiryDateInput.style.display = 'none';
            expiryDate.setAttribute('disabled', 'disabled'); // Set disabled attribute
            expiryDate.value = ''; // Clear the date input
        }
    }

    // Attach event listener to the radio buttons
    document.querySelectorAll('[name="has_expiry_date2"]').forEach(function (radio) {
        radio.addEventListener('change', toggleExpiryDateInputEdit);
    });

    // Initial call to set the initial state based on the default value
    toggleExpiryDateInputEdit();
});



    // Your existing function to submit the form
    function submitForm() {
        document.getElementById('addFoodItemForm').submit();
    }

    // For adding new food item expiry date input
    const expiryDateInput = document.getElementById('food_item_expiry_date');

    // Set the minimum date to one week from the current date
    const currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 7); // One week from the current date

    const formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD

    expiryDateInput.setAttribute('min', formattedDate);

</script>

@endsection
