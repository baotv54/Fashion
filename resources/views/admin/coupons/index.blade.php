@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">🎟️ Danh sách mã giảm giá</h2>
        <a href="{{ route('coupons.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm mã mới
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Đóng">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Đơn hàng tối thiểu</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Lượt sử dụng</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coupons as $coupon)
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $coupon->type === 'percent' ? 'info' : 'secondary' }} text-white">
                                    {{ $coupon->type === 'percent' ? 'Phần trăm' : 'Số tiền cố định' }}
                                </span>
                            </td>
    
                            <td>
                                {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value) . '₫' }}
                            </td>
                            <td>{{ number_format($coupon->min_cart_value) }}₫</td>
                            <td>{{ $coupon->start_date ? $coupon->start_date->format('d/m/Y') : 'Không có' }}</td>
                            <td>{{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : 'Không có' }}</td>
                            <td>{{ $coupon->used }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                            <td>
                                @if($coupon->image)
                                <img src="{{ asset($coupon->image) }}" class="img-thumbnail" style="max-width: 130px;">
                                @else
                                <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td style="max-width: 200px;">{{ $coupon->description }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa mã này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if($coupons->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Không có mã giảm giá nào.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection