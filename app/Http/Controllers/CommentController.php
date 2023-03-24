<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'post_id' => 'required|numeric|exists:posts,id',
            'image' => 'image|mimes:jfif,jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
        ]);

        if ($request->img){
            $fileName = time().$request->file('img')->getClientOriginalName();
            $image_path = $request->file('img')->storeAs('comments', $fileName, 'public');
            $validated['img'] = '/storage/'.$image_path;
        }
        else{
            $validated['img'] = 'noimg';
        }

        Auth::user()->comments()->create($validated);

        return back()->with('message', 'Comment save successfully!');
   }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'comment' => 'required',
            'img' => 'image|mimes:jfif,jpg,png,jpeg,gif,svg|max:2048'
        ]);

        if ($request->img == null){
            $validated['img'] = $comment->img;
        }
        else{
            $fileName = time().$request->file('img')->getClientOriginalName();
            $image_path = $request->file('img')->storeAs('comments', $fileName, 'public');
            $validated['img'] = '/storage/'.$image_path;
        }

        $comment->update($validated);
        return back()->with('message', 'Comment changed successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('message', 'Comment deleted successfully!');
    }
}
