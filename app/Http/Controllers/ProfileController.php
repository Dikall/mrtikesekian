<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        return view('laravel-examples.user-profile', compact('user'));
    }

    public function userManagement()
    {
        $users = User::all();
        $roles = ['Admin', 'Creator', 'Member']; // Tambahkan peran yang tersedia

        return view('laravel-examples.user-management', compact('users', 'roles'));
    }

    // Metode untuk memperbarui pengguna
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return back()->with('success', 'User updated successfully.');
    }

    // Metode untuk menambahkan pengguna baru
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'New user added successfully.');
    }
}
