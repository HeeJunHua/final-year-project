@extends('layouts.fundraise_layout')

@section('title')
    <title>Edit Product Page</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .itemCreation {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    <section class="itemCreation">
        <h3>Edit Product</h3>
        <form action="{{ route('inventory.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                    value="{{ old('product_name', $product->product_name) }}">
                @error('product_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="product_category">Product Category:</label>
                <select id="product_category" name="product_category"
                    class="form-control @error('product_category') is-invalid @enderror" required>
                    <!-- Add options for categories -->
                    <option value="vegetables" {{ old('product_category', $product->product_category) === 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                    <option value="fruits" {{ old('product_category', $product->product_category) === 'fruits' ? 'selected' : '' }}>Fruits</option>
                    <!-- Add more options as needed -->
                </select>
                @error('product_category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" rows="3"
                    required>{{ old('description', $product->product_description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date"
                    class="form-control @error('expiry_date') is-invalid @enderror"
                    value="{{ old('expiry_date', $product->product_expiry_date) }}" required>
                @error('expiry_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Product Quantity:</label>
                <input type="number" id="quantity" name="quantity"
                    class="form-control @error('quantity') is-invalid @enderror" min="1" required
                    value="{{ old('quantity', $product->product_quantity) }}">
                @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary mx-auto col-md-3 mt-4">Update Product</button>
            </div>
        </form>
    </section>
@endsection
