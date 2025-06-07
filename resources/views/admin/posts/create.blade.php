@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Bài Viết Mới</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf

        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Nhập tiêu đề bài viết" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Tác giả</label>
                    <input type="text" name="author" id="author" class="form-control" placeholder="Nhập tên tác giả" value="{{ old('author') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" value="1" {{ old('is_visible', 1) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_visible" value="0" {{ old('is_visible', 1) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label">Ẩn</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="post_category_id" class="form-label">Danh mục bài viết</label>
                    <select name="post_category_id" id="post_category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewPrimaryImage(event)" required>
                    <div id="primaryImagePreview" class="mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Nội dung -->
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bài viết</label>
            <textarea name="content" id="content" class="form-control" rows="10">{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Đăng bài</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<!-- TINYMCE -->
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap preview anchor code fullscreen insertdatetime media table paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | removeformat | code',
        height: 400,
        menubar: false,
    });

    function previewPrimaryImage(event) {
        let preview = document.getElementById("primaryImagePreview");
        preview.innerHTML = "";
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement("img");
                img.src = e.target.result;
                img.className = "me-2 mb-2";
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

    function validateForm() {
        const title = document.getElementById('title').value.trim();
        const author = document.getElementById('author').value.trim();
        const image = document.getElementById('image').files.length;
        const content = tinymce.get('content').getContent().trim();
        if (!title || !author || !image || !content) {
            alert('Vui lòng nhập đầy đủ thông tin bài viết.');
            return false;
        }
        return true;
    }
</script>
@endsection