<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::paginate(5); 
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attributes.index');  // Hiển thị form tạo mới
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('attributes')->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(name) = ?', [strtolower($request->name)]);
                }),
            ],
        ], [
            'name.unique' => 'Thuộc tính đã tồn tại!',
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
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('attributes')->ignore($id)->where(function ($query) use ($request) {
                    return $query->whereRaw('LOWER(name) = ?', [strtolower($request->name)]);
                }),
            ],
        ], [
            'name.unique' => 'Thuộc tính đã tồn tại!',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();

        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được cập nhật!');
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        // Kiểm tra xem có AttributeValue nào đang dùng attribute_id này không
        $hasValues = AttributeValue::where('attribute_id', $id)->exists();

        if ($hasValues) {
            return redirect()->route('attributes.index')
                ->with('error', 'Không thể xóa thuộc tính vì đang có giá trị thuộc tính liên kết.');
        }

        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Thuộc tính đã được xóa!');
    }
}
