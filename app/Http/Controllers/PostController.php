<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $allPosts = Post::with('user')->get();
        return view('posts.index', ['posts' => $allPosts]);
    }

    public function create()
    {
        return view('posts.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'img' => 'required|image|mimes:jfif,jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
        ]);
        $fileName = time().$request->file('img')->getClientOriginalName();
        $image_path = $request->file('img')->storeAs('posts', $fileName, 'public');
        $validated['img'] = '/storage/'.$image_path;

        Auth::user()->posts()->create($validated);
        return redirect()->route('posts.index')->with('message', 'Post save successfully!');
    }


    public function show(Post $post)
    {
        $post->load('comments.user');
        return view('posts.show', ['post' => $post]);
    }


    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }


    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'img' => 'image|mimes:jfif,jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
        ]);

        if ($request->img){
            $fileName = time().$request->file('img')->getClientOriginalName();
            $image_path = $request->file('img')->storeAs('posts', $fileName, 'public');
            $validated['img'] = '/storage/'.$image_path;
        }
        else{
            $validated['img'] = $post->img;
        }

        $post->update($validated);
        return redirect()->route('posts.index')->with('message', 'Post updated successfully!');
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
