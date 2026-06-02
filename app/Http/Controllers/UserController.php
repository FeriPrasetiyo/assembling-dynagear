<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function adminOnly()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->adminOnly();

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->adminOnly();

        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->adminOnly();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $this->adminOnly();

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->adminOnly();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/users')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $this->adminOnly();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Admin tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return redirect('/users')->with('success', 'User berhasil dihapus');
    }
}