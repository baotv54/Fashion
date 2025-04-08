@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Sản Phẩm</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
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
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-white">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
                </div>

                <!-- Slug -->
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug', $product->slug) }}" required>
                </div>

                <!-- Giá sản phẩm -->
                <div class="mb-3">
                    <label for="price" class="form-label">Giá sản phẩm</label>
                    <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $product->price) }}" required>
                </div>

                <!-- Chọn thương hiệu -->
                <div class="mb-3">
                    <label for="brand_id" class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select" id="brand_id" required>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Chọn danh mục -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" id="category_id" required>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Trạng thái sản phẩm -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="1" {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="0" {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label">Ẩn</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Mô tả sản phẩm -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Hình ảnh chính của sản phẩm -->
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh chính</label>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card shadow-sm">
                                <img src="{{ asset($product->image) }}" class="card-img-top img-fluid" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <input type="hidden" name="keep_images[]" value="main">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview-container-main d-flex flex-wrap mt-3"></div>
                </div>

                <!-- Thay đổi hình ảnh chính -->
                <div class="mb-3">
                    <label for="new_image" class="form-label">Thay đổi hình ảnh chính</label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">                </div>

                <!-- Hình ảnh phụ -->
                <div class="mb-3">
                    <label class="form-label">Chọn Hình Phụ</label>
                    <div class="row">
                        @foreach ($product->images as $image)
                        @if (!$image->is_main)
                        <div class="col-md-3 col-6 mb-3" id="image-{{ $image->id }}">
                            <div class="card shadow-sm">
                                <img src="{{ asset($image->image_path) }}" class="card-img-top img-fluid" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2 text-center">
                                    <button type="button" class="btn btn-sm btn-danger delete-image-btn" data-id="{{ $image->id }}">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </button>
                                    <input type="hidden" name="keep_images[]" value="{{ $image->id }}">
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Upload hình ảnh mới -->
                <div class="mb-3">
                    <label for="images" class="form-label">Thêm hình ảnh mới</label>
                    <input type="file" name="images[]" class="form-control" id="images" multiple>
                    <div class="preview-container d-flex flex-wrap mt-3"></div>
                </div>
            </div>
        </div>

        <!-- Nút cập nhật -->
        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập nhật
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xóa ảnh qua AJAX
        document.querySelectorAll('.delete-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.dataset.id;
                if (confirm("Bạn có chắc muốn xóa ảnh này không?")) {
                    fetch(`/admin/products/delete-image/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`image-${imageId}`).remove();
                            } else {
                                alert("Xóa ảnh thất bại!");
                            }
                        })
                        .catch(() => alert("Lỗi khi xóa ảnh!"));
                }
            });
        });

        // Preview ảnh tải lên
        document.getElementById('images').addEventListener('change', function(event) {
            document.querySelector('.preview-container').innerHTML = '';
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 80;
                    img.classList.add('border', 'rounded', 'shadow-sm', 'me-2');
                    document.querySelector('.preview-container').appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });

        // Preview ảnh tải lên cho hình ảnh chính
        document.getElementById('image').addEventListener('change', function(event) {
            const previewContainer = document.querySelector('.preview-container-main');
            previewContainer.innerHTML = ''; // Clear previous preview
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 120;
                    img.classList.add('border', 'rounded', 'shadow-sm', 'me-2');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
