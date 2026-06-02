<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostFile;
use App\Models\Wilayah;
use Illuminate\Support\Facades\Storage;

class PostFileController extends Controller
{
    public function destroy(
        Wilayah $wilayah,
        Post $post,
        PostFile $file
    ) {
        // Hanya admin yang boleh hapus file
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        // Pastikan file milik post yang benar
        if ($file->post_id != $post->id) {
            abort(404);
        }

        Storage::disk('public')->delete($file->file);

        $file->delete();

        return back()->with(
            'success',
            'File berhasil dihapus'
        );
    }
}