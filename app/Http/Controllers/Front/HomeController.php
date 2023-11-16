<?php

namespace App\Http\Controllers\Front;


use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Action
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return Redirect::to('login');
    }


}
