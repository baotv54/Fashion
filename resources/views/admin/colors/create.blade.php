@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="my-4">Thêm màu sắc</h2>

    <form action="{{ route('colors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Mã màu (Hex)</label>
            <input type="color" class="form-control form-control-color" id="code" name="code" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="{{ route('colors.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
