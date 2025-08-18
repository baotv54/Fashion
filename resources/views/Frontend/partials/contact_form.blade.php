<!-- Thông báo success/error -->
@if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; margin: 15px 0; border-radius: 8px; border: 1px solid #c3e6cb;">
        <strong>✅ Thành công!</strong> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; margin: 15px 0; border-radius: 8px; border: 1px solid #f5c6cb;">
        <strong>❌ Có lỗi!</strong> {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; margin: 15px 0; border-radius: 8px; border: 1px solid #f5c6cb;">
        <strong>❌ Lỗi validation:</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('contact.store') }}" id="contact-form" 
      style="background: white; padding: 30px; border-radius: 12px; margin-top: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);">
    @csrf
    
    <div style="margin-bottom: 20px;">
        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            Tên của bạn <span style="color: red;">*</span>
        </label>
        <input required type="text" id="name" name="name" 
            placeholder="Nhập họ và tên đầy đủ" 
            value="{{ old('name') }}" 
            style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;">
    </div>
    
    <div style="margin-bottom: 20px;">
        <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            Số điện thoại <span style="color: red;">*</span>
        </label>
        <input required type="tel" id="phone" name="phone" 
            placeholder="Nhập số điện thoại (VD: 0901234567)" 
            value="{{ old('phone') }}" 
            style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;">
    </div>
    
    <div style="margin-bottom: 20px;">
        <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            Email <span style="color: red;">*</span>
        </label>
        <input required type="email" id="email" name="email" 
            placeholder="Nhập địa chỉ email"
            value="{{ old('email') }}" 
            style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; box-sizing: border-box;">
    </div>
    
    <div style="margin-bottom: 20px;">
        <label for="message" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
            Nội dung tin nhắn <span style="color: red;">*</span>
        </label>
        <textarea required rows="6" id="message" name="message" 
                  placeholder="Nhập nội dung bạn muốn liên hệ, góp ý hoặc thắc mắc..."
                  style="width: 100%; padding: 12px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 16px; resize: vertical; min-height: 120px; box-sizing: border-box;">{{ old('message') }}</textarea>
    </div>
    
    <div style="margin-top: 30px;">
        <button type="submit" id="submit-btn" 
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                       color: white; 
                       padding: 15px 30px; 
                       border: none; 
                       border-radius: 8px; 
                       cursor: pointer; 
                       font-size: 16px; 
                       font-weight: 600; 
                       min-width: 150px;
                       transition: all 0.3s ease;">
            <span id="btn-text">Gửi thông tin</span>
            <span id="btn-loading" style="display: none;">⏳ Đang gửi...</span>
        </button>
    </div>
</form>

<!-- Debug info -->
<div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-family: monospace; font-size: 12px;">
    <strong>🔧 Debug Info:</strong><br>
    📍 Route: {{ route('contact.store') }}<br>
    🔒 CSRF Token: {{ csrf_token() }}<br>
    📝 Method: POST<br>
    🌐 Current URL: {{ request()->fullUrl() }}<br>
    @if(old())
        🔄 Old Input: {{ json_encode(old()) }}<br>
    @endif
</div>

<script>
// Đơn giản hóa JavaScript - không phụ thuộc vào external libraries
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Contact form loaded');
    
    const form = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnLoading = document.getElementById('btn-loading');

    if (!form || !submitBtn) {
        console.error('❌ Form elements not found');
        return;
    }

    form.addEventListener('submit', function(e) {
        console.log('📤 Form submitting...');
        
        // Hiển thị loading
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        
        // Log form data
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        console.log('📋 Form data:', data);
        
        // Validation đơn giản
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        const message = document.getElementById('message').value.trim();
        
        if (!name || !phone || !email || !message) {
            e.preventDefault();
            alert('❌ Vui lòng điền đầy đủ thông tin!');
            
            // Reset button
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            return false;
        }
        
        if (phone.length < 10) {
            e.preventDefault();
            alert('❌ Số điện thoại phải có ít nhất 10 số!');
            
            // Reset button
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            return false;
        }
        
        console.log('✅ Form validation passed, submitting...');
        // Form sẽ submit bình thường
    });
    
    // Reset button state if page loads with errors
    if (document.querySelector('.alert-danger')) {
        submitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        console.log('🔄 Reset button state due to errors');
    }
});
</script>

<style>
/* Inline CSS để tránh phụ thuộc external files */
#contact-form input:focus,
#contact-form textarea:focus {
    border-color: #667eea !important;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

#contact-form #submit-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

#contact-form #submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

@media (max-width: 768px) {
    #contact-form {
        padding: 20px !important;
        margin: 10px !important;
    }
}
</style> 