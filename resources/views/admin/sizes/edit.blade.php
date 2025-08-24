@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Size</h2>
    </div>

    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="card mb-4">
                <form action="{{ route('sizes.update', $size->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <h5 class="card-title">Thông tin Size</h5>

                        <div class="mb-3">
                            <label for="size" class="form-label">SIZE</label>
                            <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size', $size->size) }}" placeholder="Ví dụ: S (29)" required>
                            @error('size')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="height_range" class="form-label">Chiều cao (cm)</label>
                            <input type="text" name="height_range" id="height_range" class="form-control @error('height_range') is-invalid @enderror" value="{{ old('height_range', $size->height_range) }}" placeholder="Ví dụ: 1m50-1m60 hoặc 150-160">
                            @error('height_range')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="weight_range" class="form-label">Cân nặng (kg)</label>
                            <input type="text" name="weight_range" id="weight_range" class="form-control @error('weight_range') is-invalid @enderror" value="{{ old('weight_range', $size->weight_range) }}" placeholder="Ví dụ: 50-60 hoặc 50kg-60kg">
                            @error('weight_range')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="chest_range" class="form-label">Rộng ngực (cm)</label>
                            <input type="text" name="chest_range" id="chest_range" class="form-control @error('chest_range') is-invalid @enderror" value="{{ old('chest_range', $size->chest_range) }}" placeholder="Ví dụ: 80-90">
                            @error('chest_range')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hip_range" class="form-label">Rộng mông (cm)</label>
                            <input type="text" name="hip_range" id="hip_range" class="form-control @error('hip_range') is-invalid @enderror" value="{{ old('hip_range', $size->hip_range) }}" placeholder="Ví dụ: 85-95">
                            @error('hip_range')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        <a href="{{ route('sizes.index') }}" class="btn btn-outline-primary">Quay Lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
