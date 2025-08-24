<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
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

        // Doanh thu theo ngày trong tháng hiện tại
        $dailyRevenue = [];
        $daysInMonth = Carbon::now()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $revenue = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $i)
                ->sum('total');

            $dailyRevenue[] = [
                'day' => $i,
                'revenue' => (float)$revenue
            ];
        }

        // Doanh thu theo năm (5 năm gần nhất)
        $yearlyRevenue = [];
        for ($i = $year - 4; $i <= $year; $i++) {
            $revenue = Order::whereYear('created_at', $i)->sum('total');
            $yearlyRevenue[] = [
                'year' => $i,
                'revenue' => (float)$revenue
            ];
        }

        // Tổng tồn kho
        $totalInventory = ProductVariant::sum('stock');

        // Danh sách tồn kho (có thể dùng cho thống kê chi tiết sau này)
        $inventoryList = ProductVariant::with('product:id,name')->get();

        // Đơn hàng mới nhất
        $latestOrders = Order::with('user')->orderByDesc('created_at')->take(8)->get();

        // Lợi nhuận thực tế theo tháng (doanh thu - giá vốn)
        $profitMonth = OrderDetail::with(['product', 'variant'])
            ->whereHas('order', function ($q) use ($month, $year) {
                $q->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->where('status', 'delivered'); // chỉ tính đơn đã giao
            })
            ->get()
            ->sum(function ($detail) {
                // Lấy giá vốn
                if ($detail->variant_id && $detail->variant) {
                    $cost = $detail->variant->import_price * $detail->quantity;
                } elseif ($detail->product) {
                    $cost = $detail->product->import_price * $detail->quantity;
                } else {
                    $cost = 0; // phòng trường hợp product bị xóa
                }

                // Doanh thu
                $revenue = $detail->price * $detail->quantity;

                return $revenue - $cost;
            });

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

        $oneWeekAgo = now()->subDays(7);

        $topSellingProducts = OrderDetail::with(['product' => function ($q) {
            $q->withTrashed()->select('id', 'name', 'image');
        }])
            ->whereHas('order', function ($query) use ($oneWeekAgo) {
                $query->where('status', 'delivered')
                    ->where('created_at', '>=', $oneWeekAgo);
            })
            ->select('product_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Doanh thu tháng này (tổng tiền khách trả)
        $revenueMonth = Order::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('total');

        // Tính giá vốn (cost of goods sold) từ order_details
        $costOfGoods = OrderDetail::with(['product', 'variant'])
            ->whereHas('order', function ($q) use ($month, $year) {
                $q->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->where('status', 'delivered'); // chỉ tính đơn đã giao
            })
            ->get()
            ->sum(function ($detail) {
                // Nếu có variant thì lấy import_price từ variant
                if ($detail->variant) {
                    return $detail->variant->import_price * $detail->quantity;
                }

                // Ngược lại lấy import_price từ product
                if ($detail->product) {
                    return $detail->product->import_price * $detail->quantity;
                }

                return 0;
            });

        // Lợi nhuận thực tế = Doanh thu - Giá vốn
        $netProfit = $revenueMonth - $costOfGoods;

        // Tổng chi phí = Giá vốn (ở đây coi giá vốn là chi phí chính)
        $totalExpenses = $costOfGoods;

        // Tổng thu nhập = Doanh thu
        $totalIncome = $revenueMonth;

        return view('admin.statistics.index', compact(
            'orderCountToday',
            'orderCountMonth',
            'orderCountYear',
            'monthlyRevenue',
            'dailyRevenue',
            'yearlyRevenue',
            'revenueToday',
            'revenueMonth',
            'revenueYear',
            'totalInventory',
            'inventoryList',
            'latestOrders',
            'monthlyRevenue',
            'orderStatusStats', // truyền thêm cho biểu đồ tròn
            'profitMonth',
            'topSellingProducts',
            'netProfit',
            'totalIncome',
            'totalExpenses',
        ));
    }
}
