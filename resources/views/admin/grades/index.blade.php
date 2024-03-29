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
            // Open the new grade modal
            $('#openGradeModal').click(function() {
                $('#gradeModal').modal('show');
            });

            // Handle form submission for creating a new grade
            $('#createGradeForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('grades.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#gradeModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTables after updating table content
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

            // Handle form submission for updating a grade
            // $('#editGradeForm').submit(function(e) {
            //     e.preventDefault();
            //     var gradeId = $('#edit_id').val();
            //     console.log('$(this).serialize()', $(this).serialize());
            //     $.ajax({
            //         url: "/grades/" + gradeId,
            //         method: "PUT",
            //         data: $(this).serialize(),
            //         success: function(response) {
            //             $('#editGradeModal').modal('hide');
            //             $('#tableData').html(response.table_html);

            //             // Destroy DataTable instance before reinitializing
            //             $('#dataTable-1').DataTable().destroy();

            //             // Reinitialize DataTables after updating table content
            //             $('#dataTable-1').DataTable({
            //                 autoWidth: true,
            //                 "lengthMenu": [
            //                     [16, 32, 64, -1],
            //                     [16, 32, 64, "All"]
            //                 ]
            //             });

            //             $('#gradeMessage').html(
            //                 '<div class="alert alert-success" role="alert">Grade updated successfully.</div>'
            //                 );
            //         },
            //         error: function(error) {
            //             console.error(error);
            //             $('#gradeMessage').html(
            //                 '<div class="alert alert-danger" role="alert">Failed to update grade.</div>'
            //                 );
            //         }
            //     });
            // });

            // Show edit grade modal
            $(document).on('click', '.editGradeBtn', function() {
                var gradeId = $(this).data('id');
                $.ajax({
                    url: "/grades/" + gradeId + "/edit",
                    method: "GET",
                    success: function(response) {
                        console.log('response', response);
                        $('#edit_id').val(response.grade.id);
                        $('#edit_name').val(response.grade.name);
                        $('#edit_description').val(response.grade.description);
                        $('#edit_status').val(response.grade.status);
                        $('#editGradeModal').modal('show');

                        // Set the action attribute of the form to include the gradeId parameter
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

            // Delete grade
            $(document).on('click', '.deleteGradeBtn', function() {
                var gradeId = $(this).data('id');
                if (confirm("Are you sure you want to delete this grade?")) {
                    $.ajax({
                        url: "/grades/" + gradeId,
                        method: "DELETE",
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            // Reinitialize DataTables after updating table content
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#gradeMessage').html(
                                '<div class="alert alert-success" role="alert">Grade deleted successfully.</div>'
                            );
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
