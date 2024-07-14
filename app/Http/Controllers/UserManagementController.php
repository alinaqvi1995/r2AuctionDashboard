<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::get();
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

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
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
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->full_name = $request->input('name') . ' ' . $request->input('middle_name') . ' ' . $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->address = $request->input('address');
        $user->business_name = $request->input('business_name');
        $user->business_email = $request->input('business_email');
        $user->designation = $request->input('designation');
        $user->business_website = $request->input('business_website');
        $user->business_desc = $request->input('business_desc');
        $user->status = $request->input('status');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
