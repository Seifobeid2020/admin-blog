<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255',

        ]);

        $attributes['role'] = 'user';
        $attributes['status'] = 'active';


        User::create($attributes);

        return redirect('/')->with('success', 'Your account has been created.');
    }
}
