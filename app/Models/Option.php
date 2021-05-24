<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $table = 'option';

    public function kriteria()
    {
        return $this->belongsTo('\App\Models\Kriteria', 'id_kriteria');
    }

    public function scoring()
    {
        return $this->hasMany('\App\Models\Scoring', 'id_option');
    }
}
