<?php

namespace App\Http\Controllers;

use App\Models\Comparison;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ComparisonController extends Controller
{
    // Hiển thị trang so sánh
    public function index()
    {
        $products = $this->getComparisonProducts();
        return view('Frontend.pages.comparison', compact('products'));
    }

    // Thêm sản phẩm vào so sánh
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        
        // Kiểm tra sản phẩm có tồn tại
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại'
            ]);
        }

        // Kiểm tra giới hạn 4 sản phẩm
        $currentCount = $this->getComparisonCount();
        if ($currentCount >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chỉ có thể so sánh tối đa 4 sản phẩm'
            ]);
        }

        // Kiểm tra sản phẩm đã có trong danh sách chưa
        if ($this->isProductInComparison($productId)) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong danh sách so sánh'
            ]);
        }

        // Thêm vào database hoặc session
        $this->addToComparison($productId);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào danh sách so sánh',
            'count' => $this->getComparisonCount()
        ]);
    }

    // Xóa sản phẩm khỏi so sánh
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        
        $this->removeFromComparison($productId);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi danh sách so sánh',
            'count' => $this->getComparisonCount()
        ]);
    }

    // Xóa tất cả sản phẩm
    public function clear()
    {
        $this->clearComparison();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa tất cả sản phẩm khỏi danh sách so sánh',
            'count' => 0
        ]);
    }

    // Lấy số lượng sản phẩm trong so sánh
    public function count()
    {
        return response()->json([
            'count' => $this->getComparisonCount()
        ]);
    }

    // Lấy danh sách sản phẩm so sánh (API)
    public function getProducts()
    {
        $products = $this->getComparisonProducts();
        
        return response()->json([
            'success' => true,
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image ? asset($product->image) : asset('images/default.jpg'),
                    'url' => route('product.show', $product->id)
                ];
            }),
            'count' => $products->count()
        ]);
    }

    // Helper methods
    private function getComparisonProducts()
    {
        if (Auth::check()) {
            $comparisons = Comparison::where('user_id', Auth::id())
                ->with(['product' => function($query) {
                    $query->with(['category', 'brand', 'variants.attributeValues.attribute']);
                }])
                ->get();
            return $comparisons->pluck('product');
        } else {
            $sessionId = Session::getId();
            $comparisons = Comparison::where('session_id', $sessionId)
                ->with(['product' => function($query) {
                    $query->with(['category', 'brand', 'variants.attributeValues.attribute']);
                }])
                ->get();
            return $comparisons->pluck('product');
        }
    }

    private function getComparisonCount()
    {
        if (Auth::check()) {
            return Comparison::where('user_id', Auth::id())->count();
        } else {
            $sessionId = Session::getId();
            return Comparison::where('session_id', $sessionId)->count();
        }
    }

    private function isProductInComparison($productId)
    {
        if (Auth::check()) {
            return Comparison::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } else {
            $sessionId = Session::getId();
            return Comparison::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->exists();
        }
    }

    private function addToComparison($productId)
    {
        if (Auth::check()) {
            Comparison::create([
                'user_id' => Auth::id(),
                'product_id' => $productId
            ]);
        } else {
            $sessionId = Session::getId();
            Comparison::create([
                'session_id' => $sessionId,
                'product_id' => $productId
            ]);
        }
    }

    private function removeFromComparison($productId)
    {
        if (Auth::check()) {
            Comparison::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $sessionId = Session::getId();
            Comparison::where('session_id', $sessionId)
                ->where('product_id', $productId)
                ->delete();
        }
    }

    private function clearComparison()
    {
        if (Auth::check()) {
            Comparison::where('user_id', Auth::id())->delete();
        } else {
            $sessionId = Session::getId();
            Comparison::where('session_id', $sessionId)->delete();
        }
    }
}
