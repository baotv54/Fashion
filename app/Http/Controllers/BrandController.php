<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Hiển thị danh sách thương hiệu
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Hiển thị form thêm hoặc sửa thương hiệu
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Lưu thương hiệu mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'status' => 'required|boolean',
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa thương hiệu
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Cập nhật thương hiệu
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
            'status' => 'required|boolean',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được cập nhật!');
    }

    /**
     * Xóa thương hiệu
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã bị xóa thành công.');
    }
}
