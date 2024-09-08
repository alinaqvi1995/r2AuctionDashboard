@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Clients Feedback</h2>
        <p class="card-text">Feedback table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openFeedbackModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New
                    Feedback</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Feedback Messages -->
                        <div id="feedbackMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.clients_feedback.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Feedback modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">New Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createFeedbackForm" enctype="multipart/form-data">
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
                            <label for="rating">Rating</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1"
                                max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveFeedbackBtn">Save Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Feedback modal -->
    <div class="modal fade" id="editFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="editFeedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFeedbackModalLabel">Edit Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editFeedbackForm" method="POST" enctype="multipart/form-data">
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
                            <label for="edit_rating">Rating</label>
                            <input type="number" class="form-control" id="edit_rating" name="rating" min="1"
                                max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateFeedbackBtn">Update Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openFeedbackModal').click(function() {
                $('#feedbackModal').modal('show');
            });

            $('#createFeedbackForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('clients.feedback.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#feedbackModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#feedbackMessage').html(
                            '<div class="alert alert-success" role="alert">Feedback created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#feedbackMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create feedback.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editFeedbackBtn', function() {
                var feedbackId = $(this).data('id');
                console.log('feedbackIdfeedbackId', feedbackId);
                $.ajax({
                    url: "{{ route('clients.feedback.edit', ['feedback' => ':feedbackId']) }}"
                        .replace(':feedbackId', feedbackId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.feedback_item.id);
                        $('#edit_date').val(response.feedback_item.date);
                        $('#edit_title').val(response.feedback_item.title);
                        $('#edit_description').val(response.feedback_item.description);
                        $('#edit_rating').val(response.feedback_item.rating);
                        $('#edit_status').val(response.feedback_item.status);

                        $('#editFeedbackModal').modal('show');

                        $('#editFeedbackForm').attr('action',
                            "{{ route('clients.feedback.update', ['feedback' => ':feedbackId']) }}"
                            .replace(':feedbackId', feedbackId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#feedbackMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch feedback details for editing.</div>'
                        );
                    }
                });
            });

            $('#editFeedbackForm').submit(function(e) {
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
                        $('#editFeedbackModal').modal('hide');

                        $('#tableData').html(response.table_html);

                        $('#feedbackMessage').html(
                            '<div class="alert alert-success" role="alert">Feedback updated successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#feedbackMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update feedback.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteFeedbackBtn', function() {
                var feedbackId = $(this).data('id');
                if (confirm("Are you sure you want to delete this feedback?")) {
                    $.ajax({
                        url: "{{ route('clients.feedback.destroy', ['feedback' => ':feedbackId']) }}"
                            .replace(':feedbackId', feedbackId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response.table_html);
                            $('#feedbackMessage').html(
                                '<div class="alert alert-success" role="alert">Feedback deleted successfully.</div>'
                            );
                        },
                        error: function(error) {
                            console.error(error);
                            $('#feedbackMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete feedback.</div>'
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
