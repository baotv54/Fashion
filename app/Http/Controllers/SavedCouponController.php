<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedCouponController extends Controller
{
    public function save($couponId)
    {
        $user = Auth::user();
        $coupon = Coupon::findOrFail($couponId);

        if (!$user->savedCoupons->contains($couponId)) {
            $user->savedCoupons()->attach($couponId);
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Đã lưu mã giảm giá!']);
        }

        return redirect()->back()->with('success', 'Đã lưu mã giảm giá!');
    }

    public function remove($couponId)       
    {
        $user = Auth::user();
        $user->savedCoupons()->detach($couponId);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Đã xóa mã giảm giá!']);
        }

        return redirect()->back()->with('success', 'Đã xóa mã giảm giá!');
    }

    public function myCoupons()
    {
        $coupons = Auth::user()->savedCoupons()->latest()->get(); // ✅ Sửa ở đây
        return view('Frontend.pages.account.voucher_user', compact('coupons'));
    }
    public function myHistorycoupons()
    {
        $user = Auth::user();

        $coupons = $user->savedCoupons()
            ->wherePivot('used', 1)
            ->orderByDesc('coupon_user.created_at')
            ->get();

        return view('Frontend.pages.account.HistoryCoupons', compact('coupons'));
    }
}
