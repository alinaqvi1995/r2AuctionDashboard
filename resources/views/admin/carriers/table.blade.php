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
    <tbody id="carrierTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($carriers as $carrier)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $carrier->id }}">{{ $carrier->name }}</td>
                <td id="description{{ $carrier->id }}">{{ $carrier->description }}</td>
                <td id="status{{ $carrier->id }}">{{ $carrier->status }}</td>
                <td id="btn{{ $carrier->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editCarrierBtn"
                        type="button" data-id="{{ $carrier->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteCarrierBtn" type="button"
                        data-id="{{ $carrier->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
