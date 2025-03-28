@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-3">Danh sách sản phẩm</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Thêm sản phẩm</a>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price) }} VND</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                <td>
                    @foreach($product->images as $image)
                    <img src="{{ asset($image->image_path) }}" alt="Ảnh sản phẩm" width="150" class="border rounded">
                    @endforeach
                </td>

                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection