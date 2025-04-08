@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Thêm Thuộc Tính Mới</h2>

    <!-- Form tạo mới thuộc tính -->
    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Thuộc Tính</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên thuộc tính" required>
        </div>

        <button type="submit" class="btn btn-success">Tạo Mới</button>
        <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
