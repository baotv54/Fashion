    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.plc.index') }}" class="btn btn-secondary" title="Quay lại" aria-label="Quay lại">
                <span aria-hidden="true">←</span>
                <span class="visually-hidden">Quay lại</span>
            </a>
        </div>
        <div>
            @if($thread->status !== 'closed')
                <form action="{{ route('admin.plc.close', $thread->id) }}" method="post" class="d-inline">
                    @csrf
                    <button class="btn btn-danger" title="Đóng cuộc trò chuyện" aria-label="Đóng cuộc trò chuyện" onclick="return confirm('Đóng cuộc trò chuyện này?')">
                        <span aria-hidden="true">chặn</span>
                        <span class="visually-hidden">Đóng</span>
                    </button>
                </form>
            @else
                <span class="badge bg-danger">Đã đóng</span>
            @endif
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            @php
                $name = $thread->user->name ?? 'Khách ẩn danh';
                $avatar = $thread->user->avatar ?? null;
                if ($avatar) {
                    if (\Illuminate\Support\Str::startsWith($avatar, 'public/')) {
                        $avatar = substr($avatar, 7);
                    }
                    $isUrl = \Illuminate\Support\Str::startsWith($avatar, ['http://','https://','/']);
                    // Avatar được lưu tại public/avatars theo ProfileController
                    $avatarUrl = $isUrl ? $avatar : asset('avatars/' . ltrim($avatar, '/'));
                }
            @endphp
            <div class="d-flex align-items-center gap-3">
                @if(!empty($avatar))
                    <img src="{{ $avatarUrl }}" alt="avatar" width="48" height="48" style="border-radius:50%;object-fit:cover"
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=E5E7EB&color=374151&size=96';">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=E5E7EB&color=374151&size=96" alt="avatar" width="48" height="48" style="border-radius:50%;object-fit:cover">
                @endif
                <div>
                    <div style="font-weight:600; font-size:16px;">{{ $name }}</div>
                    @if($thread->status === 'closed')
                        <span class="badge bg-danger">Đã đóng</span>
                    @else
                        <span class="badge bg-success">Đang mở</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .chat-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; height: 460px; overflow-y: auto; display: flex; flex-direction: column; gap: 8px; }
        .msg { max-width: 75%; padding: 8px 10px; border-radius: 10px; font-size: 14px; line-height: 1.35; }
        .msg.user { align-self: flex-end; background: #10b981; color: #fff; border-bottom-right-radius: 4px; }
        .msg.staff { align-self: flex-start; background: #fff; color: #111827; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
        .meta { font-size: 12px; color: #6b7280; margin-top: 2px; }
    </style>

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
                        @php $senderLabel = $m->sender === 'user' ? 'Khách' : 'Nhân viên'; @endphp
                        <div class="meta">{{ $senderLabel }} • {{ $m->created_at }}</div>
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
 
