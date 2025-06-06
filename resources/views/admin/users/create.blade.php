@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ isset($users) ? '✏️ Chỉnh sửa thương hiệu' : '➕ Thêm mới thương hiệu' }}</h1>

    <form action="{{ isset($users) ? route('users.update', $users->id) : route('users.store') }}" method="POST" class="card p-4 shadow">
        @csrf
        @if(isset($users))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Tên người dùng:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $users->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $users->email ?? '') }}" required>
           
        </div>

        <div class="md-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="{{ old('password', $users->password ?? '')}}" required>

        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
            <button type="submit" class="btn btn-success">{{ isset($users) ? '✔️ Cập nhật' : '➕ Thêm mới' }}</button>
        </div>
    </form>
</div>
@endsection
