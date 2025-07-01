@extends('layouts.admin')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Quản lý liên hệ</h4>
                </div>
                
                <div class="card-body">
                    <!-- Thống kê nhanh -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1">Tổng liên hệ</p>
                                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i data-feather="message-circle" class="icon-dual icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1">Chờ xử lý</p>
                                            <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i data-feather="clock" class="icon-dual icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1">Đang xử lý</p>
                                            <h3 class="mb-0">{{ $stats['processing'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i data-feather="play-circle" class="icon-dual icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-1">Đã phản hồi</p>
                                            <h3 class="mb-0">{{ $stats['replied'] }}</h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i data-feather="check-circle" class="icon-dual icon-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bộ lọc -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('contacts.index') }}" class="d-flex">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên, email, SĐT..." value="{{ request('search') }}">
                                </div>
                                <select class="form-select me-2" name="status" style="width: 200px;">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="search"></i> Lọc
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Bảng danh sách -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>STT</th>
                                    <th>Thông tin liên hệ</th>
                                    <th>Tin nhắn</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $index => $contact)
                                <tr>
                                    <td>{{ $contacts->firstItem() + $index }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ $contact->name }}</strong><br>
                                            <small class="text-muted">
                                                <i data-feather="mail" class="icon-sm"></i> {{ $contact->email }}<br>
                                                <i data-feather="phone" class="icon-sm"></i> {{ $contact->phone }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            {{ Str::limit($contact->message, 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @switch($contact->status)
                                            @case('pending')
                                                <span class="badge bg-warning">{{ $contact->status_label }}</span>
                                                @break
                                            @case('processing')
                                                <span class="badge bg-info">{{ $contact->status_label }}</span>
                                                @break
                                            @case('replied')
                                                <span class="badge bg-success">{{ $contact->status_label }}</span>
                                                @break
                                            @case('closed')
                                                <span class="badge bg-secondary">{{ $contact->status_label }}</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <small>
                                            {{ $contact->created_at->format('d/m/Y H:i') }}<br>
                                            <span class="text-muted">{{ $contact->created_at->diffForHumans() }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-sm btn-primary">
                                                <i data-feather="eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa liên hệ này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i data-feather="inbox" class="icon-lg mb-2"></i>
                                            <p>Không có liên hệ nào</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center">
                        {{ $contacts->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    toastr.success('{{ session('success') }}');
</script>
@endif

@endsection 