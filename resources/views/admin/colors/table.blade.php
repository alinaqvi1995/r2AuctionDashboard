<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Color Code</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="colorTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($colors as $color)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $color->id }}">{{ $color->name }}</td>
                <td id="description{{ $color->id }}">{{ $color->description }}</td>
                <td id="color_code{{ $color->id }}">{{ $color->color_code }}</td>
                <td id="status{{ $color->id }}">{{ $color->status ? 'Active' : 'Inactive' }}</td>
                <td id="btn{{ $color->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editColorBtn"
                        type="button" data-id="{{ $color->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteColorBtn" type="button"
                        data-id="{{ $color->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
