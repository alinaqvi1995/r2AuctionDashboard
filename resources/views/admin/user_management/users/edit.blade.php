@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-theme-primary text-uppercase mb-0 text-center fs-18 fw-bold">Edit Profile @if ($user->role == 'buyer')
                Buyer
            @elseif ($user->role == 'seller')
                Seller
            @endif
        </h1>
        <div class="m-5">
            <div class="col d-flex justify-content-center align-items-center">
                <div class="p-x-70 p-y-20">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <!-- Basic Details -->
                        <div class="col-12">
                            <h4 class="text-theme-primary fs-16 fw-bold">Basic Details</h4>
                        </div>

                        <div class="col-12 text-center my-3">
                            <button type="button"
                                class="btn btn-outline-success admin-approval-btn @if ($user->admin_approval == 1) active @endif"
                                data-value="1">Active</button>
                            <button type="button"
                                class="btn btn-outline-danger admin-approval-btn @if ($user->admin_approval == 0) active @endif"
                                data-value="0">Inactive</button>
                            <input type="hidden" name="admin_approval" id="admin-approval"
                                value="{{ $user->admin_approval }}">
                        </div>

                        <div class="col-md-4">
                            <label for="first_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('First Name') }}</label>
                            <input id="first_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('name') is-invalid @enderror"
                                name="first_name" value="{{ $user->seller->first_name ?? $user->buyer->first_name ?? '' }}" autocomplete="first_name" autofocus>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="col-md-4">
                            <label for="middle_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Middle Name') }}</label>
                            <input id="middle_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="middle_name"
                                value="{{ $user->middle_name }}">
                        </div> --}}

                        <div class="col-md-4">
                            <label for="last_name"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="last_name"
                                value="{{ $user->seller->last_name ?? $user->buyer->last_name ?? '' }}">
                        </div>

                        <div class="col-md-4">
                            <label for="email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Email') }}</label>
                            <input id="email" type="text"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="email" readonly
                                value="{{ $user->email }}">
                        </div>

                        <!-- Contact Information -->
                        {{-- <div class="col-12 mt-4">
                            <h4 class="text-theme-primary fs-16 fw-bold">Contact Information</h4>
                        </div>

                        <div class="col-6">
                            <label for="email"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email"
                                class="form-control fs-14 bg-theme-secondary border-0 h-50px @error('email') is-invalid @enderror"
                                name="email" value="{{ $user->email }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        {{-- <div class="col-md-6">
                            <label for="phone"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Phone') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="phone" value="{{ $user->seller->phone }}">
                        </div>

                        <div class="col-md-3">
                            <label for="state"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('State') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="state" value="{{ $user->seller->company_state }}">
                        </div>

                        <div class="col-md-3">
                            <label for="city"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('City') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="city" value="{{ $user->city }}">
                        </div>

                        <div class="col-md-6">
                            <label for="address"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Address') }}</label>
                            <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                name="address" value="{{ $user->address }}">
                        </div> --}}

                        @if ($user->role == 'seller')
                            <!-- Seller Business Details -->

                            <div class="col-12 mt-4">
                                <h4 class="text-theme-primary fs-16 fw-bold">Seller Business Details</h4>
                            </div>

                            <div class="col-12">
                                <label for="user_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('user_type') }}</label>
                                <select class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="user_type"
                                    required>
                                    <option value="Company" @if ($user->user_type == 'Company') selected @endif>Company
                                    </option>
                                    <option value="Individual" @if ($user->user_type == 'Individual') selected @endif>Individual
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="company_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_name" value="{{ old('company_name', $user->seller->company_name) }}">
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="contact_phone"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Contact Phone') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="contact_phone" value="{{ old('contact_phone', $user->seller->contact_phone) }}">
                            </div> --}}

                            <div class="col-md-4">
                                <label for="linkedIn"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('LinkedIn') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="linkedIn" value="{{ old('linkedIn', $user->seller->linkedIn) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="whatsapp"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('WhatsApp') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="whatsapp" value="{{ old('whatsapp', $user->seller->whatsapp) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="website"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Website') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="website" value="{{ old('website', $user->seller->website) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="hear_about_us"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('How did you hear about us?') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="hear_about_us"
                                    value="{{ old('hear_about_us', $user->seller->hear_about_us) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_address"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Address') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_address"
                                    value="{{ old('company_address', $user->seller->company_address) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="company_city"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company City') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_city" value="{{ old('company_city', $user->seller->company_city) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="company_state"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company State') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_state"
                                    value="{{ old('company_state', $user->seller->company_state) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="company_zip"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company ZIP') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_zip" value="{{ old('company_zip', $user->seller->company_zip) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_country"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Country') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_country"
                                    value="{{ old('company_country', $user->seller->company_country) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_name" value="{{ old('bank_name', $user->seller->bank_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_address"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Address') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_address" value="{{ old('bank_address', $user->seller->bank_address) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_benificiary_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Beneficiary Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_benificiary_name"
                                    value="{{ old('bank_benificiary_name', $user->seller->bank_benificiary_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="account_number"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Account Number') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="account_number"
                                    value="{{ old('account_number', $user->seller->account_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="iban_number"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('IBAN Number') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="iban_number" value="{{ old('iban_number', $user->seller->iban_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="swift_code"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('SWIFT Code') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="swift_code" value="{{ old('swift_code', $user->seller->swift_code) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="business_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Type') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="business_type"
                                    value="{{ old('business_type', $user->seller->business_type) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="business_license"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business License') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="business_license"
                                        name="business_license">
                                    <label class="custom-file-label" for="image" id="business_license_label">Choose
                                        file</label>
                                </div>
                                <div>
                                    @if ($user->seller->business_license != null)
                                        <a href="{{ $user->seller->business_license }}" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="address_proof"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Address Proof') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="address_proof"
                                        name="address_proof">
                                    <label class="custom-file-label" for="image" id="address_proof_label">Choose
                                        file</label>
                                </div>
                                <div>
                                    @if ($user->seller->address_proof != null)
                                        <a href="{{ $user->seller->address_proof }}" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="owner_eid"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Owner EID') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="owner_eid" name="owner_eid">
                                    <label class="custom-file-label" for="image" id="owner_eid_label">Choose
                                        file</label>
                                </div>
                                <div>
                                    @if ($user->seller->owner_eid != null)
                                        <a href="{{ $user->seller->owner_eid }}" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tra_certificate"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('TRA Certificate') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="tra_certificate"
                                        name="tra_certificate">
                                    <label class="custom-file-label" for="image" id="tra_certificate_label">Choose
                                        file</label>
                                </div>
                                <div>
                                    @if ($user->seller->tra_certificate != null)
                                        <a href="{{ $user->seller->tra_certificate }}" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="bank_swift_letter"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank SWIFT Letter') }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="bank_swift_letter"
                                        name="bank_swift_letter">
                                    <label class="custom-file-label" for="image" id="bank_swift_letter_label">Choose
                                        file</label>
                                </div>
                                <div>
                                    @if ($user->seller->bank_swift_letter != null)
                                        <a href="{{ $user->seller->bank_swift_letter }}" target="_blank">
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @elseif($user->role == 'buyer')
                            <!-- Buyer Details -->
                            <div class="col-12 mt-4">
                                <h4 class="text-theme-primary fs-16 fw-bold">Buyer Details</h4>
                            </div>

                            <div class="col-12">
                                <label for="user_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('user_type') }}</label>
                                <select class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="user_type">
                                    <option value="Company" @if ($user->user_type == 'Company') selected @endif>Company
                                    </option>
                                    <option value="Individual" @if ($user->user_type == 'Individual') selected @endif>
                                        Individual
                                    </option>
                                </select>
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="buyer_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Buyer Type') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="buyer_type" value="{{ old('buyer_type', $user->buyer->buyer_type) }}" >
                            </div> --}}

                            {{-- <div class="col-md-6">
                                <label for="first_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('First Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="first_name" value="{{ old('first_name', $user->buyer->first_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="last_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Last Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="last_name" value="{{ old('last_name', $user->buyer->last_name) }}">
                            </div> --}}

                            <div class="col-md-6">
                                <label for="business_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Business Type') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="business_type" value="{{ old('business_type', $user->buyer->business_type) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_legal_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Legal Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_legal_name"
                                    value="{{ old('company_legal_name', $user->buyer->company_legal_name) }}">
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="phone"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Phone') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="phone" value="{{ old('phone', $user->buyer->phone) }}">
                            </div> --}}

                            <div class="col-md-6">
                                <label for="whatsapp"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('WhatsApp') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="whatsapp" value="{{ old('whatsapp', $user->buyer->whatsapp) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="website"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Website') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="website" value="{{ old('website', $user->buyer->website) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="resale_business_type"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Resale Business Type') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="resale_business_type"
                                    value="{{ old('resale_business_type', $user->buyer->resale_business_type) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="hear_about_us"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('How did you hear about us?') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="hear_about_us" value="{{ old('hear_about_us', $user->buyer->hear_about_us) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_address"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Address') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_address"
                                    value="{{ old('company_address', $user->buyer->company_address) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_city"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company City') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_city" value="{{ old('company_city', $user->buyer->company_city) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_state"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company State') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_state" value="{{ old('company_state', $user->buyer->company_state) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_zip"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company ZIP') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_zip" value="{{ old('company_zip', $user->buyer->company_zip) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="company_country"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Company Country') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="company_country"
                                    value="{{ old('company_country', $user->buyer->company_country) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_name" value="{{ old('bank_name', $user->buyer->bank_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_address"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Address') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_address" value="{{ old('bank_address', $user->buyer->bank_address) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="bank_benificiary_name"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Bank Beneficiary Name') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="bank_benificiary_name"
                                    value="{{ old('bank_benificiary_name', $user->buyer->bank_benificiary_name) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="account_number"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('Account Number') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="account_number"
                                    value="{{ old('account_number', $user->buyer->account_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="iban_number"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('IBAN Number') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="iban_number" value="{{ old('iban_number', $user->buyer->iban_number) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="swift_code"
                                    class="form-label fs-14 text-theme-primary fw-bold">{{ __('SWIFT Code') }}</label>
                                <input type="text" class="form-control fs-14 bg-theme-secondary border-0 h-50px"
                                    name="swift_code" value="{{ old('swift_code', $user->buyer->swift_code) }}">
                            </div>
                        @endif

                        <div class="col-12">
                            <label for="status"
                                class="form-label fs-14 text-theme-primary fw-bold">{{ __('Status') }}</label>
                            <select class="form-control fs-14 bg-theme-secondary border-0 h-50px" name="status" required>
                                <option value="1" @if ($user->status == 1) selected @endif>Active</option>
                                <option value="0" @if ($user->status == 0) selected @endif>Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-5 text-center">
                            <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom_script')
    <script>
        $(document).ready(function() {
            $('.admin-approval-btn').on('click', function() {
                $('.admin-approval-btn').removeClass('active');
                $(this).addClass('active');

                var selectedValue = $(this).data('value');
                $('#admin-approval').val(selectedValue);
            });
        });
    </script>
@endsection
