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
                    <h4>Donating To : {{ $record->event_name }}</h4>

                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td><input id="name" type="text" class="form-control" name="name"
                                        value="{{ auth()->user()->username }}" required></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td><input id="phone" type="text" class="form-control" name="phone"
                                        value="{{ auth()->user()->contact_number }}" required></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input id="email" type="text" class="form-control" name="email"
                                        value="{{ auth()->user()->email }}" required></td>
                            </tr>
                        </tbody>
                    </table>

                    <hr style="border-top: 2px solid black;" />

                    Donation Amount :

                    <div>&nbsp;</div>

                    <div class="row">
                        @foreach ($amount as $record1)
                        <div class="col-lg-2" onclick="amount({{ $record1 }})" style="cursor:pointer;">
                            <div class="card shadow event-donate">
                                <div class="card-body text-center">
                                    <b>MYR<br />{{ number_format($record1,2) }}</b>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div>&nbsp;</div>

                    <div class="row event-donate-pay">
                        <div class="col-lg-2 text-right">
                            <b>MYR</b>
                        </div>
                        <div class="col-lg-10">
                            <input id="amount" type="number" class="form-control" name="amount" placeholder="0.00"
                                required>
                        </div>
                    </div>

                    <div style="color:#929895;">Points Earned : <span id="point">0</span></div>

                    <div>&nbsp;</div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card bg-warning shadow">
                                <div class="card-body text-center">
                                    Total Pay : <b>MYR <span id="total">0.00</span></b>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="border-top: 2px solid black;" />

                    Payment Method :

                    <div>&nbsp;</div>

                    <div class="row">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-block cc-modal" data-toggle="modal"
                                data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                                data-modal-id="{{ $record->id }}">
                                <div class="card shadow event-donate-paymentmethod">
                                    <div class="text-center">
                                        <img class="" src="{{ asset('resources/cardLogo.png') }}" style="height:40px;">
                                    </div>
                                    <div class="card-body text-center">
                                        <b>Credit / Debit Card</b>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-block pp-modal" data-toggle="modal"
                                data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                                data-modal-id="{{ $record->id }}">
                                <div class="card shadow event-donate-paymentmethod">
                                    <div class="text-center">
                                        <img class="" src="{{ asset('resources/paypal.png') }}" style="height:40px;">
                                    </div>
                                    <div class="card-body text-center">
                                        <b>PayPal</b>
                                    </div>
                                </div>
                            </button>
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
        // Attach a keyup event handler to the input text box
        $("#amount").on("keyup", function () {
            // Get the value entered in the text box
            var inputValue = $(this).val();
            //calculate point
            var point = parseFloat(inputValue) / 10;
            //rounding
            point = Math.floor(point);

            // Update total element
            $("#total").html(inputValue);
            // Update point element
            $("#point").html(point);
        });

        $('.cc-modal').on('click', function () {
            //id
            var id = $(this).data('modal-id');
            //route
            var url = "{{ route('event.payment', ['id' => ':id','method' => ':method']) }}";
            //replace id
            url = url.replace(':id', id);
            //replace method
            url = url.replace(':method', 'CC');
            var method = "GET";
            var modal_id = "modal-view";
            //show loading
            $("#view-overlay").show();
            $('#' + modal_id + ' .modal-content').html("");
            //get data
            viewModal(url, method, modal_id);
        });

        $('.pp-modal').on('click', function () {
            //id
            var id = $(this).data('modal-id');
            //route
            var url = "{{ route('event.payment', ['id' => ':id','method' => ':method']) }}";
            //replace id
            url = url.replace(':id', id);
            //replace method
            url = url.replace(':method', 'PP');
            var method = "GET";
            var modal_id = "modal-view";
            //show loading
            $("#view-overlay").show();
            $('#' + modal_id + ' .modal-content').html("");
            //get data
            viewModal(url, method, modal_id);
        });
    });

    function amount(value) {
        $("#amount").val(value);
        $("#total").html(value);

        //calculate point
        var point = parseFloat(value) / 10;
        //rounding
        point = Math.floor(point);
        // Update point element
        $("#point").html(point);
    }
</script>