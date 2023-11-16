<?php

namespace App\Http\Controllers\Front;

class ControlOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        parent::__construct();
    }

    public function index()
    {
        return view('front.order-control.index');
    }
}
