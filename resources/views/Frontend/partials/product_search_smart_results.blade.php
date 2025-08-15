<div class="search-smart-result">
    @if($products->count() > 0)
        <div class="search-smart-title">Sản phẩm ({{ $products->count() }})</div>
        @foreach($products as $product)
            <div class="search-smart-item">
                <a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
                    <img class="search-smart-thumb" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    <span class="search-smart-name">{{ $product->name }}</span>
                </a>
            </div>
        @endforeach
    @else
        <p class="text-center">Không tìm thấy sản phẩm nào.</p>
    @endif
</div> 