@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Generations</h2>
        <p class="card-text">Generations table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openGenerationModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Generation</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Generation Messages -->
                        <div id="generationMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.generations.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Generation modal -->
    <div class="modal fade" id="generationModal" tabindex="-1" role="dialog" aria-labelledby="generationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generationModalLabel">New Generation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createGenerationForm">
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
                        <button type="submit" class="btn btn-primary" id="saveGenerationBtn">Save Generation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Generation modal -->
    <div class="modal fade" id="editGenerationModal" tabindex="-1" role="dialog" aria-labelledby="editGenerationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGenerationModalLabel">Edit Generation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editGenerationForm">
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
                        <button type="submit" class="btn btn-primary" id="updateGenerationBtn">Update Generation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openGenerationModal').click(function() {
                $('#generationModal').modal('show');
            });

            $('#createGenerationForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('generations.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#generationModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#generationMessage').html(
                            '<div class="alert alert-success" role="alert">Generation created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#generationMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create generation.</div>'
                        );
                    }
                });
            });

            $('#editGenerationForm').submit(function(e) {
                e.preventDefault();
                var generationId = $('#edit_id').val();
                var url = "{{ route('generations.update', ['generation' => ':generation']) }}".replace(':generation', generationId);
                $.ajax({
                    url: url,
                    method: "PUT",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editGenerationModal').modal('hide');
                        $('#tableData').html(response.generations);
                        $('#generationMessage').html(
                            '<div class="alert alert-success" role="alert">Generation updated successfully.</div>'
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
                        $('#generationMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update generation.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editGenerationBtn', function() {
                var generationId = $(this).data('id');
                var url = "{{ route('generations.edit', ['generation' => ':generation']) }}".replace(':generation', generationId);

                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.generation.id);
                        $('#edit_name').val(response.generation.name);
                        $('#edit_model_id').val(response.generation.model_id);
                        $('#edit_status').val(response.generation.status);
                        $('#editGenerationModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#generationMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch generation details for editing.</div>'
                        );
                    }
                });
            });

            // Delete generation
            $(document).on('click', '.deleteGenerationBtn', function() {
                var generationId = $(this).data('id');
                var url = "{{ route('generations.destroy', ['generation' => ':generation']) }}".replace(':generation', generationId);
                if (confirm("Are you sure you want to delete this generation?")) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response
                                .generations);
                            $('#generationMessage').html(
                                '<div class="alert alert-success" role="alert">Generation updated successfully.</div>'
                            );
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#generationMessage').html(
                                '<div class="alert alert-success" role="alert">Generation deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#generationMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete generation.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
