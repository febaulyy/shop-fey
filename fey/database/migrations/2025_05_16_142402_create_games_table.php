<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk')->unique();
            $table->string('nama');
            $table->integer('harga');
            $table->text('deskripsi');
            $table->unsignedBigInteger('kategori_id');
            $table->string('foto')->nullable();
            $table->string('zip_file');
            $table->unsignedBigInteger('user_id'); // untuk user yang mengupload
            $table->timestamps();

            // Relasi ke tabel kategoris & users
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}
