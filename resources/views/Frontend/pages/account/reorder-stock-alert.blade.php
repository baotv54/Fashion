@if(Session::has('reorder_stock_info'))
@php
    $stockInfo = Session::get('reorder_stock_info');
    $isPartialSuccess = Session::has('reorder_partial_success');
@endphp

<!-- Modal -->
<div class="modal fade" id="reorderStockModal" tabindex="-1" aria-labelledby="reorderStockLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header 
          {{ $isPartialSuccess ? 'bg-warning text-dark' : 'bg-danger text-white' }}">
        <h5 class="modal-title" id="reorderStockLabel">
          @if($isPartialSuccess)
              <i class="fas fa-shopping-cart me-2"></i> Mua lại đơn hàng một phần
          @else
              <i class="fas fa-ban me-2"></i> Không thể mua lại đơn hàng
          @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      
      <div class="modal-body">
        {{-- Hết hàng --}}
        @if(!empty($stockInfo['out_of_stock']))
          <div class="stock-section mb-3">
            <h6 class="text-danger mb-2">
              <i class="fas fa-times-circle me-2"></i>Sản phẩm đã hết hàng:
            </h6>
            <ul class="list-unstyled ms-3">
              @foreach($stockInfo['out_of_stock'] as $item)
                <li class="mb-1">
                  <span class="badge bg-danger me-2">Hết hàng</span>
                  <strong>{{ $item['name'] }}</strong>
                  @if(isset($item['requested']))
                    <small class="text-muted">(Yêu cầu: {{ $item['requested'] }})</small>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Không đủ hàng --}}
        @if(!empty($stockInfo['insufficient_stock']))
          <div class="stock-section mb-3">
            <h6 class="text-warning mb-2">
              <i class="fas fa-exclamation-triangle me-2"></i>Sản phẩm không đủ số lượng:
            </h6>
            <ul class="list-unstyled ms-3">
              @foreach($stockInfo['insufficient_stock'] as $item)
                <li class="mb-1">
                  <span class="badge bg-warning text-dark me-2">Không đủ</span>
                  <strong>{{ $item['name'] }}</strong>
                  <small class="text-muted">
                    (Yêu cầu: <strong>{{ $item['requested'] }}</strong>, 
                    Còn lại: <strong class="text-warning">{{ $item['available'] }}</strong>)
                  </small>
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Thêm vào giỏ thành công --}}
        @if($stockInfo['available_items'] > 0)
          <div class="stock-section">
            <div class="alert alert-success py-2 px-3 mb-0">
              <i class="fas fa-check-circle me-2"></i>
              <strong>{{ $stockInfo['available_items'] }}</strong> sản phẩm đã được thêm vào giỏ hàng thành công!
              <a href="{{ route('cart.index') }}" class="btn btn-success btn-sm ms-2">
                <i class="fas fa-shopping-cart me-1"></i> Xem giỏ hàng
              </a>
            </div>
          </div>
        @endif

        {{-- Gợi ý nếu fail hoàn toàn --}}
        @if(!$isPartialSuccess)
          <div class="mt-3">
            <p class="mb-2"><strong>Gợi ý:</strong></p>
            <ul class="mb-0">
              <li>Kiểm tra lại sau khi cửa hàng nhập thêm hàng</li>
              <li>Tìm kiếm các sản phẩm tương tự</li>
              <li>Liên hệ với chúng tôi để được hỗ trợ</li>
            </ul>
          </div>
        @endif
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<style>
.stock-section {
  background: #fafafa;
  padding: 15px;
  border-radius: 8px;
  border: 1px solid rgba(0,0,0,0.08);
}
.stock-section h6 {
  font-weight: 600;
  font-size: 0.95rem;
}
.stock-section li {
  padding: 5px 0;
  border-bottom: 1px solid rgba(0,0,0,0.05);
}
.stock-section li:last-child {
  border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const reorderModal = new bootstrap.Modal(document.getElementById('reorderStockModal'));
  reorderModal.show();

  // Tự động ẩn popup sau 15 giây
  setTimeout(() => {
    reorderModal.hide();
  }, 15000);
});
</script>

@endif
