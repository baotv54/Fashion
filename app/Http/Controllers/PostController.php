<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function postPage(Request $request)
    {
        $categoryId = $request->query('category_id');

        $query = Post::query();

        if ($categoryId) {
            $query->where('post_category_id', $categoryId);
        }

        $posts = Post::where('is_visible', 1)->orderBy('created_at', 'desc')->paginate(6);
        $newestPosts = Post::latest()->limit(3)->get();
        $categories = PostCategory::where('status', 1)->get();

        return view('Frontend.pages.blogs.posts', compact('posts', 'newestPosts', 'categories', 'categoryId'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $newestPosts = Post::latest()->limit(3)->get();
        $categories = PostCategory::where('status', 1)->get();

        return view('Frontend.pages.post_detail', compact('post', 'newestPosts', 'categories'));
    }

    public function create()
    {
        // Lấy danh sách danh mục hiển thị để chọn
        $categories = PostCategory::where('status', 1)->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'is_visible' => 'required|in:0,1',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['post_category_id', 'title', 'content', 'author', 'is_visible']);

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
        $categories = PostCategory::where('status', 1)->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'is_visible' => 'required|in:0,1',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads/posts', 'public');
            $data['image'] = 'storage/' . $path;
        } else {
            $data['image'] = $post->image; // giữ ảnh cũ nếu không thay đổi
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
