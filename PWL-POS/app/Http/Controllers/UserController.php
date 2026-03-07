<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // coba akses model UserModel
        $user = UserModel::firstOrCreate(
            ['username' => 'manager22'],
            ['nama' => 'Manager Dua Dua', 'password' => Hash::make('12345'), 'level_id' => 2]
        );
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
}
