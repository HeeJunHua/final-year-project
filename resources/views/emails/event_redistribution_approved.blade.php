<!-- resources/views/emails/event_redistribution_approved.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Redistribution Approved</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        p {
            line-height: 1.6;
        }

        .message {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Redistribution Approved</h1>
        </header>

        <main>
            <p>Your event redistribution on {{ $eventRedistribution->event_date }} has been accepted. We are excited to see your contribution to the event!</p>

            <div class="message">
                <p>If you would like to complete your event redistribution, please visit the following link:</p>
                <div class="button">
                    <a href="{{ route('complete.event.redistribution', ['id' => $eventRedistribution->id]) }}" style="color: #fff; text-decoration: none;">Complete Event Redistribution</a>
                </div>
            </div>

            <p>If you have any questions or need further assistance, feel free to contact our support team.</p>
        </main>

        <footer>
            <p>Thank you for using our service!</p>
        </footer>
    </div>
</body>
</html>
