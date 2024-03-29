@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Variants</h2>
            <p class="card-text">Variants table.</p>
            <div class="row my-4">
                <!-- data table -->
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="openVariantModal"><span
                            class="fe fe-plus fe-16 mr-3"></span>New Variant</button>
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Variant Messages -->
                            <div id="variantMessage"></div>
                            <!-- Table Data -->
                            <div id="tableData">
                                @include('dashboard.admin.variants.table')
                            </div>
                        </div>
                    </div>
                </div> <!-- data table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div>

    <!-- New Variant modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variantModalLabel">New Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createVariantForm">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveVariantBtn">Save Variant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Variant modal -->
    <div class="modal fade" id="editVariantModal" tabindex="-1" role="dialog" aria-labelledby="editVariantModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVariantModalLabel">Edit Variant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editVariantForm">
                        @csrf
                        @method('GET')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_type">Type</label>
                            <input type="text" class="form-control" id="edit_type" name="type" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Category</label>
                            <select class="form-control" id="edit_category" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateVariantBtn">Update Variant</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Variant Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this variant?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        // Function to clear edit modal fields
        function clearEditModalFields() {
            $('#edit_title').val('');
            $('#edit_type').val('');
            $('#edit_description').val('');
            $('#edit_category').val('');
            $('#edit_status').val('');
        }

        $(document).ready(function() {
            // Open the variant modal when clicking the "New Variant" button
            $('#openVariantModal').click(function() {
                $('#variantModal').modal('show');
            });

            // Handle click event for editing a variant using event delegation
            $(document).on('click', '.editVariantBtn', function() {
                var variantId = $(this).data('id');
                $.ajax({
                    url: '{{ route('variants.edit', ':id') }}'.replace(':id', variantId),
                    type: 'GET',
                    success: function(response) {
                        console.log('edit', response);
                        // Populate the edit form fields with variant details
                        $('#edit_id').val(response.variant.id);
                        $('#edit_title').val(response.variant.title);
                        $('#edit_type').val(response.variant.type);
                        $('#edit_description').val(response.variant.description);
                        $('#edit_category').val(response.variant.category_id);
                        $('#edit_status').val(response.variant.status);
                        // Show the edit modal
                        $('#editVariantModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#variantMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch variant details for editing</div>'
                        );
                    }
                });
            });

            // Clear edit modal fields when the modal dismisses
            $('#editVariantModal').on('hidden.bs.modal', function() {
                clearEditModalFields();
            });

            // Handle form submission via AJAX for creating a new variant
            $('#createVariantForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('variants.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#variantModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#variantMessage').html(
                            '<div class="alert alert-success" role="alert">Variant created successfully</div>'
                        );
                        setTimeout(function() {
                            $('#variantMessage').html('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#variantMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create variant</div>'
                        );
                    }
                });
            });

            // Handle form submission via AJAX for updating a variant
            $('#editVariantForm').submit(function(event) {
                var variantId = $(this).find('#edit_id').val();
                event.preventDefault();
                var formData = $(this).serialize();
                var url = '{{ route('variants.update', ['variant' => ':id']) }}'.replace(':id', variantId);
                console.log('url', url, variantId);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#editVariantModal').modal('hide');
                        $('#tableData').html(response
                            .table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#variantMessage').html(
                            '<div class="alert alert-success" role="alert">Variant updated successfully</div>'
                        );
                        setTimeout(function() {
                            $('#variantMessage').html('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#variantMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update variant</div>'
                        );
                    }
                });
            });
            // Delete recrod
            $('.deleteVariantBtn').click(function(event) {
                event.preventDefault();
                var deleteForm = $(this).closest('form');
                var formData = deleteForm.serialize();
                var url = deleteForm.attr('action');

                // Show confirmation modal before deleting
                $('#deleteConfirmationModal').modal('show');

                // Handle deletion confirmation
                $('#confirmDeleteBtn').click(function() {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: formData,
                        success: function(response) {
                            $('#deleteConfirmationModal').modal('hide');
                            // Show success message on the page
                            $('#variantMessage').html(
                                '<div class="alert alert-success" role="alert">' +
                                response.message + '</div>');

                            // Optionally, you can remove the deleted variant row from the table
                            deleteForm.closest('tr').remove();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            $('#variantMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete variant</div>'
                            );
                        }
                    });
                });
            });
        });
    </script>
@endsection
