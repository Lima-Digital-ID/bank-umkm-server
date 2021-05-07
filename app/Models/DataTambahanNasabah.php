<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTambahanNasabah extends Model
{
    use HasFactory;
    protected $table = 'data_tambahan_nasabah';

    public function nasabah()
    {
        return $this->belongsTo('\App\Models\Nasabah', 'id_nasabah');
    }
}
