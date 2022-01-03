<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKecamatan extends Model
{
    use HasFactory;
    protected $table = 'wilayah_kecamatan';
    public $incrementing = false;

    public function nasabah()
    {
        return $this->hasMany('\App\Models\Nasabah');
    }

    public function kabupaten()
    {
        return $this->belongsTo('\App\Models\WilayahKabupaten', 'kabupaten_id');
    }

    public function kantorCabang()
    {
        return $this->hasMany('\App\Models\KantorCabang', 'kecamatan_id');
    }
}
