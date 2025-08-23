<div class="col-xxl-4 col-12">
    <div class="row g-6">
        <!-- Card Phân bố trạng thái đơn hàng -->
        <div class="col-12">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Phân bố trạng thái đơn hàng</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="chart chart-sm mb-3" style="width: 100%; max-width: 300px;">
                        <canvas id="chartjs-doughnut"></canvas>
                    </div>
                    <table class="table table-sm w-100 mb-0">
                        <tbody>
                            <tr>
                                <td style="width: 24px;">
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
                                    <div class="badge" style="background-color:#20c997">&nbsp;</div>
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

        <!-- Card Tổng tồn kho -->
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Tổng tồn kho</h5>
                        <p class="mb-0 text-muted">Sản phẩm đơn và các biến thể</p>
                    </div>
                    <h3 class="mb-0">{{ $totalInventory }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
