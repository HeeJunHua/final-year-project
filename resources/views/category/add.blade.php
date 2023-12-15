<div class="modal-header">
    <h4 class="modal-title">Add Category</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addCategoryForm" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Category Name</th>
                    <td>
                        <input id="category_name" type="text" class="form-control" name="category_name" required>

                        <div class="error-message" id="category_name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid"
                                    src="{{ asset('storage/categories/default/default.png') }}" alt="Cover Image"
                                    id="edit-picture">
                                <div onclick="triggerFileInput()"><b><i class="fas fa-pencil-alt"></i>
                                        Edit</div></b>

                                <div class="error-message" id="image_path-error"></div>
                            </div>
                            <input type="file" id="edit-picture-button" name="image_path"
                                onchange="displaySelectedFile(this)" hidden accept="image/*">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('addCategoryForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>