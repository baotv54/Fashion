@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-center text-primary fw-bold">
        {{ isset($socialLink) ? ' Chỉnh sửa Sociallink' : ' Thêm mới Sociallink' }}
    </h1>

    <form action="{{ isset($socialLink) ? route('social-links.update', $socialLink->id) : route('social-links.store') }}"
          method="POST"
          class="card p-4 shadow-lg rounded-4"
          enctype="multipart/form-data">
        @csrf
        @if (isset($socialLink))
            @method('PUT')
        @endif

        <div class="row g-4">
            {{-- Cột trái --}}
            <div class="col-md-6">
                {{-- Platform --}}
                <div class="form-floating mb-3">
                    <input type="text" name="platform" id="platform"
                           class="form-control @error('platform') is-invalid @enderror"
                           value="{{ old('platform', $socialLink->platform ?? '') }}"
                           placeholder="Tên nền tảng">
                    <label for="platform"><i class="bi bi-fonts me-1"></i> Nền tảng</label>
                    @error('platform')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- URL --}}
                <div class="form-floating mb-3">
                    <input type="url" name="url" id="url"
                           class="form-control @error('url') is-invalid @enderror"
                           value="{{ old('url', $socialLink->url ?? '') }}"
                           placeholder="https://...">
                    <label for="url"><i class="bi bi-link-45deg me-1"></i> Liên kết (URL)</label>
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Cột phải --}}
            <div class="col-md-6">
                {{-- Upload hình --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold mb-2">
                        <i class="bi bi-image me-1"></i> Icon / Hình ảnh
                    </label>

                    <input type="file" id="image" name="image" accept="image/*"
                           class="form-control @error('image') is-invalid @enderror"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror

                    {{-- Preview ảnh --}}
                    <div id="preview-container" class="mt-3 text-center">
                        @if (isset($socialLink) && $socialLink->image)
                            <img id="preview" src="{{ asset('storage/' . $socialLink->image) }}"
                                 class="rounded shadow-sm border" style="max-height: 160px;">
                        @else
                            <img id="preview" src="" class="d-none rounded shadow-sm border"
                                 style="max-height: 160px;">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Nút hành động --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('social-links.index') }}" class="btn btn-outline-secondary rounded-pill">
                ⬅️ Quay lại
            </a>
            <button type="submit" class="btn btn-success rounded-pill">
                {{ isset($socialLink) ? '✔️ Cập nhật' : '➕ Thêm mới' }}
            </button>
        </div>
    </form>
</div>

{{-- Script preview ảnh --}}
@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
