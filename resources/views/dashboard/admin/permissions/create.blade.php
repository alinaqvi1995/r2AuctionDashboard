@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Permission</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Permission Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter permission name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="display_name">Display Name</label>
                                <input type="text" id="display_name" name="display_name" class="form-control" placeholder="Enter display name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Permission</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
