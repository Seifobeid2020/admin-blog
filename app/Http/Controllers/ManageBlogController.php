<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class ManageBlogController extends Controller
{

    public function index()
    {

        return  view("manageblogs.index");
    }

}
