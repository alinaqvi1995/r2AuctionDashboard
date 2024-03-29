<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="variantTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($variants as $variant)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="title{{ $variant->id }}">{{ $variant->title }}</td>
                <td id="type{{ $variant->id }}">
                    {{ $variant->type }}
                </td>
                <td id="created{{ $variant->id }}">{{ $variant->created_at }}</td>
                <td id="btn{{ $variant->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editVariantBtn"
                        type="button" data-id="{{ $variant->id }}" data-toggle="modal"
                        data-target="#editVariantModal">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <form action="{{ route('variants.destroy', $variant->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm rounded text-muted deleteVariantBtn">
                            <span class="fe fe-trash fe-12 mr-3"></span>
                            <span class="text-muted sr-only">Remove</span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
