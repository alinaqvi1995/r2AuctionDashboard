@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Role</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Role Information</strong>
            </div>
            <div class="card-body">
                <form id="createRoleForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter role name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Role</button>
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
        $('#createRoleForm').submit(function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            
            $.ajax({
                type: 'POST',
                url: `{{ route('roles.store') }}`,
                data: formData,
                success: function(response) {
                    $('#createRoleForm')[0].reset();
                    $('#successMessage').html('New role created successfully.').show();
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
