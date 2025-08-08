<?php

// app/Models/Ruangan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans'; 
    protected $fillable = [
        'nama',
        'keterangan'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_ruangan');
    }
}

