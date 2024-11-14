<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miti extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'mitis';

    // Tentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'risk_id',  // Kolom foreign key untuk menghubungkan dengan risiko
        'mitigasi', // Kolom yang menyimpan data mitigasi
    ];

    /**
     * Relasi ke model Risk
     * Satu data mitigasi terkait dengan satu risiko
     */
    public function risk()
    {
        return $this->belongsTo(Risk::class, 'risk_id');
    }
}
