<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Redistribution Dashboard</title>
    @include('top_nav_bar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }

        .redistributionContainer {
            margin-top: 20px;
        }

        h2 {
            color: #007bff;
        }

        .mb-4 a {
            text-decoration: none;
        }

        .mb-4 a:hover {
            text-decoration: underline;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background-color: #007bff;
            color: black;
            font-weight: bold;
            padding: 1rem;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #007bff;
        }

        .btn-danger {
            color: #fff;
        }

        p {
            margin-bottom: 10px;
        }

        .no-events {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #555;
        }

        .redistributionContainer {
            min-height: 500px;
        }

        .event-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-details {
            flex: 1;
            padding-right: 20px;
        }

        .event-details p {
            margin-bottom: 5px;
        }

        .event-actions {
            display: flex;
            align-items: center;
        }

        .event-actions form {
            margin-left: 10px;
            display: flex;
            align-items: center;
        }

        .event-actions form button {
            margin-left: 10px;
        }
    </style>

</head>

<body>
    <div class="container redistributionContainer">

        <div class="mb-4 row">
            <div class="col-md-10">
                <h2>Event Redistribution</h2>
            </div>
            <div class="col-md-2">
                <a href="{{ route('events.create') }}" class="btn btn-primary">Create New Event</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Your Events</h3>
            </div>
            <div class="card-body">
                @forelse($events as $event)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="event-info">
                                <div class="event-details">
                                    <h5 class="card-title">
                                        <a href="{{ route('redistribution.page', $event->id) }}">{{ $event->event_name }}</a>
                                    </h5>
                                    <p>Description: {{ $event->leftovers_description }}</p>
                                    <p>Status: {{ ucfirst($event->status) }}</p>
                                    <p>Redistribution Date: {{ $event->event_date }}</p>
                                    <p>Location: {{ $event->location }}</p>
                                    <p>Food Amount: {{ $event->food_amount }} {{ $event->food_amount_unit }}</p>
                                    <p>People Quantity: {{ $event->people_quantity }}</p>
                                    <p>Leftovers Description: {{ $event->leftovers_description }}</p>
                                </div>
                                <div class="event-actions">
                                    <form action="{{ route('events.edit', $event->id) }}" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Edit</button>
                                    </form>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-events">
                        <p>No events created yet.</p>
                        <a href="{{ route('events.create') }}" class="btn btn-primary mt-3">Create New Event</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>

<footer>
    @include('bot_nav_bar')
</footer>

</html>
