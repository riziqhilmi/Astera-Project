<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'jumlah',
        'tanggal_keluar',
        'tujuan',
        'keterangan',
        'penanggung_jawab'
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}