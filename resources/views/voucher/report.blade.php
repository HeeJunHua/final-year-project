<div class="modal-header">
  <h4 class="modal-title">Total Vouchers Report</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>Code</th>
        <th>Description</th>
        <th>Points</th>
        <th>Quantity Available</th>
        <th>Quantity Redeemed</th>
      </tr>
    </thead>
    <tbody>
      @if($records->isEmpty())
      <tr>
        <td colspan="5" class="text-center">No records found</td>
      </tr>
      @else
      @foreach ($records as $key => $record)
      <tr>
        <td>{{ $record->voucher_code }}</td>
        <td>{{ $record->voucher_description }}</td>
        <td>{{ $record->voucher_point_value }}</td>
        <td>{{ $record->voucher_quantity }}</td>
        <td>{{ $record->redemptions_count }}</td>
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