@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Danh Sách Giá Trị Thuộc Tính: {{ $attribute->name }}</h2>
        <a href="{{ route('attribute_values.create', $attribute->id) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Giá Trị Mới
        </a>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bảng danh sách giá trị thuộc tính -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Giá Trị</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributeValues as $value)
                <tr>
                    <td>{{ $value->value }}</td>
                    <td class="text-center">
                        <a href="{{ route('attribute_values.edit', [$attribute->id, $value->id]) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('attribute_values.destroy', [$attribute->id, $value->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->

</div>
@endsection
