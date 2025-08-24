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
use App\Models\ImportWarehouseMain;
use App\Models\ImportWarehouseDetail;
use App\Models\PurchaseReturn;  // nếu cần
use App\Models\ReturnDetail;
use App\Models\ImportWarehouse;



use App\Models\Post;
use App\Models\Size;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            ->withCount(['favorites', 'variants'])
            ->withSum('variants as variants_stock', 'stock')
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

        // Gom nhóm số lượng bán theo product_id
        $productSales = $order_details
            ->mapToGroups(function ($detail) {
                $mainProductId = $detail->product_variant_id
                    ? $detail->variant->product_id
                    : $detail->product_id;
                return [$mainProductId => $detail->quantity];
            })
            ->map(fn($quantities) => $quantities->sum());

        // Gắn sold_count + total_stock cho từng product
        $products->getCollection()->transform(function ($product) use ($productSales) {
            $product->sold_count = $productSales[$product->id] ?? 0;

            // Nếu có biến thể thì lấy tổng stock từ variants_stock, ngược lại lấy quantity
            $product->total_stock = $product->variants_count > 0
                ? $product->variants_stock
                : $product->quantity;

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
        $products = Product::with(['variants', 'reviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->withCount([
                'favorites',
                'reviews as reviews_count' => function ($query) {
                    $query->where('is_approved', true);
                }
            ])
            ->withAvg([
                'reviews as average_rating' => function ($query) {
                    $query->where('is_approved', true);
                }
            ], 'rating')
            ->where(function ($query) {
                $query->where('quantity', '>', 0)
                    ->orWhereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        // --- Tạo thêm top 12 sản phẩm nhiều lượt xem ---
        $topViewed = Product::with(['variants', 'reviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->withCount([
                'favorites',
                'reviews as reviews_count' => function ($query) {
                    $query->where('is_approved', true);
                }
            ])
            ->withAvg([
                'reviews as average_rating' => function ($query) {
                    $query->where('is_approved', true);
                }
            ], 'rating')
            ->where(function ($query) {
                $query->where('quantity', '>', 0)
                    ->orWhereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0);
                    });
            })
            ->orderByDesc('view_count')
            ->take(12)
            ->get();



        // --- Phần còn lại giữ nguyên ---
        $carts = Cart::content();
        $orders = Order::all();
        $posts = Post::all();
        $order_details = OrderDetail::with(['product', 'variant'])
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })
            ->get();
        $coupons = Coupon::latest()->take(4)->get();
        $banners = Banner::latest()->take(4)->get();
        $favorites = collect();

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

        $products = $products->map(function ($product) use ($productSales) {
            $product->sold_count = $productSales[$product->id] ?? 0;
            return $product;
        });

        $topFavorites = Product::with(['reviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->withCount([
                'favorites',
                'reviews as reviews_count' => function ($query) {
                    $query->where('is_approved', true);
                }
            ])
            ->withAvg([
                'reviews as average_rating' => function ($query) {
                    $query->where('is_approved', true);
                }
            ], 'rating')
            ->having('favorites_count', '>', 0)
            ->orderByDesc('favorites_count')
            ->take(4)
            ->get()
            ->map(function ($product) use ($productSales) {
                $product->sold_count = $productSales[$product->id] ?? 0;
                return $product;
            });

        $topSelling = Product::with(['reviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->withCount([
                'favorites',
                'reviews as reviews_count' => function ($query) {
                    $query->where('is_approved', true);
                }
            ])
            ->withAvg([
                'reviews as average_rating' => function ($query) {
                    $query->where('is_approved', true);
                }
            ], 'rating')
            ->whereIn('id', $productSales->keys())
            ->get()
            ->map(function ($product) use ($productSales) {
                $product->sold_count = $productSales[$product->id] ?? 0;
                return $product;
            })
            ->sortByDesc('sold_count')
            ->take(8);

        if (Auth::check()) {
            $favorites = Favorite::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }

        return view('Frontend.index', compact(
            'products',
            'topViewed',  // <--- Thêm biến topViewed
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

    public function allProducts(Request $request, $categorySlug = null)
    {
        $query = Product::with(['images', 'variants.attributeValues', 'reviews' => function ($query) {
            $query->where('is_approved', true);
        }])
            ->withCount([
                'favorites',
                'reviews as reviews_count' => function ($query) {
                    $query->where('is_approved', true);
                }
            ])
            ->withAvg([
                'reviews as average_rating' => function ($query) {
                    $query->where('is_approved', true);
                }
            ], 'rating');

        $currentCategory = null; // biến mặc định

        // Lọc theo danh mục nếu truyền slug
        if ($categorySlug) {
            $category = Category::with('parent')->where('slug', $categorySlug)->first();
            if ($category) {
                $currentCategory = $category; // gán vào để dùng ở breadcrumb

                // Lấy tất cả id danh mục con
                $categoryIds = $category->children()->pluck('id')->toArray();
                $categoryIds[] = $category->id;

                $query->whereIn('category_id', $categoryIds);
            }
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

        // Text search by name or slug
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Price filter
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

        // Sorting
        if ($request->filled('sort')) {
            [$field, $direction] = explode(':', $request->sort);
            $query->orderBy($field, $direction);
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Get order details to calculate sold count
        $order_details = OrderDetail::with(['product', 'variant'])
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })
            ->get();
        // Group sales quantity by product_id
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

        // Add sold_count to products
        $products->getCollection()->transform(function ($product) use ($productSales) {
            $product->sold_count = $productSales[$product->id] ?? 0;
            return $product;
        });

        // Get user favorites if authenticated
        $favorites = collect();
        if (Auth::check()) {
            $favorites = Favorite::with('product')
                ->where('user_id', Auth::id())
                ->get();
        }

        $brands = Brand::all();
        $categories = Category::all();
        $colors = Attribute::where('name', 'Màu')->first()?->values ?? [];
        $sizes = Attribute::where('name', 'Kích Thước')->first()?->values ?? [];

        return view('Frontend.pages.Products', compact('products', 'brands', 'categories', 'colors', 'sizes', 'favorites', 'currentCategory'));
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

        // Cộng dồn lượt xem
        $product->increment('view_count');

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
            'import_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->price !== null && $value > $request->price) {
                        $fail('Giá nhập không được lớn hơn giá bán.');
                    }
                }
            ],
            'price' => 'required|numeric|min:0',
            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->price !== null && $value > $request->price) {
                        $fail('Giá giảm không được lớn hơn giá bán.');
                    }
                    if ($request->import_price !== null && $value < $request->import_price) {
                        $fail('Giá giảm không được nhỏ hơn giá nhập.');
                    }
                }
            ],
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants' => 'nullable|array',
            'variants.*.price' => 'required_with:variants.*.import_price|numeric|min:0',
            'variants.*.import_price' => [
                'required_with:variants.*.price',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1]; // ví dụ: variants.0.import_price
                    $price = $request->variants[$index]['price'] ?? null;
                    if ($price !== null && $value > $price) {
                        $fail("Giá nhập của biến thể #" . ($index + 1) . " không được lớn hơn giá bán.");
                    }
                }
            ],
            'variants.*.discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $price = $request->variants[$index]['price'] ?? null;
                    $importPrice = $request->variants[$index]['import_price'] ?? null;

                    if ($price !== null && $value > $price) {
                        $fail("Giá KM của biến thể #" . ($index + 1) . " không được lớn hơn giá bán.");
                    }
                    if ($importPrice !== null && $value < $importPrice) {
                        $fail("Giá KM của biến thể #" . ($index + 1) . " không được nhỏ hơn giá nhập.");
                    }
                }
            ],
        ], [
            // thông báo lỗi cho sản phẩm chính
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'price.required' => 'Vui lòng nhập giá bán.',
            'import_price.required' => 'Vui lòng nhập giá nhập.',
            // thông báo lỗi cho biến thể
            'variants.*.price.required_with' => 'Vui lòng nhập giá bán cho tất cả biến thể.',
            'variants.*.price.numeric' => 'Giá bán của biến thể phải là số.',
            'variants.*.import_price.required_with' => 'Vui lòng nhập giá nhập cho biến thể.',
            'variants.*.import_price.numeric' => 'Giá nhập của biến thể phải là số.',
            'variants.*.discount_price.numeric' => 'Giá KM của biến thể phải là số.',
        ]);

        // ✅ Tạo slug tự động từ tên sản phẩm
        $slug = Str::slug($request->name);

        // Kiểm tra nếu slug đã tồn tại → thêm hậu tố để tránh trùng
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Tạo sản phẩm
        $product = Product::create(array_merge(
            $request->except(['image', 'images', 'variants']),
            ['slug' => $slug]
        ));

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
        foreach ($variants as $variantData) {
            if (!isset($variantData['value_ids'], $variantData['price'], $variantData['import_price'])) {
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
    // ProductVariantController.php
    public function storeAjax(Request $request, $productId)
    {
        $variants = $request->variants ?? [];

        foreach ($variants as $index => $variantData) {
            if (!isset($variantData['value_ids'], $variantData['price'], $variantData['import_price'])) {
                continue;
            }

            // Chuyển value_ids thành mảng đã sắp xếp
            $valueIds = collect(explode('-', $variantData['value_ids']))
                ->map(fn($id) => (int) $id)
                ->sort()
                ->values()
                ->toArray();

            // Kiểm tra xem tổ hợp này đã tồn tại chưa
            $exists = ProductVariant::where('product_id', $productId)
                ->whereHas('attributeValues', function ($q) use ($valueIds) {
                    $q->whereIn('attribute_value_id', $valueIds);
                }, '=', count($valueIds)) // vẫn giữ điều kiện số lượng
                ->whereDoesntHave('attributeValues', function ($q) use ($valueIds) {
                    $q->whereNotIn('attribute_value_id', $valueIds);
                })
                ->first();


            if ($exists) {
                // Nếu đã có thì bỏ qua (hoặc bạn có thể update giá nếu muốn)
                continue;
            }

            // Xử lý ảnh
            $imagePath = null;
            if (isset($variantData['image']) && $variantData['image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $variantData['image'];
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('variants'), $imageName);
                $imagePath = 'variants/' . $imageName;
            }

            // Tạo variant mới
            $variant = ProductVariant::create([
                'product_id' => $productId,
                'price' => $variantData['price'],
                'import_price' => $variantData['import_price'],
                'discount_price' => $variantData['discount_price'] ?? null,
                'image' => $imagePath,
            ]);

            // Gắn attribute values cho variant mới
            foreach ($valueIds as $valueId) {
                VariantAttributeValue::create([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $valueId,
                ]);
            }
        }

        return response()->json(['success' => true]);
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

        // ✅ Validate sản phẩm chính
        $request->validate([
            'name'          => 'required|max:255',
            'import_price'  => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->price !== null && $value > $request->price) {
                        $fail('Giá nhập không được lớn hơn giá bán.');
                    }
                }
            ],
            'price'         => 'required|numeric|min:0',
            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->price !== null && $value > $request->price) {
                        $fail('Giá khuyến mãi không được lớn hơn giá bán.');
                    }
                }
            ],
            'brand_id'      => 'required|exists:brands,id',
            'category_id'   => 'required|exists:categories,id',
            'status'        => 'required|boolean',
            'description'   => 'nullable',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'variants'      => 'nullable|array',
        ]);

        // ✅ Kiểm tra validate cho biến thể
        $variants = $request->input('variants', []);
        foreach ($variants as $i => $variant) {
            if (isset($variant['price'], $variant['import_price'])) {
                if ($variant['import_price'] > $variant['price']) {
                    return back()
                        ->withErrors(["variants.$i.import_price" => "Giá nhập biến thể không được lớn hơn giá bán."])
                        ->withInput();
                }
            }
            if (isset($variant['discount_price'], $variant['price'])) {
                if ($variant['discount_price'] > $variant['price']) {
                    return back()
                        ->withErrors(["variants.$i.discount_price" => "Giá khuyến mãi biến thể không được lớn hơn giá bán."])
                        ->withInput();
                }
            }
        }

        // ✅ Update sản phẩm (trừ image & variants)
        $product->update($request->except(['image', 'images', 'variants']));

        // ✅ Ảnh chính
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $filename);
            $product->update(['image' => 'uploads/products/' . $filename]);
        }

        // ✅ Ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $fileName = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('uploads/products'), $fileName);
                $product->images()->create(['image_path' => 'uploads/products/' . $fileName]);
            }
        }

        // ✅ Cập nhật biến thể
        if (!empty($variants)) {
            foreach ($variants as $index => $variantData) {
                if (!isset($variantData['id'], $variantData['value_ids'], $variantData['price'], $variantData['import_price'])) {
                    continue;
                }

                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('id', $variantData['id'])
                    ->first();

                if (!$variant) {
                    continue;
                }

                // Xử lý ảnh biến thể
                $imagePath = $variant->image;
                $imageInputName = "variants.$index.image";
                if ($request->hasFile($imageInputName)) {
                    if ($imagePath && file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
                    }
                    $file = $request->file($imageInputName);
                    $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $imagePath = 'variants/' . $imageName;
                    $file->move(public_path('variants'), $imageName);
                }

                // ✅ Update biến thể
                $variant->update([
                    'price'          => $variantData['price'],
                    'import_price'   => $variantData['import_price'],
                    'discount_price' => $variantData['discount_price'],
                    'image'          => $imagePath,
                ]);

                // Đồng bộ attribute values
                $valueIds = explode('-', $variantData['value_ids']);
                $variant->attributeValues()->sync($valueIds);
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }


    public function destroy($id)
    {
        $product = Product::with('variants')->findOrFail($id);

        // 🔎 Kiểm tra số lượng sản phẩm chính
        if ($product->quantity > 0) {
            return redirect()->route('products.index')
                ->with('error', 'Sản phẩm còn tồn kho, không thể xóa.');
        }

        // 🔎 Kiểm tra tồn kho biến thể
        foreach ($product->variants as $variant) {
            if ($variant->stock > 0) {
                return redirect()->route('products.index')
                    ->with('error', 'Một số biến thể còn tồn kho, không thể xóa.');
            }
        }

        // 🔎 Kiểm tra phiếu nhập kho liên quan (ImportWarehouseDetail -> ImportWarehouseMain)
        $importDetails = ImportWarehouseDetail::where('product_id', $product->id)
            ->with('importWarehouseMain')
            ->get();

        foreach ($importDetails as $detail) {
            if ($detail->importWarehouseMain && $detail->importWarehouseMain->import_type !== 'Đã Nhập Kho') {
                return redirect()->route('products.index')
                    ->with('error', 'Sản phẩm thuộc phiếu nhập kho chưa hoàn tất, không thể xóa.');
            }
        }

        // 🔎 Kiểm tra phiếu trả hàng liên quan
        $returnDetails = ReturnDetail::where('product_id', $product->id)
            ->with('purchaseReturn')
            ->get();

        foreach ($returnDetails as $detail) {
            if ($detail->purchaseReturn && $detail->purchaseReturn->refund_status !== 'Đã Hoàn Tiền') {
                return redirect()->route('products.index')
                    ->with('error', 'Sản phẩm thuộc phiếu trả hàng chưa hoàn tất, không thể xóa.');
            }
        }

        // ✅ Xóa mềm sản phẩm và biến thể
        foreach ($product->variants as $variant) {
            $variant->delete(); // soft delete
        }
        $product->delete(); // soft delete product

        // 🔎 Xóa cứng các ImportWarehouse có product_id = $id
        ImportWarehouse::where('product_id', $product->id)->forceDelete();

        return redirect()->route('products.index')
            ->with('success', 'Đã xóa Sản Phẩm Thành Công.');
    }


    public function forceDelete($id)
    {
        $product = Product::withTrashed()->with('variants')->findOrFail($id);

        // 🔎 Xóa OrderDetail liên quan
        $orderDetails = OrderDetail::where('product_id', $product->id)
            ->orWhereIn('variant_id', $product->variants->pluck('id'))
            ->get();

        foreach ($orderDetails as $detail) {
            $detail->forceDelete();
        }

        // 🔎 Xóa ImportWarehouseDetail liên quan
        $importDetails = ImportWarehouseDetail::where('product_id', $product->id)->get();
        foreach ($importDetails as $detail) {
            $detail->forceDelete();
        }

        // 🔎 Xóa ReturnDetail liên quan
        $returnDetails = ReturnDetail::where('product_id', $product->id)->get();
        foreach ($returnDetails as $detail) {
            $detail->forceDelete();
        }

        // 🔎 Xóa tất cả biến thể
        foreach ($product->variants as $variant) {
            $variant->forceDelete();
        }

        // 🔎 Xóa sản phẩm
        $product->forceDelete();

        return redirect()->route('products.index')
            ->with('success', 'Đã xóa vĩnh viễn sản phẩm, biến thể và các dữ liệu liên quan.');
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
        $query = $request->get('query', $request->get('q', ''));
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->select('id', 'name', 'image')
            ->limit(20)
            ->get();

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'image_url' => $p->image ? asset($p->image) : asset('images/default.jpg'),
            ];
        });

        return response()->json($results);
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
            ->withSum('variants as variants_stock', 'stock') // cộng dồn stock từ variants
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
