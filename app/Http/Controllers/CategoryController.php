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
            'parent_id' => 'nullable|exists:categories,id', // parent_id có thể null hoặc phải tồn tại trong bảng categories
            'status' => 'boolean',
        ]);
    
        // Sử dụng CategoryService để tạo danh mục
        $category = $this->categoryService->createCategory($data);
    
        // Nếu thêm danh mục con, quay lại trang chỉnh sửa danh mục cha
        if ($data['parent_id']) {
            return redirect()->route('categories.edit', $data['parent_id'])->with('success', 'Danh mục con đã được thêm!');
        }
    
        // Nếu thêm danh mục cha, quay về trang index
        return redirect()->route('categories.index')->with('success', 'Danh mục cha đã được thêm!');
    }

    /**
     * Hiển thị form sửa danh mục
     */

    public function edit($id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get(); // Lấy danh mục cha (trừ chính nó)
        return view('categories.edit', compact('category', 'categories'));
    }

    /**
     * Cập nhật danh mục
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);
    
        $category = Category::findOrFail($id);
        $category->update($data);
    
        // Nếu danh mục là danh mục cha, giữ lại trên trang chỉnh sửa danh mục cha
        if (is_null($category->parent_id)) {
            return redirect()->route('categories.edit', $category->id)->with('success', 'Danh mục cha đã được cập nhật!');
        }
    
        // Nếu danh mục là danh mục con, giữ lại trên trang chỉnh sửa danh mục cha
        return redirect()->route('categories.edit', $category->parent_id)->with('success', 'Danh mục con đã được cập nhật!');
    }


    /**
     * Xóa danh mục
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        // Lưu lại parent_id trước khi xóa
        $parentId = $category->parent_id;
    
        $category->delete();
    
        // Nếu xóa danh mục con, quay lại trang chỉnh sửa danh mục cha
        if ($parentId) {
            return redirect()->route('categories.edit', $parentId)->with('success', 'Danh mục con đã được xóa!');
        }
    
        // Nếu xóa danh mục cha, quay về trang index
        return redirect()->route('categories.index')->with('success', 'Danh mục cha đã được xóa!');
    }
}
