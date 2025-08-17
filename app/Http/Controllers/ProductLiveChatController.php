<?php

namespace App\Http\Controllers;

use App\Models\ProductLiveChatMessage;
use App\Models\ProductLiveChatAttachment;
use App\Models\ProductLiveChatThread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductLiveChatController extends Controller
{
    private function getSessionToken(Request $request): string
    {
        // Dùng session để lưu token duy nhất cho phiên duyệt
        $token = $request->session()->get('plc_session_token');
        if (!$token) {
            $token = Str::random(40);
            $request->session()->put('plc_session_token', $token);
        }
        return $token;
    }

    public function start(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $sessionToken = $this->getSessionToken($request);
        $userId = auth()->check() ? auth()->id() : null;
        $productId = (int) $request->input('product_id');

        $thread = ProductLiveChatThread::firstOrCreate(
            [
                'product_id' => $productId,
                'session_token' => $sessionToken,
            ],
            [
                'user_id' => $userId,
                'status' => 'open',
            ]
        );

        return response()->json([
            'thread_id' => $thread->id,
            'status' => $thread->status,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|integer|exists:product_live_chat_threads,id',
            'message' => 'required|string|max:5000',
        ]);

        $thread = ProductLiveChatThread::findOrFail($request->input('thread_id'));

        // Chỉ cho phép gửi trong đúng session
        $sessionToken = $this->getSessionToken($request);
        if ($thread->session_token !== $sessionToken) {
            return response()->json(['message' => 'Phiên không hợp lệ.'], 403);
        }

        $msg = ProductLiveChatMessage::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'sender' => 'user',
            'message' => $request->input('message'),
        ]);

        return response()->json([
            'message' => 'Đã gửi',
            'data' => [
                'id' => $msg->id,
                'created_at' => $msg->created_at,
            ],
        ]);
    }

    public function history(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|integer|exists:product_live_chat_threads,id',
        ]);

        $thread = ProductLiveChatThread::findOrFail($request->input('thread_id'));
        $sessionToken = $this->getSessionToken($request);
        if ($thread->session_token !== $sessionToken) {
            return response()->json(['message' => 'Phiên không hợp lệ.'], 403);
        }

        $messages = $thread->messages()
            ->with('attachments')
            ->orderBy('created_at')
            ->get();

        $result = $messages->map(function ($m) {
            return [
                'id' => $m->id,
                'sender' => $m->sender,
                'message' => $m->message,
                'created_at' => $m->created_at,
                'attachments' => $m->attachments->map(function ($a) {
                    $path = str_starts_with($a->path, 'public/') ? substr($a->path, 7) : $a->path;
                    return [
                        'id' => $a->id,
                        'type' => $a->type,
                        'mime' => $a->mime,
                        'size' => $a->size,
                        'url' => Storage::disk('public')->url($path),
                    ];
                }),
            ];
        });

        return response()->json([
            'thread_id' => $thread->id,
            'messages' => $result,
        ]);
    }

    public function sendAttachment(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|integer|exists:product_live_chat_threads,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp,mp4,webm,mov,avi|max:102400', // max ~100MB
        ]);

        $thread = ProductLiveChatThread::findOrFail($request->input('thread_id'));

        // Chỉ cho phép gửi trong đúng session (người dùng phía frontend)
        $sessionToken = $this->getSessionToken($request);
        if ($thread->session_token !== $sessionToken) {
            return response()->json(['message' => 'Phiên không hợp lệ.'], 403);
        }

        $file = $request->file('file');
        $mime = $file->getMimeType();
        $isVideo = str_starts_with($mime, 'video/');
        $type = $isVideo ? 'video' : 'image';

        // Lưu vào public disk để có thể truy cập qua URL
        $path = $file->store('live_chat', 'public');

        // Tạo message đại diện cho lần gửi file
        $msg = ProductLiveChatMessage::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'sender' => 'user',
            'message' => null,
        ]);

        $attachment = ProductLiveChatAttachment::create([
            'message_id' => $msg->id,
            'path' => $path,
            'type' => $type,
            'mime' => $mime,
            'size' => $file->getSize(),
        ]);

        return response()->json([
            'message' => 'Đã gửi tệp',
            'data' => [
                'message_id' => $msg->id,
                'attachment' => [
                    'id' => $attachment->id,
                    'type' => $attachment->type,
                    'mime' => $attachment->mime,
                    'size' => $attachment->size,
                    'url' => Storage::disk('public')->url($attachment->path),
                ],
            ],
        ]);
    }
}
