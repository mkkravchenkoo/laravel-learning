<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category_id');

        $posts = Post::query()->orderBy('published_at', 'desc')->paginate(12, ['id', 'title','published_at']);
        return view('blog.index', ['posts' => $posts]);
    }

    public function show()
    {

        $post = (object)[
            'id' => '123',
            'title' => 'lorem',
            'content' => 'Lorem <strong>ipsum</strong> dolor sit amet, consectetur adipisicing elit. Perferendis, provident?'
        ];

        return view('blog.show', ['post' => $post]);
    }

    public function like()
    {
        return 'v';
    }
}
