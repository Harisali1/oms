<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;

class IndexController extends Controller
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
