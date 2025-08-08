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
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin sản phẩm</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" placeholder="Nhập slug" value="{{ old('slug') }}">
                            @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số Lượng sản phẩm</label>
                            <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Nhập Số Lượng" value="{{ old('quantity') }}">
                            @error('quantity')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin giá</h5>

                        <div class="row">
                            <!-- Giá bán -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giá bán</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập giá bán sản phẩm" name="price" id="price">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('price')<small class="text-danger">{{ $message }}</small>@enderror

                            </div>

                            <!-- Giá so sánh -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Giá Nhập
                                    <span class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Giá nhập sản phẩm"></span>
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Nhập giá vốn sản phẩm" name="import_price" id="import_price">
                                    <span class="input-group-text">VNĐ</span>
                                </div>
                                @error('import_price')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <!-- Giá vốn -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">
                                Giá Khuyến Mãi
                                <span class="text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Giá Khuyến Mãi"></span>
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Giá Khuyến Mãi" name="discount_price" id="discount_price">
                                <span class="input-group-text">VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Thuộc tính và biến thể -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <h6 class="card-title mb-1">Thuộc tính</h6>
                                <small class="text-muted">Sản phẩm có nhiều thuộc tính khác nhau. Ví dụ: kích thước, màu sắc.</small>
                            </div>
                            <a href="#" class="text-primary " onclick="addAttributeSelector();">+ Thêm thuộc tính</a>
                        </div>

                        <!-- Vùng chứa các selector thuộc tính -->
                        <div id="attribute-select-area" class="mb-3"></div>
                        <button type="button" class="btn btn-sm btn btn-success mb-2" onclick="generateCombinations()">+ Sinh tổ hợp phiên bản</button>

                    </div>
                </div>

                <div id="variants-container" class="card shadow-sm mt-3" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-boxes me-1 text-primary"></i>
                            <span id="variant-count">0</span> phiên bản được tạo
                        </h5>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="7" class="text-center">Danh sách biến thể sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody id="variant-list">
                                    <!-- JS sẽ sinh ra các hàng tại đây -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Cột phải -->
            <div class="col-md-3">
                <!-- Ảnh đại diện -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Ảnh đại diện</h6>
                        <div class="d-flex align-items-start gap-3">
                            <label for="main-image-input" class="border border-secondary-subtle rounded d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; cursor: pointer;">
                                <span class="fs-3 text-muted">+</span>
                            </label>
                            <input type="file" name="image" id="main-image-input" class="d-none" accept="image/*" onchange="previewMainImage(event)">
                            <div id="main-image-preview" class="position-relative" style="width: 80px; height: 80px;"></div>
                        </div>
                        @error('image')<small class="text-danger d-block mt-2">{{ $message }}</small>@enderror
                    </div>
                </div>

                <!-- Ảnh phụ -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title d-flex justify-content-between">
                            <span>Ảnh phụ</span>
                            <a href="#" class="text-primary" onclick="event.preventDefault(); addSubImageByUrl()">Thêm ảnh từ URL</a>
                        </h6>

                        <div class="d-flex gap-2 flex-wrap" id="sub-image-preview-box">
                            <label for="sub-images-input" class="border border-secondary-subtle rounded d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px; cursor: pointer;">
                                <span class="fs-3 text-muted">+</span>
                            </label>
                            <input type="file" name="images[]" id="sub-images-input" class="d-none" multiple accept="image/*" onchange="previewSubImages(event)">
                        </div>
                        @error('images')<small class="text-danger d-block mt-2">{{ $message }}</small>@enderror
                    </div>
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
                    </div>
                </div>

                <!-- Trạng thái -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Trạng thái hiển thị</h5>
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
        </div>

        <!-- Nút -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Quay lại</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    const allAttributes = @json($attributes);
    const allValues = @json($attribute_values);
    let attributeSelectorIndex = 0;

    function addAttributeSelector() {
        const wrapper = document.getElementById('attribute-select-area');

        const selectedAttributeIds = Array.from(document.querySelectorAll('.attribute-name'))
            .map(select => select.value)
            .filter(v => v !== '');

        const availableAttributes = allAttributes.filter(attr => !selectedAttributeIds.includes(attr.id.toString()));

        if (availableAttributes.length === 0) {
            alert('Tất cả thuộc tính đã được chọn.');
            return;
        }

        const container = document.createElement('div');
        container.className = 'attribute-group mb-3';

        const selectId = `attribute-values-${attributeSelectorIndex}`;
        const nameAttr = `attributes[${attributeSelectorIndex}][]`;

        container.innerHTML = `
        <div class="row align-items-start">
            <div class="col-md-4">
                <label class="form-label">Thuộc tính</label>
                <select class="form-select attribute-name" required>
                    <option value="" disabled selected>Chọn thuộc tính</option>
                    ${availableAttributes.map(attr => `<option value="${attr.id}">${attr.name}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Giá trị</label>
                <select id="${selectId}" name="${nameAttr}" class="form-select attribute-values" multiple required></select>
            </div>
            <div class="col-md-2 d-grid">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-sm btn-outline-secondary mb-2" onclick="removeAttributeGroup(this)">X</button>
            </div>
        </div>
    `;

        wrapper.appendChild(container);

        const attrSelect = container.querySelector('.attribute-name');
        const valueSelect = container.querySelector('.attribute-values');

        attrSelect.addEventListener('change', function() {
            updateValues(this).then(() => {
                new Choices(`#${selectId}`, {
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: 'Chọn giá trị',
                    searchEnabled: true
                });
            });
        });

        attributeSelectorIndex++;
    }

    function updateValues(select) {
        return new Promise(resolve => {
            const attrId = select.value;
            const values = allValues.filter(v => v.attribute_id == attrId);
            const valueSelect = select.closest('.attribute-group').querySelector('.attribute-values');

            // Xóa Choices instance cũ nếu có
            if (valueSelect._choices) {
                valueSelect._choices.destroy();
            }

            valueSelect.innerHTML = '';
            values.forEach(v => {
                const option = document.createElement('option');
                option.value = v.id;
                option.textContent = v.value;
                valueSelect.appendChild(option);
            });

            resolve();
        });
    }


    function generateCombinations() {
        const selected = {};
        document.querySelectorAll('.attribute-group').forEach((group, i) => {
            const attrSelect = group.querySelector('.attribute-name');
            const attrId = attrSelect.value;
            const attrName = attrSelect.options[attrSelect.selectedIndex]?.text || '';
            const values = Array.from(group.querySelectorAll('.attribute-values option:checked')).map(opt => ({
                id: opt.value,
                name: opt.text
            }));

            if (!attrId || values.length === 0) return;
            selected[`${attrId}_${attrName}`] = values;
        });

        if (Object.keys(selected).length === 0) {
            alert('Vui lòng chọn ít nhất một giá trị cho thuộc tính.');
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
    <td colspan="7" class=" rounded-2 p-3">
        <!-- Tên biến thể -->
        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <div class="fw-bold fs-6">Phiên Bản : ${name}</div>
                <input type="hidden" name="variants[${index}][value_ids]" value="${valueIds}">
            </div>
        </div>

        <!-- Ảnh -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold text-dark">Ảnh sản phẩm:</label>
                <input type="file" name="variants[${index}][image]" class="form-control form-control-sm border-secondary" />
            </div>
        </div>

        <!-- Các input giá -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Giá Bán</label>
                <input type="number" name="variants[${index}][price]" class="form-control form-control-sm" placeholder="Giá Bán" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Giá Nhập</label>
                <input type="number" name="variants[${index}][import_price]" class="form-control form-control-sm" placeholder="Giá Nhập" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Giá Khuyến Mãi</label>
                <input type="number" name="variants[${index}][discount_price]" class="form-control form-control-sm" placeholder="Giá KM" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tồn kho</label>
                <input type="number" name="variants[${index}][stock]" class="form-control form-control-sm" placeholder="Tồn kho" required>
            </div>
        </div>

        <!-- Nút xoá -->
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); updateVariantCount()">
                    <i class="fas fa-trash-alt"></i> Xoá biến thể
                </button>
            </div>
        </div>
    </td>
`;

            tbody.appendChild(row);
        });

        document.getElementById('variants-container').style.display = 'block';
        updateVariantCount();
    }


    function cartesianProduct(arr) {
        if (arr.length === 0) return [];
        if (arr.length === 1) return arr[0].map(item => [item]); // ✅ wrap lại object
        return arr.reduce((a, b) =>
            a.flatMap(d => b.map(e => [].concat(d, e)))
        );
    }

    function updateVariantCount() {
        const count = document.querySelectorAll('#variant-list tr').length;
        document.getElementById('variant-count').innerText = count;
    }

    function removeAttributeGroup(button) {
        button.closest('.attribute-group').remove();
        setTimeout(() => {
            // Cập nhật lại danh sách thuộc tính khi xóa
            document.querySelectorAll('.attribute-group').forEach(group => {
                const select = group.querySelector('.attribute-name');
                const currentValue = select.value;

                const selectedAttributeIds = Array.from(document.querySelectorAll('.attribute-name'))
                    .map(s => s.value)
                    .filter(v => v !== '');

                const availableAttributes = allAttributes.filter(attr =>
                    !selectedAttributeIds.includes(attr.id.toString()) || attr.id.toString() === currentValue
                );

                select.innerHTML = `<option value="" disabled ${currentValue === "" ? 'selected' : ''}>Chọn thuộc tính</option>`;
                availableAttributes.forEach(attr => {
                    const option = document.createElement('option');
                    option.value = attr.id;
                    option.textContent = attr.name;
                    if (attr.id.toString() === currentValue) option.selected = true;
                    select.appendChild(option);
                });
            });
        }, 100);
    }


    let subImageIndex = 0;

    // ẢNH CHÍNH (Ảnh đại diện)
    function previewMainImage(event) {
        const file = event.target.files[0];
        const previewBox = document.getElementById('main-image-preview');
        previewBox.innerHTML = '';

        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement('div');
            wrapper.className = 'position-relative';
            wrapper.style.width = '80px';
            wrapper.style.height = '80px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rounded object-fit-cover';
            img.style.width = '100%';
            img.style.height = '100%';

            // Xoá ảnh chính
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.innerHTML = '&times;';
            delBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 p-0 px-1';
            delBtn.onclick = function() {
                previewBox.innerHTML = '';
                document.getElementById('main-image-input').value = '';
            };

            wrapper.appendChild(img);
            wrapper.appendChild(delBtn);
            previewBox.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    }

    // ẢNH PHỤ (nhiều ảnh)
    function previewSubImages(event) {
        const files = event.target.files;
        const previewBox = document.getElementById('sub-image-preview-box');

        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const wrapper = createSubImageWrapper(e.target.result);
                previewBox.appendChild(wrapper);
                subImageIndex++;
            };

            reader.readAsDataURL(files[i]);
        }
    }

    function addSubImageByUrl() {
        const url = prompt("Nhập URL ảnh phụ:");
        if (!url) return;

        const previewBox = document.getElementById('sub-image-preview-box');
        const wrapper = createSubImageWrapper(url);
        previewBox.appendChild(wrapper);
        subImageIndex++;
    }

    function createSubImageWrapper(src) {
        const wrapper = document.createElement('div');
        wrapper.className = 'position-relative me-2';
        wrapper.style.width = '80px';
        wrapper.style.height = '80px';

        const img = document.createElement('img');
        img.src = src;
        img.className = 'rounded object-fit-cover';
        img.style.width = '100%';
        img.style.height = '100%';

        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.innerHTML = '&times;';
        delBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 p-0 px-1';
        delBtn.onclick = function() {
            wrapper.remove();
        };

        wrapper.appendChild(img);
        wrapper.appendChild(delBtn);
        return wrapper;
    }

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
</script>
<style>
    /* Tuỳ biến giao diện tag của Choices.js */
    .choices__list--multiple .choices__item {
        background-color: #1CC89B !important;
        /* Màu xanh nhạt */
        color: white !important;
        /* Chữ đen */
        border-radius: 50px !important;
        /* Bo tròn */
        padding: 4px 10px 4px 12px !important;
        font-weight: 500;
        font-size: 16px;
        margin: 3px 5px 3px 0;
        border: 1px solid #1CC89B;
    }

    /* Nút xoá (×) */
    .choices__list--multiple .choices__item .choices__button {
        color: #007bff !important;
        /* Màu xanh dương */
        margin-left: 6px;
        font-size: 20px;
        line-height: 1;
    }
</style>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

@endsection
