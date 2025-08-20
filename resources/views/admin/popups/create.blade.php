@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-center fw-bold text-primary">
        {{ isset($popups) ? ' Chỉnh sửa Popup' : ' Thêm mới Popup' }}
    </h1>

    <form action="{{ isset($popups) ? route('popups.update', $popups->id) : route('popups.store') }}"
          method="POST" enctype="multipart/form-data"
          class="card p-4 shadow-sm border-0">
        @csrf
        @if (isset($popups))
            @method('PUT')
        @endif

        <div class="row">
            <!-- Cột trái: thông tin -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $popups->title ?? '') }}">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                    <textarea name="description" id="description" rows="4"
                              class="form-control">{{ old('description', $popups->description ?? '') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="media_type" class="form-label fw-semibold">Loại media</label>
                    <select name="media_type" id="media_type" class="form-select">
                        <option value="image" {{ old('media_type', $popups->media_type ?? '') == 'image' ? 'selected' : '' }}>Ảnh</option>
                        <option value="video" {{ old('media_type', $popups->media_type ?? '') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ old('status', $popups->status ?? '') == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status', $popups->status ?? '') == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
            </div>

            <!-- Cột phải: upload -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">File media</label>

                    <div id="upload-box"
                         class="upload-box border border-dashed border-2 rounded-4 p-4 text-center bg-light"
                         onclick="document.getElementById('media_file').click()"
                         ondragover="event.preventDefault(); this.classList.add('drag-over')"
                         ondragleave="this.classList.remove('drag-over')"
                         ondrop="handleDrop(event)">
                        <i class="bi bi-cloud-upload display-4 text-secondary mb-2"></i>
                        <p class="fw-medium mb-1">Kéo & thả file hoặc <span class="text-primary text-decoration-underline">chọn từ thiết bị</span></p>
                        <p class="text-muted small">(Dung lượng tối đa 2MB)</p>

                        <input type="file" id="media_file" name="media_file" accept="image/*,video/*"
                               class="d-none @error('media_file') is-invalid @enderror"
                               onchange="previewMedia(event)">
                        @error('media_file')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror

                        <div id="preview-container" class="mt-3 text-center">
                            @if (isset($popups) && $popups->media_file)
                                @if($popups->media_type === 'image')
                                    <img id="preview" src="{{ asset($popups->media_file) }}"
                                         class="rounded shadow-sm border"
                                         style="max-height: 160px;">
                                @else
                                    <video id="preview" src="{{ asset($popups->media_file) }}" controls
                                           style="max-height: 160px;" class="rounded shadow-sm border"></video>
                                @endif
                            @else
                                <img id="preview" src="" class="d-none rounded shadow-sm border"
                                     style="max-height: 160px;">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('popups.index') }}" class="btn btn-outline-secondary">
                ⬅️ Quay lại
            </a>
            <button type="submit" class="btn btn-success">
                {{ isset($popups) ? '✔️ Cập nhật' : '➕ Thêm mới' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewMedia(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';

        if (!file) return;

        const url = URL.createObjectURL(file);
        let element;

        if (file.type.startsWith('image')) {
            element = document.createElement('img');
            element.src = url;
            element.className = 'rounded shadow-sm border';
            element.style.maxHeight = '160px';
        } else if (file.type.startsWith('video')) {
            element = document.createElement('video');
            element.src = url;
            element.controls = true;
            element.className = 'rounded shadow-sm border';
            element.style.maxHeight = '160px';
        }

        previewContainer.appendChild(element);
    }

    function handleDrop(event) {
        event.preventDefault();
        const input = document.getElementById('media_file');
        input.files = event.dataTransfer.files;
        previewMedia({ target: input });
    }
</script>
@endpush
@endsection