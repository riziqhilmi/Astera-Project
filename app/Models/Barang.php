<?php

// app/Models/Barang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ruangan',
        'foto',
        'nama',
        'total',
        'kategori',
        'kondisi',
        'tanggal_pembelian',
        'status'
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
    ];
    
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
