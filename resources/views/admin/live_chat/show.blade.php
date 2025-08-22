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
                <form id="plc-admin-reply" method="post" action="{{ route('admin.plc.reply') }}" class="d-flex gap-2" enctype="multipart/form-data">
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
@push('scripts')
    <script>
        (function(){
            const threadId = {{ $thread->id }};
            const box = document.getElementById('chat-box');
            let lastId = {{ optional($messages->last())->id ?? 0 }};
            let pollTimer = null;
            const replyForm = document.getElementById('plc-admin-reply');

            function appendMessage(payload){
                const wrap = document.createElement('div');
                wrap.className = 'msg ' + (payload.sender || 'staff');
                if (payload.message) {
                    const t = document.createElement('div');
                    t.textContent = payload.message;
                    wrap.appendChild(t);
                }
                if (Array.isArray(payload.attachments)){
                    payload.attachments.forEach(a=>{
                        if (a.type === 'image'){
                            const img = document.createElement('img');
                            img.src = a.url; img.style.maxWidth='240px'; img.style.borderRadius='8px';
                            wrap.appendChild(img);
                        } else if (a.type === 'video'){
                            const vid = document.createElement('video');
                            vid.src = a.url; vid.controls = true; vid.style.maxWidth='260px'; vid.style.borderRadius='8px';
                            wrap.appendChild(vid);
                        }
                    });
                }
                const meta = document.createElement('div'); meta.className = 'meta'; meta.textContent = (payload.sender||'') + ' • ' + (payload.timestamp||'');
                wrap.appendChild(meta);
                box.appendChild(wrap);
                box.scrollTop = box.scrollHeight;
            }

            if (replyForm){
                replyForm.addEventListener('submit', async (e)=>{
                    e.preventDefault();
                    const fd = new FormData(replyForm);
                    try{
                        const res = await fetch(replyForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: fd
                        });
                        const data = await res.json();
                        if(!res.ok) throw new Error(data.message||'Reply failed');
                        // append once
                        appendMessage({
                            sender: data.data.sender,
                            message: data.data.message,
                            attachments: data.data.attachments || [],
                            timestamp: data.data.created_at
                        });
                        if (typeof data.data.id !== 'undefined') {
                            lastId = Math.max(lastId||0, Number(data.data.id)||0);
                        }
                        // clear inputs
                        replyForm.querySelector('input[name="message"]').value = '';
                        const fileInput = replyForm.querySelector('input[name="file"]');
                        if(fileInput) fileInput.value = '';
                    }catch(err){
                        console.warn('[PLC][admin] reply error', err);
                    }
                });
            }

            async function pollOnce(){
                try{
                    const url = new URL("{{ route('plc.poll') }}", window.location.origin);
                    url.searchParams.set('thread_id', threadId);
                    url.searchParams.set('since_id', String(lastId||0));
                    const res = await fetch(url);
                    const data = await res.json();
                    if(!res.ok) throw new Error(data.message||'Poll failed');
                    if (Array.isArray(data.messages) && data.messages.length){
                        data.messages.forEach(m => {
                            appendMessage({ sender: m.sender, message: m.message, attachments: m.attachments||[], timestamp: m.created_at });
                        });
                    }
                    if (typeof data.last_id !== 'undefined') lastId = data.last_id;
                }catch(err){ console.warn('[PLC][admin] poll error', err); }
            }

            function startPolling(){
                if (!pollTimer) {
                    // poll ngay lần đầu để cập nhật tức thì
                    pollOnce();
                    pollTimer = setInterval(pollOnce, 3000);
                }
            }
            function stopPolling(){ if (pollTimer) { clearInterval(pollTimer); pollTimer = null; } }

            // Start polling on load; admin page is always open
            startPolling();
        })();
    </script>
@endpush
