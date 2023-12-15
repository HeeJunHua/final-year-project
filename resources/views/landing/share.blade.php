<div class="modal-header">
    <h4 class="modal-title">Share</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" id="part1">
    <div>Caption : </div>
    <div class="row">
        <div class="col-lg-12">
            <textarea id="caption" name="caption" class="form-control" rows="3" required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center" style="padding:10px;">
            <img src="{{ asset('resources/fbLogo.png') }}" style="width:30px;margin:5px;cursor:pointer;"
                onclick="share();">
            <img src="{{ asset('resources/IGLogo.png') }}" style="width:30px;margin:5px;cursor:pointer;"
                onclick="share();">
            <img src="{{ asset('resources/WsLogo.png') }}" style="width:30px;margin:5px;cursor:pointer;"
                onclick="share();">
        </div>
    </div>
</div>
<div class="modal-body" id="part2" style="display:none;">
    <div class="col-lg-12 text-center">
        <h3>Thanks For Sharing</h3>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
    function share() {
        $("#part1").hide();
        $("#part2").show();
    }
</script>