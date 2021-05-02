<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPinjaman extends Model
{
    use HasFactory;

    protected $table = 'jenis_pinjaman';

    public function pinjaman()
    {
        return $this->hasMany('\App\Models\Pinjaman', 'id_jenis_pinjaman');
    }
}
