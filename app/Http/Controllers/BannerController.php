<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    // Danh sách banner
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    // Form tạo banner
    public function create()
    {
        return view('admin.banners.create');
    }

    // Lưu banner mới
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:30',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'subtitle' => 'required|max:30',
            'link' => 'required|url',
        ]);

        // Xử lý ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Di chuyển ảnh vào thư mục public/imgBanner
            $image->move(public_path('imgBanner'), $imageName);
            $validatedData['image'] = $imageName;
        }

        // Tạo banner
        Banner::create($validatedData);

        return redirect()->route('banners.index')->with('success', 'Banner đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
          $banners = Banner::findOrFail($id);
        return view('admin.banners.create', compact('banners'));
    }

    // Cập nhật banner
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:30',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'subtitle' => 'required|max:30',
            'link' => 'required|url',
        ]);

        $banners = Banner::findOrFail($id);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            $oldImagePath = public_path('imgBanner/' . $banners->image);
            if ($banners->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Lưu ảnh mới
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('imgBanner'), $imageName);
            $validatedData['image'] = $imageName;
        } else {
            // Giữ nguyên ảnh cũ nếu không có ảnh mới
            $validatedData['image'] = $banners->image;
        }

        // Cập nhật dữ liệu
        $banners->update($validatedData);

        return redirect()->route('banners.index')->with('success', 'Banner đã được cập nhật thành công!');
    }

    // Xóa banner
    public function destroy($id)
    {
        $banners = Banner::findOrFail($id);

        // Xóa ảnh nếu tồn tại
        $imagePath = public_path('imgBanner/' . $banners->image);
        if ($banners->image && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $banners->delete();

        return redirect()->route('banners.index')->with('success', 'Banner đã được xóa thành công!');
    }
}
