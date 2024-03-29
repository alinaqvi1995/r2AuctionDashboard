@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Edit Role</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Role Information</strong>
            </div>
            <div class="card-body">
                <form id="editRoleForm" method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ $role->name }}" placeholder="Enter role name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1" {{ $role->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $role->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" id="updateRoleBtn" class="btn btn-primary">Update Role</button>
                            <!-- Success message container -->
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
        $('#editRoleForm').submit(function(e) {
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
                    $('#successMessage').html('Role updated successfully.').show();
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
