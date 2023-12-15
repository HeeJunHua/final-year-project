<div class="modal-header">
    <h4 class="modal-title">Completion Form</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
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

    <form id="completionForm" method="POST"
        action="{{ route('event.updatecompletion', ['completionform' => $record]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name', $record->name) }}" required>

                        <div class="error-message" id="name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input id="email" type="text" class="form-control" name="email"
                            value="{{ old('email', $record->email) }}" required>

                        <div class="error-message" id="email-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Volunteer Role</th>
                    <td>
                        <input id="role" type="text" class="form-control @error('role') is-invalid @enderror"
                            name="role" value="{{ old('role', $record->role) }}" required>

                        <div class="error-message" id="role-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Skills Utilized</th>
                    <td>
                        <input id="skill" type="text" class="form-control @error('skill') is-invalid @enderror"
                            name="skill" value="{{ old('skill', $record->skill) }}" required>

                        <div class="error-message" id="skill-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Tasks Accomplished</th>
                    <td>
                        <input id="task" type="text" class="form-control @error('task') is-invalid @enderror"
                            name="task" value="{{ old('task', $record->task) }}" required>

                        <div class="error-message" id="task-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Impact and Achievements</th>
                    <td>
                        <input id="achievement" type="text"
                            class="form-control @error('achievement') is-invalid @enderror" name="achievement"
                            value="{{ old('achievement', $record->achievement) }}" required>

                        <div class="error-message" id="achievement-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Hours Volunteered</th>
                    <td>
                        <input id="hour" type="number" class="form-control @error('hour') is-invalid @enderror"
                            name="hour" value="{{ old('hour', $record->hour) }}" required>

                        <div class="error-message" id="hour-error"></div>
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
                        <input type="file" name="attachment" id="attachment">

                        <div class="error-message" id="attachment-error"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('completionForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
