<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLiveChatMessage;
use App\Models\ProductLiveChatThread;
use App\Models\ProductLiveChatAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductLiveChatAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductLiveChatThread::query();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', (int) $request->input('product_id'));
        }

        $threads = $query->latest('updated_at')->paginate(20);
        return view('Admin.live_chat.index', compact('threads'));
    }

    public function show(int $id)
    {
        $thread = ProductLiveChatThread::findOrFail($id);
        $messages = $thread->messages()->with('attachments')->orderBy('created_at')->get();
        return view('Admin.live_chat.show', compact('thread', 'messages'));
    }

    public function reply(Request $request)
    {
        $data = $request->validate([
            'thread_id' => 'required|integer|exists:product_live_chat_threads,id',
            'message' => 'nullable|string|max:5000',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,mov,avi|max:102400',
        ]);

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return back()->with('error', 'Vui lòng nhập tin nhắn hoặc chọn tệp.');
        }

        $thread = ProductLiveChatThread::findOrFail($data['thread_id']);

        $msg = ProductLiveChatMessage::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'sender' => 'staff',
            'message' => $data['message'] ?? null,
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mime = $file->getMimeType();
            $type = str_starts_with($mime, 'video/') ? 'video' : 'image';
            $path = $file->store('live_chat', 'public');

            ProductLiveChatAttachment::create([
                'message_id' => $msg->id,
                'path' => $path,
                'type' => $type,
                'mime' => $mime,
                'size' => $file->getSize(),
            ]);
        }

        return redirect()->route('admin.plc.show', $thread->id)->with('success', 'Đã gửi trả lời');
    }

    public function close(int $id)
    {
        $thread = ProductLiveChatThread::findOrFail($id);
        $thread->status = 'closed';
        $thread->save();

        return redirect()->route('admin.plc.show', $thread->id)->with('success', 'Đã đóng cuộc trò chuyện');
    }
}
