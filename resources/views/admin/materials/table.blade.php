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
    <tbody id="materialTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($materials as $material)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $material->id }}">{{ $material->name }}</td>
                <td id="name{{ $material->id }}">{{ isset($material->model) ? $material->model->name : null }}</td>
                <td id="status{{ $material->id }}">{{ $material->status ? 'Active' : 'Inactive' }}</td>
                <td id="btn{{ $material->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editMaterialBtn"
                        type="button" data-id="{{ $material->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteMaterialBtn" type="button"
                        data-id="{{ $material->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
