<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    public function store(StorePostRequest $request){
       $validated = validator($request->all(), [
           'title' => ['required', 'string', 'max:100'],
           'content' => ['required', 'string'],
       ])->validate();
//       $validated = $request->validated(); // our values

//        throw ValidationException::withMessages([
//            'custom_field' => 'Custom message'
//        ]);

       alert(__('Created!'));
       return redirect()->route('user.posts.show', 123);
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
    public function update(Request $request, $post){

        $validated = validator($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string'],
        ])->validate();

        alert(__('Updated'));
        return redirect()->back();
    }
    public function delete(){
        return redirect()->route('user.posts');
    }
    public function like(){
        return 'request - like';
    }
}
