@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Sizes</h2>
        <p class="card-text">Sizes table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openSizeModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Size</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Size Messages -->
                        <div id="sizeMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.sizes.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Size modal -->
    <div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-labelledby="sizeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sizeModalLabel">New Size</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSizeForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="model_id">Model</label>
                            <select class="form-control" id="model_id" name="model_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($models as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveSizeBtn">Save Size</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Size modal -->
    <div class="modal fade" id="editSizeModal" tabindex="-1" role="dialog" aria-labelledby="editSizeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSizeModalLabel">Edit Size</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editSizeForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_model">Model</label>
                            <select class="form-control" id="edit_model" name="model_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($models as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
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
                        <button type="submit" class="btn btn-primary" id="updateSizeBtn">Update Size</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openSizeModal').click(function() {
                $('#sizeModal').modal('show');
            });

            $('#createSizeForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('sizes.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#sizeModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#sizeMessage').html(
                            '<div class="alert alert-success" role="alert">Size created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#sizeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create size.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editSizeBtn', function() {
                var sizeId = $(this).data('id');
                $.ajax({
                    url: "{{ route('sizes.edit', ['size' => ':sizeId']) }}".replace(':sizeId',
                        sizeId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.size.id);
                        $('#edit_name').val(response.size.name);
                        $('#edit_status').val(response.size.status);
                        $('#edit_model').val(response.size.model_id);
                        $('#editSizeModal').modal('show');

                        $('#editSizeForm').attr('action',
                            "{{ route('sizes.update', ['size' => ':sizeId']) }}".replace(
                                ':sizeId', sizeId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#sizeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch size details for editing.</div>'
                        );
                    }
                });
            });

            $('#editSizeForm').submit(function(e) {
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
                        $('#editSizeModal').modal('hide');

                        $('#tableData').html(response
                            .table_html);

                        $('#sizeMessage').html(
                            '<div class="alert alert-success" role="alert">Size updated successfully.</div>'
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
                        $('#sizeMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update size.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteSizeBtn', function() {
                var sizeId = $(this).data('id');
                if (confirm("Are you sure you want to delete this size?")) {
                    $.ajax({
                        url: "{{ route('sizes.destroy', ['size' => ':sizeId']) }}".replace(
                            ':sizeId', sizeId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#tableData').html(response
                                .table_html);

                            $('#sizeMessage').html(
                                '<div class="alert alert-success" role="alert">Size deleted successfully.</div>'
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
                            $('#sizeMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete size.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
