<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Package;
use App\Models\Vendor;
use App\Models\SubVendor;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function indexUser()
    {
        $roles = Role::where('status', 1)->get();
        $packages = Package::where('status', 1)->get();
        $vendors = Vendor::with('user')->where('status', 1)->get();
        return view('dashboard.admin.user_management.users.index', compact('roles', 'packages', 'vendors'));
    }

    public function createUser()
    {
        // $user = Vendor::find(1);
        //     $categories = $user->package->category;
        //     dd($categories->toArray());
            
        $roles = Role::where('status', 1)->get();
        $packages = Package::where('status', 1)->get();
        $vendors = Vendor::with('user')->where('status', 1)->get();
        return view('dashboard.admin.user_management.users.create', compact('roles', 'packages', 'vendors'));
    }

    public function getCategories(Request $request)
    {
        $categories = '';
        if ($request->has('role') && $request->role != null) 
        {
            // if ($request->role == 2) {
            //     $categories = Category::all();
            // } elseif ($request->role == 3) {
                $categories = Category::where('package_id', $request->package)->get();
            // }
        }
        if ($request->has('vendor') && $request->vendor != null) 
        {
            $user = Vendor::find($request->vendor);
            $categories = $user->package->category;
        }
        return response()->json($categories);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());

        return redirect()->back()
            ->with('success', 'User registered successfully.');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:11'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'numeric', Rule::in([1, 2, 3])],
            'package_id' => 'required_without_all:vendor_id|nullable|numeric',
            'vendor_id' => 'required_without_all:package_id|nullable|numeric',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'zipcode' => $data['zipcode'],
            'role_id' => $data['role_id'],
        ]);

        if ($data['role_id'] == 2) {
            Vendor::create([
                'user_id' => $user->id,
                'package_id' => $data['package_id'],
                'status' => 1,
            ]);
        }

        if ($data['role_id'] == 3) {
            SubVendor::create([
                'user_id' => $user->id,
                'vendor_id' => $data['vendor_id'],
                'status' => 1,
            ]);
        }

        return $user;
    }
}
