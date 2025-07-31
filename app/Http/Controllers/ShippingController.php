<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    public function calculate(Request $request)
    {
        $districtId = $request->input('district_id');
        $wardCode = $request->input('ward_code');
        $weight = $request->input('weight', 500);

        if (!$districtId || !$wardCode) {
            return response()->json(['success' => false, 'message' => 'Thiếu thông tin địa chỉ'], 400);
        }

        try {
            $response = Http::withHeaders([
                'Token' => env('GHNHANH_API_KEY'),
                'ShopId' => env('GHN_SHOP_ID')
            ])->post(env('GHNHANH_API_URL') . '/shiip/public-api/v2/shipping-order/fee', [
                'from_district_id' => (int) env('GHN_FROM_DISTRICT_ID', 1442),
                'service_type_id' => 2,
                'to_district_id' => (int) $districtId,
                'to_ward_code' => $wardCode,
                'weight' => (int) $weight,
                'length' => 20,
                'width' => 20,
                'height' => 10,
            ]);


            if ($response->successful()) {
                $data = $response->json();
                $fee = data_get($data, 'data.total', 0);
                return response()->json([
                    'success' => true,
                    'fee' => $fee,
                    'formatted_fee' => number_format($fee, 0, ',', '.') . ' đ'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $response->json('message') ?? 'Lỗi từ dịch vụ vận chuyển'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
