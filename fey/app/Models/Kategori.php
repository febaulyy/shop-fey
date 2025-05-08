<?php 
namespace App\Models; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
 
class Kategori extends Model 
{ 
    use HasFactory; 
 
    // Nama tabel (jika berbeda dari default, yaitu "kategoris") 
    protected $table = 'kategoris'; 
 
    // Kolom yang boleh diisi secara massal 
    protected $fillable = [ 
        'nama', 
    ]; 
 
    // Jika ada relasi dengan model lain, contoh: 
    public function produk() 
    { 
        return $this->hasMany(Produk::class); 
    } 

}