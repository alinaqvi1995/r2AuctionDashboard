<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th>Sr#</th>
            <th>Name</th>
            <th>Model</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="connectivityTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($connectivities as $connectivity)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $connectivity->id }}">{{ $connectivity->name }}</td>
                <td id="name{{ $connectivity->id }}">{{ isset($connectivity->model) ? $connectivity->model->name : null }}</td>
                <td id="status{{ $connectivity->id }}">{{ $connectivity->status ? 'Active' : 'Inactive' }}</td>
                <td id="btn{{ $connectivity->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editConnectivityBtn"
                        type="button" data-id="{{ $connectivity->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteConnectivityBtn" type="button"
                        data-id="{{ $connectivity->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
