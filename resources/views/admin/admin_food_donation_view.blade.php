@section('title')
    Food Donation Management
@endsection

@section('page_title')
    Food Donation Management
@endsection

@extends('layouts.dashboard')

@section('content')
<style>
    .modal-body {
        max-height: 70vh; /* Adjust the maximum height of the modal body */
        overflow-y: auto; /* Enable vertical scrolling if the content overflows */
    }

    .report-section {
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .report-divider {
        border: 1px solid #ddd;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    @media print {
        .modal-dialog .modal-content .modal-header button.close,
        .modal-dialog .modal-content .modal-footer {
            display: none !important;
        }
    }
</style>

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
                    <form action="{{ route('admin.dashboard.food.donation.list') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="search">Search:</label>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}">
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
                <div class="col-lg-6">
                  <div class="form-group">
                      <button type="button" class="btn btn-primary report-modal" data-toggle="modal" data-target="#foodDonationReportModal"
                      data-backdrop="static" data-keyboard="false">
                      <i class="fas fa-file"></i> View Report</button>
                  </div>
                </div>
              </div>
            
            <div class="modal fade" id="foodDonationReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLongTitle">Food Donation Report</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="food-donation-print-modal">
                            @if ($report->isEmpty())
                                <p>No data available for the report.</p>
                            @else
                                @foreach ($report as $row)
                                    <div class="report-section">
                                        <h4>Food Donor Information</h4>
                                        <table class="table">
                                            <tr>
                                                <th>Donor Name</th>
                                                <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Information</th>
                                                <td>{{ $row->user->email }} | {{ $row->user->contact_number }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="report-section">
                                        <h4>Donation Details</h4>
                                        <table class="table">
                                            <tr>
                                                <th>Donation Date</th>
                                                <td>{{ $row->food_donation_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Quantity Donated</th>
                                                <td>{{ $row->total_quantity }}</td>
                                            </tr>
                                            <tr>
                                                <th>Donation Status</th>
                                                <td>{{ $row->food_donation_status }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="report-section">
                                        <h4>Food Items Donated</h4>
                                        <table class="table">
                                            <tr>
                                                <th>Food Item</th>
                                                <th>Quantity</th>
                                                <th>Category</th>
                                                <th>Expiry Date</th>
                                            </tr>
                                            @foreach ($row->foodItems as $foodItem)
                                                <tr>
                                                    <td>{{ $foodItem->food_item_name }}</td>
                                                    <td>{{ $foodItem->food_item_quantity }}</td>
                                                    <td>{{ $foodItem->food_item_category }}</td>
                                                    <td>{{ $foodItem->has_expiry_date ? $foodItem->food_item_expiry_date : 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>

                                    <div class="report-section">
                                        <h4>Recipient Organization</h4>
                                        <table class="table">
                                            <tr>
                                                <th>Organization Name</th>
                                                <td>{{ $row->foodBank->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Organization Address</th>
                                                <td>{{ $row->foodBank->address }}</td>
                                            </tr>
                                            <!-- Add any other organization information you'd like to include -->
                                        </table>
                                    </div>
                        
                                    <hr class="report-divider">
                                @endforeach
                            @endif
                        </div>                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="printFoodDonationReport()">Print</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Food Donation Management</h5>
                  </div>
                @forelse ($foodDonations as $foodDonation)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-1"><i class="far fa-calendar-alt"></i> Donation Date:
                                {{ $foodDonation->food_donation_date }}</h5>
                            <h5 class="mb-1"><i class="fas fa-user"></i> User: {{ $foodDonation->user->username }} ({{ $foodDonation->user->email }})</h5>
                            <h5 class="mb-1"><i class="fas fa-building"></i> Food Bank : {{ $foodDonation->foodBank->name }}</h5>
                            <h5 class="mb-1"><i class="fas fa-map-marker-alt"></i> Address : {{ $foodDonation->foodBank->address }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="food-items table-responsive">
                                @if ($foodDonation->foodItems->isEmpty())
                                    <p class="text-muted"><i class="fas fa-info-circle"></i> No food items in this donation.
                                    </p>
                                @else
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 20%;"><i class="fas fa-utensils"></i> Name</th>
                                                <th style="width: 20%;"><i class="fas fa-box"></i> Category</th>
                                                <th style="width: 20%;"><i class="fas fa-shopping-basket"></i> Quantity</th>
                                                <th style="width: 20%;"><i class="fas fa-clock"></i> Expiry Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($foodDonation->foodItems as $foodItem)
                                                <tr>
                                                    <td>{{ $foodItem->food_item_name }}</td>
                                                    <td>{{ $foodItem->food_item_category }}</td>
                                                    <td>{{ $foodItem->food_item_quantity }}</td>
                                                    <td>
                                                        @if ($foodItem->has_expiry_date)
                                                            {{ $foodItem->food_item_expiry_date }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                        <!-- Buttons to manage food donation status -->
                        <div class="card-footer">
                            <form action="{{ route('admin.foodDonation.update', $foodDonation->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="approve" class="btn btn-success"><i
                                        class="fas fa-check"></i> Approve</button>
                                <button type="submit" name="action" value="decline" class="btn btn-danger"><i
                                        class="fas fa-times"></i> Decline</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped">
                            <tbody>
                              <tr>
                                <td colspan="5" class="text-center">No Pending Food Donation Request</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showFoodDonationReportModal() {
            // Trigger the modal with the specific ID
            $('#foodDonationReportModal').modal('show');
        }

        function printFoodDonationReport() {
            // Create a new window or iframe
            var printWindow = window.open('', '_blank');

            // Write the modal content to the new window or iframe
            printWindow.document.write('<html><head><title>Food Donation Report</title>');
            printWindow.document.write('<style>');
            printWindow.document.write(`
                .modal-dialog {
                    max-width: 80%;
                }

                .modal-body {
                    max-height: 70vh;
                    overflow-y: auto;
                }

                .report-section {
                    margin-bottom: 20px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }

                table, th, td {
                    border: 1px solid #ddd;
                }

                th, td {
                    padding: 10px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }

                .report-divider {
                    border: 1px solid #ddd;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }

                @media print {
                    .modal-dialog .modal-content .modal-header button.close,
                    .modal-dialog .modal-content .modal-footer {
                        display: none !important;
                    }
                }
            `);
            printWindow.document.write('</style>');

            printWindow.document.write('</head><body>');
            printWindow.document.write(document.getElementById('food-donation-print-modal').innerHTML);
            printWindow.document.write('</body></html>');

            // Close the document and trigger print
            printWindow.document.close();
            printWindow.print();
        }

    </script>
@endsection
    