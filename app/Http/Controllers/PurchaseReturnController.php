<?php

namespace App\Http\Controllers;

use App\Models\ImportWarehouse;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ImportWarehouseMain;
use App\Models\ImportWarehouseDetail;
use Illuminate\Http\Request;
use App\Models\VariantAttributeValue;
use App\Models\User;
use App\Models\Supplier;
use App\Models\ReturnDetail;
use App\Models\PurchaseReturn;

use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PurchaseReturn::with('supplier', 'user')->latest();

        // Lọc theo ngày (created_at)
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo trạng thái
        // if ($request->has('status') && $request->status != null) {
        //     if ($request->status === 'hoan-thanh') {
        //         $query->where('import_type', 'Đã Nhập Kho')
        //             ->where('payment_status', 'Đã thanh toán');
        //     } elseif ($request->status === 'dang-giao-dich') {
        //         $query->where(function ($q) {
        //             $q->where('import_type', '!=', 'Đã Nhập Kho')
        //                 ->orWhere('payment_status', '!=', 'Đã thanh toán');
        //         });
        //     }
        // }

        $returns = $query->paginate(10);
        $imports = ImportWarehouseMain::all();

        return view('admin.return_warehouse.index', compact('returns','imports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'return_code'      => 'required|string|unique:purchase_returns,return_code',
        'supplier_id'      => 'required|exists:suppliers,id',
        'user_id'          => 'required|exists:users,id',
        'product_id'       => 'required|array',
        'product_id.*'     => 'required|exists:products,id',
        'quantity'         => 'required|array',
        'quantity.*'       => 'required|numeric|min:1',
        'variant_id'       => 'nullable|array',
        'variant_id.*'     => 'nullable|exists:product_variants,id',
        'total_quantity'   => 'required|numeric|min:1',
        'total_amount'     => 'required|numeric|min:1',
    ]);

    // Tạo đơn trả hàng chính
    $main = PurchaseReturn::create([
        'return_code'    => $request->return_code,
        'return_status'  => 'Đã Hoàn Hàng',   // hoặc Pending
        'refund_status'  => 'Đang Xử Lý',     // hoặc Unpaid
        'supplier_id'    => $request->supplier_id,
        'user_id'        => $request->user_id,
        'total_quantity' => $request->total_quantity,
        'total_amount'   => $request->total_amount,
    ]);

    foreach ($request->product_id as $index => $productId) {
        $variantId = $request->variant_id[$index] ?? null;
        $quantity  = $request->quantity[$index];

        $price = 0;

        if ($variantId) {
            $variant = ProductVariant::find($variantId);

            if (!$variant || $variant->stock < $quantity) {
                // Nếu không đủ stock thì hủy đơn trả đã tạo và báo lỗi
                $main->delete();
                return redirect()->back()->with('error', "Biến thể sản phẩm ID {$variantId} không đủ số lượng để hoàn hàng!");
            }

            $price = $variant->import_price ?? 0;

            // Giảm stock biến thể
            $variant->stock -= $quantity;
            $variant->save();
        } else {
            $product = Product::find($productId);

            if (!$product || $product->stock < $quantity) {
                $main->delete();
                return redirect()->back()->with('error', "Sản phẩm ID {$productId} không đủ số lượng để hoàn hàng!");
            }

            $price = $product->import_price ?? 0;

            // Giảm stock sản phẩm
            $product->stock -= $quantity;
            $product->save();
        }

        // Giảm stock trong chi tiết đơn nhập (import_warehouse_details)
        $importDetail = ImportWarehouseDetail::where('product_id', $productId)
            ->when($variantId, function ($q) use ($variantId) {
                return $q->where('variant_id', $variantId);
            })
            ->first();

        if ($importDetail) {
            if ($importDetail->stock < $quantity) {
                $main->delete();
                return redirect()->back()->with('error', "Chi tiết nhập kho của sản phẩm ID {$productId} không đủ số lượng để hoàn hàng!");
            }

            $importDetail->stock -= $quantity;
            $importDetail->save();
        }

        // Lưu chi tiết đơn trả
        ReturnDetail::create([
            'return_id'  => $main->id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity'   => $quantity,
            'price'      => $price,
        ]);
    }

    return redirect()->route('admin.return_warehouse.index')->with('success', 'Tạo đơn trả hàng thành công!');
}




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy đơn nhập chính
        $main = ImportWarehouseMain::with(['supplier', 'user', 'details.product', 'details.variant'])->findOrFail($id);

        return view('admin.order_warehouse.return', compact('main'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
