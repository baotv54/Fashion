<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function postpage()
    {
        $posts = Post::where('is_visible', 1)->orderBy('created_at', 'desc')->paginate(6);

        return view('Frontend.pages.blogs.posts', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('Frontend.pages.post_detail', compact('post'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'is_visible' => 'required|in:0,1',
            'author' => 'required|string|max:11',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'author', 'is_visible']);

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/posts'), $fileName);
            $data['image'] = 'uploads/posts/' . $fileName;
        }

        $data['created_at'] = now();

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Đăng bài thành công!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'is_visible' => 'required|in:0,1',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Xử lý hình ảnh nếu có upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads/posts', 'public');
            $data['image'] = 'storage/' . $path;
        }

        // Nếu là update
        $post = Post::findOrFail($id);
        if (!$request->hasFile('image')) {
            $data['image'] = $post->image; // giữ lại hình cũ nếu không chọn hình mới
        }
        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }


    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa!');
    }
}
