@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Create Package</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Package Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('packages.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Enter package title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter package slug" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter package description"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ecommerce">E-commerce</label>
                                <select id="ecommerce" name="ecommerce" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="events">Events</label>
                                <select id="events" name="events" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="music">Music</label>
                                <select id="music" name="music" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="appointment">Appointment</label>
                                <select id="appointment" name="appointment" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ad_space">Ad Space</label>
                                <select id="ad_space" name="ad_space" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="blogging">Blogging</label>
                                <select id="blogging" name="blogging" class="form-control" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
