<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Icon</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="manufacturerTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($manufacturers as $manufacturer)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $manufacturer->id }}">{{ $manufacturer->name }}</td>
                <td id="description{{ $manufacturer->id }}">{{ $manufacturer->description }}</td>
                <td id="icon{{ $manufacturer->id }}">
                    <img src="{{ asset('storage/'.$manufacturer->icon) }}" alt="{{ $manufacturer->name }}" width="50" height="50">
                </td>
                <td id="btn{{ $manufacturer->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editManufacturerBtn"
                        type="button" data-id="{{ $manufacturer->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteManufacturerBtn" type="button"
                        data-id="{{ $manufacturer->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
