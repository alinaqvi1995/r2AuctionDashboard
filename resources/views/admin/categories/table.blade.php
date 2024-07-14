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
    <tbody id="categoryTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($categories as $category)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $category->id }}">{{ $category->name }}</td>
                <td id="description{{ $category->id }}">{{ $category->description }}</td>
                <td id="icon{{ $category->id }}">
                    <img src="{{ asset('storage/'.$category->icon) }}" alt="{{ $category->name }}" width="50" height="50">
                </td>
                <td id="btn{{ $category->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editCategoryBtn"
                        type="button" data-id="{{ $category->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteCategoryBtn" type="button"
                        data-id="{{ $category->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
