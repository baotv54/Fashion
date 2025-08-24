@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="card shadow">
    <div class="card-body p-4">

        <h5 class="mb-3">Chọn nhiều sản phẩm</h5>

        <!-- Ô tìm kiếm -->
        <form method="GET" action="{{ route('warehouse.product') }}" class="mb-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i data-feather="search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Tìm kiếm theo tên, mã SKU, Barcode sản phẩm..."
                    id="product-search"
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">Tìm</button>
            </div>
        </form>

        <!-- Form chọn sản phẩm -->
        <form action="{{ route('warehouse.store') }}" method="POST">
            @csrf

            <!-- Danh sách sản phẩm -->
            <div style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle">
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr>
                            <td style="width: 40px;">
                                <input type="checkbox" name="selected[]" value="{{ $index }}">
                            </td>
                            <td style="width: 70px;">
                                <img src="{{ asset($item['product']->image) }}" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $item['product']->name }}</strong>
                                @if($item['is_variant'] && $item['variant'])
                                - {{ $item['variant']->name }}
                                @endif
                                <br>
                                <small class="text-muted">
                                    SKU: {{ $item['variant']->sku ?? $item['product']->slug }}
                                </small>

                                <!-- Hidden inputs -->
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item['product']->id }}">
                                <input type="hidden" name="items[{{ $index }}][variant_id]" value="{{ $item['variant']->id ?? '' }}">

                                @if($item['attributes']->count())
                                <br>
                                <small>
                                    @foreach($item['attributes'] as $attrVal)
                                    <span class="badge bg-success">
                                        {{ $attrVal->attributeValue->attribute->name ?? '' }}: {{ $attrVal->attributeValue->value ?? '' }}
                                    </span>
                                    @endforeach
                                </small>
                                @endif
                            </td>
                            <td class="text-end text-muted" style="white-space: nowrap;">
                                {{ number_format($item['is_variant'] && $item['variant'] ? ($item['variant']->import_price ?? 0) : ($item['product']->import_price ?? 0)) }} đ
                                <br>
                                <small>
                                    Có thể bán:
                                    {{ (!empty($item['is_variant']) && !empty($item['variant']))? ($item['variant']['stock'] ?? 0): ($item['product']['quantity'] ?? 0) }}

                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Không có sản phẩm nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('warehouse.index') }}" class="btn btn-outline-secondary">Hủy</a>
                <button class="btn btn-primary" type="submit">Áp dụng</button>
            </div>
        </form>
    </div>
</div>
@endsection
