<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorCabang extends Model
{
    use HasFactory;
    protected $table = 'kantor_cabang';

    public function user()
    {
        return $this->hasMany('\App\Models\User', 'id_kantor_cabang');
    }

    public function kecamatan()
    {
        return $this->belongsTo('\App\Models\WilayahKecamatan', 'kecamatan_id');
    }
}
