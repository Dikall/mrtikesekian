<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;

    protected $fillable = ['risks_id', 'likelihood', 'impact', 'level'];

    public function risk()
    {
        return $this->belongsTo(Risk::class, 'risks_id');
    }

}

