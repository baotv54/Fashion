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
use App\Models\Cost;
use App\Models\Discount;

use Illuminate\Support\Facades\DB;


class ImportWarehouseController extends Controller
{
    // Hiển thị danh sách nhập kho
    public function index(Request $request)
    {
        $query = ImportWarehouseMain::with('supplier', 'user')->latest();

        // Lọc theo ngày (created_at)
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != null) {
            if ($request->status === 'hoan-thanh') {
                $query->where('import_type', 'Đã Nhập Kho')
                    ->where('payment_status', 'Đã thanh toán');
            } elseif ($request->status === 'dang-giao-dich') {
                $query->where(function ($q) {
                    $q->where('import_type', '!=', 'Đã Nhập Kho')
                        ->orWhere('payment_status', '!=', 'Đã thanh toán');
                });
            }
        }

        $imports = $query->paginate(10);

        return view('admin.order_warehouse.index', compact('imports'));
    }

    public function trashed(Request $request)
    {
        $query = ImportWarehouseMain::onlyTrashed()->with('supplier', 'user')->latest();

        // Lọc theo ngày (deleted_at)
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('deleted_at', $request->date);
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != null) {
            if ($request->status === 'hoan-thanh') {
                $query->where('import_type', 'Đã Nhập Kho')
                    ->where('payment_status', 'Đã thanh toán');
            } elseif ($request->status === 'dang-giao-dich') {
                $query->where(function ($q) {
                    $q->where('import_type', '!=', 'Đã Nhập Kho')
                        ->orWhere('payment_status', '!=', 'Đã thanh toán');
                });
            }
        }

        $imports = $query->paginate(10);

        return view('admin.order_warehouse.trashed', compact('imports'));
    }

    public function product(Request $request)
    {
        $search = $request->input('search');

        // Lấy tất cả product_id và variant_id đã tồn tại trong bảng import
        $importedProductIds = ImportWarehouse::whereNull('variant_id')->pluck('product_id')->unique();
        $importedVariantIds = ImportWarehouse::whereNotNull('variant_id')->pluck('variant_id')->unique();

        // Lấy tất cả sản phẩm và biến thể, kèm điều kiện tìm kiếm nếu có
        $productQuery = Product::with('variants');

        if (!empty($search)) {
            $productQuery->where('name', 'like', '%' . $search . '%');
        }

        $products = $productQuery->get();

        // Lấy tất cả attribute values của biến thể
        $variantAttributeValues = VariantAttributeValue::with('attributeValue.attribute')
            ->get()
            ->groupBy('variant_id');

        $items = [];

        foreach ($products as $product) {
            if ($product->variants->count()) {
                foreach ($product->variants as $variant) {
                    // Chỉ lấy biến thể chưa tồn tại trong bảng ImportWarehouse
                    if (!$importedVariantIds->contains($variant->id)) {
                        $items[] = [
                            'is_variant' => true,
                            'product' => $product,
                            'variant' => $variant,
                            'quantity' => $variant->quantity ?? 0,
                            'attributes' => $variantAttributeValues[$variant->id] ?? collect(),
                        ];
                    }
                }
            } else {
                // Nếu sản phẩm không có biến thể và chưa tồn tại trong ImportWarehouse
                if (!$importedProductIds->contains($product->id)) {
                    $items[] = [
                        'is_variant' => false,
                        'product' => $product,
                        'variant' => null,
                        'quantity' => $product->quantity ?? 0,
                        'attributes' => collect(),
                    ];
                }
            }
        }

        // Sắp xếp theo số lượng tăng dần
        $items = collect($items)->sortBy('quantity')->values();

        return view('admin.warehouse.product', [
            'items' => $items,
        ]);
    }


    public function updatePrice(Request $request)
    {
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $importPrice = $request->input('import_price');
        $price = $request->input('price');
        $discountPrice = $request->input('discount_price');

        try {
            if ($variantId) {
                $variant = ProductVariant::findOrFail($variantId);
                $variant->import_price = $importPrice;
                $variant->price = $price;
                $variant->discount_price = $discountPrice;
                $variant->save();
            } else {
                $product = Product::findOrFail($productId);
                $product->import_price = $importPrice;
                $product->price = $price;
                $product->discount_price = $discountPrice;
                $product->save();
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }




    // Hiển thị form thêm mới
    public function create(Request $request)
    {
        $users = User::where('role', 'admin')->get();
        $suppliers = Supplier::all();
        $costs = Cost::all();
        $discounts = Discount::all();
        // Lấy tất cả bản ghi nhập kho (có product và variant liên kết)
        $importwarehouses = ImportWarehouse::with(['product', 'variant'])->latest()->get();

        // Lấy các ID cần dùng
        $productIds = $importwarehouses->pluck('product_id')->unique();
        $importVariantIds = $importwarehouses->pluck('variant_id')->filter()->unique();

        // Lấy danh sách sản phẩm kèm biến thể
        $products = Product::with('variants')->whereIn('id', $productIds)->get();

        // Lấy thuộc tính của các biến thể trong import
        $variantAttributeValues = VariantAttributeValue::with('attributeValue.attribute')
            ->whereIn('variant_id', $importVariantIds)
            ->get()
            ->groupBy('variant_id');

        // Chuẩn bị dữ liệu hiển thị
        $items = [];

        foreach ($products as $product) {
            if ($product->variants->count()) {
                foreach ($product->variants as $variant) {
                    // Chỉ hiển thị biến thể đã được nhập kho
                    $importRow = $importwarehouses->firstWhere('variant_id', $variant->id);
                    if ($importRow && $importRow->id) {
                        $items[] = [
                            'is_variant' => true,
                            'product' => $product,
                            'variant' => $variant,
                            'attributes' => $variantAttributeValues[$variant->id] ?? collect(),
                            'import_id' => $importRow->id, // Đảm bảo có ID
                            'quantity' => $importRow->quantity ?? 0,

                        ];
                    }
                }
            } else {
                // Không có biến thể → kiểm tra bản ghi nhập kho không có variant
                $importRow = $importwarehouses->first(function ($item) use ($product) {
                    return $item->product_id === $product->id && $item->variant_id === null;
                });

                if ($importRow && $importRow->id) {
                    $items[] = [
                        'is_variant' => false,
                        'product' => $product,
                        'variant' => null,
                        'attributes' => collect(),
                        'import_id' => $importRow->id,
                        'quantity' => $importRow->quantity ?? 0,

                    ];
                }
            }
        }

        return view('admin.warehouse.import_creater', [
            'items' => $items,
            'importwarehouses' => $importwarehouses,
            'users' => $users,
            'suppliers' => $suppliers,
            'discounts' => $discounts,
            'costs' => $costs,
        ]);
    }


    // Lưu dữ liệu nhập kho
    public function store(Request $request)
    {
        $selected = $request->input('selected', []);
        $items = $request->input('items', []);

        foreach ($selected as $index) {
            $productId = $items[$index]['product_id'] ?? null;
            $variantId = $items[$index]['variant_id'] ?? null;

            if (!$productId) {
                continue;
            }

            // Nếu có biến thể cụ thể
            if ($variantId) {
                ImportWarehouse::create([
                    'product_id' => $productId,
                    'variant_id' => $variantId,
                ]);
            } else {
                // Không có biến thể → kiểm tra sản phẩm có biến thể không
                $variants = ProductVariant::where('product_id', $productId)->get();

                if ($variants->count()) {
                    foreach ($variants as $variant) {
                        ImportWarehouse::create([
                            'product_id' => $productId,
                            'variant_id' => $variant->id,
                        ]);
                    }
                } else {
                    ImportWarehouse::create([
                        'product_id' => $productId,
                        'variant_id' => null,
                    ]);
                }
            }
        }

        return redirect()->route('warehouse.import_creater')->with('success', 'Đã nhập kho thành công!');
    }



    // Xóa bản ghi
    public function destroy($id)
    {
        // $import = ImportWarehouse::find($id);
        $import = ImportWarehouseMain::find($id);


        if (!$import) {
            return redirect()->back()->with('error', 'Không tìm thấy bản ghi!');
        }

        if ($import->payment_status === "Đã thanh toán" && $import->import_type === "Chưa Nhập") {
            return redirect()->back()->with('error', 'Vui Lòng Nhập Kho Trước Khi Xóa');
        }

        // Xóa mềm (đánh dấu deleted_at)
        $import->delete();

        return redirect()->back()->with('success', 'Đã xóa đơn nhập kho thành công!');
    }



    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $import = ImportWarehouse::findOrFail($id);
        $import->quantity = $request->input('quantity');
        $import->save();

        return response()->json(['success' => true, 'message' => 'Cập nhật số lượng thành công.']);
    }

    // public function store_warehouse(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'nullable|unique:order_warehouses,code',
    //         'supplier_id' => 'nullable|exists:suppliers,id',
    //         'user_id' => 'nullable|exists:users,id',
    //         'import_date' => 'nullable|date',
    //         'product_id.*' => 'nullable|exists:products,id',
    //         'quantity.*' => 'nullable|numeric|min:1',
    //         'price.*' => 'nullable|numeric|min:0',
    //         'variant_id.*' => 'nullable|exists:product_variants,id',
    //         'note' => 'nullable',


    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Tạo phiếu nhập chính
    //         $main = ImportWarehouseMain::create([
    //             'code' => $request->code,
    //             'supplier_id' => $request->supplier_id,
    //             'user_id' => $request->user_id,
    //             'note' => $request->note,
    //             'import_date' => $request->import_date,
    //         ]);

    //         // Thêm danh sách chi tiết
    //         foreach ($request->product_id as $index => $productId) {
    //             ImportWarehouseDetail::create([
    //                 'import_warehouse_id' => $main->id,
    //                 'product_id' => $productId,
    //                 'variant_id' => $request->variant_id[$index] ?? null,
    //                 'quantity' => $request->quantity[$index],
    //                 'price' => $request->price[$index],
    //             ]);
    //         }

    //         DB::commit();
    //         return redirect()->route('warehouse.import_creater')->with('success', 'Tạo đơn nhập hàng thành công!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Lỗi khi tạo đơn nhập: ' . $e->getMessage());
    //     }
    // }


    public function store_warehouse(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'code' => 'required|string|unique:order_warehouses,code',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
            'import_date' => 'required|date',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:1',
            'variant_id' => 'nullable|array',
            'variant_id.*' => 'nullable|exists:product_variants,id',
            'note' => 'nullable|string',
            'total_price' => 'required|numeric|min:1|max:999999999', // giới hạn max tránh overflow
            'cost_name' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|lte:total_price|max:999999999',
            'additional_cost' => 'nullable|numeric|min:0|lte:total_price|max:999999999',

            'payment_status' => 'required|in:Đã thanh toán,Thanh toán sau',
            'payment_method' => 'nullable|string|required_if:payment_status,Đã thanh toán',
            'payment_amount' => 'nullable|numeric|min:1|required_if:payment_status,Đã thanh toán',
            'payment_date' => 'nullable|date|required_if:payment_status,Đã thanh toán',
            'payment_reference' => 'nullable|string|required_if:payment_status,Đã thanh toán',
        ], [
            'code.required' => 'Vui lòng nhập mã đơn.',
            'code.unique' => 'Mã đơn đã tồn tại, vui lòng nhập mã khác.',
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'user_id.required' => 'Vui lòng chọn người tạo đơn.',
            'import_date.required' => 'Vui lòng chọn ngày nhập.',
            'product_id.required' => 'Vui lòng chọn ít nhất một sản phẩm.',
            'product_id.*.required' => 'Sản phẩm không hợp lệ.',
            'product_id.*.exists' => 'Sản phẩm không tồn tại.',
            'quantity.*.required' => 'Vui lòng nhập số lượng.',
            'quantity.*.numeric' => 'Số lượng phải là số.',
            'quantity.*.min' => 'Số lượng phải lớn hơn 0.',
            'total_price.required' => 'Vui lòng nhập tổng tiền.',
            'total_price.numeric' => 'Tổng tiền phải là số.',
            'total_price.min' => 'Tổng tiền phải lớn hơn 0.',
            'discount.lte' => 'Số tiền giảm giá không được lớn hơn tổng tiền sản phẩm.',
            'additional_cost.lte' => 'Chi phí bổ sung không được lớn hơn tổng tiền sản phẩm.',
            'payment_status.required' => 'Vui lòng chọn trạng thái thanh toán.',
            'payment_method.required_if' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_amount.required_if' => 'Vui lòng nhập số tiền thanh toán.',
            'payment_amount.numeric' => 'Số tiền thanh toán phải là số.',
            'payment_amount.min' => 'Số tiền thanh toán phải lớn hơn 0.',
            'payment_date.required_if' => 'Vui lòng nhập ngày thanh toán.',
            'payment_reference.required_if' => 'Vui lòng nhập mã tham chiếu thanh toán.',
        ]);

        // Tạo đơn nhập chính
        $main = ImportWarehouseMain::create([
            'code' => $request->code,
            'supplier_id' => $request->supplier_id,
            'user_id' => $request->user_id,
            'note' => $request->note,
            'import_date' => $request->import_date,
            'status' => 'Đang Giao Dịch',
            'total_price' => $request->total_price,
            'cost_name' => $request->cost_name,
            'discount' => $request->discount ?? 0,
            'additional_cost' => $request->additional_cost ?? 0,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_status === 'Đã thanh toán' ? $request->payment_method : null,
            'payment_amount' => $request->payment_status === 'Đã thanh toán' ? $request->payment_amount : null,
            'payment_date' => $request->payment_status === 'Đã thanh toán' ? $request->payment_date : null,
            'payment_reference' => $request->payment_status === 'Đã thanh toán' ? $request->payment_reference : null,
        ]);

        // Tạo chi tiết đơn
        foreach ($request->product_id as $index => $productId) {
            $variantId = $request->variant_id[$index] ?? null;
            $quantity = $request->quantity[$index];

            $price = 0;
            if ($variantId) {
                $variant = ProductVariant::find($variantId);
                $price = $variant->import_price ?? 0;
            } else {
                $product = Product::find($productId);
                $price = $product->import_price ?? 0;
            }

            ImportWarehouseDetail::create([
                'import_warehouse_id' => $main->id,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'stock' => $quantity,
                'price' => $price,
                'total' => $price * $quantity,
            ]);
        }

        // Xóa tạm các bảng trung gian (nếu cần)
        ImportWarehouse::truncate();
        Cost::truncate();
        Discount::truncate();

        return redirect()->route('warehouse.index')->with('success', 'Tạo đơn nhập hàng thành công!');
    }


    public function delete($id)
    {
        try {
            // Xóa trong DB
            $item = ImportWarehouse::findOrFail($id);
            $item->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function show($id)
    {
        // Lấy đơn nhập chính
        $main = ImportWarehouseMain::with(['supplier', 'user', 'details.product', 'details.variant'])->findOrFail($id);

        return view('admin.order_warehouse.details', compact('main'));
    }


    public function calculateTotal(Request $request)
    {
        $items = ImportWarehouse::with(['product', 'variant'])->get();

        $data = [];
        $grandTotal = 0;

        foreach ($items as $item) {
            $price = $item->variant ? ($item->variant->import_price ?? 0) : ($item->product->import_price ?? 0);
            $quantity = $item->quantity ?? 0;
            $total = $price * $quantity;

            $data[] = [
                'id' => $item->id,
                'product_name' => $item->product->name ?? '',
                'variant_name' => $item->variant->name ?? '',
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
                'total_format' => number_format($total),
            ];

            $grandTotal += $total;
        }

        return response()->json([
            'items' => $data,
            'grand_total' => $grandTotal,
            'grand_total_format' => number_format($grandTotal),
        ]);
    }

    public function update_quantity(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order_warehouses,id',
            'details' => 'required|array',
            'details.*.detail_id' => 'required|exists:import_warehouse_details,id',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|numeric|min:1',
        ]);

        foreach ($request->details as $detail) {
            $productId = $detail['product_id'];
            $variantId = $detail['variant_id'] ?? null;
            $quantity = $detail['quantity'];

            if ($variantId) {
                // Cập nhật biến thể nếu có
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    $variant->quantity += $quantity;
                    $variant->stock += $quantity;
                    $variant->save();
                }
            } else {
                // Cập nhật sản phẩm thường
                $product = Product::find($productId);
                if ($product) {
                    $product->quantity += $quantity;
                    $product->save();
                }
            }
        }

        // Đánh dấu đơn hàng là đã nhập kho
        $order = ImportWarehouseMain::find($request->order_id);
        $order->status = 'Hoàn Thành';
        $order->import_type = 'Đã Nhập Kho';

        $order->save();

        return redirect()->back()->with('success', 'Nhập kho thành công!');
    }

    public function confirmPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'payment_amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_reference' => 'nullable|string',
        ]);

        $order = ImportWarehouseMain::findOrFail($id);
        $order->payment_method = $request->payment_method;
        $order->payment_amount = $request->payment_amount;
        $order->payment_date = $request->payment_date;
        $order->payment_reference = $request->payment_reference;
        $order->payment_status = 'Đã thanh toán';
        $order->save();

        return redirect()->back()->with('success', 'Xác nhận thanh toán thành công!');
    }

    public function costs(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'additional_cost' => 'required|numeric|min:1',
        ]);

        // Xóa tất cả chi phí cũ trước khi thêm mới
        Cost::truncate(); // Xóa toàn bộ bảng Cost, hoặc nếu muốn xóa từng bản ghi: Cost::query()->delete();

        $cost = Cost::create([
            'name' => $request->name,
            'additional_cost' => $request->additional_cost,
        ]);

        return response()->json(['success' => true, 'cost' => $cost]);
    }


    public function discounts(Request $request)
    {
        $request->validate([
            'discount' => 'required|numeric|min:1',
        ]);

        // Xóa tất cả giảm giá cũ trước khi thêm mới
        Discount::truncate(); // hoặc Discount::query()->delete();

        $discount = Discount::create([
            'discount' => $request->discount,
        ]);

        return response()->json(['success' => true, 'discount' => $discount]);
    }
}
