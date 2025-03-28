<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('admin.sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
        ]);

        Size::create($request->only('name'));

        return redirect()->route('sizes.index')->with('success', 'Kích thước đã được thêm thành công!');
    }

    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
        ]);

        $size->update($request->only('name'));

        return redirect()->route('sizes.index')->with('success', 'Kích thước đã được cập nhật!');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return redirect()->route('sizes.index')->with('success', 'Kích thước đã được xóa!');
    }
}
