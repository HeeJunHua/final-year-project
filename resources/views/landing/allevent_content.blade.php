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
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Filter</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('event.allevent', $status) }}" method="GET">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="search">Search:</label>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select name="category" class="form-control">
                                        <option value="All" {{ request('category')=="All" ? 'selected' : '' }}>All
                                        </option>
                                        @foreach ($category as $key => $value)
                                        <option value="{{ $key }}" {{ request('category')==$key ? 'selected' : '' }}>{{
                                            $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <a href="{{ route('event.allevent', 'Ongoing')}}"
                            class="btn {{ request()->is('allevent/Ongoing*') ? 'btn-warning' : 'btn-default' }} btn-lg">Ongoing</a>
                        <a href="{{ route('event.allevent', 'Clear')}}"
                            class="btn {{ request()->is('allevent/Clear*') ? 'btn-warning' : 'btn-default' }} btn-lg">Completed</a>
                        <a href="{{ route('event.allevent', 'Pass')}}"
                            class="btn {{ request()->is('allevent/Pass*') ? 'btn-warning' : 'btn-default' }} btn-lg">Expired</a>
                    </div>
                </div>
            </div>

            <div class="card card-success shadow">
                <div class="card-header">
                    <h3 class="card-title"><b>@if($status=="Ongoing") Ongoing Event @elseif($status=="Clear") Completed
                            Event @elseif($status=="Pass") Expired Event @else Event @endif</b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                        $class = "btn-default";
                        $word = "MORE DETAIL";
                        switch($status){
                        case "Pass":
                        $class = "btn-danger";
                        break;
                        case "Ongoing":
                        $word = "DONATE NOW";
                        $class = "btn-success";
                        break;
                        }
                        @endphp
                        @foreach ($events as $key => $record)
                        <div class="col-lg-3">
                            <div class="card shadow landing-event">
                                <div class="card-body">
                                    @if(!empty($record->cover_image))
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
                                                aria-valuenow="{{ round($record->donations_sum_donation_amount / $record->target_goal * 100,2) }}"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width: {{ round($record->donations_sum_donation_amount / $record->target_goal * 100,2) }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="color:#BFC5C2;">
                                        @php
                                        $percent = round($record->donations_sum_donation_amount / $record->target_goal *
                                        100,2);
                                        if($percent>100){
                                        $percent = 100;
                                        }
                                        @endphp
                                        <p>{{ $percent }}% Complete</p>
                                    </div>

                                    <div class="form-group text-center">
                                        <a href="{{ route('event.detail',$record->id)}}"
                                            class="btn {{ $class }}  landing-event"><b>{{ $word }}</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {{ $events->appends(['search' => request('search'),'category' =>
                    request('category')])->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>