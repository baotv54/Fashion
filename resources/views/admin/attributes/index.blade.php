@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Danh Sách Thuộc Tính</h2>
        <a href="{{ route('attributes.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Thuộc Tính Mới
        </a>
    </div>

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bảng danh sách thuộc tính -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>Tên Thuộc Tính</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
