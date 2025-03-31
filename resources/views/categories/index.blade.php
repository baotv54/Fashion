<!-- filepath: c:\xampp\htdocs\php3\shoe-store\resources\views\categories\index.blade.php -->
@extends('layouts.app')

@section('title', 'Danh mục sản phẩm')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách danh mục sản phẩm</h2>

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Nút thêm danh mục -->
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Thêm danh mục</a>

    <!-- Bảng danh sách danh mục -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Danh mục cha</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            @if ($category->children->count() > 0)
                            <ul class="mt-2">
                                @foreach ($category->children as $child)
                                <li>{{ $child->name }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        <td>{{ $category->parent ? $category->parent->name : 'Danh mục gốc' }}</td>
                        <td>
                            <span class="badge {{ $category->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có danh mục nào</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection