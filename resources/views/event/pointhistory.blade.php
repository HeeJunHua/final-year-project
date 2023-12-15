<div class="modal-header">
    <h4 class="modal-title">Point History</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
<table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Description</th>
        <th>Points</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @if($records->isEmpty())
      <tr>
        <td colspan="4" class="text-center">No records found</td>
      </tr>
      @else
      @foreach ($records as $key => $record)
      <tr>
        <td>@if($record->transaction_type=="CR") Donation - <b>{{ $record->event->event_name }}</b> @elseif($record->transaction_type=="DR") Redemption - <b>{{ $record->redemption->voucher->voucher_name }}</b> @else - @endif</td>
        <td>{{ $record->point }}</td>
        <td>@if($record->transaction_type=="CR") Earned @elseif($record->transaction_type=="DR") Redeemed @else - @endif</td>
        <td>{{ $record->created_at }}</td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>

  <div class="card-footer clearfix">
    {{ $records->appends(['search' => request('search'),'status' =>
    request('status')])->links('pagination.custom') }}
  </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>
  $(document).on('click', '.pagination a', function (e) {
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