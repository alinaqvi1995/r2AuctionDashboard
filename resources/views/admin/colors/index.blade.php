@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Colors</h2>
        <p class="card-text">Colors table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openColorModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Color</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Color Messages -->
                        <div id="colorMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.colors.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Color modal -->
    <div class="modal fade" id="colorModal" tabindex="-1" role="dialog" aria-labelledby="colorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="colorModalLabel">New Color</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createColorForm">
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
                            <label for="color_code">Color Code</label>
                            <input type="text" class="form-control" id="color_code" name="color_code" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveColorBtn">Save Color</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Color modal -->
    <div class="modal fade" id="editColorModal" tabindex="-1" role="dialog" aria-labelledby="editColorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editColorModalLabel">Edit Color</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editColorForm">
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
                            <label for="edit_color_code">Color Code</label>
                            <input type="text" class="form-control" id="edit_color_code" name="color_code" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateColorBtn">Update Color</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new color modal
            $('#openColorModal').click(function() {
                $('#colorModal').modal('show');
            });

            // Handle form submission for creating a new color
            $('#createColorForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('colors.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#colorModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#colorMessage').html(
                            '<div class="alert alert-success" role="alert">Color created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#colorMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create color.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a color
            $('#editColorForm').submit(function(e) {
                e.preventDefault();
                var colorId = $('#edit_id').val();
                $.ajax({
                    url: "/colors/" + colorId,
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editColorModal').modal('hide');
                        $('#tableData').html(response.colors); // Corrected key for table HTML
                        $('#colorMessage').html(
                            '<div class="alert alert-success" role="alert">Color updated successfully.</div>'
                        );
                        // Reinitialize DataTables after updating table content
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
                        $('#colorMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update color.</div>'
                        );
                    }
                });
            });

            // Show edit color modal
            $(document).on('click', '.editColorBtn', function() {
                var colorId = $(this).data('id');
                $.ajax({
                    url: "/colors/" + colorId + "/edit",
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.color.id);
                        $('#edit_name').val(response.color.name);
                        $('#edit_description').val(response.color.description);
                        $('#edit_color_code').val(response.color.color_code);
                        $('#edit_status').val(response.color.status);
                        $('#editColorModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#colorMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch color details for editing.</div>'
                        );
                    }
                });
            });

            // Delete color
            $(document).on('click', '.deleteColorBtn', function() {
                var colorId = $(this).data('id');
                if (confirm("Are you sure you want to delete this color?")) {
                    $.ajax({
                        url: "/colors/" + colorId,
                        method: "DELETE",
                        success: function(response) {
                            $('#tableData').html(response
                                .table_html);

                            // Reinitialize DataTables after updating table content
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#colorMessage').html(
                                '<div class="alert alert-success" role="alert">Color deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#colorMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete color.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
