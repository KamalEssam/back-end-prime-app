<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;

class AdminController extends WebController
{
    public function index()
    {
        return view('admin.index');
    }

}
