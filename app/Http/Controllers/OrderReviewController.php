<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderReview;
use App\Models\OrderReviewMedia;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderReviewController extends Controller
{
    public function index(Request $request, $orderId = null)
    {
        try {
            if ($orderId) {
                return $this->getOrderReviews($request, $orderId);
            }
            return $this->getAdminReviews($request);
        } catch (\Exception $e) {
            Log::error('Error in OrderReviewController index: ' . $e->getMessage());
            if ($orderId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tải đánh giá.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Không thể tải danh sách đánh giá.');
        }
    }

    private function getOrderReviews($request, $orderId)
    {
        $perPage = $request->input('per_page', 5);
        $sort = $request->input('sort', 'latest');
        $filter = $request->input('filter', 'all');

        $order = Order::with(['orderDetails.product'])->findOrFail($orderId);

        $query = OrderReview::where('order_id', $orderId)
            ->where('is_approved', true)
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'media' => function ($q) {
                    $q->select('id', 'order_review_id', 'file_path', 'type');
                },
                'order.orderDetails.product',
                'orderDetail.product' // Load thông tin sản phẩm được đánh giá
            ]);

        if ($filter !== 'all') {
            if ($filter === 'media') {
                $query->has('media');
            } elseif (in_array($filter, ['1', '2', '3', '4', '5'])) {
                $query->where('rating', $filter);
            }
        }

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
            ],
        ]);
    }

    private function getAdminReviews($request)
    {
        $query = OrderReview::with(['user', 'order.orderDetails.product', 'orderDetail.product', 'media']);

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'pending':
                    $query->where('is_approved', false);
                    break;
                case 'rejected':
                    $query->whereNotNull('rejected_at');
                    break;
            }
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('media')) {
            if ($request->media === 'with_media') {
                $query->has('media');
            } elseif ($request->media === 'no_media') {
                $query->doesntHave('media');
            }
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('orderDetail.product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $reviews = $query->paginate(15);

        $totalReviews = OrderReview::count();
        $pendingReviews = OrderReview::where('is_approved', false)->count();
        $averageRating = OrderReview::where('is_approved', true)->avg('rating') ?? 0;
        $reviewsWithMedia = OrderReview::has('media')->count();
        $newReviewsToday = OrderReview::whereDate('created_at', today())->count();

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'pendingReviews',
            'averageRating',
            'reviewsWithMedia',
            'newReviewsToday'
        ));
    }

    /**
     * Lưu đánh giá cho nhiều sản phẩm trong đơn hàng
     */
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'reviews' => 'required|array|min:1',
            'reviews.*.order_detail_id' => 'required|exists:order_details,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'nullable|string|max:1000',
            'reviews.*.media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
        ]);

        $userId = Auth::id();
        $order = Order::with(['orderDetails.product', 'user'])->findOrFail($orderId);

        // Kiểm tra quyền đánh giá
        if ($order->user_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền đánh giá đơn hàng này.',
            ], 403);
        }

        if ($order->status !== 'delivered') {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chỉ có thể đánh giá đơn hàng đã giao thành công.',
            ], 403);
        }

        try {
            DB::beginTransaction();

            $createdReviews = [];

            foreach ($request->reviews as $reviewData) {
                $orderDetailId = $reviewData['order_detail_id'];

                // Kiểm tra order_detail có thuộc đơn hàng này không
                $orderDetail = OrderDetail::where('id', $orderDetailId)
                    ->where('order_id', $orderId)
                    ->firstOrFail();

                // Kiểm tra đã đánh giá sản phẩm này chưa
                $existingReview = OrderReview::where('order_id', $orderId)
                    ->where('user_id', $userId)
                    ->where('order_detail_id', $orderDetailId)
                    ->first();

                if ($existingReview) {
                    continue; // Bỏ qua sản phẩm đã được đánh giá
                }

                // Tạo đánh giá mới, bao gồm product_id
                $review = OrderReview::create([
                    'order_id' => $orderId,
                    'user_id' => $userId,
                    'order_detail_id' => $orderDetailId,
                    'product_id' => $orderDetail->product_id, 
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'] ?? null,
                    'is_approved' => config('app.auto_approve_reviews', true),
                ]);

                // Lưu media nếu có
                if (isset($reviewData['media'])) {
                    $this->saveReviewMediaFromArray($reviewData['media'], $review);
                }

                $createdReviews[] = $review->load(['user', 'media', 'orderDetail.product']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đánh giá đã được gửi thành công.',
                'reviews' => array_map(function ($review) {
                    return $this->formatReviewForResponse($review);
                }, $createdReviews),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing reviews for order_id ' . $orderId . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    /**
     * Lấy thông tin sản phẩm trong đơn hàng để đánh giá
     */
    public function getOrderProducts($orderId)
    {
        $userId = Auth::id();
        $order = Order::with(['orderDetails.product', 'orderDetails.variant'])
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->where('status', 'delivered')
            ->firstOrFail();

        $products = $order->orderDetails->map(function ($detail) use ($userId, $orderId) {
            // Kiểm tra đã đánh giá chưa
            $existingReview = OrderReview::where('order_id', $orderId)
                ->where('user_id', $userId)
                ->where('order_detail_id', $detail->id)
                ->first();

            return [
                'order_detail_id' => $detail->id,
                'product' => [
                    'id' => $detail->product->id,
                    'name' => $detail->product->name,
                    'image' => $detail->product->image,
                    'price' => $detail->price,
                ],
                'variant' => $detail->variant ? [
                    'id' => $detail->variant->id,
                    'name' => $detail->variant->name,
                ] : null,
                'quantity' => $detail->quantity,
                'has_review' => $existingReview ? true : false,
                'review' => $existingReview ? $this->formatReviewForResponse($existingReview->load(['media'])) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number ?? 'N/A',
                'status' => $order->status,
            ],
            'products' => $products,
        ]);
    }

    public function edit($id)
    {
        $review = OrderReview::with(['media', 'orderDetail.product'])->findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền chỉnh sửa đánh giá này.',
            ], 403);
        }

        return response()->json($this->formatReviewForResponse($review));
    }

    public function update(Request $request, $id)
    {
        $review = OrderReview::with('media')->findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền chỉnh sửa đánh giá này.',
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
            'remove_media' => 'sometimes|array',
            'remove_media.*' => 'integer',
        ]);

        try {
            DB::beginTransaction();

            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => config('app.auto_approve_reviews', true),
                'updated_at' => now(),
            ]);

            if ($request->has('remove_media')) {
                $this->removeSelectedMedia($request->remove_media, $review);
            }

            $this->saveReviewMedia($request, $review);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đánh giá đã được cập nhật thành công.',
                'review' => $this->formatReviewForResponse($review->fresh()->load(['user', 'media', 'orderDetail.product'])),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating review id ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $review = OrderReview::with('media')->findOrFail($id);

        if (!Auth::check() || (Auth::user()->role !== 'admin' && $review->user_id !== Auth::id())) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa đánh giá này.',
            ], 403);
        }

        try {
            DB::beginTransaction();

            foreach ($review->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }

            $review->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đánh giá đã được xóa thành công.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting review id ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    public function toggleVisibility($id)
    {
        try {
            $review = OrderReview::findOrFail($id);

            if (!Auth::check() || Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền thay đổi trạng thái hiển thị.',
                ], 403);
            }

            $review->update([
                'is_approved' => !$review->is_approved,
            ]);

            return response()->json([
                'success' => true,
                'message' => $review->is_approved ? 'Đánh giá đã được hiển thị.' : 'Đánh giá đã được ẩn.',
                'is_approved' => $review->is_approved,
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling visibility for review id ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    public function bulkApprove(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền thực hiện hành động này.',
            ], 403);
        }

        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'integer|exists:order_reviews,id'
        ]);

        try {
            DB::beginTransaction();

            $updated = OrderReview::whereIn('id', $request->review_ids)
                ->update([
                    'is_approved' => true,
                    'approved_at' => now(),
                    'rejected_at' => null,
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Đã duyệt thành công {$updated} đánh giá.",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error bulk approving reviews: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    // Get user's reviews for a specific order
    public function getUserOrderReviews($orderId)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập.',
            ], 401);
        }

        $reviews = OrderReview::where('order_id', $orderId)
            ->where('user_id', $userId)
            ->with(['media', 'orderDetail.product'])
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có đánh giá.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'reviews' => $reviews->map(function ($review) {
                return $this->formatReviewForResponse($review);
            }),
        ]);
    }

    private function saveReviewMedia($request, $review)
    {
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('order-reviews', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                OrderReviewMedia::create([
                    'order_review_id' => $review->id,
                    'file_path' => $path,
                    'type' => $type,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }

    private function saveReviewMediaFromArray($mediaFiles, $review)
    {
        if (is_array($mediaFiles)) {
            foreach ($mediaFiles as $file) {
                $path = $file->store('order-reviews', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                OrderReviewMedia::create([
                    'order_review_id' => $review->id,
                    'file_path' => $path,
                    'type' => $type,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }
    }

    private function removeSelectedMedia($mediaIds, $review)
    {
        $mediaToRemove = OrderReviewMedia::whereIn('id', $mediaIds)
            ->where('order_review_id', $review->id)
            ->get();

        foreach ($mediaToRemove as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }
    }

    private function formatReviewForResponse($review)
    {
        $reviewedProduct = null;
        if ($review->orderDetail && $review->orderDetail->product) {
            $reviewedProduct = [
                'id' => $review->orderDetail->product->id,
                'name' => $review->orderDetail->product->name,
                'image' => $review->orderDetail->product->image,
                'quantity' => $review->orderDetail->quantity,
                'price' => $review->orderDetail->price,
            ];
        }

        return [
            'id' => $review->id,
            'order_id' => $review->order_id,
            'order_detail_id' => $review->order_detail_id,
            'user_id' => $review->user_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'is_approved' => $review->is_approved,
            'created_at' => $review->created_at->toDateTimeString(),
            'user' => [
                'name' => $review->user->name ?? 'Ẩn danh',
                'avatar' => asset('images/default-avatar.png'),
            ],
            'reviewed_product' => $reviewedProduct,
            'media' => $review->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'type' => $media->type,
                    'url' => Storage::url($media->file_path),
                ];
            })->toArray(),
        ];
    }
}
