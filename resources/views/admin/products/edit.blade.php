@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chỉnh Sửa Sản Phẩm</h2>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
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

    <!-- Form chỉnh sửa sản phẩm -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

        <!-- Mô tả sản phẩm -->
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $product->description) }}</textarea>
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

        <!-- Hình ảnh sản phẩm hiện tại -->
        <div class="mb-3">
            <label class="form-label">Hình ảnh sản phẩm hiện tại</label>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($product->images as $image)
                <div id="image-{{ $image->id }}" class="position-relative">
                    <img src="{{ asset($image->image_path) }}" alt="Ảnh sản phẩm" width="100" class="border rounded">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-image-btn" data-id="{{ $image->id }}">X</button>
                    <input type="hidden" name="keep_images[]" value="{{ $image->id }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Upload hình ảnh mới -->
        <div class="mb-3">
            <label for="images" class="form-label">Tải lên hình ảnh mới</label>
            <input type="file" name="images[]" class="form-control" id="images" multiple>
            <div class="preview-container d-flex flex-wrap mt-3"></div>
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

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý xóa ảnh qua AJAX
        const deleteButtons = document.querySelectorAll('.delete-image-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const imageId = this.getAttribute('data-id');

                if (confirm("Bạn có chắc muốn xóa ảnh này không?")) {
                    fetch(`/admin/products/delete-image/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Xóa ảnh thất bại."); // Kiểm tra phản hồi
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const imageElement = document.getElementById(`image-${imageId}`);
                                imageElement.remove(); // Xóa ảnh khỏi giao diện
                                // Xóa input hidden tương ứng
                                const hiddenInput = document.querySelector(`input[value="${imageId}"]`);
                                if (hiddenInput) hiddenInput.remove();
                            } else {
                                alert("Xóa ảnh thất bại: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Lỗi:", error);
                            alert("Đã xảy ra lỗi khi xóa ảnh. Vui lòng thử lại!");
                        });
                }
            });
        });

        // Xử lý preview hình ảnh tải lên
        const imagesInput = document.getElementById('images');
        const previewContainer = document.querySelector('.preview-container');

        imagesInput.addEventListener('change', function(event) {
            previewContainer.innerHTML = ''; // Xóa preview cũ

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 100;
                    img.classList.add('border', 'rounded', 'me-2');
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            });
        });
    });
</script>
@endsection