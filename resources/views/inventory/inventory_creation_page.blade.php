@extends('layouts.fundraise_layout')

@section('title')
    <title>Create Product Page</title>
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
        <h3 class="text-center mb-4">Product Creation</h3>

        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" class="form-control @error('product_name') is-invalid @enderror" required>
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
                @error('product_category')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea name="description" id="description"
                    class="form-control @error('description') is-invalid @enderror" rows="3" required></textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date"
                    class="form-control @error('expiry_date') is-invalid @enderror" required>
                @error('expiry_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Product Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control @error('quantity') is-invalid @enderror" min="1" required>
                @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary col-md-6 mt-4">Create Product</button>
            </div>
        </form>
    </section>
@endsection
