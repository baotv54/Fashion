@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="my-4">Chỉnh sửa màu sắc</h2>

    <form action="{{ route('colors.update', $color->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên màu</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $color->name }}" required>
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Mã màu (Hex)</label>
            <input type="color" class="form-control form-control-color" id="code" name="code" value="{{ $color->code }}" required>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('colors.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
