@extends('dashboard.vendor.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Products</h2>
            <p class="card-text">Products table.</p>
            <div class="row my-4">
                <!-- data table -->
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="openProductModal"><span
                            class="fe fe-plus fe-16 mr-3"></span>New Product</button>
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- Product Messages -->
                            <div id="productMessage"></div>
                            <!-- Table Data -->
                            <div id="tableData">
                                @include('dashboard.vendor.products.table')
                            </div>
                        </div>
                    </div>
                </div> <!-- data table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div>

    <!-- New Product modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createProductForm">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        {{-- <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control category" id="category" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label for="subcategory">Subcategory</label>
                            <select class="form-control" id="subcategory" name="subcategory_id" required>
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="variant_id">Variants</label>
                            </div>
                            @foreach ($variants as $row)
                                <input type="hidden" id="div-{{ $row->id }}" value="{{ $row->title }}" />
                            @endforeach
                            {{-- <div class="form-control"> --}}
                            <select id="variant_id" name="variant_id[]" class="form-control select2" multiple>
                                @foreach ($variants as $row)
                                    <option value="{{ $row->id }}" data-name-{{ $row->id }}="{{ $row->title }}">
                                        {{ $row->title }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- </div> --}}
                        </div>
                        <div class="form-group">
                            <label for="old_price">Regular Price</label>
                            <input type="text" class="form-control" id="old_price" name="old_price">
                        </div>
                        <div class="form-group">
                            <label for="new_price">Discounted Price</label>
                            <input type="text" class="form-control" id="new_price" name="new_price">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div id="hash_tags" class="mb-3">
                            <label for="tags">Tags</label><br>
                            <input type="hidden" name="tags[]" value="{{ $row->title }}">
                            {{-- Input field for adding new tags --}}
                            <input type="text" id="tagInput" class="form-control" placeholder="Add a new tag...">
                        </div>
                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <select class="form-control" id="condition" name="condition" required>
                                <option value="Old">Old</option>
                                <option value="New">New</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock_condition">Stock Condition</label>
                            <select class="form-control" id="stock_condition" name="stock_condition" required>
                                <option value="Low">Low</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="number" class="form-control" id="discount" name="discount">
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" class="form-control" id="facebook" name="facebook">
                        </div>
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" class="form-control" id="instagram" name="instagram">
                        </div>
                        <div class="form-group">
                            <label for="youtube">Youtube</label>
                            <input type="text" class="form-control" id="youtube" name="youtube">
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter(X)</label>
                            <input type="text" class="form-control" id="twitter" name="twitter">
                        </div>
                        <div class="form-group">
                            <label for="tiktok">Tiktok</label>
                            <input type="text" class="form-control" id="tiktok" name="tiktok">
                        </div>
                        <div class="form-group">
                            <label for="pinterest">Pinterest</label>
                            <input type="text" class="form-control" id="pinterest" name="pinterest">
                        </div>
                        <div class="form-group">
                            <label for="linkedin">LinkedIn</label>
                            <input type="text" class="form-control" id="linkedin" name="linkedin">
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image" id="image_label">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="media">Media</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input select2" id="media" name="media[]"
                                    multiple>
                                <label class="custom-file-label" for="media" id="media_label">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product modal -->
    <div class="modal fade" id="editproductModal" tabindex="-1" role="dialog" aria-labelledby="editproductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editproductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        @csrf
                        @method('PUT') <!-- Use PUT method for update -->
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Category</label>
                            <select class="form-control category" id="edit_category" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label for="edit_subcategory">Subcategory</label>
                            <select class="form-control" id="edit_subcategory" name="subcategory_id" required>
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_old_price">Regular Price</label>
                            <input type="text" class="form-control" id="edit_old_price" name="old_price">
                        </div>
                        <div class="form-group">
                            <label for="edit_new_price">Discounted Price</label>
                            <input type="text" class="form-control" id="edit_new_price" name="new_price">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_discount">Discount</label>
                            <input type="number" class="form-control" id="edit_discount" name="discount">
                        </div>
                        <div class="form-group">
                            <label for="edit_condition">Condition</label>
                            <select class="form-control" id="edit_condition" name="condition" required>
                                <option value="Old">Old</option>
                                <option value="New">New</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_stock_condition">Stock Condition</label>
                            <select class="form-control" id="edit_stock_condition" name="stock_condition" required>
                                <option value="Low">Low</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div>
                                <label for="edit_variant_id">Variants</label>
                            </div>
                            @foreach ($variants as $row)
                                <input type="hidden" id="div-{{ $row->id }}" value="{{ $row->title }}" />
                            @endforeach
                            <select id="edit_variant_id" name="variant_id[]" class="form-control select2" multiple>
                                @foreach ($variants as $row)
                                    <option value="{{ $row->id }}"
                                        data-name-{{ $row->id }}="{{ $row->title }}">
                                        {{ $row->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="edit_hash_tags" class="mb-3">
                            <label for="edit_tags">Tags</label><br>
                            <!-- Existing tags will be dynamically added here -->
                            @if (!empty($row->tags))
                                @foreach ($row->tags as $tag)
                                    @php
                                        $explodedTags = explode(',', $tag->title);
                                    @endphp
                                    @foreach ($explodedTags as $explodedTag)
                                        <span class="badge badge-primary tag badge-lg" data-id="{{ $tag->id }}"
                                            style="font-size: 1.25em;">
                                            {{ $explodedTag }}
                                        </span>
                                        <input type="hidden" name="tags[]" value="{{ $explodedTag }}">
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                        <input type="text" id="edit_tagInput" class="form-control" placeholder="Add a new tag...">


                        <!-- End of additional fields -->
                        <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Confirmation Modal -->
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
                    Are you sure you want to delete this product?
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
            // Open the product modal when clicking the "New Product" button
            $('#openProductModal').click(function() {
                $('#productModal').modal('show');
            });

            // Handle click event for editing a product using event delegation
            $(document).on('click', '.editProductBtn', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: '{{ route('vendor.products.edit', ':id') }}'.replace(':id', productId),
                    type: 'GET',
                    success: function(response) {
                        console.log('edit', response);
                        // Populate the edit form fields with product details
                        $('#edit_id').val(response.product.id);
                        $('#edit_title').val(response.product.title);
                        $('#edit_description').val(response.product.description);
                        $('#edit_category').val(response.product.category_id);
                        $('#edit_status').val(response.product.status);
                        $('#edit_old_price').val(response.product.old_price);
                        $('#edit_new_price').val(response.product.new_price);
                        $('#edit_discount').val(response.product.discount);
                        $('#edit_condition').val(response.product.condition);
                        $('#edit_stock_condition').val(response.product.stock_condition);

                        // Show the edit modal
                        $('#editproductModal').modal('show');

                        // Autopopulate variant select with the product's variants
                        var variantIds = response.product.variants.map(variant => variant.id);
                        $('#edit_variant_id').val(variantIds).trigger('change');

                        // Populate the subcategory dropdown if available
                        var subcategoryDropdown = $('#edit_subcategory');
                        subcategoryDropdown.empty(); // Clear existing options
                        subcategoryDropdown.append($('<option>', {
                            value: '',
                            text: 'Select Subcategory'
                        }));
                        if (response.product.subcategory) {
                            if (Array.isArray(response.product.subcategory)) {
                                // If the subcategory data is an array
                                response.product.subcategory.forEach(subcategory => {
                                    subcategoryDropdown.append($('<option>', {
                                        value: subcategory.id,
                                        text: subcategory.title
                                    }));
                                });
                            } else {
                                // If the subcategory data is an object
                                subcategoryDropdown.append($('<option>', {
                                    value: response.product.subcategory.id,
                                    text: response.product.subcategory.title
                                }));
                            }
                            $('#edit_subcategory_input')
                        .show(); // Show the subcategory dropdown
                        }

                        // Autopopulate tags if available
                        if (response.product.tags) {
                            var tags = response.product.tags.split(
                            ','); // Convert tags string to an array
                            $('#edit_hash_tags').empty();
                            tags.forEach(tag => {
                                var tagElement = $(
                                    '<span class="badge badge-primary tag badge-lg" data-id="' +
                                    tag.trim() +
                                    '" style="font-size: 1.25em;">#' + tag.trim() +
                                    '</span>');
                                var hiddenInput = $(
                                    '<input type="hidden" name="tags[]" value="' +
                                    tag.trim() + '">');
                                $('#edit_hash_tags').append(tagElement).append(
                                    hiddenInput);
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch product details for editing</div>'
                        );
                    }
                });
            });

            // Clear edit modal fields when the modal dismisses
            $('#editproductModal').on('hidden.bs.modal', function() {
                clearEditModalFields();
            });

            // Handle form submission via AJAX for creating a new product
            $('#createProductForm').submit(function(event) {
                event.preventDefault();
                var formData = new FormData($(this)[0]); // Use FormData object to include media files
                $.ajax({
                    url: '{{ route('vendor.products.store') }}',
                    type: 'POST',
                    data: formData, // Send FormData object instead of serialized data
                    contentType: false, // Set contentType to false when sending FormData
                    processData: false, // Set processData to false when sending FormData
                    success: function(response) {
                        $('#productModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTables after updating table content
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#productMessage').html(
                            '<div class="alert alert-success" role="alert">Product created successfully</div>'
                        );
                        setTimeout(function() {
                            $('#productMessage').html('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create product</div>'
                        );
                    }
                });
            });

            // Handle form submission via AJAX for updating a product
            $('#editProductForm').submit(function(event) {
                var productId = $(this).find('#edit_id').val();
                event.preventDefault();
                var formData = new FormData($(this)[0]); // Use FormData object to include media files
                var url = '{{ route('vendor.products.update', ':id') }}'.replace(':id', productId);
                console.log('urlurl', url);

                $.ajax({
                    url: url,
                    type: 'POST', // Change the type to POST for updating
                    data: formData,
                    contentType: false, // Set contentType to false when sending FormData
                    processData: false, // Set processData to false when sending FormData
                    success: function(response) {
                        $('#editproductModal').modal('hide');
                        $(this).trigger('reset');
                        $('#tableData').html(response.table_html);

                        $('#productMessage').html(
                            '<div class="alert alert-success" role="alert">Product updated successfully</div>'
                        );
                        setTimeout(function() {
                            $('#productMessage').html('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update product</div>'
                        );
                    }
                });
            });
            // Delete recrod
            $('.deleteProductBtn').click(function(event) {
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
                            $('#productMessage').html(
                                '<div class="alert alert-success" role="alert">' +
                                response.message + '</div>');

                            // Optionally, you can remove the deleted product row from the table
                            deleteForm.closest('tr').remove();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            $('#productMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete product</div>'
                            );
                        }
                    });
                });
            });

            // Allow selecting or deselecting options by clicking on tags
            $(document).on('click', '.tag', function() {
                var tagId = $(this).data('id');
                var isSelected = $(this).hasClass('badge-primary');
                if (isSelected) {
                    // Remove the hidden input field for the unselected tag
                    $(this).next('input[name="tags[]"]').remove();
                    $(this).removeClass('badge-primary').addClass('badge-secondary');
                } else {
                    // Create a hidden input field for the selected tag
                    var tagName = $(this).text().trim().replace('#', '');
                    var newInput = $('<input type="hidden" name="tags[]" value="#' + tagName +
                        '">');
                    // Append the new input field to the form
                    $('#hash_tags').append(newInput);
                    $(this).removeClass('badge-secondary').addClass('badge-primary');
                }
            });

            // Allow selecting or deselecting options by clicking on tags
            $(document).on('click', '.tag', function() {
                var tagId = $(this).data('id');
                var tagInput = $(this).next('input[name="tags[]"]');
                if (tagInput.length) {
                    // Remove the hidden input field for the tag
                    tagInput.remove();
                }
                $(this).remove(); // Remove the tag from the UI
            });

            // Functionality to add a new tag when pressing Enter in the input field
            $('#tagInput').keypress(function(event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    var newTagName = $(this).val().trim();
                    if (newTagName) {
                        // Generate a unique ID for the new tag
                        var newTagId = 'random_' + Math.floor(Math.random() * 1000000);
                        // Create the new tag
                        var newTag = $('<span class="badge badge-primary tag badge-lg" data-id="' +
                            newTagId +
                            '" style="font-size: 1.25em;">#' + newTagName + '</span>');
                        // Append the new tag after the input field
                        $('#tagInput').before(newTag);

                        // Create a hidden input field for the new tag code name
                        var newInput = $('<input type="hidden" name="tags[]" value="#' + newTagName +
                            '">'); // Add '#' symbol here
                        // Append the new input field to the form
                        $('#hash_tags').append(newInput);

                        // Clear the input field
                        $(this).val('');
                    }
                }
            });

            // Update label text when files are selected for additional images
            $('#media').on('change', function() {
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
                $('#media_label').text(fileNames);
            });

            // Update label text when files are selected for additional images
            $('#image').on('change', function() {
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
                $('#image_label').text(fileNames);
            });
        });

        // select2 initialization for edit modal
        $('#editproductModal').on('shown.bs.modal', function() {
            $('#edit_variant_id').select2();
        });

        // Functionality to add a new tag when clicking on the "Add New" text in edit modal
        // $('#edit_addNewTagText').click(function() {
        //     var newTagName = prompt('Enter the name for the new tag:');
        //     if (newTagName) {
        //         // Generate a unique ID for the new tag
        //         var newTagId = 'random_' + Math.floor(Math.random() * 1000000);
        //         // Create the new tag
        //         var newTag = $('<span class="badge badge-primary tag badge-lg" data-id="' + newTagId +
        //             '" style="font-size: 1.25em;">#' + newTagName + '</span>');
        //         // Append the new tag after the last tag in the container
        //         $('#edit_hash_tags').append(newTag);

        //         // Create a hidden input field for the new tag code name
        //         var newInput = $('<input type="hidden" name="tags[]" value="#' + newTagName +
        //             '">');
        //         // Append the new input field to the form
        //         $('#edit_hash_tags').append(newInput);
        //     }
        // });

        $('.category').on('change', function() {
            var category = $(this).val();
            var subcategoryDropdown = $(this).closest('.form-group').next('.form-group').find('select');
            $.ajax({
                type: 'GET',
                url: "/vendor/get-subcategory/" + category, // Manually construct the URL
                success: function(response) {
                    subcategoryDropdown.empty(); // Clear existing options
                    subcategoryDropdown.append($('<option>', {
                        value: '',
                        text: 'Select Subcategory'
                    }));
                    response.forEach(function(subcategory) {
                        subcategoryDropdown.append($('<option>', {
                            value: subcategory.id,
                            text: subcategory.title
                        }));
                    });
                    subcategoryDropdown.closest('.form-group').show(); // Show the subcategory dropdown
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Allow selecting or deselecting options by clicking on tags in edit modal
        $(document).on('click', '#editproductModal .tag', function() {
            var tagId = $(this).data('id');
            var tagInput = $(this).next('input[name="tags[]"]');
            if (tagInput.length) {
                // Remove the hidden input field for the tag
                tagInput.remove();
            }
            $(this).remove(); // Remove the tag from the UI
        });

        // Functionality to add a new tag in edit modal when pressing Enter in the input field
        $('#editproductModal #edit_tagInput').keypress(function(event) {
            if (event.which === 13) { // Check if Enter key is pressed
                var newTagName = $(this).val().trim();
                if (newTagName) {
                    // Generate a unique ID for the new tag
                    var newTagId = 'random_' + Math.floor(Math.random() * 1000000);
                    // Create the new tag
                    var newTag = $('<span class="badge badge-primary tag badge-lg" data-id="' +
                        newTagId +
                        '" style="font-size: 1.25em;">#' + newTagName + '</span>');
                    // Append the new tag after the input field
                    $('#editproductModal #edit_tagInput').before(newTag);

                    // Create a hidden input field for the new tag code name
                    var newInput = $('<input type="hidden" name="tags[]" value="' + newTagName +
                        '">'); // Do not include '#' symbol here
                    // Append the new input field to the form
                    $('#editproductModal #edit_hash_tags').append(newInput);

                    // Clear the input field
                    $(this).val('');
                }
            }
        });
    </script>
@endsection
