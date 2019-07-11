<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Post;
use App\Category;
use App\Tag;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    { 
        // Upload image to storage
        $image = $request->image->store('posts');

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,
            'category_id' => $request->category
        ]);

        // Attach tags to post if any were selected
        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        session()->flash('success', 'Post created successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create', 
        [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only(['title', 'description', 'content', 'published_at', 'category']);

        if($request->hasFile('image')){
            // Store new image
            $image = $request->image->store('posts');
            // Delete old image
            $post->deleteImage();
            // Add new image to array of values with which post will be updated
            $data['image'] = $image;
        }

        if($request->tags){
            // Use sync function so that there aren't any posts linked to tags that don't exist
            $post->tags()->sync($request->tags);
        }

        $post->update($data);

        session()->flash('success', 'Post updated successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();

        // Completely remove image from database and storage
        if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }
        // Only trash the image
        else{
            $post->delete();
        }
        
        session()->flash('success', 'Post trashed successfully.');

        return redirect(route('posts.index'));
    }

    public function trashed()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')->withPosts($trashed);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->where('id', $id)->firstOrFail();
        $post->restore();

        session()->flash('success', 'Post restored successfully.');

        return redirect()->back();
    }
}
