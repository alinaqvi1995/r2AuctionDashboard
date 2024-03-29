@extends('dashboard.admin.layouts.app')

@section('content')
    <style>
        #permission_id+span.select2.select2-container .select2-selection--multiple .select2-selection__rendered {
            background-color: #f8f9fa !important;
            /* Set your desired grey color here */
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Create Role Permission</h2>
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong class="card-title">Role Permission Information</strong>
                </div>
                <div class="card-body">
                    <form id="rolePermissionForm" method="POST" action="{{ route('role_permissions.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="role_id">Role</label>
                                    <select id="role_id" name="role_id" class="form-control" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="permission_id">Permissions</label>
                                    <div id="selectPermission">
                                        <select id="permission_id" name="permission_id[]" class="form-control select2"
                                            multiple required>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id }}">
                                                    {{ $permission->display_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Role Permission</button>
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
            $('#role_id').change(function() {
                var roleId = $(this).val();
                $.ajax({
                    url: "{{ route('get_permissions_by_role') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        role_id: roleId
                    },
                    success: function(response) {
                        console.log('response', response);
                        var html = response.html;

                        $('#permission_id').replaceWith(
                        html); // Replace existing select with new one

                        // Reinitialize select2 after updating options
                        $('.select2').select2();

                        // Apply background color after select2 initialization
                        $('#permission_id').next('.select2-container').find(
                            '.select2-selection__rendered').css('background-color',
                            '#f8f9fa');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(xhr.responseText);
                        // Handle error here
                    }
                });
            });

            // Trigger change event on page load to populate permissions for the default role
            // $('#role_id').change();
        });
    </script>
@endsection
