<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Coupon;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Models\OrderDetail;
use App\Models\Favorite;
use App\Models\Banner;
use App\Models\VariantAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category', 'brand', 'images')
            ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
            ->paginate(5);
        return view('admin.products.index', compact('products', 'search'));
    }

    public function homepage()
    {
        $products = Product::latest()->take(8)->get();
        $carts = Cart::content();
        $coupons = Coupon::latest()->take(4)->get();
        $banners = Banner::latest()->take(4)->get();
        $favorites = collect(); // luôn khởi tạo rỗng

        if (Auth::check()) {
            $favorites = Favorite::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }
        return view('Frontend.index', compact('products', 'carts', 'coupons', 'favorites','banners'));

    }

    public function aboutPage()
    {
        $products = Product::latest()->take(8)->get();
        return view('Frontend.pages.gioi-thieu', compact('products'));
    }

    public function allProducts(Request $request)
    {
        $query = Product::with(['images', 'variants.attributeValues']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand_id', $request->brand);
        }

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.attributeValues', fn($q) => $q->whereIn('value', $request->size));
        }

        if ($request->filled('color')) {
            $query->whereHas('variants.attributeValues', fn($q) => $q->whereIn('value', $request->color));
        }

        if ($request->filled('price')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->price as $price) {
                    match ($price) {
                        '<1000000' => $q->orWhere('price', '<', 1000000),
                        '>=1000000<=3000000' => $q->orWhereBetween('price', [1000000, 3000000]),
                        '>=3000000<=5000000' => $q->orWhereBetween('price', [3000000, 5000000]),
                        '>=5000000<=10000000' => $q->orWhereBetween('price', [5000000, 10000000]),
                        '>10000000' => $q->orWhere('price', '>', 10000000),
                    };
                }
            });
        }

        if ($request->filled('sort')) {
            [$field, $direction] = explode(':', $request->sort);
            $query->orderBy($field, $direction);
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Brand::all();
        $categories = Category::all();
        $colors = Attribute::where('name', 'Màu')->first()?->values ?? [];
        $sizes = Attribute::where('name', 'Kích Thước')->first()?->values ?? [];

        // Xử lý yêu cầu tìm kiếm thông minh (smart search)
        if ($request->get('view') == 'smart') {
            return view('Frontend.partials.product_search_smart_results', compact('products'));
        }

        return view('Frontend.pages.Products', compact('products', 'brands', 'categories', 'colors', 'sizes'));
    }

    public function show($id)
    {
        $product = Product::with([
            'images',
            'variants.attributeValues',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            },
            'reviews.user'
        ])->findOrFail($id);

        $images = $product->images;

        // Lấy thuộc tính "Màu"
        $colorAttr = Attribute::where('name', 'Màu')->first();
        $colors = $colorAttr
            ? $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues;
            })
            ->where('attribute_id', $colorAttr->id)
            ->unique('id')
            : collect();

        // Lấy thuộc tính "Kích Thước"
        $sizeAttr = Attribute::where('name', 'Kích Thước')->first();
        $sizes = $sizeAttr
            ? $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues;
            })
            ->where('attribute_id', $sizeAttr->id)
            ->unique('id')
            : collect();

        // Sản phẩm liên quan (trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(8)
            ->get();

        // Kiểm tra người dùng đã mua chưa
        $hasPurchased = Auth::check() && OrderDetail::where('product_id', $id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', Auth::id());
            })->exists();

        return view('Frontend.pages.product_detail', compact(
            'product',
            'images',
            'colors',
            'sizes',
            'relatedProducts',
            'hasPurchased'
        ))->with('carts', Cart::content());
    }

    public function getVariant(Request $request)
    {
        $variant = ProductVariant::where('product_id', $request->product_id)
            ->whereHas('attributeValues', fn($q) => $q->where('attribute_value_id', $request->color_id))
            ->whereHas('attributeValues', fn($q) => $q->where('attribute_value_id', $request->size_id))
            ->with('attributeValues', 'product')
            ->first();

        return $variant
            ? response()->json(['success' => true, 'variant' => ['id' => $variant->id, 'price' => number_format($variant->price) . '₫', 'stock' => $variant->stock, 'image' => asset($variant->image ?? $variant->product->image)]])
            : response()->json(['success' => false]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'attributes' => Attribute::all(),
            'attribute_values' => AttributeValue::all(),


        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|max:255',
    //         'slug' => 'required|unique:products,slug',
    //         'price' => 'required|numeric|min:0',
    //         'brand_id' => 'required|exists:brands,id',
    //         'category_id' => 'required|exists:categories,id',
    //         'status' => 'required|boolean',
    //         'description' => 'nullable',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    //         'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    //     ]);

    //     $product = Product::create($request->except(['image', 'images']));

    //     if ($request->hasFile('image')) {
    //         $filename = time() . '_' . $request->file('image')->getClientOriginalName();
    //         $request->file('image')->move(public_path('uploads/products'), $filename);
    //         $product->update(['image' => 'uploads/products/' . $filename]);
    //     }

    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $img) {
    //             $fileName = time() . '_' . $img->getClientOriginalName();
    //             $img->move(public_path('uploads/products'), $fileName);
    //             $product->images()->create(['image_path' => 'uploads/products/' . $fileName]);
    //         }
    //     }

    //     return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công.');
    // }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'slug' => 'required|unique:products,slug',
        'price' => 'required|numeric|min:0',
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categories,id',
        'status' => 'required|boolean',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'variants' => 'nullable|array'
    ]);

    // Tạo sản phẩm
    $product = Product::create($request->except(['image', 'images', 'variants']));

    // Ảnh đại diện
    if ($request->hasFile('image')) {
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/products'), $filename);
        $product->update(['image' => 'uploads/products/' . $filename]);
    }

    // Nhiều ảnh phụ
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $img) {
            $fileName = time() . '_' . $img->getClientOriginalName();
            $img->move(public_path('uploads/products'), $fileName);
            $product->images()->create(['image_path' => 'uploads/products/' . $fileName]);
        }
    }

    // Thêm biến thể nếu có
    $variants = $request->input('variants', []);
    if (!empty($variants)) {
        foreach ($variants as $index => $variantData) {
            if (!isset($variantData['value_ids'], $variantData['price'], $variantData['stock'])) {
                continue;
            }

            // Xử lý ảnh biến thể
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
                'product_id' => $product->id,
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
    }

    return redirect()->route('products.index')->with('success', 'Thêm sản phẩm và biến thể thành công.');
}

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('admin.products.edit', [
            'product' => $product,
            'brands' => Brand::all(),
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $product->update($request->except(['image', 'images']));

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $filename);
            $product->update(['image' => 'uploads/products/' . $filename]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $fileName = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('uploads/products'), $fileName);
                $product->images()->create(['image_path' => 'uploads/products/' . $fileName]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        foreach ($product->images as $img) {
            if (file_exists(public_path($img->image_path))) {
                unlink(public_path($img->image_path));
            }
            $img->delete();
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công.');
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
        $image->delete();
        return response()->json(['success' => true, 'message' => 'Hình ảnh đã được xóa.']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with('images')->where('name', 'like', "%$query%")->get();
        return view('admin.products.index', compact('products'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new ProductsImport, $request->file('file'));
        return back()->with('success', 'Import sản phẩm thành công!');
    }
}
