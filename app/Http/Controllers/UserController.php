<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::latest()->select(
            'id',
            'name',
            'phone',
            'avatar',
            'password',
            'email',
            'role'
        )->paginate(5);

        return view('admin.users.index', compact('users'));
    }
    public function detail($id)
    {
        $users = DB::table('users')->where('id', $id)->first();
        return view('admin.users.detail', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validatedDate = $request->validate(
            [
                'name' => 'required|max:15',
                'phone' => 'nullable|max:15',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'role' => 'required|max:15',
            ]
        );
        $validatedDate['password'] = Hash::make($validatedDate['password']);
        User::create($validatedDate);
        return redirect()->route('users.index')->with('success', 'Tạo mới thành công');
    }
//     public function edit($id)
//     {
//         $users = User::find($id);
// <<<<<<< Hung
//         return view('admin.users.edit', compact('users'));
// =======
//         return view('admin.users.create', compact('users'));
// >>>>>>> main
//     }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([

            // 'name' => 'nullable|max:155' . $id,
            // 'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            // 'password' => 'nullable|min:8',
            'role' => 'required|max:255',
        ]);
        $users = User::findOrFail($id);

       $users->update([
        // 'name' => $validatedData['name'],
        // 'email' => $validatedData['email'],
        // 'password' => $validatedData['password'] ?? $users-> password,
        'role' => $validatedData['role'],

       ]);
        return redirect()->route('users.index')->with('success', 'User đã được cập nhật!');
    }
    public function destroy($id)
    {
        $users = User::find($id);
        if (!$users) {
            return redirect()->route('users.index')->with('error', 'User không tồn tại.');
        }

        $users->delete();

        return redirect()->route('users.index')->with('success', 'User đã bị xóa thành công.');
    }

}
