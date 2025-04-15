<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductReview;
use App\Models\OrderDetail;
use App\Models\Product;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
    
        $userId = Auth::id();
    
        $hasPurchased = OrderDetail::where('product_id', $productId)
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->exists();
    
        if (! $hasPurchased) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm đã mua.');
        }
    
        $existingReview = ProductReview::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();
    
        if ($existingReview) {
            return redirect()->route('reviews.edit', $existingReview->id)
                ->with('info', 'Bạn đã đánh giá sản phẩm này. Bạn có thể chỉnh sửa đánh giá.');
        }
    
        ProductReview::create([
            'product_id' => $productId,
            'user_id'    => $userId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'is_approved'=> true,
        ]);
    
        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
    

    // Hiển thị form chỉnh sửa (nếu bạn dùng route GET)
    public function edit($id)
    {
        $review = ProductReview::findOrFail($id);

        // Chỉ cho người dùng sửa review của chính họ
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Cập nhật lại thì cần duyệt lại
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được cập nhật. Vui lòng chờ admin duyệt lại.');
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Đánh giá đã được xóa.');
    }

    // Duyệt đánh giá (admin)
    public function approve($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->is_approved = true;
        $review->save();

        return redirect()->back()->with('success', 'Đánh giá đã được duyệt.');
    }
}
