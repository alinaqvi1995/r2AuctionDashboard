@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Categories</h2>
        <p class="card-text">Categories table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openCategoryModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Category</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Category Messages -->
                        <div id="categoryMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.categories.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Category modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createCategoryForm" enctype="multipart/form-data">
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
                            <label for="icon">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="icon" name="icon" required>
                                <label class="custom-file-label" for="image" id="icon_label">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveCategoryBtn">Save Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" enctype="multipart/form-data" method="POST"
                        action="{{ route('categories.update', ['category' => ':categoryId']) }}">
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
                            <label for="edit_icon">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_icon" name="icon">
                                <label class="custom-file-label" for="edit_icon" id="edit_icon_label">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateCategoryBtn">Update
                            Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new category modal
            $('#openCategoryModal').click(function() {
                $('#categoryModal').modal('show');
            });

            // Handle form submission for creating a new category
            $('#createCategoryForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('categories.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#categoryModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#categoryMessage').html(
                            '<div class="alert alert-success" role="alert">Category created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#categoryMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create category.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a category
            // $('#editCategoryForm').submit(function(e) {
            // e.preventDefault();
            // var categoryId = $('#edit_id').val(); // Ensure this is getting the correct value

            // $.ajax({
            //     url: "{{ route('categories.update', ['category' => ':categoryId']) }}"
            //         .replace(':categoryId', categoryId),
            //     method: "POST",
            //     enctype: 'multipart/form-data',
            //     data: new FormData(this),
            //     contentType: false,
            //     processData: false,
            //     success: function(response) {
            //         $('#editCategoryModal').modal('hide');
            //         $('#tableData').html(response.categories);
            //         $('#categoryMessage').html(
            //             '<div class="alert alert-success" role="alert">Category updated successfully.</div>'
            //         );
            //     },
            //     error: function(error) {
            //         console.error(error);
            //         $('#categoryMessage').html(
            //             '<div class="alert alert-danger" role="alert">Failed to update category.</div>'
            //         );
            //     }
            // });
            // });


            // Show edit category modal
            $(document).on('click', '.editCategoryBtn', function() {
                var categoryId = $(this).data('id');
                $.ajax({
                    url: "{{ route('categories.edit', ['category' => ':categoryId']) }}"
                        .replace(':categoryId', categoryId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.category.id);
                        $('#edit_name').val(response.category.name);
                        $('#edit_description').val(response.category.description);

                        $('#editCategoryModal').modal('show');

                        $('#editCategoryForm').attr('action',
                            "{{ route('categories.update', ['category' => ':categoryId']) }}"
                            .replace(':categoryId', categoryId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#categoryMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch category details for editing.</div>'
                        );
                    }
                });
            });

            // Delete category
            $(document).on('click', '.deleteCategoryBtn', function() {
                var categoryId = $(this).data('id');
                if (confirm("Are you sure you want to delete this category?")) {
                    $.ajax({
                        url: "{{ route('categories.destroy', ['category' => ':categoryId']) }}"
                            .replace(':categoryId', categoryId),
                        method: "DELETE",
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            $('#categoryMessage').html(
                                '<div class="alert alert-success" role="alert">Category deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#categoryMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete category.</div>'
                            );
                        }
                    });
                }
            });

            // Update label text when files are selected for additional icon
            $('#icon').on('change', function() {
                // Get the file names
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                // Update the label text
                $('#icon_label').text(fileNames);
            });

            // Update label text when files are selected for additional icon
            $('#edit_icon').on('change', function() {
                // Get the file names
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                // Update the label text
                $('#edit_icon_label').text(fileNames);

                // Debug: Log the files array to see if the file data is captured
                console.log('Selected files:', files);
            });
        });
    </script>
@endsection
