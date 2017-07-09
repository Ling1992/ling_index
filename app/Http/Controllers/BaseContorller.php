<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->assign();
    }
}