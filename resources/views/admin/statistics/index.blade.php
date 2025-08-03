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
                                <td>
                                    <div class="badge bg-info">&nbsp;</div>
                                </td>
                                <td>Đang xử lý</td>
                                <td class="text-end">{{ $orderStatusStats['processing'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge bg-success">&nbsp;</div>
                                </td>
                                <td>Đã xác nhận</td>
                                <td class="text-end">{{ $orderStatusStats['confirmed'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge bg-warning">&nbsp;</div>
                                </td>
                                <td>Đang giao hàng</td>
                                <td class="text-end">{{ $orderStatusStats['shipping'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge bg-teal" style="background-color:#20c997">&nbsp;</div>
                                </td>
                                <td>Đã giao</td>
                                <td class="text-end">{{ $orderStatusStats['delivered'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge bg-danger">&nbsp;</div>
                                </td>
                                <td>Đã hủy</td>
                                <td class="text-end">{{ $orderStatusStats['cancelled'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="badge bg-dark">&nbsp;</div>
                                </td>
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
                                <th></th>
                                <th>Mã đơn</th>
                                <th>Ngày</th>
                                <th>Khách hàng</th>
                                <th>Trạng thái</th>
                                <th>Phương thức</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestOrders as $order)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" title="Chi tiết đơn hàng">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal Chi tiết đơn hàng -->
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết đơn hàng: #{{ $order->order_code }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered mb-4">
                                                        <tr>
                                                            <th>Người đặt</th>
                                                            <td>{{ $order->user->name ?? 'Khách vãng lai' }}
                                                                <br>
                                                                <small>{{ $order->email }}</small>
                                                                <br>
                                                                <small>{{$order->phone}}</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ngày đặt</th>
                                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Trạng thái</th>
                                                            <td>
                                                                @php
                                                                $map = [
                                                                'ordered' => 'Đã đặt',
                                                                'processing' => 'Đang xử lý',
                                                                'confirmed' => 'Đã xác nhận',
                                                                'shipping' => 'Đang giao',
                                                                'delivered' => 'Đã giao',
                                                                'cancelled' => 'Đã hủy',
                                                                'returned' => 'Trả hàng',
                                                                ];
                                                                @endphp
                                                                <span class="badge bg-label-{{ $order->status == 'cancelled' ? 'danger' : 'primary' }}">
                                                                    {{ $map[$order->status] ?? 'Không xác định' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phương thức thanh toán</th>
                                                            <td>{{ ucfirst($order->payment_method) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tổng tiền</th>
                                                            <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hành động</th>
                                                            <td>
                                                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @php
                                                                    $nextStatus = [
                                                                    'ordered' => 'processing',
                                                                    'processing' => 'confirmed',
                                                                    'confirmed' => 'shipping',
                                                                    'shipping' => 'delivered',
                                                                    ];

                                                                    $statusLabel = [
                                                                    'ordered' => 'Đang xử lý',
                                                                    'processing' => 'Đã xác nhận',
                                                                    'confirmed' => 'Đang giao hàng',
                                                                    'shipping' => 'Đã giao',
                                                                    ];

                                                                    $current = $order->status;
                                                                    @endphp

                                                                    @if (array_key_exists($current, $nextStatus))
                                                                    <input type="hidden" name="status" value="{{ $nextStatus[$current] }}">
                                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                                        Cập nhật: {{ $statusLabel[$current] }}
                                                                    </button>
                                                                    @elseif ($current === 'delivered')
                                                                    <span class="badge bg-label-success">Đã hoàn tất</span>
                                                                    @elseif ($current === 'cancelled')
                                                                    <span class="badge bg-label-danger">Đã hủy</span>
                                                                    @elseif ($current === 'returned')
                                                                    <span class="badge bg-label-warning">Trả hàng</span>
                                                                    @else
                                                                    <span class="badge bg-label-secondary">Không xác định</span>
                                                                    @endif
                                                                </form>
                                                            </td>
                                                    </table>

                                                    <h6 class="mb-3">Danh sách sản phẩm:</h6>
                                                    <table class="table table-sm table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th>Biến thể</th>
                                                                <th>Giá</th>
                                                                <th>Số lượng</th>
                                                                <th>Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->orderDetails as $detail)
                                                            <tr>
                                                                <td>{{ $detail->product_name }}</td>
                                                                <td>{{ $detail->variation_name ?? 'Mặc định' }}</td>
                                                                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $detail->quantity }}</td>
                                                                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="text-end">
                                                        <strong>Tổng cộng: {{ number_format($order->total, 0, ',', '.') }} VNĐ</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="{{ route('orders.details', $order->id) }}"><span>#{{ $order->order_code }}</span></a></td>
                                <td><span class="text-nowrap">{{ $order->created_at->format('d/m/Y, H:i') }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center order-name text-nowrap">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($order->user->name ?? 'K', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="m-0">
                                                <a href="#" class="text-heading">{{ $order->user->name ?? 'Khách vãng lai' }}</a>
                                            </h6>
                                            <small>{{ $order->email }}</small>
                                            <small>{{$order->phone}}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $map = [
                                    'ordered' => ['text' => 'Đã đặt', 'color' => 'primary'],
                                    'processing' => ['text' => 'Đang xử lý', 'color' => 'info'],
                                    'confirmed' => ['text' => 'Đã xác nhận', 'color' => 'success'],
                                    'shipping' => ['text' => 'Đang giao', 'color' => 'warning'],
                                    'delivered' => ['text' => 'Đã giao', 'color' => 'success'],
                                    'cancelled' => ['text' => 'Đã hủy', 'color' => 'danger'],
                                    ];
                                    $status = $map[$order->status] ?? ['text' => 'Không xác định', 'color' => 'secondary'];
                                    @endphp
                                    <span class="badge px-2 bg-label-{{ $status['color'] }}">
                                        {{ $status['text'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="ms-1">{{ ucfirst($order->payment_method) }}</span>
                                    </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const primaryColor = "#3B7DDD";
        const infoColor = "#0dcaf0";
        const successColor = "#28a745";
        const warningColor = "#ffc107";
        const dangerColor = "#dc3545";
        const darkColor = "#343a40";
        const tealColor = "#20c997";

        const monthlyData = {
            !!json_encode($monthlyRevenue) !!
        };
        const orderStatusData = {
            !!json_encode($orderStatusStats) !!
        };

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
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
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
                            gridLines: {
                                color: "transparent"
                            }
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
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0,0,0,0.05)"
                            }
                        }]
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
                            infoColor, // Đang xử lý
                            successColor, // Đã xác nhận
                            warningColor, // Đang giao
                            tealColor, // Đã giao
                            dangerColor, // Đã hủy
                            darkColor // Trả hàng
                        ],
                        borderColor: "transparent"
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutoutPercentage: 65,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
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
