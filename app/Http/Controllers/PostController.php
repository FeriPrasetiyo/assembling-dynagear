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
            (int) $wilayah->user_id !== (int) auth()->id()
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
        if ((int) $post->wilayah_id !== (int) $wilayah->id) {
            abort(404);
        }
    }

    private function uploadWatermarkedPhoto($foto, Wilayah $wilayah, Request $request, Post $post)
{
    $filename = time().'_'.uniqid().'.jpg';
    $savePath = storage_path('app/public/foto/'.$filename);

    $sourcePath = $foto->getPathname();
    $mime = $foto->getMimeType();

    if ($mime === 'image/png') {
        $image = imagecreatefrompng($sourcePath);
    } else {
        $image = imagecreatefromjpeg($sourcePath);
    }

    $width = imagesx($image);
    $height = imagesy($image);

    // Font
    $fontPath = '/usr/share/fonts/dejavu/DejaVuSans-Bold.ttf';

    if (!file_exists($fontPath)) {
        $fontPath = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
    }

    // Ukuran watermark
    $fontSize = max(32, intval($width / 28));
    $padding = intval($fontSize * 0.8);
    $lineHeight = intval($fontSize * 1.45);

    $lines = [
        'PT DYNAGEAR',
        'WILAYAH : '.strtoupper($wilayah->nama_wilayah),
        'SO : '.$request->nomor_so,
        date('d-m-Y H:i'),
    ];

    // Hitung ukuran box
    $maxTextWidth = 0;

    foreach ($lines as $line) {
        $box = imagettfbbox($fontSize, 0, $fontPath, $line);
        $textWidth = abs($box[4] - $box[0]);

        if ($textWidth > $maxTextWidth) {
            $maxTextWidth = $textWidth;
        }
    }

    $boxWidth = $maxTextWidth + ($padding * 2);
    $boxHeight = ($lineHeight * count($lines)) + ($padding * 1.3);

    $boxX = intval($width * 0.035);
    $boxY = $height - $boxHeight - intval($height * 0.04);

    // Warna
    $blackTransparent = imagecolorallocatealpha($image, 0, 0, 0, 45);
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);

    imagefilledrectangle(
        $image,
        $boxX,
        $boxY,
        $boxX + $boxWidth,
        $boxY + $boxHeight,
        $blackTransparent
    );

    $textX = $boxX + $padding;
    $textY = $boxY + $padding + $fontSize;

    foreach ($lines as $index => $line) {
        $y = $textY + ($index * $lineHeight);

        // Shadow hitam
        imagettftext($image, $fontSize, 0, $textX + 3, $y + 3, $black, $fontPath, $line);

        // Text putih
        imagettftext($image, $fontSize, 0, $textX, $y, $white, $fontPath, $line);
    }

    imagejpeg($image, $savePath, 85);
    imagedestroy($image);

    $post->files()->create([
        'type' => 'foto',
        'file' => 'foto/'.$filename,
    ]);
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

        return view('posts.index', compact('wilayah', 'posts', 'search'));
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
                $this->uploadWatermarkedPhoto($foto, $wilayah, $request, $post);
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

                if ($file && (int) $file->post_id === (int) $post->id) {
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
                $this->uploadWatermarkedPhoto($foto, $wilayah, $request, $post);
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