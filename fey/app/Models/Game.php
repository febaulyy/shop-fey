<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games'; // atau nama tabel sesuai migration kamu

    protected $fillable = [
        'kode_produk',
        'nama',
        'harga',
        'deskripsi',
        'kategori_id',
        'foto',
        'zip_file',
        'user_id',
    ];
}
