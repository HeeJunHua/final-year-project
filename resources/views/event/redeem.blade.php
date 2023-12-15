@section('title')
Points Redemption
@endsection

@section('page_title')
Points Redemption
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
          <form action="{{ route('event.redeem',['status'=>$status]) }}" method="GET">
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
            <i class="fas fa-star"></i> <b>Total Points Earned : {{ number_format($total,2) }}</b>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="form-group" style="font-size:20px;">
            <i class="fas fa-star"></i> <b>Balance Points : {{ number_format($balance,2) }}</b>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
            <a href="{{ route('event.redeem', 'Ongoing')}}"
              class="btn {{ request()->is('redeem/Ongoing*') ? 'btn-warning' : 'btn-default' }} btn-lg">Available
              Vouchers</a>
            <a href="{{ route('event.redeem', 'Pass')}}"
              class="btn {{ request()->is('redeem/Pass*') ? 'btn-warning' : 'btn-default' }} btn-lg">Pass Vouchers</a>
            <a href="{{ route('event.redeem', 'Clear')}}"
              class="btn {{ request()->is('redeem/Clear*') ? 'btn-warning' : 'btn-default' }} btn-lg">Redeemed
              Vouchers</a>
          </div>
        </div>
        <div class="col-lg-6 text-right">
          <button type="button" class="btn btn-warning report-modal btn-lg" data-toggle="modal"
            data-target="#modal-view" data-backdrop="static" data-keyboard="false">
            <i class="fas fa-history"></i> View Point History</button>
        </div>
      </div>

      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">
            @if($status=="Pass")
            Pass Vouchers
            @elseif($status=="Clear")
            Redeemed Vouchers
            @elseif($status=="Ongoing")
            Available Vouchers
            @else
            Vouchers
            @endif
          </h5>
        </div>
        <div class="card-body">
          @if($records->isEmpty())
          <div class="redeem-voucher">
            <div class="row">
              <div class="col-lg-12">
                No Voucher
              </div>
            </div>
          </div>
          @else
          @php
          $color = "#4caf50";
          $class = "redeem-voucher";
          $bg = "bg-success";
          if($status=="Pass"){
            $color = "#929895";
            $class = "redeem-voucher-pass";
            $bg = "bg-danger";
          }
          @endphp
          @foreach ($records as $key => $record)
          <div class="{{ $class }}">
            <div class="row">
              <div class="col-lg-1">
                <i class="fa fa-gift" style="font-size:40px;color:{{ $color }};"></i>
              </div>
              <div class="col-lg-5">
                <h2><b>{{ $record->voucher_name }}</b></h2>
                <span>Expiry Date : {{ $record->voucher_expiry_date }}</span>
                @if($status=="Clear")
                <br /><span>Redemption Date : {{ $record->redemptions[0]->redemption_date }}</span>
                @endif
              </div>
              <div class="col-lg-2" style="color:{{ $color }};">
                <h3><b>{{ $record->voucher_point_value }} Point</b></h3>

                @if(in_array($status,["Ongoing","Pass"]))
                <div class="progress mb-3">
                  <div class="progress-bar {{ $bg }}" role="progressbar"
                    aria-valuenow="{{ round(($record->voucher_quantity - $record->redemptions_count) / $record->voucher_quantity * 100,2) }}"
                    aria-valuemin="0" aria-valuemax="100"
                    style="width: {{ round(($record->voucher_quantity - $record->redemptions_count) / $record->voucher_quantity * 100,2) }}%">
                  </div>
                </div>

                <h6>Quantity Left  : {{ $record->voucher_quantity - $record->redemptions_count }} / {{ $record->voucher_quantity }}</h6>
                @endif
              </div>
              <div class="col-lg-4 text-right">
                @if($status=="Ongoing")
                @if($balance>$record->voucher_point_value)
                <!-- <a href="{{ route('event.redeemvoucher', $record->id)}}" class="btn btn-block btn-success btn-lg">Redeem</a> -->
                <button type="button" class="btn btn-block btn-success btn-lg redeem-modal" data-toggle="modal" data-target="#modal-view" data-backdrop="static" data-keyboard="false" data-modal-id="{{ $record->id }}">Redeem</button>
                @else
                <a href="#" class="btn btn-block btn-danger btn-lg" disabled>Insufficient Point</a>
                @endif
                @elseif($status=="Pass")
                @elseif($status=="Clear")
                <a href="#" class="btn btn-block btn-default btn-lg" disabled>Code : {{ $record->voucher_code }}</a>
                @endif
              </div>
            </div>
          </div>
          @endforeach
          @endif
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
    //onclick for report
    $('.report-modal').on('click', function () {
      //route
      var url = "{{ route('event.pointhistory') }}";
      var method = "GET";
      var modal_id = "modal-view";
      //show loading
      $("#view-overlay").show();
      //empty the modal
      $('#' + modal_id + ' .modal-content').html("");
      //get data
      viewModal(url, method, modal_id);
    });

    //onclick for view
    $('.redeem-modal').on('click', function () {
      //id
      var id = $(this).data('modal-id');
      //route
      var url = "{{ route('event.confirmredeem', ['id' => ':id']) }}";
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