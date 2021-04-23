<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;
    protected $table = 'nasabah';

    public function pinjaman()
    {
        return $this->hasMany('App\Models\Pinjaman');
    }
}
