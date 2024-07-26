<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with(['buyer', 'seller'])->get();
        return view('admin.user_management.users.index', compact('users'));
    }

    public function edit($product)
    {
        $user = User::findOrFail($product);
        return view('admin.user_management.users.edit', compact('user'));
    }

    public function update(Request $request, $product)
    {
        $user = User::findOrFail($product);

        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:255'],
            // 'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'state' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'business_email' => ['nullable', 'string', 'email', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'business_website' => ['nullable', 'string', 'max:255'],
            'business_desc' => ['nullable', 'string', 'max:500'],
            // 'role' => ['required', 'string', 'in:admin,buyer,seller,user'],
            'status' => ['required', 'string'],
            // Add other validation rules for buyer and seller fields as necessary
        ]);

        
        if ($validator->fails()) {
            dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Update user data
        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user->update($data);

        // Handle Buyer or Seller update
        if ($user->role === 'buyer') {
            $buyerData = $request->only([
                'first_name',
                'last_name',
                'business_type',
                'company_legal_name',
                'phone',
                'whatsapp',
                'website',
                'resale_business_type',
                'hear_about_us',
                'monthly_purchasing_ability',
                'billing_address1',
                'billing_address2',
                'billing_city',
                'billing_state',
                'billing_zip',
                'billing_country',
                'same_as_billing',
                'shipping_address1',
                'shipping_address2',
                'shipping_city',
                'shipping_state',
                'shipping_zip',
                'shipping_country',
                'account_first_name',
                'account_last_name',
                'account_phone',
                'account_email',
                'account_same_as_primary_contact',
                'shipping_first_name',
                'shipping_last_name',
                'shipping_phone',
                'shipping_email',
                'shipping_same_as_primary_contact',
                'payment_method',
                'bank_name',
                'account_title',
                'security_deposit',
                'business_license',
                'address_proof',
                'owner_eid',
                'security_deposit_slip',
                'tra_certificate'
            ]);

            $buyer = Buyer::updateOrCreate(['user_id' => $user->id], $buyerData);
        } elseif ($user->role === 'seller') {
            $sellerData = $request->only([
                'company_name',
                'contact_phone',
                'first_name',
                'last_name',
                'linkedIn',
                'whatsapp',
                'website',
                'hear_about_us',
                'company_address',
                'company_city',
                'company_state',
                'company_zip',
                'company_country',
                'bank_name',
                'bank_address',
                'bank_benificiary_name',
                'account_number',
                'iban_number',
                'swift_code',
                'business_type',
                'business_license',
                'address_proof',
                'owner_eid',
                'tra_certificate',
                'bank_swift_letter'
            ]);

            $seller = Seller::updateOrCreate(['user_id' => $user->id], $sellerData);
        }

        if ($user->role == 'admin') {
            return redirect()->route('admin')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }
    }
}
