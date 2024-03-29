<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('dashboard.admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('dashboard.admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Package::create($data);

        return redirect()->route('packages.index');
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        return view('dashboard.admin.packages.show', compact('package'));
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('dashboard.admin.packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->update($request->all());
        return redirect()->route('packages.index');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect()->route('packages.index');
    }
}
