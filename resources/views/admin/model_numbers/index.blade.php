@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Model Numbers</h2>
        <p class="card-text">Model Numbers table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openModelNumberModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Model Number</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- ModelNumber Messages -->
                        <div id="modelNumberMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.model_numbers.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New ModelNumber modal -->
    <div class="modal fade" id="modelNumberModal" tabindex="-1" role="dialog" aria-labelledby="modelNumberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelNumberModalLabel">New Model Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createModelNumberForm">
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
                        <button type="submit" class="btn btn-primary" id="saveModelNumberBtn">Save Model Number</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit ModelNumber modal -->
    <div class="modal fade" id="editModelNumberModal" tabindex="-1" role="dialog"
        aria-labelledby="editModelNumberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModelNumberModalLabel">Edit Model Number</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editModelNumberForm" method="POST">
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
                        <button type="submit" class="btn btn-primary" id="updateModelNumberBtn">Update Model
                            Number</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new model number modal
            $('#openModelNumberModal').click(function() {
                $('#modelNumberModal').modal('show');
            });

            // Handle form submission for creating a new model number
            $('#createModelNumberForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('modelnumbers.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modelNumberModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#modelNumberMessage').html(
                            '<div class="alert alert-success" role="alert">Model Number created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#modelNumberMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create Model Number.</div>'
                        );
                    }
                });
            });

            // Show edit model number modal
            $(document).on('click', '.editModelNumberBtn', function() {
                var modelNumberId = $(this).data('id');
                $.ajax({
                    url: "/model_numbers/" + modelNumberId + "/edit",
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.modelnumber.id);
                        $('#edit_name').val(response.modelnumber.name);
                        $('#edit_description').val(response.modelnumber.description);
                        $('#edit_status').val(response.modelnumber.status);
                        $('#editModelNumberModal').modal('show');

                        // Set the action attribute of the form to include the modelNumberId parameter
                        $('#editModelNumberForm').attr('action',
                            "{{ route('modelnumbers.update', ['modelnumber' => ':modelNumberId']) }}"
                            .replace(
                                ':modelNumberId', modelNumberId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#modelNumberMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch Model Number details for editing.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a model number
            // $('#editModelNumberForm').submit(function(e) {
            //     e.preventDefault();
            //     var modelNumberId = $('#edit_id').val();
            //     $.ajax({
            //         url: "/model_numbers/" + modelNumberId,
            //         method: "PUT",
            //         data: $(this).serialize(),
            //         success: function(response) {
            //             $('#editModelNumberModal').modal('hide');
            //             $('#tableData').html(response.table_html);

            //             $('#modelNumberMessage').html(
            //                 '<div class="alert alert-success" role="alert">Model Number updated successfully.</div>'
            //             );
            //         },
            //         error: function(error) {
            //             console.error(error);
            //             $('#modelNumberMessage').html(
            //                 '<div class="alert alert-danger" role="alert">Failed to update Model Number.</div>'
            //             );
            //         }
            //     });
            // });

            // Delete model number
            $(document).on('click', '.deleteModelNumberBtn', function() {
                var modelNumberId = $(this).data('id');
                if (confirm("Are you sure you want to delete this Model Number?")) {
                    $.ajax({
                        url: "/model_numbers/" + modelNumberId,
                        method: "DELETE",
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            $('#modelNumberMessage').html(
                                '<div class="alert alert-success" role="alert">Model Number deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#modelNumberMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete Model Number.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
