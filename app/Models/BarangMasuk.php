<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'jumlah',
        'tanggal_masuk',
        'supplier',
        'keterangan',
        'penerima'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}