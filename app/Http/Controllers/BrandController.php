<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brands = $this->brandService->getAllBrands();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'status' => 'required|boolean',
        ]);

        $this->brandService->createBrand($request->all());
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được tạo thành công!');
    }

    public function edit($id)
    {
        $brand = $this->brandService->findById($id);
        return view('admin.brands.create', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
            'status' => 'required|boolean',
        ]);

        $this->brandService->updateBrand($id, $request->all());
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã được cập nhật!');
    }

    public function destroy($id)
    {
        $brand = $this->brandService->findById($id);
        if (!$brand) {
            return redirect()->route('brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }
    
        $this->brandService->deleteBrand($id);
        return redirect()->route('brands.index')->with('success', 'Thương hiệu đã bị xóa thành công.');
    }
    
}
