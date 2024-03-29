@extends('dashboard.admin.layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-2 page-title">Tickets</h2>
            <p class="card-text">Tickets table.</p>
            <div class="row my-4">
                <!-- data table -->
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="openTicketModal"><span
                            class="fe fe-plus fe-16 mr-3"></span>New Ticket</button>
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sr#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="ticketTableBody">
                                    @php $counter = 1 @endphp <!-- Initialize counter -->
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                                            <td id="name{{ $ticket->id }}">{{ $ticket->name }}</td>
                                            <td id="status{{ $ticket->id }}">
                                                {{ $ticket->status }}
                                            </td>
                                            <td id="created{{ $ticket->id }}">{{ $ticket->created_at }}</td>
                                            <td id="btn{{ $ticket->id }}">
                                                <button
                                                    class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editTicketBtn"
                                                    type="button" data-id="{{ $ticket->id }}" data-toggle="modal"
                                                    data-target="#editTicketModal">
                                                    <span class="text-muted sr-only">Edit</span>
                                                </button>
                                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm rounded text-muted deleteTicketBtn">
                                                        <span class="fe fe-trash fe-12 mr-3"></span>
                                                        <span class="text-muted sr-only">Remove</span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- data table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div>

    <!-- New Ticket modal -->
    <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="ticketModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">New Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createTicketForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveTicketBtn">Save Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Ticket modal -->
    <div class="modal fade" id="editTicketModal" tabindex="-1" role="dialog" aria-labelledby="editTicketModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTicketModalLabel">Edit Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTicketForm">
                        @csrf
                        @method('GET')
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="updateTicketBtn">Update Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        // Function to clear edit modal fields
        function clearEditModalFields() {
            $('#edit_name').val('');
            $('#edit_description').val('');
            $('#edit_status').val('');
        }

        $(document).ready(function() {
            // Open the ticket modal when clicking the "New Ticket" button
            $('#openTicketModal').click(function() {
                $('#ticketModal').modal('show');
            });

            // Handle click event for editing a ticket
            $('.editTicketBtn').click(function() {
                var ticketId = $(this).data('id');
                $.ajax({
                    url: '{{ route('tickets.edit', ':id') }}'.replace(':id', ticketId),
                    type: 'GET',
                    success: function(response) {
                        console.log('edit', response);
                        // Populate the edit form fields with ticket details
                        $('#edit_id').val(response.ticket.id);
                        $('#edit_name').val(response.ticket.name);
                        $('#edit_description').val(response.ticket.description);
                        $('#edit_status').val(response.ticket.status);
                        // Show the edit modal
                        $('#editTicketModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#ticketMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to fetch ticket details for editing</div>'
                        );
                    }
                });
            });

            // Clear edit modal fields when the modal dismisses
            $('#editTicketModal').on('hidden.bs.modal', function() {
                clearEditModalFields();
            });

            // Handle form submission via AJAX for creating a new ticket
            $('#createTicketForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('tickets.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#ticketModal').modal('hide');
                        // Append new ticket to the table
                        $('#ticketTableBody').append(
                            '<tr><td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"><label class="custom-control-label"></label></div></td><td>' +
                            response.ticket.id + '</td><td>' + response.ticket.name +
                            '</td><td>' + response.ticket.status + '</td><td>' + response
                            .ticket.created_at +
                            '</td><td><button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editTicketBtn" type="button" data-id="' +
                            response.ticket.id +
                            '" data-toggle="modal" data-target="#editTicketModal"><span class="text-muted sr-only">Edit</span></button><form action="{{ route('tickets.destroy', ':id') }}" method="POST">@csrf @method('DELETE')<button type="submit" class="btn btn-sm rounded text-muted deleteTicketBtn"><span class="fe fe-trash fe-12 mr-3"></span><span class="text-muted sr-only">Remove</span></button></form></td></tr>'
                        );
                        $('#ticketMessage').html(
                            '<div class="alert alert-success" role="alert">Ticket created successfully</div>'
                        );
                        setTimeout(function() {
                            $('#ticketMessage').html('');
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#ticketMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to create ticket</div>'
                        );
                    }
                });
            });

            // Handle form submission via AJAX for updating a ticket
            $('#editTicketForm').submit(function(event) {
                var ticketId = $(this).find('#edit_id').val();
                event.preventDefault();
                var formData = $(this).serialize();
                var url = '{{ route('tickets.update', ['ticket' => ':id']) }}'.replace(':id', ticketId);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#editTicketModal').modal('hide');

                        // Find the edited ticket row in the table body
                        var editedTicketRow = $('#ticketTableBody').find('tr[data-id="' +
                            ticketId + '"]');

                        // Update the HTML content of specific td elements within the row
                        $('#name' + response.ticket.id).html(response.ticket
                            .name); // Update name
                        $('#status' + response.ticket.id).html(response.ticket
                            .status); // Update status
                        $('#created' + response.ticket.id).html(response.ticket
                            .created_at); // Update date

                        $('#ticketMessage').html(
                            '<div class="alert alert-success" role="alert">' + response
                            .message + '</div>');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#ticketMessage').html(
                            '<div class="alert alert-danger" role="alert">Failed to update ticket</div>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
