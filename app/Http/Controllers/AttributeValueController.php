<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Models\VariantAttributeValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'value' => [
                'required',
                'max:255',
                Rule::unique('attribute_values')->where(function ($query) use ($request, $attributeId) {
                    return $query->where('attribute_id', $attributeId)
                        ->whereRaw('LOWER(value) = ?', [strtolower($request->value)]);
                }),
            ],
        ], [
            'value.unique' => 'Giá trị thuộc tính đã tồn tại!',
        ]);

        $attribute = Attribute::findOrFail($attributeId);
        $attribute->values()->create([
            'value' => $request->input('value'),
        ]);

        return redirect()->route('attribute_values.index', $attributeId)
            ->with('success', 'Giá trị thuộc tính đã được tạo thành công!');
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
        $request->validate([
            'value' => [
                'required',
                'max:255',
                Rule::unique('attribute_values')->ignore($id)->where(function ($query) use ($request, $attributeId) {
                    return $query->where('attribute_id', $attributeId)
                        ->whereRaw('LOWER(value) = ?', [strtolower($request->value)]);
                }),
            ],
        ], [
            'value.unique' => 'Giá trị thuộc tính đã tồn tại!',
        ]);

        $attribute = Attribute::findOrFail($attributeId);
        $attributeValue = AttributeValue::findOrFail($id);

        $attributeValue->update([
            'value' => $request->input('value'),
        ]);

        return redirect()->route('attribute_values.index', $attributeId)
            ->with('success', 'Giá trị thuộc tính đã được cập nhật!');
    }

    public function destroy($attributeId, $id)
    {
        // Tìm giá trị thuộc tính
        $attributeValue = AttributeValue::findOrFail($id);

        // Kiểm tra xem có VariantAttributeValue nào đang sử dụng attribute_value_id này không
        $isUsed = VariantAttributeValue::where('attribute_value_id', $id)->exists();

        if ($isUsed) {
            return redirect()->route('attribute_values.index', $attributeId)
                ->with('error', 'Không thể xóa vì giá trị thuộc tính này đang được sử dụng trong biến thể sản phẩm.');
        }

        // Nếu không bị ràng buộc thì xóa
        $attributeValue->delete();

        return redirect()->route('attribute_values.index', $attributeId)
            ->with('success', 'Giá trị thuộc tính đã được xóa!');
    }
}
