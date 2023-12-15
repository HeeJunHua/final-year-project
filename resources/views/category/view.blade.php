<div class="modal-header">
    <h4 class="modal-title">View Category</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Category Name</th>
                <td>{{ $record->category_name }}</td>
            </tr>
            <tr>
                <th>Image</th>
                <td>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if(!empty($record->image_path))
                            <img class="profile-user-img img-fluid"
                                src="{{ asset('storage/categories/' . $record->image_path) }}" alt="Cover Image"
                                id="edit-picture">
                            @else
                            <img class="profile-user-img img-fluid"
                                src="{{ asset('storage/categories/default/default.png') }}" alt="Cover Image"
                                id="edit-picture">
                            @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>