@extends('dashboard.admin.layouts.app')

@section('content')
    <form method="POST" action="{{ route('users.register') }}" class="col-lg-6 col-md-8 col-10 mx-auto">
        @csrf
        <div class="mx-auto text-center my-4">
            <h2 class="my-3">Register New User</h2>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">Firstname</label>
                <input id="firstname" type="text" class="form-control @error('first_name') is-invalid @enderror"
                    name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">Lastname</label>
                <input id="lastname" type="text" class="form-control @error('last_name') is-invalid @enderror"
                    name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                value="{{ old('phone') }}" required autocomplete="phone">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                value="{{ old('address') }}" autocomplete="address">
            @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="city">City</label>
                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                    value="{{ old('city') }}" autocomplete="city">
                @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="state">State</label>
                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror"
                    name="state" value="{{ old('state') }}" autocomplete="state">
                @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="country">Country</label>
                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror"
                    name="country" value="{{ old('country') }}" autocomplete="country">
                @error('country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="zipcode">Zipcode</label>
                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror"
                    name="zipcode" value="{{ old('zipcode') }}" autocomplete="zipcode">
                @error('zipcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="role">Role</label>
                <select id="role" class="form-control @error('role_id') is-invalid @enderror" name="role_id"
                    required>
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                        @if ($role->name !== 'Admin')
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('role_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group" id="package_input" style="display: none;">
            <label for="package">Package</label>
            <select id="package" class="form-control @error('package_id') is-invalid @enderror" name="package_id">
                <option value="">Select Package</option>
                @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->title }}</option>
                @endforeach
            </select>
            @error('package_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group" id="vendors_input" style="display: none;">
            <label for="vendor">Vendors</label>
            <select id="vendor" class="form-control @error('vendor_id') is-invalid @enderror" name="vendor_id">
                <option value="">Select vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->user->first_name . ' ' . $vendor->user->last_name }}
                    </option>
                @endforeach
            </select>
            @error('vendor_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group" id="category_input" style="display: none;">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">Select Category</option>
            </select>
        </div>
        <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Register') }}</button>
    </form>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('#role').on('change', function() {
                var role = $(this).val();
                console.log(role);
                if (role == 2) {
                    $('#package_input').show();
                    $('#vendors_input').hide();
                } else if (role == 3) {
                    $('#package_input').hide();
                    $('#vendors_input').show();
                } else {
                    $('#package_input').hide();
                    $('#vendors_input').hide();
                }
            });

            $('#package').on('change', function() {
                var packageId = $(this).val();
                $('#category_id').empty().append($('<option>', {
                    value: '',
                    text: 'Select Category'
                }));
                if (packageId) {
                    $.ajax({
                        type: 'GET',
                        url: `{{ route('users.get.categories') }}`,
                        data: {
                            package: packageId,
                            role: $('#role').val(),
                        },
                        success: function(response) {
                            populateCategories(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $('#vendor').on('change', function() {
                var vendor = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: `{{ route('users.get.categories') }}`,
                    data: {
                        vendor: vendor,
                    },
                    success: function(response) {
                        populateCategories(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            function populateCategories(categories) {
                var categoryDropdown = $('#category_id');
                categories.forEach(function(category) {
                    categoryDropdown.append($('<option>', {
                        value: category.id,
                        text: category.title
                    }));
                });
                $('#category_input').show();
            }
        });
    </script>
@endsection
