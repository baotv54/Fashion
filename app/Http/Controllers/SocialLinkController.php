<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::all();
        return view('admin.socials.index', compact('links'));
    }

    public function create()
    {
        return view('admin.socials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'url'      => 'nullable|url',
            'image'    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('socials', 'public');
        }

        SocialLink::create([
            'platform' => $request->platform,
            'url'      => $request->url,
            'image'    => $imagePath,
        ]);

        return redirect()->route('social-links.index')->with('success', 'Thêm mới thành công!');
    }

    public function edit($id)
    {
        $socialLink = SocialLink::findOrFail($id);
        return view('admin.socials.create', compact('socialLink'));
    }

    public function update(Request $request, $id)
    {
        $socialLink = SocialLink::findOrFail($id);

        $request->validate([
            'platform' => 'required|string|max:50',
            'url'      => 'nullable|url',
            'image'    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = [
            'platform' => $request->platform,
            'url'      => $request->url,
        ];

        if ($request->hasFile('image')) {
            if ($socialLink->image && Storage::disk('public')->exists($socialLink->image)) {
                Storage::disk('public')->delete($socialLink->image);
            }
            $data['image'] = $request->file('image')->store('socials', 'public');
        }

        $socialLink->update($data);

        return redirect()->route('social-links.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
{
    $socialLink = SocialLink::findOrFail($id);


    if ($socialLink->image && Storage::disk('public')->exists($socialLink->image)) {
        Storage::disk('public')->delete($socialLink->image);
    }

    $socialLink->delete();
    return redirect()->back()->with('success', 'Xóa thành công!');
}
}
