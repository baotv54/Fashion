<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif',
            'status' => 'required|boolean',
        ]);

        // Lưu hình ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/brands'), $imageName);
            $imagePath = 'uploads/brands/' . $imageName;
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được tạo thành công!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.create', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'status' => 'required|boolean',
        ]);

        $brand = Brand::findOrFail($id);

        // Xử lý ảnh nếu có upload mới
        $imagePath = $brand->image;
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($brand->image && File::exists(public_path($brand->image))) {
                File::delete(public_path($brand->image));
            }

            $imageName = time() . '_' . Str::slug($request->name) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/brands'), $imageName);
            $imagePath = 'uploads/brands/' . $imageName;
        }

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được cập nhật!');
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }

        // Xóa ảnh
        if ($brand->image && File::exists(public_path($brand->image))) {
            File::delete(public_path($brand->image));
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã bị xóa thành công.');
    }
}
