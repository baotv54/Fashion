@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="my-4">Thêm kích thước</h2>

    <form action="{{ route('sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên kích thước</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm mới</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
