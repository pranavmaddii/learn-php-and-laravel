<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::active()->with('user')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use($search){
                        $q->where('username', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.index', compact('posts'));
    }


    public function show($id)
    {
        // // Get post with author username
        // $post = DB::table('posts')
        //     ->join('users', 'posts.user_id', '=', 'users.id')
        //     ->select('posts.*', 'users.username')
        //     ->where('posts.id', $id)
        //     ->first();

        // // Get comments with commenter usernames
        // $comments = DB::table('comments')
        //     ->join('users', 'comments.user_id', '=', 'users.id')
        //     ->select('comments.*', 'users.username')
        //     ->where('comments.post_id', $id)
        //     ->orderBy('comments.created_at', 'desc')
        //     ->get();

        // NEW WAY - Using Eloquent relationships:
        $post = Post::with('user')->findOrFail($id);
        $comments = $post->comments()->with('user')->orderBy('created_at', 'desc')->paginate(5);
        return view('posts.show', compact('post', 'comments'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'body'  => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB
        ]);

        // Handle image upload
        $imagePath = null;
        if($request->hasFile('image')){
            $imagePath = $request -> file('image') -> store('posts', 'public');
        }

        Post::create([
            'title'   => $validated['title'],
            'body'    => $validated['body'],
            'image' => $imagePath,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/')
            ->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'body'  => 'required|string|max:2000',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        return redirect('/posts/' . $post->id)
            ->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['status'=> 'inactive']);

        return redirect('/')
            ->with('success', 'Post moved to trash');
    }

    public function deleted(){
        $posts = Post::inactive()
            ->where('user_id', Auth::id())
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
        return view('posts.deleted', compact('posts'));
    }

    public function restore($id){
        $post = Post::inactive()->where('user_id', Auth::id())->findOrFail($id);
        $post->update(['status'=> 'active']);

        return redirect()->route('posts.deleted')->with('success', 'Post restored successfully');
    }

    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        // Check if user already liked the post
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            // Already liked -> remove the like (unlike)
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            // Not liked yet -> add the like
            $post->likes()->attach($user->id);
            $liked = true;
        }

        // Return JSON for AJAX
        return response()->json([
            'liked' => $liked,
            'count' => $post->likes()->count()
        ]);
    }

    public function myPosts(){
        $posts = Post::active()
            ->where('user_id', Auth::id())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.mine', compact('posts'));
    }
}
