@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="mb-2 page-title">Subcategories</h2>
        <p class="card-text">Subcategories table.</p>
        <div class="row my-4">
            <!-- data table -->
            <div class="col-md-12">
                <a href="{{ route('subcategories.create') }}" class="btn btn-primary mb-2">Add New Subcategory</a>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Sr#</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1 @endphp <!-- Initialize counter -->
                                @foreach ($subcategories as $subcategory)
                                <tr id="row_{{ $subcategory->id }}">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <label class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                                    <td>{{ $subcategory->category->title }}</td>
                                    <td>{{ $subcategory->title }}</td>
                                    <td>{{ ucfirst($subcategory->status) }}</td>
                                    <td>{{ $subcategory->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow">
                                            <a class="dropdown-item" href="{{ route('subcategories.edit', $subcategory->id) }}"><i
                                                    class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                                            <button type="button" class="dropdown-item delete-subcategory" data-id="{{ $subcategory->id }}"><i
                                                    class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- data table -->
        </div> <!-- end section -->
    </div> <!-- .col-12 -->
</div>

@endsection

@section('bottom_script')
<script>
    $(document).ready(function() {
        $('.delete-subcategory').click(function() {
            var subcategoryId = $(this).data('id');

            if (confirm('Are you sure you want to delete this subcategory?')) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('subcategories.destroy', '__subcategory_id__') }}".replace('__subcategory_id__', subcategoryId),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE"
                    },
                    success: function(response) {
                        $('#row_' + subcategoryId).remove();
                        alert('Subcategory deleted successfully.');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to delete subcategory.');
                    }
                });
            }
        });
    });
</script>
@endsection
