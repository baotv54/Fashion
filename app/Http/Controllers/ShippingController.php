<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        $response = Http::withToken(env('GHN_TOKEN'))
            ->withHeaders([
                'ShopId' => env('GHN_SHOP_ID'),
                'Content-Type' => 'application/json',
            ])
            ->post('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee', [
                "service_type_id" => 2,
                "from_district_id" => 1450, // Quận bạn gửi hàng
                "to_district_id" => (int) $request->district_id,
                "to_ward_code" => $request->ward_code,
                "height" => 10,
                "length" => 20,
                "weight" => (int) $request->weight,
                "width" => 20,
                "insurance_value" => $request->order_value,
            ]);

        if ($response->successful()) {
            $fee = $response['data']['total'];
            return response()->json([
                'fee' => $fee,
                'formatted' => number_format($fee, 0, ',', '.') . '₫'
            ]);
        }

        return response()->json(['error' => 'Không tính được phí vận chuyển'], 500);
    }
}
