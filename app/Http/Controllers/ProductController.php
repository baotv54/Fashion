<?php
namespace App\Http\Controllers;

use App\Models\Image;
use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Gloudemans\Shoppingcart\Facades\Cart;
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

    public function homepage()
    {
        $products = $this->productService->getAll();
        $carts =  Cart::content();
        return view('Frontend.index', compact('products', 'carts'));
    }
    public function show($id)
    {
        $carts =  Cart::content();

        $product = Product::with('images')->findOrFail($id);
        $images = $product->images; 
        return view('Frontend.pages.product_detail', compact('product', 'images', 'carts'));
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
}
