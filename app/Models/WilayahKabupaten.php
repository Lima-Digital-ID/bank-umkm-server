<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKabupaten extends Model
{
    use HasFactory;
    protected $table = 'wilayah_kabupaten';

    public function kecamatan()
    {
        return $this->hasMany('\App\Models\WilayahKecamatan', 'kabupaten_id');
    }
}
