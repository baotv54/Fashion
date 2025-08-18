@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat - Thread #{{ $thread->id }}</title>
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
    <style>
        .container { max-width: 1000px; margin: 24px auto; }
        .chat-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; height: 460px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; }
        .msg { max-width: 75%; padding: 8px 10px; border-radius: 10px; font-size: 14px; line-height: 1.35; }
        .msg.user { align-self: flex-end; background: #10b981; color: #fff; border-bottom-right-radius: 4px; }
        .msg.staff { align-self: flex-start; background: #fff; color: #111827; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
        .meta { font-size: 12px; color: #6b7280; margin-top: 2px; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Live Chat - Thread #{{ $thread->id }}</h2>
        <div>
            <a href="{{ route('admin.plc.index') }}" class="btn btn-secondary">Quay lại</a>
            @if($thread->status !== 'closed')
                <form action="{{ route('admin.plc.close', $thread->id) }}" method="post" class="d-inline">
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Đóng cuộc trò chuyện này?')">Đóng</button>
                </form>
            @else
                <span class="badge bg-danger">Đã đóng</span>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3"><strong>Product ID:</strong> {{ $thread->product_id }}</div>
                <div class="col-md-3"><strong>User ID:</strong> {{ $thread->user_id ?? '-' }}</div>
                <div class="col-md-3"><strong>Status:</strong> {{ $thread->status }}</div>
                <div class="col-md-3"><strong>Session:</strong> {{ $thread->session_token }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="chat-box mb-3" id="chat-box">
                @foreach($messages as $m)
                    <div class="msg {{ $m->sender }}">
                        @if(!empty($m->message))
                            <div>{{ $m->message }}</div>
                        @endif
                        @if($m->relationLoaded('attachments'))
                            @foreach($m->attachments as $a)
                                @if($a->type === 'image')
                                    <div class="mt-1"><img src="{{ Storage::disk('public')->url(str_starts_with($a->path,'public/') ? substr($a->path,7) : $a->path) }}" alt="attachment" style="max-width:240px;border-radius:8px"></div>
                                @elseif($a->type === 'video')
                                    <div class="mt-1"><video src="{{ Storage::disk('public')->url(str_starts_with($a->path,'public/') ? substr($a->path,7) : $a->path) }}" controls style="max-width:260px;border-radius:8px"></video></div>
                                @endif
                            @endforeach
                        @endif
                        <div class="meta">{{ ucfirst($m->sender) }} • {{ $m->created_at }}</div>
                    </div>
                @endforeach
            </div>

            @if($thread->status !== 'closed')
                <form method="post" action="{{ route('admin.plc.reply') }}" class="d-flex gap-2" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                    <input type="text" name="message" class="form-control" placeholder="Nhập trả lời..." maxlength="5000">
                    <input type="file" name="file" accept="image/*,video/*" class="form-control" style="max-width:280px">
                    <button class="btn btn-primary">Gửi</button>
                </form>
            @else
                <div class="alert alert-warning m-0">Cuộc trò chuyện đã đóng. Không thể gửi thêm tin nhắn.</div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
@endsection
