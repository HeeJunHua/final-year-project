<!-- ChartJS -->
<script src="{{ asset('theme/v1/plugins/chart.js/Chart.min.js') }}"></script>

<script>
    $(function() {
        const donors = @json($latestDates);
        const donatedAmount = @json($totalcount);

        //line chart
        const ctx = document.getElementById('linechart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: donors.map(donor => `${donor}`),
                datasets: [{
                    label: 'Latest 10 Day Volunteer Register',
                    data: donatedAmount,
                    borderColor: '#32A660',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    })
</script>

<div class="modal-header">
    <h4 class="modal-title">Report</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table">
        <tbody>
            <tr>
                <th>Event Name</th>
                <td>{{ $record->event_name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $record->start_date }} - {{ $record->end_date }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $record->event_location }}</td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <div>
                    <h5><b>Total Volunteers</b></h5>
                </div>

                <div style="color:#4caf50;">
                    <h1><b>{{ $record->volunteer_count }}</b></h1>
                </div>
            </div>
        </div>
    </div>

    <canvas id="linechart" style="max-width: 100%;"></canvas>

    @if (!$record->volunteer->isEmpty())
        <div>
            <h5><b>All Volunteers</b></h5>
        </div>

        @foreach ($record->volunteer as $key => $record1)
            <div class="event-donor">
                <div class="row">
                    <div class="col-lg-2">
                        <i class="fa fa-heart" style="font-size:40px;color:red;"></i>
                    </div>
                    <div class="col-lg-6">
                        <b>{{ $record1->name }}</b><br />
                    </div>
                    <div class="col-lg-4" style="color:#929895;">
                        {{ $record1->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
    $(document).on('click', '.pagination a', function(e) {
        //prevent redirect
        e.preventDefault();
        //pagination url
        var url = $(this).attr('href');
        var method = "GET";
        var modal_id = "modal-view";
        //get data
        viewModal(url, method, modal_id);
        //unbind the click
        $(document).off('click', '.pagination a');
    });
</script>
