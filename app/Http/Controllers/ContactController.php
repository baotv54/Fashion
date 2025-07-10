<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Notification; // KHÔNG SỬ DỤNG
use Illuminate\Support\Facades\Auth;
// use App\Models\User; // KHÔNG SỬ DỤNG
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // ======================= COMMENTED - KHÔNG SỬ DỤNG =======================
    /**
     * Hiển thị trang liên hệ - KHÔNG CẦN THIẾT VÌ DÙNG ROUTE CLOSURE
     */
    // public function show()
    // {
    //     return view('Frontend.pages.pages.lien-he');
    // }
    // =====================================================================

    /**
     * Xử lý gửi form liên hệ - CHỨC NĂNG CHÍNH
     */
    public function store(ContactRequest $request)
    {
        // Debug logging
        Log::info('Contact form submitted', [
            'data' => $request->all(),
            'url' => $request->url(),
            'method' => $request->method()
        ]);
        
        try {
            // Lưu thông tin liên hệ vào database
            $contact = Contact::create($request->validated());
            
            Log::info('Contact saved successfully', ['contact_id' => $contact->id]);

            // ======================= COMMENTED - CHƯA IMPLEMENT =======================
            // Gửi email thông báo cho admin (sẽ implement sau)
            // $this->notifyAdmin($contact);
            // =====================================================================

            // Trả về response thành công
            return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
            
        } catch (\Exception $e) {
            Log::error('Contact form error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.')
                        ->withInput();
        }
    }

    /**
     * Hiển thị danh sách liên hệ trong admin panel - CHỨC NĂNG ADMIN
     */
    public function index(Request $request)
    {
        $query = Contact::with('repliedBy');

        // Lọc theo status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(15);

        // Thống kê
        $stats = [
            'total' => Contact::count(),
            'pending' => Contact::where('status', 'pending')->count(),
            'processing' => Contact::where('status', 'processing')->count(),
            'replied' => Contact::where('status', 'replied')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Cập nhật status liên hệ - CHỨC NĂNG ADMIN
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,replied,closed'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    /**
     * Gửi phản hồi cho người liên hệ - CHỨC NĂNG CHÍNH ADMIN
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|min:10|max:2000'
        ], [
            'admin_reply.required' => 'Vui lòng nhập nội dung phản hồi.',
            'admin_reply.min' => 'Phản hồi phải có ít nhất 10 ký tự.',
            'admin_reply.max' => 'Phản hồi không được vượt quá 2000 ký tự.',
        ]);

        $contact = Contact::findOrFail($id);
        
        // Cập nhật thông tin phản hồi
        $contact->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => Auth::id() ?? 1 // Lấy ID user đang đăng nhập
        ]);

        // Gửi email phản hồi cho người dùng
        try {
            Mail::to($contact->email)->send(new ContactReplyMail($contact));
            
            Log::info('Contact reply email sent successfully', [
                'contact_id' => $contact->id,
                'user_email' => $contact->email,
                'admin_id' => Auth::id() ?? 1,
                'sent_at' => now()
            ]);
            
            return back()->with('success', '✅ Phản hồi đã được gửi thành công! Email đã được gửi đến ' . $contact->email);
            
        } catch (\Exception $e) {
            Log::error('Failed to send contact reply email', [
                'contact_id' => $contact->id,
                'user_email' => $contact->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('warning', '⚠️ Phản hồi đã được lưu thành công nhưng không thể gửi email. Kiểm tra cấu hình email. Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Xóa liên hệ - CHỨC NĂNG ADMIN
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('success', 'Đã xóa liên hệ thành công!');
    }

    // ======================= COMMENTED - KHÔNG SỬ DỤNG =======================
    /**
     * Gửi thông báo cho admin khi có liên hệ mới - CHƯA IMPLEMENT
     */
    // private function notifyAdmin(Contact $contact)
    // {
    //     try {
    //         // Gửi cho tất cả admin
    //         $admins = User::where('role', 'admin')->get();
            
    //         Notification::send($admins, new NewContactNotification($contact));
            
    //     } catch (\Exception $e) {
    //         \Log::error('Failed to notify admin about new contact: ' . $e->getMessage());
    //     }
    // }

    /**
     * Method thừa không sử dụng
     */
    // private function sendReplyEmail(Contact $contact)
    // {
    //     try {
    //         Mail::to($contact->email)->send(new ContactReplyMail($contact));
    //         return true;
    //     } catch (\Exception $e) {
    //         Log::error('Failed to send reply email: ' . $e->getMessage());
    //         return false;
    //     }
    // }
    // =====================================================================
}
