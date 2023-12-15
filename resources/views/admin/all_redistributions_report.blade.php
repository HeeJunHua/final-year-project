@php
    $currentUser = null;
@endphp

@foreach ($allRedistributions as $redistribution)
    @if ($redistribution->user->id !== $currentUser)
        @php
            $currentUser = $redistribution->user->id;
        @endphp

        <h4>User: {{ $redistribution->user->username }}</h4>
        <div class="report-section">
            <h3>User Details</h3>
            <table>
                <tr>
                    <th>User ID</th>
                    <td>{{ $redistribution->user->id }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $redistribution->user->email }}</td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>{{ $redistribution->user->contact_number ?: 'N/A' }}</td>
                </tr>
                <!-- Add other user details you want to include -->
            </table>
        </div>
    @endif

    <div class="report-section">
        <h4>Event Details</h4>
        <table>
            <tr>
                <th>Event Name</th>
                <td>{{ $redistribution->event_name }}</td>
            </tr>
            <tr>
                <th>Event Status</th>
                <td>{{ $redistribution->status }}</td>
            </tr>
            <tr>
                <th>Event Date</th>
                <td>{{ $redistribution->event_date }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $redistribution->location }}</td>
            </tr>
        </table>

        <div class="report-divider"></div>

        <h4>People and Leftovers</h4>
        <table>
            <tr>
                <th>People Quantity</th>
                <td>{{ $redistribution->people_quantity }}</td>
            </tr>
            <tr>
                <th>Leftovers Description</th>
                <td>{{ $redistribution->leftovers_description ?: 'N/A' }}</td>
            </tr>
        </table>

        <div class="report-divider"></div>

        <h4>Food Items Distributed</h4>
        <table>
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
@endforeach
