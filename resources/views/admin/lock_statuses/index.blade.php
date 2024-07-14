@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Lock Statuses</h2>
        <p class="card-text">Lock Statuses table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openLockStatusModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Lock Status</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- LockStatus Messages -->
                        <div id="lockStatusMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.lock_statuses.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New LockStatus modal -->
    <div class="modal fade" id="lockStatusModal" tabindex="-1" role="dialog" aria-labelledby="lockStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lockStatusModalLabel">New Lock Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createLockStatusForm">
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
                        <button type="submit" class="btn btn-primary" id="saveLockStatusBtn">Save Lock Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit LockStatus modal -->
    <div class="modal fade" id="editLockStatusModal" tabindex="-1" role="dialog"
        aria-labelledby="editLockStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLockStatusModalLabel">Edit Lock Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editLockStatusForm" method="POST">
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
                        <button type="submit" class="btn btn-primary" id="updateLockStatusBtn">Update Lock Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new lock status modal
            $('#openLockStatusModal').click(function() {
                $('#lockStatusModal').modal('show');
            });

            // Handle form submission for creating a new lock status
            $('#createLockStatusForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('lockstatuses.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#lockStatusModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#lockStatusMessage').html(
                            '<div class="alert alert-success" role="alert">Lock Status created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#lockStatusMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create Lock Status.</div>'
                        );
                    }
                });
            });

            // Show edit lock status modal
            $(document).on('click', '.editLockStatusBtn', function() {
                var lockStatusId = $(this).data('id');
                $.ajax({
                    url: "/lock_statuses/" + lockStatusId + "/edit",
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.lockStatus.id);
                        $('#edit_name').val(response.lockStatus.name);
                        $('#edit_description').val(response.lockStatus.description);
                        $('#edit_status').val(response.lockStatus.status);
                        $('#editLockStatusModal').modal('show');

                        // Set the action attribute of the form to include the lockStatusId parameter
                        $('#editLockStatusForm').attr('action',
                            "{{ route('lockstatuses.update', ['lockStatus' => ':lockStatusId']) }}"
                            .replace(
                                ':lockStatusId', lockStatusId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#lockStatusMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch Lock Status details for editing.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a lock status
            // $('#editLockStatusForm').submit(function(e) {
            //     e.preventDefault();
            //     var lockStatusId = $('#edit_id').val();
            //     $.ajax({
            //         url: "/lock_statuses/" + lockStatusId,
            //         method: "PUT",
            //         data: $(this).serialize(),
            //         success: function(response) {
            //             $('#editLockStatusModal').modal('hide');
            //             $('#tableData').html(response.table_html);

            //             $('#lockStatusMessage').html(
            //                 '<div class="alert alert-success" role="alert">Lock Status updated successfully.</div>'
            //             );
            //         },
            //         error: function(error) {
            //             console.error(error);
            //             $('#lockStatusMessage').html(
            //                 '<div class="alert alert-danger" role="alert">Failed to update Lock Status.</div>'
            //             );
            //         }
            //     });
            // });

            // Delete lock status
            $(document).on('click', '.deleteLockStatusBtn', function() {
                var lockStatusId = $(this).data('id');
                if (confirm("Are you sure you want to delete this Lock Status?")) {
                    $.ajax({
                        url: "/lock_statuses/" + lockStatusId,
                        method: "DELETE",
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            $('#lockStatusMessage').html(
                                '<div class="alert alert-success" role="alert">Lock Status deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#lockStatusMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete Lock Status.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
