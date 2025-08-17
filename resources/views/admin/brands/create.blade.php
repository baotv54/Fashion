@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center fw-bold text-primary">
            {{ isset($brand) ? '✏️ Chỉnh sửa thương hiệu' : '➕ Thêm mới thương hiệu' }}
        </h1>

        <form action="{{ isset($brand) ? route('brands.update', $brand->id) : route('brands.store') }}" method="POST"
            enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
            @csrf
            @if (isset($brand))
                @method('PUT')
            @endif

            <div class="row">
                <!-- Thông tin -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Tên thương hiệu:</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $brand->name ?? '') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Trạng thái:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ isset($brand) && $brand->status ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ isset($brand) && !$brand->status ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>
                </div>

                <!-- Ảnh thương hiệu -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">
                            <i class="bi bi-image me-1"></i> Ảnh thương hiệu
                        </label>

                        <div id="upload-box"
                            class="upload-box border border-dashed border-2 rounded-4 p-4 text-center bg-light position-relative"
                            onclick="document.getElementById('image').click()"
                            ondragover="event.preventDefault(); this.classList.add('drag-over')"
                            ondragleave="this.classList.remove('drag-over')" ondrop="handleDrop(event)">

                            <i class="bi bi-cloud-upload display-4 text-secondary mb-2"></i>
                            <p class="fw-medium mb-1">Kéo & thả ảnh vào đây hoặc <span
                                    class="text-primary text-decoration-underline">chọn từ thiết bị</span></p>
                            <p class="text-muted small">(Dung lượng tối đa 2MB)</p>

                            <input type="file" id="image" name="image" accept="image/*"
                                class="d-none @error('image') is-invalid @enderror" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror

                            <div id="preview-container" class="mt-3 text-center">
                                @if (isset($brand) && $brand->image)
                                    <img id="preview" src="{{ asset($brand->image) }}" class="rounded shadow-sm border"
                                        style="max-height: 160px;">
                                @else
                                    <img id="preview" src="" class="d-none rounded shadow-sm border"
                                        style="max-height: 160px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save me-1"></i>
                    {{ isset($brand) ? '✔️ Cập nhật' : '➕ Thêm mới' }}
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

            function handleDrop(event) {
                event.preventDefault();
                const input = document.getElementById('image');
                input.files = event.dataTransfer.files;
                previewImage({
                    target: input
                });
            }
        </script>
    @endpush
@endsection
