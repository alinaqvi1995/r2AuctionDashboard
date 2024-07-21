@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Rams</h2>
        <p class="card-text">Rams table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openRamModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Ram</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Ram Messages -->
                        <div id="ramMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.rams.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Ram modal -->
    <div class="modal fade" id="ramModal" tabindex="-1" role="dialog" aria-labelledby="ramModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ramModalLabel">New Ram</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRamForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveRamBtn">Save Ram</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Ram modal -->
    <div class="modal fade" id="editRamModal" tabindex="-1" role="dialog" aria-labelledby="editRamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRamModalLabel">Edit Ram</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRamForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateRamBtn">Update Ram</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openRamModal').click(function() {
                $('#ramModal').modal('show');
            });

            $('#createRamForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('rams.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#ramModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#ramMessage').html(
                            '<div class="alert alert-success" role="alert">Ram created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#ramMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create ram.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editRamBtn', function() {
                var ramId = $(this).data('id');
                $.ajax({
                    url: "{{ route('rams.edit', ['ram' => ':ramId']) }}".replace(':ramId',
                        ramId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.ram.id);
                        $('#edit_name').val(response.ram.name);
                        $('#edit_status').val(response.ram.status);
                        $('#editRamModal').modal('show');

                        $('#editRamForm').attr('action',
                            "{{ route('rams.update', ['ram' => ':ramId']) }}".replace(
                                ':ramId', ramId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#ramMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch ram details for editing.</div>'
                        );
                    }
                });
            });

            $('#editRamForm').submit(function(e) {
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
                        $('#editRamModal').modal('hide');

                        $('#tableData').html(response
                            .table_html);

                        $('#ramMessage').html(
                            '<div class="alert alert-success" role="alert">Ram updated successfully.</div>'
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
                        $('#ramMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update ram.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteRamBtn', function() {
                var ramId = $(this).data('id');
                if (confirm("Are you sure you want to delete this ram?")) {
                    $.ajax({
                        url: "{{ route('rams.destroy', ['ram' => ':ramId']) }}".replace(
                            ':ramId', ramId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#tableData').html(response
                                .table_html);

                            $('#ramMessage').html(
                                '<div class="alert alert-success" role="alert">Ram deleted successfully.</div>'
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
                            $('#ramMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete ram.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
