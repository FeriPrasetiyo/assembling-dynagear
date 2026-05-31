<?php

namespace App\Http\Controllers;

use App\Models\PostFile;
use Illuminate\Support\Facades\Storage;

class PostFileController extends Controller
{
    public function destroy($wilayah, $post, PostFile $file)
    {
        Storage::disk('public')->delete($file->file);

        $file->delete();

        return back()->with(
            'success',
            'File berhasil dihapus'
        );
    }
}