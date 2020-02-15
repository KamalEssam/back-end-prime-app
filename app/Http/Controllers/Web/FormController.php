<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;

class FormController extends WebController
{

    public function load($form)
    {
        return view('admin.forms.' . $form);
    }

}
