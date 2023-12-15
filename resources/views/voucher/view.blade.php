<div class="modal-header">
    <h4 class="modal-title">View Voucher</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Voucher Code</th>
                <td>{{ $record->voucher_code }}</td>
            </tr>
            <tr>
                <th>Voucher Name</th>
                <td>{{ $record->voucher_name }}</td>
            </tr>
            <tr>
                <th>Voucher Description</th>
                <td>{{ $record->voucher_description }}</td>
            </tr>
            <tr>
                <th>Voucher Points</th>
                <td>{{ $record->voucher_point_value }}</td>
            </tr>
            <tr>
                <th>Voucher Quantity</th>
                <td>{{ $record->voucher_quantity }}</td>
            </tr>
            <tr>
                <th>Voucher Expiry Date</th>
                <td>{{ $record->voucher_expiry_date }}</td>
            </tr>
            <tr>
                <th>Voucher Status</th>
                <td>{{ $record->voucher_status }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>