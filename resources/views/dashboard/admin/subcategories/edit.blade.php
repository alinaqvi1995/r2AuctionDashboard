@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Edit Subcategory</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Subcategory Information</strong>
            </div>
            <div class="card-body">
                <form id="editSubcategoryForm" method="POST" action="{{ route('subcategories.update', $subcategory->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ $subcategory->title }}" placeholder="Enter subcategory title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" value="{{ $subcategory->slug }}" placeholder="Enter subcategory slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter subcategory description">{{ $subcategory->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="active" {{ $subcategory->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $subcategory->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" id="updateSubcategoryBtn" class="btn btn-primary">Update Subcategory</button>
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
        $('#editSubcategoryForm').submit(function(e) {
            e.preventDefault(); // Prevent form submission
            
            // Serialize form data
            var formData = $(this).serialize();
            
            // Submit form via AJAX
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    // Show success message
                    $('#successMessage').html('Subcategory updated successfully.').show();
                    // Hide success message after 3 seconds
                    setTimeout(function() {
                        $('#successMessage').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
