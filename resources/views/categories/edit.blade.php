@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sửa danh mục</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Không có --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="1" {{ $category->status ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ !$category->status ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection
