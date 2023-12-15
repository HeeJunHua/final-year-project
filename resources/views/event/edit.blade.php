<div class="modal-header">
    <h4 class="modal-title">Edit Event</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="editEventForm" action="{{ route('event.update', $record->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Event Name</th>
                    <td>
                        <input id="event_name" type="text" class="form-control" name="event_name"
                            value="{{ old('event_name', $record->event_name) }}" required>

                        <div class="error-message" id="event_name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Category</th>
                    <td>
                        <select id="category_id" name="category_id" class="form-control" required>
                            @foreach ($categories as $key => $value)
                            <option value="{{ $key }}" {{ old('category_id', $record->category_id)==$key ?
                                'selected' : ''
                                }}>{{ $value }}</option>
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
                            <option value="{{ $key }}" {{ old('event_status', $record->event_status)==$key ?
                                'selected' : ''
                                }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endif
                <tr>
                    <th>Event Description</th>
                    <td>
                        <textarea id="event_description" name="event_description" class="form-control" rows="3"
                            required>{{ old('event_description', $record->event_description) }}</textarea>

                        <div class="error-message" id="event_description-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Location</th>
                    <td>
                        <input id="event_location" type="text" class="form-control" name="event_location"
                            value="{{ old('event_location', $record->event_location) }}" required>

                        <div class="error-message" id="event_location-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event Start Date</th>
                    <td>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ old('start_date', $record->start_date) }}" required>

                        <div class="error-message" id="start_date-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Event End Date</th>
                    <td>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ old('end_date', $record->end_date) }}" required>

                        <div class="error-message" id="end_date-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Target Fundraise Goal</th>
                    <td>
                        <input id="target_goal" type="number" class="form-control" name="target_goal"
                            value="{{ old('target_goal', $record->target_goal) }}" required>

                        <div class="error-message" id="target_goal-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Cover Image</th>
                    <td>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if(!empty($record->cover_image))
                                <img class="profile-user-img img-fluid"
                                    src="{{ asset('storage/events/' . $record->cover_image) }}" alt="Cover Image"
                                    id="edit-picture">
                                @else
                                <img class="profile-user-img img-fluid"
                                    src="{{ asset('storage/events/default/default.png') }}" alt="Cover Image"
                                    id="edit-picture">
                                @endif
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
                        @if(!$record->eventImages->isEmpty())
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record->eventImages as $key1 => $record1)
                                <tr>
                                    <td>
                                        <a href="{{ asset('storage/event_attachment/'.$record1->image_path) }}"
                                            target="_blank">{{ $record1->image_path }}</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="att[]" value="{{ $record1->id }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <input type="file" name="attachment" accept="image/*,video/*">
                    </td>
                </tr>
                <tr>
                    <th>Event Attachment</th>
                    <td>
                        @if(!$record->attachment->isEmpty())
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record->attachment as $key1 => $record1)
                                <tr>
                                    <td>
                                        <a href="{{ asset('storage/attachment/'.$record1->path) }}"
                                            target="_blank">{{ $record1->name }}</a>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="attachment[]" value="{{ $record1->id }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <input type="file" name="event_attachment[]" multiple>
                    </td>
                </tr>
                <tr>
                    <th>Post Announcement for Recurring Volunteers</th>
                    <td>
                        <input id="ann" type="checkbox" name="ann" value="1" onchange="toggleann(this);" {{
                            !$record->announcements->isEmpty() ? 'checked' : '' }}>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr />
        @if(!$record->announcements->isEmpty())
        @foreach ($record->announcements as $key1 => $record1)
        <hr />
        <table class="table table-bordered table-hover" id="ann_table">
            <tbody>
                <tr>
                    <th>Announcement Message</th>
                    <td>
                        <textarea id="ann_text" name="ann_text" class="form-control" rows="3"
                            required>{{ old('ann_text', $record1->ann_text) }}</textarea>

                        <div class="error-message" id="ann_text-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td>
                        <input id="ann_contact_phone" type="text" class="form-control" name="ann_contact_phone"
                            value="{{ old('ann_contact_phone', $record1->ann_contact_phone) }}" required>

                        <div class="error-message" id="ann_contact_phone-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Contact Email</th>
                    <td>
                        <input id="ann_contact_email" type="text" class="form-control" name="ann_contact_email"
                            value="{{ old('ann_contact_email', $record1->ann_contact_email) }}" required>

                        <div class="error-message" id="ann_contact_email-error"></div>
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
        @else
        <table class="table table-bordered table-hover" id="ann_table" style="display: none;">
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
        @endif
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('editEventForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>