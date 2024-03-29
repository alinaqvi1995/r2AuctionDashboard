@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Subcategory</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Subcategory Information</strong>
            </div>
            <div class="card-body">
                <form id="createSubcategoryForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Enter subcategory title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter subcategory slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter subcategory description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Subcategory</button>
                            <div id="successMessage" class="alert alert-success mt-3" style="display: none;"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection

@section('bottom_script')
<script>
    $(document).ready(function() {
        $('#createSubcategoryForm').submit(function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                type: 'POST',
                url: `{{ route('subcategories.store') }}`,
                data: formData,
                success: function(response) {
                    $('#createSubcategoryForm')[0].reset();
                    $('#successMessage').html('New subcategory created successfully.').show();
                    setTimeout(function() {
                        $('#successMessage').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            return false;
        });
    });
</script>
@endsection
