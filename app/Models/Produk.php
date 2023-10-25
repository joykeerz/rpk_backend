<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'nama_produk',
        'deskripsi_produk',
        'harga_produk',
        'kategori_id',
        'stok_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function inputProduk(){

    }
}
