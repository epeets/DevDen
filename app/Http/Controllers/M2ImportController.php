<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class M2ImportController extends Controller
{
    //
    public function import()
    {
        return view ('auth.tools.import.m2');
    }
    public function store()
    {
        //Code for importing products
    }
}
