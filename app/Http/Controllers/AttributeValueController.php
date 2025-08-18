<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeValueController extends Controller
{
    public function index($attributeId)
    {
        // Lấy thuộc tính theo attributeId
        $attribute = Attribute::findOrFail($attributeId);

        // Lấy tất cả giá trị thuộc tính của thuộc tính này
        $attributeValues = $attribute->values;

        // Trả về view admin.attribute_values.index và truyền biến $attribute và $attributeValues
        return view('admin.attribute_values.index', compact('attribute', 'attributeValues'));
    }


    public function create($attributeId)
    {
        // Lấy thuộc tính cần tạo giá trị
        $attribute = Attribute::findOrFail($attributeId);
    
        // Trả về view admin.attribute_values.create và truyền biến $attribute
        return view('admin.attribute_values.create', compact('attribute'));
    }
    

    public function store(Request $request, $attributeId)
    {
        // Xử lý form tạo mới giá trị thuộc tính
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($attributeId);
        $attribute->values()->create([
            'value' => $request->input('value'),
        ]);

        return redirect()->route('attribute_values.index', $attributeId)->with('success', 'Giá trị thuộc tính đã được tạo thành công!');
    }

    public function edit($attributeId, $id)
    {
        // Lấy thuộc tính cần sửa giá trị
        $attribute = Attribute::findOrFail($attributeId);
    
        // Lấy giá trị thuộc tính cần sửa
        $attributeValue = AttributeValue::findOrFail($id);
    
        // Trả về view admin.attribute_values.edit và truyền biến $attribute và $attributeValue
        return view('admin.attribute_values.edit', compact('attribute', 'attributeValue'));
    }
    

    public function update(Request $request, $attributeId, $id)
    {
        // Xử lý form cập nhật giá trị thuộc tính
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($attributeId);
        $attributeValue = AttributeValue::findOrFail($id);

        $attributeValue->update([
            'value' => $request->input('value'),
        ]);

        return redirect()->route('attribute_values.index', $attributeId)->with('success', 'Giá trị thuộc tính đã được cập nhật!');
    }

    public function destroy($attributeId, $id)
    {
        // Xóa giá trị thuộc tính
        $attributeValue = AttributeValue::findOrFail($id);
        $attributeValue->delete();

        return redirect()->route('attribute_values.index', $attributeId)->with('success', 'Giá trị thuộc tính đã được xóa!');
    }
}
