@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Regions</h2>
        <p class="card-text">Regions table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openRegionModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Region</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Region Messages -->
                        <div id="regionMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.regions.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Region modal -->
    <div class="modal fade" id="regionModal" tabindex="-1" role="dialog" aria-labelledby="regionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regionModalLabel">New Region</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRegionForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveRegionBtn">Save Region</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Region modal -->
    <div class="modal fade" id="editRegionModal" tabindex="-1" role="dialog" aria-labelledby="editRegionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRegionModalLabel">Edit Region</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRegionForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateRegionBtn">Update Region</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new region modal
            $('#openRegionModal').click(function() {
                $('#regionModal').modal('show');
            });

            // Handle form submission for creating a new region
            $('#createRegionForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('regions.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#regionModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#regionMessage').html(
                            '<div class="alert alert-success" role="alert">Region created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#regionMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create region.</div>'
                        );
                    }
                });
            });

            // Show edit region modal
            $(document).on('click', '.editRegionBtn', function() {
                var regionId = $(this).data('id');
                $.ajax({
                    url: "{{ route('regions.edit', ['region' => ':regionId']) }}".replace(':regionId', regionId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.region.id);
                        $('#edit_name').val(response.region.name);
                        $('#edit_description').val(response.region.description);
                        $('#edit_status').val(response.region.status);
                        $('#editRegionModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#regionMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch region details for editing.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a region
            $('#editRegionForm').submit(function(e) {
                e.preventDefault();
                var regionId = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('regions.update', ['region' => ':regionId']) }}".replace(':regionId', regionId),
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editRegionModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#regionMessage').html(
                            '<div class="alert alert-success" role="alert">Region updated successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#regionMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update region.</div>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
