<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th>Sr#</th>
            <th>Name</th>
            <th>Model Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="capacityTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($capacities as $capacity)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $capacity->id }}">{{ $capacity->name }}</td>
                <td id="name{{ $capacity->id }}">{{ isset($capacity->brand) ? $capacity->brand->name : null }}</td>
                <td id="description{{ $capacity->id }}">{{ $capacity->description }}</td>
                <td id="status{{ $capacity->id }}">{{ $capacity->status ? 'Active' : 'Inactive' }}</td>
                <td id="btn{{ $capacity->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editCapacityBtn"
                        type="button" data-id="{{ $capacity->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteCapacityBtn" type="button"
                        data-id="{{ $capacity->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
