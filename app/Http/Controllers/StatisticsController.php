<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductVariant;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Đơn hàng
        $orderCountToday = Order::whereDate('created_at', $today)->count();
        $orderCountMonth = Order::whereMonth('created_at', $month)->count();
        $orderCountYear  = Order::whereYear('created_at', $year)->count();

        // Doanh thu
        $revenueToday = Order::whereDate('created_at', $today)->sum('total');
        $revenueMonth = Order::whereMonth('created_at', $month)->sum('total');
        $revenueYear  = Order::whereYear('created_at', $year)->sum('total');

        // Tổng tồn kho
        $totalInventory = ProductVariant::sum('stock');

        // Danh sách tồn kho (có thể dùng cho thống kê chi tiết sau này)
        $inventoryList = ProductVariant::with('product:id,name')->get();

        // Đơn hàng mới nhất
        $latestOrders = Order::with('user')->orderByDesc('created_at')->take(8)->get();

        // Doanh thu theo từng tháng trong năm hiện tại
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $i)
                ->sum('total');

            $monthlyRevenue[] = [
                'month' => $i,
                'revenue' => (float)$revenue
            ];
        }

        // Thống kê số lượng đơn hàng theo trạng thái (dùng cho biểu đồ tròn)
        $orderStatusStats = [
            'processing' => Order::where('status', 'processing')->count(),
            'confirmed'  => Order::where('status', 'confirmed')->count(),
            'shipping'   => Order::where('status', 'shipping')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'returned'   => Order::where('status', 'returned')->count(),
        ];

        return view('admin.statistics.index', compact(
            'orderCountToday',
            'orderCountMonth',
            'orderCountYear',
            'revenueToday',
            'revenueMonth',
            'revenueYear',
            'totalInventory',
            'inventoryList',
            'latestOrders',
            'monthlyRevenue',
            'orderStatusStats' // truyền thêm cho biểu đồ tròn
        ));
    }
}
