@section('title')
Reports
@endsection

@section('page_title')
Reports
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-warning card-outline">
        <div class="card-header">
          <h3 class="card-title">Filter</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('event.index') }}" method="GET">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="search">Search:</label>
                  <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="status">Status:</label>
                  <select name="status" class="form-control">
                    @foreach ($status as $key => $value)
                    <option value="{{ $key }}" {{ request('status')==$key ? 'selected' : '' }}>{{ $value }}</option>
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
        <div class="col-lg-4">
          <div class="form-group" style="font-size:20px;">
            <i class="fas fa-donate"></i> <b>Total Fund Raised : {{ number_format($total,2) }}</b>
          </div>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Event Listing</h5>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th style="width:10px;">No</th>
                <th>Event Category</th>
                <th>Event Name</th>
                <th>Fund Goals</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if($records->isEmpty())
              <tr>
                <td colspan="7" class="text-center">No records found</td>
              </tr>
              @else
              @foreach ($records as $key => $record)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $record->category->category_name }}</td>
                <td>{{ $record->event_name }}</td>
                <td>{{ number_format($record->target_goal, 2) }}</td>
                <td>{{ $record->start_date }}</td>
                <td>{{ $record->end_date }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success view-modal" data-toggle="modal"
                      data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                      data-modal-id="{{ $record->id }}">
                      <i class="fas fa-file"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
        <div class="card-footer clearfix">
          {{ $records->appends(['search' => request('search'),'status' =>
          request('status')])->links('pagination.custom') }}
        </div>
      </div>
    </div>
  </div>
</div>

@include('modal/modal')

<script>
  $(document).ready(function () {
    //onclick for view
    $('.view-modal').on('click', function () {
      //id
      var id = $(this).data('modal-id');
      //route
      var url = "{{ route('event.reportdetail', ['id' => ':id']) }}";
      //replace id
      url = url.replace(':id', id);
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
@endsection