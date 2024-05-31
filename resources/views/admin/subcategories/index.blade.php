@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Subcategories</h2>
        <p class="card-text">Subcategories table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openSubcategoryModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Subcategory</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Subcategory Messages -->
                        <div id="subcategoryMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.subcategories.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Subcategory modal -->
    <div class="modal fade" id="subcategoryModal" tabindex="-1" role="dialog" aria-labelledby="subcategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subcategoryModalLabel">New Subcategory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSubcategoryForm">
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
                            <label for="category_id">Category</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <button type="submit" class="btn btn-primary" id="saveSubcategoryBtn">Save Subcategory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Subcategory modal -->
    <div class="modal fade" id="editSubcategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="editSubcategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubcategoryModalLabel">Edit Subcategory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editSubcategoryForm">
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
                            <label for="edit_category_id">Category</label>
                            <select class="form-control" id="edit_category_id" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                        <button type="submit" class="btn btn-primary" id="updateSubcategoryBtn">Update
                            Subcategory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openSubcategoryModal').click(function() {
                $('#subcategoryModal').modal('show');
            });

            $('#createSubcategoryForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('subcategories.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#subcategoryModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#subcategoryMessage').html(
                            '<div class="alert alert-success" role="alert">Subcategory created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#subcategoryMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create subcategory.</div>'
                        );
                    }
                });
            });

            $('#editSubcategoryForm').submit(function(e) {
                e.preventDefault();
                var subcategoryId = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('subcategories.destroy', ':id') }}".replace(':id',
                        subcategoryId),
                    method: "PUT",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editSubcategoryModal').modal('hide');
                        $('#tableData').html(response
                            .subcategories);
                        $('#subcategoryMessage').html(
                            '<div class="alert alert-success" role="alert">Subcategory updated successfully.</div>'
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
                        $('#subcategoryMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update subcategory.</div>'
                        );
                    }
                });
            });

            // Show edit subcategory modal
            $(document).on('click', '.editSubcategoryBtn', function() {
                var subcategoryId = $(this).data('id');
                var url = "{{ route('subcategories.edit', ':id') }}".replace(':id', subcategoryId);
                $.ajax({
                    url: url,
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.subcategory.id);
                        $('#edit_name').val(response.subcategory.name);
                        $('#edit_description').val(response.subcategory.description);
                        $('#edit_category_id').val(response.subcategory.category_id);
                        $('#edit_status').val(response.subcategory.status);
                        $('#editSubcategoryModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#subcategoryMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch subcategory details for editing.</div>'
                        );
                    }
                });
            });

            // Delete subcategory
            $(document).on('click', '.deleteSubcategoryBtn', function() {
                var subcategoryId = $(this).data('id');
                var url = "{{ route('subcategories.destroy', ':id') }}".replace(':id', subcategoryId);

                if (confirm("Are you sure you want to delete this subcategory?")) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#tableData').html(response
                                .subcategories);

                            $('#subcategoryMessage').html(
                                '<div class="alert alert-success" role="alert">Subcategory deleted successfully.</div>'
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
                            $('#subcategoryMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete subcategory.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
