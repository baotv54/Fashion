@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Sản Phẩm</h2>

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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Nhập slug" value="{{ old('slug') }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá sản phẩm</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="Nhập giá" value="{{ old('price') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" id="description" rows="3" placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="brand_id" class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select" id="brand_id" required>
                        <option value="" selected disabled>Chọn thương hiệu</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" id="category_id" required>
                        <option value="" selected disabled>Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="1" {{ old('status', 1) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="0" {{ old('status', 1) == 0 ? 'checked' : '' }}>
                        <label class="form-check-label">Ẩn</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload nhiều ảnh -->
        <div class="mb-3">
            <label for="images" class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="images[]" class="form-control" id="images" accept="image/*" multiple onchange="previewImages(event)">
            <div id="imagePreview" class="mt-2 d-flex flex-wrap"></div>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<!-- Script hiển thị preview ảnh -->
<script>
function previewImages(event) {
    let preview = document.getElementById("imagePreview");
    preview.innerHTML = ""; // Xóa ảnh cũ
    let files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        let reader = new FileReader();
        reader.onload = function (e) {
            let img = document.createElement("img");
            img.src = e.target.result;
            img.className = "me-2 mb-2";
            img.style.width = "100px";
            img.style.height = "100px";
            img.style.objectFit = "cover";
            img.style.borderRadius = "5px";
            img.style.boxShadow = "0 0 5px rgba(0,0,0,0.2)";
            preview.appendChild(img);
        };
        reader.readAsDataURL(files[i]);
    }
}
</script>
@endsection
