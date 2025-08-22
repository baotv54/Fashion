@extends('layouts.admin')

@section('content')


    <div class="container">
        <h2 class="mb-4">Quản lý Mạng Xã Hội</h2>

         {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Nút thêm mới --}}
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('social-links.create') }}" class="btn btn-primary">
                <i data-feather="plus" class="me-1"></i> Thêm Mới
            </a>
        </div>


        {{-- Bảng danh sách --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nền Tảng</th>

                            <th>Icon</th>
                            <th>Link</th>

                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($links as $link)
                            <tr>
                                <td>{{ $link->id }}</td>
                                <td>{{ $link->platform }}</td>
                                <td>
                                    <a href="{{ $link->url ?? '#' }}">
                                        <img src="{{ asset('storage/' . $link->image) }}" width="100px"
                                            style="max-height: 80px; object-fit: cover;" />
                                    </a>
                                </td>
                                <td> {{ $link->url }} </td>




                                <td>
                                    <a href="{{ route('social-links.edit', $link->id) }}"
                                        class="btn btn-sm btn-outline-warning me-1"
                                        onclick="return confirm('Bạn có chắc muốn chỉnh sửa không?')">
                                        <i data-feather="edit"></i> Sửa
                                    </a>

                                    <form action="{{ route('social-links.destroy', $link->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                            <i data-feather="trash-2"></i> Xoá
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Không có banner nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
