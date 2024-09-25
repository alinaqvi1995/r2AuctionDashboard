<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Posted By</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Featured</th>
            <th>Admin Approval</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="productTableBody">
        @php $counter = 1 @endphp
        @foreach ($products as $product)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td>
                <td id="name{{ $product->id }}">{{ $product->name }}</td>
                <td id="user{{ $product->id }}">
                    {{ $product->user->name . ' ' . $product->user->middle_name . ' ' . $product->user->last_name }}
                </td>
                <td id="description{{ $product->id }}">{{ $product->description }}</td>
                <td id="status{{ $product->id }}">
                    @if ($product->status == 1)
                        Active
                    @else
                        Inactive
                    @endif
                </td>
                <td>
                    @if ($product->admin_approval == 1)
                        <button
                            class="btn btn-sm featured-toggle {{ $product->featured ? 'btn-success' : 'btn-danger' }}"
                            data-id="{{ $product->id }}" {{ $product->status == 0 ? 'disabled' : '' }}>
                            {{ $product->featured ? 'Active' : 'Inactive' }}
                        </button>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled data-id="{{ $product->id }}">Waiting For
                            Admin Approval
                        </button>
                    @endif
                </td>
                <td id="admin_approval{{ $product->id }}">
                    @if ($product->admin_approval == 1)
                        Approved
                    @elseif ($product->admin_approval == 0)
                        Waiting For Approval
                    @else
                        Not Approved
                    @endif
                </td>
                <td id="image{{ $product->id }}">
                    @if ($product['images'] && isset($product['images'][0]['path']))
                        <img src="{{ $product['images'][0]['path'] }}" alt="Product Image" style="max-width: 100px;">
                    @else
                        No Image Available
                    @endif
                </td>
                <td id="btn{{ $product->id }}">
                    {{-- <a href="{{ route('products.edit', $product->id) }}"
                        class="btn btn-sm rounded dropdown-toggle more-horizontal text-mute" type="button"
                        data-id="{{ $product->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;"
                        class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm rounded text-muted deleteProductBtn" type="submit"
                            data-id="{{ $product->id }}">
                            <span class="fe fe-trash fe-12 mr-3"></span>
                            <span class="text-muted sr-only">Remove</span>
                        </button>
                    </form> --}}
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="text-muted sr-only">Action</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow">
                        <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}"><i
                                class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $product->id }}">
                            <button type="submit" class="dropdown-item"><i
                                    class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
