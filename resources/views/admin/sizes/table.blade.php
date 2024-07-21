<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="sizeTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($sizes as $size)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $size->id }}">{{ $size->name }}</td>
                <td id="status{{ $size->id }}">{{ $size->status }}</td>
                <td id="btn{{ $size->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editSizeBtn"
                        type="button" data-id="{{ $size->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteSizeBtn" type="button"
                        data-id="{{ $size->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
