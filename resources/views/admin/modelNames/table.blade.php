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
    <tbody id="modelNameTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($modelNames as $modelName)
            <tr>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $modelName->id }}">{{ $modelName->name }}</td>
                <td id="status{{ $modelName->id }}">{{ $modelName->status }}</td>
                <td id="btn{{ $modelName->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editModelNameBtn"
                        type="button" data-id="{{ $modelName->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteModelNameBtn" type="button"
                        data-id="{{ $modelName->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
