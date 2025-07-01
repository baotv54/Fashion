@extends('layouts.admin')

@section('title', 'Chi tiết liên hệ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Chi tiết liên hệ #{{ $contact->id }}</h4>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Thông tin liên hệ -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông tin liên hệ</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Họ tên:</strong>
                            <p>{{ $contact->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $contact->email }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Số điện thoại:</strong>
                            <p>{{ $contact->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Thời gian gửi:</strong>
                            <p>{{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Nội dung tin nhắn:</strong>
                        <div class="border p-3 mt-2 bg-light">
                            {{ $contact->message }}
                        </div>
                    </div>

                    @if($contact->admin_reply)
                    <div class="mb-3">
                        <strong>Phản hồi từ Admin:</strong>
                        <div class="border p-3 mt-2 bg-success bg-opacity-10">
                            {{ $contact->admin_reply }}
                        </div>
                        <small class="text-muted">
                            Phản hồi bởi: {{ $contact->repliedBy->name ?? 'N/A' }} 
                            vào {{ $contact->replied_at ? $contact->replied_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Form phản hồi -->
            @if(!$contact->admin_reply || $contact->status !== 'replied')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Gửi phản hồi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contacts.reply', $contact->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="admin_reply" class="form-label">Nội dung phản hồi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('admin_reply') is-invalid @enderror" 
                                      id="admin_reply" 
                                      name="admin_reply" 
                                      rows="6" 
                                      placeholder="Nhập nội dung phản hồi cho khách hàng..."
                                      required>{{ old('admin_reply') }}</textarea>
                            @error('admin_reply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i data-feather="send"></i> Gửi phản hồi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Quản lý trạng thái</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Trạng thái hiện tại:</strong>
                        <div class="mt-2">
                            @switch($contact->status)
                                @case('pending')
                                    <span class="badge bg-warning fs-6">{{ $contact->status_label }}</span>
                                    @break
                                @case('processing')
                                    <span class="badge bg-info fs-6">{{ $contact->status_label }}</span>
                                    @break
                                @case('replied')
                                    <span class="badge bg-success fs-6">{{ $contact->status_label }}</span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-secondary fs-6">{{ $contact->status_label }}</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <form method="POST" action="{{ route('contacts.updateStatus', $contact->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Cập nhật trạng thái:</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $contact->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                                <option value="closed" {{ $contact->status == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i data-feather="refresh-cw"></i> Cập nhật trạng thái
                        </button>
                    </form>

                    <hr>

                    <div class="d-grid">
                        <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}" 
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa liên hệ này? Hành động này không thể hoàn tác.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i data-feather="trash-2"></i> Xóa liên hệ
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Thông tin thêm -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Thông tin thêm</h5>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p><strong>ID liên hệ:</strong> #{{ $contact->id }}</p>
                        <p><strong>Thời gian tạo:</strong><br>{{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
                        <p><strong>Lần cập nhật cuối:</strong><br>{{ $contact->updated_at->format('d/m/Y H:i:s') }}</p>
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

@if(session('error'))
<script>
    toastr.error('{{ session('error') }}');
</script>
@endif

@endsection 