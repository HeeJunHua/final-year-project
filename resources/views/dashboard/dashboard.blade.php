@section('title')
Dashboard
@endsection

@section('page_title')
Dashboard
@endsection

@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Profile</h5>
        </div>
        <div class="card-body">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                src="{{ asset('storage/profile_photos/' . auth()->user()->user_photo) }}" alt="User profile picture">
            </div>
          </div>

          <table class="table table-bordered table-hover">
            <tbody>
              <tr>
                <th>Name</th>
                <td>{{ auth()->user()->username }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ auth()->user()->email }}</td>
              </tr>
              <tr>
                <th>Phone Number</th>
                <td>{{ auth()->user()->contact_number }}</td>
              </tr>
              <tr>
                <td colspan="2">
                  <a href="{{ route('user.profile')}}" class="btn btn-block btn-success btn-lg">Update My Profile</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="m-0">Stats</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hover">
            <tbody>
              <tr>
                <th>Total Donations</th>
                <td style="text-align:right;">{{ number_format($donation, 2) }}</td>
              </tr>
              <tr>
                <th>Total Fund Raised</th>
                <td style="text-align:right;">{{ number_format($fund, 2) }}</td>
              </tr>
              <tr>
                <th>Total Points Earned</th>
                <td style="text-align:right;">{{ number_format($point_cr, 2) }}</td>
              </tr>
              <tr>
                <th>Total Points Used</th>
                <td style="text-align:right;">{{ number_format($point_dr, 2) }}</td>
              </tr>
              <tr>
                <th>Balance Points</th>
                <td style="text-align:right;">{{ number_format($point, 2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection