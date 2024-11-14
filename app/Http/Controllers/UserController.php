<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Existing index method
    public function index()
    {
        $users = User::all();
        return view('laravel-examples.users-management', compact('users'));
    }

    // New edit method
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('laravel-examples.user-edit', compact('user'));
    }

    // New destroy method
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users-management')->with('success', 'User deleted successfully.');
    }
}
