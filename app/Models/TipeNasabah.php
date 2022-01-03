<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeNasabah extends Model
{
    use HasFactory;
    protected $table = 'tipe_nasabah';

    public function nasabah()
    {
        return $this->hasMany('\App\Modes\Nasabah', 'id_tipe');
    }
}
