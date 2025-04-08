@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Thêm Giá Trị Mới Cho Thuộc Tính: {{ $attribute->name }}</h2>

    <!-- Form tạo mới giá trị thuộc tính -->
    <form action="{{ route('attribute_values.store', $attribute->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="value" class="form-label">Giá trị</label>
            <input type="text" name="value" id="value" class="form-control" placeholder="Nhập giá trị thuộc tính" required>
        </div>

        <button type="submit" class="btn btn-success">Tạo Mới</button>
        <a href="{{ route('attribute_values.index', $attribute->id) }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
