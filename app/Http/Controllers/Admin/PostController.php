<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(){
        return 'page - list';
    }
    public function create(){
        return 'page - create new post';
    }
    public function store(){
        return 'request - save post';
    }
    public function show($post){
        return "page - show post {$post}";
    }
    public function edit(){
        return 'page - edit post';
    }
    public function update(){
        return 'request - edit post';
    }
    public function delete(){
        return 'request - delete post';
    }
    public function like(){
        return 'request - like';
    }
}
