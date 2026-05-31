<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::latest()->get();

        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required',
        ]);

        Wilayah::create([
            'nama_wilayah' => $request->nama_wilayah,
        ]);

        return redirect('/wilayah')
            ->with('success', 'Wilayah berhasil ditambahkan');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();

        return redirect('/wilayah')
            ->with('success', 'Wilayah berhasil dihapus');
    }
}