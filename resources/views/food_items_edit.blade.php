<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Item</title>
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
            max-width: 600px;
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
    <section class="container">
        <h3>Edit Food Item</h3>
        <form action="{{ route('food_items.update', $food_item) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="food_item_name">Food Item Name:</label>
                <input type="text" id="food_item_name" name="food_item_name" class="form-control @error('food_item_name') is-invalid @enderror" value="{{ old('food_item_name', $food_item->food_item_name) }}">
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
                    <option value="vegetables" {{ old('food_item_category', $food_item->food_item_category) === 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="fruits" {{ old('food_item_category', $food_item->food_item_category) === 'fruits' ? 'selected' : '' }}>Fruits</option>
                    <option value="grains" {{ old('food_item_category', $food_item->food_item_category) === 'grains' ? 'selected' : '' }}>Grains</option>
                    <option value="proteins" {{ old('food_item_category', $food_item->food_item_category) === 'proteins' ? 'selected' : '' }}>Proteins (e.g., meat, fish, eggs)</option>
                    <option value="dairy" {{ old('food_item_category', $food_item->food_item_category) === 'dairy' ? 'selected' : '' }}>Dairy</option>
                    <option value="snacks" {{ old('food_item_category', $food_item->food_item_category) === 'snacks' ? 'selected' : '' }}>Snacks</option>
                    <option value="beverages" {{ old('food_item_category', $food_item->food_item_category) === 'beverages' ? 'selected' : '' }}>Beverages</option>
                    <option value="canned_goods" {{ old('food_item_category', $food_item->food_item_category) === 'canned_goods' ? 'selected' : '' }}>Canned Goods</option>
                    <option value="dry_goods" {{ old('food_item_category', $food_item->food_item_category) === 'dry_goods' ? 'selected' : '' }}>Dry Goods (e.g., pasta, rice)</option>
                    <option value="frozen_foods" {{ old('food_item_category', $food_item->food_item_category) === 'frozen_foods' ? 'selected' : '' }}>Frozen Foods</option>
                    <option value="baked_goods" {{ old('food_item_category', $food_item->food_item_category) === 'baked_goods' ? 'selected' : '' }}>Baked Goods</option>
                    <option value="sweets" {{ old('food_item_category', $food_item->food_item_category) === 'sweets' ? 'selected' : '' }}>Sweets (e.g., candies, chocolates)</option>
                </select>
                @error('food_item_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="food_item_quantity">Food Item Quantity:</label>
                <input type="number" id="food_item_quantity" name="food_item_quantity" class="form-control @error('food_item_quantity') is-invalid @enderror" min="1" value="{{ old('food_item_quantity', $food_item->food_item_quantity) }}">
                @error('food_item_quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="food_item_expiry_date">Food Item Expiry Date : <span class="small-text">(expiry date must be at least 1 week)</span></label>
                <input type="date" id="food_item_expiry_date" name="food_item_expiry_date" class="form-control @error('food_item_expiry_date') is-invalid @enderror"
                    min="{{ now()->addWeek()->toDateString() }}" value="{{ old('food_item_expiry_date', $food_item->food_item_expiry_date) }}">
                @error('food_item_expiry_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary mx-auto col-md-3 mt-4">Update Item</button>
            </div>
        </form>
    </section>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
