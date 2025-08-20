<!-- Báo cáo thu nhập -->
<div class="col-xxl-6 col-md-6">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title mb-0">
                <h5 class="mb-1">Báo cáo thu nhập</h5>
                <p class="card-subtitle">Tổng quan thu nhập tháng {{ \Carbon\Carbon::now()->format('m/Y') }}</p>
            </div>
            <div class="dropdown">
                <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-2 me-n1" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base ti tabler-dots-vertical icon-md text-body-secondary"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                    <a class="dropdown-item" href="javascript:void(0);">Tải xuống</a>
                    <a class="dropdown-item" href="javascript:void(0);">Làm mới</a>
                    <a class="dropdown-item" href="javascript:void(0);">Chia sẻ</a>
                </div>
            </div>
        </div>
        <div class="card-body pb-0">
            <ul class="p-0 m-0">
                <li class="d-flex align-items-center mb-5">
                    <div class="me-4">
                        <span class="badge bg-label-primary rounded p-1_5"><i class="icon-base ti tabler-chart-pie-2 icon-md"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Lợi nhuận ròng</h6>
                            <small class="text-body">{{ number_format($totalIncome, 0, ',', '.') }} doanh thu</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-4">
                            <small>{{ number_format($netProfit, 0, ',', '.') }}₫</small>
                        </div>
                    </div>
                </li>
                <li class="d-flex align-items-center mb-5">
                    <div class="me-4">
                        <span class="badge bg-label-success rounded p-1_5"><i class="icon-base ti tabler-currency-dollar icon-md"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Tổng thu nhập</h6>
                            <small class="text-body">Doanh thu tháng</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-4">
                            <small>{{ number_format($totalIncome, 0, ',', '.') }}₫</small>
                        </div>
                    </div>
                </li>
                <li class="d-flex align-items-center mb-5">
                    <div class="me-4">
                        <span class="badge bg-label-secondary text-body rounded p-1_5"><i class="icon-base ti tabler-credit-card icon-md"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Tổng chi phí</h6>
                            <small class="text-body">Quảng cáo, marketing...</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-4">
                            <small>{{ number_format($totalExpenses, 0, ',', '.') }}₫</small>
                        </div>
                    </div>
                </li>
            </ul>
            <div id="reportBarChart"></div>
        </div>
    </div>
</div>
<!--/ Earning Reports -->
