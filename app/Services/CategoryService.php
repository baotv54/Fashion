<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Lấy tất cả danh mục (bao gồm danh mục con nếu có)
     */
    public function getAllCategories()
    {
        return Category::whereNull('parent_id')->with('children')->get();
    }

    /**
     * Lấy danh mục theo ID
     */
    public function getCategoryById($id)
    {
        return Category::find($id);
    }

    /**
     * Tạo mới danh mục
     */
    public function createCategory(array $data)
    {
        // Tạo slug từ name và kiểm tra trùng lặp
        $slug = Str::slug($data['name']);
        $count = Category::where('slug', $slug)->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1); // Thêm số nếu slug đã tồn tại
        }

        $data['slug'] = $slug;

        return Category::create($data);
    }

    /**
     * Cập nhật danh mục
     */
    public function updateCategory($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'parent_id' => $data['parent_id'] ?? null,
            'status' => $data['status'] ?? 1
        ]);
        return $category;
    }

    /**
     * Xóa danh mục
     */
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }
}
