<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('Frontend.pages.favorites', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích');
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            if ($request->ajax()) {
                return response()->json(['status' => 'removed']);
            }
            return redirect()->back()->with('success', 'Đã xóa khỏi danh sách yêu thích');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            if ($request->ajax()) {
                return response()->json(['status' => 'added']);
            }
            return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích');
        }
    }

    public function destroy($product_id)
    {
        $deleted = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->delete();

        if (request()->ajax()) {
            if ($deleted) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }

        // Nếu không phải AJAX thì redirect bình thường
        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích');
    }
}
