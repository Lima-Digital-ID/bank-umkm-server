<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = 'pinjaman';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function nasabah()
    {
        return $this->belongsTo('App\Models\Nasabah', 'id_nasabah');
    }

    public function pelunasan()
    {
        return $this->hasMany('\App\Models\Pelunasan', 'id_pinjaman');
    }
}
