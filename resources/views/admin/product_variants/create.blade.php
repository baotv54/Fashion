@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Thêm biến thể cho: {{ $product->name }}</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('product_variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Thuộc tính và biến thể -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div>
                        <h6 class="card-title mb-1">Thuộc tính</h6>
                        <small class="text-muted">Sản phẩm có nhiều thuộc tính khác nhau. Ví dụ: kích thước, màu sắc.</small>
                    </div>
                    <a href="#" class="text-primary" onclick="addAttributeSelector(); return false;">+ Thêm thuộc tính</a>
                </div>
                <div id="attribute-select-area" class="mb-3"></div>
                <button type="button" class="btn btn-sm btn-success mb-2" onclick="generateCombinations()">+ Sinh tổ hợp phiên bản</button>
            </div>
        </div>

        <div id="variants-container" style="display:none">
            <h5 class="mb-3">Danh sách phiên bản (<span id="variant-count">0</span>)</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Thuộc tính</th>
                            <th>Giá bán</th>
                            <th>Tồn kho</th>
                            <th>Hình ảnh</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="variant-list"></tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Thêm Sản Phẩm</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<!-- Include Scripts & Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
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
            <td><input type="hidden" name="variants[${index}][value_ids]" value="${valueIds}">${name}</td>
            <td><input type="number" name="variants[${index}][price]" class="form-control" placeholder="Giá" required></td>
            <td><input type="number" name="variants[${index}][stock]" class="form-control" placeholder="Số lượng" required></td>
            <td><input type="file" name="variants[${index}][image]" class="form-control"></td>
            <td><button type="button" class="btn btn-sm btn-outline-secondary mb-2" onclick="this.closest('tr').remove(); updateVariantCount()">X</button></td>
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

</script>

<style>
    .choices__list--multiple .choices__item {
        background-color: #1CC89B !important;
        color: white !important;
        border-radius: 50px !important;
        padding: 4px 10px 4px 12px !important;
        font-weight: 500;
        font-size: 16px;
        margin: 3px 5px 3px 0;
        border: 1px solid #1CC89B;
    }
    .choices__list--multiple .choices__item .choices__button {
        color: #007bff !important;
        margin-left: 6px;
        font-size: 20px;
        line-height: 1;
    }
</style>
@endsection
