@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">News</h2>
        <p class="card-text">News table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openNewsModal"><span class="fe fe-plus fe-16 mr-3"></span>New
                    News</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- News Messages -->
                        <div id="newsMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.news.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New News modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsModalLabel">New News</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createNewsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image" required>
                                <label class="custom-file-label" for="image" id="image_label">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveNewsBtn">Save News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit News modal -->
    <div class="modal fade" id="editNewsModal" tabindex="-1" role="dialog" aria-labelledby="editNewsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNewsModalLabel">Edit News</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editNewsForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="edit_image" name="image">
                                <label class="custom-file-label" for="edit_image" id="edit_image_label">Choose
                                    file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateNewsBtn">Update News</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openNewsModal').click(function() {
                $('#newsModal').modal('show');
            });

            $('#createNewsForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('news.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#newsModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#newsMessage').html(
                            '<div class="alert alert-success" role="alert">News created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#newsMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create news.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editNewsBtn', function() {
                var newsId = $(this).data('id');
                $.ajax({
                    url: "{{ route('news.edit', ['news' => ':newsId']) }}"
                        .replace(':newsId', newsId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.news_item.id);
                        $('#edit_date').val(response.news_item.date);
                        // $('#edit_image').val(response.news_item.image);
                        $('#edit_title').val(response.news_item.title);
                        $('#edit_description').val(response.news_item.description);
                        $('#edit_status').val(response.news_item.status);

                        $('#editNewsModal').modal('show');

                        $('#editNewsForm').attr('action',
                            "{{ route('news.update', ['news' => ':newsId']) }}"
                            .replace(':newsId', newsId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#newsMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch news details for editing.</div>'
                        );
                    }
                });
            });

            $('#editNewsForm').submit(function(e) {
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
                        $('#editNewsModal').modal('hide');

                        $('#tableData').html(response.table_html);

                        $('#newsMessage').html(
                            '<div class="alert alert-success" role="alert">News updated successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#newsMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update news.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteNewsBtn', function() {
                var newsId = $(this).data('id');
                if (confirm("Are you sure you want to delete this news?")) {
                    $.ajax({
                        url: "{{ route('news.destroy', ['news' => ':newsId']) }}"
                            .replace(':newsId', newsId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            $('#newsMessage').html(
                                '<div class="alert alert-success" role="alert">News deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#newsMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete news.</div>'
                            );
                        }
                    });
                }
            });

            $('#image').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                $('#image_label').text(fileNames);
            });

            $('#edit_image').on('change', function() {
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                $('#edit_image_label').text(fileNames);
            });
        });
    </script>
@endsection
