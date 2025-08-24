@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Hiển thị lỗi validate --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
