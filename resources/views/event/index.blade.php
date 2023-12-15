@section('title')
@if(auth()->user()->user_role=="admin")
Event Management
@else
Fundraising Event
@endif
@endsection

@section('page_title')
@if(auth()->user()->user_role=="admin")
Event Management
@else
Fundraising Event
@endif
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
          <div class="form-group">
            <button type="button" class="btn btn-warning add-modal" data-toggle="modal" data-target="#modal-edit"
              data-backdrop="static" data-keyboard="false">
              <i class="fas fa-plus"></i></button>
          </div>
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
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if($records->isEmpty())
              <tr>
                <td colspan="8" class="text-center">No records found</td>
              </tr>
              @else
              @foreach ($records as $key => $record)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $record->category->category_name }}</td>
                <td><a href="{{ route('event.detail',$record->id)}}">{{ $record->event_name }}</a></td>
                <td>{{ number_format($record->target_goal, 2) }}</td>
                <td>{{ $record->event_status }}</td>
                <td>{{ $record->start_date }}</td>
                <td>{{ $record->end_date }}</td>
                <td>
                  <div class="btn-group" role="group">
                    @if(auth()->user()->user_role=="admin")
                    <button type="button" class="btn btn-warning edit-modal" data-toggle="modal"
                      data-target="#modal-edit" data-backdrop="static" data-keyboard="false"
                      data-modal-id="{{ $record->id }}">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    @endif
                    <button type="button" class="btn btn-success view-modal" data-toggle="modal"
                      data-target="#modal-view" data-backdrop="static" data-keyboard="false"
                      data-modal-id="{{ $record->id }}">
                      <i class="fas fa-eye"></i>
                    </button>
                    @if(auth()->user()->user_role=="admin")
                    <form action="{{ route('event.destroy', $record->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
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
    //onclick for edit
    $('.edit-modal').on('click', function () {
      //id
      var id = $(this).data('modal-id');
      //route
      var url = "{{ route('event.edit', ['id' => ':id']) }}";
      //replace id
      url = url.replace(':id', id);
      var method = "GET";
      var modal_id = "modal-edit";
      //show loading
      $("#edit-overlay").show();
      //empty the modal
      $('#' + modal_id + ' .modal-content').html("");
      //get data
      editModal(url, method, modal_id);
    });

    //onclick for view
    $('.view-modal').on('click', function () {
      //id
      var id = $(this).data('modal-id');
      //route
      var url = "{{ route('event.view', ['id' => ':id']) }}";
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

    //onclick for add
    $('.add-modal').on('click', function () {
      //route
      var url = "{{ route('event.create') }}";
      var method = "GET";
      var modal_id = "modal-edit";
      //show loading
      $("#view-overlay").show();
      //empty the modal
      $('#' + modal_id + ' .modal-content').html("");
      //get data
      editModal(url, method, modal_id);
    });
  });

  function toggleann(obj) {
    if (obj.checked) {
      $('#ann_table').show();
    } else {
      $('#ann_table').hide();
    }
  }
</script>
@endsection