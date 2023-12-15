<div class="modal-header">
    <h4 class="modal-title">Edit Category</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="editVoucherForm" action="{{ route('voucher.update', $record->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <table class="table table-bordered table-hover">
        <tbody>
                <tr>
                    <th>Voucher Code</th>
                    <td>
                        <input id="voucher_code" type="text" class="form-control" name="voucher_code" value="{{ old('voucher_code', $record->voucher_code) }}" required>

                        <div class="error-message" id="voucher_code-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Voucher Name</th>
                    <td>
                        <input id="voucher_name" type="text" class="form-control" name="voucher_name" value="{{ old('voucher_name', $record->voucher_name) }}" required>

                        <div class="error-message" id="voucher_name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Voucher Description</th>
                    <td>
                        <textarea id="voucher_description" name="voucher_description" class="form-control" rows="3"
                            required>{{ old('voucher_description', $record->voucher_description) }}</textarea>

                        <div class="error-message" id="voucher_description-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Voucher Points</th>
                    <td>
                        <input id="voucher_point_value" type="number" class="form-control" name="voucher_point_value" value="{{ old('voucher_point_value', $record->voucher_point_value) }}"
                            required>

                        <div class="error-message" id="voucher_point_value-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Voucher Quantity</th>
                    <td>
                        <input id="voucher_quantity" type="number" class="form-control" name="voucher_quantity" value="{{ old('voucher_quantity', $record->voucher_quantity) }}"
                            required>

                        <div class="error-message" id="voucher_quantity-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Voucher Expiry Date</th>
                    <td>
                        <input id="voucher_expiry_date" type="date" class="form-control" name="voucher_expiry_date" value="{{ old('voucher_expiry_date', $record->voucher_expiry_date) }}"
                            required>

                        <div class="error-message" id="voucher_expiry_date-error"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('editVoucherForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>