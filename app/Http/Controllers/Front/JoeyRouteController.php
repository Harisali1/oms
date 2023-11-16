<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JoeyRoutificJobRoute;
use Illuminate\Http\Request;

class JoeyRouteController extends Controller
{
    public function index()
    {
        $routes = JoeyRoutificJobRoute::with('joey','job','location')->get();
        return view('front.joey.index', compact('routes'));
    }
}
