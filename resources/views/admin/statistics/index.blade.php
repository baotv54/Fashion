@extends('layouts.admin')

@section('content')
<div class="row g-6">
    <!-- Doanh số bán hàng -->
    <div class="col-xl-4">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-7">
                    <div class="card-body text-nowrap">
                        <h5 class="card-title mb-0">Chúc mừng! 🎉</h5>
                        <p class="mb-2">Lợi nhuận trong tháng</p>
                        <h4 class="text-primary mb-1">{{ number_format($revenueMonth, 0, ',', '.') }}₫</h4>
                    </div>
                </div>
                <div class="col-5 text-center">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="https://demos.pixinvent.com/vuexy-html-admin-template/assets/img/illustrations/card-advance-sale.png" height="140" alt="Doanh số bán hàng" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="col-xl-8 col-md-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Thống kê</h5>
            </div>
            <div class="card-body d-flex align-items-end">
                <div class="w-100">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-primary me-4 p-2">
                                    <i class="icon-base ti tabler-chart-pie-2 icon-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ number_format($orderCountMonth) }}</h5>
                                    <small>Đơn hàng trong tháng</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-info me-4 p-2">
                                    <i class="icon-base ti tabler-users icon-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ number_format($orderCountYear) }}</h5>
                                    <small>Đơn hàng trong năm</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-danger me-4 p-2">
                                    <i class="icon-base ti tabler-shopping-cart icon-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $orderCountToday }}</h5>
                                    <small>Đơn hàng trong ngày</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded bg-label-success me-4 p-2">
                                    <i class="icon-base ti tabler-currency-dollar icon-lg"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ number_format($revenueToday, 0, ',', '.') }}₫</h5>
                                    <small>Doanh thu trong ngày</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Biểu đồ Profit / Expenses / Revenue có thể giữ nguyên -->
    @include('admin.statistics.partials.profit-expenses')
    @include('admin.statistics.partials.revenue-report')
    @include('admin.statistics.partials.earning-report')
    @include('admin.statistics.partials.popular-products')
    @include('admin.statistics.partials.orders-table')
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

        const monthlyData = @json($monthlyRevenue);
        const orderStatusData = @json($orderStatusStats);

        const dailyRevenue = @json($dailyRevenue);
        const monthlyRevenue = @json($monthlyRevenue);
        const yearlyRevenue = @json($yearlyRevenue);

        let ctx = document.getElementById("revenue-chart").getContext("2d");
        let chart;

        let chartData = Array(12).fill(0);
        let labels = [];

        for (let i = 1; i <= 12; i++) {
            labels.push('Tháng ' + i);
            const found = monthlyData.find(item => parseInt(item.month) === i);
            if (found) {
                chartData[i - 1] = parseFloat(found.revenue) || 0;
            }
        }

        function renderChart(type) {
            let labels = [],
                data = [];

            if (type === "day") {
                labels = dailyRevenue.map(d => "Ngày " + d.day);
                data = dailyRevenue.map(d => d.revenue);
            } else if (type === "month") {
                labels = monthlyRevenue.map(m => "Tháng " + m.month);
                data = monthlyRevenue.map(m => m.revenue);
            } else {
                labels = yearlyRevenue.map(y => "Năm " + y.year);
                data = yearlyRevenue.map(y => y.revenue);
            }

            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Doanh thu",
                        backgroundColor: "#dc3545",
                        data: data
                    }]
                },
                options: {
                    maintainAspectRatio: false,
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
                        }]
                    }
                }
            });
        }

        document.getElementById("revenue-type").addEventListener("change", function(e) {
            renderChart(e.target.value);
        });

        renderChart("month"); // mặc định theo tháng

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