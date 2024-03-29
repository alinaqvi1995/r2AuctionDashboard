@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="mb-2 page-title">Permissions</h2>
        <p class="card-text">Permissions table.</p>
        <div class="row my-4">
            <!-- data table -->
            <div class="col-md-12">
            {{-- @if(auth()->user()->hasPermission('add.permission'))
                @endif  --}}   
                <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-2">Add New Permission</a>
                <div class="card shadow">
                    <div class="card-body">
                        <!-- table -->
                        <table class="table datatables" id="dataTable-1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $counter = 1 @endphp <!-- Initialize counter -->
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <label class="custom-control-label"></label>
                                        </div>
                                    </td>
                                    <td>{{ $counter++ }}</td> <!-- Increment and display counter -->
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->display_name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>{{ $permission->created_at }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm rounded dropdown-toggle more-horizontal text-muted"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right shadow">
                                                <a class="dropdown-item" href="{{ route('permissions.edit', $permission->id) }}"><i
                                                        class="fe fe-edit-2 fe-12 mr-3 text-muted"></i>Edit</a>
                                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"><i
                                                            class="fe fe-trash fe-12 mr-3 text-muted"></i>Remove</button>
                                                </form>
                                            </div>
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
