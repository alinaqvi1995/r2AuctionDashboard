@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Products</h2>
        <p class="card-text">Products table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openProductModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Product</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Product Messages -->
                        <div id="productMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.products.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <label for="name" class="form-label fs-14 text-theme-primary fw-bold">Name</label>
                            <input type="text" class="form-control fs-14 h-50px" name="name" value=""
                                placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-label fs-14 text-theme-primary fw-bold">Description</label>
                            <textarea class="form-control fs-14 h-50px" name="description" required placeholder="Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="form-label fs-14 text-theme-primary fw-bold">Category</label>
                            <select class="form-control fs-14 h-50px" name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategory_id">Subcategory</label>
                            <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                                <!-- Options will be dynamically populated based on the selected category -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="condition" class="form-label fs-14 text-theme-primary fw-bold">Condition</label>
                            <select class="form-control fs-14 h-50px" name="condition" id="condition" required>
                                <option value="New">New</option>
                                <option value="Used">Used</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer_id"
                                class="form-label fs-14 text-theme-primary fw-bold">Manufacturer</label>
                            <select class="form-control fs-14 h-50px" name="manufacturer_id" required>
                                <option value="">Select Manufacturer</option>
                                @foreach ($manufacturer as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="color_id">Colors</label>
                            <div id="selectcolor">
                                <select id="color_id" name="color_id[]" class="form-control select2" multiple required>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="region_id">Regions</label>
                            <div id="selectregion">
                                <select id="region_id" name="region_id[]" class="form-control select2" multiple required>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region->id }}">
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="capacity_id">Capacity</label>
                            <div id="selectcapacity">
                                <select id="capacity_id" name="capacity_id[]" class="form-control select2" multiple
                                    required>
                                    @foreach ($capacity as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="modelNumber_id">Model Number</label>
                            <div id="selectmodelNumber">
                                <select id="modelNumber_id" name="modelNumber_id[]" class="form-control select2" multiple
                                    required>
                                    @foreach ($modelNumber as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3" id="selectgrade" style="display: none;">
                            <label for="grade_id">Grades</label>
                            <div id="selectgrade">
                                <select id="grade_id" name="grade_id[]" class="form-control select2" multiple>
                                    @foreach ($grade as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3" id="selectlockStatus" style="display: none;">
                            <label for="lockStatus_id">LockStatus</label>
                            <div id="selectlockStatus">
                                <select id="lockStatus_id" name="lockStatus_id[]" class="form-control select2" multiple>
                                    @foreach ($lockStatus as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="carrier_id">Carriers</label>
                            <div id="selectcarrier">
                                <select id="carrier_id" name="carrier_id[]" class="form-control select2" multiple
                                    required>
                                    @foreach ($carrier as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input image" id="image" name="image">
                                <label class="custom-file-label image_label" for="image" id="image_label">Choose
                                    file</label>
                            </div>
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label for="media">Media</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input select2 media" id="media" name="media[]"
                                    multiple>
                                <label class="custom-file-label media_label" for="media" id="media_label">Choose file</label>
                            </div>
                        </div> --}}
                        <button type="submit" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_id">Category</label>
                            <select class="form-control" id="edit_category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_subcategory_id">Subcategory</label>
                            <select class="form-control" id="edit_subcategory_id" name="subcategory_id" required>
                                <!-- Options will be dynamically populated based on the selected category -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_condition">Condition</label>
                            <select class="form-control" id="edit_condition" name="condition">
                                <option value="New">New</option>
                                <option value="Used">Used</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_manufacturer_id"
                                class="form-label fs-14 text-theme-primary fw-bold">Manufacturer</label>
                            <select class="form-control fs-14 h-50px" name="manufacturer_id" id="edit_manufacturer_id"
                                required>
                                <option value="">Select Manufacturer</option>
                                @foreach ($manufacturer as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_color_id">Colors</label>
                            <select id="edit_color_id" name="color_id[]" class="form-control select2" multiple required>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_region_id">Regions</label>
                            <select id="edit_region_id" name="region_id[]" class="form-control select2" multiple
                                required>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_capacity_id">Capacity</label>
                            <select id="edit_capacity_id" name="capacity_id[]" class="form-control select2" multiple
                                required>
                                @foreach ($capacity as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_modelNumber_id">Model Number</label>
                            <select id="edit_modelNumber_id" name="modelNumber_id[]" class="form-control select2"
                                multiple required>
                                @foreach ($modelNumber as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3" id="edit_grade_id_field" style="display: none;">
                            <label for="edit_grade_id">Grades</label>
                            <div id="edit_selectgrade">
                                <select id="edit_grade_id" name="grade_id[]" class="form-control select2" multiple>
                                    @foreach ($grade as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3" id="edit_lockStatus_id_field" style="display: none;">
                            <label for="edit_lockStatus_id">LockStatus</label>
                            <div id="edit_selectlockStatus">
                                <select id="edit_lockStatus_id" name="lockStatus_id[]" class="form-control select2"
                                    multiple>
                                    @foreach ($lockStatus as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_carrier_id">Carriers</label>
                            <select id="edit_carrier_id" name="carrier_id[]" class="form-control select2" multiple
                                required>
                                @foreach ($carrier as $row)
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
                        <div class="form-group mb-3">
                            <label for="edit_image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input image" id="edit_image" name="image">
                                <label class="custom-file-label image_label" for="edit_image"
                                    id="edit_image_label">Choose
                                    file</label>
                            </div>
                        </div>
                        {{-- <div class="form-group mb-3">
                            <label for="edit_media">Media</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input select2 media" id="edit_media" name="media[]"
                                    multiple>
                                <label class="custom-file-label media_label" for="edit_media" id="edit_media_label">Choose
                                    file</label>
                            </div>
                        </div> --}}
                        <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Function to toggle visibility of Grades and LockStatus based on condition
            function toggleFieldsBasedOnCondition(conditionValue) {
                console.log('Toggle function called with condition:', conditionValue);
                if (conditionValue === 'Used') {
                    console.log('Showing fields for Used condition');
                    $('#edit_grade_id_field').show();
                    $('#edit_lockStatus_id_field').show();
                    $('#edit_grade_id').prop('required', true);
                    $('#edit_lockStatus_id').prop('required', true);
                } else {
                    console.log('Hiding fields for New condition');
                    $('#edit_grade_id_field').hide();
                    $('#edit_lockStatus_id_field').hide();
                    $('#edit_grade_id').prop('required', false);
                    $('#edit_lockStatus_id').prop('required', false);
                }
            }

            // Handle change event for condition in the create modal
            $('#condition').change(function() {
                var selectedCondition = $(this).val();
                if (selectedCondition === 'Used') {
                    $('#selectgrade').show();
                    $('#selectlockStatus').show();
                    $('#grade_id').prop('required', true);
                    $('#lockStatus_id').prop('required', true);
                } else {
                    $('#selectgrade').hide();
                    $('#selectlockStatus').hide();
                    $('#grade_id').prop('required', false);
                    $('#lockStatus_id').prop('required', false);
                }
            });

            // Handle change event for condition in the edit modal
            $('#edit_condition').change(function() {
                var selectedCondition = $(this).val();
                console.log('Selected condition:', selectedCondition);
                toggleFieldsBasedOnCondition(selectedCondition); // Ensure this function call is correct
            });

            // Show the new product modal
            $('#openProductModal').click(function() {
                $('#productModal').modal('show');
            });

            // Show edit product modal
            $(document).on('click', '.editProductBtn', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: "{{ route('products.edit', ['product' => ':productId']) }}".replace(
                        ':productId', productId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.product.id);
                        $('#edit_name').val(response.product.name);
                        $('#edit_description').val(response.product.description);
                        $('#edit_category_id').val(response.product.category_id).trigger(
                            'change');
                        $('#edit_manufacturer_id').val(response.product.manufacturer_id)
                            .trigger(
                                'change');
                        $('#edit_status').val(response.product.status).trigger('change');

                        // Set select options for colors
                        var colorIds = response.product.colors.map(color => color.id);
                        $('#edit_color_id').val(colorIds).trigger('change');

                        // Set select options for regions
                        var regionIds = response.product.regions.map(region => region.id);
                        $('#edit_region_id').val(regionIds).trigger('change');

                        // Set select options for capacities
                        var capacityIds = response.product.storages.map(storage => storage.id);
                        $('#edit_capacity_id').val(capacityIds).trigger('change');

                        // Set select options for modelNumbers
                        var modelNumberIds = response.product.model_numbers.map(modelNumber =>
                            modelNumber.id);
                        $('#edit_modelNumber_id').val(modelNumberIds).trigger('change');

                        // Set select options for lockStatuses
                        var lockStatusIds = response.product.lock_statuses.map(lockStatus =>
                            lockStatus.id);
                        $('#edit_lockStatus_id').val(lockStatusIds).trigger('change');

                        // Set select options for grades
                        var gradeIds = response.product.grades.map(grade => grade.id);
                        $('#edit_grade_id').val(gradeIds).trigger('change');

                        // Set select options for carriers
                        var carrierIds = response.product.carriers.map(carrier => carrier.id);
                        $('#edit_carrier_id').val(carrierIds).trigger('change');

                        $('#edit_condition').val(response.product.condition);
                        populateSubcategories(response.product.category_id,
                            '#edit_subcategory_id', response.product.subcategory_id);

                        var currentCondition = $('#edit_condition').val();

                        toggleFieldsBasedOnCondition(response.product.condition);


                        $('#editProductModal').modal('show');
                    },
                    error: function(error) {
                        console.error(error);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch product details for editing.</div>'
                        );
                    }
                });
            });

            // Handle form submission for creating a new product
            $('#createProductForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('products.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#productModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#productMessage').html(
                            '<div class="alert alert-success" role="alert">Product created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create product.</div>'
                        );
                    }
                });
            });

            // Handle form submission for updating a product
            $('#editProductForm').submit(function(e) {
                e.preventDefault();
                var productId = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('products.update', ['product' => ':productId']) }}".replace(
                        ':productId', productId),
                    method: "PUT",
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editProductModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#productMessage').html(
                            '<div class="alert alert-success" role="alert">Product updated successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update product.</div>'
                        );
                    }
                });
            });

            // Function to fetch and populate subcategories based on the selected category
            function populateSubcategories(categoryId, targetDropdown, selectedSubcategoryId = null) {
                $.ajax({
                    url: "{{ route('subcategories.by_category') }}",
                    method: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        $(targetDropdown).empty(); // Clear previous options
                        $(targetDropdown).append($('<option>', {
                            value: '',
                            text: 'Select Subcategory'
                        }));
                        $.each(response.subcategories, function(index, subcategory) {
                            var option = $('<option>', {
                                value: subcategory.id,
                                text: subcategory.name
                            });
                            if (subcategory.id == selectedSubcategoryId) {
                                option.attr('selected', 'selected');
                            }
                            $(targetDropdown).append(option);
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        // Handle error
                    }
                });
            }

            // Handle change event on the category dropdown to fetch and populate subcategories
            $('#category_id').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, '#subcategory_id');
            });

            // Handle change event on the category dropdown in the edit modal to fetch and populate subcategories
            $('#edit_category_id').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, '#edit_subcategory_id');
            });

            // Update label text when files are selected for additional images
            $('.media').on('change', function() {
                console.log('yessss');
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
                $('.media_label').text(fileNames);
            });

            // Update label text when files are selected for additional images
            $('.image').on('change', function() {
                // Get the file names
                console.log('yes');
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                // Update the label text
                $('.image_label').text(fileNames);
            });

        });
    </script>
@endsection
