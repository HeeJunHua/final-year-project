<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donation</title>
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
        max-width: 800px; /* Adjusted width for better readability */
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
    textarea,
    button {
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

    .table th, .table td {
        text-align: center;
    }

    .table tfoot td {
        font-weight: bold;
    }

    .foodDonation {
        min-height: 500px;
    }

    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success"  style="margin-bottom: 0px;" id="successAlert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-success"  style="margin-bottom: 0px;" id="successAlert">
            {{ session('error') }}
        </div>
    @endif

    <section class="container foodDonation">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Food Donation</h3>
            <a href="{{ route('food_items.create') }}" class="btn btn-primary">Create Food Item</a>
        </div>
        @if($foodItems->isEmpty())
            <p>No food items available.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Item Name</th>
                        <th>Expiry Date</th>
                        <th>Category</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foodItems as $foodItem)
                        <tr>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('food_items.edit', $foodItem) }}" class="btn btn-sm btn-primary mx-4">Edit</a>
                                    <form action="{{ route('food_items.destroy', $foodItem) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                            <td>{{ $foodItem->food_item_name }}</td>
                            <td>{{ $foodItem->food_item_expiry_date }}</td>
                            <td>{{ $foodItem->food_item_category }}</td>
                            <td>{{ $foodItem->food_item_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">Total Items :</td>
                        <td>{{ $foodItems->sum('food_item_quantity') }}</td>
                    </tr>
                </tfoot>
            </table>
        <div class="makeDonationBtn mx-auto mt-5">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#donationModal">Make Donation</button>
        </div>
        @endif
    </section>

    <div class="modal fade" id="donationModal" tabindex="-1" role="dialog" aria-labelledby="donationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title col-md-10" id="donationModalLabel">Make Donation</h5>
                    <button type="button" class="close col-md-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to make a donation?</p>
                    <p>Please acknowledge that donations are final and cannot be undone.</p>
                </div>
                <div class="modal-footer mx-auto">
                    <div class="mt-5">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('food_items.makeDonation') }}" class="btn btn-success">Make Donation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
