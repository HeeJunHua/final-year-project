<div class="modal-header">
    <h4 class="modal-title">Add Event</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addEventForm" action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Event Name</th>
                    <td>
                        <input id="event_name" type="text" class="form-control" name="event_name" required>

                        <div class="error-message" id="event_name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Category</th>
                    <td>
                        <select id="category_id" name="category_id" class="form-control" required>
                            @foreach ($categories as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>

                        <div class="error-message" id="category_id-error"></div>
                    </td>
                </tr>
                @if(auth()->user()->user_role=="admin")
                <tr>
                    <th>Event Status</th>
                    <td>
                        <select name="event_status" class="form-control" required>
                            @foreach ($status as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endif
                <tr>
                    <th>Event Description</th>
                    <td>
                        <textarea id="event_description" name="event_description" class="form-control" rows="3"
                            required></textarea>

                        <div class="error-message" id="event_description-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Location</th>
                    <td>
                        <input id="event_location" type="text" class="form-control" name="event_location" required>

                        <div class="error-message" id="event_location-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Start Date</th>
                    <td>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>

                        <div class="error-message" id="start_date-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event End Date</th>
                    <td>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>

                        <div class="error-message" id="end_date-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Target Fundraise Goal</th>
                    <td>
                        <input id="target_goal" type="number" class="form-control" name="target_goal" required>

                        <div class="error-message" id="target_goal-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Cover Image</th>
                    <td>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid"
                                    src="{{ asset('storage/events/default/default.png') }}" alt="Cover Image"
                                    id="edit-picture">
                                <div onclick="triggerFileInput()"><b><i class="fas fa-pencil-alt"></i>
                                        Edit</div></b>

                                <div class="error-message" id="cover_image-error"></div>
                            </div>
                            <input type="file" id="edit-picture-button" name="cover_image"
                                onchange="displaySelectedFile(this)" hidden accept="image/*">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Event Multimedia</th>
                    <td>
                        <input type="file" name="attachment" accept="image/*,video/*">

                        <div class="error-message" id="attachment-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Attachment</th>
                    <td>
                        <input type="file" name="event_attachment[]" multiple>

                        <div class="error-message" id="event_attachment-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Post Announcement for Recurring Volunteers</th>
                    <td>
                        <input id="ann" type="checkbox" name="ann" value="1" onchange="toggleann(this);">
                    </td>
                </tr>
            </tbody>
        </table>
        <hr />
        <table class="table table-bordered table-hover" id="ann_table" style="display:none;">
            <tbody>
                <tr>
                    <th>Announcement Message</th>
                    <td>
                        <textarea id="ann_text" name="ann_text" class="form-control" rows="3" required></textarea>

                        <div class="error-message" id="ann_text-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>
                        <input id="ann_contact_phone" type="text" class="form-control" name="ann_contact_phone"
                            required>

                        <div class="error-message" id="ann_contact_phone-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Contact Email</th>
                    <td>
                        <input id="ann_contact_email" type="text" class="form-control" name="ann_contact_email"
                            required>

                        <div class="error-message" id="ann_contact_email-error"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('addEventForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>