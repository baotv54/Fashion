@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Sửa Giá Trị Thuộc Tính: {{ $attribute->name }}</h2>

    <!-- Form sửa giá trị thuộc tính -->
    <form action="{{ route('attribute_values.update', [$attribute->id, $attributeValue->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="value" class="form-label">Giá trị</label>
            <input type="text" name="value" id="value" class="form-control" value="{{ $attributeValue->value }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('attribute_values.index', $attribute->id) }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
