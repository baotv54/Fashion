@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container py-4">
    <h4 class="fw-bold mb-3">Danh sách User đã xóa (Thùng rác)</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày xóa</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->deleted_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Khôi phục user này?')">
                                    Khôi phục
                                </button>
                            </form>

                            <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa vĩnh viễn user này? Lưu Ý Khi xóa người dùng này thì mọi thông tin liên quan đều bị xóa gây thất thoát dữ liệu trong hệ thống ')">
                                    Xóa vĩnh viễn
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Không có user nào trong thùng rác.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 px-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
