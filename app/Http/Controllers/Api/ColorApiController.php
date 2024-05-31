<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;

class ColorApiController extends Controller
{
    public function index()
    {
        $colors = Color::with('model')->get();
        return response()->json($colors);
    }

    public function show($id)
    {
        $color = Color::with('model')->findOrFail($id);
        return response()->json($color);
    }
}
