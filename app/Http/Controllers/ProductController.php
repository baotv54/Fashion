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
use App\Models\Order;
use App\Models\Favorite;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\AttributeValue;
use App\Models\VariantAttributeValue;
use App\Models\Post;
use App\Models\Size;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $createdDate = $request->input('created_date');
        $stockStatus = $request->input('stock_status');

        // Lấy products với filter
        $products = Product::with('category', 'brand', 'images')
            ->withCount('favorites') // thêm số lượt thích
            ->when($search, fn($query) => $query->where('name', 'like', "%$search%"))
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->when($createdDate, fn($query) => $query->whereDate('created_at', $createdDate))
            ->when($stockStatus, function ($query) use ($stockStatus) {
                $query->when($stockStatus === 'out_of_stock', fn($q) => $q->where('quantity', 0))
                    ->when($stockStatus === 'low_stock', fn($q) => $q->whereBetween('quantity', [1, 9]))
                    ->when($stockStatus === 'in_stock', fn($q) => $q->where('quantity', '>=', 10));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Lấy danh mục để đổ vào form lọc
        $categories = \App\Models\Category::all();

        // Tính số lượng đã bán cho các sản phẩm trong $products
        $productIds = $products->pluck('id');
        $order_details = OrderDetail::with('variant')
            ->whereIn('product_id', $productIds)
            ->orWhereHas('variant', fn($q) => $q->whereIn('product_id', $productIds))
            ->get();

        $productSales = $order_details->map(function ($detail) {
            $mainProductId = $detail->product_variant_id
                ? $detail->variant->product_id
                : $detail->product_id;
            return [
                'product_id' => $mainProductId,
                'quantity' => $detail->quantity,
            ];
        })
            ->groupBy('product_id')
            ->map(fn($items) => $items->sum('quantity'));

        // Gắn sold_count cho từng product
        $products->getCollection()->transform(function ($product) use ($productSales) {
            $product->sold_count = $productSales[$product->id] ?? 0;
            // $product->favorites_count đã có nhờ withCount('favorites')
            return $product;
        });

        return view('admin.products.index', compact(
            'products',
            'search',
            'categoryId',
            'createdDate',
            'stockStatus',
            'categories'
        ));
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.products.restore', compact('products'));
    }


    public function homepage()
    {
        $products = Product::with('variants')
            ->withCount('favorites') // thêm số lượt thích
            ->where(function ($query) {
                $query->where('quantity', '>', 0)
                    ->orWhereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        $carts = Cart::content();
        $orders = Order::all();
        $posts = Post::all();
        $order_details = OrderDetail::with(['product', 'variant'])->get();
        $coupons = Coupon::latest()->take(4)->get();
        $banners = Banner::latest()->take(4)->get();
        $favorites = collect();

        // Gom nhóm số lượng bán theo product_id
        $productSales = $order_details->map(function ($detail) {
            $mainProductId = $detail->product_variant_id
                ? $detail->variant->product_id
                : $detail->product_id;

            return [
                'product_id' => $mainProductId,
                'quantity'   => $detail->quantity,
            ];
        })
            ->groupBy('product_id')
            ->map(function ($items) {
                return $items->sum('quantity');
            });

        // Gắn sold_count và favorites_count cho list sản phẩm ở homepage
        $products = $products->map(function ($product) use ($productSales) {
            $product->sold_count = $productSales[$product->id] ?? 0;
            // $product->favorites_count đã có nhờ withCount('favorites')
            return $product;
        });

        // Top sản phẩm được thích nhiều nhất
        $topFavorites = Product::withCount('favorites')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->take(4)
            ->get()
            ->map(function ($product) use ($productSales) {
                $product->sold_count = $productSales[$product->id] ?? 0;
                return $product;
            });

        // Top 4 sản phẩm bán chạy
        $topSelling = Product::withCount('favorites')
            ->whereIn('id', $productSales->keys())
            ->get()
            ->map(function ($product) use ($productSales) {
                $product->sold_count = $productSales[$product->id] ?? 0;
                return $product;
            })
            ->sortByDesc('sold_count')
            ->take(4);

        if (Auth::check()) {
            $favorites = Favorite::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }

        return view('Frontend.index', compact(
            'products',
            'carts',
            'coupons',
            'favorites',
            'banners',
            'topFavorites',
            'topSelling',
            'posts'
        ));
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

        // Kiểm tra đã mua và trạng thái đơn hàng hoàn thành
        $canReview = false;
        $userReview = null;
        if (Auth::check()) {
            $hasCompletedOrder = OrderDetail::where('product_id', $id)
                ->whereHas('order', function ($q) {
                    $q->where('user_id', Auth::id())
                        ->where('status', 'delivered');
                })->exists();

            // Kiểm tra đã đánh giá chưa
            $userReview = $product->reviews->where('user_id', Auth::id())->first();
            $canReview = $hasCompletedOrder && !$userReview;
        }

        $totalSold = OrderDetail::where('product_id', $product->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })->sum('quantity');

        // Thống kê đánh giá từ collection đã load
        $avgRating = $product->reviews->avg('rating');
        $totalReviews = $product->reviews->count();

        $ratingStats = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = $product->reviews->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? ($count / $totalReviews * 100) : 0;
            $ratingStats[$i] = [
                'count' => $count,
                'percentage' => round($percentage, 2),
            ];
        }

        // FIX: Tạo mapping variants với cách sắp xếp nhất quán
        $variantMapping = [];
        foreach ($product->variants as $variant) {
            // Sắp xếp theo ID attribute value để đảm bảo consistency
            $attributeIds = $variant->attributeValues->pluck('id')->sort()->values()->toArray();
            $key = implode('-', $attributeIds);

            $variantMapping[$key] = [
                'id' => $variant->id,
                'price' => $variant->price ?? $product->price,
                'stock' => $variant->stock,
                'image' => $variant->image,
                'sku' => $variant->sku,
                'attribute_value_ids' => $attributeIds, // Thêm dòng này
            ];

            // Debug: Log ra để kiểm tra
            Log::info("Variant {$variant->id}: key={$key}, attributes=" . json_encode($attributeIds));
        }

        // FIX: Tính toán hasVariants chính xác
        $hasVariants = $product->variants->count() > 0;

        // Lấy toàn bộ danh sách size để hiển thị dưới "Thông số kỹ thuật"
        $sizes = Size::orderBy('size')->get();

        return view('Frontend.pages.product_detail', compact(
            'product',
            'images',
            'attributes',
            'relatedProducts',
            'avgRating',
            'totalReviews',
            'totalSold',
            'variantMapping',
            'hasVariants',
            'ratingStats',
            'canReview',
            'userReview',
            'sizes'
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
        ], [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'slug.required' => 'Vui lòng nhập đường dẫn (slug) cho sản phẩm.',
            'slug.unique' => 'Slug này đã tồn tại. Vui lòng chọn slug khác.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',

            'import_price.required' => 'Vui lòng nhập giá nhập.',
            'import_price.numeric' => 'Giá nhập phải là một số.',
            'import_price.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',

            'price.required' => 'Vui lòng nhập giá bán.',
            'price.numeric' => 'Giá bán phải là một số.',
            'price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',

            'discount_price.numeric' => 'Giá giảm phải là một số.',
            'discount_price.min' => 'Giá giảm phải lớn hơn hoặc bằng 0.',

            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'brand_id.exists' => 'Thương hiệu không tồn tại.',

            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',

            'status.required' => 'Vui lòng chọn trạng thái hiển thị.',
            'status.boolean' => 'Trạng thái phải là đúng hoặc sai.',

            'image.required' => 'Vui lòng chọn ảnh đại diện.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh đại diện chỉ chấp nhận các định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh đại diện không được vượt quá 2MB.',

            'images.*.image' => 'Mỗi ảnh phụ phải là một tệp hình ảnh.',
            'images.*.mimes' => 'Ảnh phụ chỉ chấp nhận các định dạng: jpeg, png, jpg, webp.',
            'images.*.max' => 'Mỗi ảnh phụ không được vượt quá 2MB.',

            'variants.array' => 'Dữ liệu biến thể phải là dạng danh sách.'
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
        $variants = $request->variants ?? [];

        foreach ($variants as $index => $variantData) {
            if (!isset($variantData['value_ids'], $variantData['price'], $variantData['import_price'], $variantData['discount_price'])) {
                continue;
            }

            $imagePath = null;
            if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $variantData['image'];
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('variants'), $imageName);
                $imagePath = 'variants/' . $imageName;
            }

            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'price' => $variantData['price'],
                'import_price' => $variantData['import_price'],
                'discount_price' => $variantData['discount_price'],
                'image' => $imagePath,
            ]);

            $valueIds = explode('-', $variantData['value_ids']);
            foreach ($valueIds as $valueId) {
                VariantAttributeValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
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
    public function missingVariants($id)
    {
        $product = Product::with('variants.attributeValues.attribute')->findOrFail($id);

        // Lấy danh sách attribute_id mà sản phẩm đang có
        $attributeIds = $product->variants
            ->flatMap(fn($v) => $v->attributeValues->pluck('attribute_id'))
            ->unique();

        // Lấy các attribute cùng value liên quan đến sản phẩm
        $attributes = Attribute::with('values')
            ->whereIn('id', $attributeIds)
            ->get();

        // Sinh ra tất cả tổ hợp có thể có từ các attribute này
        $combinations = [[]];
        foreach ($attributes as $attribute) {
            $temp = [];
            foreach ($combinations as $combination) {
                foreach ($attribute->values as $value) {
                    $temp[] = array_merge($combination, [$value]);
                }
            }
            $combinations = $temp;
        }

        // Lấy tổ hợp đã có
        $existing = $product->variants->map(function ($variant) {
            return $variant->attributeValues->pluck('id')->sort()->values()->toArray();
        })->toArray();

        // Lọc tổ hợp chưa có
        $missing = [];
        foreach ($combinations as $combo) {
            $ids = collect($combo)->pluck('id')->sort()->values()->toArray();
            if (!in_array($ids, $existing)) {
                $missing[] = [
                    'ids' => $ids,
                    'name' => collect($combo)->pluck('value')->implode(' / ')
                ];
            }
        }

        return response()->json($missing);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'import_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
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
                if (!isset($variantData['value_ids'], $variantData['price'], $variantData['import_price'], $variantData['discount_price'])) {
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
                        'import_price' => $variantData['import_price'],
                        'discount_price' => $variantData['discount_price'],
                        'image' => $imagePath,
                    ]);

                    // Xóa và gán lại attribute_value
                    VariantAttributeValue::where('variant_id', $variant->id)->delete();
                } else {
                    // Tạo biến thể mới
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'price' => $variantData['price'],
                        'import_price' => $variantData['import_price'],
                        'discount_price' => $variantData['discount_price'],
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
        $product = Product::with('variants')->findOrFail($id);

        // Kiểm tra số lượng sản phẩm chính
        if ($product->quantity > 0) {
            return redirect()->route('products.index')
                ->with('error', 'Sản phẩm còn tồn kho, không thể xóa.');
        }

        // Kiểm tra số lượng của tất cả biến thể
        foreach ($product->variants as $variant) {
            if ($variant->quantity > 0) {
                return redirect()->route('products.index')
                    ->with('error', 'Một số biến thể còn tồn kho, không thể xóa.');
            }
        }

        // Nếu tất cả số lượng đều nhỏ hơn 1 thì cho phép xóa mềm
        foreach ($product->variants as $variant) {
            $variant->delete(); // soft delete
        }

        $product->delete(); // soft delete product

        return redirect()->route('products.index')->with('success', 'Đã xóa mềm sản phẩm thành công.');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->with(['variants' => function ($query) {
            $query->withTrashed();
        }])->findOrFail($id);

        // Khôi phục sản phẩm
        $product->restore();

        // Khôi phục các biến thể liên quan
        foreach ($product->variants as $variant) {
            $variant->restore();
        }

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được khôi phục thành công.');
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
