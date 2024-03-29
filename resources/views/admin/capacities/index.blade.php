@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Capacities</h2>
        <p class="card-text">Capacities table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openCapacityModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Capacity</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Capacity Messages -->
                        <div id="capacityMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.capacities.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Capacity modal -->
    <div class="modal fade" id="capacityModal" tabindex="-1" role="dialog" aria-labelledby="capacityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="capacityModalLabel">New Capacity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createCapacityForm">
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
                        <button type="submit" class="btn btn-primary" id="saveCapacityBtn">Save Capacity</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Capacity modal -->
    <div class="modal fade" id="editCapacityModal" tabindex="-1" role="dialog" aria-labelledby="editCapacityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCapacityModalLabel">Edit Capacity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCapacityForm">
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
                        <button type="submit" class="btn btn-primary" id="updateCapacityBtn">Update Capacity</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new capacity modal
            $('#openCapacityModal').click(function() {
                $('#capacityModal').modal('show');
            });

            // Handle form submission for creating a new capacity
            $('#createCapacityForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('capacities.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#capacityModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#capacityMessage').html(
                            '<div class="alert alert-success" role="alert">Capacity created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#capacityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create capacity.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a capacity
            $('#editCapacityForm').submit(function(e) {
                e.preventDefault();
                var capacityId = $('#edit_id').val();
                $.ajax({
                    url: "/capacities/" + capacityId,
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editCapacityModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Destroy DataTable instance before reinitializing
                        $('#dataTable-1').DataTable().destroy();

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#capacityMessage').html(
                            '<div class="alert alert-success" role="alert">Capacity updated successfully.</div>'
                            );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#capacityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update capacity.</div>'
                            );
                    }
                });
            });

            // Show edit capacity modal
            $(document).on('click', '.editCapacityBtn', function() {
                var capacityId = $(this).data('id');
                $.ajax({
                    url: "/capacities/" + capacityId + "/edit",
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.capacity.id);
                        $('#edit_name').val(response.capacity.name);
                        $('#edit_description').val(response.capacity.description);
                        $('#edit_status').val(response.capacity.status);
                        $('#editCapacityModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#capacityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch capacity details for editing.</div>'
                        );
                    }
                });
            });

            // Delete capacity
            $(document).on('click', '.deleteCapacityBtn', function() {
                var capacityId = $(this).data('id');
                if (confirm("Are you sure you want to delete this capacity?")) {
                    $.ajax({
                        url: "/capacities/" + capacityId,
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

                            $('#capacityMessage').html(
                                '<div class="alert alert-success" role="alert">Capacity deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#capacityMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete capacity.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
