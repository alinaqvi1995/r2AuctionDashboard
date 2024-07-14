@extends('auth.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-theme-primary text-uppercase mb-0 text-center fs-18 fw-bold">Sign up FOR Admin Panel</h1>
        <div class="m-5">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="p-x-70 p-y-20">
                    <form method="POST" action="{{ route('register') }}" class="row g-3">
                        @csrf

                        <!-- First Name -->
                        <div class="col-md-4">
                            <label for="name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('First Name') }}</label>
                            <input id="name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="col-md-4">
                            <label for="middle_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Middle Name') }}</label>
                            <input id="middle_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="middle_name"
                                value="{{ old('middle_name') }}" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-4">
                            <label for="last_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="last_name"
                                value="{{ old('last_name') }}" required>
                        </div>

                        <!-- Email Address -->
                        <div class="col-6">
                            <label for="email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Phone') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="phone" value="{{ old('phone') }}" required>
                        </div>

                        <!-- State -->
                        <div class="col-md-3">
                            <label for="state"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('State') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="state" value="{{ old('state') }}" required>
                        </div>

                        <!-- City -->
                        <div class="col-md-3">
                            <label for="city"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('City') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="city" value="{{ old('city') }}" required>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label for="address"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Address') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="address" value="{{ old('address') }}" required>
                        </div>

                        <!-- Business Name -->
                        <div class="col-md-6">
                            <label for="business_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Name') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_name" value="{{ old('business_name') }}" required>
                        </div>

                        <!-- Business Email -->
                        <div class="col-md-6">
                            <label for="business_email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Email') }}</label>
                            <input type="email" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_email" value="{{ old('business_email') }}" required>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-4">
                            <label for="designation"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Designation') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="designation" value="{{ old('designation') }}" required>
                        </div>

                        <!-- Business Website -->
                        <div class="col-md-4">
                            <label for="business_website"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Website') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_website" value="{{ old('business_website') }}" required>
                        </div>

                        <!-- Business Description -->
                        <div class="col-md-4">
                            <label for="business_desc"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Description') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="business_desc" value="{{ old('business_desc') }}" required>
                        </div>

                        <!-- Password -->
                        <div class="col-12">
                            <label for="password"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-12">
                            <label for="password-confirm"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>

                        <!-- Sign up As Role -->
                        <div class="col-12">
                            <label for="role"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Sign up As') }}</label>
                            <select id="role" name="role"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" required>
                                <option value="">Select Role</option>
                                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        {{-- <div class="col-12">
                            <button type="submit" class="btn w-100 py-3 fs-14 text-uppercase fw-bold default-btn">Create
                                Account</button>

                            <a href="{{ route('social.redirect', ['provider' => 'facebook']) }}"
                                class="btn btn-primary">Login with Facebook</a>
                            <a href="{{ route('social.redirect', ['provider' => 'google']) }}"
                                class="btn btn-danger">Login with Google</a>
                        </div> --}}

                        <!-- Login Link -->
                        <div class="col-12 text-center">
                            <label class="form-check-label text-grey text-center  fs-14" for="gridCheck">
                                Already a member? <a href="{{ route('login') }}"
                                    class="text-theme-primary text-decoration-underline"> Sign in</a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
