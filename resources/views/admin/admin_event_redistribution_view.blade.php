@section('title')
    Food Redistribution Management
@endsection

@section('page_title')
    Food Redistribution Management
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
                <form action="{{ route('admin.dashboard.event.redistribution.search') }}" method="GET">
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
        <div class="m-3">
            <button type="button" class="btn btn-primary" onclick="showAllRedistributionReport()">
                <i class="fas fa-file"></i> View Report
            </button>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">Food Redistribution Management</h5>
            </div>
            @forelse ($eventRedistribution as $redistribution)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-1"><i class="fas fa-tag"></i> Event Name:
                            {{ $redistribution->event_name }}</h5>
                        <h5 class="mb-1"><i class="fas fa-calendar-alt"></i> Event Date:
                            {{ $redistribution->event_date }}</h5>
                        <h5 class="mb-1"><i class="fas fa-user"></i> User: {{ $redistribution->user->username }} ({{ $redistribution->user->email }})</h5>
                        <h5 class="mb-1"><i class="fas fa-map-marker-alt"></i> Location : {{ $redistribution->location }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="food-items table-responsive">
                            @if ($redistribution->foodItems->isEmpty())
                                <p class="text-muted"><i class="fas fa-info-circle"></i> No food items in this redistribution.
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
                                        @foreach ($redistribution->foodItems as $foodItem)
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

                    <!-- Buttons to manage food redistribution status -->
                    <div class="card-footer">
                        <form action="{{ route('admin.updateEventRedistributionStatus', $redistribution->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')

                            <button type="button" class="btn btn-primary" onclick="showRedistributionReportModal({{ $redistribution->id }})">
                                <i class="fas fa-eye"></i> View
                            </button>
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
                                <td colspan="5" class="text-center">No Pending Food Redistribution Request</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal for Overall Redistribution Report -->
<div class="modal fade" id="allRedistributionReportModal" tabindex="-1" role="dialog" aria-labelledby="allRedistributionReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allRedistributionReportModalLabel">Overall Food Redistribution Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be filled dynamically using AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printAllRedistributionReport()">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Redistribution Report -->
<div class="modal fade" id="redistributionReportModal" tabindex="-1" role="dialog" aria-labelledby="redistributionReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="redistributionReportModalLabel">Food Redistribution Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="redistribution-print-modal">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printRedistributionReport()">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function printAllRedistributionReport() {
    // Create a new window or iframe
    var printWindow = window.open('', '_blank');

    // Write the modal content to the new window or iframe
    printWindow.document.write('<html><head><title>Overall Food Redistribution Report</title>');
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

    // Fetch the content dynamically and write it to the body
    $.ajax({
        url: "{{ route('admin.getAllRedistributionReports') }}",
        type: 'GET',
        success: function(response) {
            printWindow.document.write(response);

            // Close the document and trigger print
            printWindow.document.close();
            printWindow.print();
        },
        error: function(error) {
            console.log(error);
            printWindow.close();
        }
    });

    printWindow.document.write('</body></html>');
}

    function showAllRedistributionReport() {
        // Make an AJAX request to fetch the overall redistribution report content
        $.ajax({
            url: "{{ route('admin.getAllRedistributionReports') }}",
            type: 'GET',
            success: function(response) {
                // Set the reports content in the modal body
                $('#allRedistributionReportModal .modal-body').html(response);
                // Trigger the modal
                $('#allRedistributionReportModal').modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function showRedistributionReportModal(redistributionId) {
        // Make an AJAX request to fetch the redistribution report content
        $.ajax({
            url: "{{ route('admin.getRedistributionReport') }}",
            type: 'GET',
            data: { redistributionId: redistributionId },
            success: function(response) {
                // Set the report content in the modal body
                $('#redistribution-print-modal').html(response);
                // Trigger the modal with the specific ID
                $('#redistributionReportModal').modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function printRedistributionReport() {
        // Create a new window or iframe
        var printWindow = window.open('', '_blank');

        // Write the modal content to the new window or iframe
        printWindow.document.write('<html><head><title>Food Redistribution Report</title>');
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
        printWindow.document.write(document.getElementById('redistribution-print-modal').innerHTML);
        printWindow.document.write('</body></html>');

        // Close the document and trigger print
        printWindow.document.close();
        printWindow.print();
    }
</script>
@endsection
