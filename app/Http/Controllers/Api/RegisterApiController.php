<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterApiController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'business_email' => 'nullable|string|email|max:255',
            'designation' => 'nullable|string|max:255',
            'business_website' => 'nullable|string|max:255',
            'business_desc' => 'nullable|string|max:500',
            // 'role' => 'nullable|string|in:admin,buyer,seller,user|max:50',
        ]);

        $role = $request->role ?? 'user';

        $user = User::create([
            'name' => $validatedData['name'] ?? '',
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'middle_name' => $validatedData['middle_name'] ?? '',
            'last_name' => $validatedData['last_name'] ?? '',
            'full_name' => trim(($validatedData['name'] ?? '') . ' ' . ($validatedData['middle_name'] ?? '') . ' ' . ($validatedData['last_name'] ?? '')),
            'phone' => $validatedData['phone'] ?? '',
            'state' => $validatedData['state'] ?? '',
            'city' => $validatedData['city'] ?? '',
            'address' => $validatedData['address'] ?? '',
            'business_name' => $validatedData['business_name'] ?? '',
            'business_email' => $validatedData['business_email'] ?? '',
            'designation' => $validatedData['designation'] ?? '',
            'business_website' => $validatedData['business_website'] ?? '',
            'business_desc' => $validatedData['business_desc'] ?? '',
            'role' => $role,
            'business_type' => $validatedData['business_type'] ?? null,
        ]);

        if ($role === 'buyer') {
            Buyer::create([
                'user_id' => $user->id,
                'buyer_type' => $validatedData['buyer_type'] ?? '',
                'first_name' => $validatedData['first_name'] ?? '',
                'last_name' => $validatedData['last_name'] ?? '',
                'business_type' => $validatedData['business_type'] ?? null,
                'company_legal_name' => $validatedData['company_legal_name'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'whatsapp' => $validatedData['whatsapp'] ?? null,
                'website' => $validatedData['website'] ?? null,
                'resale_business_type' => $validatedData['resale_business_type'] ?? null,
                'hear_about_us' => $validatedData['hear_about_us'] ?? null,
                'monthly_purchasing_ability' => $validatedData['monthly_purchasing_ability'] ?? null,
                'billing_address1' => $validatedData['billing_address1'] ?? null,
                'billing_address2' => $validatedData['billing_address2'] ?? null,
                'billing_city' => $validatedData['billing_city'] ?? null,
                'billing_state' => $validatedData['billing_state'] ?? null,
                'billing_zip' => $validatedData['billing_zip'] ?? null,
                'billing_country' => $validatedData['billing_country'] ?? null,
                'same_as_billing' => $validatedData['same_as_billing'] ?? null,
                'shipping_address1' => $validatedData['shipping_address1'] ?? null,
                'shipping_address2' => $validatedData['shipping_address2'] ?? null,
                'shipping_city' => $validatedData['shipping_city'] ?? null,
                'shipping_state' => $validatedData['shipping_state'] ?? null,
                'shipping_zip' => $validatedData['shipping_zip'] ?? null,
                'shipping_country' => $validatedData['shipping_country'] ?? null,
                'account_first_name' => $validatedData['account_first_name'] ?? null,
                'account_last_name' => $validatedData['account_last_name'] ?? null,
                'account_phone' => $validatedData['account_phone'] ?? null,
                'account_email' => $validatedData['account_email'] ?? null,
                'account_same_as_primary_contact' => $validatedData['account_same_as_primary_contact'] ?? null,
                'shipping_first_name' => $validatedData['shipping_first_name'] ?? null,
                'shipping_last_name' => $validatedData['shipping_last_name'] ?? null,
                'shipping_phone' => $validatedData['shipping_phone'] ?? null,
                'shipping_email' => $validatedData['shipping_email'] ?? null,
                'shipping_same_as_primary_contact' => $validatedData['shipping_same_as_primary_contact'] ?? null,
                'payment_method' => $validatedData['payment_method'] ?? null,
                'bank_name' => $validatedData['bank_name'] ?? null,
                'account_title' => $validatedData['account_title'] ?? null,
                'security_deposit' => $validatedData['security_deposit'] ?? null,
                'business_license' => $validatedData['business_license'] ?? null,
                'address_proof' => $validatedData['address_proof'] ?? null,
                'owner_eid' => $validatedData['owner_eid'] ?? null,
                'security_deposit_slip' => $validatedData['security_deposit_slip'] ?? null,
                'tra_certificate' => $validatedData['tra_certificate'] ?? null,
                'r2_certificate' => $validatedData['r2_certificate'] ?? null,
            ]);
        } elseif ($role === 'seller') {
            Seller::create([
                'user_id' => $user->id,
                'company_name' => $validatedData['company_name'] ?? '',
                'contact_phone' => $validatedData['contact_phone'] ?? '',
                'first_name' => $validatedData['first_name'] ?? '',
                'last_name' => $validatedData['last_name'] ?? '',
                'linkedIn' => $validatedData['linkedIn'] ?? null,
                'whatsapp' => $validatedData['whatsapp'] ?? null,
                'website' => $validatedData['website'] ?? null,
                'hear_about_us' => $validatedData['hear_about_us'] ?? null,
                'company_address' => $validatedData['company_address'] ?? null,
                'company_city' => $validatedData['company_city'] ?? null,
                'company_state' => $validatedData['company_state'] ?? null,
                'company_zip' => $validatedData['company_zip'] ?? null,
                'company_country' => $validatedData['company_country'] ?? null,
                'bank_name' => $validatedData['bank_name'] ?? null,
                'bank_address' => $validatedData['bank_address'] ?? null,
                'bank_benificiary_name' => $validatedData['bank_benificiary_name'] ?? null,
                'account_number' => $validatedData['account_number'] ?? null,
                'iban_number' => $validatedData['iban_number'] ?? null,
                'swift_code' => $validatedData['swift_code'] ?? null,
                'business_type' => $validatedData['business_type'] ?? null,
                'business_license' => $validatedData['business_license'] ?? null,
                'address_proof' => $validatedData['address_proof'] ?? null,
                'owner_eid' => $validatedData['owner_eid'] ?? null,
                'tra_certificate' => $validatedData['tra_certificate'] ?? null,
                'bank_swift_letter' => $validatedData['bank_swift_letter'] ?? null,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'string', 'min:8'],
            'middle_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20'],
            'state' => ['sometimes', 'string', 'max:255'],
            'city' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:255'],
            'business_name' => ['sometimes', 'string', 'max:255'],
            'business_email' => ['sometimes', 'string', 'email', 'max:255'],
            'designation' => ['sometimes', 'string', 'max:255'],
            'business_website' => ['sometimes', 'string', 'max:255'],
            'business_desc' => ['sometimes', 'string', 'max:500'],
            'role' => ['sometimes', 'string', 'in:admin,buyer,seller,user'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'request' => $request->toArray()
        ], 201);

        $user->update($data);

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
                'security_deposit', //file
                'business_license', //file
                'address_proof',    //file
                'owner_eid',    //file
                'security_deposit_slip',    //file
                'tra_certificate',  //file
                'r2_certificate'    //file
            ]);

            $buyer = Buyer::firstOrNew(['user_id' => $user->id]);
            $buyer->fill($buyerData);
            $buyer->save();
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
                'business_license', //file
                'address_proof',    //file
                'owner_eid',    //file
                'tra_certificate',  //file
                'bank_swift_letter' //file
            ]);

            $seller = Seller::firstOrNew(['user_id' => $user->id]);
            $seller->fill($sellerData);
            $seller->save();
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
}
