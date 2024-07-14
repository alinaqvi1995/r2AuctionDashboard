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
    <tbody id="gradeTableBody">
        @php $counter = 1 @endphp <!-- Initialize counter -->
        @foreach ($grades as $grade)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <label class="custom-control-label"></label>
                    </div>
                </td>
                <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                <td id="name{{ $grade->id }}">{{ $grade->name }}</td>
                <td id="description{{ $grade->id }}">{{ $grade->description }}</td>
                <td id="status{{ $grade->id }}">{{ $grade->status }}</td>
                <td id="btn{{ $grade->id }}">
                    <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted editGradeBtn"
                        type="button" data-id="{{ $grade->id }}">
                        <span class="text-muted sr-only">Edit</span>
                    </button>
                    <button class="btn btn-sm rounded text-muted deleteGradeBtn" type="button"
                        data-id="{{ $grade->id }}">
                        <span class="fe fe-trash fe-12 mr-3"></span>
                        <span class="text-muted sr-only">Remove</span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
