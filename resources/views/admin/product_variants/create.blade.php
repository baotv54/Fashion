@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Thêm biến thể cho: {{ $product->name }}</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('product_variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Vùng chọn thuộc tính để sinh biến thể -->
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
                <select name="attributes[${attributeSelectorIndex}][]" class="form-select attribute-values" multiple required></select>
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

    function cartesianProduct(arr) {
    if (arr.length === 0) return [];
    if (arr.length === 1) return arr[0].map(item => [item]); // ✅ wrap lại object
    return arr.reduce((a, b) =>
        a.flatMap(d => b.map(e => [].concat(d, e)))
    );
}


    function generateCombinations() {
        const selected = {};
        document.querySelectorAll('.attribute-group').forEach((group, i) => {
            const attrSelect = group.querySelector('.attribute-name');
            const attrId = attrSelect.value;
            const values = Array.from(group.querySelectorAll('.attribute-values option:checked')).map(opt => ({
                id: opt.value,
                name: opt.text
            }));

            if (!attrId || values.length === 0) return;

            const attrObj = allAttributes.find(a => a.id == attrId);
            const attrName = attrObj ? attrObj.name : `Thuộc tính ${attrId}`;
            selected[`${attrId}_${attrName}`] = values;
        });

        const selectedValues = Object.values(selected);

        if (selectedValues.length === 0 || selectedValues.some(v => v.length === 0)) {
            alert('Vui lòng chọn ít nhất một giá trị cho mỗi thuộc tính.');
            return;
        }

        const combinations = cartesianProduct(selectedValues);


        const tbody = document.getElementById('variant-list');
        tbody.innerHTML = '';

        combinations.forEach((combo, index) => {
            const name = combo.map(v => v.name).join(' / ');
            console.log('Combo:', combo);
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



    function updateVariantCount() {
        const count = document.querySelectorAll('#variant-list tr').length;
        document.getElementById('variant-count').innerText = count;
    }
</script>
@endsection
