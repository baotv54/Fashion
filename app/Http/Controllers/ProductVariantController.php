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
        $variants = $product->variants()->with('attributeValues')->get();
        return view('admin.product_variants.index', compact('product', 'variants'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        $attributes = Attribute::with('values')->get();
        return view('admin.product_variants.create', compact('product', 'attributes'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'price' => 'required|numeric',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'attribute_values' => 'required|array|min:1'
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục public/variants/
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'variants/' . $imageName;
            $request->file('image')->move(public_path('variants'), $imageName);
        }
    
        $variant = ProductVariant::create([
            'product_id' => $productId,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath, // Đường dẫn ảnh lưu trực tiếp vào public/variants/
        ]);
    
        foreach ($request->attribute_values as $valueId) {
            VariantAttributeValue::create([
                'variant_id' => $variant->id,
                'attribute_value_id' => $valueId,
            ]);
        }
    
        return redirect()->route('product_variants.index', $productId)->with('success', 'Tạo biến thể thành công');
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
    
    
    public function destroy($productId, $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
    
        if ($variant->image) {
            // Xóa ảnh khỏi thư mục public/variants/
            $imagePath = public_path($variant->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        $variant->attributeValues()->delete();
        $variant->delete();
    
        return back()->with('success', 'Xóa biến thể thành công');
    }
    
    
}
