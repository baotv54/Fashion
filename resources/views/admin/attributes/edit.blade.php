@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Thuộc Tính</h2>
    </div>

    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="card mb-4">
                <form action="{{ route('attributes.update', $attribute->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <h5 class="card-title">Thông tin thuộc tính</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên thuộc tính</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $attribute->name }}">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
