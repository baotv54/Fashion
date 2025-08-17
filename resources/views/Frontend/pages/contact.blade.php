@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Liên hệ với chúng tôi</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email') }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại <small class="text-muted"></small></label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       placeholder="VD: 0901234567"
                                       value="{{ old('phone') }}">
                                <small class="form-text text-muted">Để chúng tôi liên hệ nhanh hơn</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Chủ đề <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" 
                                       placeholder="VD: Hỏi về sản phẩm, Khiếu nại, Góp ý..."
                                       value="{{ old('subject') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      required>{{ old('message') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <span id="submitText">Gửi liên hệ</span>
                                <span id="loadingText" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Đang gửi...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin liên hệ -->
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Thông tin liên hệ</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt text-primary"></i> Địa chỉ</h5>
                            <p>123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-phone text-primary"></i> Điện thoại</h5>
                            <p>+84 123 456 789</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-envelope text-primary"></i> Email</h5>
                            <p>contact@example.com</p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-clock text-primary"></i> Giờ làm việc</h5>
                            <p>Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingText = document.getElementById('loadingText');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitText.classList.add('d-none');
        loadingText.classList.remove('d-none');
    });
});
</script>
@endsection 