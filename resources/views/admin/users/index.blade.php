@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="card">
    <div class="card-datatable">
        @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">

                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <button class="btn add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceBrandList"><span><i class="icon-base ti tabler-plus icon-16px me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Thêm Tài khoản</span></span></button>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <ul class="nav nav-tabs mb-3">
                        @php
                        $roles = [
                        'all' => 'Tất cả',
                        'admin' => 'Quản Trị Viên',
                        'manage' => 'Nhân Viên',
                        'user' => 'Khách Hàng',
                        ];
                        @endphp
                        @foreach ($roles as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }}"
                                href="{{ route('users.index', ['status' => $key]) }}">
                                {{ $label }} (<small style="color: red;">{{ $counts [$key] ?? 0 }}</small>)
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <table class="datatables-brand-list table dataTable dtr-column" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup>
                            <col style="width: 40px;">
                            <col>
                            <col style="width: 200px;">
                            <col style="width: 150px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>

                                </td>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" class="text-primary fw-bold" style="text-decoration: none;">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button
                                            class="btn btn-sm btn-icon btn-outline-warning" title="Sửa"
                                            data-bs-toggle="modal"
                                            data-bs-target="#roleModal"
                                            data-id="{{ $user->id }}"
                                            data-role="{{ $user->role }}"
                                            title="Phân quyền">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </button>
                                        @if($user->role === 'admin')
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAdminModal{{ $user->id }}" title="Xóa Admin">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteAdminModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteAdminModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteAdminModalLabel{{ $user->id }}">Xác nhận xóa Admin</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Bạn đang xóa admin <strong>{{ $user->name }}</strong>. Vui lòng nhập mật khẩu để xác nhận:</p>
                                                            <div class="mb-3">
                                                                <label for="password{{ $user->id }}" class="form-label">Mật khẩu:</label>
                                                                <input type="password" name="password" id="password{{ $user->id }}" class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <!-- Xóa user bình thường bằng icon -->
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa user này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Xóa User">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Không có tài khoản nào nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($users->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $users->firstItem() }} đến {{ $users->lastItem() }} trong tổng số {{ $users->total() }} danh mục
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $users->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $users->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($users->getUrlRange(
                                max(1, $users->currentPage() - 2),
                                min($users->lastPage(), $users->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($users->lastPage() > $users->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $users->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $users->url($users->lastPage()) }}">
                                        <i class="icon-base ti tabler-chevrons-right icon-18px"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceBrandList" aria-labelledby="offcanvasEcommerceBrandListLabel" aria-modal="true" role="dialog">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header py-6">
        <h5 id="offcanvasEcommerceBrandListLabel" class="offcanvas-title">Thêm thương hiệu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <!-- Offcanvas Body -->
    <div class="offcanvas-body border-top">
        <form action="{{ route('users.store') }}" method="POST" id="eCommerceBrandListForm" class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework">
            @csrf
            <!-- Tên thương hiệu -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="Brand-title">Tên</label>
                <input type="text" class="form-control" id="Brand-title" name="name" placeholder="Nhập tên thương hiệu" aria-label="Brand title">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="Brand-title">Email</label>
                <input type="text" class="form-control" id="Brand-title" name="email" placeholder="Nhập Email" aria-label="Brand title">
                @error('email')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="Brand-title">Password</label>
                <input type="text" class="form-control" id="Brand-title" name="password" placeholder="Nhập Email" aria-label="Brand title">
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Trạng thái -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="Brand-status">Quyền</label>
                <select id="Brand-status" name="role" class="form-select">
                    <option value="#" selected disabled>{{ old('role', $users->role ?? '') }}</option>
                    <option value="admin">Quản Trị Viên</option>
                    <option value="user">Người Dùng</option>
                    <option value="manage">Nhân viên</option>
                </select>
            </div>
            <!-- Submit -->
            <div class="mb-6">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Thêm</button>
            </div>
        </form>
    </div>
</div>


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
                <input type="hidden" name="current_role" id="currentRole">
                <div class="mb-3">
                    <label for="role" class="form-label">Vai Trò</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="admin">Admin</option>
                        <option value="manage">Nhân viên</option>
                        <option value="user">Người dùng</option>
                    </select>
                </div>
                <div class="mb-3" id="passwordField" style="display:none;">
                    <label for="password" class="form-label">Nhập mật khẩu để xác nhận</label>
                    <input type="password" name="password" id="passwordInput" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary">✔️ Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const roleModal = document.getElementById('roleModal');
        roleModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            const currentRole = button.getAttribute('data-role');

            const form = document.getElementById('roleForm');
            form.action = `/admin/users/${userId}`;
            document.getElementById('currentRole').value = currentRole;

            const roleSelect = form.querySelector('#role');
            roleSelect.value = currentRole;

            const passwordField = document.getElementById('passwordField');

            // Hiển thị ô nhập mật khẩu nếu đổi từ admin sang role khác
            roleSelect.addEventListener('change', function() {
                if (currentRole === 'admin' && roleSelect.value !== 'admin') {
                    passwordField.style.display = 'block';
                    document.getElementById('passwordInput').required = true;
                } else {
                    passwordField.style.display = 'none';
                    document.getElementById('passwordInput').required = false;
                }
            });

            // Trigger lần đầu khi modal mở
            if (currentRole === 'admin' && roleSelect.value !== 'admin') {
                passwordField.style.display = 'block';
                document.getElementById('passwordInput').required = true;
            } else {
                passwordField.style.display = 'none';
                document.getElementById('passwordInput').required = false;
            }
        });
    });
</script>
@endsection