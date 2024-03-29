<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="regionTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($regions as $region)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $region->id }}">{{ $region->name }}</td>
                <td id="description{{ $region->id }}">{{ $region->description }}</td>
                <td id="status{{ $region->id }}">{{ $region->status }}</td>
                <td id="btn{{ $region->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editRegionBtn"
                        type="button" data-id="{{ $region->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteRegionBtn" type="button"
                        data-id="{{ $region->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
