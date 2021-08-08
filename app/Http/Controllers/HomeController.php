<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //
    public function index(){
        return view('components.layout');
    }


}
