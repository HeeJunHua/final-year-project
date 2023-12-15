<div class="modal-header">
    <h4 class="modal-title">View Volunteer</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    @if(in_array($record->status,['Pending']) && ($record->event->user_id == auth()->user()->id))
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <a href="{{ route('event.respondvolunteer', ['id' => $record->id, 'status'=>'Approved'])}}"
                    class="btn btn-success btn-lg">Approve</a>
                <a href="{{ route('event.respondvolunteer', ['id' => $record->id, 'status'=>'Rejected'])}}"
                    class="btn btn-danger btn-lg">Reject</a>
            </div>
        </div>
    </div>
    @endif
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Event Name</th>
                <td>{{ $record->event->event_name }}</td>
            </tr>
            <tr>
                <th>Event Category</th>
                <td>{{ $record->event->category->category_name }}</td>
            </tr>
            <tr>
                <th>Event Location</th>
                <td>{{ $record->event->event_location }}</td>
            </tr>
            <tr>
                <th>Fundraiser Name</th>
                <td>{{ $record->event->user->username }}</td>
            </tr>
            <tr>
                <th>Event Start Date</th>
                <td>{{ $record->event->start_date }}</td>
            </tr>
            <tr>
                <th>Event End Date</th>
                <td>{{ $record->event->end_date }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $record->name }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $record->phone }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $record->email }}</td>
            </tr>
            <tr>
                <th>Skill</th>
                <td>{{ $record->skill }}</td>
            </tr>
            <tr>
                <th>Interest</th>
                <td>{{ $record->interest }}</td>
            </tr>
            <tr>
                <th>Available Start Date</th>
                <td>{{ $record->start_date }}</td>
            </tr>
            <tr>
                <th>Available End Date</th>
                <td>{{ $record->end_date }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $record->status }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>