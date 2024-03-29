@extends('dashboard.subvendor.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Edit Product</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Product Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('products.update', $product->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ $product->title }}" placeholder="Enter product title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" value="{{ $product->slug }}" placeholder="Enter product slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter product description">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="old_price">Old Price</label>
                                <input type="text" id="old_price" name="old_price" class="form-control" value="{{ $product->old_price }}" placeholder="Enter old price" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="new_price">New Price</label>
                                <input type="text" id="new_price" name="new_price" class="form-control" value="{{ $product->new_price }}" placeholder="Enter new price" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
