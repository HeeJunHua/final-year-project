<div class="modal-header">
    <h4 class="modal-title">Recurring Volunteers</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th>Event Name</th>
                <td>{{ $record->event->event_name }}</td>
            </tr>
            <tr>
                <th>Event Date</th>
                <td>{{ $record->event->start_date }}</td>
            </tr>
            <tr>
                <th>Event Location</th>
                <td>{{ $record->event->event_location }}</td>
            </tr>
            <tr>
                <th>Event Message</th>
                <td>{{ $record->ann_text }}</td>
            </tr>
        </tbody>
    </table>
    <h6>If you are interested please contact us</h6>
    <table class="table table-bordered table-hover">
        <tbody>
            <tr>
                <th><i class="fa fa-phone-square"></i></th>
                <td>{{ $record->ann_contact_phone }}</td>
            </tr>
            <tr>
                <th><i class="fa fa-envelope"></i></th>
                <td>{{ $record->ann_contact_email }}</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ route('event.registervolunteer', ['announcement' => $record]) }}"
        class="btn btn-warning btn-block btn-lg"><b>Register as Volunteer</b></a>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
