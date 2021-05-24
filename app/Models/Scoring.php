<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoring extends Model
{
    use HasFactory;

    protected $table = 'scoring';

    public function option()
    {
        return $this->belongsTo('\App\Models\Option', 'id_option');
    }
    
    public function nasabah()
    {
        return $this->belongsTo('\App\Models\Nasabah', 'id_nasabah');
    }
}
