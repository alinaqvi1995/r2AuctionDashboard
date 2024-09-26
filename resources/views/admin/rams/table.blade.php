<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th>Sr#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="ramTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($rams as $ram)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $ram->id }}">{{ $ram->name }}</td>
                <td id="status{{ $ram->id }}">{{ $ram->status }}</td>
                <td id="btn{{ $ram->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editRamBtn"
                        type="button" data-id="{{ $ram->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteRamBtn" type="button"
                        data-id="{{ $ram->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
