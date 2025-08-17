
@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center text-primary fw-bold">
            {{ isset($users) ? '✏️ Chỉnh sửa người dùng' : '➕ Thêm mới người dùng' }}
        </h1>

        <form action="{{ isset($users) ? route('users.update', $users->id) : route('users.store') }}"
              method="POST" class="card p-4 shadow rounded-4">
            @csrf
            @if (isset($users))
                @method('PUT')
            @endif

            {{-- Tên --}}
            <div class="form-floating mb-3">
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Tên người dùng" value="{{ old('name', $users->name ?? '') }}">
                <label for="name"><i class="bi bi-person-circle me-1"></i> Tên người dùng</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-floating mb-3">
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Email" value="{{ old('email', $users->email ?? '') }}">
                <label for="email"><i class="bi bi-envelope me-1"></i> Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mật khẩu --}}
            <div class="form-floating mb-3">
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Mật khẩu">
                <label for="password"><i class="bi bi-shield-lock me-1"></i> Mật khẩu</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if (isset($users))
                    <small class="text-muted">* Để trống nếu không muốn thay đổi mật khẩu</small>
                @endif
            </div>
             <div class="md-3">
                    <label for="role" class="form-label">Vai Trò</label>
                    <select name="role" class="form-select" id="role" >
                        <option value="#" selected disabled>{{ old('role', $users->role ?? '') }}</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="manage">manage</option>
                     @error('role')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </select>
                </div>

            {{-- Nút hành động --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill">
                    ⬅️ Quay lại
                </a>
                <button type="submit" class="btn btn-success rounded-pill">
                    {{ isset($users) ? '✔️ Cập nhật' : '➕ Thêm mới' }}
                </button>
            </div>
        </form>
    </div>

    {{-- Bootstrap Icons --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @endpush
@endsection
