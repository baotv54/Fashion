@extends('layouts.admin')

@section('title', 'Thêm danh mục bài viết')

@section('content')
<div class="container">
    <h2 class="mb-4">Thêm danh mục bài viết</h2>

    <form action="{{ route('post-categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
    </form>
</div>
@endsection
