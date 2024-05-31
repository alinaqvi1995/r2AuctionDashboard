<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capacity;

class CapacityApiController extends Controller
{
    public function index()
    {
        $capacities = Capacity::with('brand')->get();
        return response()->json($capacities);
    }

    public function show($id)
    {
        $capacity = Capacity::with('brand')->findOrFail($id);
        return response()->json($capacity);
    }
}
