<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Title</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
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
            <td>{{ $product->title }}</td>
            <td>
                @if($product->status == 1)
                    Active
                @else
                    Inactive
                @endif
            </td>
            <td>{{ $product->created_at }}</td>
            {{-- <td>
                <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted"
                    type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right shadow">
                    <a class="dropdown-item editProductBtn" href="#editProductModal"><i
                            class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item deleteProductBtn"><i
                                class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                    </form>
                </div>
            </td> --}}
            <td id="btn{{ $product->id }}">
                <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editProductBtn"
                    type="button" data-id="{{ $product->id }}" data-toggle="modal"
                    data-target="#editProductModal">
                    <span class="text-muted sr-only">Edit</span>
                </button>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm rounded text-muted deleteProductBtn">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>