@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Bài Viết</h2>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Hiển thị thông báo -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form chỉnh sửa -->
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $post->title) }}" required>
                </div>

                <!-- Tác giả -->
                <div class="mb-3">
                    <label for="author" class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" id="author" value="{{ old('author', $post->author) }}" required>
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" value="1" {{ old('is_visible', $post->is_visible ?? 1) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" value="0" {{ old('is_visible', $post->is_visible ?? 1) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label">Ẩn</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Hình ảnh hiện tại -->
                <div class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại</label>
                    <div>
                        @if($post->image)
                        <img src="{{ asset($post->image) }}" alt="Hình ảnh bài viết" style="width: 150px; height: 150px; object-fit: cover; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                        @else
                        <p>Chưa có hình ảnh</p>
                        @endif
                    </div>
                </div>

                <!-- Thay đổi hình ảnh -->
                <div class="mb-3">
                    <label for="image" class="form-label">Thay đổi hình ảnh</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                    <div id="imagePreview" class="mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Nội dung bài viết -->
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bài viết</label>
            <textarea name="content" id="content" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập nhật bài viết
            </button>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap preview anchor code fullscreen insertdatetime media table paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | removeformat | code',
        height: 400,
        menubar: false,
    });

    function previewImage(event) {
        const preview = document.getElementById("imagePreview");
        preview.innerHTML = "";
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "150px";
                img.style.height = "150px";
                img.style.objectFit = "cover";
                img.style.borderRadius = "5px";
                img.style.boxShadow = "0 0 5px rgba(0,0,0,0.2)";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection