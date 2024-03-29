<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return view('admin.manufacturers.index', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjusted validation for image upload
        ]);

        if ($request->hasFile('icon')) {
            $img = $request->icon;
            $number = rand(1, 999);
            $numb = $number / 7;
            $extension = $img->extension();
            $filenamenew = date('Y-m-d') . "_." . $numb . "_." . $extension;
            $filenamepath = 'manufacturer_icons' . '/' . 'img/' . $filenamenew;
            $filename = $img->move(public_path('storage/manufacturer_icons' . '/' . 'img'), $filenamenew);
            $iconPath = $filenamepath;
        }

        $manufacturer = Manufacturer::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        if ($manufacturer) {
            $manufacturers = Manufacturer::all();
            $view = view('admin.manufacturers.table', compact('manufacturers'))->render();
            return response()->json(['message' => 'Manufacturer created successfully', 'table_html' => $view], 200);
        } else {
            return response()->json(['error' => 'Failed to create manufacturer'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $manufacturer = Manufacturer::findOrFail($id);
            return response()->json(['manufacturer' => $manufacturer], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch manufacturer details for editing: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        // dd($request->toArray());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjusted validation for image upload
        ]);

        try {
            if ($request->hasFile('icon')) {
                $img = $request->icon;
                $number = rand(1, 999);
                $numb = $number / 7;
                $extension = $img->extension();
                $filenamenew = date('Y-m-d') . "_." . $numb . "_." . $extension;
                $filenamepath = 'manufacturer_icons' . '/' . 'img/' . $filenamenew;
                $filename = $img->move(public_path('storage/manufacturer_icons' . '/' . 'img'), $filenamenew);
                $iconPath = $filenamepath;
                // dd('ok');
            }
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'icon' => $iconPath,
            ];

            $manufacturer->update($data);

            if ($manufacturer->wasChanged()) {
                $manufacturers = Manufacturer::all();
                $view = view('admin.manufacturers.table', compact('manufacturers'))->render();
                return back()->with(['message' => 'Manufacturer updated successfully', 'manufacturers' => $view], 200);
                // return response()->json(['message' => 'Manufacturer updated successfully', 'manufacturers' => $view], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the manufacturer'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update manufacturer: ' . $e->getMessage()], 500);
        }
    }
    public function destroy(Manufacturer $manufacturer)
    {
        try {
            // Delete the manufacturer's icon file before deleting the manufacturer
            if ($manufacturer->icon) {
                \Storage::delete($manufacturer->icon);
            }
            $manufacturer->delete();
            $manufacturers = Manufacturer::all();
            $view = view('admin.manufacturers.table', compact('manufacturers'))->render();
            return response()->json(['message' => 'Manufacturer deleted successfully', 'manufacturers' => $view], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete manufacturer: ' . $e->getMessage()], 500);
        }
    }
}
