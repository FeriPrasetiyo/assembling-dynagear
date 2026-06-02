<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
    $table->id();

    $table->foreignId('wilayah_id')
        ->constrained('wilayah')
        ->cascadeOnDelete();

    $table->string('nomor_so');
    $table->string('nama_barang');
    $table->date('tanggal');
    $table->text('description')->nullable();

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};  