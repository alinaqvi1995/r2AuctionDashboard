@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">Time Slots</h2>
        <p class="card-text">Time Slots table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" id="openTimeSlotModal"><span
                        class="fe fe-plus fe-16 mr-3"></span>New Time Slot</button>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Time Slot Messages -->
                        <div id="timeSlotMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            @include('admin.auction_slots.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Time Slot modal -->
    <div class="modal fade" id="timeSlotModal" tabindex="-1" role="dialog" aria-labelledby="timeSlotModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeSlotModalLabel">New Time Slot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createTimeSlotForm">
                        @csrf
                        <div class="form-group">
                            <label for="auction_date">Start Time</label>
                            <input type="date" class="form-control" id="auction_date" name="auction_date" required>
                        </div>
                        <div class="form-group">
                            <label for="auction_date_end">End Time</label>
                            <input type="date" class="form-control" id="auction_date_end" name="auction_date_end" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveTimeSlotBtn">Save Time Slot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Time Slot modal -->
    <div class="modal fade" id="editSlotModal" tabindex="-1" role="dialog" aria-labelledby="editSlotModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSlotModalLabel">Edit Time Slot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editSlotForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_auction_date">Start Time</label>
                            <input type="date" class="form-control" id="edit_auction_date" name="auction_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_auction_date_end">End Time</label>
                            <input type="date" class="form-control" id="edit_auction_date_end" name="auction_date_end" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <input type="text" class="form-control" id="edit_description" name="description">
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateTimeSlotBtn">Update Time Slot</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#openTimeSlotModal').click(function() {
                $('#timeSlotModal').modal('show');
            });

            $('#createTimeSlotForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('auction_slots.store') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#timeSlotModal').modal('hide');
                        $('#tableData').html(response.table_html);

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });

                        $('#timeSlotMessage').html(
                            '<div class="alert alert-success" role="alert">Time Slot created successfully.</div>'
                        );
                    },
                    error: function(error) {
                        console.error(error);
                        $('#timeSlotMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create time slot.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.editSlotBtn', function() {
                var timeSlotId = $(this).data('id');
                $.ajax({
                    url: "{{ route('auction_slots.edit', ['auction_slot' => ':timeSlotId']) }}"
                        .replace(':timeSlotId', timeSlotId),
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(response.auction_slot.id);
                        $('#edit_auction_date').val(response.auction_slot.auction_date);
                        $('#edit_auction_date_end').val(response.auction_slot.auction_date_end);
                        $('#edit_description').val(response.auction_slot.description);

                        $('#editSlotModal').modal('show');

                        $('#editSlotForm').attr('action',
                            "{{ route('auction_slots.update', ['auction_slot' => ':timeSlotId']) }}"
                            .replace(':timeSlotId', timeSlotId));
                    },
                    error: function(error) {
                        console.error(error);
                        $('#timeSlotMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch time slot details for editing.</div>'
                        );
                    }
                });
            });

            $('#editSlotForm').submit(function(e) {
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
                        $('#editSlotModal').modal('hide');

                        $('#tableData').html(response.table_html);

                        $('#timeSlotMessage').html(
                            '<div class="alert alert-success" role="alert">Time Slot updated successfully.</div>'
                        );

                        $('#dataTable-1').DataTable({
                            autoWidth: true,
                            "lengthMenu": [
                                [16, 32, 64, -1],
                                [16, 32, 64, "All"]
                            ]
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        $('#timeSlotMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update time slot.</div>'
                        );
                    }
                });
            });

            $(document).on('click', '.deleteSlotBtn', function() {
                var timeSlotId = $(this).data('id');
                if (confirm("Are you sure you want to delete this time slot?")) {
                    $.ajax({
                        url: "{{ route('auction_slots.destroy', ['auction_slot' => ':timeSlotId']) }}"
                            .replace(':timeSlotId', timeSlotId),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#tableData').html(response.table_html);

                            $('#timeSlotMessage').html(
                                '<div class="alert alert-success" role="alert">Time Slot deleted successfully.</div>'
                            );

                            $('#dataTable-1').DataTable({
                                autoWidth: true,
                                "lengthMenu": [
                                    [16, 32, 64, -1],
                                    [16, 32, 64, "All"]
                                ]
                            });
                        },
                        error: function(error) {
                            console.error(error);
                            $('#timeSlotMessage').html(
                                '<div class="alert alert-danger" role="alert">Failed to delete time slot.</div>'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
