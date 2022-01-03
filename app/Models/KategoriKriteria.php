<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKriteria extends Model
{
    use HasFactory;

    protected $table = 'kategori_kriteria';

    public function kriteria()
    {
        return $this->hasMany('\App\Models\Kriteria', 'id_kategori');
    }
}
