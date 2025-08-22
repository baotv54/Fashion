<div id="plc-widget" data-product-id="{{ $productId ?? ($product->id ?? null) }}">
    <button id="plc-toggler" aria-label="Live Chat">💬</button>
    <div id="plc-popup" hidden>
        <div class="plc-header">
            <span>Hỗ trợ sản phẩm</span>
            <button id="plc-close" aria-label="Close">×</button>
        </div>
        <div id="plc-messages"></div>
        <div class="plc-form">
            <input id="plc-input" type="text" placeholder="Nhập tin nhắn..." maxlength="5000" />
            <input id="plc-file" type="file" accept="image/*,video/*" style="display:none" />
            <button id="plc-attach" title="Đính kèm">📎</button>
            <button id="plc-send">Gửi</button>
        </div>
    </div>
</div>

<style>
#plc-widget { position: fixed; right: 24px; bottom: 24px; z-index: 99990; font-family: system-ui, sans-serif; }
#plc-toggler { width: 52px; height: 52px; border-radius: 50%; border: none; background: #10b981; color: #fff; font-size: 22px; cursor: pointer; box-shadow: 0 8px 24px rgba(0,0,0,.15); }
#plc-popup { position: fixed; right: 24px; bottom: 88px; width: 340px; max-width: calc(100vw - 32px); background: #fff; border-radius: 12px; box-shadow: 0 20px 50px rgba(0,0,0,.15); overflow: hidden; display: flex; flex-direction: column; }
.plc-header { background: #10b981; color: #fff; padding: 10px 12px; display: flex; align-items: center; justify-content: space-between; font-weight: 600; }
#plc-close { background: transparent; color: #fff; border: none; font-size: 20px; cursor: pointer; }
#plc-messages { height: 320px; padding: 12px; overflow-y: auto; background: #f9fafb; display: flex; flex-direction: column; gap: 8px; }
.plc-msg { max-width: 80%; padding: 8px 10px; border-radius: 10px; font-size: 14px; line-height: 1.35; }
.plc-msg.user { align-self: flex-end; background: #10b981; color: #fff; border-bottom-right-radius: 4px; }
.plc-msg.staff { align-self: flex-start; background: #fff; color: #111827; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
.plc-form { display: flex; gap: 8px; padding: 10px; border-top: 1px solid #e5e7eb; background: #fff; }
#plc-input { flex: 1; border: 1px solid #d1d5db; border-radius: 8px; padding: 8px 10px; font-size: 14px; }
#plc-send { background: #10b981; color: #fff; border: none; border-radius: 8px; padding: 8px 12px; cursor: pointer; }
#plc-attach { background: #f3f4f6; color: #111827; border: 1px solid #e5e7eb; border-radius: 8px; padding: 8px 10px; cursor: pointer; }
@media (max-width:520px){ #plc-popup{ right:0; bottom:0; width:100%; height:60vh; border-radius: 12px 12px 0 0;} }
</style>

<script>
(function(){
    const root = document.getElementById('plc-widget');
    if (!root) return;
    const productId = root.dataset.productId;
    if (!productId) { console.warn('[PLC] Missing productId'); return; }

    const toggler = document.getElementById('plc-toggler');
    const popup = document.getElementById('plc-popup');
    const closeBtn = document.getElementById('plc-close');
    const list = document.getElementById('plc-messages');
    const input = document.getElementById('plc-input');
    const sendBtn = document.getElementById('plc-send');
    const attachBtn = document.getElementById('plc-attach');
    const fileInput = document.getElementById('plc-file');

    const key = (pid)=>`plc_thread_${pid}`;
    let threadId = localStorage.getItem(key(productId));

    let lastId = 0;
    let pollTimer = null;
    const renderedIds = new Set();

    async function pollOnce(){
        if (!threadId) return;
        try{
            const url = new URL("{{ route('plc.poll') }}", window.location.origin);
            url.searchParams.set('thread_id', threadId);
            url.searchParams.set('since_id', String(lastId||0));
            const res = await fetch(url);
            const data = await res.json();
            if(res.status === 403){
                localStorage.removeItem(key(productId));
                threadId = null; lastId = 0; list.innerHTML='';
                await startThread();
                return;
            }
            if(!res.ok) throw new Error(data.message||'Poll failed');
            if (Array.isArray(data.messages) && data.messages.length){
                data.messages.forEach(m => {
                    if (m && typeof m.id !== 'undefined') {
                        if (renderedIds.has(m.id)) return; // skip duplicates
                        renderedIds.add(m.id);
                    }
                    if (m.message) addMsg(m.message, m.sender, m.id);
                    if (m.attachments && m.attachments.length) {
                        m.attachments.forEach(a => addAttachment(a, m.sender, m.id));
                    }
                });
                list.scrollTop = list.scrollHeight;
            }
            if (typeof data.last_id !== 'undefined') lastId = data.last_id;
        }catch(err){ console.warn('[PLC] poll error', err); }
    }

    function startPolling(){
        if (pollTimer) return;
        // poll ngay để cập nhật tức thì
        pollOnce();
        pollTimer = setInterval(pollOnce, 3000);
    }
    function stopPolling(){
        if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
    }

    async function startThread(){
        try{
            const res = await fetch("{{ route('plc.start') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ product_id: productId })
            });
            const data = await res.json();
            if(!res.ok) throw new Error(data.message||'Start failed');
            threadId = data.thread_id; localStorage.setItem(key(productId), threadId);
            await loadHistory();
        }catch(e){ console.error('[PLC] start error', e); }
    }

    async function loadHistory(){
        if(!threadId) return;
        try{
            const url = new URL("{{ route('plc.history') }}", window.location.origin);
            url.searchParams.set('thread_id', threadId);
            const res = await fetch(url);
            const data = await res.json();
            if(res.status === 403){
                // session token changed => reset thread and start new
                localStorage.removeItem(key(productId));
                threadId = null; lastId = 0; list.innerHTML='';
                await startThread();
                return;
            }
            if(!res.ok) throw new Error(data.message||'History failed');
            list.innerHTML = '';
            renderedIds.clear();
            data.messages.forEach(m => {
                if (m && typeof m.id !== 'undefined') renderedIds.add(m.id);
                if (m.message) addMsg(m.message, m.sender, m.id);
                if (m.attachments && m.attachments.length) {
                    m.attachments.forEach(a => addAttachment(a, m.sender, m.id));
                }
            });
            list.scrollTop = list.scrollHeight;
            if (data.messages && data.messages.length){
                lastId = data.messages[data.messages.length - 1].id;
            }
        }catch(e){ console.error('[PLC] history error', e); }
    }

    async function send(){
        const text = (input.value||'').trim();
        if(!text || !threadId) return;
        const toSend = text;
        input.value='';
        try{
            const res = await fetch("{{ route('plc.send') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ thread_id: threadId, message: toSend })
            });
            const data = await res.json().catch(()=>({}));
            if(res.status === 403){
                // reset and retry once
                localStorage.removeItem(key(productId));
                threadId = null; lastId = 0;
                await startThread();
                if (toSend){
                    const res2 = await fetch("{{ route('plc.send') }}", {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        body: JSON.stringify({ thread_id: threadId, message: toSend })
                    });
                    const data2 = await res2.json().catch(()=>({}));
                    if (!res2.ok) throw new Error((data2&&data2.message)||'Send failed');
                    if (data2 && data2.data && typeof data2.data.id !== 'undefined') {
                        lastId = Math.max(lastId||0, Number(data2.data.id)||0);
                    }
                }
                return;
            }
            if(!res.ok){ throw new Error((data&&data.message)||'Send failed'); }
            // Append once and advance lastId so poll không lặp
            const newId = (data && data.data && typeof data.data.id !== 'undefined') ? Number(data.data.id) : null;
            if (newId !== null) { renderedIds.add(newId); }
            addMsg(toSend, 'user', newId);
            if (newId !== null) {
                lastId = Math.max(lastId||0, newId);
            }
        }catch(e){ console.error('[PLC] send error', e); }
        list.scrollTop = list.scrollHeight;
    }

    function addMsg(text, sender, id){
        const el = document.createElement('div');
        el.className = `plc-msg ${sender}`;
        el.textContent = text;
        list.appendChild(el);
    }

    function addAttachment(att, sender, msgId){
        const wrap = document.createElement('div');
        wrap.className = `plc-msg ${sender}`;
        if (att.type === 'image') {
            const img = document.createElement('img');
            img.src = att.url;
            img.alt = 'attachment';
            img.style.maxWidth = '220px';
            img.style.borderRadius = '8px';
            wrap.appendChild(img);
        } else if (att.type === 'video') {
            const vid = document.createElement('video');
            vid.src = att.url;
            vid.controls = true;
            vid.style.maxWidth = '240px';
            vid.style.borderRadius = '8px';
            wrap.appendChild(vid);
        }
        list.appendChild(wrap);
    }

    toggler.addEventListener('click', async ()=>{
        popup.hidden = !popup.hidden;
        if(!popup.hidden){
            if(!threadId) await startThread(); else { await loadHistory(); }
            startPolling();
        } else {
            stopPolling();
        }
    });
    closeBtn.addEventListener('click', ()=>{ popup.hidden = true; });
    sendBtn.addEventListener('click', send);
    input.addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ e.preventDefault(); send(); }});

    attachBtn.addEventListener('click', ()=> fileInput.click());
    fileInput.addEventListener('change', async (e)=>{
        if(!threadId){ await startThread(); }
        const f = e.target.files[0];
        if(!f || !threadId) return;
        try{
            const fd = new FormData();
            fd.append('thread_id', threadId);
            fd.append('file', f);
            const res = await fetch("{{ route('plc.attach') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: fd
            });
            const data = await res.json();
            if(res.status === 403){
                localStorage.removeItem(key(productId));
                threadId = null; lastId = 0;
                await startThread();
                return;
            }
            if(!res.ok) throw new Error(data.message||'Attach failed');
            addAttachment(data.data.attachment, 'user');
            if (data && data.data && typeof data.data.message_id !== 'undefined') {
                lastId = Math.max(lastId||0, Number(data.data.message_id)||0);
            }
            list.scrollTop = list.scrollHeight;
        }catch(err){ console.error('[PLC] attach error', err); }
        e.target.value = '';
    });

    // Lazy start thread so history is ready on first open next time
    if(!threadId){ startThread(); }
})();
</script>
