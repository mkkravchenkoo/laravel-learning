<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){
        return view('register.index');
    }
    public function store(Request $request){
       $name = $request->input('name');
       $email = $request->input('email');
       $password = $request->input('password');
       $agreement = $request->boolean('agreement');

//        dump($request->all());
//        dump($request->only(['name']));
//        dump($request->except(['_token']));
//        dump($request->input('email'));
//        dump($request->boolean('agreement'));
//        dump($request->email);
//        dump($request->file('avatar'));
//
//        dump($request->has('name'));
//        dump($request->filled('name'));
//        dump($request->missing('first_name'));

    }
}
