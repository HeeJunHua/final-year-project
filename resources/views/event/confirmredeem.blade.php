<div class="modal-header">
    <h4 class="modal-title redeem">Confirmation</h4>
    <h4 class="modal-title code" style="display:none;">Voucher Redemption Successful !</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row redeem">
        <div class="col-lg-12 text-center">
            <h1>Confirm To Redeem?</h1>
        </div>
    </div>
    <div class="row code" style="display:none;">
        <div class="col-lg-12 text-center">
            <h1>Code : {{ $voucher->voucher_code }}</h1>
            <h4 style="color:#929895;">Expiry Date : {{ $voucher->voucher_expiry_date }}</h4>
        </div>
    </div>
    <div class="row redeem">
        <div class="col-lg-6 text-right"><button type="button" class="btn btn-success btn-block" onclick="confirmation('1')">Yes</div>
        <div class="col-lg-6"><button type="button" class="btn btn-danger btn-block" onclick="confirmation('0')" data-dismiss="modal">No</button></div>
    </div>
</div>
<div class="modal-footer justify-content-between code" style="display:none;">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<input type="hidden" id="confirm" value="0"/>

<script>
  $(document).ready(function () {
    $('#modal-view').on('hidden.bs.modal', function () {
        if($("#confirm").val()=="1"){
            window.location.href = "{{ $route }}";
        }
    });
  });

  function confirmation(value){
    $("#confirm").val(value);

    if(value=="1"){
        $(".redeem").hide();
        $(".code").show();
    }
  }
</script>