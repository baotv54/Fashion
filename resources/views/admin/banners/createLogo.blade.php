@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-center text-primary fw-bold">
        {{ isset($banners) ? '✏️ Chỉnh sửa images' : '➕ Thêm mới Logo' }}
    </h1>

    <form action="{{ isset($banners) ? route('logo.update', $banners->id) : route('logo.store') }}" method="POST"
        class="card p-4 shadow-lg rounded-4" enctype="multipart/form-data">
        @csrf
        @if (isset($banners))
        @method('PUT')
        @endif

        <div class="row g-4">



            <div class="col-md-6">
                {{-- Ảnh Banner --}}
                <div class="mb-3">
                    <label class="form-label d-block fw-semibold mb-2"><i class="bi bi-image me-1"></i> Ảnh images</label>

                    <div id="upload-box"
                        class="upload-box border border-dashed border-2 rounded-4 p-4 text-center bg-light position-relative"
                        onclick="document.getElementById('images').click()"
                        ondragover="event.preventDefault(); this.classList.add('drag-over')"
                        ondragleave="this.classList.remove('drag-over')" ondrop="handleDropp(event)">

                        <i class="bi bi-cloud-upload display-3 text-secondary mb-2"></i>
                        <p class="fw-medium mb-1">Kéo & thả ảnh vào đây hoặc <span
                                class="text-primary text-decoration-underline">chọn từ thiết bị</span></p>
                        <p class="text-muted mb-2 small">(Dung lượng tối đa 2MB)</p>

                        <input type="file" id="images" name="images" accept="images/*"
                            class="d-none @error('images') is-invalid @enderror" onchange="previewImage(event)">
                        @error('images')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror

                        {{-- Preview ảnh --}}
                        <div id="preview-container" class="mt-3 text-center">
                            @if (isset($banners) && $banners->images)
                            <img id="previewimages" src="{{ asset('imgBanner/' . $banners->images) }}"
                                class="rounded shadow-sm border" style="max-height: 160px;">
                            @else
                            <img id="previewimages" src="" class="d-none rounded shadow-sm border"
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

    function previewimages(event) {
        const input = event.target;
        const preview = document.getElementById('previewimages');
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
        const input = document.getElementById('images');
        input.files = event.dataTransfer.files;
        previewimages({
            target: input
        });
    }
</script>

@endpush
@endsection