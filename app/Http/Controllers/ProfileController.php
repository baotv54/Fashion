<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Cập nhật avatar nếu có upload mới
        if ($request->hasFile('avatar')) {
            // Xoá avatar cũ nếu có
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Lưu avatar mới giữ tên gốc (sanitize và tránh trùng tên)
            $uploadedFile = $request->file('avatar');

            // Lấy tên gốc và phần mở rộng
            $originalName = $uploadedFile->getClientOriginalName();
            $extension = $uploadedFile->getClientOriginalExtension();

            // Lấy phần tên (không chứa extension) và sanitize cơ bản
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            // Loại bỏ ký tự không an toàn, thay khoảng trắng bằng gạch dưới
            $baseName = preg_replace('/[^A-Za-z0-9_\- ]+/', '', $baseName);
            $baseName = preg_replace('/\s+/', '_', $baseName);
            $baseName = trim($baseName);

            if (empty($baseName)) {
                // Fallback nếu tên gốc rỗng
                $baseName = (string) time();
            }

            $targetPath = public_path('avatars');
            $uniqueName = $baseName . '.' . $extension;
            $counter = 0;

            // Nếu đã tồn tại, thêm hậu tố -1, -2, ... trước extension
            while (file_exists($targetPath . DIRECTORY_SEPARATOR . $uniqueName)) {
                $counter++;
                $uniqueName = $baseName . '-' . $counter . '.' . $extension;
            }

            $uploadedFile->move($targetPath, $uniqueName);
            $user->avatar = $uniqueName;
        }

        $user->fill($request->except('avatar'));


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $banners = Banner::latest()->take(4)->get();
        return Redirect::to('/account')
            ->with([
                'status' => 'profile-updated',
                'banners' => $banners,
                'success' => 'Cập nhật thông tin thành công!',
            ]);
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
