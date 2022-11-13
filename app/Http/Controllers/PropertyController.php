<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Property;


class PropertyController extends Controller
{
    public function getAll()
    {
        $properties = Property::all();
        return response()->json($properties);
    }
}