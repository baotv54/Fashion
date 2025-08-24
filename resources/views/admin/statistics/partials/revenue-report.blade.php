<!-- Revenue Report -->
<div class="col-xxl-8">
    <div class="card h-100">
        <div class="card-body p-0">
            <div class="row row-bordered g-0">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Doanh thu</h5>
                        <select id="revenue-type" class="form-select w-auto">
                            <option value="day">Theo ngày</option>
                            <option value="month" selected>Theo tháng</option>
                            <option value="year">Theo năm</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="revenue-chart" height="530"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!--/ Revenue Report -->