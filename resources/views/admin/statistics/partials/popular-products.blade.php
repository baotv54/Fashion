<!-- Sản phẩm nổi bật -->
<div class="col-xxl-6 col-md-6">
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
                <h5 class="mb-1">Sản phẩm nổi bật</h5>
                <p class="card-subtitle">Top 5 sản phẩm bán chạy trong tuần</p>
            </div>
        </div>
        <div class="card-body">
            <ul class="p-0 m-0">
                @forelse ($topSellingProducts as $product)
                @if($product->product) <!-- kiểm tra sản phẩm tồn tại -->
                <li class="d-flex mb-6">
                    <div class="me-4">
                        <img
                            src="{{ $product->product->image ? asset($product->product->image) : 'https://via.placeholder.com/46' }}"
                            alt="{{ $product->product->name }}"
                            class="rounded"
                            width="46" />
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">{{ $product->product->name }}</h6>
                            <small class="text-body d-block">Item: #{{ $product->product_id }}</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-1">
                            <p class="mb-0">{{ number_format($product->total_sold) }} sản phẩm bán ra</p>
                        </div>
                    </div>
                </li>
                @endif
                @empty
                <li class="text-center text-muted">Chưa có sản phẩm bán chạy</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
<!--/ Popular Product -->