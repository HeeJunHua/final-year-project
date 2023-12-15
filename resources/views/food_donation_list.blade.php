@section('title')
Food Donation History
@endsection

@section('page_title')
Food Donation History
@endsection

@extends('layouts.dashboard')
@section('content')
<!-- Include Bootstrap CSS (Assuming you have Bootstrap installed) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background-image: url('background.jpg'); /* Replace with your image */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        overflow: hidden;
    }

    .donatedContainer {
        animation: fadeIn 1s ease-out;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8);
        margin: 10px;
    }

    .table {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
    }

    .table th,
    .table td {
        text-align: center;
        padding: 12px;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color: #cce5ff;
        transition: background-color 0.3s ease;
    }

    .intro-text {
        margin-bottom: 20px;
        font-size: 18px;
        color: #4c4c4c;
        animation: slideInUp 1s ease-out;
    }

    .thanks-text {
        margin-top: 20px;
        font-size: 16px;
        color: #6c757d;
        animation: fadeIn 1s ease-out;
    }

    /* Keyframes for animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<body>
    <div class="donatedContainer">
        <h2 class="mb-4">Your Generosity in Action</h2>
        <p class="intro-text">Here's a list of the food items you've generously donated to those in need. Your contributions make a meaningful impact on the lives of others. Thank you for spreading kindness and making the world a better place!</p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Food Item</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $index => $donation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $donation->food_donation_date }}</td>
                        <td>{{ $donation->foodItem->food_item_name }}</td>
                        <td>{{ $donation->food_donation_status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No donations found. Your kindness is truly appreciated!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <p class="thanks-text">Thank you for making a difference in the world!</p>
    </div>
</body>

@endsection