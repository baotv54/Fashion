@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold text-primary">Hướng dẫn chọn size</h3>
        <a href="{{ route('sizes.create') }}" class="btn btn-success shadow">
            <i data-feather="plus" class="me-1"></i> Thêm Size Mới
        </a>
    </div>
    <div class="mb-3">
        <h5 class="fw-semibold">Bảng kích cỡ</h5>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card shadow rounded-4 border-0">
        <div class="card-body table-responsive p-0">
            <table class="table align-middle mb-0 text-center" style="min-width: 700px;">
                <thead style="background: #2d3a4a; color: #fff;">
                    <tr style="font-size: 1.1rem;">
                        <th class="rounded-start">SIZE</th>
                        <th>Chiều cao (cm)</th>
                        <th>Cân nặng (kg)</th>
                        <th>Rộng ngực (cm)</th>
                        <th class="rounded-end">Rộng mông (cm)</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sizes as $index => $size)
                        <tr style="font-size: 1.05rem; background: {{ $index % 2 == 1 ? '#f5f7fa' : '#fff' }};">
                            <td class="fw-bold text-primary text-uppercase">{{ $size->size }}</td>
                            <td>{{ $size->height_range }}</td>
                            <td>{{ $size->weight_range }}</td>
                            <td>{{ $size->chest_range }}</td>
                            <td>{{ $size->hip_range }}</td>
                            <td>
                                <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-sm btn-warning me-1 shadow-sm" title="Sửa">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa size này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Xóa">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted text-center">Chưa có size nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>
@endpush

@endsection

<style>
    .table th, .table td {
        vertical-align: middle !important;
    }
    .table th {
        font-weight: 600;
        letter-spacing: 0.5px;
        background: #2d3a4a !important;
        color: #fff !important;
    }
    .table td {
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .table tr {
        border-bottom: 1px solid #e5e7eb;
    }
    @media (max-width: 900px) {
        .table {
            font-size: 0.95rem;
        }
    }
    @media (max-width: 600px) {
        .table {
            font-size: 0.9rem;
        }
        .table th, .table td {
            padding: 0.4rem 0.2rem;
        }
    }
</style> 