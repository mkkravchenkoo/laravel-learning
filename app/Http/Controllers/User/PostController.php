<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $post = (object)[
            'id' => '123',
            'title' => 'lorem',
            'content' => 'Lorem <strong>ipsum</strong> dolor sit amet, consectetur adipisicing elit. Perferendis, provident?'
        ];

        $posts = array_fill(0, 10, $post);
        $posts = collect($posts);


        return view('user.posts.index', ['posts' => $posts]);
    }
    public function create(){
        return view('user.posts.create');
    }
    public function store(Request $request){
       $title = $request->input('title');
       $content = $request->input('content');

        dump($title, $content);

        return 'request - save post';
    }
    public function show($post){
        $post = (object)[
            'id' => '123',
            'title' => 'lorem',
            'content' => 'Lorem <strong>ipsum</strong> dolor sit amet, consectetur adipisicing elit. Perferendis, provident?'
        ];
        return view('user.posts.show', ['post' => $post]);
    }
    public function edit($post){
        $post = (object)[
            'id' => '123',
            'title' => 'lorem',
            'published' => true,
            'content' => 'Lorem <strong>ipsum</strong> dolor sit amet, consectetur adipisicing elit. Perferendis, provident?'
        ];

        return view('user.posts.edit', ['post' => $post]);
    }
    public function update(Request $request){

        $title = $request->input('title');
        $content = $request->input('content');
        dump($title, $content);
        return 'request - edit post';
    }
    public function delete(){
        return 'request - delete post';
    }
    public function like(){
        return 'request - like';
    }
}
