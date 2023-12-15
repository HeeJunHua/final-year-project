@section('title')
    Volunteer
@endsection

@section('page_title')
    Volunteer
@endsection

@extends('layouts.dashboard')

@section('content')
<style>
    .modal-dialog {
    max-width: 1000px !important;
}
</style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Filter</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('event.volunteer', ['type' => $type]) }}" method="GET">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="search">Search:</label>
                                        <input type="text" name="search" class="form-control"
                                            value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select name="status" class="form-control">
                                            <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All
                                            </option>
                                            @foreach ($status as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ request('status') == $key ? 'selected' : '' }}>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <a href="{{ route('event.volunteer', 'myevent') }}"
                                class="btn {{ request()->is('volunteer/myevent*') ? 'btn-warning' : 'btn-default' }} btn-lg">My
                                Event Volunteers</a>
                            <a href="{{ route('event.volunteer', 'myregister') }}"
                                class="btn {{ request()->is('volunteer/myregister*') ? 'btn-warning' : 'btn-default' }} btn-lg">My
                                Event Registration</a>
                            @if (auth()->user()->user_role == 'admin')
                                <a href="{{ route('event.volunteer', 'completionform') }}"
                                    class="btn {{ request()->is('volunteer/completionform*') ? 'btn-warning' : 'btn-default' }} btn-lg">Completion
                                    Form</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">
                            @if ($status == 'myevent')
                                My Event Volunteers
                            @elseif($status == 'myregister')
                                My Event Registration
                            @elseif($status == 'completionform')
                                Completion Form
                            @else
                                Volunteers
                            @endif
                        </h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:10px;">No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Event Category</th>
                                    <th>Event Name</th>
                                    <th>Volunteer Status</th>
                                    @if (request()->is('volunteer/myregister*') || request()->is('volunteer/completionform*'))
                                        <th colspan="2" style="text-align: center;">Completion Form</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($records->isEmpty())
                                    <tr>
                                        @if (request()->is('volunteer/myregister*') || request()->is('volunteer/completionform*'))
                                            <td colspan="9" class="text-center">No records found</td>
                                        @else
                                            <td colspan="7" class="text-center">No records found</td>
                                        @endif
                                    </tr>
                                @else
                                    @foreach ($records as $key => $record)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $record->name }}</td>
                                            <td>{{ $record->phone }}</td>
                                            <td>{{ $record->event->category->category_name }}</td>
                                            <td><a
                                                    href="{{ route('event.detail', $record->event_id) }}">{{ $record->event->event_name }}</a>
                                            </td>
                                            <td>{{ $record->status }}</td>
                                            @if (request()->is('volunteer/myregister*') || request()->is('volunteer/completionform*'))
                                                @if ($record->status == 'Approved')
                                                    @if (empty($record->completion_form))
                                                        @if (auth()->user()->user_role == 'admin')
                                                            @if (request()->is('volunteer/myregister*'))
                                                                <td colspan="2" style="text-align: center;">
                                                                    <button type="button"
                                                                        class="btn btn-warning completionadd-modal"
                                                                        data-toggle="modal" data-target="#modal-edit"
                                                                        data-backdrop="static" data-keyboard="false"
                                                                        data-modal-id="{{ $record->id }}">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td colspan="2" style="text-align: center;">
                                                                <button type="button"
                                                                    class="btn btn-warning completionadd-modal"
                                                                    data-toggle="modal" data-target="#modal-edit"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    data-modal-id="{{ $record->id }}">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        @endif
                                                    @else
                                                        @if (auth()->user()->user_role == 'admin')
                                                            <td style="text-align: right;">
                                                                @if ($record->completion_form->status == 'Approved')
                                                                    <button type="button"
                                                                        class="btn btn-primary completioncert-modal"
                                                                        data-toggle="modal" data-target="#modal-view"
                                                                        data-backdrop="static" data-keyboard="false"
                                                                        data-modal-id="{{ $record->completion_form->id }}">
                                                                        <i class="fas fa-certificate"></i>
                                                                    </button>
                                                                @endif
                                                                <button type="button"
                                                                    class="btn btn-success completionview-modal"
                                                                    data-toggle="modal" data-target="#modal-view"
                                                                    data-backdrop="static" data-keyboard="false"
                                                                    data-modal-id="{{ $record->completion_form->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        @else
                                                            @if ($record->completion_form->status == 'Approved')
                                                                <td style="text-align: right;">
                                                                    <button type="button"
                                                                        class="btn btn-primary completioncert-modal"
                                                                        data-toggle="modal" data-target="#modal-view"
                                                                        data-backdrop="static" data-keyboard="false"
                                                                        data-modal-id="{{ $record->completion_form->id }}">
                                                                        <i class="fas fa-certificate"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-success completionview-modal"
                                                                        data-toggle="modal" data-target="#modal-view"
                                                                        data-backdrop="static" data-keyboard="false"
                                                                        data-modal-id="{{ $record->completion_form->id }}">
                                                                        <i class="fas fa-eye"></i>
                                                                    </button>
                                                                </td>
                                                            @else
                                                                <td style="text-align: right;">
                                                                    <button type="button"
                                                                        class="btn btn-warning completionedit-modal"
                                                                        data-toggle="modal" data-target="#modal-edit"
                                                                        data-backdrop="static" data-keyboard="false"
                                                                        data-modal-id="{{ $record->completion_form->id }}">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                </td>
                                                            @endif
                                                        @endif


                                                        <td>{{ $record->completion_form->status }}</td>
                                                    @endif
                                                @else
                                                    <td colspan="2">Volunteer Status Pending</td>
                                                @endif
                                            @endif
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if (
                                                        (auth()->user()->user_role == 'admin' || auth()->user()->id == $record->user_id) &&
                                                            request()->is('volunteer/myregister*') &&
                                                            in_array($record->status, ['Pending', 'Rejected']))
                                                        <button type="button" class="btn btn-warning edit-modal"
                                                            data-toggle="modal" data-target="#modal-edit"
                                                            data-backdrop="static" data-keyboard="false"
                                                            data-modal-id="{{ $record->id }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-success view-modal"
                                                        data-toggle="modal" data-target="#modal-view"
                                                        data-backdrop="static" data-keyboard="false"
                                                        data-modal-id="{{ $record->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if (
                                                        (auth()->user()->user_role == 'admin' || auth()->user()->id == $record->user_id) &&
                                                            request()->is('volunteer/myregister*') &&
                                                            $record->status == 'Pending')
                                                        <form action="{{ route('event.destroyvolunteer', $record->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    @endif

                                                    @if (auth()->user()->user_role == 'admin' &&
                                                            request()->is('volunteer/completionform*') &&
                                                            $record->completion_form->status == 'Pending')
                                                        <form
                                                            action="{{ route('event.destroycompletionform', $record->completion_form) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $records->appends(['search' => request('search'), 'status' => request('status')])->links('pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modal/modal')

    <script>
        $(document).ready(function() {
            //onclick for edit
            $('.edit-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.editvolunteer', ['id' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-edit";
                //show loading
                $("#edit-overlay").show();
                //empty the modal
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                editModal(url, method, modal_id);
            });

            //onclick for view
            $('.view-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.viewvolunteer', ['id' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-view";
                //show loading
                $("#view-overlay").show();
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                viewModal(url, method, modal_id);
            });

            //onclick for completion form
            $('.completionadd-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.addcompletion', ['volunteer' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-edit";
                //show loading
                $("#edit-overlay").show();
                //empty the modal
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                editModal(url, method, modal_id);
            });

            //onclick for completion form
            $('.completionedit-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.editcompletion', ['completionform' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-edit";
                //show loading
                $("#edit-overlay").show();
                //empty the modal
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                editModal(url, method, modal_id);
            });

            //onclick for completion form
            $('.completionview-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.viewcompletion', ['completionform' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-view";
                //show loading
                $("#view-overlay").show();
                //empty the modal
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                viewModal(url, method, modal_id);
            });

            //onclick for completion form
            $('.completioncert-modal').on('click', function() {
                //id
                var id = $(this).data('modal-id');
                //route
                var url = "{{ route('event.cert', ['completionform' => ':id']) }}";
                //replace id
                url = url.replace(':id', id);
                var method = "GET";
                var modal_id = "modal-view";
                //show loading
                $("#view-overlay").show();
                //empty the modal
                $('#' + modal_id + ' .modal-content').html("");
                //get data
                viewModal(url, method, modal_id);
            });
        });
    </script>
@endsection
