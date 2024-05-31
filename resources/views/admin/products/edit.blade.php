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

            <!-- Name Field -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}"
                    required>
            </div>

            <!-- Description Field -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
            </div>

            <!-- Category Field -->
            <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subcategory Field -->
            <div class="form-group">
                <label for="subcategory_id">Subcategory</label>
                <select class="form-control" id="subcategory_id" name="subcategory_id" required>
                    <option value="">Select Subcategory</option>
                    @foreach ($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Condition Field -->
            <div class="form-group">
                <label for="condition">Condition</label>
                <select class="form-control" id="condition" name="condition">
                    <option value="New" {{ $product->condition == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Used" {{ $product->condition == 'Used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>

            <!-- Manufacturer Field -->
            <div class="form-group">
                <label for="manufacturer_id" class="form-label fs-14 text-theme-primary fw-bold">Manufacturer</label>
                <select class="form-control fs-14 h-50px" name="manufacturer_id" id="manufacturer_id" required>
                    <option value="">Select Manufacturer</option>
                    @foreach ($manufacturer as $row)
                        <option value="{{ $row->id }}" {{ $product->manufacturer_id == $row->id ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- {{ dd($product->colors->pluck('id')->toArray()) }} --}}

            <!-- Auction Slot Field -->
            <div class="form-group">
                <label for="auction_slot_id">Auction Slot</label>
                <select class="form-control" id="auction_slot_id" name="auction_slot_id">
                    <option value="">Select Auction Slot</option>
                    @foreach ($auctionSlots as $slot)
                        <option value="{{ $slot->id }}"
                            {{ $product->auction_slot_id == $slot->id ? 'selected' : '' }}>{{ $slot->auction_date }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Colors Field -->
            <div class="form-group">
                <label for="color_id">Colors</label>
                <select id="color_id" name="color_id[]" class="form-control select2" multiple required>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}"
                            {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $color->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Regions Field -->
            <div class="form-group">
                <label for="region_id">Regions</label>
                <select id="region_id" name="region_id[]" class="form-control select2" multiple required>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}"
                            {{ in_array($region->id, $product->regions->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Capacity Field -->
            <div class="form-group">
                <label for="capacity_id">Capacity</label>
                <select id="capacity_id" name="capacity_id[]" class="form-control select2" multiple required>
                    @foreach ($capacity as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->storages->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Model Number Field -->
            <div class="form-group">
                <label for="modelNumber_id">Model Number</label>
                <select id="modelNumber_id" name="modelNumber_id[]" class="form-control select2" multiple required>
                    @foreach ($modelNumber as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->modelNumbers->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Grade Field -->
            <div class="form-group mb-3" id="grade_id_field"
                style="display: {{ $product->condition == 'Used' ? 'block' : 'none' }};">
                <label for="grade_id">Grades</label>
                <div id="selectgrade">
                    <select id="grade_id" name="grade_id[]" class="form-control select2" multiple>
                        @foreach ($grade as $row)
                            <option value="{{ $row->id }}"
                                {{ in_array($row->id, $product->grades->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- LockStatus Field -->
            <div class="form-group mb-3" id="lockStatus_id_field"
                style="display: {{ $product->condition == 'Used' ? 'block' : 'none' }};">
                <label for="lockStatus_id">LockStatus</label>
                <div id="selectlockStatus">
                    <select id="lockStatus_id" name="lockStatus_id[]" class="form-control select2" multiple>
                        @foreach ($lockStatus as $row)
                            <option value="{{ $row->id }}"
                                {{ in_array($row->id, $product->lockStatuses->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Carrier Field -->
            <div class="form-group">
                <label for="carrier_id">Carriers</label>
                <select id="carrier_id" name="carrier_id[]" class="form-control select2" multiple required>
                    @foreach ($carrier as $row)
                        <option value="{{ $row->id }}"
                            {{ in_array($row->id, $product->carriers->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $row->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Field -->
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Image Field -->
            <div class="form-group mb-3">
                <label for="image">Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input image" id="image" name="image">
                    <label class="custom-file-label image_label" for="image" id="image_label">Choose file</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
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
        });
    </script>
@endsection
