<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Nasabah extends Model
{
    use HasApiTokens,HasFactory;
    protected $table = 'nasabah';

    protected $hidden = [
        'password',
        'token',
    ];

    public function pinjaman()
    {
        return $this->hasMany('App\Models\Pinjaman');
    }

    public function tipe()
    {
        return $this->belongsTo('\App\Models\TipeNasabah');
    }

    public function dataTambahan()
    {
        return $this->hasOne('App\Models\DataTambahanNasabah','id_nasabah');
    }
}
