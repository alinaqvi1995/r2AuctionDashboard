@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="mb-2 page-title">Roles</h2>
        <p class="card-text">Roles table.</p>
        <div class="row my-4">
            <!-- data table -->
            <div class="col-md-12">
                <a href="{{ route('roles.create') }}" class="btn btn-primary mb-2">Add New Role</a>
                <div class="card shadow">
                    <div class="card-body">
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
                            <tbody>
                                @php $counter = 1 @endphp <!-- Initialize counter -->
                                @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <label class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @if($role->status == 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow">
                                            <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}"><i
                                                    class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"><i
                                                        class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                                            </form>
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
