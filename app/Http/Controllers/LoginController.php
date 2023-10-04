<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){

        return view('login.index');
    }

    public function store(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        dump($email, $password, $remember);
    }
}
