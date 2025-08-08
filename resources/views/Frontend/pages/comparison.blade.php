<!DOCTYPE html>
<html lang="en">
<head>
    @include('Frontend.partials.head')
    <title>So sánh sản phẩm - F1GENZ Shoes</title>
    <style>
        .comparison-table {
            overflow-x: auto;
            margin: 20px 0;
        }
        .comparison-table table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        .comparison-table th,
        .comparison-table td {
            border: 1px solid #e0e0e0;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }
        .comparison-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        .comparison-table .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }
        .comparison-table .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .comparison-table .product-price {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
        }
        .comparison-table .attribute-label {
            background-color: #f1f3f4;
            font-weight: 600;
            text-align: left;
            width: 200px;
        }
        .remove-product {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .remove-product:hover {
            background: #c82333;
        }
        .add-to-cart-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .add-to-cart-btn:hover {
            background: #218838;
        }
        .empty-comparison {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .empty-comparison img {
            width: 200px;
            opacity: 0.5;
            margin-bottom: 20px;
        }
        .clear-all-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .clear-all-btn:hover {
            background: #5a6268;
        }
        .comparison-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .rating {
            color: #ffc107;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .comparison-table {
                font-size: 14px;
            }
            .comparison-table .product-image {
                width: 80px;
                height: 80px;
            }
            .comparison-table th,
            .comparison-table td {
                padding: 10px 8px;
            }
        }
    </style>
</head>
<body>
    @include('Frontend.partials.header')
    
    <div class="container mt-4 mb-5">
        <div class="comparison-header">
            <h2>So sánh sản phẩm</h2>
            @if($products && $products->count() > 0)
                <button type="button" class="clear-all-btn" onclick="clearAllProducts()">
                    <i class="fas fa-trash"></i> Xóa tất cả
                </button>
            @endif
        </div>

        @if($products && $products->count() > 0)
            <div class="comparison-table">
                <table>
                    <thead>
                        <tr>
                            <th class="attribute-label">Sản phẩm</th>
                            @foreach($products as $product)
                                <th style="position: relative;">
                                    <button type="button" class="remove-product" 
                                            onclick="removeProduct({{ $product->id }})"
                                            style="position: absolute; top: 5px; right: 5px;">
                                        ×
                                    </button>
                                    <div class="product-image-wrapper">
                                        <img src="{{ $product->image ? asset($product->image) : asset('images/default.jpg') }}" 
                                             alt="{{ $product->name }}" class="product-image">
                                    </div>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
                                    
                                    @php
                                        $avgRating = $product->reviews->avg('rating') ?? 0;
                                        $reviewCount = $product->reviews->count();
                                    @endphp
                                    <div class="rating mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $avgRating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                        <small>({{ $reviewCount }} đánh giá)</small>
                                    </div>
                                    
                                    <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                        </button>
                                    </form>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Thương hiệu -->
                        <tr>
                            <td class="attribute-label">Thương hiệu</td>
                            @foreach($products as $product)
                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        
                        <!-- Danh mục -->
                        <tr>
                            <td class="attribute-label">Danh mục</td>
                            @foreach($products as $product)
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        
                        <!-- Mô tả -->
                        <tr>
                            <td class="attribute-label">Mô tả</td>
                            @foreach($products as $product)
                                <td style="text-align: left;">
                                    {{ Str::limit(strip_tags($product->description), 100) }}
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Trạng thái -->
                        <tr>
                            <td class="attribute-label">Trạng thái</td>
                            @foreach($products as $product)
                                <td>
                                    @if($product->status == 1)
                                        <span style="color: green;">✓ Còn hàng</span>
                                    @else
                                        <span style="color: red;">✗ Hết hàng</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Kích cỡ có sẵn -->
                        @if($products->first()->variants->isNotEmpty())
                        <tr>
                            <td class="attribute-label">Kích cỡ</td>
                            @foreach($products as $product)
                                <td>
                                    @php
                                        $sizes = $product->variants->flatMap(function($variant) {
                                            return $variant->attributeValues->where('attribute.name', 'Size');
                                        })->pluck('value')->unique();
                                    @endphp
                                    {{ $sizes->implode(', ') ?: 'N/A' }}
                                </td>
                            @endforeach
                        </tr>
                        @endif
                        
                        <!-- Màu sắc -->
                        @if($products->first()->variants->isNotEmpty())
                        <tr>
                            <td class="attribute-label">Màu sắc</td>
                            @foreach($products as $product)
                                <td>
                                    @php
                                        $colors = $product->variants->flatMap(function($variant) {
                                            return $variant->attributeValues->where('attribute.name', 'Color');
                                        })->pluck('value')->unique();
                                    @endphp
                                    {{ $colors->implode(', ') ?: 'N/A' }}
                                </td>
                            @endforeach
                        </tr>
                        @endif
                        
                        <!-- Ngày tạo -->
                        <tr>
                            <td class="attribute-label">Ngày thêm</td>
                            @foreach($products as $product)
                                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-comparison">
                <img src="{{ asset('images/empty-comparison.png') }}" alt="Chưa có sản phẩm so sánh" 
                     onerror="this.style.display='none'">
                <h4>Chưa có sản phẩm nào để so sánh</h4>
                <p>Hãy thêm ít nhất 2 sản phẩm để bắt đầu so sánh</p>
                <a href="{{ route('products.all') }}" class="add-to-cart-btn">
                    <i class="fas fa-search"></i> Khám phá sản phẩm
                </a>
            </div>
        @endif
    </div>

    @include('Frontend.partials.footer')
    @include('Frontend.partials.scrip')
    
    <script>
        function removeProduct(productId) {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách so sánh?')) {
                fetch('/comparison/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                });
            }
        }

        function clearAllProducts() {
            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi danh sách so sánh?')) {
                fetch('/comparison/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                });
            }
        }
    </script>
</body>
</html> 