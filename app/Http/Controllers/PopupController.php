<?php

namespace App\Http\Controllers;

use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function index()
    {
        $popups = Popup::latest()->get();
        return view('admin.popups.index', compact('popups'));
    }

    public function create()
    {
        return view('admin.popups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'media_type'  => 'required|in:image,video',
            'media_file' => 'required|file|mimes:jpg,jpeg,png,mp4,webm|max:102400'
        ]);

        $path = $request->file('media_file')->store('popups', 'public');

        Popup::create([
            'title'       => $request->title,
            'description' => $request->description,
            'media_type'  => $request->media_type,
            'media_path'  => $path,
            'status'      => $request->status ?? 1
        ]);

        return redirect()->route('popups.index')->with('success', 'Thêm popup thành công');
    }

       public function edit($id)
    {
        $popups = Popup::findOrFail($id);
        return view('admin.popups.create', compact('popups'));
    }


    public function update(Request $request, $id)
{
    $popup = Popup::findOrFail($id);

    $request->validate([
        'title'       => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'media_type'  => 'required|in:image,video',
        'media_file'  => 'nullable|file|mimes:jpg,jpeg,png,mp4,webm|max:102400', // 100MB
        'status'      => 'nullable|in:0,1'
    ]);

    $data = $request->only(['title', 'description', 'media_type', 'status']);

    if ($request->hasFile('media_file')) {
        $path = $request->file('media_file')->store('popups', 'public');
        $data['media_path'] = $path;
    }

    $popup->update($data);

    return redirect()->route('popups.index')->with('success', 'Cập nhật popup thành công');
}

  public function destroy(Popup $popup)
{
    if ($popup->media_path && \Storage::disk('public')->exists($popup->media_path)) {
        \Storage::disk('public')->delete($popup->media_path);
    }

    $popup->delete();

    return redirect()->route('popups.index')->with('success', 'Xóa popup thành công');
}
}
