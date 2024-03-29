@extends('dashboard.admin.layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <h2 class="page-title">Edit Package</h2>
        <div class="card shadow mb-4">
            <div class="card-header">
                <strong class="card-title">Package Information</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('packages.update', $package->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{ $package->title }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" name="slug" class="form-control" value="{{ $package->slug }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" required>{{ $package->description }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ecommerce">E-commerce</label>
                                <select id="ecommerce" name="ecommerce" class="form-control" required>
                                    <option value="true" {{ $package->ecommerce == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->ecommerce == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="events">Events</label>
                                <select id="events" name="events" class="form-control" required>
                                    <option value="true" {{ $package->events == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->events == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="music">Music</label>
                                <select id="music" name="music" class="form-control" required>
                                    <option value="true" {{ $package->music == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->music == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="appointment">Appointment</label>
                                <select id="appointment" name="appointment" class="form-control" required>
                                    <option value="true" {{ $package->appointment == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->appointment == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="ad_space">Ad Space</label>
                                <select id="ad_space" name="ad_space" class="form-control" required>
                                    <option value="true" {{ $package->ad_space == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->ad_space == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="blogging">Blogging</label>
                                <select id="blogging" name="blogging" class="form-control" required>
                                    <option value="true" {{ $package->blogging == 'true' ? 'selected' : '' }}>True</option>
                                    <option value="false" {{ $package->blogging == 'false' ? 'selected' : '' }}>False</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1" {{ $package->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $package->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Package</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .card -->
    </div> <!-- .col-12 -->
</div> <!-- .row -->

@endsection
