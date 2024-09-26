<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th>Sr#</th>
            <th>Title</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="newsTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($news as $item)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="title{{ $item->id }}">{{ $item->title }}</td>
                <td id="date{{ $item->id }}">{{ $item->date }}</td>
                <td id="status{{ $item->id }}">
                    @if ($item->status == 1)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif
                </td>
                <td id="btn{{ $item->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editNewsBtn"
                        type="button" data-id="{{ $item->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteNewsBtn" type="button"
                        data-id="{{ $item->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
