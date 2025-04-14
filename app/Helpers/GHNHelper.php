<?php

namespace App\Helpers;

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
        $token = env('GHNHANH_API_KEY');
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/ward?district_id=$districtId";
        $wards = self::fetchGHN($url, $token);
        return collect($wards)->firstWhere('WardCode', $wardCode)['WardName'] ?? 'Không rõ';
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
