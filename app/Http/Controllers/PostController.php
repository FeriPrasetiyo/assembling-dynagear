<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Wilayah;
use App\Models\PostFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    private function checkViewAccess(Wilayah $wilayah)
    {
        if (
            auth()->user()->role !== 'admin' &&
            $wilayah->user_id !== auth()->id()
        ) {
            abort(403);
        }
    }

    private function adminOnly()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }

    private function checkPostBelongsToWilayah(Wilayah $wilayah, Post $post)
    {
        if ($post->wilayah_id !== $wilayah->id) {
            abort(404);
        }
    }

    public function index(Request $request, Wilayah $wilayah)
    {
        $this->checkViewAccess($wilayah);

        $search = $request->search;

        $posts = $wilayah->posts()
            ->with('files')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_so', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('posts.index', compact(
            'wilayah',
            'posts',
            'search'
        ));
    }

    public function create(Wilayah $wilayah)
    {
        $this->adminOnly();

        return view('posts.create', compact('wilayah'));
    }

    public function store(Request $request, Wilayah $wilayah)
    {
        $this->adminOnly();

        $request->validate([
            'nomor_so' => 'required',
            'nama_barang' => 'required',
            'tanggal' => 'required|date',
            'description' => 'nullable',

            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video.*' => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
        ]);

        $post = Post::create([
            'nomor_so' => $request->nomor_so,
            'nama_barang' => $request->nama_barang,
            'tanggal' => $request->tanggal,
            'wilayah_id' => $wilayah->id,
            'description' => $request->description,
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('foto', 'public');

                $post->files()->create([
                    'type' => 'foto',
                    'file' => $path,
                ]);
            }
        }

        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $video) {
                $path = $video->store('video', 'public');

                $post->files()->create([
                    'type' => 'video',
                    'file' => $path,
                ]);
            }
        }

        return redirect('/wilayah/'.$wilayah->id.'/foto-video')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Wilayah $wilayah, Post $post)
    {
        $this->checkViewAccess($wilayah);
        $this->checkPostBelongsToWilayah($wilayah, $post);

        $post->load('files');

        return view('posts.show', compact('wilayah', 'post'));
    }

    public function edit(Wilayah $wilayah, Post $post)
    {
        $this->adminOnly();
        $this->checkPostBelongsToWilayah($wilayah, $post);

        $post->load('files');

        return view('posts.edit', compact('wilayah', 'post'));
    }

    public function update(Request $request, Wilayah $wilayah, Post $post)
    {
        $this->adminOnly();
        $this->checkPostBelongsToWilayah($wilayah, $post);

        $request->validate([
            'nomor_so' => 'required',
            'nama_barang' => 'required',
            'tanggal' => 'required|date',
            'description' => 'nullable',

            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video.*' => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:102400',
        ]);

        if ($request->has('hapus_file')) {
            foreach ($request->hapus_file as $fileId) {
                $file = PostFile::find($fileId);

                if ($file && $file->post_id == $post->id) {
                    Storage::disk('public')->delete($file->file);
                    $file->delete();
                }
            }
        }

        $post->update([
            'nomor_so' => $request->nomor_so,
            'nama_barang' => $request->nama_barang,
            'tanggal' => $request->tanggal,
            'description' => $request->description,
        ]);

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('foto', 'public');

                $post->files()->create([
                    'type' => 'foto',
                    'file' => $path,
                ]);
            }
        }

        if ($request->hasFile('video')) {
            foreach ($request->file('video') as $video) {
                $path = $video->store('video', 'public');

                $post->files()->create([
                    'type' => 'video',
                    'file' => $path,
                ]);
            }
        }

        return redirect('/wilayah/'.$wilayah->id.'/foto-video/'.$post->id)
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Wilayah $wilayah, Post $post)
{
    $this->adminOnly();
    $this->checkPostBelongsToWilayah($wilayah, $post);

    foreach ($post->files as $file) {
        Storage::disk('public')->delete($file->file);
        $file->delete();
    }

    $post->delete();

    return redirect('/wilayah/'.$wilayah->id.'/foto-video')
        ->with('success', 'Data berhasil dihapus');
}
}