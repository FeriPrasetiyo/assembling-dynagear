<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Wilayah extends Model
{
    protected $fillable = [
        'nama_wilayah',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}