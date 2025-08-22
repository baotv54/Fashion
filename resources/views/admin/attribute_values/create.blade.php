@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Thêm Giá Trị Mới Cho Thuộc Tính: {{ $attribute->name }}</h2>

    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
