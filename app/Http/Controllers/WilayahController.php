<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WilayahController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $wilayahs = Wilayah::with('user')->latest()->get();
        } else {
            $wilayahs = Wilayah::with('user')
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $users = User::where('role', 'user')->get();

        return view('wilayah.create', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
    'nama_wilayah' => 'required',
    'user_id' => 'required|exists:users,id|unique:wilayah,user_id',
], [
    'user_id.unique' => 'User ini sudah memiliki wilayah.',
]);

        Wilayah::create([
            'user_id' => $request->user_id,
            'nama_wilayah' => $request->nama_wilayah,
        ]);

        return redirect('/wilayah')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function destroy(Wilayah $wilayah)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    foreach ($wilayah->posts as $post) {
        foreach ($post->files as $file) {
            Storage::disk('public')->delete($file->file);
            $file->delete();
        }

        $post->delete();
    }

    $wilayah->delete();

    return redirect('/wilayah')
        ->with('success', 'Wilayah dan semua file berhasil dihapus');
}
}