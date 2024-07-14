<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required'],
            'state' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'business_name' => ['required'],
            'business_email' => ['required'],
            'designation' => ['required'],
            'business_website' => ['required'],
            'business_desc' => ['required'],
            'role' => ['required'],
        ]);
    }

    protected function create(array $data)
    {
        // dd($data);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'],
            'phone' => $data['phone'],
            'state' => $data['state'],
            'city' => $data['city'],
            'address' => $data['address'],
            'business_name' => $data['business_name'],
            'business_email' => $data['business_email'],
            'designation' => $data['designation'],
            'business_website' => $data['business_website'],
            'business_desc' => $data['business_desc'],
            'role' => $data['role'],
        ]);
    }
}
