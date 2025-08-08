@if($suggestions->count() > 0)
    @foreach($suggestions as $product)
    <div class="search-suggestion-item" onclick="window.location.href='{{ route('product.show', $product->id) }}'">
        <div class="search-suggestion-image">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="40" height="40">
        </div>
        <div class="search-suggestion-content">
            <div class="search-suggestion-name">{{ $product->name }}</div>
            <div class="search-suggestion-price">{{ number_format($product->price) }}₫</div>
            @if($product->brand)
            <div class="search-suggestion-brand">{{ $product->brand->name }}</div>
            @endif
        </div>
    </div>
    @endforeach
    
    <div class="search-suggestion-more">
        <a href="/search?type=product&q={{ urlencode($query) }}">
            Xem tất cả kết quả cho "{{ $query }}" →
        </a>
    </div>
@else
    <div class="search-suggestion-empty">
        <div class="search-suggestion-empty-text">Không tìm thấy sản phẩm nào</div>
        <div class="search-suggestion-empty-subtext">Hãy thử từ khóa khác</div>
    </div>
@endif

<style>
.search-suggestion-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-suggestion-item:hover {
    background-color: #f8f9fa;
}

.search-suggestion-image {
    margin-right: 12px;
}

.search-suggestion-image img {
    border-radius: 4px;
    object-fit: cover;
}

.search-suggestion-content {
    flex: 1;
}

.search-suggestion-name {
    font-weight: 500;
    color: #333;
    margin-bottom: 4px;
    font-size: 14px;
    line-height: 1.3;
}

.search-suggestion-price {
    color: #e74c3c;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 2px;
}

.search-suggestion-brand {
    color: #666;
    font-size: 12px;
}

.search-suggestion-more {
    padding: 12px 15px;
    border-top: 1px solid #e0e0e0;
    background-color: #f8f9fa;
}

.search-suggestion-more a {
    color: #007bff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
}

.search-suggestion-more a:hover {
    text-decoration: underline;
}

.search-suggestion-empty {
    padding: 20px;
    text-align: center;
}

.search-suggestion-empty-text {
    color: #666;
    font-size: 14px;
    margin-bottom: 4px;
}

.search-suggestion-empty-subtext {
    color: #999;
    font-size: 12px;
}
</style> 