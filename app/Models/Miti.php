<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miti extends Model
{
    use HasFactory;

    protected $fillable = ['risk_id', 'mitigasi'];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}
