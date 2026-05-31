<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wilayah;
use App\Models\PostFile;

class Post extends Model
{
    protected $fillable = [
        'nomor_so',
        'nama_barang',
        'tanggal',
        'wilayah_id',
        'description',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function files()
    {
        return $this->hasMany(PostFile::class);
    }
}