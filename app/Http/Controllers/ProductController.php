<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Coupon;
use App\Models\Attribute;
use App\Models\ProductVariant;
use App\Models\OrderDetail;
use App\Models\Favorite;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\AttributeValue;
use App\Models\VariantAttributeValue;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $createdDate = $request->input('created_date');
        $stockStatus = $request->input('stock_status');

        $products = Product::with('category', 'brand', 'images')
            ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->when($createdDate, function ($query) use ($createdDate) {
                return $query->whereDate('created_at', $createdDate);
            })
            ->when($stockStatus, function ($query) use ($stockStatus) {
                return $query->where(function ($q) use ($stockStatus) {
                    if ($stockStatus === 'out_of_stock') {
                        $q->where('quantity', 0);
                    } elseif ($stockStatus === 'low_stock') {
                        $q->whereBetween('quantity', [1, 9]);
                    } elseif ($stockStatus === 'in_stock') {
                        $q->where('quantity', '>=', 10);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Lấy danh mục để đổ vào form lọc
        $categories = \App\Models\Category::all();

        return view('admin.products.index', compact('products', 'search', 'categoryId', 'createdDate', 'stockStatus', 'categories'));
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
        return view('Frontend.index', compact('products', 'carts', 'coupons', 'favorites', 'banners'));
    }

    public function aboutPage()
    {
        $products = Product::latest()->take(8)->get();
        return view('Frontend.pages.gioi-thieu', compact('products'));
    }

    public function allProducts(Request $request)
    {
        $query = Product::with(['images', 'variants.attributeValues']);

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

        return view('Frontend.pages.Products', compact('products', 'brands', 'categories', 'colors', 'sizes'));
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'variants.attributeValues.attribute',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            },
            'reviews.user'
        ])->findOrFail($id);

        $images = $product->images;

        // Nhóm attributes theo tên thuộc tính
        $attributes = $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues;
            })
            ->groupBy(fn($attrVal) => $attrVal->attribute->name);

        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(8)
            ->get();

        $hasPurchased = Auth::check() && OrderDetail::where('product_id', $id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', Auth::id());
            })->exists();

        $totalSold = OrderDetail::where('product_id', $product->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })->sum('quantity');

        $avgRating = $product->reviews->avg('rating');
        $totalReviews = $product->reviews->count();

        // Tạo mapping variants để JavaScript sử dụng
        $variantMapping = [];
        foreach ($product->variants as $variant) {
            $attributeIds = $variant->attributeValues->pluck('id')->sort()->toArray();
            $key = implode('-', $attributeIds);

            $variantMapping[$key] = [
                'id' => $variant->id,
                'price' => $variant->price ?? $product->price,
                'stock' => $variant->stock,
                'image' => $variant->image,
                'sku' => $variant->sku,
            ];
        }

        return view('Frontend.pages.product_detail', compact(
            'product',
            'images',
            'attributes',
            'relatedProducts',
            'hasPurchased',
            'avgRating',
            'totalReviews',
            'totalSold',
            'variantMapping'
        ))->with('carts', Cart::content());
    }

    public function getVariantInfo($id)
    {
        $variant = ProductVariant::with(['product', 'attributeValues.attribute'])->findOrFail($id);

        return response()->json([
            'id' => $variant->id,
            'price' => $variant->price ?? $variant->product->price,
            'stock' => $variant->stock,
            'image' => $variant->image ? asset($variant->image) : null,
            'sku' => $variant->sku,
            'attributes' => $variant->attributeValues->map(function ($attrVal) {
                return $attrVal->attribute->name . ': ' . $attrVal->value;
            })->join(', '),
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug',
            'quantity' => 'required|integer|min:0|max:255',
            'import_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
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
                    'import_price' => $variantData['import_price'],
                    'discount_price' => $variantData['discount_price'],
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
        $variantIds = ProductVariant::where('product_id', $id)->pluck('id');

        return view('admin.products.edit', [
            'product' => $product,
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'attributeValues' => AttributeValue::all(),
            'attribute' => Attribute::all(),
            'variantAttributeValue' => VariantAttributeValue::all(),
            'product_variants' => ProductVariant::where('product_id', $id)->get(),
            'variantAttributeValue' => VariantAttributeValue::whereIn('variant_id', $variantIds)->get(),


        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'nullable|array',

        ]);

        $product->update($request->except(['image', 'images', 'variants']));

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

        // ✅ Cập nhật biến thể
        $variants = $request->input('variants', []);
        if (!empty($variants)) {
            foreach ($variants as $index => $variantData) {
                if (!isset($variantData['value_ids'], $variantData['price'], $variantData['stock'])) {
                    continue;
                }

                $variant = null;

                // Nếu có ID → cập nhật, không có → tạo mới
                if (!empty($variantData['id'])) {
                    $variant = ProductVariant::where('product_id', $product->id)
                        ->where('id', $variantData['id'])
                        ->first();
                }

                // Xử lý ảnh biến thể
                $imagePath = $variant->image ?? null;
                $imageInputName = "variants.$index.image";

                if ($request->hasFile($imageInputName)) {
                    // Xoá ảnh cũ nếu có
                    if ($imagePath && file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
                    }

                    $file = $request->file($imageInputName);
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $imagePath = 'variants/' . $imageName;
                    $file->move(public_path('variants'), $imageName);
                }

                if ($variant) {
                    // Cập nhật biến thể
                    $variant->update([
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                        'image' => $imagePath,
                    ]);

                    // Xóa và gán lại attribute_value
                    VariantAttributeValue::where('variant_id', $variant->id)->delete();
                } else {
                    // Tạo biến thể mới
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                        'image' => $imagePath,
                    ]);
                }

                // Gán các attribute_value mới
                $valueIds = explode('-', $variantData['value_ids']);
                foreach ($valueIds as $valueId) {
                    VariantAttributeValue::create([
                        'variant_id' => $variant->id,
                        'attribute_value_id' => $valueId,
                    ]);
                }
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

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');
    //     $products = Product::with('images')->where('name', 'like', "%$query%")->get();
    //     return view('admin.products.index', compact('products'));
    // }
    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json($products);
    }

    public function info(Request $request)
    {
        $product = Product::findOrFail($request->id);
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new ProductsImport, $request->file('file'));
        return back()->with('success', 'Import sản phẩm thành công!');
    }

    public function warehouse(Request $request)
    {
        $search = $request->input('search');
        $stockFilter = $request->input('stock_filter');
        $categoryId = $request->input('category_id');

        $products = Product::with('category', 'brand', 'images')
            ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
            ->when($stockFilter === 'in_stock', fn($query) => $query->where('quantity', '>', 0))
            ->when($stockFilter === 'out_stock', fn($query) => $query->where('quantity', '=', 0))
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->paginate(10);

        $categories = Category::all(); // Load tất cả danh mục để đổ ra select

        return view('admin.warehouse.index', compact('products', 'search', 'stockFilter', 'categoryId', 'categories'));
    }

    // public function import_creater ()
    // {
    //     $product = Product::with('images')->findOrFail($id);
    //     $variantIds = ProductVariant::where('product_id', $id)->pluck('id');

    //     return view('admin.warehouse.import_creater', [
    //         'product' => $product,
    //         'attributeValues' => AttributeValue::all(),
    //         'attribute' => Attribute::all(),
    //         'variantAttributeValue' => VariantAttributeValue::all(),
    //         'product_variants' => ProductVariant::where('product_id', $id)->get(),
    //         'variantAttributeValue' => VariantAttributeValue::whereIn('variant_id', $variantIds)->get(),


    //     ]);
    // }
    // public function import_creater()
    // {
    //     // Lấy tất cả sản phẩm có biến thể kèm các thông tin cần thiết
    //     return view('admin.warehouse.import_creater', [
    //             'products' => Product::all(),
    //             // 'suppliers' => Supplier::all(),
    //         ]);
    // }

    public function search3(Request $request)
    {
        $term = $request->get('term');
        $products = Product::where('name', 'like', '%' . $term . '%')->limit(10)->get();

        return response()->json($products->map(function ($p) {
            return [
                'id' => $p->id,
                'label' => $p->name,
                'value' => $p->name,
            ];
        }));
    }


    public function search2(Request $request)
    {
        $query = $request->get('query');
        $products = Product::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'image as image_url')
            // chọn các cột cần thiết
            ->limit(10)
            ->get();

        return response()->json($products);
    }


    public function history()
    {
        return view('admin.warehouse.history', [
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'attributes' => Attribute::all(),
            'attribute_values' => AttributeValue::all(),


        ]);
    }

    public function supplier()
    {
        return view('admin.warehouse.supplier', [
            'brands' => Brand::all(),
            'categories' => Category::all(),
            'attributes' => Attribute::all(),
            'attribute_values' => AttributeValue::all(),


        ]);
    }

    public function quickview($id)
    {
        $product = Product::with([
            'category',
            'brand',
            'images',
            'variants.attributeValues.attribute'
        ])->findOrFail($id);

        // Lấy các thuộc tính màu sắc và kích thước
        $colors = collect();
        $sizes = collect();

        if ($product->variants->isNotEmpty()) {
            $attributes = $product->variants
                ->flatMap(function ($variant) {
                    return $variant->attributeValues;
                })
                ->groupBy(fn($attrVal) => $attrVal->attribute->name);

            $colors = $attributes->get('Màu', collect());
            $sizes = $attributes->get('Kích Thước', collect());
        }

        return response()->json([
            'success' => true,
            'html' => view('Frontend.partials.quickview-modal', compact('product', 'colors', 'sizes'))->render()
        ]);
    }
}
