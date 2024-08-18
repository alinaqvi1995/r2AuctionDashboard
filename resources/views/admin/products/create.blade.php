@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Products</h2>
        <form id="createProductForm">
            @csrf
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
                <select class="form-control" id="subcategory_id" name="subcategory_id">
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="form-label fs-14 text-theme-primary fw-bold">Product Title</label>
                <input type="text" class="form-control fs-14 h-50px" name="name" value="" placeholder="Product Name"
                    required>
            </div>
            <div class="form-group">
                <label for="reference" class="form-label fs-14 text-theme-primary fw-bold">Reference</label>
                <input type="text" class="form-control fs-14 h-50px" name="reference" value=""
                    placeholder="Product Reference" required>
            </div>
            <div class="form-group">
                <label for="listing_type" class="form-label fs-14 text-theme-primary fw-bold">Listing Type</label>
                <select class="form-control fs-14 h-50px" name="listing_type" id="listing_type" required>
                    <option value="">Select Listing Type</option>
                    <option value="One">One</option>
                    <option value="Two">Two</option>
                    <option value="Three">Three</option>
                </select>
            </div>
            <div class="form-group">
                <label for="material" class="form-label fs-14 text-theme-primary fw-bold">Material</label>
                <select class="form-control fs-14 h-50px" name="material" id="material" required>
                    <option value="">Select Material</option>
                    <option value="Stainless Steel">Stainless Steel</option>
                    <option value="Plastic">Plastic</option>
                </select>
            </div>
            <div class="form-group">
                <label for="generation" class="form-label fs-14 text-theme-primary fw-bold">Generation</label>
                <select class="form-control fs-14 h-50px" name="generation" id="generation" required>
                    <option value="">Select Generation</option>
                    <option value="1st Generation">1st Generation</option>
                    <option value="2nd Generation">2nd Generation</option>
                    <option value="3rd Generation">3rd Generation</option>
                </select>
            </div>
            <div class="form-group">
                <label for="connectivity" class="form-label fs-14 text-theme-primary fw-bold">Connectivity</label>
                <select class="form-control fs-14 h-50px" name="connectivity" id="connectivity" required>
                    <option value="">Select Connectivity</option>
                    <option value="Wi-Fi">Wi-Fi</option>
                    <option value="Cable">Cable</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity" class="form-label fs-14 text-theme-primary fw-bold">Quantity</label>
                <input type="number" class="form-control fs-14 h-50px" name="quantity" value=""
                    placeholder="Product quantity" required>
            </div>
            <div class="form-group">
                <label for="auction_name" class="form-label fs-14 text-theme-primary fw-bold">Auction Name</label>
                <input type="text" class="form-control fs-14 h-50px" name="auction_name" value=""
                    placeholder="Product auction_name" required>
            </div>
            <div class="form-group">
                <label for="lot_address" class="form-label fs-14 text-theme-primary fw-bold">Lot Address</label>
                <input type="text" class="form-control fs-14 h-50px" name="lot_address" value=""
                    placeholder="Product Lot Address" required>
            </div>
            <div class="form-group">
                <label for="lot_city" class="form-label fs-14 text-theme-primary fw-bold">Lot City</label>
                <input type="text" class="form-control fs-14 h-50px" name="lot_city" value=""
                    placeholder="Product Lot City" required>
            </div>
            <div class="form-group">
                <label for="lot_state" class="form-label fs-14 text-theme-primary fw-bold">Lot State</label>
                <input type="text" class="form-control fs-14 h-50px" name="lot_state" value=""
                    placeholder="Product Lot State" required>
            </div>
            <div class="form-group">
                <label for="lot_zip" class="form-label fs-14 text-theme-primary fw-bold">Lot Zip</label>
                <input type="text" class="form-control fs-14 h-50px" name="lot_zip" value=""
                    placeholder="Product Lot Zip" required>
            </div>
            <div class="form-group">
                <label for="lot_country" class="form-label fs-14 text-theme-primary fw-bold">Lot Country</label>
                <input type="text" class="form-control fs-14 h-50px" name="lot_country" value=""
                    placeholder="Product Lot Country" required>
            </div>
            <div class="form-group">
                <label for="international_buyers" class="form-label fs-14 text-theme-primary fw-bold">International
                    Buyers</label>
                <select class="form-control fs-14 h-50px" name="international_buyers" id="international_buyers" required>
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group">
                <label for="shipping_requirements"
                    class="form-label fs-14 text-theme-primary fw-bold">shipping_requirements</label>
                <select class="form-control fs-14 h-50px" name="shipping_requirements" id="shipping_requirements"
                    required>
                    <option value="">Select</option>
                    <option value="Buyer responsible for packaging materials and shipping costs.">Buyer responsible for
                        packaging materials and shipping costs.</option>
                    <option value="Shipper responsible for packaging materials and shipping costs.">Shipper responsible for
                        packaging materials and shipping costs.</option>
                    <option value="Buyer responsible for shipping costs. Seller responsible for packaging materials.">Buyer
                        responsible for shipping costs. Seller responsible for packaging materials.</option>
                </select>
            </div>
            <div class="form-check">
                <input type="checkbox" id="certificate_data_erasure" class="form-check-input" value="1"
                    name="certificate_data_erasure">
                <label for="certificate_data_erasure" class="form-label fs-14 text-theme-primary fw-bold">Certificate Data
                    Erasure</label>
            </div>

            <div class="form-check">
                <input type="checkbox" id="certificate_hardware_destruction" class="form-check-input" value="1"
                    name="certificate_hardware_destruction">
                <label for="certificate_hardware_destruction"
                    class="form-label fs-14 text-theme-primary fw-bold">Certificate Hardware Destruction</label>
            </div>
            <div class="form-check">
                <input type="checkbox" id="lot_sold_as_is" class="form-check-input" value="1" name="lot_sold_as_is">
                <label for="lot_sold_as_is" class="form-label fs-14 text-theme-primary fw-bold">Lot Sold As Is</label>
            </div>
            <div class="form-group">
                <label for="notes" class="form-label fs-14 text-theme-primary fw-bold">Notes</label>
                <textarea class="form-control fs-14 h-50px" name="notes" required placeholder="Write notes"></textarea>
            </div>
            <div class="form-group">
                <label for="bidding_close_time" class="form-label fs-14 text-theme-primary fw-bold">Bidding Close
                    Time</label>
                <input type="datetime-local" class="form-control fs-14 h-50px" name="bidding_close_time" value=""
                    placeholder="Product bidding_close_time" required>
            </div>
            <div class="form-group mb-3">
                <label for="auction_slot_id">Auction Slots</label>
                <select id="auction_slot_id" name="auction_slot_id" class="form-control" required>
                    <option value="" selected disabled>Select Auction Date</option>
                    @foreach ($auctionSlots as $row)
                        <option value="{{ $row->id }}">
                            {{ $row->auction_date . ' - ' . $row->auction_date_end }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="processing_time" class="form-label fs-14 text-theme-primary fw-bold">Processing Time</label>
                <input type="number" class="form-control fs-14 h-50px" name="processing_time" value=""
                    placeholder="Product Days" required>
            </div>
            <div class="form-group">
                <label for="minimum_bid_price" class="form-label fs-14 text-theme-primary fw-bold">Minimum Bid
                    Price</label>
                <input type="text" class="form-control fs-14 h-50px" name="minimum_bid_price" value=""
                    placeholder="Product Minimum Bid Price" required>
            </div>
            <div class="form-check">
                <input type="checkbox" id="buy_now" class="form-check-input" value="1" name="buy_now">
                <label for="buy_now" class="form-label fs-14 text-theme-primary fw-bold">Buy Now</label>
            </div>
            <div class="form-group">
                <label for="buy_now_price" class="form-label fs-14 text-theme-primary fw-bold">Buy Now Price</label>
                <input type="number" class="form-control fs-14 h-50px" name="buy_now_price" value=""
                    placeholder="Product Buy Now Price" required>
            </div>
            <div class="form-group">
                <label for="reserve_price" class="form-label fs-14 text-theme-primary fw-bold">Reserve Price</label>
                <input type="number" class="form-control fs-14 h-50px" name="reserve_price" value=""
                    placeholder="Product Reserve Price" required>
            </div>
            <div class="form-group">
                <label for="description" class="form-label fs-14 text-theme-primary fw-bold">Description</label>
                <textarea class="form-control fs-14 h-50px" name="description" required placeholder="Description"></textarea>
            </div>
            <div class="form-group">
                <label for="condition" class="form-label fs-14 text-theme-primary fw-bold">Condition</label>
                <select class="form-control fs-14 h-50px" name="condition" id="condition" required>
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                </select>
            </div>
            <div class="form-group">
                <label for="manufacturer_id" class="form-label fs-14 text-theme-primary fw-bold">Manufacturer</label>
                <select class="form-control fs-14 h-50px" name="manufacturer_id" required id="manufacturer_id">
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
                    <select id="capacity_id" name="capacity_id[]" class="form-control select2" multiple required>
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
                    <select id="modelNumber_id" name="modelNumber_id[]" class="form-control select2" multiple required>
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
                    <select id="carrier_id" name="carrier_id[]" class="form-control select2" multiple required>
                        @foreach ($carrier as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="rams">Ram</label>
                <div id="selectrams">
                    <select id="rams" name="rams[]" class="form-control select2" multiple required>
                        @foreach ($rams as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="sizes">Size</label>
                <div id="selectsizes">
                    <select id="sizes" name="sizes[]" class="form-control select2" multiple required>
                        @foreach ($sizes as $row)
                            <option value="{{ $row->id }}">
                                {{ $row->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="modelNames">Model Name</label>
                <div id="selectmodelNames">
                    <select id="modelNames" name="modelNames[]" class="form-control select2" multiple required>
                        @foreach ($modelNames as $row)
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

            <div class="form-group mb-3">
                <label for="media">Media</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input media" id="media" name="media[]" multiple>
                    <label class="custom-file-label media_label" for="media" id="media_label">Choose
                        file</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" id="saveProductBtn">Save Product</button>
        </form>
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

            $(document).on('click', '.editProductBtn', function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: "{{ route('products.edit', ['product' => ':productId']) }}".replace(
                        ':productId', productId),
                    method: "GET",
                    success: function(response) {
                        console.log('response', response);

                        // Populate product details
                        $('#edit_id').val(response.product.id);
                        $('#edit_name').val(response.product.name);
                        $('#edit_description').val(response.product.description);
                        $('#edit_category_id').val(response.product.category_id).trigger(
                            'change');
                        $('#edit_manufacturer_id').val(response.product.manufacturer_id)
                            .trigger('change');
                        $('#edit_status').val(response.product.status).trigger('change');
                        $('#edit_condition').val(response.product.condition);

                        // Replace select options for colors
                        var colors = response.product.colors;
                        $('#edit_color_id').replaceWith(buildSelect('edit_color_id', colors));

                        // Replace select options for regions
                        var regions = response.product.regions;
                        $('#edit_region_id').replaceWith(buildSelect('edit_region_id',
                            regions));

                        // Replace select options for capacities
                        var capacities = response.product.storages;
                        $('#edit_capacity_id').replaceWith(buildSelect('edit_capacity_id',
                            capacities));

                        // Replace select options for model numbers
                        var modelNumbers = response.product.model_numbers;
                        $('#edit_modelNumber_id').replaceWith(buildSelect('edit_modelNumber_id',
                            modelNumbers));

                        // Replace select options for lock statuses
                        var lockStatuses = response.product.lock_statuses;
                        $('#edit_lockStatus_id').replaceWith(buildSelect('edit_lockStatus_id',
                            lockStatuses));

                        // Replace select options for grades
                        var grades = response.product.grades;
                        $('#edit_grade_id').replaceWith(buildSelect('edit_grade_id', grades));

                        // Replace select options for carriers
                        var carriers = response.product.carriers;
                        $('#edit_carrier_id').replaceWith(buildSelect('edit_carrier_id',
                            carriers));

                        // Populate subcategories
                        var subcategories = response.subcategories;
                        $('#edit_subcategory_id').empty();
                        subcategories.forEach(function(subcategory) {
                            $('#edit_subcategory_id').append('<option value="' +
                                subcategory.id + '">' + subcategory.name +
                                '</option>');
                        });

                        $('#editProductModal').modal('show');

                        // Initialize Select2 for the new select elements
                        $('.select2').select2({
                            theme: 'bootstrap4',
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch product details for editing.</div>'
                        );
                    }
                });
            });

            // Function to build a select element
            function buildSelect(id, options) {
                var select = $('<select>').attr('id', id).addClass('form-control select2');
                options.forEach(function(option) {
                    select.append($('<option>').attr('value', option.id).text(option.name));
                });
                return select;
            }

            $('#createProductForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                var imageFile = $('#image')[0].files[0];
                formData.append('image', imageFile);

                $.ajax({
                    url: "{{ route('products.store') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#productModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#productMessage').html(
                            '<div class="alert alert-success" role="alert">Product created successfully.</div>'
                        );

                        window.location.href = "{{ route('products.index') }}";
                    },
                    error: function(error) {
                        console.error(error);
                        $('#productMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create product.</div>'
                        );
                    }
                });
            });

            $('#editProductForm').submit(function(e) {
                e.preventDefault();
                var productId = $('#edit_id').val();

                var formData = new FormData(this);

                var imageFile = $('#edit_image')[0].files[0];
                formData.append('image', imageFile);

                $.ajax({
                    url: "{{ route('products.update', ['product' => ':productId']) }}".replace(
                        ':productId', productId),
                    method: "PUT",
                    data: formData,
                    processData: false,
                    contentType: false,
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
                    }
                });
            }

            $('#category_id').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, '#subcategory_id');
            });

            $('#edit_category_id').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, '#edit_subcategory_id');
            });

            $('.media').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                $('.media_label').text(fileNames);
            });

            $('.image').on('change', function() {
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

            $('#manufacturer_id').change(function() {
                var manufacturerId = $(this).val();
                $.ajax({
                    url: "{{ route('get.manufacturers.relations', ':manufacturerId') }}".replace(
                        ':manufacturerId', manufacturerId),
                    type: 'GET',
                    success: function(response) {
                        var capacities = response.capacities;
                        var models = response.models;
                        $.each(capacities, function(index, capacity) {
                            capacitiesOptions += '<option value="' + capacity.id +
                                '">' + capacity.name + '</option>';
                        });
                        $('#capacity_id').html(capacitiesOptions);

                        $.each(models, function(index, model) {
                            modelsOptions += '<option value="' + model.id + '">' + model
                                .name + '</option>';
                        });
                        $('#modelNumber_id').html(modelsOptions);
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            });

            // $('#modelNumber_id').change(function() {
            //     var modelNumberId = $(this).val();
            //     $.ajax({
            //         url: "{{ route('get.model.relations', ':modelNumberId') }}".replace(
            //             ':modelNumberId', modelNumberId),
            //         type: 'GET',
            //         success: function(response) {
            //             var colors = response.colors;
            //             var colorsOptions = '<option value="">Select Colors</option>';
            //             $.each(colors, function(index, color) {
            //                 colorsOptions += '<option value="' + color.id + '">' + color
            //                     .name + '</option>';
            //             });
            //             $('#color_id').html(colorsOptions);
            //         },
            //         error: function(xhr) {
            //             console.log('Error:', xhr.responseText);
            //         }
            //     });
            // });

        });
    </script>
@endsection
