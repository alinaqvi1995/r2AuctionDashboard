<!-- table -->
<table class="table datatables" id="dataTable-1">
    <thead>
        <tr>
            <th></th>
            <th>Sr#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="subcategoryTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($subcategories as $subcategory)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $subcategory->id }}">{{ $subcategory->name }}</td>
                <td id="description{{ $subcategory->id }}">{{ $subcategory->description }}</td>
                <td id="status{{ $subcategory->id }}">{{ $subcategory->status ? 'Active' : 'Inactive' }}</td>
                <td id="category{{ $subcategory->id }}">{{ $subcategory->category->name }}</td>
                <td id="btn{{ $subcategory->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editSubcategoryBtn"
                        type="button" data-id="{{ $subcategory->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteSubcategoryBtn" type="button"
                        data-id="{{ $subcategory->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
