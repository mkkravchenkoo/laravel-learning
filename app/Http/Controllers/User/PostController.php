<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index(){
        $posts = Post::query()->orderBy('published_at', 'desc')->paginate(12, ['id', 'title','published_at']);
        return view('user.posts.index', ['posts' => $posts]);
    }
    public function create(){
        return view('user.posts.create');
    }
    public function store(StorePostRequest $request){
       $validated = validator($request->all(), [
           'title' => ['required', 'string', 'max:100'],
           'content' => ['required', 'string'],
           'published_at' => ['nullable', 'string', 'date'],
           'published' => ['nullable', 'boolean'],
       ])->validate();

        $post = Post::query()->firstOrCreate([
            'user_id' => User::query()->value('id'),
            'title' => $validated['title'],
        ],[
            'content' => $validated['content'],
            'published_at' => new Carbon($validated['published_at'] ?? null),
            'published' => $validated['published'] ?? false
        ]);
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
