@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <h4 class="mb-4">DANH SÁCH SẢN PHẨM BỊ XÓA</h4>

    @if(session('success'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Ngày xóa</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="fw-bold">{{ $product->id }}</td>
                        <td>
                            <img src="{{ asset($product->image ?? 'images/no-image.png') }}"
                                alt="{{ $product->name }}"
                                class="rounded"
                                style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td>
                            <div>
                                <strong>{{ $product->name }}</strong><br>
                                <small class="text-muted">{{ Str::limit($product->slug, 50) }}</small>
                            </div>
                        </td>
                        <td class="text-danger fw-bold">{{ number_format($product->price, 0) }} đ</td>
                        <td>{{ $product->deleted_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <form action="{{ route('products.restore', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    Khôi phục
                                </button>
                            </form>
                            <!-- Form xóa vĩnh viễn -->
                            <form action="{{ route('products.forceDelete', $product->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('⚠️ Bạn có chắc muốn xóa VĨNH VIỄN sản phẩm này? Tất cả dữ liệu liên quan (biến thể, đơn hàng) cũng sẽ bị xóa!')">
                                    Xóa vĩnh viễn
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <i class="ti ti-box me-1"></i> Không có sản phẩm nào đã bị xóa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection