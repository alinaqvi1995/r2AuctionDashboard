@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-theme-primary text-uppercase mb-0 text-center fs-18 fw-bold">Edit Profile</h1>
        <div class="m-5">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="p-x-70 p-y-20">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-4">
                            <label for="name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('First Name') }}</label>
                            <input id="name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('name') is-invalid @enderror"
                                name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="middle_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Middle Name') }}</label>
                            <input id="middle_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="middle_name"
                                value="{{ $user->middle_name }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="last_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="last_name"
                                value="{{ $user->last_name }}" required>
                        </div>

                        <div class="col-6">
                            <label for="email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Phone') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="phone" value="{{ $user->phone }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="state"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('State') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="state" value="{{ $user->state }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="city"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('City') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="city" value="{{ $user->city }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="address"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Address') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="address" value="{{ $user->address }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="business_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Name') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_name" value="{{ $user->business_name }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="business_email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Email') }}</label>
                            <input type="email" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_email" value="{{ $user->business_email }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="designation"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Designation') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="designation" value="{{ $user->designation }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="business_website"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Website') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_website" value="{{ $user->business_website }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="business_desc"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Description') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_desc" value="{{ $user->business_desc }}" required>
                        </div>

                        <div class="col-12">
                            <label for="status"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Status') }}</label>
                            <select class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="status" required>
                                <option value="1" @if ($user->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($user->status == 0) selected @endif>Inactive</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="password"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('New Password') }}</label>
                            <input id="password" type="password"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('password') is-invalid @enderror"
                                name="password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="password-confirm"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Confirm New Password') }}</label>
                            <input id="password-confirm" type="password"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="password_confirmation"
                                autocomplete="new-password">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn w-100 py-3 fs-14 text-uppercase fw-bold default-btn">Update
                                Password</button>
                        </div>

                        <div class="col-12 text-center">
                            <label class="form-check-label text-grey text-center fs-14" for="gridCheck">
                                <a href="{{ route('users.index') }}"
                                    class="text-theme-primary text-decoration-underline"> Back to Users</a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
