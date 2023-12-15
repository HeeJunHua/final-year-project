<!-- resources/views/emails/event_redistribution_declined.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Redistribution Declined</title>
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
            color: #dc3545;
        }

        p {
            line-height: 1.6;
        }

        .message {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 20px;
        }

        /* Add more styles as needed */
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Redistribution Declined</h1>
        </header>

        <main>
            <p>We regret to inform you that your event redistribution on {{ $eventRedistribution->event_date }} has been declined. If you have any questions or concerns, please reach out to us for further assistance.</p>

            <div class="message">
                <p>We appreciate your understanding and hope to work with you on future events.</p>
            </div>
        </main>

        <footer>
            <p>Thank you for considering our platform!</p>
        </footer>
    </div>
</body>
</html>
