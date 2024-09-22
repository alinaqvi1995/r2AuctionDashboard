@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-2 page-title">All Notifications</h2>
        <p class="card-text">Notifications table.</p>
        <div class="row my-4">
            <div class="col-md-12">
                    <div class="card-body">
                        <!-- Time Slot Messages -->
                        <div id="timeSlotMessage"></div>
                        <!-- Table Data -->
                        <div id="tableData">
                            <!-- table -->
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody id="slotTableBody">
                                    @php $counter = 1 @endphp <!-- Initialize counter -->
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                                            <td id="title{{ $notification->id }}">{{ $notification->title }}</td>
                                            <td id="description{{ $notification->id }}">{{ $notification->description }}</td>
                                            {{-- <td id="btn{{ $notification->id }}">
                                                <button
                                                    class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editnotificationBtn"
                                                    type="button" data-id="{{ $slot->id }}">
                                                    <span class="text-muted sr-only">Edit</span>
                                                </button>
                                                <button class="btn btn-sm rounded text-muted deleteSlotBtn" type="button"
                                                    data-id="{{ $slot->id }}">
                                                    <span class="fe fe-trash fe-12 mr-3"></span>
                                                    <span class="text-muted sr-only">Remove</span>
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
