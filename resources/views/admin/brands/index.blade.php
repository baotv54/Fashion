@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Danh sách Thương Hiệu</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">➕ Thêm Thương Hiệu</a>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td>
                        <span class="badge {{ $brand->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $brand->status ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">✏️ Sửa</a>
                        <button class="btn btn-danger" onclick="confirmDelete({{ $brand->id }})">🗑️ Xóa</button>
                        <form id="delete-form-{{ $brand->id }}" action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display: none;">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa thương hiệu này không?")) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
