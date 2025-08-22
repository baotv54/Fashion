@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Giá Trị Thuộc Tính: <span class="text-primary">{{ $attribute->name }}</span></h3>
        <a href="{{ route('attribute_values.create', $attribute->id) }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Giá Trị Mới
        </a>
    </div>

    {{-- Hiển thị thông báo lỗi --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Giá Trị</th>
                        <th width="20%">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attributeValues as $value)
                    <tr>
                        <td>{{ $value->value }}</td>
                        <td class="text-center">
                            <a href="{{ route('attribute_values.edit', [$attribute->id, $value->id]) }}" class="btn btn-sm btn-outline-warning me-1">
                                sửa </a>
                            <form action="{{ route('attribute_values.destroy', [$attribute->id, $value->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa giá trị này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Xóa </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-muted text-center">Chưa có giá trị nào cho thuộc tính này.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
</script>
@endpush
@endsection
