<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục bài viết
     */
    public function index()
    {
        $postCategories = PostCategory::all();
        return view('admin.postcategories.index', compact('postCategories'));
    }

    /**
     * Hiển thị form thêm danh mục bài viết
     */
    public function create()
    {
        return view('admin.postcategories.create');
    }

    /**
     * Lưu danh mục bài viết mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        // Tạo slug từ tên và đảm bảo không trùng
        $slug = Str::slug($data['name']);
        $count = PostCategory::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        PostCategory::create($data);

        return redirect()->route('post-categories.index')->with('success', 'Danh mục bài viết đã được thêm!');
    }

    /**
     * Hiển thị form sửa danh mục bài viết
     */
    public function edit($id)
    {
        $category = PostCategory::findOrFail($id); // đổi tên biến thành $category
        return view('admin.postcategories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục bài viết
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $postCategory = PostCategory::findOrFail($id);

        $slug = Str::slug($data['name']);
        $count = PostCategory::where('slug', $slug)->where('id', '!=', $id)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $postCategory->update([
            'name' => $data['name'],
            'slug' => $slug,
            'status' => $data['status'] ?? $postCategory->status,
        ]);

        return redirect()->route('post-categories.index')->with('success', 'Danh mục bài viết đã được cập nhật!');
    }

    /**
     * Xóa danh mục bài viết
     */
    public function destroy($id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $postCategory->delete();

        return redirect()->route('post-categories.index')->with('success', 'Danh mục bài viết đã được xóa!');
    }
}
