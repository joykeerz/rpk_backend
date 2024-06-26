<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $table = 'alamat';
    protected $fillable = [
        'id',
        'jalan',
        'jalan_ext',
        'blok',
        'rt',
        'rw',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'kelurahan',
        'negara',
        'kode_pos',
        'external_alamat_id',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'kota_id',
    ];
    // protected $guarded = ['id'];

    // public function biodata()
    // {
    //     return $this->belongsTo(Biodata::class);
    // }

    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // public function pesanan()
    // {
    //     return $this->belongsTo(Pesanan::class);
    // }

    // public function gudang()
    // {
    //     return $this->belongsTo(Gudang::class);
    // }
}
