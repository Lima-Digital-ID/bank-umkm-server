<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Nasabah extends Model
{
    use HasApiTokens,HasFactory;
    protected $table = 'nasabah';

    protected $hidden = array('token');


    public function pinjaman()
    {
        return $this->hasMany('App\Models\Pinjaman');
    }

    public function penjamin()
    {
        return $this->hasMany('\App\Models\Penjamin', 'id_nasabah');
    }

    public function tipe()
    {
        return $this->belongsTo('\App\Models\TipeNasabah');
    }

    public function dataTambahan()
    {
        return $this->hasOne('App\Models\DataTambahanNasabah','id_nasabah');
    }
    
    public function syaratPinjamanUmroh()
    {
        return $this->hasOne('App\Models\SyaratPinjamanUmroh','id_nasabah');
    }

    public function scoring()
    {
        return $this->hasMany('\App\Models\Scoring', 'id_nasabah');
    }

    public function informasiBank()
    {
        return $this->hasMany('\App\Models\InformasiBank', 'id_nasabah');
    }

    public function kecamatan()
    {
        return $this->belongsTo('\App\Models\WilayahKecamatan');
    }

    public function kabupaten()
    {
        return $this->belong('\App\Models\WilayahKabupaten', 'kecamatan_id', 'id');
    }

}
