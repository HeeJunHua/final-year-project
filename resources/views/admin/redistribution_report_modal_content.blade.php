<div class="report-section">
    <h4>Food Redistribution Details</h4>
    <table class="table">
        <tr>
            <th>Event Name</th>
            <td>{{ $redistribution->event_name }}</td>
        </tr>
        <tr>
            <th>Event Date</th>
            <td>{{ $redistribution->event_date }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $redistribution->location }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $redistribution->status }}</td>
        </tr>
    </table>
</div>

<div class="report-section">
    <h4>User Information</h4>
    <table class="table">
        <tr>
            <th>First Name</th>
            <td>{{ $redistribution->user->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $redistribution->user->last_name }}</td>
        </tr>
        <tr>
            <th>Contact Number</th>
            <td>{{ $redistribution->user->contact_number }}</td>
        </tr>
    </table>
</div>

<div class="report-section">
    <h4>People Quantity and Leftovers Description</h4>
    <table class="table">
        <tr>
            <th>People Quantity</th>
            <td>{{ $redistribution->people_quantity }}</td>
        </tr>
        <tr>
            <th>Leftovers Description</th>
            <td>{{ $redistribution->leftovers_description }}</td>
        </tr>
    </table>
</div>

<div class="report-divider"></div>

<div class="report-section">
    <h4>Food Items Distributed</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Food Item</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($redistribution->foodItems as $foodItem)
                <tr>
                    <td>{{ $foodItem->food_item_name }}</td>
                    <td>{{ $foodItem->food_item_quantity }}</td>
                    <td>{{ $foodItem->food_item_category }}</td>
                    <td>
                        @if ($foodItem->has_expiry_date)
                            {{ $foodItem->food_item_expiry_date }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Number of Food Items: {{ $redistribution->foodItems->sum('food_item_quantity') }}</p>
</div>

<div class="report-divider"></div>
