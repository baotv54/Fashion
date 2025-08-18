<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Lấy thông tin biến thể của sản phẩm
     */
    public function getProductVariants($productId)
    {
        try {
            $product = Product::with(['variants.attributeValues.attribute', 'brand'])->findOrFail($productId);
            $cartItem = Cart::search(function ($cartItem) use ($productId) {
                return isset($cartItem->options['product_id']) && $cartItem->options['product_id'] == $productId;
            })->first();

            $attributes = $product->variants
                ->flatMap(function ($variant) {
                    return $variant->attributeValues;
                })
                ->groupBy(fn($attrVal) => $attrVal->attribute->name)
                ->map(function ($values, $attributeName) {
                    return $values->unique('id')->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'value' => $value->value,
                            'attribute_name' => $value->attribute->name,
                        ];
                    })->sortBy('id')->values();
                })
                ->sortKeys();

            $variantMapping = [];
            $variantDetails = [];

            foreach ($product->variants as $variant) {
                $attributeIds = $variant->attributeValues->pluck('id')->sort()->values()->toArray();
                $key = implode('-', $attributeIds);

                $variantPrice = $variant->price ?? $product->price;
                $comparePrice = $variant->compare_at_price ?? $product->compare_at_price;
                $discount = $comparePrice && $comparePrice > $variantPrice ? round((($comparePrice - $variantPrice) / $comparePrice) * 100) : 0;

                $variantData = [
                    'id' => $variant->id,
                    'price' => $variantPrice,
                    'compare_at_price' => $comparePrice,
                    'discount' => $discount,
                    'stock' => $variant->stock,
                    'image' => $variant->image ? asset($variant->image) : null,
                    'sku' => $variant->sku,
                    'attribute_ids' => $attributeIds,
                    'attribute_combination' => $variant->attributeValues->map(function ($attrVal) {
                        return $attrVal->attribute->name . ': ' . $attrVal->value;
                    })->join(', ')
                ];

                $variantMapping[$key] = $variantData;
                $variantDetails[] = $variantData;
            }

            $variantsForResponse = $product->variants->map(function ($variant) use ($product) {
                $variantPrice = $variant->price ?? $product->price;
                $comparePrice = $variant->compare_at_price ?? $product->compare_at_price;

                return [
                    'id' => $variant->id,
                    'price' => $variantPrice,
                    'compare_at_price' => $comparePrice,
                    'stock' => $variant->stock,
                    'image' => $variant->image ? asset($variant->image) : null,
                    'sku' => $variant->sku,
                    'attribute_values' => $variant->attributeValues->map(function ($attrVal) {
                        return [
                            'id' => $attrVal->id,
                            'value' => $attrVal->value,
                            'attribute_name' => $attrVal->attribute->name
                        ];
                    })
                ];
            });

            $response = [
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'vendor' => $product->brand->name ?? 'Đang cập nhật',
                    'type' => $product->type ?? 'Đang cập nhật',
                    'price' => $product->price,
                    'compare_at_price' => $product->compare_at_price,
                    'discount' => $product->compare_at_price ? round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100) : 0,
                    'sku' => $product->sku ?? 'Đang cập nhật',
                    'image' => $product->image ? asset($product->image) : null,
                    'stock' => $product->quantity ?? 0,
                ],
                'attributes' => $attributes,
                'variants' => $variantsForResponse,
                'variantMapping' => $variantMapping,
                'cartItem' => $cartItem ? [
                    'rowId' => $cartItem->rowId,
                    'options' => $cartItem->options
                ] : null,
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error getting product variants: ' . $e->getMessage(), [
                'product_id' => $productId,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['error' => 'Không thể tải dữ liệu biến thể'], 500);
        }
    }

    /**
     * Cập nhật biến thể trong giỏ hàng
     */
    public function updateVariant(Request $request)
    {
        Log::info('UpdateVariant called', [
            'request_data' => $request->all(),
            'session_id' => session()->getId(),
        ]);

        try {
            $validated = $request->validate([
                'rowId' => 'required|string',
                'variant_id' => 'required|integer|exists:product_variants,id',
            ]);

            $rowId = $validated['rowId'];
            $variantId = $validated['variant_id'];

            $currentItem = Cart::get($rowId);
            if (!$currentItem) {
                return response()->json(['error' => 'Sản phẩm không tồn tại trong giỏ hàng'], 404);
            }

            $newVariant = ProductVariant::with(['product', 'attributeValues.attribute'])->findOrFail($variantId);
            if ($newVariant->stock < $currentItem->qty) {
                return response()->json([
                    'error' => 'Biến thể không đủ số lượng trong kho. Còn lại: ' . $newVariant->stock
                ], 400);
            }

            $newAttributes = $newVariant->attributeValues->mapWithKeys(function ($attrVal) {
                return [$attrVal->attribute->name => $attrVal->value];
            })->toArray();

            $existingVariantItem = Cart::search(function ($cartItem) use ($variantId, $rowId) {
                return isset($cartItem->options['variant_id']) &&
                    (int)$cartItem->options['variant_id'] == $variantId &&
                    $cartItem->rowId !== $rowId;
            })->first();

            $finalRowId = $rowId;
            $finalQuantity = $currentItem->qty;
            $merged = false;

            if ($existingVariantItem) {
                $totalQuantity = $existingVariantItem->qty + $currentItem->qty;
                if ($totalQuantity > $newVariant->stock) {
                    return response()->json([
                        'error' => 'Tổng số lượng vượt quá tồn kho. Còn lại: ' . $newVariant->stock
                    ], 400);
                }

                Cart::update($existingVariantItem->rowId, $totalQuantity);
                Cart::remove($rowId);
                $finalRowId = $existingVariantItem->rowId;
                $finalQuantity = $totalQuantity;
                $merged = true;
            } else {
                $variantPrice = $newVariant->price ?? $newVariant->product->price;
                $updateData = [
                    'id' => 'variant_' . $variantId,
                    'name' => $newVariant->product->name,
                    'qty' => $currentItem->qty,
                    'price' => $variantPrice,
                    'options' => [
                        'image' => $newVariant->image ?? $newVariant->product->image,
                        'variant_attributes' => $newAttributes, // Lưu dưới dạng mảng
                        'variant_id' => $variantId,
                        'product_id' => $newVariant->product_id,
                        'type' => 'variant',
                    ],
                ];
                Cart::update($rowId, $updateData);
                $updatedItems = Cart::search(function ($cartItem) use ($variantId) {
                    return isset($cartItem->options['variant_id']) && (int)$cartItem->options['variant_id'] == $variantId;
                });
                if ($updatedItems->isNotEmpty()) {
                    $finalRowId = $updatedItems->first()->rowId;
                }
            }

            $updatedItem = Cart::get($finalRowId);
            if (!$updatedItem) {
                return response()->json(['error' => 'Không thể lấy thông tin sản phẩm đã cập nhật'], 500);
            }

            $response = [
                'success' => 'Cập nhật biến thể thành công',
                'merged' => $merged,
                'item' => [
                    'rowId' => $updatedItem->rowId,
                    'name' => $updatedItem->name,
                    'qty' => $updatedItem->qty,
                    'price' => number_format($updatedItem->price, 0, ',', '.'),
                    'subtotal' => number_format($updatedItem->price * $updatedItem->qty, 0, ',', '.'),
                    'image' => $updatedItem->options->image ?? '',
                    'variant_attributes' => $updatedItem->options->variant_attributes ?? '',
                    'variant_id' => $updatedItem->options->variant_id ?? null,
                ],
                'cart' => [
                    'total_price' => Cart::subtotal(0, ',', '.'),
                    'count' => Cart::count()
                ],
                'old_rowId' => $rowId,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error('Exception in updateVariant', [
                'error_message' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);
            return response()->json(['error' => 'Lỗi server khi cập nhật biến thể: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $carts = Cart::content();
        return view('Frontend.pages.cart', compact('carts'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'variant_id' => 'nullable|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
                'attributes' => 'nullable|array',
            ]);

            $product = Product::with('variants.attributeValues.attribute')->findOrFail($request->input('product_id'));
            $quantity = $request->input('quantity');

            if (!empty($request->input('variant_id'))) {
                $variant = ProductVariant::with(['product', 'attributeValues.attribute'])->findOrFail($request->input('variant_id'));
                if ($variant->stock < $quantity) {
                    return back()->with('error', 'Sản phẩm không đủ hàng trong kho. Còn lại: ' . $variant->stock);
                }
                $this->addVariantToCart($variant, $quantity);
            } elseif ($product->variants->count() > 0) {
                if (empty($request->input('attributes'))) {
                    return back()->with('error', 'Vui lòng chọn đầy đủ thuộc tính sản phẩm');
                }
                $variant = $this->findVariantByAttributes($product, $request->input('attributes'));
                if (!$variant) {
                    return back()->with('error', 'Không tìm thấy biến thể phù hợp với lựa chọn của bạn');
                }
                if ($variant->stock < $quantity) {
                    return back()->with('error', 'Sản phẩm không đủ hàng trong kho. Còn lại: ' . $variant->stock);
                }
                $this->addVariantToCart($variant, $quantity);
            } else {
                if (($product->quantity ?? 0) < $quantity) {
                    return back()->with('error', 'Sản phẩm không đủ hàng trong kho. Còn lại: ' . ($product->quantity ?? 0));
                }
                $this->addProductToCart($product, $quantity);
            }

            return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
        } catch (\Exception $e) {
            Log::error('Error adding product to cart: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
        }
    }

    /**
     * Tìm biến thể dựa trên thuộc tính
     */
    private function findVariantByAttributes($product, $selectedAttributes)
    {
        foreach ($product->variants as $variant) {
            $variantAttributes = $variant->attributeValues->pluck('id')->toArray();
            if (count(array_intersect($selectedAttributes, $variantAttributes)) === count($selectedAttributes) &&
                count($selectedAttributes) === count($variantAttributes)) {
                return $variant;
            }
        }
        return null;
    }

    /**
     * Thêm biến thể vào giỏ hàng
     */
    private function addVariantToCart($variant, $quantity)
    {
        $attributes = $variant->attributeValues->mapWithKeys(function ($attrVal) {
            return [$attrVal->attribute->name => $attrVal->value];
        })->toArray();

        $existingItem = Cart::search(function ($cartItem) use ($variant) {
            return isset($cartItem->options['variant_id']) && $cartItem->options['variant_id'] == $variant->id;
        });

        if ($existingItem->isNotEmpty()) {
            $cartItem = $existingItem->first();
            $newQuantity = $cartItem->qty + $quantity;
            if ($newQuantity > $variant->stock) {
                throw new \Exception('Tổng số lượng vượt quá tồn kho. Còn lại: ' . $variant->stock);
            }
            Cart::update($cartItem->rowId, $newQuantity);
        } else {
            Cart::add([
                'id' => 'variant_' . $variant->id,
                'name' => $variant->product->name,
                'qty' => $quantity,
                'price' => $variant->price ?? $variant->product->price,
                'options' => [
                    'image' => $variant->image ?? $variant->product->image,
                    'variant_attributes' => $attributes, // Lưu dưới dạng mảng JSON
                    'variant_id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'type' => 'variant',
                ],
            ]);
        }
    }

    /**
     * Thêm sản phẩm vào giỏ hàng (không có biến thể)
     */
    private function addProductToCart($product, $quantity)
    {
        $existingItem = Cart::search(function ($cartItem) use ($product) {
            return isset($cartItem->options['product_id']) && $cartItem->options['product_id'] == $product->id && $cartItem->options['type'] == 'product';
        });

        if ($existingItem->isNotEmpty()) {
            $cartItem = $existingItem->first();
            $newQuantity = $cartItem->qty + $quantity;
            if ($newQuantity > ($product->quantity ?? 0)) {
                throw new \Exception('Tổng số lượng vượt quá tồn kho. Còn lại: ' . ($product->quantity ?? 0));
            }
            Cart::update($cartItem->rowId, $newQuantity);
        } else {
            Cart::add([
                'id' => 'product_' . $product->id,
                'name' => $product->name,
                'qty' => $quantity,
                'price' => $product->discount_price ?? $product->price,
                'options' => [
                    'image' => $product->image,
                    'product_id' => $product->id,
                    'type' => 'product',
                ],
            ]);
        }
    }

    /**
     * Cập nhật số lượng trong giỏ hàng
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'rowId' => 'required',
                'quantity' => 'required|integer|min:1',
            ]);

            $rowId = $request->input('rowId');
            $quantity = $request->input('quantity');
            $item = Cart::get($rowId);

            if (!$item) {
                return response()->json(['error' => 'Mục không tồn tại trong giỏ hàng'], 400);
            }

            if (isset($item->options['type']) && $item->options['type'] === 'variant') {
                $variant = ProductVariant::find($item->options['variant_id']);
                if (!$variant || $quantity > $variant->stock) {
                    return response()->json([
                        'error' => 'Số lượng vượt quá tồn kho. Còn lại: ' . ($variant->stock ?? 0)
                    ], 400);
                }
            } else {
                $product = Product::find($item->options['product_id']);
                if (!$product || $quantity > ($product->quantity ?? 0)) {
                    return response()->json([
                        'error' => 'Số lượng vượt quá tồn kho. Còn lại: ' . ($product->quantity ?? 0)
                    ], 400);
                }
            }

            Cart::update($rowId, $quantity);

            $item = Cart::get($rowId);
            $totalItems = Cart::count();
            $totalPrice = Cart::subtotal(0, ',', '.');

            return response()->json([
                'qty' => $item->qty,
                'subtotal' => number_format($item->price * $item->qty, 0, ',', '.'),
                'total_items' => $totalItems,
                'total_price' => $totalPrice,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'], 500);
        }
    }

    /**
     * Xóa một mục khỏi giỏ hàng
     */
    public function remove(Request $request)
    {
        try {
            $request->validate(['rowId' => 'required']);
            Cart::remove($request->input('rowId'));
            return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
        } catch (\Exception $e) {
            Log::error('Error removing cart item: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa sản phẩm');
        }
    }

    /**
     * Xóa tất cả sản phẩm trong giỏ hàng
     */
    public function destroy()
    {
        try {
            Cart::destroy();
            return redirect()->route('cart.index')->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng');
        } catch (\Exception $e) {
            Log::error('Error destroying cart: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa giỏ hàng');
        }
    }

    /**
     * Hiển thị trang thanh toán
     */
    public function checkout()
    {
        try {
            $carts = Cart::content();

            if ($carts->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
            }

            $cartsWithVariants = $carts->map(function ($cart) {
                $variantId = $cart->options->variant_id ?? null;
                if ($variantId) {
                    $variant = ProductVariant::with(['attributeValues.attribute'])->find($variantId);
                    $cart->variant = $variant;
                    $cart->variant_details = $cart->options->variant_attributes; // Lưu ý: Cần chuyển sang mảng JSON
                }
                return $cart;
            });

            $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal()));
            $discount = floatval(Session::get('coupon.discount', 0));
            $user = Auth::user();
            $coupons = $user->savedCoupons()
                ->wherePivot('used', 0) // ❗ chỉ lấy mã chưa dùng
                ->orderByDesc('coupon_user.created_at')
                ->get();
            $shippingFee = 0;
            $total = $subtotal - $discount + $shippingFee;

            $addresses = Auth::check() ? \App\Models\Address::where('user_id', Auth::id())->get() : collect();

            return view('Frontend.pages.checkout', compact('cartsWithVariants', 'subtotal', 'discount', 'shippingFee', 'total', 'addresses', 'coupons'));
        } catch (\Exception $e) {
            Log::error('Error loading checkout: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải trang thanh toán');
        }
    }

    /**
     * API: Validate tồn kho toàn bộ giỏ hàng (real-time polling)
     * GET /cart/validate
     */
    public function validateCart()
    {
        try {
            $items = [];
            $hasIssue = false;

            foreach (Cart::content() as $cartItem) {
                $type = $cartItem->options['type'] ?? 'product';
                $requested = (int)($cartItem->qty ?? 0);
                $available = 0;
                $ok = true;
                $message = '';

                if ($type === 'variant' && isset($cartItem->options['variant_id'])) {
                    $variant = ProductVariant::find($cartItem->options['variant_id']);
                    $available = (int)($variant->stock ?? 0);
                    if (!$variant || $available <= 0) {
                        $ok = false;
                        $message = 'Hết hàng';
                    } elseif ($requested > $available) {
                        $ok = false;
                        $message = 'Không đủ hàng. Còn lại: ' . $available;
                    }
                } else {
                    $product = Product::find($cartItem->options['product_id'] ?? null);
                    $available = (int)($product->quantity ?? 0);
                    if (!$product || $available <= 0) {
                        $ok = false;
                        $message = 'Hết hàng';
                    } elseif ($requested > $available) {
                        $ok = false;
                        $message = 'Không đủ hàng. Còn lại: ' . $available;
                    }
                }

                if (!$ok) {
                    $hasIssue = true;
                }

                $items[] = [
                    'rowId' => $cartItem->rowId,
                    'name' => $cartItem->name,
                    'type' => $type,
                    'requested' => $requested,
                    'available' => $available,
                    'ok' => $ok,
                    'message' => $message,
                ];
            }

            return response()->json([
                'ok' => !$hasIssue,
                'items' => $items,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error validating cart stock: ' . $e->getMessage());
            return response()->json(['ok' => false, 'error' => 'Không thể kiểm tra tồn kho'], 500);
        }
    }
}