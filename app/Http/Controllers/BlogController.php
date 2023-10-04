<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category_id');

        $post = (object)[
            'id' => '123',
            'title' => 'lorem',
            'content' => 'Lorem <strong>ipsum</strong> dolor sit amet, consectetur adipisicing elit. Perferendis, provident?'
        ];

        $posts = array_fill(0, 10, $post);
        $posts = collect($posts);
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
