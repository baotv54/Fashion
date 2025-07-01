@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Biến thể của sản phẩm: <span class="text-primary">{{ $product->name }}</span></h3>
        <a href="{{ route('product_variants.create', $product->id) }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Biến Thể
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Thuộc tính</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($variants as $variant)
                    <tr>
                        <td class="text-center">
                            <img src="{{ asset($variant->image) }}" alt="Ảnh biến thể" class="rounded border shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td class="text-end">{{ number_format($variant->price) }}₫</td>
                        <td class="text-center">{{ $variant->stock }}</td>
                        <td>
                            @foreach ($variant->attributeValues as $value)
                                <span class="badge bg-secondary me-1">
                                    {{ $value->attributeValue->value ?? 'N/A' }}
                                </span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="{{ route('product_variants.edit', [$product->id, $variant->id]) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('product_variants.destroy', [$product->id, $variant->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa biến thể này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có biến thể nào cho sản phẩm này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>
@endpush
@endsection
