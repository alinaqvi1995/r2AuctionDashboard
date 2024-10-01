@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Connectivities</h2>
        <p class="card-text">Connectivities table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openConnectivityModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Connectivity</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Connectivity Messages -->
                        <div id="connectivityMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.connectivities.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Connectivity modal -->
    <div class="modal fade" id="connectivityModal" tabindex="-1" role="dialog" aria-labelledby="connectivityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connectivityModalLabel">New Connectivity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createConnectivityForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="model_id">Models</label>
                            <select class="form-control" id="model_id" name="model_id" required>
                                <option value="" selected disabled>Select Model Name</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveConnectivityBtn">Save Connectivity</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Connectivity modal -->
    <div class="modal fade" id="editConnectivityModal" tabindex="-1" role="dialog" aria-labelledby="editConnectivityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editConnectivityModalLabel">Edit Connectivity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editConnectivityForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_model_id">Models</label>
                            <select class="form-control" id="edit_model_id" name="model_id" required>
                                <option value="" selected disabled>Select Model Name</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateConnectivityBtn">Update Connectivity</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openConnectivityModal').click(function() {
                $('#connectivityModal').modal('show');
            });

            $('#createConnectivityForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('connectivity.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#connectivityModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#connectivityMessage').html(
                            '<div class="alert alert-success" role="alert">Connectivity created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#connectivityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create connectivity.</div>'
                        );
                    }
                });
            });

            $('#editConnectivityForm').submit(function(e) {
                e.preventDefault();
                var connectivityId = $('#edit_id').val();
                var url = "{{ route('connectivity.update', ['connectivity' => ':connectivity']) }}".replace(':connectivity', connectivityId);
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editConnectivityModal').modal('hide');
                        $('#tableData').html(response.connectivities);
                        $('#connectivityMessage').html(
                            '<div class="alert alert-success" role="alert">Connectivity updated successfully.</div>'
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
                        $('#connectivityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update connectivity.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editConnectivityBtn', function() {
                var connectivityId = $(this).data('id');
                console.log('connectivityId', connectivityId);
                var url = "{{ route('connectivity.edit', ['connectivity' => ':connectivity']) }}".replace(':connectivity', connectivityId);

                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.connectivity.id);
                        $('#edit_name').val(response.connectivity.name);
                        $('#edit_model_id').val(response.connectivity.model_id);
                        $('#edit_status').val(response.connectivity.status);
                        $('#editConnectivityModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#connectivityMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch connectivity details for editing.</div>'
                        );
                    }
                });
            });

            // Delete connectivity
            $(document).on('click', '.deleteConnectivityBtn', function() {
                var connectivityId = $(this).data('id');
                var url = "{{ route('connectivity.destroy', ['connectivity' => ':connectivity']) }}".replace(':connectivity', connectivityId);
                if (confirm("Are you sure you want to delete this connectivity?")) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response
                                .connectivities);
                            $('#connectivityMessage').html(
                                '<div class="alert alert-success" role="alert">Connectivity updated successfully.</div>'
                            );
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#connectivityMessage').html(
                                '<div class="alert alert-success" role="alert">Connectivity deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#connectivityMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete connectivity.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
