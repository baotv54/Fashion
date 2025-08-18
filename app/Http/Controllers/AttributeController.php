<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();  // Lấy tất cả các thuộc tính
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.create');  // Hiển thị form tạo mới
    }

    public function store(Request $request)
    {
        // Xử lý lưu thuộc tính mới
        $request->validate([
            'name' => 'required|unique:attributes,name|max:255',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được tạo thành công!');
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);  // Tìm thuộc tính theo ID
        return view('admin.attributes.edit', compact('attribute'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật thuộc tính
        $request->validate([
            'name' => 'required|max:255|unique:attributes,name,' . $id,
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được cập nhật!');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được xóa!');
    }
}
