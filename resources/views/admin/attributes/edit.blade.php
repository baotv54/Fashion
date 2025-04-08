@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Sửa Thuộc Tính: {{ $attribute->name }}</h2>

    <!-- Form sửa thuộc tính -->
    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Thuộc Tính</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $attribute->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
