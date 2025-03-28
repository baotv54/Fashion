<?php



namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'code' => 'required|string|max:10|unique:colors,code',
        ]);

        Color::create($request->only('name', 'code'));

        return redirect()->route('colors.index')->with('success', 'Màu sắc đã được thêm thành công!');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'code' => 'required|string|max:10|unique:colors,code,' . $color->id,
        ]);

        $color->update($request->only('name', 'code'));

        return redirect()->route('colors.index')->with('success', 'Màu sắc đã được cập nhật!');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return redirect()->route('colors.index')->with('success', 'Màu sắc đã được xóa!');
    }
}
