<!DOCTYPE html>
<html>
<head>
    <title>Simple Contact Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Simple Contact Form Test</h1>
    
    @if(session('success'))
        <div style="background: green; color: white; padding: 10px; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: red; color: white; padding: 10px; margin: 10px 0;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: red; color: white; padding: 10px; margin: 10px 0;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contact.store') }}" style="max-width: 500px;">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label>Họ và tên: *</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Email: *</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Số điện thoại:</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Tiêu đề: *</label><br>
            <input type="text" name="subject" value="{{ old('subject') }}" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Nội dung: *</label><br>
            <textarea name="message" required style="width: 100%; height: 100px; padding: 8px;">{{ old('message') }}</textarea>
        </div>

        <button type="submit" style="background: blue; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Gửi liên hệ
        </button>
    </form>

    <div style="margin-top: 20px;">
        <a href="{{ route('contact.show') }}">Quay lại trang liên hệ chính</a>
    </div>
</body>
</html> 