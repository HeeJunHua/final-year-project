<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('theme/v1/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('theme/v1/dist/css/adminlte.min.css') }}">
<!-- Custom Style -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!-- AdminLTE App -->
<script src="{{ asset('theme/v1/dist/js/adminlte.min.js') }}"></script>
<!-- Custom Script -->
<script src="{{ asset('js/script.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('theme/v1/plugins/chart.js/Chart.min.js') }}"></script>

<script>
    @php
    $donated = 100;
    $left = 0;
    if ($record -> donations_sum_donation_amount < $record -> target_goal) {
        $donated = round($record -> donations_sum_donation_amount / $record -> target_goal * 100, 2);
        $left = 100 - $donated;
    }
    @endphp
    $(function () {
        //donut chart
        var donutChartCanvas = $('#chart').get(0).getContext('2d')
        var donutData = {
            labels: [
                'Fund Raised',
                'Pending'
            ],
            datasets: [
                {
                    data: [{{ $donated }}, {{ $left }}],
            backgroundColor: ['gold', 'lightgrey'],
    }
      ]
    }
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: false //no legend
        }
    }

    new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    })
  })

    @if ($record -> end_date > now())
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $record->end_date }}").getTime();

    // Update the countdown every 1 second
    var x = setInterval(function () {

        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the remaining time
        var distance = countDownDate - now;

        // Calculate days, hours, minutes, and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the countdown
        $("#day").html(days);
        $("#hour").html(hours);
        $("#minute").html(minutes);
        $("#second").html(seconds);

        // If the countdown is over, display a message
        if (distance < 0) {
            clearInterval(x);
            $("#day").html("0");
            $("#hour").html("0");
            $("#minute").html("0");
            $("#second").html("0");
        }
    }, 1000);
    @endif
</script>

<div>&nbsp;</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            @if(!empty($record->cover_image))
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('storage/events/' . $record->cover_image) }}"
                                    style="height:400px;">
                            </div>
                            @else
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('storage/events/default/default.png') }}"
                                    style="height:400px;">
                            </div>
                            @endif

                            <div style="color:#BFC5C2;">
                                <p><i class="fa fa-map-marker"></i> {{ $record->event_location }}</p>
                            </div>
                            <div>
                                <p>{{ $record->event_description }}</p>
                            </div>
                            <div class="landing-announcement">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p><b>Ograniser : </b>{{ $record->user->username }}</p>
                                    </div>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <div>
                                <p>Gallery:</p>
                            </div>
                            <div class="row">
                                @foreach ($record->eventImages as $key => $record1)
                                <div class="col-lg-4">
                                    <div class="card shadow landing-category">
                                        <div class="card-body">
                                            @if(!empty($record1->image_path))
                                            <div class="text-center">
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/event_attachment/' . $record1->image_path) }}"
                                                    style="height:200px;">
                                            </div>
                                            @else
                                            <div class="text-center">
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/event_attachment/default/default.png') }}"
                                                    style="height:200px;">
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="text-center">
                                <b>Time Remaining To Help</b>
                            </div>

                            <div>&nbsp;</div>

                            <table class="table">
                                <tr>
                                    <td class="text-center"><h1 id="day" class="countdown">0</h1></td>
                                    <td class="text-center"><h1 id="hour" class="countdown">0</h1></td>
                                    <td class="text-center"><h1 id="minute" class="countdown">0</h1></td>
                                    <td class="text-center"><h1 id="second" class="countdown">0</h1></td>
                                </tr>
                                <tr>
                                    <td class="text-center">DAYS</td>
                                    <td class="text-center">HOURS</td>
                                    <td class="text-center">MINUTES</td>
                                    <td class="text-center">SECONDS</td>
                                </tr>
                            </table>

                            <div>&nbsp;</div>

                            <div class="text-center">
                                <span>Event Start Date : {{ $record->start_date }}</span><br />
                                <span>Event End Date : {{ $record->end_date }}</span>
                            </div>

                            <div>&nbsp;</div>

                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-block btn-lg" style="padding:20px;">
                                    <h3>{{ $record->donations_count }} <small>Donors</small></h3>
                                </button>
                            </div>

                            <div>&nbsp;</div>

                            <div class="text-center">
                                Fund Raised So Far :
                            </div>


                            <canvas id="chart"
                                style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>

                            <div class="text-center">
                                <h3>{{ $donated }} %</h3>
                            </div>

                            <div class="text-center">
                                <h3>{{number_format($record -> donations_sum_donation_amount,2) ?? 0.00}} /
                                    {{number_format($record -> target_goal,2)}}</h3>
                            </div>

                            <div>&nbsp;</div>

                            <div class="text-center">
                                @if ($record -> end_date < now())
                                <a href="#" class="btn btn-danger btn-block"><b>Expired</b></a>
                                @elseif($record -> donations_sum_donation_amount >= $record -> target_goal)
                                <a href="#"
                                    class="btn btn-success btn-block"><b>Completed</b></a>
                                @else
                                <a href="{{ route('event.donate',$record->id)}}"
                                    class="btn btn-warning btn-block"><b>Donate Now</b></a>
                                @endif
                            </div>

                            <div>&nbsp;</div>

                            <div class="text-center">
                                <button type="button" class="btn btn-warning btn-block share-modal" data-toggle="modal"
                                    data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                                    data-modal-id="{{ $record->id }}">
                                    <b>Share</b>
                                </button>
                            </div>

                            <div>&nbsp;</div>

                            @if(!$record->donations->isEmpty())
                            <div>Recent Donations :</div>
                            @foreach ($record->donations as $key => $record1)
                            <div class="event-donor">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <i class="fa fa-heart" style="font-size:40px;color:red;"></i>
                                    </div>
                                    <div class="col-lg-6">
                                        <b>{{ $record1->user->username }}</b><br />
                                        MYR {{ $record1->donation_amount }}
                                    </div>
                                    <div class="col-lg-4" style="color:#929895;">
                                        {{ $record1->donation_date }}
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div>&nbsp;</div>

                            <div class="text-center">
                                <button type="button" class="btn btn-warning btn-block view-modal" data-toggle="modal"
                                    data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                                    data-modal-id="{{ $record->id }}">
                                    <b>See All Donations</b>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('modal/modal')

<script>
    $(document).ready(function () {
        //onclick for view
        $('.view-modal').on('click', function () {
            //id
            var id = $(this).data('modal-id');
            //route
            var url = "{{ route('event.getdonor', ['id' => ':id']) }}";
            //replace id
            url = url.replace(':id', id);
            var method = "GET";
            var modal_id = "modal-view";
            //show loading
            $("#view-overlay").show();
            $('#' + modal_id + ' .modal-content').html("");
            //get data
            viewModal(url, method, modal_id);
        });

        //onclick for view
        $('.share-modal').on('click', function () {
            //id
            var id = $(this).data('modal-id');
            //route
            var url = "{{ route('event.share', ['id' => ':id']) }}";
            //replace id
            url = url.replace(':id', id);
            var method = "GET";
            var modal_id = "modal-view";
            //show loading
            $("#view-overlay").show();
            $('#' + modal_id + ' .modal-content').html("");
            //get data
            viewModal(url, method, modal_id);
        });
    });
</script>