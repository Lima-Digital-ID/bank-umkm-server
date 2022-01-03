<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;
    protected $table = 'pencairan';

    public function pinjaman()
    {
        return $this->belongsTo('App\Models\Pinjaman', 'id_pinjaman');
    }
}
