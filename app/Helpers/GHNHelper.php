<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GHNHelper
{
    public static function getProvinceName($provinceId)
    {
        $token = env('GHNHANH_API_KEY');
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/province";
        $provinces = self::fetchGHN($url, $token);
        return collect($provinces)->firstWhere('ProvinceID', $provinceId)['ProvinceName'] ?? 'Không rõ';
    }

    public static function getDistrictName($districtId)
    {
        $token = env('GHNHANH_API_KEY');
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/district";
        $districts = self::fetchGHN($url, $token);
        return collect($districts)->firstWhere('DistrictID', $districtId)['DistrictName'] ?? 'Không rõ';
    }
    public static function getWardName($wardCode, $districtId)
    {
        return Cache::remember("ghn_ward_name_{$wardCode}_d{$districtId}", 86400, function () use ($wardCode, $districtId) {
            $token = env('GHNHANH_API_KEY');
            $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/ward?district_id=$districtId";
    
            $response = Http::withHeaders(['Token' => $token])->get($url);
            if ($response->successful()) {
                $wards = $response->json('data');
                
                // Tìm theo WardCode
                $ward = collect($wards)->firstWhere('WardCode', $wardCode);
                if ($ward) {
                    return $ward['WardName'];
                }
                
                // Nếu không tìm thấy bằng WardCode, thử tìm bằng WardID
                $ward = collect($wards)->firstWhere('WardID', (int)$wardCode);
                if ($ward) {
                    return $ward['WardName'];
                }
                
                // Log lỗi để dễ debug
                Log::warning("Không tìm thấy ward với code: $wardCode và district: $districtId");
                
                return 'Không rõ';
            }
    
            Log::error("Lỗi kết nối GHN API để lấy thông tin phường xã: " . $response->body());
            return 'Không rõ';
        });
    }
    private static function fetchGHN($url, $token)
    {
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return $data['data'] ?? [];
    }
}
