@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Thống kê</strong> tổng quan</h1>

    <!-- Tổng quan nhanh -->
    <div class="row">
        <div class="col-xl-6 col-xxl-5 d-flex">
            <div class="w-100">
                <div class="row g-3">
                    <!-- Đơn hàng hôm nay -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Đơn hàng hôm nay</h5>
                                    <i class="text-primary" data-feather="truck"></i>
                                </div>
                                <h1 class="mt-2 mb-3">{{ $orderCountToday }}</h1>
                                <small class="text-muted">Hôm nay</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tổng tồn kho -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Tổng tồn kho</h5>
                                    <i class="text-primary" data-feather="layers"></i>
                                </div>
                                <h1 class="mt-2 mb-3">{{ $totalInventory }}</h1>
                                <small class="text-muted">Sản phẩm các biến thể</small>
                            </div>
                        </div>
                    </div>

                    <!-- Doanh thu hôm nay -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Doanh thu hôm nay</h5>
                                    <i class="text-primary" data-feather="dollar-sign"></i>
                                </div>
                                <h1 class="mt-2 mb-3">{{ number_format($revenueToday, 0, ',', '.') }}₫</h1>
                                <small class="text-muted">Hôm nay</small>
                            </div>
                        </div>
                    </div>

                    <!-- Đơn hàng trong tháng -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Đơn hàng tháng</h5>
                                    <i class="text-primary" data-feather="shopping-cart"></i>
                                </div>
                                <h1 class="mt-2 mb-3">{{ $orderCountMonth }}</h1>
                                <small class="text-muted">Trong tháng này</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ doanh thu theo tháng -->
        <div class="col-xl-6 col-xxl-7">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Doanh thu theo tháng</h5>
                </div>
                <div class="card-body py-3">
                    <div class="chart chart-sm">
                        <canvas id="chartjs-dashboard-bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ xu hướng & phân bố -->
    <div class="row mt-4">
        <!-- Xu hướng doanh thu và đơn hàng -->
        <div class="col-12 col-lg-8">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Xu hướng doanh thu và đơn hàng</h5>
                </div>
                <div class="card-body pt-2 pb-3">
                    <div class="chart chart-md">
                        <canvas id="chartjs-line"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ phân bố trạng thái đơn hàng -->
        <div class="col-12 col-lg-4">
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">Phân bố trạng thái đơn hàng</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="chart chart-sm mb-3">
                        <canvas id="chartjs-doughnut"></canvas>
                    </div>
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <td><div class="badge bg-info">&nbsp;</div></td>
                                <td>Đang xử lý</td>
                                <td class="text-end">{{ $orderStatusStats['processing'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><div class="badge bg-success">&nbsp;</div></td>
                                <td>Đã xác nhận</td>
                                <td class="text-end">{{ $orderStatusStats['confirmed'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><div class="badge bg-warning">&nbsp;</div></td>
                                <td>Đang giao hàng</td>
                                <td class="text-end">{{ $orderStatusStats['shipping'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><div class="badge bg-teal" style="background-color:#20c997">&nbsp;</div></td>
                                <td>Đã giao</td>
                                <td class="text-end">{{ $orderStatusStats['delivered'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><div class="badge bg-danger">&nbsp;</div></td>
                                <td>Đã hủy</td>
                                <td class="text-end">{{ $orderStatusStats['cancelled'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td><div class="badge bg-dark">&nbsp;</div></td>
                                <td>Trả hàng</td>
                                <td class="text-end">{{ $orderStatusStats['returned'] ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách đơn hàng gần đây -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Đơn hàng gần đây</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th class="d-none d-xl-table-cell">Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th class="d-none d-xl-table-cell">Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'Khách' }}</td>
                                <td class="d-none d-xl-table-cell">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                                <td>
                                    @php
                                        $statusLabels = [
                                            'processing' => ['text' => 'Đang xử lý', 'class' => 'info'],
                                            'confirmed'  => ['text' => 'Đã xác nhận', 'class' => 'success'],
                                            'shipping'   => ['text' => 'Đang giao', 'class' => 'warning'],
                                            'delivered'  => ['text' => 'Đã giao', 'class' => 'success'],
                                            'cancelled'  => ['text' => 'Đã hủy', 'class' => 'danger'],
                                            'returned'   => ['text' => 'Trả hàng', 'class' => 'dark'],
                                        ];
                                        $status = $statusLabels[$order->status] ?? ['text' => 'Không xác định', 'class' => 'secondary'];
                                    @endphp
                                    <span class="badge bg-{{ $status['class'] }}">{{ $status['text'] }}</span>
                                </td>
                                <td class="d-none d-xl-table-cell">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-info">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const primaryColor = "#3B7DDD";
        const infoColor    = "#0dcaf0";
        const successColor = "#28a745";
        const warningColor = "#ffc107";
        const dangerColor  = "#dc3545";
        const darkColor    = "#343a40";
        const tealColor    = "#20c997";

        const monthlyData = {!! json_encode($monthlyRevenue) !!};
        const orderStatusData = {!! json_encode($orderStatusStats) !!};

        let chartData = Array(12).fill(0);
        let labels = [];

        for (let i = 1; i <= 12; i++) {
            labels.push('Tháng ' + i);
            const found = monthlyData.find(item => parseInt(item.month) === i);
            if (found) {
                chartData[i - 1] = parseFloat(found.revenue) || 0;
            }
        }

        // --- Biểu đồ cột: Doanh thu theo tháng ---
        const barCtx = document.getElementById("chartjs-dashboard-bar");
        if (barCtx) {
            new Chart(barCtx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Doanh thu",
                        backgroundColor: primaryColor,
                        borderColor: primaryColor,
                        data: chartData
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: { display: false },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND',
                                    maximumFractionDigits: 0
                                }).format(tooltipItem.yLabel);
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1_000_000) {
                                        return (value / 1_000_000).toLocaleString('vi-VN') + ' Tr';
                                    }
                                    return value.toLocaleString('vi-VN');
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: { color: "transparent" }
                        }]
                    }
                }
            });
        }

        // --- Biểu đồ đường: Xu hướng doanh thu + đơn hàng ---
        const lineCtx = document.getElementById("chartjs-line");
        if (lineCtx) {
            new Chart(lineCtx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Doanh thu (triệu)",
                        fill: true,
                        backgroundColor: "rgba(59, 125, 221, 0.1)",
                        borderColor: primaryColor,
                        data: chartData.map(val => val / 1_000_000)
                    }, {
                        label: "Đơn hàng",
                        fill: true,
                        backgroundColor: "transparent",
                        borderColor: "#adb5bd",
                        borderDash: [4, 4],
                        data: [45, 32, 38, 24, 33, 26, 21, 20, 36, 35, 39, 28] // Có thể dynamic sau
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                if (tooltipItem.datasetIndex === 0) {
                                    return 'Doanh thu: ' + tooltipItem.yLabel.toLocaleString('vi-VN') + ' triệu';
                                }
                                return 'Đơn hàng: ' + tooltipItem.yLabel;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{ ticks: { beginAtZero: true } }],
                        xAxes: [{ gridLines: { color: "rgba(0,0,0,0.05)" } }]
                    }
                }
            });
        }

        // --- Biểu đồ tròn: Phân bố trạng thái đơn hàng ---
        const doughnutCtx = document.getElementById("chartjs-doughnut");
        if (doughnutCtx) {
            new Chart(doughnutCtx, {
                type: "doughnut",
                data: {
                    labels: [
                        "Đang xử lý",
                        "Đã xác nhận",
                        "Đang giao hàng",
                        "Đã giao",
                        "Đã hủy",
                        "Trả hàng"
                    ],
                    datasets: [{
                        data: [
                            orderStatusData.processing || 0,
                            orderStatusData.confirmed || 0,
                            orderStatusData.shipping || 0,
                            orderStatusData.delivered || 0,
                            orderStatusData.cancelled || 0,
                            orderStatusData.returned || 0
                        ],
                        backgroundColor: [
                            infoColor,    // Đang xử lý
                            successColor, // Đã xác nhận
                            warningColor, // Đang giao
                            tealColor,    // Đã giao
                            dangerColor,  // Đã hủy
                            darkColor     // Trả hàng
                        ],
                        borderColor: "transparent"
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 65,
                    legend: { display: false },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                return data.labels[tooltipItem.index] + ': ' +
                                    data.datasets[0].data[tooltipItem.index] + ' đơn';
                            }
                        }
                    }
                }
            });
        }
    });
</script>
