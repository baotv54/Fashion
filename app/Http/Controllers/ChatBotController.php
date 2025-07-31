<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ProductVariant;
use App\Models\ProductReview;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\OrderDetail;
use App\Models\Favorite;
use App\Helpers\ChatBotHelper;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ImageVector;

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
                'section' => $msg->section,
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
            ->take(10)
            ->orderBy('created_at')
            ->get()
            ->map(function ($m) {
                return [
                    'role' => $m->role === 'bot' ? 'model' : $m->role,
                    'parts' => [['text' => $m->message]]
                ];
            })
            ->toArray();
    
        // ✅ Lấy thông tin người dùng và xu hướng
        $userProfile = $this->getUserProfile();
        $trendingProducts = $this->getTrendingProducts();
        $userPreferences = $this->getUserPreferences();
        $seasonalInfo = ChatBotHelper::getSeasonalRecommendations();
        $userStyle = ChatBotHelper::analyzeUserStyle(auth()->id());
        $budgetAnalysis = ChatBotHelper::analyzeBudget(auth()->id());
    
        // ✅ Prompt nâng cao gửi Gemini
        $prompt = $this->buildAdvancedPrompt($message, $userProfile, $trendingProducts, $userPreferences, $seasonalInfo, $userStyle, $budgetAnalysis);
    
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
            $recommendations = $result['recommendations'] ?? [];
    
            // ✅ Lưu tin nhắn người dùng
            ChatMessage::create([
                'chat_session_id' => $chatSession->id,
                'role' => 'user',
                'message' => $message,
            ]);
    
            // ✅ Xử lý theo từng loại intent
            switch ($intent) {
                case 'faq':
                    return $this->handleFAQ($chatSession, $reply);
                
                case 'product_search':
                    return $this->handleProductSearch($chatSession, $reply, $filters, $recommendations);
                
                case 'style_advice':
                    return $this->handleStyleAdvice($chatSession, $reply, $filters);
                
                case 'size_help':
                    return $this->handleSizeHelp($chatSession, $reply, $filters);
                
                case 'comparison':
                    return $this->handleComparison($chatSession, $reply, $filters);
                
                default:
                    return $this->handleFAQ($chatSession, $reply);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi xử lý chatbot: ' . $e->getMessage());
            return response()->json([
                'reply' => 'Đã xảy ra lỗi nội bộ. Vui lòng thử lại sau.',
                'products' => []
            ], 500);
        }
    }
    

    /**
     * Xử lý câu hỏi thường
     */
    private function handleFAQ($chatSession, $reply)
    {
        ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'role' => 'bot',
            'message' => $reply,
        ]);

        // Nếu câu hỏi có từ khóa sản phẩm, tự động tìm và trả về sản phẩm liên quan
        $keyword = request()->input('message');
        $products = Product::where('name', 'LIKE', '%' . $keyword . '%')->where('status', 1)->get();
        $productItems = $this->formatProductResponse($products);

        // Nếu có sản phẩm khớp tên, ưu tiên trả về sản phẩm và trả lời ngắn gọn
        if ($products->count() > 0) {
            return response()->json([
                'reply' => 'Đây là sản phẩm bạn tìm kiếm:',
                'products' => $productItems
            ]);
        }
        // Nếu không có sản phẩm, trả về tư vấn như cũ
        return response()->json([
            'reply' => $reply,
            'products' => []
        ]);
    }

    /**
     * Xử lý tìm kiếm sản phẩm
     */
    private function handleProductSearch($chatSession, $reply, $filters, $recommendations)
    {
        $message = request()->input('message');
        $products = $this->searchProductsWithAdvancedFilters($filters, $recommendations, $message);
    
        if ($products->isEmpty()) {
            // ✅ Gợi ý sản phẩm thay thế
            $alternativeProducts = $this->getAlternativeProducts($filters);
            
            // ✅ Gợi ý cá nhân hóa
            $personalizedProducts = ChatBotHelper::getPersonalizedRecommendations(auth()->id());
            
            ChatMessage::create([
                'chat_session_id' => $chatSession->id,
                'role' => 'bot',
                'message' => $reply,
            ]);
            
            return response()->json([
                'reply' => $reply,
                'products' => $alternativeProducts,
                'personalized' => $personalizedProducts->take(3)->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'brand' => optional($product->brand)->name,
                        'category' => optional($product->category)->name,
                        'price' => number_format($product->price) . 'đ',
                        'image' => $product->image ? asset($product->image) : 'https://via.placeholder.com/100',
                        'url' => url('/product/' . $product->id),
                        'rating' => $product->reviews->avg('rating') ?? 0,
                        'is_personalized' => true
                    ];
                }),
                'suggestions' => $this->getSearchSuggestions($filters)
            ]);
        }
    
        // ✅ Lưu tin nhắn và ID sản phẩm nếu có
        ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'role' => 'bot',
            'message' => $reply,
            'product_ids' => $products->pluck('id')->toArray(),
        ]);
    
        // ✅ Format trả về với thông tin chi tiết
        $productItems = $this->formatProductResponse($products);
    
        return response()->json([
            'reply' => $reply,
            'products' => $productItems,
            'filters_applied' => $filters,
            'total_found' => $products->count(),
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Xử lý tư vấn phong cách
     */
    private function handleStyleAdvice($chatSession, $reply, $filters)
    {
        $styleAnalysis = ChatBotHelper::analyzeUserStyle(auth()->id());
        $outfitSuggestions = [];
        
        if (!empty($filters['product_id'])) {
            $outfitSuggestions = ChatBotHelper::generateOutfitSuggestions($filters['product_id']);
        }

        ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'role' => 'bot',
            'message' => $reply,
        ]);

        return response()->json([
            'reply' => $reply,
            'style_analysis' => $styleAnalysis,
            'outfit_suggestions' => $outfitSuggestions,
            'products' => []
        ]);
    }

    /**
     * Xử lý hỗ trợ size
     */
    private function handleSizeHelp($chatSession, $reply, $filters)
    {
        $sizeGuide = $this->getSizeGuide($filters);
        
        ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'role' => 'bot',
            'message' => $reply,
        ]);

        return response()->json([
            'reply' => $reply,
            'size_guide' => $sizeGuide,
            'products' => []
        ]);
    }

    /**
     * Xử lý so sánh sản phẩm
     */
    private function handleComparison($chatSession, $reply, $filters)
    {
        $products = collect();
        
        if (!empty($filters['product_ids'])) {
            $products = Product::with(['brand', 'category', 'reviews', 'variants'])
                ->whereIn('id', $filters['product_ids'])
                ->get();
        }

        ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'role' => 'bot',
            'message' => $reply,
        ]);

        return response()->json([
            'reply' => $reply,
            'comparison_data' => $this->formatComparisonData($products),
            'products' => []
        ]);
    }

    /**
     * Xây dựng prompt nâng cao với phân tích chi tiết
     */
    private function buildAdvancedPrompt($message, $userProfile, $trendingProducts, $userPreferences, $seasonalInfo, $userStyle, $budgetAnalysis)
    {
        // Helper chuyển mọi giá trị thành chuỗi
        $toString = function($val) {
            if (is_array($val)) return implode(', ', array_map(function($v) {
                return is_array($v) ? json_encode($v, JSON_UNESCAPED_UNICODE) : $v;
            }, $val));
            if (is_object($val)) return json_encode($val, JSON_UNESCAPED_UNICODE);
            return (string)$val;
        };

        $userPreferencesStr = $toString($userProfile['preferences'] ?? '');
        $seasonalKeywordsStr = $toString($seasonalInfo['keywords'] ?? '');
        $styleInfo = $toString($userStyle ?? '');
        $preferencesInfo = $toString($userPreferences ?? '');
        $trendingInfo = $trendingProducts->take(3)->map(function($p) {
            return "- {$p->name} ({$p->brand->name}) - " . number_format($p->price) . "đ";
        })->join("\n");

        return <<<EOD
        Bạn là chatbot tư vấn giày thông minh của F1GENZ Shoes. Phân tích yêu cầu từ người dùng và đưa ra tư vấn cá nhân hóa.

        THÔNG TIN NGƯỜI DÙNG:
        - Giới tính: {$toString($userProfile['gender'] ?? '')}
        - Độ tuổi: {$toString($userProfile['age_group'] ?? '')}
        - Sở thích: {$userPreferencesStr}
        - Lịch sử mua hàng: {$toString($userProfile['purchase_history'] ?? '')}
        - Phong cách: {$styleInfo}
        - Ngân sách: {$toString($budgetAnalysis['min'] ?? '')}đ - {$toString($budgetAnalysis['max'] ?? '')}đ (trung bình: {$toString($budgetAnalysis['avg'] ?? '')}đ)

        XU HƯỚNG HIỆN TẠI:
        $trendingInfo

        SỞ THÍCH NGƯỜI DÙNG:
        $preferencesInfo

        THÔNG TIN MÙA VỤ:
        - Mùa hiện tại: {$toString($seasonalInfo['season'] ?? '')}
        - Từ khóa phù hợp: {$seasonalKeywordsStr}

        PHÂN TÍCH YÊU CẦU:
        1. Xác định ý định: "faq", "product_search", "style_advice", "size_help", "comparison"
        2. Phân tích mục đích sử dụng: thể thao, đi làm, dạo phố, dự tiệc, chạy bộ, bóng đá, bóng rổ...
        3. Phân tích đối tượng: nam/nữ, độ tuổi, phong cách
        4. Xác định ngân sách và ưu tiên
        5. Đưa ra gợi ý phù hợp với mùa vụ

        TRẢ VỀ JSON:
        {
          "intent": "faq|product_search|style_advice|size_help|comparison",
          "reply": "Câu trả lời thân thiện và tư vấn chi tiết",
          "filters": {
            "category": "string",
            "brand": "string", 
            "price_min": number,
            "price_max": number,
            "size": "string",
            "color": "string",
            "purpose": "string",
            "gender": "string",
            "rating_min": number,
            "product_id": number,
            "product_ids": [number]
          },
          "recommendations": {
            "style": "string",
            "features": ["string"],
            "care_tips": ["string"],
            "seasonal_advice": "string"
          }
        }

        Câu từ người dùng: "$message"
        EOD;
    }

    /**
     * Lấy thông tin profile người dùng
     */
    private function getUserProfile()
    {
        if (!auth()->check()) {
            return [
                'gender' => 'unknown',
                'age_group' => 'unknown', 
                'preferences' => 'unknown',
                'purchase_history' => 'none'
            ];
        }

        $user = auth()->user();
        $orders = $user->orders()->with('details.product')->get();
        
        // Phân tích lịch sử mua hàng
        $purchasedCategories = $orders->flatMap(function($order) {
            return $order->details->pluck('product.category.name');
        })->countBy();

        $purchasedBrands = $orders->flatMap(function($order) {
            return $order->details->pluck('product.brand.name');
        })->countBy();

        return [
            'gender' => $this->analyzeGender($purchasedCategories),
            'age_group' => $this->analyzeAgeGroup($user, $purchasedCategories),
            'preferences' => $this->analyzePreferences($purchasedCategories, $purchasedBrands),
            'purchase_history' => $orders->count() . ' đơn hàng'
        ];
    }

    /**
     * Lấy sản phẩm trending
     */
    private function getTrendingProducts()
    {
        return Product::with(['brand', 'category', 'reviews'])
            ->where('status', 1)
            ->whereHas('reviews', function($q) {
                $q->where('rating', '>=', 4);
            })
            ->withCount(['reviews', 'favoritedByUsers'])
            ->orderBy('reviews_count', 'desc')
            ->orderBy('favorited_by_users_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Lấy sở thích người dùng
     */
    private function getUserPreferences()
    {
        if (!auth()->check()) {
            return [];
        }

        $user = auth()->user();
        
        // Sở thích từ lịch sử mua hàng
        $purchasePreferences = $user->orders()
            ->with('details.product.category')
            ->get()
            ->flatMap(function($order) {
                return $order->details->pluck('product.category.name');
            })
            ->countBy()
            ->sortDesc()
            ->take(3)
            ->keys()
            ->toArray();

        // Sở thích từ sản phẩm yêu thích
        $favoritePreferences = $user->favorites()
            ->with('product.category')
            ->get()
            ->pluck('product.category.name')
            ->countBy()
            ->sortDesc()
            ->take(3)
            ->keys()
            ->toArray();

        return [
            'categories' => array_unique(array_merge($purchasePreferences, $favoritePreferences)),
            'price_range' => $this->getUserPriceRange($user),
            'brands' => $this->getUserPreferredBrands($user)
        ];
    }

    /**
     * Tìm kiếm sản phẩm với bộ lọc nâng cao
     */
    private function searchProductsWithAdvancedFilters($filters, $recommendations, $message = null)
    {
        $query = Product::with(['brand', 'category', 'reviews', 'variants.attributeValues.attribute'])
            ->where('status', 1);

        // ✅ Tìm theo tên sản phẩm nếu có filter 'name' hoặc 'keyword'
        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['keyword'])) {
            $query->where('name', 'LIKE', '%' . $filters['keyword'] . '%');
        }
        // ✅ Nếu không có filter nào, fallback tìm theo message
        if (empty($filters) && !empty($message)) {
            $query->where('name', 'LIKE', '%' . $message . '%');
        }

        // ✅ Bộ lọc cơ bản
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

        // ✅ Bộ lọc giá nâng cao
        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', (int)$filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            if (is_string($filters['price_max'])) {
                $price = $this->parsePriceString($filters['price_max']);
                if ($price) {
                    $query->where('price', '<=', $price);
                }
            } else {
                $query->where('price', '<=', (int)$filters['price_max']);
            }
        }

        // ✅ Bộ lọc size
        if (!empty($filters['size'])) {
            $query->whereHas('variants.attributeValues', function ($q) use ($filters) {
                $q->whereHas('attribute', function ($attr) {
                    $attr->where('name', 'LIKE', '%size%');
                })->where('value', 'LIKE', '%' . $filters['size'] . '%');
            });
        }

        // ✅ Bộ lọc màu sắc
        if (!empty($filters['color'])) {
            $query->whereHas('variants.attributeValues', function ($q) use ($filters) {
                $q->whereHas('attribute', function ($attr) {
                    $attr->where('name', 'LIKE', '%màu%');
                })->where('value', 'LIKE', '%' . $filters['color'] . '%');
            });
        }

        // ✅ Bộ lọc rating
        if (!empty($filters['rating_min'])) {
            $query->whereHas('reviews', function ($q) use ($filters) {
                $q->where('rating', '>=', $filters['rating_min']);
            });
        }

        // ✅ Bộ lọc mục đích sử dụng
        if (!empty($filters['purpose'])) {
            $purposeKeywords = $this->getPurposeKeywords($filters['purpose']);
            $query->where(function ($q) use ($purposeKeywords) {
                foreach ($purposeKeywords as $keyword) {
                    $q->orWhere('name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        // ✅ Bộ lọc giới tính
        if (!empty($filters['gender'])) {
            $genderKeywords = $this->getGenderKeywords($filters['gender']);
            $query->where(function ($q) use ($genderKeywords) {
                foreach ($genderKeywords as $keyword) {
                    $q->orWhere('name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                }
            });
        }

        // ✅ Sắp xếp thông minh
        $query->withCount(['reviews', 'favoritedByUsers'])
              ->orderBy('reviews_count', 'desc')
              ->orderBy('favorited_by_users_count', 'desc')
              ->orderBy('price', 'asc');

        if (!empty($filters['keyword'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['keyword'] . '%')
                  ->orWhere('description', 'LIKE', '%' . $filters['keyword'] . '%')
                  ->orWhereHas('brand', function($b) use ($filters) {
                      $b->where('name', 'LIKE', '%' . $filters['keyword'] . '%');
                  })
                  ->orWhereHas('category', function($c) use ($filters) {
                      $c->where('name', 'LIKE', '%' . $filters['keyword'] . '%');
                  });
            });
        }

        return $query->limit(8)->get();
    }

    /**
     * Lấy sản phẩm thay thế
     */
    private function getAlternativeProducts($filters)
    {
        $query = Product::with(['brand', 'category', 'reviews'])
            ->where('status', 1)
            ->whereHas('reviews', function ($q) {
                $q->where('rating', '>=', 4);
            });

        // Loại bỏ các filter quá cụ thể
        if (!empty($filters['category'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['category'] . '%');
            });
        }

        return $query->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => optional($product->brand)->name,
                    'category' => optional($product->category)->name,
                    'price' => number_format($product->price) . 'đ',
                    'image' => $product->image ? asset($product->image) : 'https://via.placeholder.com/100',
                    'url' => url('/product/' . $product->id),
                    'rating' => $product->reviews->avg('rating') ?? 0,
                    'is_alternative' => true
                ];
            });
    }

    /**
     * Format response sản phẩm
     */
    private function formatProductResponse($products)
    {
        return $products->map(function ($product) {
            $avgRating = $product->reviews->avg('rating') ?? 0;
            $totalReviews = $product->reviews->count();
            
            // Lấy thông tin variants
            $variants = $product->variants->map(function ($variant) {
                $attributes = $variant->attributeValues->map(function ($attrValue) {
                    return $attrValue->attribute->name . ': ' . $attrValue->value;
                })->join(', ');
                
                return [
                    'id' => $variant->id,
                    'price' => number_format($variant->price) . 'đ',
                    'stock' => $variant->stock,
                    'attributes' => $attributes
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => optional($product->brand)->name,
                'category' => optional($product->category)->name,
                'price' => number_format($product->price) . 'đ',
                'image' => $product->image ? asset($product->image) : 'https://via.placeholder.com/100',
                'url' => url('/product/' . $product->id),
                'rating' => round($avgRating, 1),
                'total_reviews' => $totalReviews,
                'variants' => $variants,
                'description' => Str::limit($product->description, 100),
                'is_trending' => $product->reviews_count > 5 && $avgRating >= 4
            ];
        });
    }

    /**
     * Lấy gợi ý tìm kiếm
     */
    private function getSearchSuggestions($filters)
    {
        $suggestions = [];
        
        if (empty($filters['category'])) {
            $suggestions[] = 'Bạn có thể thử tìm theo danh mục: Giày thể thao, Giày chạy bộ, Giày bóng đá...';
        }
        
        if (empty($filters['price_max'])) {
            $suggestions[] = 'Bạn có thể đặt ngân sách tối đa để tôi gợi ý phù hợp hơn';
        }
        
        if (empty($filters['size'])) {
            $suggestions[] = 'Bạn có thể cho biết size giày để tôi kiểm tra hàng có sẵn';
        }

        return $suggestions;
    }

    /**
     * Lấy hướng dẫn size
     */
    private function getSizeGuide($filters)
    {
        return [
            'eu_sizes' => [
                '36' => '22.5cm', '37' => '23.5cm', '38' => '24cm', '39' => '24.5cm',
                '40' => '25cm', '41' => '25.5cm', '42' => '26cm', '43' => '26.5cm',
                '44' => '27cm', '45' => '27.5cm', '46' => '28cm'
            ],
            'us_sizes' => [
                '5' => '36', '6' => '37', '7' => '38', '8' => '39',
                '9' => '40', '10' => '41', '11' => '42', '12' => '43'
            ],
            'tips' => [
                'Đo chân vào cuối ngày khi chân đã giãn nở',
                'Đứng thẳng khi đo để có kết quả chính xác',
                'Nếu giữa 2 size, chọn size lớn hơn',
                'Với giày thể thao, nên chọn size lớn hơn 0.5'
            ]
        ];
    }

    /**
     * Format dữ liệu so sánh
     */
    private function formatComparisonData($products)
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => optional($product->brand)->name,
                'category' => optional($product->category)->name,
                'price' => number_format($product->price) . 'đ',
                'rating' => round($product->reviews->avg('rating') ?? 0, 1),
                'total_reviews' => $product->reviews->count(),
                'features' => $this->extractFeatures($product),
                'pros' => $this->getPros($product),
                'cons' => $this->getCons($product)
            ];
        });
    }

    /**
     * Trích xuất tính năng sản phẩm
     */
    private function extractFeatures($product)
    {
        $features = [];
        
        if (str_contains(strtolower($product->name), 'thể thao')) {
            $features[] = 'Thiết kế thể thao';
        }
        
        if (str_contains(strtolower($product->description ?? ''), 'thoáng')) {
            $features[] = 'Thoáng khí';
        }
        
        if (str_contains(strtolower($product->description ?? ''), 'mềm')) {
            $features[] = 'Đế mềm';
        }
        
        return $features;
    }

    /**
     * Lấy ưu điểm
     */
    private function getPros($product)
    {
        $pros = [];
        $avgRating = $product->reviews->avg('rating') ?? 0;
        
        if ($avgRating >= 4) {
            $pros[] = 'Đánh giá cao từ khách hàng';
        }
        
        if ($product->reviews->count() > 10) {
            $pros[] = 'Nhiều đánh giá';
        }
        
        return $pros;
    }

    /**
     * Lấy nhược điểm
     */
    private function getCons($product)
    {
        $cons = [];
        $avgRating = $product->reviews->avg('rating') ?? 0;
        
        if ($avgRating < 3) {
            $cons[] = 'Đánh giá thấp';
        }
        
        if ($product->reviews->count() < 5) {
            $cons[] = 'Ít đánh giá';
        }
        
        return $cons;
    }

    // ✅ Các helper methods
    private function parsePriceString($priceString)
    {
        $price = strtolower($priceString);
        $price = str_replace(['triệu', 'tr', 'vnđ', 'vnd', 'đ', ',', ' '], '', $price);
        
        if (is_numeric($price)) {
            return (float)$price * 1000000;
        }
        
        return null;
    }

    private function getPurposeKeywords($purpose)
    {
        $keywords = [
            'thể thao' => ['thể thao', 'sport', 'athletic'],
            'chạy bộ' => ['chạy', 'running', 'jogging'],
            'bóng đá' => ['bóng đá', 'football', 'soccer'],
            'bóng rổ' => ['bóng rổ', 'basketball'],
            'đi làm' => ['công sở', 'office', 'formal'],
            'dạo phố' => ['casual', 'street', 'dạo phố'],
            'dự tiệc' => ['party', 'tiệc', 'formal']
        ];

        return $keywords[$purpose] ?? [$purpose];
    }

    private function getGenderKeywords($gender)
    {
        return $gender === 'nam' ? ['nam', 'men', 'male'] : ['nữ', 'women', 'female'];
    }

    private function analyzeGender($purchasedCategories)
    {
        $maleCategories = ['bóng đá', 'bóng rổ', 'thể thao nam'];
        $femaleCategories = ['thời trang nữ', 'giày nữ'];
        
        $maleCount = collect($purchasedCategories)->filter(function($count, $category) use ($maleCategories) {
            return collect($maleCategories)->contains($category);
        })->sum();
        
        $femaleCount = collect($purchasedCategories)->filter(function($count, $category) use ($femaleCategories) {
            return collect($femaleCategories)->contains($category);
        })->sum();
        
        if ($maleCount > $femaleCount) return 'nam';
        if ($femaleCount > $maleCount) return 'nữ';
        return 'unknown';
    }

    private function analyzeAgeGroup($user, $purchasedCategories)
    {
        // Logic phân tích độ tuổi dựa trên sản phẩm đã mua
        $sportCategories = collect($purchasedCategories)->filter(function($count, $category) {
            return str_contains($category, 'thể thao') || str_contains($category, 'chạy');
        })->sum();
        
        if ($sportCategories > 0) return '18-35';
        return 'unknown';
    }

    private function analyzePreferences($purchasedCategories, $purchasedBrands)
    {
        $topCategories = collect($purchasedCategories)->sortDesc()->take(2)->keys()->join(', ');
        $topBrands = collect($purchasedBrands)->sortDesc()->take(2)->keys()->join(', ');
        
        return "Danh mục: $topCategories, Thương hiệu: $topBrands";
    }

    private function getUserPriceRange($user)
    {
        $orders = $user->orders()->with('details')->get();
        if ($orders->isEmpty()) return [0, 5000000];
        
        $prices = $orders->flatMap(function($order) {
            return $order->details->pluck('price');
        });
        
        return [$prices->min(), $prices->max()];
    }

    private function getUserPreferredBrands($user)
    {
        return $user->orders()
            ->with('details.product.brand')
            ->get()
            ->flatMap(function($order) {
                return $order->details->pluck('product.brand.name');
            })
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(3)
            ->keys()
            ->toArray();
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
    

    public function handle(Request $request)
    {
        $userMessage = $request->input('message');

        // (Tùy chọn) Xử lý, kiểm tra, truy vấn database ở đây nếu muốn

        // Tạo prompt gửi lên Gemini
        $prompt = $userMessage;

        // Gọi Gemini API
        $apiKey = 'AIzaSyAKa06ydnfEI6uI-rfBOUslzKpjk91a65Y';
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro:generateContent?key=$apiKey";

        $response = Http::post($apiUrl, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        $data = $response->json();
        $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi không hiểu câu hỏi.';

        return response()->json(['reply' => $answer]);
    }

    /**
     * Tìm kiếm sản phẩm bằng hình ảnh
     */
    public function imageSearch(Request $request)
    {
        try {
            // Validate hình ảnh
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
            ]);

            $image = $request->file('image');
            
            // 1. Lưu hình ảnh tạm thời
            $imagePath = $this->saveTemporaryImage($image);
            
            // 2. Phân tích hình ảnh bằng Gemini Vision
            $description = $this->analyzeImageWithAI($imagePath);
            
            // 3. Chuyển đổi mô tả thành filters
            $filters = $this->extractFiltersFromDescription($description);
            
            // 4. Tìm kiếm sản phẩm
            $products = $this->searchProductsWithAdvancedFilters($filters, [], null);
            
            // 5. Lưu log tìm kiếm
            $this->saveImageSearchLog($imagePath, $description, $filters, $products);
            
            // 6. Xóa file tạm
            $this->deleteTemporaryImage($imagePath);
            
            // 7. Format response
            $productItems = $this->formatProductResponse($products);
            
            return response()->json([
                'success' => true,
                'description' => $description,
                'filters_applied' => $filters,
                'products' => $productItems,
                'total_found' => $products->count(),
                'message' => $products->count() > 0 
                    ? "Tôi đã tìm thấy {$products->count()} sản phẩm phù hợp với hình ảnh của bạn"
                    : "Không tìm thấy sản phẩm phù hợp. Bạn có thể thử tìm kiếm với từ khóa khác."
            ]);

        } catch (\Exception $e) {
            Log::error('Lỗi tìm kiếm hình ảnh: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xử lý hình ảnh. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Lưu hình ảnh tạm thời
     */
    private function saveTemporaryImage($image)
    {
        $filename = 'temp_' . time() . '_' . $image->getClientOriginalName();
        $path = public_path('uploads/temp');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $image->move($path, $filename);
        return 'uploads/temp/' . $filename;
    }

    /**
     * Phân tích hình ảnh bằng Gemini Vision
     */
    private function analyzeImageWithAI($imagePath)
    {
        if (empty($imagePath) || !file_exists(public_path($imagePath))) {
            return response()->json(['success' => false, 'message' => 'Không thể lưu hoặc đọc ảnh tạm!']);
        }

        Log::info('imagePath: ' . $imagePath);
        $imageData = base64_encode(file_get_contents(public_path($imagePath)));
        
        $prompt = "Phân tích chi tiết giày trong hình ảnh này. Trả về JSON với format:
        {
            'brand': 'tên thương hiệu',
            'category': 'loại giày (thể thao, casual, công sở...)',
            'color': 'màu sắc chính',
            'style': 'kiểu dáng (sneaker, boot, sandal...)',
            'features': ['tính năng 1', 'tính năng 2'],
            'description': 'mô tả tổng quan'
        }";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY');

        $response = Http::post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        ['inline_data' => [
                            'mime_type' => 'image/jpeg',
                            'data' => $imageData
                        ]]
                    ]
                ]
            ]
        ]);

        if ($response->failed()) {
            throw new \Exception('Lỗi khi gọi Gemini Vision API');
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Trích xuất JSON từ response
        preg_match('/\{.*\}/s', $text, $matches);
        $jsonText = $matches[0] ?? $text;
        
        $result = json_decode($jsonText, true);
        
        if (!$result) {
            // Fallback: trả về mô tả text nếu không parse được JSON
            return $text;
        }
        
        return $result;
    }

    /**
     * Chuyển đổi mô tả thành filters
     */
    private function extractFiltersFromDescription($description)
    {
        $filters = [];
        if (is_array($description)) {
            if (!empty($description['brand']) && $description['brand'] !== 'Không xác định') $filters['brand'] = $description['brand'];
            if (!empty($description['category']) && $description['category'] !== 'Không xác định') $filters['category'] = $description['category'];
            if (!empty($description['color'])) $filters['color'] = $description['color'];
            if (!empty($description['style'])) $filters['purpose'] = $description['style'];
            // Nếu có mô tả mà chưa có filter, dùng mô tả làm keyword
            if (empty($filters) && !empty($description['description'])) {
                $filters['keyword'] = $description['description'];
            }
        } else {
            $text = strtolower($description);
            if (empty($filters) && !empty($text)) {
                $filters['keyword'] = $text;
            }
        }
        return $filters;
    }

    /**
     * Lưu log tìm kiếm hình ảnh
     */
    private function saveImageSearchLog($imagePath, $description, $filters, $products)
    {
        try {
            DB::table('image_search_logs')->insert([
                'user_id' => auth()->id(),
                'uploaded_image' => $imagePath,
                'ai_description' => is_array($description) ? json_encode($description) : $description,
                'search_filters' => json_encode($filters),
                'search_results' => json_encode($products->pluck('id')->toArray()),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::warning('Không thể lưu log tìm kiếm hình ảnh: ' . $e->getMessage());
        }
    }

    /**
     * Xóa file tạm
     */
    private function deleteTemporaryImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Tìm kiếm sản phẩm bằng so sánh vector ảnh (image-to-image search)
     */
    public function imageSearchByVector(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120'
        ]);

        $image = $request->file('image');
        // Lưu ảnh tạm để phân tích AI
        $imagePath = $this->saveTemporaryImage($image);
        // Kiểm tra đường dẫn ảnh tạm
        if (empty($imagePath) || !file_exists(public_path($imagePath))) {
            Log::error('Lỗi lưu ảnh tạm hoặc file không tồn tại: ' . $imagePath);
            return response()->json(['success' => false, 'message' => 'Không thể lưu hoặc đọc ảnh tạm!']);
        }
        // Phân tích mô tả AI từ ảnh
        $description = $this->analyzeImageWithAI($imagePath);

        // Gửi ảnh sang AI vector service
        $response = Http::attach(
            'image', file_get_contents(public_path($imagePath)), basename($imagePath)
        )->post('http://localhost:5001/extract-vector');

        // Xóa file tạm
        $this->deleteTemporaryImage($imagePath);

        $queryVector = $response->json('vector');
        if (!$queryVector) {
            return response()->json(['success' => false, 'message' => 'Không thể phân tích ảnh!']);
        }

        $imageVectors = ImageVector::all();
        $maxSim = -1;
        $best = null;

        foreach ($imageVectors as $iv) {
            $sim = $this->cosineSimilarity($queryVector, $iv->vector);
            if ($sim > $maxSim) {
                $maxSim = $sim;
                $best = $iv;
            }
        }

        if ($best) {
            $product = Product::find($best->product_id);
            return response()->json([
                'success' => true,
                'product' => $product,
                'matched_image' => $best->image_path,
                'similarity' => $maxSim,
                'description' => $description
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm phù hợp!']);
        }
    }

    /**
     * Hàm tính cosine similarity giữa 2 vector
     */
    private function cosineSimilarity($vecA, $vecB)
    {
        $dot = 0; $normA = 0; $normB = 0;
        for ($i = 0; $i < count($vecA); $i++) {
            $dot += $vecA[$i] * $vecB[$i];
            $normA += $vecA[$i] * $vecA[$i];
            $normB += $vecB[$i] * $vecB[$i];
        }
        return $dot / (sqrt($normA) * sqrt($normB));
    }
}
