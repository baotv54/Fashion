@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Biến thể của sản phẩm: {{ $product->name }}</h2>
    <a href="{{ route('product_variants.create', $product->id) }}" class="btn btn-primary mb-3">Thêm biến thể</a>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thuộc tính</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($variants as $variant)
            <tr>
                <td><img src="{{ asset($variant->image) }}" width="60"></td>
                <td>{{ number_format($variant->price) }}₫</td>
                <td>{{ $variant->stock }}</td>
                <td>
                    @foreach ($variant->attributeValues as $value)
                    <span class="badge bg-secondary">
                        {{ $value->attributeValue->value ?? 'N/A' }}
                    </span>
                    @endforeach
                </td>

                <td>
                    <a href="{{ route('product_variants.edit', [$product->id, $variant->id]) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('product_variants.destroy', [$product->id, $variant->id]) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection