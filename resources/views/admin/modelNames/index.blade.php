@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">ModelNames</h2>
        <p class="card-text">ModelNames table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openModelNameModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New ModelName</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- ModelName Messages -->
                        <div id="modelNameMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.modelNames.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New ModelName modal -->
    <div class="modal fade" id="modelNameModal" tabindex="-1" role="dialog" aria-labelledby="modelNameModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelNameModalLabel">New ModelName</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createModelNameForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="index">Index</label>
                            <input type="number" class="form-control" id="index" name="index">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer_id">Manufacturer</label>
                            <select class="form-control" id="manufacturer_id" name="manufacturer_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($manufacturer as $row)
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
                        <button type="submit" class="btn btn-primary" id="saveModelNameBtn">Save ModelName</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit ModelName modal -->
    <div class="modal fade" id="editModelNameModal" tabindex="-1" role="dialog" aria-labelledby="editModelNameModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModelNameModalLabel">Edit ModelName</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editModelNameForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_index">Index</label>
                            <input type="number" class="form-control" id="edit_index" name="index">
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Category</label>
                            <select class="form-control" id="edit_category" name="category_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_manufacturer">Manufacturer</label>
                            <select class="form-control" id="edit_manufacturer" name="manufacturer_id" required>
                                <option value="" disabled selected>Select</option>
                                @foreach ($manufacturer as $row)
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
                        <button type="submit" class="btn btn-primary" id="updateModelNameBtn">Update ModelName</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openModelNameModal').click(function() {
                $('#modelNameModal').modal('show');
            });

            $('#createModelNameForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('modelNames.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#modelNameModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#modelNameMessage').html(
                            '<div class="alert alert-success" role="alert">ModelName created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#modelNameMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create modelName.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editModelNameBtn', function() {
                var modelNameId = $(this).data('id');
                $.ajax({
                    url: "{{ route('modelNames.edit', ['modelName' => ':modelNameId']) }}".replace(':modelNameId',
                        modelNameId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.modelName.id);
                        $('#edit_name').val(response.modelName.name);
                        $('#edit_index').val(response.modelName.index);
                        $('#edit_status').val(response.modelName.status);
                        $('#edit_category').val(response.modelName.category_id);
                        $('#edit_manufacturer').val(response.modelName.manufacturer_id);
                        $('#editModelNameModal').modal('show');

                        $('#editModelNameForm').attr('action',
                            "{{ route('modelNames.update', ['modelName' => ':modelNameId']) }}".replace(
                                ':modelNameId', modelNameId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#modelNameMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch modelName details for editing.</div>'
                        );
                    }
                });
            });

            $('#editModelNameForm').submit(function(e) {
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
                        $('#editModelNameModal').modal('hide');

                        $('#tableData').html(response
                            .table_html);

                        $('#modelNameMessage').html(
                            '<div class="alert alert-success" role="alert">ModelName updated successfully.</div>'
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
                        $('#modelNameMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update modelName.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteModelNameBtn', function() {
                var modelNameId = $(this).data('id');
                if (confirm("Are you sure you want to delete this modelName?")) {
                    $.ajax({
                        url: "{{ route('modelNames.destroy', ['modelName' => ':modelNameId']) }}".replace(
                            ':modelNameId', modelNameId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#tableData').html(response
                                .table_html);

                            $('#modelNameMessage').html(
                                '<div class="alert alert-success" role="alert">ModelName deleted successfully.</div>'
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
                            $('#modelNameMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete modelName.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
