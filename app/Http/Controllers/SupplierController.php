<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ImportWarehouseMain;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo khoảng ngày tạo
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Lọc theo nhân viên phụ trách
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return view('admin.supplier.index', [
            'users' => User::where('role', 'admin')->get(),
            'suppliers' => $query->orderByDesc('id')->paginate(10),
            'oldFilters' => $request->only('search', 'from_date', 'to_date', 'user_id'),
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create', [
            'users' => User::where('role', 'admin')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_code'  => 'required|string|max:50|unique:suppliers,supplier_code',
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|regex:/^[0-9+\-\s]{9,15}$/',
            'tax_code'       => 'required|string|max:50',
            'fax'            => 'required|string|max:50',
            'email'          => 'required|email|max:255',
            'province'       => 'required|string|max:100',
            'district'       => 'required|string|max:100',
            'ward'           => 'required|string|max:100',
            'address_detail' => 'required|string|max:255',
            'user_id'        => 'required|integer|exists:users,id',
            'website'        => 'required|url|max:255',
            // không validate status cố định ở đây
        ], [
            'supplier_code.required' => 'Vui lòng nhập mã nhà cung cấp',
            'supplier_code.unique'   => 'Mã nhà cung cấp đã tồn tại',
            'supplier_code.max'      => 'Mã nhà cung cấp không được vượt quá 50 ký tự',
            'name.required'          => 'Vui lòng nhập tên nhà cung cấp',
            'name.max'               => 'Tên nhà cung cấp không được vượt quá 255 ký tự',
            'phone.regex'            => 'Số điện thoại không hợp lệ',
            'email.email'            => 'Email không đúng định dạng',
            'email.max'              => 'Email không được vượt quá 255 ký tự',
            'user_id.exists'         => 'Nhân viên phụ trách không hợp lệ',
            'website.url'            => 'Website không đúng định dạng (phải bắt đầu bằng http:// hoặc https://)',
            'website.max'            => 'Website không được vượt quá 255 ký tự',
        ]);

        $data = $request->all();
        $data['status'] = 'Đang Hoạt Động'; // gán mặc định

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Thêm nhà cung cấp thành công');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::with('user')->findOrFail($id);

        // Đơn nhập của nhà cung cấp
        $imports = ImportWarehouseMain::where('supplier_id', $id)->get();

        // Đơn trả của nhà cung cấp
        $returns = PurchaseReturn::where('supplier_id', $id)->get();

        // Thống kê
        $stats = [
            'imports_count' => $imports->count(),
            'imports_unpaid' => $imports->where('payment_status', 'Chưa Thanh Toán')->count(),
            'returns_count' => $returns->count(),
            'returns_unrefund' => $returns->where('refund_status', '!=', 'Đã Hoàn Tiền')->count(),
        ];

        return view('admin.supplier.show', compact('supplier', 'imports', 'returns', 'stats'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $users = User::where('role', 'admin')->get();

        return view('admin.supplier.edit', compact('supplier', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'supplier_code'  => 'required|string|max:50|unique:suppliers,supplier_code,' . $supplier->id,
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|regex:/^[0-9+\-\s]{9,15}$/',
            'tax_code'       => 'required|string|max:50',
            'fax'            => 'required|string|max:50',
            'email'          => 'required|email|max:255',
            'province'       => 'required|string|max:100',
            'district'       => 'required|string|max:100',
            'ward'           => 'required|string|max:100',
            'address_detail' => 'required|string|max:255',
            'user_id'        => 'required|integer|exists:users,id',
            'website'        => 'required|url|max:255',
            // không validate status như "Đang Hoạt Động"
        ]);

        $data = $request->only([
            'supplier_code',
            'name',
            'phone',
            'tax_code',
            'fax',
            'email',
            'province',
            'district',
            'ward',
            'address_detail',
            'user_id',
            'website',
        ]);

        // set status mặc định
        $data['status'] = 'Đang Hoạt Động';

        $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    public function update_status(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        // set status mặc định
        $data['status'] = 'Ngưng Hoạt Động';
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Nhà Cung Cấp Đã Ngưng Hoạt Động');
    }

    public function update_status_2(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        // set status mặc định
        $data['status'] = 'Đang Hoạt Động';
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Nhà Cung Cấp Đã Ngưng Hoạt Động');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Kiểm tra trạng thái
        if ($supplier->status === 'Đang Hoạt Động') {
            return redirect()->route('suppliers.index')
                ->with('error', 'Không thể xóa nhà cung cấp đang hoạt động.');
        }

        // Xóa mềm
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Xóa nhà cung cấp thành công (đã lưu trong thùng rác).');
    }
    public function trash()
    {
        $suppliers = Supplier::onlyTrashed()->paginate(10);
        $users = User::all();

        return view('admin.supplier.trash', compact('suppliers','users'));
    }

    public function restore($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->restore();

        return redirect()->route('suppliers.trash')
            ->with('success', 'Khôi phục nhà cung cấp thành công.');
    }

    // Xóa vĩnh viễn nhà cung cấp
    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->forceDelete();

        return redirect()->route('suppliers.trash')
            ->with('success', 'Đã xóa vĩnh viễn nhà cung cấp.');
    }
}
