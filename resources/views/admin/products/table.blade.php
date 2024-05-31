<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Image</th> <!-- New column for the image -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="productTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($products as $product)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $product->id }}">{{ $product->name }}</td>
                <td id="description{{ $product->id }}">{{ $product->description }}</td>
                <td id="status{{ $product->id }}">{{ $product->status }}</td>
                <td id="image{{ $product->id }}">
                    @if($product->image)
                    <img src="{{ asset('products/' . $product->image) }}" alt="Product Image" style="max-width: 100px;">
                    @else
                        No Image Available
                    @endif
                </td>
                <td id="btn{{ $product->id }}">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm rounded dropdown-toggle more-horizontal text-mute"
                        type="button" data-id="{{ $product->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </a>
                    <button class="btn btn-sm rounded text-muted deleteProductBtn" type="button"
                        data-id="{{ $product->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
