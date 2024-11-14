<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;
    protected $fillable = ['kode','faktor', 'kemungkinan', 'dampak'];

        public function values()
        {
            return $this->hasMany(Value::class, 'risks_id');
        }

        public function mitis()
        {
            return $this->hasMany(Miti::class, 'risk_id');
        }
    
}
