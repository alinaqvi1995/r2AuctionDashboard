<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\SellerGradingPolicy;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\UserSignedUp;
use Illuminate\Support\Facades\Mail;

class RegisterApiController extends Controller
{
    // public function register(Request $request)
    // {

    //     $validatedData = $request->validate([
    //         'name' => 'nullable|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     $role = $request->role ?? 'user';

    //     $user = User::create([
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'role' => $role,
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     Mail::to($user->email)->send(new UserSignedUp($user));

    //     Notification::create([
    //         'user_id' => $user->id,
    //         'title' => 'New User Registration',
    //         'description' => 'A new user has registered: ' . $user->email,
    //         'link' => route('users.index'),
    //         'is_read' => 0,
    //     ]);

    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'token' => $token
    //     ], 201);
    // }


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $role = $request->role ?? 'user';

        $existingUser = User::withTrashed()->where('email', $validatedData['email'])->first();

        if ($existingUser && $existingUser->trashed()) {
            $existingUser->restore();
            $existingUser->password = Hash::make($validatedData['password']);
            $existingUser->role = $role;
            $existingUser->save();

            $user = $existingUser;
        } else {
            $user = User::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $role,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        Mail::to($user->email)->send(new UserSignedUp($user));

        Notification::create([
            'user_id' => $user->id,
            'title' => 'New User Registration',
            'description' => 'A new user has registered: ' . $user->email,
            'link' => route('users.index'),
            'is_read' => 0,
        ]);

        return response()->json([
            'message' => $existingUser ? 'User restored successfully' : 'User registered successfully',
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

        $data['full_name'] = trim(($request->input('name') ?? '') . ' ' . ($request->input('middle_name') ?? '') . ' ' . ($request->input('last_name') ?? ''));

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
                'security_deposit',
                'user_type'
            ]);

            $buyer = Buyer::firstOrNew(['user_id' => $user->id]);
            $buyer->fill($buyerData);

            $buyerFiles = [
                // 'security_deposit',
                'business_license',
                'address_proof',
                'owner_eid',
                'security_deposit_slip',
                'tra_certificate',
                'r2_certificate'
            ];

            foreach ($buyerFiles as $file) {
                if ($request->hasFile($file)) {
                    $filename = time() . '_' . $file . '.' . $request->file($file)->getClientOriginalExtension();
                    $request->file($file)->move(public_path('buyer_files'), $filename);
                    $buyer->{$file} = url('/') . '/' . 'buyer_files/' . $filename;
                }
            }

            $buyer->save();

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Buyer Updated',
                'description' => 'Buyer information has been updated: ' . $user->full_name,
                'link' => route('users.index'),
                'is_read' => 0,
            ]);

        } elseif ($user->role === 'seller') {
            $sellerData = $request->only([
                'company_name',
                'contact_phone',
                'first_name',
                'user_type',
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
                'company_cont_address',
                'company_terms_conditions',
                'company_grading_policy',
                'business_type'
            ]);

            $seller = Seller::firstOrNew(['user_id' => $user->id]);
            $seller->fill($sellerData);

            $sellerFiles = [
                'business_license',
                'address_proof',
                'owner_eid',
                'tra_certificate',
                'bank_swift_letter'
            ];

            foreach ($sellerFiles as $file) {
                if ($request->hasFile($file)) {
                    $filename = time() . '_' . $file . '.' . $request->file($file)->getClientOriginalExtension();
                    $request->file($file)->move(public_path('seller_files'), $filename);
                    $seller->{$file} = url('/') . '/' . 'seller_files/' . $filename;
                }
            }

            $seller->save();

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Seller Updated',
                'description' => 'Seller information has been updated: ' . $user->full_name,
                'link' => route('users.index'),
                'is_read' => 0,
            ]);

            if ($request->has('policy_grade_title') && $request->has('policy_grade_description')) {
                $policyTitles = $request->input('policy_grade_title');
                $policyDescriptions = $request->input('policy_grade_description');

                $policyIdsToKeep = [];

                foreach ($policyTitles as $index => $title) {
                    $description = $policyDescriptions[$index];

                    $gradingPolicy = SellerGradingPolicy::updateOrCreate(
                        ['seller_id' => $seller->id, 'grade' => $title],
                        ['description' => $description]
                    );

                    $policyIdsToKeep[] = $gradingPolicy->id;
                }

                SellerGradingPolicy::where('seller_id', $seller->id)
                    ->whereNotIn('id', $policyIdsToKeep)
                    ->delete();
            }

        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
}
