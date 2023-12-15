@extends('layouts.app')

@section('title')
    <title>Inventory Page</title>
@endsection

@section('style')
@endsection

@section('content')
    <div class="container inventoryContainer m-4">
        <div class="card mb-4 card-primary card-outline">
            <div class="card-header">
                <h5 class="mb-0">Welcome to Our Inventory Management Page</h5>
            </div>
            <div class="card-body">
                <p>
                    Thank you for using our Inventory Management Page. This page allows you to manage and keep track of your inventory effectively.
                </p>
                <p>
                    Here, you can add, edit, and delete products in your inventory. The inventory page helps you maintain accurate records of your products, including details like product name, category, description, quantity, and expiry date.
                </p>
                <p>
                    Utilize the search and filter options to find specific products quickly. If your inventory is empty, you can start by adding your first product.
                </p>
                <p>
                    You if your product is good or near expiry, you can choose to donate for food donation. You can find your item at <a href="{{ route('food.donation')}}">food donaton page</a>.
                </p>
                
            </div>
            <div class="card-footer">
                <div class="row mt-2">
                    <div class="col-lg-4">
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add Product</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.index') }}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="search">Search:</label>
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Product Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="filterBy">Filter By :</label>
                                <select name="filterBy" class="form-control">
                                    <option value="all">All</option>
                                    <option value="expired">Expired</option>
                                    <option value="near_expiring">Expiring This Week</option>
                                    <option value="good">Good</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 mt-3">
                            <button type="submit" class="btn btn-primary ml-3">Search</button>
                        </div>
                    </div>
                </form>
            </div>                     
        </div>
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_name']) }}">Product Name</a></th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_category']) }}">Category</a></th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_description']) }}">Description</a></th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_quantity']) }}">Quantity</a></th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_expiry_date']) }}">Expiry Date</a></th>
                        <th><a href="{{ route('inventory.index', ['sortBy' => 'product_status']) }}">Status</a></th>
                        <th>Actions</th>
                        <th>Donate</th>
                    </tr>
                </thead>                
                <tbody>
                    @if(!$products->isEmpty())
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->product_category }}</td>
                            <td>{{ $product->product_description }}</td>
                            <td>{{ $product->product_quantity }}</td>
                            <td>{{ $product->product_expiry_date }}</td>
                            <td>{{ $product->product_status }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('inventory.edit', ['id' => $product->id]) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventory.destroy', $product) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @if ($product->product_status == 'near_expiry' || $product->product_status == 'good')
                                <td>
                                    <form action="{{ route('inventory.donate', $product) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Donate">
                                            <i class="fas fa-gift fa-fw"></i>
                                        </button>
                                    </form>
                                </td>
                            @elseif ($product->product_status == 'donated')
                                <td>
                                    <span class="text-success"><i class="fas fa-check fa-fw"></i> Donated</span>
                                </td>
                            @else
                                <td>
                                    <span class="text-danger"><i class="fas fa-times fa-fw"></i>Expired</span>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center">
                            <p>Your inventory is currently empty or there is no product in the filter option.</p>
                        </div>
                    </tr>
                @endif
                </tbody>
            </table>
        
    </div>

    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
@endsection