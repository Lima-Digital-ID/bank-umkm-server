<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPinjamanUmroh extends Model
{
    use HasFactory;
    protected $table = 'syarat_pinjaman_umroh';

    public function nasabah()
    {
        return $this->belongsTo('\App\Models\Nasabah', 'id_nasabah');
    }
}
