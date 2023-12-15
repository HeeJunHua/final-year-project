<html>

<head>
    <title>Receipt</title>
    <script>
        // Trigger the print dialog when the page loads
        window.onload = function () {
            window.print();
        };
    </script>
</head>

<body>
    <div style="text-align:center;">
        <h1> Official Receipt </h1>
    </div>
    <div style="text-align:center;">
        <span> Fundraising Platform</span><br />
        <span> https://www.fundraising.com </span>
    </div>
    <div style="text-align:right;">
        <span> <b>OR-{{ date('Ymd',strtotime($record->donation_date)) }}{{$record->id}}</b> </span>
    </div>
    <div>&nbsp;</div>
    <hr />
    <div>&nbsp;</div>
    <div style="text-align:right;">
        <span><b>{{ date('l d F Y',strtotime($record->donation_date)) }}</b></span>
    </div>
    <div>&nbsp;</div>
    <div>
        <span><b>To : </b>{{ $record->name }}</span>
    </div>
    <div>&nbsp;</div>
    <div>
        <span><b>Phone : </b>{{ $record->phone }}</span>
    </div>
    <div>&nbsp;</div>
    <div>
        <span><b>Email : </b>{{ $record->email }}</span>
    </div>
    <div style="height:100px;">&nbsp;</div>
    <div>
        <span><b>From : </b>{{ $record->event->event_name }}</span>
    </div>
    <hr />
    <table style="width:100%;">
        <tr>
            <th style="width:50%;text-align:left;">Description</th>
            <th style="width:50%;text-align:left;">Amount (MYR)</th>
        </tr>
    </table>
    <hr />
    <table style="width:100%;">
        <tr>
            <td style="width:50%;text-align:left;">Donation - {{ $record->payment_method }}</td>
            <td style="width:50%;text-align:left;">{{ $record->donation_amount }}</td>
        </tr>
    </table>
    <div style="height:100px;">&nbsp;</div>
    <hr />
    <table style="width:100%;">
        <tr>
            <th style="width:50%;text-align:left;">Total Payment</th>
            <th style="width:50%;text-align:left;">{{ $record->donation_amount }}</th>
        </tr>
    </table>
    <hr />
    <div style="text-align:center;">
        <span>Thank You For Suppoting Us<br />This Receipt will be send to you email.</span>
    </div>
    <div>&nbsp;</div>
    <div style="text-align:center;">
        <a href="{{ route('fundraise_home_page')}}" class="btn btn-primary">Home</a>
    </div>
</body>

</html>