@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4">Tạo đơn trả hàng cho đơn nhập <strong>{{ $import->code ?? '---' }}</strong></h4>

    <div class="row">
        <!-- Danh sách sản phẩm hoàn trả -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Sản phẩm hoàn trả</strong>
                </div>
                <div class="card-body table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>SKU</th>
                                <th>Số lượng</th>
                                <th>Đơn giá trả</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($import->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image ?? 'https://via.placeholder.com/50' }}"
                                                 alt="" width="50" class="me-2 rounded">
                                            <span>{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item->product->sku }}</td>
                                    <td>
                                        <input type="number" name="return_qty[{{ $item->id }}]"
                                               class="form-control" min="0" max="{{ $item->quantity }}" value="0">
                                        <small class="text-muted">Tối đa: {{ $item->quantity }}</small>
                                    </td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                    <td>0đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hoàn tiền -->
            <div class="card">
                <div class="card-header">
                    <strong>Hoàn tiền</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6">Giá trị hàng trả</div>
                        <div class="col-6 text-end">0đ</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Chi phí</div>
                        <div class="col-6 text-end">0đ</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">Giảm trừ trả hàng</div>
                        <div class="col-6 text-end">0đ</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6"><strong>Giá trị hoàn trả</strong></div>
                        <div class="col-6 text-end"><strong>0đ</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin NCC & Bổ sung -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><strong>Nhà cung cấp</strong></div>
                <div class="card-body">
                    <p><strong>{{ $import->supplier->name }}</strong></p>
                    <p class="mb-1">{{ $import->supplier->phone }}</p>
                    <p class="mb-1">{{ $import->supplier->email ?? 'Không có email' }}</p>
                    <p class="mb-0">{{ $import->supplier->address }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Thông tin bổ sung</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Mã đơn hoàn trả</label>
                        <input type="text" name="return_code" class="form-control" placeholder="Nhập mã đơn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lý do hoàn trả</label>
                        <textarea name="return_reason" class="form-control" rows="3" placeholder="Nhập lý do hoàn trả"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút hành động -->
    <div class="mt-3">
        <button class="btn btn-primary">Lưu đơn trả hàng</button>
        <a href="{{ route('imports.index') }}" class="btn btn-secondary">Hủy</a>
    </div>
</div>
@endsection
