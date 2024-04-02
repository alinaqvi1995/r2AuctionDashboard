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
    <tbody id="productTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($products as $products)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $products->id }}">{{ $products->name }}</td>
                <td id="description{{ $products->id }}">{{ $products->description }}</td>
                <td id="status{{ $products->id }}">{{ $products->status }}</td>
                <td id="btn{{ $products->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editProductBtn"
                        type="button" data-id="{{ $products->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteProductBtn" type="button"
                        data-id="{{ $products->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
