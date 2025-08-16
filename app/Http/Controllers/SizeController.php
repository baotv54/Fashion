<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:50',
            'height_range' => 'nullable|string|max:50',
            'weight_range' => 'nullable|string|max:50',
            'chest_range' => 'nullable|string|max:50',
            'hip_range' => 'nullable|string|max:50',
        ]);
        Size::create($request->only(['size', 'height_range', 'weight_range', 'chest_range', 'hip_range']));
        return redirect()->route('sizes.index')->with('success', 'Thêm size thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'size' => 'required|string|max:50',
            'height_range' => 'nullable|string|max:50',
            'weight_range' => 'nullable|string|max:50',
            'chest_range' => 'nullable|string|max:50',
            'hip_range' => 'nullable|string|max:50',
        ]);
        $size->update($request->only(['size', 'height_range', 'weight_range', 'chest_range', 'hip_range']));
        return redirect()->route('sizes.index')->with('success', 'Cập nhật size thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('sizes.index')->with('success', 'Xóa size thành công!');
    }
}
