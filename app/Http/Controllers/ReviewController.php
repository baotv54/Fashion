<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReview;
use App\Models\ProductReviewMedia;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function index(Request $request, $productId = null)
    {
        try {
            if ($productId) {
                return $this->getProductReviews($request, $productId);
            }
            return $this->getAdminReviews($request);
        } catch (\Exception $e) {
            Log::error('Error in ReviewController index: ' . $e->getMessage());
            if ($productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tải đánh giá.',
                ], 500);
            }
            return redirect()->back()->with('error', 'Không thể tải danh sách đánh giá.');
        }
    }

    private function getProductReviews($request, $productId)
    {
        $perPage = $request->input('per_page', 5);
        $sort = $request->input('sort', 'latest');
        $filter = $request->input('filter', 'all');

        $product = Product::findOrFail($productId);

        $query = ProductReview::where('product_id', $productId)
            ->where('is_approved', true)
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'media' => function ($q) {
                    $q->select('id', 'product_review_id', 'file_path', 'type');
                }
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
        $query = ProductReview::with(['user', 'product.category', 'media']);

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
                $q->whereHas('product', function ($productQuery) use ($search) {
                    $productQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $query->orderBy('created_at', 'desc');
        $reviews = $query->paginate(15);

        $totalReviews = ProductReview::count();
        $pendingReviews = ProductReview::where('is_approved', false)->count();
        $averageRating = ProductReview::where('is_approved', true)->avg('rating') ?? 0;
        $reviewsWithMedia = ProductReview::has('media')->count();
        $newReviewsToday = ProductReview::whereDate('created_at', today())->count();

        return view('admin.reviews.index', compact(
            'reviews', 
            'totalReviews', 
            'pendingReviews', 
            'averageRating', 
            'reviewsWithMedia',
            'newReviewsToday'
        ));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:10240',
        ]);

        $userId = Auth::id();
        $product = Product::findOrFail($productId);

        $hasPurchased = OrderDetail::where('product_id', $productId)
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('status', 'delivered');
            })->exists();

        if (!$hasPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chỉ có thể đánh giá sản phẩm đã mua và nhận hàng.',
            ], 403);
        }

        $existingReview = ProductReview::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này.',
                'redirect' => route('reviews.edit', $existingReview->id),
            ], 400);
        }

        try {
            DB::beginTransaction();

            $review = ProductReview::create([
                'product_id' => $productId,
                'user_id' => $userId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => config('app.auto_approve_reviews', true),
            ]);

            $this->saveReviewMedia($request, $review);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $review->is_approved
                    ? 'Đánh giá đã được gửi thành công.'
                    : 'Đánh giá đã được gửi và đang chờ duyệt.',
                'review' => $this->formatReviewForResponse($review->load(['user', 'media'])),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing review for product_id ' . $productId . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }

    public function edit($id)
    {
        $review = ProductReview::with(['media', 'product'])->findOrFail($id);

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
        $review = ProductReview::with('media')->findOrFail($id);

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
                'review' => $this->formatReviewForResponse($review->fresh()->load(['user', 'media'])),
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
        $review = ProductReview::with('media')->findOrFail($id);

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
            $review = ProductReview::findOrFail($id);

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
            'review_ids.*' => 'integer|exists:product_reviews,id'
        ]);

        try {
            DB::beginTransaction();

            $updated = ProductReview::whereIn('id', $request->review_ids)
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

    private function saveReviewMedia($request, $review)
    {
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                ProductReviewMedia::create([
                    'product_review_id' => $review->id,
                    'file_path' => $path,
                    'type' => $type,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }
    }

    private function removeSelectedMedia($mediaIds, $review)
    {
        $mediaToRemove = ProductReviewMedia::whereIn('id', $mediaIds)
            ->where('product_review_id', $review->id)
            ->get();

        foreach ($mediaToRemove as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }
    }

    private function formatReviewForResponse($review)
    {
        return [
            'id' => $review->id,
            'product_id' => $review->product_id,
            'user_id' => $review->user_id,
            'rating' => $review->rating,
            'comment' => $review->comment,
            'is_approved' => $review->is_approved,
            'created_at' => $review->created_at->toDateTimeString(),
            'user' => [
                'name' => $review->user->name ?? 'Ẩn danh',
                'avatar' => asset('images/default-avatar.png'),
            ],
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
