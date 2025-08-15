<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helpers\GHNHelper;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->paginate(4); 
        return view('Frontend.pages.account.address', compact('addresses'));
    }
    

    // Thêm địa chỉ mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'address' => 'required|max:255',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ]);

        // Lấy tên từ GHN API
        $provinceName = GHNHelper::getProvinceName($request->province);
        $districtName = GHNHelper::getDistrictName($request->district);
        $wardName = GHNHelper::getWardName($request->ward, $request->district);

        // Nếu là địa chỉ mặc định, bỏ mặc định các địa chỉ khác
        if ($request->has('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province' => $provinceName,   // lưu tên
            'district' => $districtName,   // lưu tên
            'ward' => $wardName,           // lưu tên
            'is_default' => $request->has('is_default'),
        ]);

        return redirect()->route('addresses.index')->with('success', 'Thêm địa chỉ thành công!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'address' => 'required|max:255',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ]);

        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $provinceName = GHNHelper::getProvinceName($request->province);
        $districtName = GHNHelper::getDistrictName($request->district);
        $wardName = GHNHelper::getWardName($request->ward, $request->district);

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province' => $provinceName,
            'district' => $districtName,
            'ward' => $wardName,
        ]);
        return redirect()->route('addresses.index')->with('success', 'Cập nhật địa chỉ thành công!');
    }

    // Đặt địa chỉ mặc định
    public function setDefault($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Bỏ mặc định của các địa chỉ khác
        Address::where('user_id', Auth::id())->update(['is_default' => false]);

        // Đặt địa chỉ này làm mặc định
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('success', 'Đặt địa chỉ mặc định thành công!');
    }

    // Xóa địa chỉ
    public function destroy($id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Xóa địa chỉ thành công!');
    }

    // Lấy danh sách tỉnh
    public function getProvince()
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/province";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }

    // Lấy danh sách quận theo tỉnh
    public function getDistrict($provinceId)
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/district?province_id=$provinceId";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }

    // Lấy danh sách phường theo quận
    public function getWard($districtId)
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/ward?district_id=$districtId";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }
}
