<div class="modal-header">
    <h4 class="modal-title">View Event</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if(in_array($record->event_status,['Pending']) && auth()->user()->user_role=="admin")
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <a href="{{ route('event.respond', ['id' => $record->id, 'status'=>'Approved'])}}"
                    class="btn btn-success btn-lg">Approve</a>
                <a href="{{ route('event.respond', ['id' => $record->id, 'status'=>'Rejected'])}}"
                    class="btn btn-danger btn-lg">Reject</a>
            </div>
        </div>
    </div>
    @endif

    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Event Name</th>
                <td>{{ $record->event_name }}</td>
            </tr>
            <tr>
                <th>Event Category</th>
                <td>{{ $record->category->category_name }}</td>
            </tr>
            <tr>
                <th>Event Status</th>
                <td>{{ $record->event_status }}</td>
            </tr>
            <tr>
                <th>Event Description</th>
                <td>{{ nl2br($record->event_description) }}</td>
            </tr>
            <tr>
                <th>Event Location</th>
                <td>{{ $record->event_location }}</td>
            </tr>
            <tr>
                <th>Event Start Date</th>
                <td>{{ $record->start_date }}</td>
            </tr>
            <tr>
                <th>Event End Date</th>
                <td>{{ $record->end_date }}</td>
            </tr>
            <tr>
                <th>Target Fundraise Goal</th>
                <td>{{ $record->target_goal }}</td>
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
                        </div>
                </td>
            </tr>
            <tr>
                <th>Event Multimedia</th>
                <td>
                    @if(!$record->eventImages->isEmpty())
                    <table class="table table-bordered table-hover">
                        <tbody>
                            @foreach ($record->eventImages as $key1 => $record1)
                            <tr>
                                <td><a href="{{ asset('storage/event_attachment/'.$record1->image_path) }}"
                                        target="_blank">{{ $record1->image_path }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Event Attachment</th>
                <td>
                    @if(!$record->attachment->isEmpty())
                    <table class="table table-bordered table-hover">
                        <tbody>
                            @foreach ($record->attachment as $key1 => $record1)
                            <tr>
                                <td><a href="{{ asset('storage/attachment/'.$record1->path) }}"
                                        target="_blank">{{ $record1->name }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @if(!$record->announcements->isEmpty())
    @foreach ($record->announcements as $key1 => $record1)
    <hr />
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Announcement Message</th>
                <td>{{ nl2br($record1->ann_text) }}</td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>{{ $record1->ann_contact_phone }}</td>
            </tr>
            <tr>
                <th>Contact Email</th>
                <td>{{ $record1->ann_contact_email }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
    @endif
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>