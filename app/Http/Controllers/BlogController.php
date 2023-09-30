<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(){
        return 'list';
    }
    public function show(){
        return 'show';
    }
    public function like(){
        return 'v';
    }
}
