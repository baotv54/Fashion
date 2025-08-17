<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('children')->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form thêm danh mục
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get(); // Lấy danh mục cha
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'boolean',
        ]);

        // Tạo slug từ tên danh mục và đảm bảo không trùng
        $slug = Str::slug($data['name']);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        $data['slug'] = $slug;

        // Tạo danh mục
        Category::create($data);

        if ($data['parent_id']) {
            return redirect()->route('categories.edit', $data['parent_id'])->with('success', 'Danh mục con đã được thêm!');
        }

        return redirect()->route('categories.index')->with('success', 'Danh mục cha đã được thêm!');
    }

    /**
     * Hiển thị form sửa danh mục
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Cập nhật danh mục
     */
public function update(Request $request, $id)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'nullable|boolean',
    ]);

    $category = Category::findOrFail($id);

    $slug = Str::slug($data['name']);
    $count = Category::where('slug', $slug)->where('id', '!=', $id)->count();
    if ($count > 0) {
        $slug .= '-' . ($count + 1);
    }

    $category->update([
        'name' => $data['name'],
        'slug' => $slug,
        'status' => $data['status'] ?? $category->status,
    ]);

    if (is_null($category->parent_id)) {
        return redirect()->route('categories.edit', $category->id)->with('success', 'Danh mục cha đã được cập nhật!');
    }

    return redirect()->route('categories.edit', $category->parent_id)->with('success', 'Danh mục con đã được cập nhật!');
}


    /**
     * Xóa danh mục
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $parentId = $category->parent_id;
        $category->delete();

        if ($parentId) {
            return redirect()->route('categories.edit', $parentId)->with('success', 'Danh mục con đã được xóa!');
        }

        return redirect()->route('categories.index')->with('success', 'Danh mục cha đã được xóa!');
    }
}
