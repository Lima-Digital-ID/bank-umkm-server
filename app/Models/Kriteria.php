<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    public function kategoriKriteria()
    {
        return $this->belongsTo('\App\Models\KategoriKriteria', 'id_kategori');
    }

    public function option()
    {
        return $this->hasMany('\App\Models\Option', 'id_kriteria');
    }
}
