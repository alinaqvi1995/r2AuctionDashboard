@extends('dashboard.vendor.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Event</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Event Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter event name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="package_id">Package</label>
                                <select id="package_id" name="package_id" class="form-control" required>
                                    <option value="">Select Package</option>
                                    @foreach ($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select id="category_id" name="category_id" class="form-control" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="total_no_of_tickets">Total No. of Tickets</label>
                                <input type="number" id="total_no_of_tickets" name="total_no_of_tickets" class="form-control" placeholder="Enter Total No of Tickets" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter event description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
