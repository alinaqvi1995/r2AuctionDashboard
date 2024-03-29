@extends('dashboard.vendor.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Edit Category</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Category Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.update', $category->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ $category->title }}" placeholder="Enter category title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" value="{{ $category->slug }}" placeholder="Enter category slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter category description">{{ $category->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="type">Category Type</label>
                                <select id="type" name="type" class="form-control" required>
                                    <option value="">Select Package</option>
                                    <option {{ $category->type == 'ecommerce' ? 'selected' : '' }} value="ecommerce">ecommerce</option>
                                    <option {{ $category->type == 'events' ? 'selected' : '' }} value="events">events</option>
                                    <option {{ $category->type == 'music' ? 'selected' : '' }} value="music">music</option>
                                    <option {{ $category->type == 'appointment' ? 'selected' : '' }} value="appointment">appointment</option>
                                    <option {{ $category->type == 'ad_space' ? 'selected' : '' }} value="ad_space">ad_space</option>
                                    <option {{ $category->type == 'blogging' ? 'selected' : '' }} value="blogging">blogging</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="package_id">Package</label>
                                <select id="package_id" name="package_id" class="form-control" required>
                                    <option value="">Select Package</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}" {{ $package->id == $category->package_id ? 'selected' : '' }}>{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
