@extends('admin.layouts.app')

@section('content')
    <style>
    </style>

    <div class="container">
        <h2 class="mb-2 page-title">Edit Product</h2>
        <form id="editProductForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="id" name="id" value="{{ $product->id }}">

            <!-- Listing Title -->
            <div class="form-group">
                <label for="name">Listing Title *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}"
                    required>
            </div>

            <!-- Reference -->
            <div class="form-group">
                <label for="reference">Reference *</label>
                <input type="text" class="form-control" id="reference" name="reference" value="{{ $product->reference }}"
                    required>
            </div>

            <!-- Listing Type -->
            <div class="form-group">
                <label for="listing_type">Listing Type *</label>
                <select class="form-control" id="listing_type" name="listing_type" required>
                    <option value="">Select Listing Type</option>
                    <option value="Type A" {{ $product->listing_type == 'Type A' ? 'selected' : '' }}>Type A</option>
                    <option value="Type B" {{ $product->listing_type == 'Type B' ? 'selected' : '' }}>Type B</option>
                </select>
            </div>

            <!-- Product Manufacturer -->
            <div class="form-group">
                <label for="manufacturer_id">Product Manufacturer *</label>
                <select class="form-control" id="manufacturer_id" name="manufacturer_id" required>
                    <option value="">Select Manufacturer</option>
                    @foreach ($manufacturer as $row)
                        <option value="{{ $row->id }}" {{ $product->manufacturer_id == $row->id ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Category -->
            <div class="form-group">
                <label for="category_id">Product Category *</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Model Name -->
            <div class="form-group">
                <label for="model_name">Model Name *</label>
                <select id="model_name_id" name="model_name_id[]" class="form-control select2" multiple required>
                    @foreach ($modelNames as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->modelNames->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Model Number -->
            <div class="form-group">
                <label for="modelNumber_id">Model Number *</label>
                <select id="modelNumber_id" name="modelNumber_id[]" class="form-control select2" multiple required>
                    @foreach ($modelNumber as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->modelNumbers->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Region -->
            <div class="form-group">
                <label for="region_id">Region *</label>
                <select id="region_id" name="region_id[]" class="form-control select2" multiple required>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}"
                            {{ in_array($region->id, $product->regions->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Capacity -->
            <div class="form-group">
                <label for="capacity_id">Capacity *</label>
                <select id="capacity_id" name="capacity_id[]" class="form-control select2" multiple required>
                    @foreach ($capacity as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->storages->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- RAM -->
            <div class="form-group">
                <label for="rams">RAM *</label>
                <select id="ram_id" name="ram_id[]" class="form-control select2" multiple required>
                    @foreach ($rams as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->rams->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Color -->
            <div class="form-group">
                <label for="color_id">Color *</label>
                <select id="color_id" name="color_id[]" class="form-control select2" multiple required>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}"
                            {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Model Size -->
            <div class="form-group">
                <label for="model_size">Model Size *</label>
                <select name="model_size" id="" class="form-control">
                    <option value="40 MM" {{ $product->model_size == '40 MM' ? 'selected' : '' }}>40 MM</option>
                    <option value="41 MM" {{ $product->model_size == '41 MM' ? 'selected' : '' }}>41 MM</option>
                    <option value="42 MM" {{ $product->model_size == '42 MM' ? 'selected' : '' }}>42 MM</option>
                    <option value="43 MM" {{ $product->model_size == '43 MM' ? 'selected' : '' }}>43 MM</option>
                    <option value="44 MM" {{ $product->model_size == '44 MM' ? 'selected' : '' }}>44 MM</option>
                    <option value="45 MM" {{ $product->model_size == '45 MM' ? 'selected' : '' }}>45 MM</option>
                    <option value="46 MM" {{ $product->model_size == '46 MM' ? 'selected' : '' }}>46 MM</option>
                    <option value="47 MM" {{ $product->model_size == '47 MM' ? 'selected' : '' }}>47 MM</option>
                    <option value='11"' {{ $product->model_size == '11"' ? 'selected' : '' }}>11"</option>
                    <option value='12.9"' {{ $product->model_size == '12.9"' ? 'selected' : '' }}>12.9"</option>
                    <option value='13"' {{ $product->model_size == '13"' ? 'selected' : '' }}>13"</option>
                    <option value="Mixed" {{ $product->model_size == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                </select>
            </div>

            <!-- Material -->
            <div class="form-group">
                <label for="material">Material *</label>
                <input type="text" class="form-control" id="material" name="material"
                    value="{{ $product->material }}" required>
            </div>

            <!-- Device Generation -->
            <div class="form-group">
                <label for="generation">Device Generation *</label>
                <input type="text" class="form-control" id="generation" name="generation"
                    value="{{ $product->generation }}" required>
            </div>

            <!-- Connectivity -->
            <div class="form-group">
                <label for="connectivity">Connectivity *</label>
                <select name="connectivity" id="connectivity" class="form-control">
                <option value="Cellular" {{ $product->network_status == 'Cellular' ? 'selected' : '' }}>Cellular</option>
                <option value="Wifi" {{ $product->network_status == 'Wifi' ? 'selected' : '' }}>Wifi</option>
                <option value="GPS" {{ $product->network_status == 'GPS' ? 'selected' : '' }}>GPS</option>
            </select>
            </div>

            <!-- Network Status -->
            <div class="form-group">
                <label for="network_status">Network Status *</label>
                <select class="form-control" id="network_status" name="network_status" required>
                    <option value="Locked" {{ $product->network_status == 'Locked' ? 'selected' : '' }}>Locked</option>
                    <option value="Unlocked" {{ $product->network_status == 'Unlocked' ? 'selected' : '' }}>Unlocked
                    </option>
                </select>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity *</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="{{ $product->quantity }}" required>
            </div>

            <!-- Carrier -->
            <div class="form-group">
                <label for="carrier_id">Carrier *</label>
                <select id="carrier_id" name="carrier_id[]" class="form-control select2" multiple required>
                    @foreach ($carrier as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->carriers->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product Grade -->
            <div class="form-group">
                <label for="grade_id">Product Grade *</label>
                <select id="grade_id" name="grade_id[]" class="form-control select2" multiple required>
                    @foreach ($grade as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->grades->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Lot Condition -->
            <div class="form-group">
                <label for="condition">Lot Condition *</label>
                <select class="form-control" id="condition" name="condition" required>
                    <option value="New" {{ $product->condition == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Used" {{ $product->condition == 'Used' ? 'selected' : '' }}>Used</option>
                    <option value="Open Box" {{ $product->condition == 'Open Box' ? 'selected' : '' }}>Open Box</option>
                    <option value="Repair Stock" {{ $product->condition == 'Repair Stock' ? 'selected' : '' }}>Repair
                        Stock</option>
                    <option value="R2" {{ $product->condition == 'R2' ? 'selected' : '' }}>R2</option>
                    <option value="As-Is" {{ $product->condition == 'As-Is' ? 'selected' : '' }}>As-Is</option>
                </select>
            </div>

            <!-- Lot Location -->
            <div class="form-group">
                <label for="lot_address">Lot Address *</label>
                <input type="text" class="form-control" id="lot_address" name="lot_address"
                    value="{{ $product->lot_address }}" required>
            </div>

            <!-- Lot Location -->
            <div class="form-group">
                <label for="lot_city">Lot City *</label>
                <input type="text" class="form-control" id="lot_city" name="lot_city"
                    value="{{ $product->lot_city }}" required>
            </div>

            <!-- Lot Location -->
            <div class="form-group">
                <label for="lot_state">Lot Province *</label>
                <input type="text" class="form-control" id="lot_state" name="lot_state"
                    value="{{ $product->lot_state }}" required>
            </div>

            <!-- Lot Location -->
            <div class="form-group">
                <label for="lot_zip">Lot Zip / Postal Code *</label>
                <input type="text" class="form-control" id="lot_zip" name="lot_zip"
                    value="{{ $product->lot_zip }}" required>
            </div>

            <!-- Lot Location -->
            <div class="form-group">
                <label for="lot_country">Lot Country *</label>
                <input type="text" class="form-control" id="lot_country" name="lot_country"
                    value="{{ $product->lot_country }}" required>
            </div>

            <!-- International Buyers -->
            <div class="form-group">
                <label>International Buyers *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="international_buyers" id="international_yes"
                        value="1" {{ $product->international_buyers == '1' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="international_yes">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="international_buyers" id="international_no"
                        value="0" {{ $product->international_buyers == '0' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="international_no">
                        No
                    </label>
                </div>
            </div>

            <!-- Shipping Requirements -->
            <div class="form-group">
                <label for="condition">Shipping Requirements *</label>
                <select class="form-control" id="condition" name="condition" required>
                    <option value="Buyer responsible for packaging materials and shipping costs"
                        {{ $product->condition == 'Buyer responsible for packaging materials and shipping costs' ? 'selected' : '' }}>
                        Buyer responsible for packaging materials and shipping costs</option>
                    <option value="Buyer responsible for shipping costs. Seller responsible for packaging materials"
                        {{ $product->condition == 'Buyer responsible for shipping costs. Seller responsible for packaging materials' ? 'selected' : '' }}>
                        Buyer responsible for shipping costs. Seller responsible for packaging materials</option>
                    <option value="Seller responsible for packaging and shipping costs"
                        {{ $product->condition == 'Seller responsible for packaging and shipping costs' ? 'selected' : '' }}>
                        Seller responsible for packaging and shipping costs</option>
                </select>
            </div>

            <!-- Data Erasure & Hardware Destruction Certificate Requirements -->
            <div class="form-group">
                <label>Data Erasure & Hardware Destruction Certificate Requirements *</label>
                <p>Your data will be securely removed from all devices</p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="certificate_data_erasure"
                        id="certificate_data_erasure" value="1"
                        {{ $product->certificate_data_erasure ? 'checked' : '' }}>
                    <label class="form-check-label" for="certificate_data_erasure">
                        Certificates of data erasure required
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="certificate_hardware_destruction"
                        id="certificate_hardware_destruction" value="1"
                        {{ $product->certificate_hardware_destruction ? 'checked' : '' }}>
                    <label class="form-check-label" for="certificate_hardware_destruction">
                        Certificates of hardware destruction required
                    </label>
                </div>
            </div>

            <!-- Payment Requirements -->
            <div class="form-group">
                <label>Payment Requirements *</label>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_requirements"
                        id="payment_wire_bank_transfer" value="wire_bank_transfer"
                        {{ $product->payment_requirements == 'wire_bank_transfer' ? 'checked' : '' }}>
                    <label class="form-check-label" for="payment_wire_bank_transfer">
                        Wire transfer or Bank transfer
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_requirements" id="payment_cheque"
                        value="cheque" {{ $product->payment_requirements == 'cheque' ? 'checked' : '' }}>
                    <label class="form-check-label" for="payment_cheque">
                        Cheque
                    </label>
                </div>
            </div>

            <!-- Note Field -->
            <div class="form-group">
                <label for="description">Note</label>
                <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
            </div>

            <!-- Auction Date -->
            <div class="form-group">
                <label for="auction_slot_id">Auction Slot</label>
                <select class="form-control" id="auction_slot_id" name="auction_slot_id">
                    <option value="">Select Auction Slot</option>
                    @foreach ($auctionSlots as $slot)
                        <option value="{{ $slot->id }}"
                            {{ $product->auction_slot_id == $slot->id ? 'selected' : '' }}>
                            {{ $slot->auction_date . ' - ' . $slot->auction_date_end }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Processing Time -->
            <div class="form-group">
                <label for="processing_time">Processing Time *</label>
                <input type="number" class="form-control" id="processing_time" name="processing_time"
                    value="{{ $product->processing_time }}" required>
            </div>

            <!-- Minimum Price -->
            <div class="form-group">
                <label for="minimum_bid_price">Minimum Price *</label>
                <input type="number" class="form-control" id="minimum_bid_price" name="minimum_bid_price"
                    value="{{ $product->minimum_bid_price }}" required>
            </div>

            <!-- Buy Now Checkbox -->
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="use_buy_now" id="use_buy_now" value="1"
                        {{ $product->use_buy_now ? 'checked' : '' }}>
                    <label class="form-check-label" for="use_buy_now">
                        Use Buy Now
                    </label>
                </div>
            </div>

            <!-- Buy Now Price Input -->
            <div class="form-group">
                <label for="buy_now_price">Buy Now Price</label>
                <input type="number" name="buy_now_price" id="buy_now_price" class="form-control"
                    value="{{ $product->buy_now_price }}" placeholder="Enter Buy Now Price" min="0"
                    step="0.01">
            </div>

            <!-- Reserve Price -->
            <div class="form-group">
                <label for="reserve_price">Reserve Price *</label>
                <input type="number" class="form-control" id="reserve_price" name="reserve_price"
                    value="{{ $product->reserve_price }}" required>
            </div>

            <!-- Photo Upload -->
            <div class="form-group">
                <label for="image">Upload Photo *</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input media" id="media" name="media[]" multiple>
                    <label class="custom-file-label media_label" for="media" id="media_label">Choose
                        file</label>
                </div>
            </div>

            <!-- Status Field -->
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            @if (Auth::user()->isAdmin())
                <!-- admin_approval Field -->
                <div class="form-group">
                    <label for="admin_approval">Approve</label>
                    <select class="form-control" id="admin_approval" name="admin_approval" required>
                        <option value="1" {{ $product->admin_approval == 1 ? 'selected' : '' }}>Approve</option>
                        <option value="0" {{ $product->admin_approval == 0 ? 'selected' : '' }}>Not Approve</option>
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Handle condition change
            $('#condition').change(function() {
                var selectedCondition = $(this).val();
                if (selectedCondition === 'Used') {
                    $('#grade_id_field').show();
                    $('#lockStatus_id_field').show();
                } else {
                    $('#grade_id_field').hide();
                    $('#lockStatus_id_field').hide();
                }
            });

            // Handle form submission
            $('#editProductForm').submit(function(e) {
                e.preventDefault();
                var productId = $('#id').val();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('products.update', ['product' => ':productId']) }}".replace(
                        ':productId', productId),
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Product updated successfully.');
                    },
                    error: function(error) {
                        console.error(error);
                        alert('Failed to update product.');
                    }
                });
            });

            // Populate subcategories based on the selected category
            $('#category_id').change(function() {
                var categoryId = $(this).val();
                populateSubcategories(categoryId, '#subcategory_id');
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

            // Initialize the subcategory dropdown based on the current category
            populateSubcategories('{{ $product->category_id }}', '#subcategory_id',
                '{{ $product->subcategory_id }}');

            // Handle file input label change
            $('.custom-file-input').on('change', function(event) {
                var inputFile = event.currentTarget;
                $(inputFile).parent()
                    .find('.custom-file-label')
                    .html(inputFile.files[0].name);
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
        });
    </script>
@endsection
