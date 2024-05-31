@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Manufacturers</h2>
        <p class="card-text">Manufacturers table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openManufacturerModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Manufacturer</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Manufacturer Messages -->
                        <div id="manufacturerMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.manufacturers.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Manufacturer modal -->
    <div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="manufacturerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manufacturerModalLabel">New Manufacturer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createManufacturerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="icon" name="icon" required>
                                <label class="custom-file-label" for="image" id="icon_label">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveManufacturerBtn">Save Manufacturer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Manufacturer modal -->
    <div class="modal fade" id="editManufacturerModal" tabindex="-1" role="dialog"
        aria-labelledby="editManufacturerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editManufacturerModalLabel">Edit Manufacturer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editManufacturerForm" enctype="multipart/form-data" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_icon">Icon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_icon" name="icon">
                                <label class="custom-file-label" for="edit_icon" id="edit_icon_label">Choose file</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateManufacturerBtn">Update
                            Manufacturer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            // Open the new manufacturer modal
            $('#openManufacturerModal').click(function() {
                $('#manufacturerModal').modal('show');
            });

            // Handle form submission for creating a new manufacturer
            $('#createManufacturerForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('manufacturers.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#manufacturerModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTable
                        $('#dataTable-1').DataTable().destroy();
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#manufacturerMessage').html(
                            '<div class="alert alert-success" role="alert">Manufacturer created successfully.</div>'
                            );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#manufacturerMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create manufacturer.</div>'
                            );
                    }
                });
            });

            $(document).on('click', '.editManufacturerBtn', function() {
                var manufacturerId = $(this).data('id');
                $.ajax({
                    url: "{{ route('manufacturers.edit', ['manufacturer' => ':manufacturerId']) }}"
                        .replace(':manufacturerId', manufacturerId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.manufacturer.id);
                        $('#edit_name').val(response.manufacturer.name);
                        $('#edit_description').val(response.manufacturer.description);

                        $('#editManufacturerModal').modal('show');

                        $('#editManufacturerForm').attr('action',
                            "{{ route('manufacturers.update', ['manufacturer' => ':manufacturerId']) }}"
                            .replace(':manufacturerId', manufacturerId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#manufacturerMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch manufacturer details for editing.</div>'
                            );
                    }
                });
            });

            // Handle form submission for updating a manufacturer
            $('#editManufacturerForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var actionUrl = $(this).attr('action');
                $.ajax({
                    url: actionUrl,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editManufacturerModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        // Reinitialize DataTable
                        $('#dataTable-1').DataTable().destroy();
                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#manufacturerMessage').html(
                            '<div class="alert alert-success" role="alert">Manufacturer updated successfully.</div>'
                            );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#manufacturerMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update manufacturer.</div>'
                            );
                    }
                });
            });

            // Delete manufacturer
            $(document).on('click', '.deleteManufacturerBtn', function() {
                var manufacturerId = $(this).data('id');
                var url = "{{ route('manufacturers.destroy', ['manufacturer' => ':manufacturer']) }}"
                    .replace(':manufacturer', manufacturerId);
                if (confirm("Are you sure you want to delete this manufacturer?")) {
                    $.ajax({
                        url: url,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            // Reinitialize DataTable
                            $('#dataTable-1').DataTable().destroy();
                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });

                            $('#manufacturerMessage').html(
                                '<div class="alert alert-success" role="alert">Manufacturer deleted successfully.</div>'
                                );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#manufacturerMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete manufacturer.</div>'
                                );
                        }
                    });
                }
            });

            // Update file input label for new manufacturer
            $('#icon').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                $('#icon_label').text(fileNames);
            });

            // Update file input label for editing manufacturer
            $('#edit_icon').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                $('#edit_icon_label').text(fileNames);
            });
        });
    </script>
@endsection
