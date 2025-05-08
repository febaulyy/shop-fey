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
        'deskripsi',
        'kategori_id',
    ];

    // app/Models/Produk.php

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

}
