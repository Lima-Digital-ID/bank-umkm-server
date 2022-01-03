<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBank extends Model
{
    use HasFactory;

    protected $table = 'master_bank';

    public function informasiBank()
    {
        return $this->hasMany('\App\Models\InformasiBank', 'id_bank');
    }
}
