<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\OrderReview;
use App\Models\OrderDetail;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class ChatBotHelper
{
    /**
     * Phân tích xu hướng mua hàng
     */
    public static function analyzeTrends()
    {
        // Sản phẩm bán chạy nhất
        $topSelling = OrderDetail::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('product.brand')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Sản phẩm được yêu thích nhất
        $topFavorites = Product::withCount('favoritedByUsers')
            ->with('brand')
            ->orderBy('favorited_by_users_count', 'desc')
            ->limit(5)
            ->get();

        // Sản phẩm đánh giá cao nhất
        $topRated = Product::with(['brand', 'reviews'])
            ->whereHas('reviews', function($q) {
                $q->where('rating', '>=', 4);
            })
            ->withCount(['reviews'])
            ->orderBy('reviews_count', 'desc')
            ->limit(5)
            ->get();

        return [
            'top_selling' => $topSelling,
            'top_favorites' => $topFavorites,
            'top_rated' => $topRated
        ];
    }

    /**
     * Gợi ý sản phẩm dựa trên lịch sử
     */
    public static function getPersonalizedRecommendations($userId)
    {
        if (!$userId) return collect();

        // Lấy sản phẩm đã mua
        $purchasedProducts = OrderDetail::whereHas('order', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->pluck('product_id');

        // Lấy sản phẩm yêu thích
        $favoriteProducts = Favorite::where('user_id', $userId)->pluck('product_id');

        // Tìm sản phẩm tương tự
        $similarProducts = Product::whereIn('category_id', function($q) use ($purchasedProducts) {
            $q->select('category_id')
              ->from('products')
              ->whereIn('id', $purchasedProducts);
        })
        ->whereNotIn('id', $purchasedProducts->merge($favoriteProducts))
        ->with(['brand', 'category', 'reviews'])
        ->withCount(['reviews', 'favoritedByUsers'])
        ->orderBy('reviews_count', 'desc')
        ->limit(8)
        ->get();

        return $similarProducts;
    }

    /**
     * Phân tích phong cách người dùng
     */
    public static function analyzeUserStyle($userId)
    {
        if (!$userId) return [];

        $purchases = OrderDetail::whereHas('order', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('product.category')->get();

        $styleAnalysis = [
            'sporty' => 0,
            'casual' => 0,
            'formal' => 0,
            'luxury' => 0
        ];

        foreach ($purchases as $purchase) {
            $categoryName = strtolower($purchase->product->category->name ?? '');
            
            if (str_contains($categoryName, 'thể thao') || str_contains($categoryName, 'chạy')) {
                $styleAnalysis['sporty']++;
            } elseif (str_contains($categoryName, 'casual') || str_contains($categoryName, 'dạo phố')) {
                $styleAnalysis['casual']++;
            } elseif (str_contains($categoryName, 'công sở') || str_contains($categoryName, 'formal')) {
                $styleAnalysis['formal']++;
            } elseif (str_contains($categoryName, 'cao cấp') || str_contains($categoryName, 'luxury')) {
                $styleAnalysis['luxury']++;
            }
        }

        return $styleAnalysis;
    }

    /**
     * Tạo gợi ý outfit
     */
    public static function generateOutfitSuggestions($productId)
    {
        $product = Product::with('category')->find($productId);
        if (!$product) return [];

        $categoryName = strtolower($product->category->name ?? '');
        $suggestions = [];

        if (str_contains($categoryName, 'thể thao')) {
            $suggestions = [
                'Quần short thể thao',
                'Áo thun thể thao',
                'Tất thể thao',
                'Mũ lưỡi trai'
            ];
        } elseif (str_contains($categoryName, 'casual')) {
            $suggestions = [
                'Quần jean',
                'Áo thun basic',
                'Áo khoác denim',
                'Túi đeo chéo'
            ];
        } elseif (str_contains($categoryName, 'công sở')) {
            $suggestions = [
                'Quần âu',
                'Áo sơ mi',
                'Áo vest',
                'Cà vạt'
            ];
        }

        return $suggestions;
    }

    /**
     * Phân tích ngân sách người dùng
     */
    public static function analyzeBudget($userId)
    {
        if (!$userId) return ['min' => 0, 'max' => 5000000, 'avg' => 2500000];

        $orders = OrderDetail::whereHas('order', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->get();

        if ($orders->isEmpty()) {
            return ['min' => 0, 'max' => 5000000, 'avg' => 2500000];
        }

        $prices = $orders->pluck('price');
        
        return [
            'min' => $prices->min(),
            'max' => $prices->max(),
            'avg' => round($prices->avg())
        ];
    }

    /**
     * Tạo câu trả lời thông minh
     */
    public static function generateSmartResponse($intent, $filters, $userProfile)
    {
        $responses = [
            'product_search' => [
                'default' => 'Tôi đã tìm thấy những sản phẩm phù hợp với yêu cầu của bạn:',
                'no_results' => 'Xin lỗi, tôi không tìm thấy sản phẩm phù hợp. Bạn có thể thử tìm kiếm với tiêu chí khác.',
                'budget_high' => 'Dựa trên ngân sách của bạn, tôi gợi ý những sản phẩm cao cấp:',
                'budget_low' => 'Với ngân sách này, tôi gợi ý những sản phẩm chất lượng tốt:'
            ],
            'style_advice' => [
                'sporty' => 'Với phong cách thể thao, bạn nên chọn giày có đế mềm và thoáng khí.',
                'casual' => 'Cho phong cách casual, giày sneaker hoặc giày lười sẽ rất phù hợp.',
                'formal' => 'Với công việc văn phòng, giày oxford hoặc derby sẽ tạo vẻ chuyên nghiệp.'
            ],
            'size_help' => [
                'default' => 'Để chọn size chính xác, bạn có thể đo chân và so sánh với bảng size của chúng tôi.',
                'wide_feet' => 'Nếu bạn có bàn chân rộng, nên chọn size lớn hơn 0.5-1 size.',
                'narrow_feet' => 'Với bàn chân nhỏ, bạn có thể chọn size nhỏ hơn 0.5 size.'
            ]
        ];

        $response = $responses[$intent]['default'] ?? 'Tôi có thể giúp gì cho bạn?';

        // Tùy chỉnh theo profile người dùng
        if ($userProfile['gender'] === 'nam') {
            $response .= ' Dựa trên sở thích của bạn, tôi gợi ý những sản phẩm phù hợp.';
        }

        return $response;
    }

    /**
     * Phân tích mùa vụ
     */
    public static function getSeasonalRecommendations()
    {
        $currentMonth = now()->month;
        
        $seasonalCategories = [
            'spring' => [3, 4, 5], // Mùa xuân
            'summer' => [6, 7, 8], // Mùa hè
            'autumn' => [9, 10, 11], // Mùa thu
            'winter' => [12, 1, 2] // Mùa đông
        ];

        $currentSeason = '';
        foreach ($seasonalCategories as $season => $months) {
            if (in_array($currentMonth, $months)) {
                $currentSeason = $season;
                break;
            }
        }

        $seasonalKeywords = [
            'spring' => ['nhẹ', 'thoáng', 'màu sắc'],
            'summer' => ['thoáng khí', 'mát', 'nhẹ'],
            'autumn' => ['ấm', 'cổ điển', 'tối màu'],
            'winter' => ['ấm', 'chống nước', 'dày']
        ];

        return [
            'season' => $currentSeason,
            'keywords' => $seasonalKeywords[$currentSeason] ?? []
        ];
    }
} 