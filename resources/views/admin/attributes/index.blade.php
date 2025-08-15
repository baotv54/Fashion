@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Danh Sách Thuộc Tính</h3>
        <a href="{{ route('attributes.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Thuộc Tính Mới
        </a>
    </div>

    <!-- Thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bảng danh sách -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Tên Thuộc Tính</th>
                        <th width="30%">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('attribute_values.index', $attribute->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i data-feather="list"></i> Giá trị
                            </a>
                            <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa thuộc tính này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-muted text-center">Không có thuộc tính nào.</td>
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
