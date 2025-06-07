@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm danh mục mới</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control">
             @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Không có --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
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
