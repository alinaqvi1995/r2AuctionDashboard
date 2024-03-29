@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Carriers</h2>
        <p class="card-text">Carriers table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openCarrierModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Carrier</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Carrier Messages -->
                        <div id="carrierMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.carriers.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Carrier modal -->
    <div class="modal fade" id="carrierModal" tabindex="-1" role="dialog" aria-labelledby="carrierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carrierModalLabel">New Carrier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createCarrierForm">
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
                        <button type="submit" class="btn btn-primary" id="saveCarrierBtn">Save Carrier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Carrier modal -->
    <div class="modal fade" id="editCarrierModal" tabindex="-1" role="dialog" aria-labelledby="editCarrierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCarrierModalLabel">Edit Carrier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCarrierForm" method="POST">
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
                        <button type="submit" class="btn btn-primary" id="updateCarrierBtn">Update Carrier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new carrier modal
            $('#openCarrierModal').click(function() {
                $('#carrierModal').modal('show');
            });

            // Handle form submission for creating a new carrier
            $('#createCarrierForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('carriers.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#carrierModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#carrierMessage').html(
                            '<div class="alert alert-success" role="alert">Carrier created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#carrierMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create carrier.</div>'
                        );
                    }
                });
            });

            // Show edit carrier modal
            $(document).on('click', '.editCarrierBtn', function() {
                var carrierId = $(this).data('id');
                $.ajax({
                    url: "/carriers/" + carrierId + "/edit",
                    method: "GET",
                    success: function(response) {
                        console.log('response', response);
                        $('#edit_id').val(response.carrier.id);
                        $('#edit_name').val(response.carrier.name);
                        $('#edit_description').val(response.carrier.description);
                        $('#edit_status').val(response.carrier.status);
                        $('#editCarrierModal').modal('show');

                        // Set the action attribute of the form to include the carrierId parameter
                        $('#editCarrierForm').attr('action',
                            "{{ route('carriers.update', ['carrier' => ':carrierId']) }}".replace(
                                ':carrierId', carrierId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#carrierMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch carrier details for editing.</div>'
                            );
                    }
                });
            });
        });
    </script>
@endsection
