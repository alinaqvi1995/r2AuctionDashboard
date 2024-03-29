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
                </div>
                <label for="description" class="form-label fs-14 text-theme-primary fw-bold">Description</label>
                <textarea class="form-control fs-14 h-50px" name="description" required placeholder="Description"></textarea>
            </div>
        </div>
        <label for="category_id" class="form-label fs-14 text-theme-primary fw-bold">Category</label>
        <select class="form-control fs-14 h-50px" name="category_id" required>
            <option value="">Select Category</option>
            @foreach ($categories as $category)
            @endforeach
        </select>
    </div>
    </div>
    <div class="form-group">
        <label for="brand_id" class="form-label fs-14 text-theme-primary fw-bold">Manufacturer</label>
        <select class="form-control fs-14 h-50px" name="brand_id" required>
            <option value="">Select Manufacturer</option>
            @foreach ($manufacturer as $brand)
            @endforeach
        </select>
    </div>
    </div>
    <div class="form-group">
        <label for="color_id" class="form-label fs-14 text-theme-primary fw-bold">Color</label>
        @foreach ($colors as $color)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="color_id[]" value="{{ $color->id }}">
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="storage_id" class="form-label fs-14 text-theme-primary fw-bold">Capacity</label>
        @foreach ($capacity as $storage)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="storage_id[]" value="{{ $storage->id }}">
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="region_id" class="form-label fs-14 text-theme-primary fw-bold">Region</label>
        @foreach ($region as $region)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="region_id[]" value="{{ $region->id }}">
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="modelNumber_id" class="form-label fs-14 text-theme-primary fw-bold">Model
            Number</label>
        @foreach ($modelNumber as $row)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="modelNumber_id[]" <label
                    class="form-check-label">{{ $row->name }}</label>
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="lockStatus_id" class="form-label fs-14 text-theme-primary fw-bold">Lock
            Status</label>
        @foreach ($lockStatus as $row)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="lockStatus_id[]" <label
                    class="form-check-label">{{ $row->name }}</label>
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="grade_id" class="form-label fs-14 text-theme-primary fw-bold">Grade</label>
        @foreach ($grade as $row)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="grade_id[]" value="{{ $row->id }}">
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="carrier_id" class="form-label fs-14 text-theme-primary fw-bold">Carrier</label>
        @foreach ($carrier as $row)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="carrier_id[]" <label
                    class="form-check-label">{{ $row->name }}</label>
            </div>
        @endforeach
    </div>
    </div>
    <div class="form-group">
        <label for="condition" class="form-label fs-14 text-theme-primary fw-bold">Condition</label>
        <input type="text" class="form-control fs-14 h-50px" name="condition" value=""
            placeholder="Condition">
    </div>
    <!-- Add other fields and select options for related models -->
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
                        <!-- Add other fields for editing -->
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
            // Open the new product modal
            $('#openProductModal').click(function() {
                $('#productModal').modal('show');
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
                        // Add other fields to populate for editing
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
        });
    </script>
@endsection
