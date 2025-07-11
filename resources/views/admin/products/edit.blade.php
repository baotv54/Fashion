@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Chỉnh Sửa Sản Phẩm</h2>
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
    </div>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin sản phẩm</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name', $product->name) }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Nhập mô tả sản phẩm">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>
                @if($product_variants->count() > 0)
                <div class="card mb-4" id="variants-container">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product_variants->count() }} phiên bản</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Thuộc tính</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Ảnh</th>
                                        <th>Xoá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product_variants as $index => $variant)
                                    <tr>
                                        <td>
                                            @php
                                            $attributeValues = $variantAttributeValue->where('variant_id', $variant->id);
                                            $valueIds = $attributeValues->pluck('attribute_value_id')->toArray();
                                            @endphp

                                            @if($attributeValues->count())
                                            @foreach($attributeValues as $value)
                                            <span class="badge bg-secondary me-1">
                                                {{ $value->attributeValue->attribute->name ?? '---' }}:
                                                {{ $value->attributeValue->value ?? '---' }}
                                            </span>
                                            @endforeach
                                            @else
                                            <span class="text-muted">Không có thuộc tính</span>
                                            @endif

                                            <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                            <input type="hidden" name="variants[{{ $index }}][value_ids]" value="{{ implode('-', $valueIds) }}">
                                        </td>

                                        <td>
                                            <input type="number"
                                                name="variants[{{ $index }}][price]"
                                                value="{{ $variant->price }}"
                                                class="form-control form-control-sm"
                                                min="0" step="1000">
                                        </td>

                                        <td>
                                            <input type="number"
                                                name="variants[{{ $index }}][stock]"
                                                value="{{ $variant->stock }}"
                                                class="form-control form-control-sm"
                                                min="0">
                                        </td>

                                        <td>
                                            @if($variant->image)
                                            <img src="{{ asset($variant->image) }}" alt="Ảnh" width="60" height="60" style="object-fit: cover;" class="mb-2 d-block">
                                            @else
                                            <span class="text-muted d-block mb-2">Không có ảnh</span>
                                            @endif

                                            <input type="file"
                                                name="variants[{{ $index }}][image]"
                                                accept="image/*"
                                                class="form-control form-control-sm">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <div id="variants-container" class="card" style="display:none;">
                    <div class="card-body">
                        <h5 class="card-title"><span id="variant-count">0</span> phiên bản</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Phiên bản</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Ảnh</th>
                                        <th>Xoá</th>
                                    </tr>
                                </thead>
                                <tbody id="variant-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-3">
                <!-- Hình ảnh chính -->
                <div class="mb-3">
                    <label class="form-label">Ảnh chính</label>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <!-- Hiển thị ảnh chính hiện tại -->
                        <div class="position-relative" style="width: 120px; height: 120px;">
                            <img src="{{ asset($product->image) }}" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                            <input type="hidden" name="keep_images[]" value="main">
                        </div>

                        <!-- Nút chọn ảnh chính mới -->
                        <label for="image" style="width: 120px; height: 120px;" class="border border-secondary-subtle rounded d-flex align-items-center justify-content-center" role="button">
                            <i class="fas fa-plus fa-2x text-muted"></i>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" hidden>
                    </div>
                    <!-- Preview ảnh chính upload mới -->
                    <div class="preview-container-main d-flex flex-wrap gap-2 mt-3"></div>
                </div>

                <!-- Ảnh phụ -->
                <div class="mb-3">
                    <label class="form-label">Ảnh phụ</label>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <!-- Nút chọn ảnh phụ mới -->
                        <label for="images" style="width: 80px; height: 80px;" class="border border-secondary-subtle rounded d-flex align-items-center justify-content-center" role="button">
                            <i class="fas fa-plus"></i>
                        </label>
                        <input type="file" name="images[]" id="images" multiple hidden>

                        <!-- Hiển thị ảnh phụ hiện tại -->
                        @foreach ($product->images as $image)
                        @if (!$image->is_main)
                        <div class="position-relative" style="width: 80px; height: 80px;" id="image-{{ $image->id }}">
                            <img src="{{ asset($image->image_path) }}" class="img-fluid rounded border" style="width: 100%; height: 100%; object-fit: cover;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 p-1 delete-image-btn" data-id="{{ $image->id }}" style="z-index: 10;">
                                <i class="fas fa-times"></i>
                            </button>
                            <input type="hidden" name="keep_images[]" value="{{ $image->id }}">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <!-- Preview ảnh phụ upload mới -->
                    <div class="preview-container d-flex flex-wrap gap-2 mt-3"></div>
                </div>

                <!-- Thương hiệu & Danh mục -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Phân loại</h5>

                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Thương hiệu</label>
                            <select name="brand_id" class="form-select" id="brand_id">
                                <option value="" selected disabled>Chọn thương hiệu</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="" selected disabled>Chọn danh mục</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Trạng thái hiển thị</h5>
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
            </div>
        </div>

        <!-- Nút -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Quay lại</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#description',
        height: 400,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'code', 'fullscreen', 'insertdatetime', 'media', 'table',
            'paste', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code',
        content_style: "body { font-family:Helvetica,Arial,sans-serif; font-size:14px }"
    });

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
