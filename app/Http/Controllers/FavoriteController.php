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

        return view('Frontend.partials.modal', compact('favorites'));
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

        return redirect()->route('Frontend.index')->with('success', 'Đã thêm vào danh sách yêu thích');
    }

    public function destroy($product_id)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product_id)
            ->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích');
    }
}
