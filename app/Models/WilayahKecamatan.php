<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahKecamatan extends Model
{
    use HasFactory;
    protected $table = 'wilayah_kecamatan';

    public function nasabah()
    {
        return $this->hasMany('\App\Models\Nasabah');
    }

    public function kabupaten()
    {
        return $this->hasMany('\App\Models\WilayahKabupaten');
    }
}
