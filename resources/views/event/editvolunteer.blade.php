<div class="modal-header">
    <h4 class="modal-title">Edit Volunteer</h4>
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

    <form id="editVolunteerForm" action="{{ route('event.updatevolunteer', ['volunteer' => $record]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <table class="table table-bordered table-hover">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>
                        <input id="name" type="text" class="form-control" name="name"
                            value="{{ old('name', $record->name) }}" required>

                        <div class="error-message" id="name-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>
                        <input id="phone" type="text" class="form-control" name="phone"
                            value="{{ old('phone', $record->phone) }}" required>

                        <div class="error-message" id="phone-error"></div>
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
                    <th>Skill</th>
                    <td>
                        <input id="skill" type="text" class="form-control" name="skill"
                            value="{{ old('skill', $record->skill) }}" required>

                        <div class="error-message" id="skill-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Interest</th>
                    <td>
                        <input id="interest" type="text" class="form-control" name="interest"
                            value="{{ old('interest', $record->interest) }}" required>

                        <div class="error-message" id="interest-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ old('start_date', $record->start_date) }}" required>

                        <div class="error-message" id="start_date-error"></div>
                    </td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ old('end_date', $record->end_date) }}" required>

                        <div class="error-message" id="end_date-error"></div>
                    </td>
                </tr>
                @if (auth()->user()->user_role == 'admin')
                    <tr>
                        <th>Event Status</th>
                        <td>
                            <select name="status" class="form-control" required>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('status', $record->status) == $key ? 'selected' : '' }}>
                                        {{ $value }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-primary" onclick="submitFormModal('editVolunteerForm');">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
