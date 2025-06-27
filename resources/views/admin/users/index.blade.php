@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-4 text-center">Danh sách Tài Khoản</h1>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Nút thêm mới --}}
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Tài Khoản
        </a>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
<<<<<<< HEAD
                        <th>Vai trò</th>
=======
                        <th>Password</th>
>>>>>>> feature/search-product
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
<<<<<<< HEAD
                            <td>{{ $user->role }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-outline-warning me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#roleModal"
                                    data-id="{{ $user->id }}"
                                    data-role="{{ $user->role }}"
                                    title="Phân quyền"
                                >
                                    <i data-feather="edit"></i>
                                </button>

=======
                            <td>{{ $user->password}}</td>
                            
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Chỉnh sửa">
                                    <i data-feather="edit"></i>
                                </a>
>>>>>>> feature/search-product
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $user->id }})" title="Xoá">
                                    <i data-feather="trash-2"></i>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
<<<<<<< HEAD
                            <td colspan="5" class="text-muted">Không có người dùng nào.</td>
=======
                            <td colspan="5" class="text-muted">Không có thương hiệu nào.</td>
>>>>>>> feature/search-product
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<<<<<<< HEAD
{{-- Modal Phân Quyền --}}
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="roleForm" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Phân Quyền Người Dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="role" class="form-label">Vai Trò</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="manage">Manage</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary">✔️ Cập nhật</button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
=======
{{-- Nhúng script trực tiếp --}}
>>>>>>> feature/search-product
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
<<<<<<< HEAD
        const roleModal = document.getElementById('roleModal');
        roleModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            const userRole = button.getAttribute('data-role');

            const form = document.getElementById('roleForm');
            form.action = `/admin/users/${userId}`; // Cập nhật action đúng user

            const roleSelect = form.querySelector('#role');
            roleSelect.value = userRole;
        });
    });

    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa Người dùng này không?")) {
=======
    });

    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa thương hiệu này không?")) {
>>>>>>> feature/search-product
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
