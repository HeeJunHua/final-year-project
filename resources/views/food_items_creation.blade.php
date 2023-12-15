<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Item Creation</title>
    @include('top_nav_bar')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 1rem;
        }

        section {
            max-width: 700px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .small-text {
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success"  style="margin-bottom: 0px;" id="successAlert">
            {{ session('success') }}
        </div>
    @endif
    <section class="itemCreation">
        <h3>Food Item Creation</h3>
        <form action="{{ route('food_items.store') }}" method="POST">
            @csrf

            <div id="newFoodItem" class="form-group">
                <label for="food_item_name">Food Item Name:</label>
                <input type="text" id="food_item_name" name="food_item_name" class="form-control @error('food_item_name') is-invalid @enderror">
                @error('food_item_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="food_item_category">Food Item Category:</label>
                <select id="food_item_category" name="food_item_category" class="form-control @error('food_item_category') is-invalid @enderror" required>
                    <option value="" selected disabled>Select a category</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="fruits">Fruits</option>
                    <option value="grains">Grains</option>
                    <option value="proteins">Proteins (e.g., meat, fish, eggs)</option>
                    <option value="dairy">Dairy</option>
                    <option value="snacks">Snacks</option>
                    <option value="beverages">Beverages</option>
                    <option value="canned_goods">Canned Goods</option>
                    <option value="dry_goods">Dry Goods (e.g., pasta, rice)</option>
                    <option value="frozen_foods">Frozen Foods</option>
                    <option value="baked_goods">Baked Goods</option>
                    <option value="sweets">Sweets (e.g., candies, chocolates)</option>
                </select>
                @error('food_item_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="food_item_quantity">Food Item Quantity/KG :</label>
                <input type="number" id="food_item_quantity" name="food_item_quantity" class="form-control @error('food_item_quantity') is-invalid @enderror" min="1">
                @error('food_item_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="food_item_expiry_date">Food Item Expiry Date : <span class="small-text">(expiry date must be at least 1 week)</span></label>
                <input type="date" id="food_item_expiry_date" name="food_item_expiry_date" class="form-control @error('food_item_expiry_date') is-invalid @enderror"
                    min="{{ now()->addWeek()->toDateString() }}">
                @error('food_item_expiry_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary mx-auto col-md-3 mt-4">Add Item</button>
            </div>            
            
        </form>
    </section>
</body>
<footer>
    @include('bot_nav_bar')
</footer>
</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Set a timer to fade out the alert after 3 seconds (3000 milliseconds)
    $(document).ready(function() {
        setTimeout(function() {
            $('#successAlert').fadeOut();
        }, 3000); // Adjust the duration as needed
    });
</script>
