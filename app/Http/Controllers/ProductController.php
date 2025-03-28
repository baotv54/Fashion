<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
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

    public function index()
    {
        $products = $this->productService->getAll();
        return view('admin.products.index', compact('products'));
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('images'); // Bỏ dữ liệu hình ảnh ra để xử lý riêng
        $product = $this->productService->create($data); // Tạo sản phẩm mới

        // Xử lý upload hình ảnh
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('images');
        $product = $this->productService->findById($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        $this->productService->update($id, $data);

        // Xử lý hình ảnh
        if ($request->hasFile('images')) {
            $this->productService->deleteImage($id); // Xóa ảnh cũ
            $this->productService->addImage($id, $request->file('images')); // Thêm ảnh mới
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
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Hình ảnh không tồn tại.'], 404);
        }

        // Xóa file vật lý
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        // Xóa bản ghi trong database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Hình ảnh đã được xóa.']);
    }
}
