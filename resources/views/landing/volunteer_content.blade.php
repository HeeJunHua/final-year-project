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

<div>&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-body">
                    <h4>Register as Volunteer : {{ $announcement->event->event_name }}</h4>

                    <form action="{{ route('event.storevolunteer', ['announcement' => $announcement]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>
                                        <input id="name" type="text" class="form-control" name="name"
                                            value="{{ old('name', auth()->user()->username) }}" required>

                                        @error('name')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>
                                        <input id="phone" type="text" class="form-control" name="phone"
                                            value="{{ old('phone', auth()->user()->contact_number) }}" required>

                                        @error('phone')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input id="email" type="text" class="form-control" name="email"
                                            value="{{ old('email', auth()->user()->email) }}" required>

                                        @error('email')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Skill</th>
                                    <td>
                                        <input id="skill" type="text" class="form-control" name="skill"
                                            value="{{ old('skill') }}" required>

                                        @error('skill')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Interests</th>
                                    <td>
                                        <input id="interest" type="text" class="form-control" name="interest"
                                            value="{{ old('interest') }}" required>

                                        @error('interest')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Event Start Date</th>
                                    <td>{{ $announcement->event->start_date }}</td>
                                </tr>
                                <tr>
                                    <th>Event End Date</th>
                                    <td>{{ $announcement->event->end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Availability Start Date</th>
                                    <td>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ old('start_date') }}" required>

                                        @error('start_date')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th>Availability End Date</th>
                                    <td>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ old('end_date') }}" required>

                                        @error('end_date')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-warning"><b>Register</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
