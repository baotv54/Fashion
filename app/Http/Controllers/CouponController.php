<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class CouponController extends Controller
{
    // ========== ADMIN SIDE (QUẢN LÝ COUPON) ==========
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);

        return view('admin.coupons.index', compact('coupons'));
    }

    // Hiển thị form tạo mã giảm giá
    public function create()
    {
        return view('admin.coupons.create');
    }

    // Lưu mã giảm giá mới
    // Lưu mã giảm giá mới
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_cart_value' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);


        $data = $request->all();

        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục public/coupons/
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'coupons/' . $imageName;
            $request->file('image')->move(public_path('coupons'), $imageName);
            $data['image'] = $imagePath; // Đường dẫn ảnh lưu trực tiếp vào public/coupons/
        }

        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }



    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_cart_value' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($coupon->image && file_exists(public_path($coupon->image))) {
                unlink(public_path($coupon->image));
            }

            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = 'coupons/' . $imageName;
            $request->file('image')->move(public_path('coupons'), $imageName);
            $data['image'] = $imagePath;
        }

        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);

        if ($coupon->image) {
            Storage::disk('public')->delete($coupon->image);
        }

        $coupon->delete();

        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công!');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại!'], 404);
        }

        // Kiểm tra ngày hiệu lực
        $now = now();
        if ($coupon->start_date && $now < $coupon->start_date) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá chưa có hiệu lực!'], 400);
        }
        if ($coupon->end_date && $now > $coupon->end_date) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết hạn!'], 400);
        }

        // Kiểm tra số lượt sử dụng
        if ($coupon->usage_limit && $coupon->used >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã đạt giới hạn sử dụng!'], 400);
        }

        // Tính toán giảm giá
        $cartTotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal())); // Tổng giá trị giỏ hàng
        if ($coupon->min_cart_value && $cartTotal < $coupon->min_cart_value) {
            return response()->json(['success' => false, 'message' => 'Giá trị đơn hàng không đủ để áp dụng mã giảm giá!'], 400);
        }

        $discount = 0;
        if ($coupon->type === 'percent') {
            $discount = $cartTotal * ($coupon->value / 100);
        } else {
            $discount = $coupon->value;
        }

        // Lưu mã giảm giá vào session
        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá đã được áp dụng!',
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discount,
            'total' => $cartTotal - $discount
        ]);
    }
    public function removeCoupon()
    {
        $discount = Session::has('coupon') ? Session::get('coupon.discount') : 0;

        // Xóa mã giảm giá khỏi session
        Session::forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Mã giảm giá đã được xóa!',
            'discount' => 0
        ]);
    }
    public function list()
    {
        $coupons = Coupon::latest()->paginate(10);
        $products = Product::latest()->take(8)->get();
        return view('admin.coupons.list', compact('coupons', 'products'));
    }
}
