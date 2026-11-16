<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::withCount('reports')->orderBy('building')->get();

        return view('locations.index', compact('locations'));
    }
}
