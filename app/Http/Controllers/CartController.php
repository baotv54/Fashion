<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $carts =  Cart::content();
        return view('Frontend.pages.cart', compact('carts'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $currentProduct = Product::where('id', $validate['product_id'])->first();
        Cart::add([
            'id' => $currentProduct->id,
            'name' => $currentProduct->name,
            'qty' => $validate['quantity'],
            'price' => $currentProduct->price,
            'options' => ['image' => $currentProduct->image],
        ]);

        return redirect()->route('cart.index')->with('success', 'add success cart');
    }
    public function update(Request $request)
    {
        $rowId = $request->input('rowId');
        $quantity = (int) $request->input('quantity');

        Cart::update($rowId, $quantity);

        $item = Cart::get($rowId);
        $totalItems = Cart::count();
        $totalPrice = Cart::subtotal(0, ',', '.'); // định dạng đẹp

        return response()->json([
            'qty' => $item->qty,
            'subtotal' => number_format($item->price * $item->qty, 0, ',', '.'),
            'total_items' => $totalItems,
            'total_price' => $totalPrice,
        ]);
    }


    public function remove(Request $request)
    {
        if ($request->has('rowId')) {
            $rowId =  $request->query('rowId');
            Cart::remove($rowId);
            return  redirect()->route('cart.index')->with('success', 'remove success cart');
        }
    }

    public function destroy()
    {
        Cart::destroy();
        return  redirect()->route('cart.index')->with('success', 'destroy success cart');
    }

    public function checkout()
    {
        $carts = Cart::content();
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal())); // Chuyển subtotal thành số
        $discount = floatval(Session::get('coupon.discount', 0)); // Đảm bảo discount là số
        $total = $subtotal - $discount;
        
        return view('Frontend.pages.checkout', compact('carts', 'subtotal', 'discount', 'total'));
    }
}
