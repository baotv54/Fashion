<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ProductVariant;
use Gloudemans\Shoppingcart\Facades\Cart;


class ChatBotController extends Controller
{
    public function getHistory(Request $request)
    {
        $token = session('chat_token');
    
        // Nếu user đăng nhập mà không có token (vì session bị reset)
        if (!$token && auth()->check()) {
            $session = ChatSession::where('user_id', auth()->id())->first();
            if ($session) {
                $token = $session->session_token;
                session(['chat_token' => $token]);
            }
        }
    
        if (!$token) {
            return response()->json(['history' => []]);
        }
    
        $chatSession = ChatSession::where('session_token', $token)->first();
        if (!$chatSession) {
            return response()->json(['history' => []]);
        }
    
        // Lấy tin nhắn theo thứ tự thời gian
        $messages = $chatSession->messages()->orderBy('created_at')->get();
    
        $history = $messages->map(function ($msg) {
            return [
                'role' => $msg->role,
                'message' => $msg->message,
                'section' => $msg->section, // thêm section nếu có
            ];
        });
    
        return response()->json([
            'history' => $history,
        ]);
    }
    

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json([
                'reply' => 'Vui lòng nhập nội dung.',
                'products' => []
            ], 400);
        }
    
        $token = session('chat_token');
    
        if (!$token) {
            if (auth()->check()) {
                $existing = ChatSession::where('user_id', auth()->id())->first();
                $token = $existing?->session_token ?? Str::uuid();
            } else {
                $token = Str::uuid();
            }
            session(['chat_token' => $token]);
        }
    
        $chatSession = ChatSession::firstOrCreate(
            ['session_token' => $token],
            ['user_id' => auth()->id()]
        );
    
        // ✅ Lấy lịch sử hội thoại gần nhất
        $history = $chatSession->messages()
            ->latest()
            ->take(5)
            ->orderBy('created_at')
            ->get()
            ->map(function ($m) {
                return [
                    'role' => $m->role === 'bot' ? 'model' : $m->role,
                    'parts' => [['text' => $m->message]]
                ];
            })
            ->toArray();
    
        // ✅ Prompt gửi Gemini
        $prompt = <<<EOD
        Bạn là chatbot hỗ trợ khách hàng. Dưới đây là yêu cầu từ người dùng.
    
        Hãy:
        1. Xác định ý định: "faq" nếu là câu hỏi, hoặc "product_search" nếu là tìm sản phẩm.
        2. Viết câu trả lời tự nhiên, thân thiện và hữu ích.
        3. Nếu là tìm sản phẩm, phân tích thêm category, brand, price_max (nếu có).
    
        TRẢ VỀ JSON đúng định dạng:
        {
          "intent": "faq" hoặc "product_search",
          "reply": "Câu trả lời dành cho người dùng",
          "filters": {
            "category": string (nếu có),
            "brand": string (nếu có),
            "price_max": number (nếu có)
          }
        }
    
        KHÔNG giải thích gì thêm. Câu từ người dùng: "$message"
        EOD;
    
        $contents = array_merge($history, [
            [
                'role' => 'user',
                'parts' => [['text' => $prompt]]
            ]
        ]);
    
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY');
    
            $response = Http::post($url, ['contents' => $contents]);
    
            if ($response->failed()) {
                Log::error('Gemini API lỗi', ['body' => $response->body()]);
                return response()->json([
                    'reply' => 'Lỗi khi gọi AI. Vui lòng thử lại.',
                    'products' => []
                ], 500);
            }
    
            $data = $response->json();
            $replyText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $replyText = trim($replyText);
            $replyText = preg_replace('/^[^\{]*(\{.*\})[^\}]*$/s', '$1', $replyText);
            $result = json_decode($replyText, true);
    
            if (!is_array($result) || !isset($result['reply'])) {
                Log::warning('Phản hồi không hợp lệ từ Gemini', ['reply' => $replyText]);
                return response()->json([
                    'reply' => 'Xin lỗi, tôi chưa hiểu rõ câu hỏi. Bạn có thể hỏi lại không?',
                    'products' => []
                ]);
            }
    
            $intent = $result['intent'] ?? 'faq';
            $reply = $result['reply'];
            $filters = $result['filters'] ?? [];
    
            // ✅ Lưu tin nhắn người dùng
            ChatMessage::create([
                'chat_session_id' => $chatSession->id,
                'role' => 'user',
                'message' => $message,
            ]);
    
            // ✅ Nếu là câu hỏi thông thường thì chỉ lưu trả lời
            if ($intent === 'faq' || empty($filters)) {
                ChatMessage::create([
                    'chat_session_id' => $chatSession->id,
                    'role' => 'bot',
                    'message' => $reply,
                ]);
    
                return response()->json([
                    'reply' => $reply,
                    'products' => []
                ]);
            }
    
            // ✅ Nếu là tìm sản phẩm
            $query = Product::with(['brand', 'category']);
    
            if (!empty($filters['brand'])) {
                $query->whereHas('brand', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', '%' . $filters['brand'] . '%');
                });
            }
    
            if (!empty($filters['category'])) {
                $query->whereHas('category', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', '%' . $filters['category'] . '%');
                });
            }
    
            if (!empty($filters['price_max'])) {
                if (is_string($filters['price_max'])) {
                    $price = strtolower($filters['price_max']);
                    $price = str_replace(['triệu', 'tr', 'vnđ', 'vnd', 'đ', ',', ' '], '', $price);
                    if (is_numeric($price)) {
                        $filters['price_max'] = (float)$price * 1000000;
                    } else {
                        unset($filters['price_max']);
                    }
                }
    
                if (is_numeric($filters['price_max'])) {
                    $query->where('price', '<=', (int)$filters['price_max']);
                }
            }
    
            $products = $query->limit(5)->get();
    
            if ($products->isEmpty()) {
                return response()->json([
                    'reply' => "Không tìm thấy sản phẩm phù hợp. $reply",
                    'products' => []
                ]);
            }
    
            // ✅ Lưu tin nhắn và ID sản phẩm nếu có
            ChatMessage::create([
                'chat_session_id' => $chatSession->id,
                'role' => 'bot',
                'message' => $reply,
                'product_ids' => $products->pluck('id')->toArray(),
            ]);
    
            // ✅ Format trả về
            $productItems = [];
            foreach ($products as $product) {
                $productItems[] = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'brand'    => optional($product->brand)->name,
                    'category' => optional($product->category)->name,
                    'price'    => number_format($product->price) . 'đ',
                    'image'    => $product->image ? asset($product->image) : 'https://via.placeholder.com/100',
                    'url'      => url('/product/' . $product->id),
                ];
            }
    
            return response()->json([
                'reply' => $reply,
                'products' => $productItems
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý chatbot: ' . $e->getMessage());
            return response()->json([
                'reply' => 'Đã xảy ra lỗi nội bộ. Vui lòng thử lại sau.',
                'products' => []
            ], 500);
        }
    }
    

    public function addToCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = (int) $request->input('quantity', 1);
    
            if (!$productId || !is_numeric($productId)) {
                return response()->json(['message' => 'ID sản phẩm không hợp lệ'], 400);
            }
    
            $product = Product::find($productId);
    
            if (!$product) {
                return response()->json(['message' => 'Không tìm thấy sản phẩm'], 404);
            }
    
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $quantity,
                'price' => $product->price,
                'options' => [
                    'image' => $product->image,
                    'variant_attributes' => null,
                ],
            ]);
    
            return response()->json(['message' => 'Đã thêm sản phẩm vào giỏ hàng!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm sản phẩm vào giỏ hàng: ' . $e->getMessage());
            return response()->json(['message' => 'Lỗi hệ thống khi thêm vào giỏ hàng'], 500);
        }
    }
    
}
