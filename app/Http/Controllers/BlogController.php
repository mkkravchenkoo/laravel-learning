<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function index(Request $request)
    {

        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:50'],
            'from_date' => ['nullable', 'string', 'date'],
            'to_date' => ['nullable', 'string', 'date', 'after:from_date'],
//            'tag' => ['nullable', 'string', 'max:10'],
        ]);

        $query = Post::query();

        if($search = $validated['search']){
            $query->where('title', 'like', "%{$search}%");
        }

        if($fromDate = $validated['from_date']){
            $query->where('published_at', '>=',  new Carbon($fromDate));
        }

        if($toDate = $validated['to_date']){
            $query->where('published_at', '<=',  new Carbon($toDate));
        }

        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(12, ['id', 'title','published_at']);
        return view('blog.index', ['posts' => $posts]);
    }

    public function show(Request $request, Post $post)
    {
        return view('blog.show', ['post' => $post]);
    }

    public function like()
    {
        return 'v';
    }
}
