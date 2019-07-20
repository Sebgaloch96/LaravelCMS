<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\Tag;

class WelcomeController extends Controller
{
    public function index()
    {
        $searchValue = request()->query('search');

        if($searchValue){
            $posts = Post::where('title', 'LIKE', "%{$searchValue}%")->simplePaginate(2);
        }
        else{
            $posts = Post::simplePaginate(2);
        }

        $data = [
            'categories' => Category::all(),
            'posts' => $posts,
            'tags' => Tag::all()
        ];

        return view('welcome', $data);
    }
}
