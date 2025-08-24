<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderReview;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Added missing import

class ProductReviewController extends Controller
{
    /**
     * Lấy danh sách đánh giá và thống kê cho sản phẩm
     */
    public function index(Request $request, $productId)
    {
        try {
            $perPage = $request->input('per_page', 5);
            $sort = $request->input('sort', 'latest');
            $filter = $request->input('filter', 'all');

            // Kiểm tra sản phẩm
            $product = Product::findOrFail($productId);

            // Truy vấn đánh giá
            $query = OrderReview::where('product_id', $productId)
                ->approved()
                ->with([
                    'user' => function ($q) {
                        $q->select('id', 'name', 'avatar');
                    },
                    'media' => function ($q) {
                        $q->select('id', 'order_review_id', 'file_path', 'type');
                    },
                    'orderDetail' => function ($q) {
                        $q->select('id', 'order_id', 'product_id');
                    }
                ]);

            // Áp dụng bộ lọc
            if ($filter !== 'all') {
                if ($filter === 'media') {
                    $query->has('media');
                } elseif (in_array($filter, ['1', '2', '3', '4', '5'])) {
                    $query->where('rating', $filter);
                }
            }

            // Áp dụng sắp xếp
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'rating_high':
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'rating_low':
                    $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $reviews = $query->paginate($perPage);

            // Tính thống kê đánh giá với cache
            $cacheKey = "product_{$productId}_review_stats";
            $stats = Cache::remember($cacheKey, now()->addHours(1), function () use ($productId) {
                $totalReviews = OrderReview::where('product_id', $productId)->approved()->count();
                $avgRating = $totalReviews > 0 ? OrderReview::where('product_id', $productId)->approved()->avg('rating') : 0;

                $ratingStats = [];
                for ($i = 1; $i <= 5; $i++) {
                    $count = OrderReview::where('product_id', $productId)->where('rating', $i)->approved()->count();
                    $percentage = $totalReviews > 0 ? ($count / $totalReviews * 100) : 0;
                    $ratingStats[$i] = [
                        'count' => $count,
                        'percentage' => round($percentage, 2),
                    ];
                }

                return [
                    'totalReviews' => $totalReviews,
                    'avgRating' => round($avgRating, 1),
                    'ratingStats' => $ratingStats,
                ];
            });

            $formattedReviews = $reviews->map(function ($review) {
                return $this->formatReviewForResponse($review);
            })->toArray();

            return response()->json([
                'success' => true,
                'data' => [
                    'reviews' => $formattedReviews,
                    'pagination' => [
                        'current_page' => $reviews->currentPage(),
                        'last_page' => $reviews->lastPage(),
                        'per_page' => $reviews->perPage(),
                        'total' => $reviews->total(),
                        'has_more' => $reviews->hasMorePages(),
                    ],
                    'avgRating' => $stats['avgRating'],
                    'totalReviews' => $stats['totalReviews'],
                    'ratingStats' => $stats['ratingStats'],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error in ProductReviewController index for product_id ' . $productId . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể tải đánh giá: ' . $e->getMessage(),
            ], $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException ? 404 : 500);
        }
    }

    /**
     * Định dạng đánh giá cho phản hồi JSON
     */
    private function formatReviewForResponse($review)
    {
        $product = $review->orderDetail ? $review->orderDetail->product : null;

        return [
            'id' => $review->id,
            'product_id' => $review->product_id,
            'user_id' => $review->user_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'is_approved' => $review->is_approved,
            'created_at' => $review->created_at->toDateTimeString(),
            'order_id' => $review->order_id,
            'order_detail_id' => $review->order_detail_id,
            'user' => [
                'name' => $review->user->name ?? 'Ẩn danh',
                'avatar' => $review->user->avatar ? Storage::url($review->user->avatar) : asset('images/default-avatar.png'),
            ],
            'reviewed_product' => $product ? [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $this->getProductImageUrl($product->image),
            ] : null,
            'media' => $review->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'type' => $media->type,
                    'url' => Storage::url($media->file_path),
                ];
            })->toArray(),
        ];
    }

    /**
     * Helper function để tạo URL cho product image từ public/uploads
     */
    private function getProductImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('uploads/default-product.jpg');
        }

        // Nếu đã có đầy đủ URL, trả về nguyên bản
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // Nếu đã có /uploads/ ở đầu, chỉ cần tạo asset URL
        if (str_starts_with($imagePath, '/uploads/')) {
            return asset(ltrim($imagePath, '/'));
        }

        // Nếu đã có uploads/ ở đầu (không có /)
        if (str_starts_with($imagePath, 'uploads/')) {
            return asset($imagePath);
        }

        // Các trường hợp khác, thêm uploads/ vào đầu
        return asset('uploads/' . ltrim($imagePath, '/'));
    }
}