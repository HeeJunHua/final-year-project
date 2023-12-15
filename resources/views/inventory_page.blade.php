<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Page</title>
    @include('top_nav_bar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .inventoryContainer {
            background-color: #ffffff;
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            min-height: 500px;
        }

        h1, h2 {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #545b62;
        }

        .alert {
            margin-top: 20px;
        }

        .no-events {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
        }

        .no-events a {
            color: white;
        }

        .no-events a:hover {
            text-decoration: underline;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 8px;
            border: none;
        }

        th {
            background-color: #007bff;
            color: black;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .status-in-stock {
            color: #28a745;
        }

        .status-low-stock {
            color: #ffc107;
        }

        .status-out-of-stock {
            color: #dc3545;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .filter-btn {
            padding: 8px;
            border-radius: 5px;
            background-color: #007bff;
            border: 1px solid #007bff;
            color: white;
        }

        .filter-btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .actions-btns a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
        }

        .actions-btns a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container inventoryContainer">
        <h1>Your Inventory</h1>
        <div class="mb-4 row">
            <div class="col-md-6">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search...">
                    <button class="filter-btn">Filter</button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('inventory.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>

        @if(!$products->isEmpty())
            <table class="table table-striped">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->product_category }}</td>
                            <td>{{ $product->product_description }}</td>
                            <td>{{ $product->product_quantity }}</td>
                            <td>{{ $product->product_expiry_date }}</td>
                            <td>{{ $product->product_status }}</td>
                            <td class="actions-btns">
                                <a href="{{ route('inventory.edit', ['product' => $product->id]) }}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventory.destroy', $product) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-events">
                <p>Your inventory is currently empty.</p>
            </div>
        @endif
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
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
