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
    <tbody id="generationTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($generations as $generation)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $generation->id }}">{{ $generation->name }}</td>
                <td id="name{{ $generation->id }}">{{ isset($generation->model) ? $generation->model->name : null }}</td>
                <td id="status{{ $generation->id }}">{{ $generation->status ? 'Active' : 'Inactive' }}</td>
                <td id="btn{{ $generation->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editGenerationBtn"
                        type="button" data-id="{{ $generation->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteGenerationBtn" type="button"
                        data-id="{{ $generation->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
