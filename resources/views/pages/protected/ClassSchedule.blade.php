@extends('layout.MainLayout')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">Add Schedule</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered" id="schedulesTable">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Tutor</th>
                                    <th>Mode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addScheduleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="day" class="form-label">Date</label>
                            <input type="date" id="day" name="day" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tutor" class="form-label">Tutor</label>
                            <input type="text" id="tutor" name="tutor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="mode" class="form-label">Mode</label>
                            <select id="mode" name="mode" class="form-control" required>
                                <option value="online">Online</option>
                                <option value="physical">Physical</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link (if online)</label>
                            <input type="url" id="link" name="link" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="any_material_url" class="form-label">Material URL</label>
                            <input type="url" id="any_material_url" name="any_material_url" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea id="note" name="note" class="form-control"></textarea>
                        </div>

                        {{-- Errors Alert --}}
                        <div class="alert alert-danger" id="errors" style="display: none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const table = $('#schedulesTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('class-schedules.load') }}",
                    type: "GET",
                    dataSrc: function(json) {
                        console.log('API Response:', json); // Log the response data
                        return json.data; // Return the data array to DataTables
                    },
                    error: function(xhr, status, error) {
                        console.error('DataTables Error:', error); // Log any AJAX errors
                    }
                },
                "columns": [{
                        data: 'class_name',
                        title: 'Class Name'
                    },
                    {
                        data: 'day',
                        title: 'Day'
                    },
                    {
                        data: 'start_time',
                        title: 'Start Time'
                    },
                    {
                        data: 'end_time',
                        title: 'End Time'
                    },
                    {
                        data: 'tutor',
                        title: 'Tutor'
                    },
                    {
                        data: 'mode',
                        title: 'Mode'
                    },
                    {
                        data: 'id',
                        title: 'Actions',
                        render: function(data) {
                            return `
                    <button class="btn btn-sm btn-warning edit-schedule" data-id="${data}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-schedule" data-id="${data}">Delete</button>
                `;
                        }
                    }
                ]
            });


            // Add Schedule
            $('#addScheduleForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('class-schedules.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addScheduleModal').modal('hide');
                        $('#addScheduleForm')[0].reset();
                        table.ajax.reload();
                        alert(response.message);
                    },
                    error: function(response) {
                        alert('Error adding schedule');
                        console.log(response);

                        // Display errors
                        $('#errors').html('');
                        $('#errors').show();
                        $.each(response.responseJSON.errors, function(key, value) {
                            $('#errors').append(`<p>${value}</p>`);
                        });


                    }
                });
            });

            // Delete Schedule
            $('#schedulesTable').on('click', '.delete-schedule', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this schedule?')) {
                    $.ajax({
                        url: `/class-schedules/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            table.ajax.reload();
                            alert(response.message);
                        },
                        error: function(response) {
                            alert('Error deleting schedule');
                        }
                    });
                }
            });
        });
    </script>
@endsection
