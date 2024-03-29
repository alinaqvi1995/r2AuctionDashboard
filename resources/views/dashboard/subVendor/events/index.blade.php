@extends('dashboard.subvendor.layouts.app')

@section('content')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center my-3">
                <div class="col">
                    <h2 class="page-title">Calendar</h2>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn" data-toggle="modal" data-target=".modal-calendar"><span
                            class="fe fe-filter fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-primary" id="openEventModal"><span
                            class="fe fe-plus fe-16 mr-3"></span>New Event</button>
                </div>
            </div>
            <div id='calendar'></div>
        </div>
    </div>

    <!-- new event modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="varyModalLabel">New Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form id="createEventForm" method="POST" action="{{ route('subVendor.events.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="name">Title</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter event title" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="package_id">Package</label>
                                    <input type="text" disabled class="form-control"
                                        value="{{ Auth::user()->subVendor->vendor->package->title ?? 'No Package Found' }}">
                                    <input type="text" hidden name="package_id" class="form-control"
                                        value="{{ Auth::user()->subVendor->vendor->package->id ?? 0 }}"
                                        id="package_id">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach (Auth::user()->subVendor->vendor->package->category as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="total_no_of_tickets">Total No. of Tickets</label>
                                    <input type="number" id="total_no_of_tickets" name="total_no_of_tickets"
                                        class="form-control" placeholder="Enter Total No of Tickets" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="venue">Venue</label>
                                    <input type="text" id="venue" name="venue" class="form-control"
                                        placeholder="Enter Venue Name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control"
                                        placeholder="Enter Venue Address" required>
                                </div>
                                <div id="dress_code_tags" class="mb-3">
                                    <label for="dress_code">Dress Code</label><br>
                                    @foreach ($categories as $row)
                                        <span class="badge badge-primary tag badge-lg" data-id="{{ $row->id }}"
                                            style="font-size: 1.25em;">
                                            {{ $row->title }}
                                        </span>
                                        <input type="hidden" name="dress_code[]" value="{{ $row->title }}">
                                    @endforeach
                                </div>
                                <p id="addNewTagText" style="color: blue; text-decoration: underline; cursor: pointer;">Add
                                    New</p>
                                <div class="form-group mb-3">
                                    <div>
                                        <label for="ticket_id">Tickets Type</label>
                                    </div>
                                    @foreach ($ticktes as $row)
                                        <input type="hidden" id="div-{{ $row->id }}" value="{{ $row->name }}" />
                                    @endforeach
                                    {{-- <div class="form-control"> --}}
                                    <select id="ticket_id" name="ticket_id[]" class="form-control select2" multiple>
                                        @foreach ($ticktes as $row)
                                            <option value="{{ $row->id }}"
                                                data-name-{{ $row->id }}="{{ $row->name }}">{{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- </div> --}}
                                </div>
                                <div id="embed-div">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Note</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Enter event description"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="eventType">Event type</label>
                                        <select id="eventType" name="eventType" class="form-control select2">
                                            <option value="private">Private</option>
                                            <option value="public">Public</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="date-input1">Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="button-addon-date"><span
                                                        class="fe fe-calendar fe-16"></span></div>
                                            </div>
                                            <input type="text" class="form-control drgpicker" id="start_date"
                                                name="start_date" value="04/24/2020">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 timeFields">
                                        <label for="startDate">Start Time</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="button-addon-time"><span
                                                        class="fe fe-clock fe-16"></span></div>
                                            </div>
                                            <input type="text" class="form-control time-input" id="start_time"
                                                name="start_time" placeholder="10:00 AM">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="date-input1">End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="button-addon-date"><span
                                                        class="fe fe-calendar fe-16"></span></div>
                                            </div>
                                            <input type="text" class="form-control drgpicker" id="end_date"
                                                name="end_date" value="04/24/2020">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 timeFields">
                                        <label for="endDate">End Time</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="button-addon-time"><span
                                                        class="fe fe-clock fe-16"></span></div>
                                            </div>
                                            <input type="text" class="form-control time-input" id="end_time"
                                                name="end_time" placeholder="11:00 AM">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="all_day"
                                            name="all_day">
                                        <label class="custom-control-label" for="all_day">All day</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="promotional_Video">Promotional Video</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="promotional_Video"
                                            name="promotional_Video">
                                        <label class="custom-file-label" for="promotional_Video"
                                            id="promotional_Video_label">Choose file</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="customFile">Banner</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="banner">
                                        <label class="custom-file-label" for="customFile" id="customFile_label">Choose
                                            file</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="additional_images">Additional Images</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input select2" id="additional_images"
                                            name="additional_images[]" multiple>
                                        <label class="custom-file-label" for="additional_images"
                                            id="additional_images_label">Choose file</label>
                                    </div>
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <label for="additional_images">Additional Images</label>
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <div class="card shadow mb-4">
                                                        <div class="card-header">
                                                            <strong>Browse or drop here</strong>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="drag-drop-area"></div>
                                                        </div> <!-- .card-body -->
                                                    </div> <!-- .card -->
                                                </div> <!-- .col -->
                                            </div> <!-- .row -->
                                        </div>
                                    </div> <!-- .row -->
                                </div> --}}
                                <button type="button" class="btn mb-2 btn-primary" id="saveEventBtn">Save Event</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- new event modal -->
@endsection

@section('bottom_script')
    <!-- Include FullCalendar JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.js"></script>

    <!-- Your custom JavaScript code using FullCalendar and AJAX -->
    <script>
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');
            var eventsObject = {!! $events->filter(function ($event) {
                    return $event->start_date && $event->end_date;
                })->toJson() !!}; // Filter out events without start/end dates

            var events = Object.values(eventsObject); // Convert the events object to an array

            // Function to convert date strings to ISO 8601 format
            function convertToISODate(dateString) {
                var parts = dateString.split('/');
                return parts[2] + '-' + parts[0].padStart(2, '0') + '-' + parts[1].padStart(2, '0');
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'timeGrid', 'list', 'bootstrap'], // Include necessary plugins
                timeZone: 'UTC',
                themeSystem: 'bootstrap',
                header: {
                    left: 'today, prev, next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                buttonIcons: {
                    prev: 'fe-arrow-left',
                    next: 'fe-arrow-right',
                    prevYear: 'left-double-arrow',
                    nextYear: 'right-double-arrow'
                },
                weekNumbers: true,
                eventLimit: true, // allow "more" link when too many events
                events: events.map(function(event) {
                    return {
                        title: event.name,
                        start: convertToISODate(event.start_date),
                        end: convertToISODate(event.end_date),
                        allDay: true // Assuming all events are full-day events
                    };
                })
            });

            calendar.render();

            // Open the event modal when clicking the "New Event" button
            $('#openEventModal').click(function() {
                $('#eventModal').modal('show');
            });

            // Handle form submission via AJAX
            $('#saveEventBtn').click(function() {
                var formData = new FormData($('#createEventForm')[0]);
                formData.append('all_day', $('#all_day').is(':checked') ? true : false);

                $.ajax({
                    url: '{{ route('subVendor.events.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Convert date strings to ISO 8601 format
                        var startISO = convertToISODate(response.event.start_date);
                        var endISO = convertToISODate(response.event.end_date);

                        // Construct the new event object
                        var newEvent = {
                            title: response.event.name,
                            start: startISO,
                            end: endISO,
                            allDay: response.event
                                .all_day // Assuming this property exists in the response
                        };

                        // Add the new event to the calendar
                        calendar.addEvent(newEvent);

                        // Hide the event modal
                        $('#eventModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // You can handle error response here
                    }
                });
            });

            $('#all_day').change(function() {
                if ($(this).prop('checked')) {
                    $('.timeFields').hide();
                } else {
                    $('.timeFields').show();
                }
            });

            function convertToISODate(dateString) {
                var parts = dateString.split('/');
                return parts[2] + '-' + parts[0].padStart(2, '0') + '-' + parts[1].padStart(2, '0');
            }
        });
        $("#ticket_id").change(function() {
            $("embed-div").html();
            allTickets = $(this).val();
            html = '';
            $.each(allTickets, function(index, val) {
                id = val;
                html += '<div class="form-group mb-3">';
                html += '<h6>' + $('#div-' + val).val() + '</h6>'
                html += '<div class="form-row">';
                html += '<div class="form-group col-md-6">';
                html += '<label for="price-' + id + '">Price</label>';
                html += '<input type="number" class="form-control" name="price[]" required>';
                html += '</div>';
                html += '<div class="form-group col-md-6">';
                html += '<label for="quantity-' + id + '">Quantity</label>';
                html += '<input type="number" class="form-control" name="quantity[]" required>';
                html += '</div>';
                html += '</div>';
                html += '</div>';
            });
            $("#embed-div").html(html);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Allow selecting or deselecting options by clicking on tags
            $(document).on('click', '.tag', function() {
                var dressCodeId = $(this).data('id');
                var isSelected = $(this).hasClass('badge-primary');
                if (isSelected) {
                    $(this).removeClass('badge-primary').addClass('badge-secondary');
                } else {
                    $(this).removeClass('badge-secondary').addClass('badge-primary');
                }
            });

            // Add functionality to add a new tag when clicking on the "Add New" text
            $('#addNewTagText').click(function() {
                var newTagName = prompt('Enter the name for the new tag:');
                if (newTagName) {
                    // Generate a unique ID for the new tag
                    var newTagId = 'random_' + Math.floor(Math.random() * 1000000);
                    // Create the new tag
                    var newTag = $('<span class="badge badge-primary tag badge-lg" data-id="' + newTagId +
                        '" style="font-size: 1.25em;">' + newTagName + '</span>');
                    // Append the new tag after the last tag in the container
                    $('#dress_code_tags').append(newTag);

                    // Create a hidden input field for the new dress code name
                    var newInput = $('<input type="hidden" name="dress_code[]" value="' + newTagName +
                        '">');
                    // Append the new input field to the form
                    $('#dress_code_tags').append(newInput);
                }
            });

            // Update label text when a file is selected for promotional video
            $('#promotional_Video').on('change', function() {
                // Get the file name
                var fileName = $(this).val().split('\\').pop();
                // Update the label text
                $('#promotional_Video_label').text(fileName);
            });

            // Update label text when a file is selected for banner
            $('#customFile').on('change', function() {
                // Get the file name
                var fileName = $(this).val().split('\\').pop();
                // Update the label text
                $('#customFile_label').text(fileName);
            });

            // Update label text when files are selected for additional images
            $('#additional_images').on('change', function() {
                // Get the file names
                var files = $(this)[0].files;
                var fileNames = '';
                for (var i = 0; i < files.length; i++) {
                    fileNames += files[i].name;
                    if (i < files.length - 1) {
                        fileNames += ', ';
                    }
                }
                // Update the label text
                $('#additional_images_label').text(fileNames);
            });
        });
    </script>
@endsection
