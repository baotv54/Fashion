<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị form thêm danh mục
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get(); // Lấy danh mục cha
        return view('categories.create', compact('categories'));
    }

    /**
     * Lưu danh mục mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'boolean'
        ]);

        $this->categoryService->createCategory($data);
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được tạo!');
    }

    /**
     * Hiển thị form sửa danh mục
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get(); // Không cho chọn chính nó làm cha
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Cập nhật danh mục
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'boolean'
        ]);

        $this->categoryService->updateCategory($category->id, $data);
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }
}
