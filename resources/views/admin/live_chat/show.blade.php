@extends('layouts.admin')
@section('content')
@include('admin.live_chat._show', ['thread' => $thread, 'messages' => $messages])
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
