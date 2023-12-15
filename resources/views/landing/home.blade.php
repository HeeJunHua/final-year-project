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

<div>&nbsp;</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-success shadow">
                <div class="card-header">
                    <h3 class="card-title"><b>Trending Events</b></h3>

                    <div class="card-tools">
                        <a href="{{ route('event.allevent', 'Ongoing') }}" class="btn btn-success  landing-event"><b>See
                                More</b></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($events as $key => $record)
                            <div class="col-lg-3">
                                <div class="card shadow landing-event">
                                    <div class="card-body">
                                        @if (!empty($record->cover_image))
                                            <div class="text-center">
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/events/' . $record->cover_image) }}"
                                                    style="height:400px;">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/events/default/default.png') }}"
                                                    style="height:400px;">
                                            </div>
                                        @endif

                                    </div>
                                    <div class="card-footer clearfix">
                                        <div class="text-center">
                                            <h5>{{ $record->event_name }}</h5>
                                        </div>
                                        <div class="text-center">
                                            <p>{{ $record->event_description }}</p>
                                        </div>
                                        <div style="color:#BFC5C2;">
                                            <p><i class="fa fa-map-marker"></i> {{ $record->event_location }}</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    aria-valuenow="{{ round(($record->donations_sum_donation_amount / $record->target_goal) * 100, 2) }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ round(($record->donations_sum_donation_amount / $record->target_goal) * 100, 2) }}%">
                                                </div>
                                            </div>
                                        </div>
                                        <div style="color:#BFC5C2;">
                                            <p>{{ round(($record->donations_sum_donation_amount / $record->target_goal) * 100, 2) }}%
                                                Complete</p>
                                        </div>

                                        <div class="form-group text-center">
                                            <a href="{{ route('event.detail',$record->id)}}" class="btn btn-success  landing-event"><b>DONATE NOW</b></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-warning shadow">
                <div class="card-header">
                    <h3 class="card-title"><b>Trending Annoucements</b></h3>
                </div>
                <div class="card-body">
                    @foreach ($announcements as $key => $record)
                        <div class="landing-announcement">
                            <div class="row">
                                <div class="col-lg-8">
                                    <p><b>{{ $record->event->event_name }}</b></p>
                                    <p>Message : {{ $record->ann_text }}</p>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <button type="button" class="btn btn-warning view-modal" data-toggle="modal"
                                        data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                                        data-modal-id="{{ $record->id }}">
                                        More Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary shadow">
                <div class="card-header">
                    <h3 class="card-title"><b>Fundraise Categories</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($category as $key => $record1)
                            <div class="col-lg-2">
                                <div class="card shadow landing-category">
                                    <a href="{{ route('event.allevent', ['status' => 'Ongoing', 'search' => '', 'category' => $record1->id]) }}">
                                        <div class="card-body">
                                            @if (!empty($record1->image_path))
                                                <div class="text-center">
                                                    <img class="img-thumbnail"
                                                        src="{{ asset('storage/categories/' . $record1->image_path) }}"
                                                        style="height:60px;">
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <img class="img-thumbnail"
                                                        src="{{ asset('storage/categories/default/default.png') }}"
                                                        style="height:60px;">
                                                </div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="card-footer clearfix">
                                        <div class="text-center">
                                            <h6>
                                                <a href="{{ route('event.allevent', ['status' => 'Ongoing', 'search' => '', 'category' => $record1->id]) }}">{{ $record1->category_name }}</a>
                                            </h6>
                                        </div>
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

@include('modal/modal')

<script>
    $(document).ready(function() {
        //onclick for view
        $('.view-modal').on('click', function() {
            //id
            var id = $(this).data('modal-id');
            //route
            var url = "{{ route('announcementDetail', ['id' => ':id']) }}";
            //replace id
            url = url.replace(':id', id);
            console.log(url);
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
