<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductVariant;


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
            'product_id' => 'nullable|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Nếu có biến thể
        if (!empty($validate['variant_id'])) {
            $variant = ProductVariant::with(['product', 'attributeValues.attribute'])->findOrFail($validate['variant_id']);

            $attributes = $variant->attributeValues->map(function ($attrVal) {
                return $attrVal->attribute->name . ': ' . $attrVal->value;
            })->join(', ');
            Cart::add([
                'id' => $variant->id, // id là của biến thể
                'name' => $variant->product->name,
                'qty' => $validate['quantity'],
                'price' => $variant->price,
                'options' => [
                    'image' => $variant->image ?? $variant->product->image,
                    'variant_attributes' => $attributes,
                ],
            ]);
        }
        // Nếu không có variant → thêm product gốc
        elseif (!empty($validate['product_id'])) {
            $product = Product::findOrFail($validate['product_id']);

            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $validate['quantity'],
                'price' => $product->price,
                'options' => [
                    'image' => $product->image,
                ],
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');
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
    {$carts = Cart::content();
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal()));
        $discount = floatval(Session::get('coupon.discount', 0));
        $shippingFee = 0;
        $total = $subtotal - $discount + $shippingFee;
    
        $addresses = \App\Models\Address::where('user_id', Auth::id())->get();
    
        return view('Frontend.pages.checkout', compact('carts', 'subtotal', 'discount', 'shippingFee', 'total', 'addresses'));
    }
}
