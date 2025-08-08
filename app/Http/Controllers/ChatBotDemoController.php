<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ChatBotHelper;
use App\Models\Product;
use App\Models\User;

class ChatBotDemoController extends Controller
{
    /**
     * Demo phân tích xu hướng
     */
    public function demoTrends()
    {
        $trends = ChatBotHelper::analyzeTrends();
        
        return response()->json([
            'success' => true,
            'data' => $trends,
            'message' => 'Phân tích xu hướng thành công'
        ]);
    }

    /**
     * Demo gợi ý cá nhân hóa
     */
    public function demoPersonalizedRecommendations(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $recommendations = ChatBotHelper::getPersonalizedRecommendations($userId);
        
        return response()->json([
            'success' => true,
            'data' => $recommendations->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => optional($product->brand)->name,
                    'category' => optional($product->category)->name,
                    'price' => number_format($product->price) . 'đ',
                    'rating' => round($product->reviews->avg('rating') ?? 0, 1),
                    'total_reviews' => $product->reviews->count()
                ];
            }),
            'message' => 'Gợi ý cá nhân hóa thành công'
        ]);
    }

    /**
     * Demo phân tích phong cách
     */
    public function demoStyleAnalysis(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $styleAnalysis = ChatBotHelper::analyzeUserStyle($userId);
        
        return response()->json([
            'success' => true,
            'data' => $styleAnalysis,
            'message' => 'Phân tích phong cách thành công'
        ]);
    }

    /**
     * Demo gợi ý outfit
     */
    public function demoOutfitSuggestions(Request $request)
    {
        $productId = $request->input('product_id');
        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cung cấp product_id'
            ], 400);
        }

        $suggestions = ChatBotHelper::generateOutfitSuggestions($productId);
        
        return response()->json([
            'success' => true,
            'data' => $suggestions,
            'message' => 'Gợi ý outfit thành công'
        ]);
    }

    /**
     * Demo phân tích ngân sách
     */
    public function demoBudgetAnalysis(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        $budgetAnalysis = ChatBotHelper::analyzeBudget($userId);
        
        return response()->json([
            'success' => true,
            'data' => $budgetAnalysis,
            'message' => 'Phân tích ngân sách thành công'
        ]);
    }

    /**
     * Demo gợi ý theo mùa
     */
    public function demoSeasonalRecommendations()
    {
        $seasonalInfo = ChatBotHelper::getSeasonalRecommendations();
        
        return response()->json([
            'success' => true,
            'data' => $seasonalInfo,
            'message' => 'Gợi ý theo mùa thành công'
        ]);
    }

    /**
     * Demo tìm kiếm thông minh
     */
    public function demoSmartSearch(Request $request)
    {
        $query = $request->input('query', '');
        $filters = $request->input('filters', []);
        
        $products = Product::with(['brand', 'category', 'reviews'])
            ->where('status', 1);

        // Áp dụng các bộ lọc
        if (!empty($filters['category'])) {
            $products->whereHas('category', function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['category'] . '%');
            });
        }

        if (!empty($filters['brand'])) {
            $products->whereHas('brand', function ($q) use ($filters) {
                $q->where('name', 'LIKE', '%' . $filters['brand'] . '%');
            });
        }

        if (!empty($filters['price_max'])) {
            $products->where('price', '<=', (int)$filters['price_max']);
        }

        if (!empty($filters['rating_min'])) {
            $products->whereHas('reviews', function ($q) use ($filters) {
                $q->where('rating', '>=', $filters['rating_min']);
            });
        }

        $results = $products->withCount(['reviews', 'favoritedByUsers'])
            ->orderBy('reviews_count', 'desc')
            ->orderBy('favorited_by_users_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => optional($product->brand)->name,
                    'category' => optional($product->category)->name,
                    'price' => number_format($product->price) . 'đ',
                    'rating' => round($product->reviews->avg('rating') ?? 0, 1),
                    'total_reviews' => $product->reviews->count(),
                    'favorites_count' => $product->favorited_by_users_count
                ];
            }),
            'total_found' => $results->count(),
            'message' => 'Tìm kiếm thông minh thành công'
        ]);
    }

    /**
     * Demo so sánh sản phẩm
     */
    public function demoProductComparison(Request $request)
    {
        $productIds = $request->input('product_ids', []);
        
        if (count($productIds) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cung cấp ít nhất 2 product_ids để so sánh'
            ], 400);
        }

        $products = Product::with(['brand', 'category', 'reviews'])
            ->whereIn('id', $productIds)
            ->get();

        $comparison = $products->map(function($product) {
            $avgRating = $product->reviews->avg('rating') ?? 0;
            $totalReviews = $product->reviews->count();
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => optional($product->brand)->name,
                'category' => optional($product->category)->name,
                'price' => number_format($product->price) . 'đ',
                'rating' => round($avgRating, 1),
                'total_reviews' => $totalReviews,
                'price_value' => $product->price,
                'features' => $this->extractFeatures($product),
                'pros' => $this->getPros($product),
                'cons' => $this->getCons($product)
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $comparison,
            'message' => 'So sánh sản phẩm thành công'
        ]);
    }

    /**
     * Demo tư vấn size
     */
    public function demoSizeGuide()
    {
        $sizeGuide = [
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
                'Với giày thể thao, nên chọn size lớn hơn 0.5',
                'Với giày công sở, chọn size vừa khít'
            ],
            'measurement_guide' => [
                'step1' => 'Đặt tờ giấy trên sàn nhà',
                'step2' => 'Đứng lên tờ giấy với chân phải',
                'step3' => 'Đánh dấu điểm xa nhất của gót chân và ngón chân',
                'step4' => 'Đo khoảng cách giữa 2 điểm',
                'step5' => 'So sánh với bảng size'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $sizeGuide,
            'message' => 'Hướng dẫn chọn size thành công'
        ]);
    }

    /**
     * Demo tất cả tính năng
     */
    public function demoAllFeatures(Request $request)
    {
        $userId = $request->input('user_id', auth()->id());
        
        $results = [
            'trends' => ChatBotHelper::analyzeTrends(),
            'personalized_recommendations' => ChatBotHelper::getPersonalizedRecommendations($userId),
            'style_analysis' => ChatBotHelper::analyzeUserStyle($userId),
            'budget_analysis' => ChatBotHelper::analyzeBudget($userId),
            'seasonal_recommendations' => ChatBotHelper::getSeasonalRecommendations()
        ];

        return response()->json([
            'success' => true,
            'data' => $results,
            'message' => 'Demo tất cả tính năng thành công'
        ]);
    }

    // Helper methods
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
        
        if (str_contains(strtolower($product->description ?? ''), 'chống nước')) {
            $features[] = 'Chống nước';
        }
        
        return $features;
    }

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
        
        if ($product->price < 2000000) {
            $pros[] = 'Giá hợp lý';
        }
        
        return $pros;
    }

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
        
        if ($product->price > 3000000) {
            $cons[] = 'Giá cao';
        }
        
        return $cons;
    }
} 