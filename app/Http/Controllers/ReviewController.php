<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReview;
use App\Models\ProductReviewMedia;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // Thêm đánh giá mới
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:5120', // 5MB
        ]);

        $userId = Auth::id();

        // Kiểm tra đã mua sản phẩm chưa
        $hasPurchased = OrderDetail::where('product_id', $productId)
            ->whereHas('order', fn($query) => $query->where('user_id', $userId))
            ->exists();

        if (! $hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua.');
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = ProductReview::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview->id)
                ->with('info', 'Bạn đã đánh giá sản phẩm này. Bạn có thể chỉnh sửa đánh giá.');
        }

        // Lưu đánh giá
        $review = ProductReview::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Đợi admin duyệt
        ]);

        // Lưu media nếu có
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                ProductReviewMedia::create([
                    'product_review_id' => $review->id,
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm! Đánh giá của bạn sẽ được duyệt sớm.');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $review = ProductReview::with('media')->findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, $id)
    {
        $review = ProductReview::with('media')->findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:5120',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // cần duyệt lại
        ]);

        // Xóa media cũ nếu cần (có thể cải tiến: cho phép xóa từng file)
        if ($request->hasFile('media')) {
            foreach ($review->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }

            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';

                ProductReviewMedia::create([
                    'product_review_id' => $review->id,
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        return back()->with('success', 'Đánh giá đã được cập nhật. Vui lòng chờ duyệt lại.');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = ProductReview::with('media')->findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($review->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        $review->delete();

        return back()->with('success', 'Đánh giá đã được xóa.');
    }

    // Admin duyệt đánh giá
    public function approve($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return back()->with('success', 'Đánh giá đã được duyệt.');
    }
}
