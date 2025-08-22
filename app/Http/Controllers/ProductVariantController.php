<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\VariantAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $variants = $product->variants()->with('attributeValues')->paginate(5);
        return view('admin.product_variants.index', compact('product', 'variants'));
    }

    // public function create($productId)
    // {
    //     $product = Product::findOrFail($productId);
    //     $attributes = Attribute::with('values')->get();
    //     return view('admin.product_variants.create', compact('product', 'attributes', 'attribute_values'));
    // }
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        $attributes = Attribute::all();
        $attribute_values = AttributeValue::all();

        return view('admin.product_variants.create', compact('product', 'attributes', 'attribute_values'));
    }

    // public function store(Request $request, $productId)
    // {
    //     $request->validate([
    //         'price' => 'required|numeric',
    //         'stock' => 'required|numeric|min:0',
    //         'image' => 'nullable|image',
    //         'attribute_values' => 'required|array|min:1'
    //     ]);

    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         // Lưu ảnh vào thư mục public/variants/
    //         $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
    //         $imagePath = 'variants/' . $imageName;
    //         $request->file('image')->move(public_path('variants'), $imageName);
    //     }

    //     $variant = ProductVariant::create([
    //         'product_id' => $productId,
    //         'price' => $request->price,
    //         'stock' => $request->stock,
    //         'image' => $imagePath, // Đường dẫn ảnh lưu trực tiếp vào public/variants/
    //     ]);

    //     foreach ($request->attribute_values as $valueId) {
    //         VariantAttributeValue::create([
    //             'variant_id' => $variant->id,
    //             'attribute_value_id' => $valueId,
    //         ]);
    //     }

    //     return redirect()->route('product_variants.index', $productId)->with('success', 'Tạo biến thể thành công');
    // }

    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $variants = $request->input('variants', []);
        if (empty($variants)) {
            return back()->withErrors(['error' => 'Chưa có biến thể nào được tạo.']);
        }

        foreach ($variants as $index => $variantData) {
            // Kiểm tra dữ liệu cần thiết
            if (!isset($variantData['value_ids'], $variantData['price'], $variantData['stock'])) {
                continue;
            }

            // Xử lý ảnh nếu có
            $imagePath = null;
            $imageInputName = "variants.$index.image";

            if ($request->hasFile($imageInputName)) {
                $file = $request->file($imageInputName);
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = 'variants/' . $imageName;
                $file->move(public_path('variants'), $imageName);
            }

            // Tạo biến thể
            $variant = ProductVariant::create([
                'product_id' => $productId,
                'price' => $variantData['price'],
                'stock' => $variantData['stock'],
                'image' => $imagePath,
            ]);

            // Gán các giá trị thuộc tính
            $valueIds = explode('-', $variantData['value_ids']);
            foreach ($valueIds as $valueId) {
                VariantAttributeValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Tạo biến thể thành công.');
    }



    public function edit($productId, $variantId)
    {
        $variant = ProductVariant::with('attributeValues')->findOrFail($variantId);
        $attributes = Attribute::with('values')->get();
        return view('admin.product_variants.edit', compact('variant', 'attributes', 'productId'));
    }

    public function update(Request $request, $productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        $request->validate([
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'attribute_values' => 'required|array|min:1'
        ]);
        if ($request->hasFile('image')) {
            if ($variant->image) {
                // Xóa ảnh cũ khỏi thư mục public/variants/
                $oldImagePath = public_path($variant->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Lưu ảnh mới vào thư mục public/variants/
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'variants/' . $imageName;
            $request->file('image')->move(public_path('variants'), $imageName);
            $variant->image = $imagePath;
        }
        $variant->update([
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $variant->image,
        ]);

        $variant->attributeValues()->delete();

        foreach ($request->attribute_values as $valueId) {
            VariantAttributeValue::create([
                'variant_id' => $variant->id,
                'attribute_value_id' => $valueId,
            ]);
        }

        return redirect()->route('product_variants.index', $productId)->with('success', 'Cập nhật biến thể thành công');
    }


    // public function destroy($productId, $variantId)
    // {
    //     $variant = ProductVariant::findOrFail($variantId);

    //     if ($variant->image) {
    //         // Xóa ảnh khỏi thư mục public/variants/
    //         $imagePath = public_path($variant->image);
    //         if (file_exists($imagePath)) {
    //             unlink($imagePath);
    //         }
    //     }

    //     $variant->attributeValues()->delete();
    //     $variant->delete();

    //     return back()->with('success', 'Xóa biến thể thành công');
    // }
    public function destroy($productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);

        // Kiểm tra tồn kho
        if ($variant->stock > 0) {
            return back()->with('error', 'Không thể xóa biến thể vì còn hàng trong kho!');
        }

        // Xóa mềm (soft delete)
        $variant->delete();

        return back()->with('success', 'Xóa biến thể thành công');
    }

    public function restore($productId, $variantId)
    {
        $variant = ProductVariant::withTrashed()->findOrFail($variantId);

        if ($variant->trashed()) {
            $variant->restore();
            return back()->with('success', 'Khôi phục biến thể thành công');
        }

        return back()->with('info', 'Biến thể này chưa bị xóa');
    }

    public function forceDelete($productId, $variantId)
    {
        $variant = ProductVariant::withTrashed()->findOrFail($variantId);

        if ($variant->trashed()) {
            // Xóa ảnh nếu có
            if ($variant->image) {
                $imagePath = public_path($variant->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $variant->forceDelete();
            return back()->with('success', 'Xóa vĩnh viễn biến thể thành công');
        }

        return back()->with('info', 'Biến thể chưa bị xóa mềm, không thể xóa cứng');
    }
}
