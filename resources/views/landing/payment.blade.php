<div class="modal-header">
    <h4 class="modal-title">@if($method=="CC") Credit / Debit Card @elseif($method=="PP") PayPal @else Payment @endif
    </h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="error-message" id="amount-error"></div>
    <div class="error-message" id="name-error"></div>
    <div class="error-message" id="phone-error"></div>
    <div class="error-message" id="email-error"></div>
    <div class="row">
        <div class="col-lg-4">
            <h6>Payment Method :</h6>
        </div>
        <div class="col-lg-8">
            <div class="card shadow event-donate-payment">
                @if($method=="CC")
                <div class="text-center">
                    <img class="" src="{{ asset('resources/cardLogo.png') }}" style="height:20px;">
                </div>
                <div class="card-body text-center">
                    <b>Credit / Debit Card</b>
                </div>
                @elseif($method=="PP")
                <div class="text-center">
                    <img class="" src="{{ asset('resources/paypal.png') }}" style="height:20px;">
                </div>
                <div class="card-body text-center">
                    <b>Credit / Debit Card</b>
                </div>
                @endif
            </div>
        </div>

        <form id="paymentForm" action="{{ route('event.makepayment') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input id="event_id" type="hidden" class="form-control" value="{{ $record->id }}" name="event_id" required>
            @if($method=="CC")
            <input id="method" type="hidden" class="form-control" value="Credit Card" name="method" required>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">Enter Card Number :</div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <input id="cc1" type="number" class="form-control" name="cc1" required>

                        <div class="error-message" id="cc1-error"></div>
                    </div>
                    <div class="col-lg-3">
                        <input id="cc2" type="number" class="form-control" name="cc2" required>

                        <div class="error-message" id="cc2-error"></div>
                    </div>
                    <div class="col-lg-3">
                        <input id="cc3" type="number" class="form-control" name="cc3" required>

                        <div class="error-message" id="cc3-error"></div>
                    </div>
                    <div class="col-lg-3">
                        <input id="cc4" type="number" class="form-control" name="cc4" required>

                        <div class="error-message" id="cc4-error"></div>
                    </div>
                </div>
                <div>&nbsp;</div>
                <div class="row">
                    <div class="col-lg-5">Enter Card CVV :</div>
                    <div class="col-lg-7">Enter Card Expiry Date :</div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <input id="cvv" type="number" class="form-control" name="cvv" required>

                        <div class="error-message" id="cvv-error"></div>
                    </div>
                    <div class="col-lg-2">&nbsp;</div>
                    <div class="col-lg-3">
                        <input id="ex_m" type="number" class="form-control" name="ex_m" required>

                        <div class="error-message" id="ex_m-error"></div>
                    </div>
                    <div class="col-lg-1">/</div>
                    <div class="col-lg-3">
                        <input id="ex_y" type="number" class="form-control" name="ex_y" required>

                        <div class="error-message" id="ex_y-error"></div>
                    </div>
                </div>
                <div>&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12">Enter Card Holder Name :</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input id="card_name" type="text" class="form-control" name="card_name" required>

                        <div class="error-message" id="card_name-error"></div>
                    </div>
                </div>
            </div>
            @elseif($method=="PP")
            <input id="method" type="hidden" class="form-control" value="PayPal" name="method" required>
            {{-- <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">Enter Email :</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input id="pp_email" type="text" class="form-control" name="pp_email" required>

                        <div class="error-message" id="pp_email-error"></div>
                    </div>
                </div>
                <div>&nbsp;</div>
                <div class="row">
                    <div class="col-lg-12">Enter Password :</div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <input id="pp_password" type="password" class="form-control" name="pp_password" required>

                        <div class="error-message" id="pp_password-error"></div>
                    </div>
                </div>
            </div> --}}
            @endif
        </form>
    </div>


    <div>&nbsp;</div>

    <div class="text-center">
        <button type="button" class="btn btn-block btn-warning" onclick="submitPaymentModal('paymentForm');"><b>Pay
                Now</b></button>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
    function submitPaymentModal(form_id) {
        $("#view-overlay").show();
        var formData = new FormData($('#' + form_id)[0]);
        formData.append('amount', $("#amount").val());
        formData.append('name', $("#name").val());
        formData.append('phone', $("#phone").val());
        formData.append('email', $("#email").val());
        var formAction = $('#' + form_id).attr('action');
        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,
            processData: false, // Important: tell jQuery not to process the data
            contentType: false, // Important: tell jQuery not to set contentType
            success: function (data) {
                window.location.href = data.route;
            },
            error: function (xhr, status, error) {
                var form = document.getElementById(form_id);
                var elementsInsideForm = form.getElementsByClassName('form-control');
                for (var i = 0; i < elementsInsideForm.length; i++) {
                    elementsInsideForm[i].classList.remove('is-invalid');
                }
                $('.error-message').html("");
                $("#view-overlay").hide();
                var errors = xhr.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key + '-error').html(value[0]);
                });
            }
        });
    }
</script>