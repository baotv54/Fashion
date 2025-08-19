@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center text-primary fw-bold">
            {{ isset($banners) ? '✏️ Chỉnh sửa Banner' : '➕ Thêm mới Banner' }}
        </h1>

        <form action="{{ isset($banners) ? route('banners.update', $banners->id) : route('banners.store') }}" method="POST"
            class="card p-4 shadow-lg rounded-4" enctype="multipart/form-data">
            @csrf
            @if (isset($banners))
                @method('PUT')
            @endif

            <div class="row g-4">
                {{-- Cột trái --}}
                <div class="col-md-6">
                    {{-- Tiêu đề --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $banners->title ?? '') }}" placeholder="Tiêu đề">
                        <label for="title"><i class="bi bi-fonts me-1"></i> Tiêu đề</label>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="url" name="link" id="link"
                            class="form-control @error('link') is-invalid @enderror"
                            value="{{ old('link', $banners->link ?? '') }}" placeholder="https://...">
                        <label for="link"><i class="bi bi-link-45deg me-1"></i> Liên kết (URL)</label>
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Phụ đề --}}
                    <div class="mb-3">
                        <label for="subtitle" class="form-label"><i class="bi bi-chat-left-text me-1"></i> Phụ đề</label>
                        <textarea name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="4">{{ old('subtitle', $banners->subtitle ?? '') }}</textarea>
                        @error('subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                </div>

                {{-- Cột phải --}}
                <div class="col-md-6">
                    {{-- Ảnh Banner --}}
                    <div class="mb-3">
                        <label class="form-label d-block fw-semibold mb-2"><i class="bi bi-image me-1"></i> Ảnh sản
                            phẩm</label>

                        <div id="upload-box"
                            class="upload-box border border-dashed border-2 rounded-4 p-4 text-center bg-light position-relative"
                            onclick="document.getElementById('image').click()"
                            ondragover="event.preventDefault(); this.classList.add('drag-over')"
                            ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event)">

                            <i class="bi bi-cloud-upload display-3 text-secondary mb-2"></i>
                            <p class="fw-medium mb-1">Kéo & thả ảnh vào đây hoặc <span
                                    class="text-primary text-decoration-underline">chọn từ thiết bị</span></p>
                            <p class="text-muted mb-2 small">(Dung lượng tối đa 2MB)</p>

                            <input type="file" id="image" name="image" accept="image/*"
                                class="d-none @error('image') is-invalid @enderror" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror

                            {{-- Preview ảnh --}}
                            <div id="preview-container" class="mt-3 text-center">
                                @if (isset($banners) && $banners->image)
                                    <img id="preview" src="{{ asset('imgBanner/' . $banners->image) }}"
                                        class="rounded shadow-sm border" style="max-height: 160px;">
                                @else
                                    <img id="preview" src="" class="d-none rounded shadow-sm border"
                                        style="max-height: 160px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            {{-- Nút hành động --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary rounded-pill">
                    ⬅️ Quay lại
                </a>
                <button type="submit" class="btn btn-success rounded-pill">
                    {{ isset($banners) ? '✔️ Cập nhật' : '➕ Thêm mới' }}
                </button>
            </div>
        </form>
    </div>

    {{-- Bootstrap Icons --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
           
        </style>
    @endpush

    {{-- Preview ảnh khi upload --}}
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

            function handleDrop(event) {
                event.preventDefault();
                const input = document.getElementById('image');
                input.files = event.dataTransfer.files;
                previewImage({
                    target: input
                });
            }

            function previewLogo(event) {
                const input = event.target;
                const preview = document.getElementById('previewlogo');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function handleDropp(event) {
                event.preventDefault();
                const input = document.getElementById('logo');
                input.files = event.dataTransfer.files;
                previewLogo({
                    target: input
                });
            }
        </script>
         
    @endpush
@endsection
