@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Thêm Sản Phẩm</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" id="slug" placeholder="Nhập slug" value="{{ old('slug') }}">
                    @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá sản phẩm</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="Nhập giá" value="{{ old('price') }}">
                    @error('price')<small class="text-danger">{{ $message }}</small>@enderror
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
                    <select name="brand_id" class="form-select" id="brand_id">
                        <option value="" selected disabled>Chọn thương hiệu</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select" id="category_id">
                        <option value="" selected disabled>Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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

        <!-- Hình ảnh chính -->
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh chính</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewPrimaryImage(event)">
            <div id="primaryImagePreview" class="mt-2"></div>
            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <!-- Upload nhiều ảnh phụ -->
        <div class="mb-3">
            <label for="images" class="form-label">Ảnh sản phẩm phụ</label>
            <input type="file" name="images[]" class="form-control" id="images" accept="image/*" multiple onchange="previewImages(event)">
            <div id="imagePreview" class="mt-2 d-flex flex-wrap"></div>
            @error('images')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <!-- Vùng chọn thuộc tính ñể sinh biến thể -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Chọn thuộc tính</h5>
                <div id="attribute-select-area" class="mb-3"></div>
                <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addAttributeSelector()">+ Thêm thuộc tính</button><br>
                <button type="button" class="btn btn-primary mt-2" onclick="generateCombinations()">+ Sinh tổ hợp phiên bản</button>
            </div>
        </div>

        <!-- Bảng tổ hợp biến thể -->
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

        <button type="submit" class="btn btn-success mt-3">Thêm Sản Phẩm</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
const allAttributes = @json($attributes);
const allValues = @json($attribute_values);
let attributeSelectorIndex = 0;

function addAttributeSelector() {
    const wrapper = document.getElementById('attribute-select-area');
    const container = document.createElement('div');
    container.className = 'attribute-group mb-3';
    container.innerHTML = `
        <div class="row align-items-start">
            <div class="col-md-4">
                <label class="form-label">Thuộc tính</label>
                <select class="form-select attribute-name" onchange="updateValues(this)" required>
                    <option value="" disabled selected>Chọn thuộc tính</option>
                    ${allAttributes.map(attr => `<option value="${attr.id}">${attr.name}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Giá trị</label>
                <select name="attributes[${attributeSelectorIndex}][]" class="form-select attribute-values" multiple required>
                    <option disabled>Chọn giá trị</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger" onclick="this.closest('.attribute-group').remove()">Xóa</button>
            </div>
        </div>
    `;
    wrapper.appendChild(container);
    attributeSelectorIndex++;
}

function updateValues(select) {
    const attrId = select.value;
    const values = allValues.filter(v => v.attribute_id == attrId);
    const valueSelect = select.closest('.attribute-group').querySelector('.attribute-values');
    valueSelect.innerHTML = '';
    values.forEach(v => {
        const option = document.createElement('option');
        option.value = v.id;
        option.textContent = v.value;
        valueSelect.appendChild(option);
    });
}

function generateCombinations() {
    const selected = {};
    document.querySelectorAll('.attribute-group').forEach((group, i) => {
        const attrSelect = group.querySelector('.attribute-name');
        const attrId = attrSelect.value;
        const attrName = attrSelect.options[attrSelect.selectedIndex].text;
        const values = Array.from(group.querySelectorAll('.attribute-values option:checked')).map(opt => ({
            id: opt.value,
            name: opt.text
        }));

        if (!attrId || values.length === 0) return;
        selected[`${attrId}_${attrName}`] = values;
    });

    if (Object.keys(selected).length === 0 || Object.values(selected).some(v => v.length === 0)) {
        alert('Vui lòng chọn ít nhất một giá trị cho mỗi thuộc tính.');
        return;
    }

    const combinations = cartesianProduct(Object.values(selected));
    const tbody = document.getElementById('variant-list');
    tbody.innerHTML = '';

    combinations.forEach((combo, index) => {
        const name = combo.map(v => v.name).join(' / ');
        const valueIds = combo.map(v => v.id).join('-');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td><input type="hidden" name="variants[${index}][value_ids]" value="${valueIds}">${name}</td>
            <td><input type="number" name="variants[${index}][price]" class="form-control" placeholder="Giá" required></td>
            <td><input type="number" name="variants[${index}][stock]" class="form-control" placeholder="Số lượng" required></td>
            <td><input type="file" name="variants[${index}][image]" class="form-control"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); updateVariantCount()">X</button></td>
        `;
        tbody.appendChild(row);
    });

    document.getElementById('variants-container').style.display = 'block';
    updateVariantCount();
}

function cartesianProduct(arr) {
    return arr.reduce((a, b) => a.flatMap(d => b.map(e => [].concat(d, e))));
}

function updateVariantCount() {
    const count = document.querySelectorAll('#variant-list tr').length;
    document.getElementById('variant-count').innerText = count;
}

function previewPrimaryImage(event) {
    let preview = document.getElementById("primaryImagePreview");
    preview.innerHTML = "";
    let file = event.target.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
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

function previewImages(event) {
    let preview = document.getElementById("imagePreview");
    preview.innerHTML = "";
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
