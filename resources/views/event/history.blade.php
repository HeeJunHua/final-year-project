@section('title')
Donation History
@endsection

@section('page_title')
Donation History
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
          <form action="{{ route('event.history') }}" method="GET">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                  <label for="search">Search:</label>
                  <input type="text" name="search" class="form-control" value="{{ request('search') }}">
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
            <i class="fas fa-donate"></i> <b>Total Donations : {{ number_format($total,2) }}</b>
          </div>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Donation History</h5>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th style="width:10px;">No</th>
                <th>Event Name</th>
                <th>Donor</th>
                <th>Amount</th>
                <th>Date</th>
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
                <td>{{ $key + 1 }}</td>
                <td><a href="{{ route('event.detail',$record->event_id)}}">{{ $record->event->event_name }}</a></td>
                <td>{{ $record->user->username }}</td>
                <td>{{ number_format($record->donation_amount, 2) }}</td>
                <td>{{ $record->donation_date }}</td>
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
@endsection