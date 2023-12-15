<div class="modal-header">
    <h4 class="modal-title">Completion Form</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if(in_array($record->status,['Pending']) && auth()->user()->user_role=="admin")
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <a href="{{ route('event.respondcompletion', ['completionform' => $record->id, 'status'=>'Approved'])}}"
                    class="btn btn-success btn-lg">Approve</a>
                <a href="{{ route('event.respondcompletion', ['completionform' => $record->id, 'status'=>'Rejected'])}}"
                    class="btn btn-danger btn-lg">Reject</a>
            </div>
        </div>
    </div>
    @endif

    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Event Name</th>
                <td>{{ $record->volunteer->event->event_name }}</td>
            </tr>
            <tr>
                <th>Event Category</th>
                <td>{{ $record->volunteer->event->category->category_name }}</td>
            </tr>
            <tr>
                <th>Event Location</th>
                <td>{{ $record->volunteer->event->event_location }}</td>
            </tr>
            <tr>
                <th>Fundraiser Name</th>
                <td>{{ $record->volunteer->event->user->username }}</td>
            </tr>
            <tr>
                <th>Event Start Date</th>
                <td>{{ $record->volunteer->event->start_date }}</td>
            </tr>
            <tr>
                <th>Event End Date</th>
                <td>{{ $record->volunteer->event->end_date }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Name</th>
                <td>
                    {{ $record->name }}
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    {{ $record->email }}
                </td>
            </tr>
            <tr>
                <th>Volunteer Role</th>
                <td>
                    {{ $record->role }}
                </td>
            </tr>
            <tr>
                <th>Skills Utilized</th>
                <td>
                    {{ $record->skill }}
                </td>
            </tr>
            <tr>
                <th>Tasks Accomplished</th>
                <td>
                    {{ $record->task }}
                </td>
            </tr>
            <tr>
                <th>Impact and Achievements</th>
                <td>
                    {{ $record->achievement }}
                </td>
            </tr>
            <tr>
                <th>Hours Volunteered</th>
                <td>
                    {{ $record->hour }}
                </td>
            </tr>
            <tr>
                <th>Attachment</th>
                <td>
                    @if (!empty($record->path))
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td>
                                    <a href="{{ asset('storage/completion_attachment/' . $record->path) }}"
                                        target="_blank">{{ $record->path }}</a>
                                </td>
                            </tr>
                        </table>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
