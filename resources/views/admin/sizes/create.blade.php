@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <h2>Thêm Size Mới</h2>
    <form action="{{ route('sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="size" class="form-label">SIZE</label>
            <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" placeholder="Ví dụ: S (29)" required>
            @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="height_range" class="form-label">Chiều cao (cm)</label>
            <input type="text" name="height_range" id="height_range" class="form-control @error('height_range') is-invalid @enderror" value="{{ old('height_range') }}" placeholder="Ví dụ: 1m50-1m60 hoặc 150-160">
            @error('height_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="weight_range" class="form-label">Cân nặng (kg)</label>
            <input type="text" name="weight_range" id="weight_range" class="form-control @error('weight_range') is-invalid @enderror" value="{{ old('weight_range') }}" placeholder="Ví dụ: 50-60 hoặc 50kg-60kg">
            @error('weight_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="chest_range" class="form-label">Rộng ngực (cm)</label>
            <input type="text" name="chest_range" id="chest_range" class="form-control @error('chest_range') is-invalid @enderror" value="{{ old('chest_range') }}" placeholder="Ví dụ: 80-90">
            @error('chest_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="hip_range" class="form-label">Rộng mông (cm)</label>
            <input type="text" name="hip_range" id="hip_range" class="form-control @error('hip_range') is-invalid @enderror" value="{{ old('hip_range') }}" placeholder="Ví dụ: 85-95">
            @error('hip_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Tạo Mới</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
