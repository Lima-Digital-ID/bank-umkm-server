<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function index()
    {
        return view('activation.index');
    }
}
