@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Materials</h2>
        <p class="card-text">Materials table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openMaterialModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Material</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Material Messages -->
                        <div id="materialMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.materials.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Material modal -->
    <div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-labelledby="materialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialModalLabel">New Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createMaterialForm">
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
                        <button type="submit" class="btn btn-primary" id="saveMaterialBtn">Save Material</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Material modal -->
    <div class="modal fade" id="editMaterialModal" tabindex="-1" role="dialog" aria-labelledby="editMaterialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMaterialModalLabel">Edit Material</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editMaterialForm">
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
                        <button type="submit" class="btn btn-primary" id="updateMaterialBtn">Update Material</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openMaterialModal').click(function() {
                $('#materialModal').modal('show');
            });

            $('#createMaterialForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('materials.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#materialModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#materialMessage').html(
                            '<div class="alert alert-success" role="alert">Material created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#materialMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create material.</div>'
                        );
                    }
                });
            });

            $('#editMaterialForm').submit(function(e) {
                e.preventDefault();
                var materialId = $('#edit_id').val();
                var url = "{{ route('materials.update', ['material' => ':material']) }}".replace(':material', materialId);
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editMaterialModal').modal('hide');
                        $('#tableData').html(response.materials);
                        $('#materialMessage').html(
                            '<div class="alert alert-success" role="alert">Material updated successfully.</div>'
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
                        $('#materialMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update material.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editMaterialBtn', function() {
                var materialId = $(this).data('id');
                var url = "{{ route('materials.edit', ['material' => ':material']) }}".replace(':material', materialId);

                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.material.id);
                        $('#edit_name').val(response.material.name);
                        $('#edit_model_id').val(response.material.model_id);
                        $('#edit_status').val(response.material.status);
                        $('#editMaterialModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#materialMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch material details for editing.</div>'
                        );
                    }
                });
            });

            // Delete material
            $(document).on('click', '.deleteMaterialBtn', function() {
                var materialId = $(this).data('id');
                var url = "{{ route('materials.destroy', ['material' => ':material']) }}".replace(':material', materialId);
                if (confirm("Are you sure you want to delete this material?")) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response
                                .materials);
                            $('#materialMessage').html(
                                '<div class="alert alert-success" role="alert">Material updated successfully.</div>'
                            );
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#materialMessage').html(
                                '<div class="alert alert-success" role="alert">Material deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#materialMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete material.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
