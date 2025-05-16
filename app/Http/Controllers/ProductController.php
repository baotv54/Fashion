<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ProductVariant;
use App\Models\Attribute;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
    protected $brandService;
    protected $categoryService;

    public function __construct(ProductService $productService, BrandService $brandService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = $this->productService->getAllWithSearch($search, 5);
        return view('admin.products.index', compact('products', 'search'));
    }
    public function allProducts(Request $request)
    {
        $query = Product::query()
            ->with(['images', 'variants.attributeValues']); 
    
        if ($request->filled('brand')) {
            $query->whereIn('brand_id', $request->input('brand'));
        }
    
        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->input('category'));
        }
    
        if ($request->filled('size')) {
            $query->whereHas('variants.attributeValues', function ($q) use ($request) {
                $q->whereIn('value', $request->input('size'));
            });
        }
    
        if ($request->filled('color')) {
            $query->whereHas('variants.attributeValues', function ($q) use ($request) {
                $q->whereIn('value', $request->input('color'));
            });
        }
    
        if ($request->filled('price')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->input('price') as $price) {
                    switch ($price) {
                        case '<1000000':
                            $q->orWhere('price', '<', 1000000);
                            break;
                        case '>=1000000<=3000000':
                            $q->orWhereBetween('price', [1000000, 3000000]);
                            break;
                        case '>=3000000<=5000000':
                            $q->orWhereBetween('price', [3000000, 5000000]);
                            break;
                        case '>=5000000<=10000000':
                            $q->orWhereBetween('price', [5000000, 10000000]);
                            break;
                        case '>10000000':
                            $q->orWhere('price', '>', 10000000);
                            break;
                    }
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
        $colorAttr = Attribute::where('name', 'Màu')->first();
        $colors = $colorAttr?->values ?? [];
        
        $sizeAttr = Attribute::where('name', 'Kích Thước')->first();
        $sizes = $sizeAttr?->values ?? [];
        
        return view('Frontend.pages.Products', compact('products', 'brands', 'categories', 'sizes', 'colors'));
    }
    
    


    public function homepage()
    {
        $products = $this->productService->getAll();
        $carts =  Cart::content();
        $coupons = Coupon::latest()->take(4)->get();
        return view('Frontend.index', compact('products', 'carts', 'coupons'));
    }
    public function show($id)
    {
        $carts = Cart::content();
        $product = Product::with([
            'images',
            'variants.attributeValues',
            'reviews' => function ($query) {
                $query->where('is_approved', true)->latest();
            },
            'reviews.user'
        ])->findOrFail($id);

        $images = $product->images;

        // Lấy attribute "Màu"
        $colorAttr = Attribute::where('name', 'Màu')->first();
        $colors = $colorAttr
            ? $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues;
            })
            ->where('attribute_id', $colorAttr->id)
            ->unique('id')
            : collect();

        // Lấy attribute "Kích Thước"
        $sizeAttr = Attribute::where('name', 'Kích Thước')->first();
        $sizes = $sizeAttr
            ? $product->variants
            ->flatMap(function ($variant) {
                return $variant->attributeValues;
            })
            ->where('attribute_id', $sizeAttr->id)
            ->unique('id')
            : collect();

        // Lấy sản phẩm liên quan: cùng danh mục, loại trừ sản phẩm hiện tại
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(8)
            ->get();

        // Kiểm tra user hiện tại đã mua sản phẩm chưa (để gửi đánh giá)
        $hasPurchased = false;
        if (Auth::check()) {
            $hasPurchased = OrderDetail::where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->where('user_id', Auth::id());
                })->exists();
        }

        return view('Frontend.pages.product_detail', compact(
            'product',
            'images',
            'carts',
            'colors',
            'sizes',
            'relatedProducts',
            'hasPurchased'
        ));
    }


    public function getVariant(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $sizeId = $request->input('size_id');

        $variant = \App\Models\ProductVariant::where('product_id', $productId)
            ->whereHas('attributeValues', function ($q) use ($colorId) {
                $q->where('attribute_value_id', $colorId);
            })
            ->whereHas('attributeValues', function ($q) use ($sizeId) {
                $q->where('attribute_value_id', $sizeId);
            })
            ->with('attributeValues', 'product')
            ->first();

        if (!$variant) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'variant' => [
                'id' => $variant->id,
                'price' => number_format($variant->price) . '₫',
                'stock' => $variant->stock,
                'image' => asset($variant->image ?? $variant->product->image),
            ]
        ]);
    }



    public function create()
    {
        $brands = $this->brandService->getAllBrands();
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.create', compact('brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('images'); // Bỏ dữ liệu hình ảnh ra để xử lý riêng
        $product = $this->productService->create($data); // Tạo sản phẩm mới

        // Xử lý hình ảnh chính (Lưu tạm thời)
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move(public_path('uploads/products'), $fileName);

            // Cập nhật cột image trong bảng products (Lưu tạm thời)
            $product->update(['image' => 'uploads/products/' . $fileName]);
        }

        // Xử lý hình ảnh phụ
        if ($request->hasFile('images')) {
            $this->productService->addImage($product->id, $request->file('images'));
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function edit($id)
    {
        $product = $this->productService->findById($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        $brands = $this->brandService->getAllBrands();
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Kiểm tra hình ảnh chính
        ]);

        $data = $request->except('images', 'image'); // Bỏ dữ liệu hình ảnh ra để xử lý riêng
        $product = $this->productService->findById($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        // Cập nhật thông tin sản phẩm (không bao gồm hình ảnh)
        $this->productService->update($id, $data);

        // Cập nhật hình ảnh chính nếu có
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '_' . $imageFile->getClientOriginalName();
            $imagePath = 'uploads/products/' . $fileName;

            // Xóa hình ảnh cũ nếu có
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image)); // Xóa hình cũ
            }

            // Di chuyển hình ảnh mới vào thư mục public/uploads/products
            $imageFile->move(public_path('uploads/products'), $fileName);

            // Cập nhật cột hình ảnh chính trong bảng products
            $product->update(['image' => $imagePath]);
        }

        // Xử lý hình ảnh phụ nếu có
        if ($request->hasFile('images')) {
            $this->productService->addImage($id, $request->file('images'));
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }



    public function destroy($id)
    {
        $this->productService->delete($id);
        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công.');
    }

    public function deleteImage($id)
    {
        $image = Image::find($id);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Hình ảnh không tồn tại.'], 404);
        }

        // Xóa file vật lý trong thư mục public/uploads/products
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Xóa bản ghi trong database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Hình ảnh đã được xóa.']);
    }

    // tìm kiếm sản phẩm theo tên
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = $this->productService->search($query);
        return view('admin.products.index', compact('products'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return back()->with('success', 'Import sản phẩm thành công!');
    }
}
