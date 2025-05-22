<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'kode_produk',
        'nama',
        'harga',
        'stok',
        'foto',
        'zip_file', // ← tambahkan ini
        'deskripsi',
        'kategori_id',
    ];
    

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

}
