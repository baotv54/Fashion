<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function index(Request $request)
    {
        $currentStatus = $request->input('status', 'all');

        $query = User::latest()->select('id', 'name', 'phone', 'avatar', 'password', 'email', 'role');

        if ($currentStatus !== 'all') {
            $query->where('role', $currentStatus);
        }

        $users = $query->paginate(10)->appends(['status' => $currentStatus]);

        $counts = [
            'all'    => User::count(),
            'admin'  => User::where('role', 'admin')->count(),
            'manage' => User::where('role', 'manage')->count(),
            'user'   => User::where('role', 'user')->count(),
        ];

        return view('admin.users.index', compact('users', 'counts', 'currentStatus'));
    }

    public function detail($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        return view('admin.users.detail', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validatedDate = $request->validate(
            [
                'name' => 'required|max:15',
                'phone' => 'nullable|max:15',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'role' => 'required|max:15',
            ]
        );
        $validatedDate['password'] = Hash::make($validatedDate['password']);
        User::create($validatedDate);
        return redirect()->route('users.index')->with('success', 'Tạo mới thành công');
    }
    //     public function edit($id)
    //     {
    //         $users = User::find($id);
    // <<<<<<< Hung
    //         return view('admin.users.edit', compact('users'));
    // =======
    //         return view('admin.users.create', compact('users'));
    // >>>>>>> main
    //     }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([

            // 'name' => 'nullable|max:155' . $id,
            // 'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            // 'password' => 'nullable|min:8',
            'role' => 'required|max:255',
        ]);
        $users = User::findOrFail($id);

        $users->update([
            // 'name' => $validatedData['name'],
            // 'email' => $validatedData['email'],
            // 'password' => $validatedData['password'] ?? $users-> password,
            'role' => $validatedData['role'],

        ]);
        return redirect()->route('users.index')->with('success', 'User đã được cập nhật!');
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User không tồn tại.');
        }

        // Nếu là admin → kiểm tra còn bao nhiêu admin
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();

            if ($adminCount <= 1) {
                return redirect()->route('users.index')->with('error', 'Không thể xóa admin cuối cùng.');
            }
        }

        // ✅ Kiểm tra đơn hàng của user
        $hasActiveOrders = $user->orders()
            ->whereNotIn('status', ['delivered', 'cancelled'])
            ->exists();

        if ($hasActiveOrders) {
            return redirect()->route('users.index')->with('error', 'User còn đơn hàng đang hoạt động, không thể xóa.');
        }

        // 👉 Xóa mềm
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User đã bị xóa (soft delete).');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->paginate(10); // chỉ lấy user đã soft delete
        return view('admin.users.trashed', compact('users'));
    }

    // Khôi phục user
    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return redirect()->route('users.trashed')->with('error', 'User không tồn tại trong thùng rác.');
        }

        $user->restore();

        return redirect()->route('users.trashed')->with('success', 'User đã được khôi phục thành công.');
    }

    // Xóa vĩnh viễn user
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return redirect()->route('users.trashed')
                ->with('error', 'User không tồn tại trong thùng rác.');
        }

        foreach ($user->orders as $order) {
            // Xóa order details
            $order->orderDetails()->delete();

            // Xóa order
            $order->delete();
        }

        // Xóa user
        $user->forceDelete();

        return redirect()->route('users.trashed')
            ->with('success', 'User và các đơn hàng đã bị xóa vĩnh viễn.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Lấy tất cả đơn hàng của user
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        
        // Lọc đơn hàng theo trạng thái thực tế trong database
        $completedOrders = $orders->where('status', 'delivered'); // Đơn thành công = delivered
        $pendingOrders = $orders->whereIn('status', ['ordered', 'processing', 'confirmed', 'shipping']); // Đơn chờ xử lý
        $cancelledOrders = $orders->where('status', 'cancelled'); // Đơn đã hủy
        
        // Thống kê
        $stats = [
            'total_orders' => $orders->count(),
            'completed_orders' => $completedOrders->count(),
            'pending_orders' => $pendingOrders->count(),
            'cancelled_orders' => $cancelledOrders->count(),
            'total_spent' => $completedOrders->sum('total_amount'),
        ];
        
        return view('admin.users.show', compact('user', 'orders', 'completedOrders', 'pendingOrders', 'cancelledOrders', 'stats'));
    }
}
