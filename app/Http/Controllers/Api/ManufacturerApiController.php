<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerApiController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return response()->json($manufacturers);
    }

    public function show(Manufacturer $manufacturer)
    {
        return response()->json($manufacturer);
    }
}
