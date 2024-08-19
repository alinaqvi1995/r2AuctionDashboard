@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Grades</h2>
        <p class="card-text">Grades table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openGradeModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Grade</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Grade Messages -->
                        <div id="gradeMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.grades.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Grade modal -->
    <div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">New Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createGradeForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="carrier_id">Carrier</label>
                            <select class="form-control" id="carrier_id" name="carrier_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($carriers as $carrier)
                                    <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveGradeBtn">Save Grade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Grade modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" role="dialog" aria-labelledby="editGradeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editGradeForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_carrier">Carrier</label>
                            <select class="form-control" id="edit_carrier" name="carrier_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($carriers as $carrier)
                                    <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateGradeBtn">Update Grade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openGradeModal').click(function() {
                $('#gradeModal').modal('show');
            });

            $('#createGradeForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('grades.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#gradeModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#gradeMessage').html(
                            '<div class="alert alert-success" role="alert">Grade created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#gradeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create grade.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editGradeBtn', function() {
                var gradeId = $(this).data('id');
                $.ajax({
                    url: "{{ route('grades.edit', ['grade' => ':gradeId']) }}".replace(':gradeId',
                        gradeId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.grade.id);
                        $('#edit_name').val(response.grade.name);
                        $('#edit_description').val(response.grade.description);
                        $('#edit_status').val(response.grade.status);
                        $('#edit_carrier').val(response.grade.carrier_id);
                        $('#editGradeModal').modal('show');

                        $('#editGradeForm').attr('action',
                            "{{ route('grades.update', ['grade' => ':gradeId']) }}".replace(
                                ':gradeId', gradeId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#gradeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch grade details for editing.</div>'
                        );
                    }
                });
            });

            $('#editGradeForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var actionUrl = $(this).attr('action');
                $.ajax({
                    url: actionUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editGradeModal').modal('hide');

                        $('#tableData').html(response
                            .table_html);

                        $('#gradeMessage').html(
                            '<div class="alert alert-success" role="alert">Grade updated successfully.</div>'
                        );

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        $('#gradeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update grade.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteGradeBtn', function() {
                var gradeId = $(this).data('id');
                if (confirm("Are you sure you want to delete this grade?")) {
                    $.ajax({
                        url: "{{ route('grades.destroy', ['grade' => ':gradeId']) }}".replace(
                            ':gradeId', gradeId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#tableData').html(response
                                .table_html);

                            $('#gradeMessage').html(
                                '<div class="alert alert-success" role="alert">Grade deleted successfully.</div>'
                            );

                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });
                        },
                        error: function(error) {
                            console.error(error);
                            $('#gradeMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete grade.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
