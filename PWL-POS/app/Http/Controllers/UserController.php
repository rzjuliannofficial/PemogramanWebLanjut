<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    public function profile($id, $name)
    {

        $user = [
            'id' => $id,
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)) . '@pos.com',
            'role' => 'Kasir',
            'joined_date' => '2025-01-15'
        ];

        return view('user.profile', ['user' => $user]);
    }

    public function tambah()
    {
        return view('user.user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah_simpan(Request $request, $id)
    {
        $user = UserModel::find($id);
        
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }
}
