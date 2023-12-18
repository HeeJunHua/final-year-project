@extends('layouts.fundraise_layout')

@section('title')
    <title>Food Donation Page</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .custom-invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
            /* Bootstrap's default danger color */
        }

        .food-item-card {
            position: relative;
        }

        .edit-delete-buttons {
            position: absolute;
            top: 0;
            right: 0;
        }

        .food-item-card h6 {
            margin-bottom: 0.5rem;
        }

        .food-item-card p {
            margin-bottom: 0.25rem;
        }

        .food-item-card .fa {
            margin-right: 5px;
        }

        .info-icon {
            margin-left: 5px;
            color: #007bff;
            /* Bootstrap's primary color */
            cursor: pointer;
        }

        .donate-all-button {
            margin-top: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="{{ count($foodItems) > 0 ? 'col-md-8' : 'col-md-12' }}">
                {{-- Food Donation Purpose --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Welcome to Our Food Donation Page</h5>
                    </div>
                    <div class="card-body">
                        <p>Thank you for choosing to make a positive impact through our Food Donation Program. Your
                            contributions play a crucial role in helping those in need.</p>
                        <p>Our mission is to create a community that cares and shares. By adding food items to our donation
                            pool, you are actively participating in making a difference in the lives of others.</p>
                        <p>Together, we can alleviate hunger and build a stronger, more compassionate community.</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Add Food Item</h5>
                    </div>
                    <div class="card-body">
                        <p>Contribute to our food donation program by adding items that you are willing to share. Your
                            generosity makes a direct impact on the lives of those who need it most.</p>
                
                        <form action="{{ route('food_items.store') }}" method="post" id="addFoodItemForm">
                            @csrf
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
                                    <div class="custom-invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3 expiry-date-input" id="expiryDateInput" style="display: {{ old('has_expiry_date') == '1' ? 'block' : 'none' }}">
                                <label for="food_item_expiry_date" class="form-label">
                                    Expiry Date
                                    <i class="fa fa-info-circle info-icon" data-toggle="tooltip" data-placement="top"
                                        title="Enter the expiry date of the food item. Food item must have at least 2 days before the expiry date."></i>
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
            
                            <button type="button" class="btn btn-primary" onclick="submitForm()">Add Food Item</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- User's Food Items --}}
            @if (count($foodItems) > 0)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Your Contributed Food Items</h5>
                        </div>
                        <div class="card-body">
                            {{-- Iterate through user's food items --}}
                            @foreach ($foodItems as $foodItem)
                                <div class="mb-3 border-bottom pb-3 food-item-card">
                                    <div class="edit-delete-buttons">
                                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editModal{{ $foodItem->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('food_items.destroy', $foodItem) }}" method="post"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this item?')"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                    <h6>{{ $foodItem->food_item_name }}</h6>
                                    <p><strong><i class="fa fa-box"></i> Quantity:</strong>
                                        {{ $foodItem->food_item_quantity }}</p>
                                    <p><strong><i class="fa fa-tag"></i> Category:</strong>
                                        {{ $foodItem->food_item_category }}</p>
                                    @if ($foodItem->food_item_expiry_date !== null)
                                        <p><strong><i class="fa fa-calendar"></i> Expiry Date:</strong>
                                            {{ $foodItem->food_item_expiry_date }}</p>
                                    @else
                                        <p><strong><i class="fa fa-calendar-times"></i> Expiry Date:</strong> Not
                                            applicable</p>
                                    @endif
                                    {{-- Add more details as needed --}}
                                </div>
                            @endforeach

                            {{-- Total Quantity Count and Donate Button --}}
                            <div class="mt-4">
                                <p><strong>Total Items:</strong> {{ $foodItems->sum('food_item_quantity') }}</p>
                                <button type="button" class="btn btn-success donate-all-button" data-toggle="modal"
                                    data-target="#donationModal">
                                    <i class="fa fa-gift"></i> Donate All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal and Donation Modal -->
                <div class="container">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <!-- Edit Modal -->
                            @foreach ($foodItems as $foodItem)
                            <div class="modal fade" id="editModal{{ $foodItem->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModalLabel{{ $foodItem->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Food Item</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Edit Form -->
                                            <form action="{{ route('food_items.update', $foodItem) }}" method="POST">
                                                @csrf
                                                @method('PUT')

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
                            </div>
                            @endforeach


                            <!-- Donation Modal -->
                            <div class="modal fade" id="donationModal" tabindex="-1" role="dialog"
                                aria-labelledby="donationModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="donationModalLabel">Confirm Donation</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Donation confirmation message -->
                                            <p>Are you sure you want to donate all your food items?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('food.donation.location') }}" method="get">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm Donation</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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

    // For edit date input
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle the display of expiry date input and enable/disable it
        function toggleExpiryDateInputEdit(foodItemId) {
            var expiryDateInput = document.getElementById('expiryDateInput' + foodItemId);
            var expiryYesRadio = document.getElementById('expiry_yes' + foodItemId);
            var expiryDate = document.getElementById('food_item_expiry_date');

            // Display expiry date input if 'Yes' is selected, otherwise hide it and enable/disable
            if (expiryYesRadio.checked) {
                expiryDateInput.style.display = 'block';
                expiryDate.removeAttribute('disabled');
            } else {
                expiryDateInput.style.display = 'none';
                expiryDate.removeAttribute('disabled'); // Remove disabled attribute
                expiryDate.value = ''; // Clear the date input
            }
        }

        
        
        // Attach event listeners to radio buttons for each edit modal
        @foreach ($foodItems as $foodItem)
            var expiryYesRadio{{ $foodItem->id }} = document.getElementById('expiry_yes{{ $foodItem->id }}');
            var expiryNoRadio{{ $foodItem->id }} = document.getElementById('expiry_no{{ $foodItem->id }}');
            var expiryDate{{ $foodItem->id }} = document.getElementById('food_item_expiry_date');

            expiryYesRadio{{ $foodItem->id }}.addEventListener('change', function () {
                toggleExpiryDateInputEdit('{{ $foodItem->id }}');
            });

            expiryNoRadio{{ $foodItem->id }}.addEventListener('change', function () {
                toggleExpiryDateInputEdit('{{ $foodItem->id }}');
            });

            // Initial call to set the initial state based on the default value
            toggleExpiryDateInputEdit('{{ $foodItem->id }}');
            
            
        @endforeach
    });

    // For adding new food item expiry date input
    const expiryDateInput = document.getElementById('food_item_expiry_date');

    // Set the minimum date to one week from the current date
    const currentDate = new Date();
    currentDate.setDate(currentDate.getDate() + 3); // 2 Days from the current date

    const formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD

    expiryDateInput.setAttribute('min', formattedDate);
</script>


@endsection
