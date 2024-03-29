@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Category</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Category Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Enter category title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter category slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter category description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="type">Category Type</label>
                                <select id="type" name="type" class="form-control" required>
                                    <option value="" selected disabled>Select Package</option>
                                    <option value="ecommerce">ecommerce</option>
                                    <option value="events">events</option>
                                    <option value="music">music</option>
                                    <option value="appointment">appointment</option>
                                    <option value="ad_space">ad_space</option>
                                    <option value="blogging">blogging</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="package_id">Package</label>
                                <select id="package_id" name="package_id" class="form-control" required>
                                    <option value="">Select Package</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
