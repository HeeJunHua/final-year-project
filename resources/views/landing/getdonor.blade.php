<div class="modal-header">
    <h4 class="modal-title">All Donors</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
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
    @if ($record -> end_date < now())
    <a href="#" class="btn btn-danger"><b>Expired</b></a>
    @elseif($record -> donations_sum_donation_amount >= $record -> target_goal)
    <a href="#"
        class="btn btn-success"><b>Completed</b></a>
    @else
    <a href="{{ route('event.donate',$record->id)}}"
        class="btn btn-warning"><b>Donate Now</b></a>
    @endif
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>