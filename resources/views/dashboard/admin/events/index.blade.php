@extends('dashboard.admin.layouts.app')

@section('content')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .tag {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e0e0e0;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .tag-remove {
            margin-left: 5px;
            color: #888;
            cursor: pointer;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center my-3">
                <div class="col">
                    <h2 class="page-title">Calendar</h2>
                    <button type="button" class="btn btn-primary" id="view-btn"><i class='fe fe-calendar fe-16'></i> Calender
                        View</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn" data-toggle="modal" data-target=".modal-calendar"><span
                            class="fe fe-filter fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-primary" id="openEventModal"><span
                            class="fe fe-plus fe-16 mr-3"></span>New Event</button>
                </div>
            </div>
            <div class="col-md-12 my-4 d-none" id="list-view">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="card-title">
                            <h5>
                                Events List
                            </h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                        </div>
                        <div class="toolbar">
                            <form class="form">
                                <div class="form-row">
                                    <div class="form-group col-auto mr-auto">
                                    </div>
                                    <div class="form-group col-auto">
                                        <label for="search" class="sr-only">Search</label>
                                        <input type="text" class="form-control" id="search1" value=""
                                            placeholder="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-borderless table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Event Type</th>
                                            <th>Category</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="user-table-body">

                                    </tbody>
                                </table>
                                <nav aria-label="Table Paging" class="mb-0 text-muted">
                                    <ul class="pagination justify-content-center mb-0" id="user-pagination">
                                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id='calendar' class=""></div>
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
                    <form id="createEventForm" method="POST" action="{{ route('events.store') }}">
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
                                    <select id="package_id" name="package_id" class="form-control" required>
                                        <option value="">Select Package</option>
                                        @foreach ($packages as $package)
                                            <option value="{{ $package->id }}">{{ $package->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
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
                                    {{-- @foreach ($categories as $row)
                                        <span class="badge badge-primary tag badge-lg" data-id="{{ $row->id }}"
                                            style="font-size: 1.25em;">
                                            {{ $row->title }}
                                        </span>
                                        <input type="hidden" name="dress_code[]" value="{{ $row->title }}">
                                    @endforeach --}}
                                    <div id="tag-container">
                                    </div>
                                    <input type="text" id="tag-input" class="form-control"
                                        placeholder="Type and press Enter to add tag" required>
                                    <input type="hidden" id="tag-values" name="dress_code[]" value="">
                                </div>
                                {{-- <p id="addNewTagText" style="color: blue; text-decoration: underline; cursor: pointer;">
                                    Add
                                    New</p> --}}
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
        function createTag(text) {
            var tag = document.createElement('div');
            tag.classList.add('tag');
            tag.textContent = text;
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'dress_code[]';
            hiddenInput.value = text;
            tag.addEventListener('click', function() {
                tag.remove();
                hiddenInput.remove();
            });
            var removeBtn = document.createElement('span');
            removeBtn.classList.add('tag-remove');
            removeBtn.textContent = '×';
            removeBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                tag.remove();
                hiddenInput.remove();
            });

            tag.appendChild(removeBtn);
            document.getElementById("dress_code_tags").appendChild(hiddenInput);
            return tag;
        }
        document.getElementById('tag-input').addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && this.value.trim() !== '') {
                var tagText = this.value.trim();
                var tagContainer = document.getElementById('tag-container');
                var tag = createTag(tagText);
                tagContainer.appendChild(tag);
                this.value = '';
            }
        });
        $("#view-btn").click(function() {
            text = $(this).html();
            if (text == '<i class="fe fe-grid fe-16"></i> List View') {
                $(this).html("<i class='fe fe-calendar fe-16'></i> Calender View");
                $("#list-view").addClass("d-none");
                $("#calendar").removeClass("d-none");
            } else {
                $(this).html("<i class='fe fe-grid fe-16'></i> List View");
                $("#calendar").addClass("d-none");
                $("#list-view").removeClass("d-none");
            }
        });
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
                    url: '{{ route('events.store') }}',
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
    <script>
        $(document).ready(function() {
            $('#package_id').on('change', function() {
                var packageId = $(this).val();
                var categorySelect = $('#category_id');
                console.log(packageId, 'packageIdpackageId');

                // Clear existing options
                categorySelect.empty().append('<option value="">Select Category</option>');

                // Fetch categories based on the selected package
                $.ajax({
                    url: '{{ route('get.categories', ':id') }}'.replace(':id', packageId),
                    data: {
                        packageId: packageId
                    }, // Pass the packageId as data
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, category) {
                            categorySelect.append('<option value="' + category.id +
                                '">' + category.title + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
    <script>
        var search = null;
        $("input").keyup(function() {
            search = $(this).val();
            fetchDataOnReady();
        });
        $(document).ready(function() {
            fetchDataOnReady();
        });

        function fetchDataOnClick(page) {
            console.log(page);
            $.ajax({
                url: "{{ route('events.index') }}",
                type: "GET",
                data: {
                    type: 'ajax',
                    page: page
                },
                success: function(response) {
                    console.log("Data fetched successfully on click:", response);
                    generateTableRows(response.data);
                    generatePagination(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data on click:", error);
                }
            });
        }

        function fetchDataOnReady() {
            $.ajax({
                url: "{{ route('events.index') }}",
                type: "GET",
                data: {
                    type: 'ajax',
                    search: search
                },
                success: function(response) {
                    console.log("Data fetched successfully on document ready:", response);
                    $('#user-table-body').empty();
                    generateTableRows(response.data);
                    generatePagination(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data on document ready:", error);
                }
            });
        }

        function generateTableRows(users) {
            var html = '';
            const currentUrl = window.location.href;
            $.each(users, function(index, user) {
                html += '<tr>';
                html += '<td>' + user.name + '</td>';
                html += '<td>' + user.eventType + '</td>';
                html += '<td>' + user.category.title + '</td>';
                html += '<td>' + user.start_date + ' ' + user.start_time + '<br/> ' + user.end_date + ' ' + user
                    .end_time + '</td>';
                html += '<td>';
                html +=
                    '  <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                html += '<span class="text-muted sr-only">Action</span>';
                html += '</button>';
                html += '<div class="dropdown-menu dropdown-menu-right shadow">';
                html += '<a class="dropdown-item" href="' + currentUrl + '/' + user.id +
                    '/edit"><i class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>';
                // html += '<a class="dropdown-item" href="#"><i class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</a>';
                // html += '<a class="dropdown-item" href="#"><i class="fe fe-flag fe-12 mr-3 text-muted"></i>Assign</a>';
                html += '</div></td>';
                html += '</tr>';
            });
            $('#user-table-body').html(html);
        }
        pre = 0;
        nxt = 0;

        function generatePagination(response) {
            var html = '';
            if (response.prev_page_url) {
                pre = response.current_page - 1;
                html += '<li class="page-item"><a onclick="fetchDataOnClick(\'' + pre +
                    '\')" href="javascript:void(0);" class="page-link" >Previous</a></li>';
            }
            for (var i = 1; i <= response.last_page; i++) {
                html += '<li class="page-item ' + (i == response.current_page ? 'active' : '') +
                    '"><a class="page-link pg-btn" onclick="fetchDataOnClick(\'' + i + '\')" data-attr="page=' + i +
                    '" href="javascript:void(0);">' + i + '</a></li>';
            }
            if (response.next_page_url) {
                nxt = response.current_page + 1;
                html += '<li class="page-item"><a class="page-link" onclick="fetchDataOnClick(\'' + nxt +
                    '\')" href="javascript:void(0);">Next</a></li>';
            }
            $('#user-pagination').html(html);
        }
    </script>
@endsection
