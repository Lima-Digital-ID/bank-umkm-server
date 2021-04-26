<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelunasan extends Model
{
    use HasFactory;
    protected $table = 'pelunasan';

    public function pinjaman()
    {
        return $this->belongsTo('\App\Models\Pinjaman');
    }
}
