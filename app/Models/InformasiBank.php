<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiBank extends Model
{
    use HasFactory;

    protected $table = 'informasi_bank';

    public function bank()
    {
        return $this->belongsTo('\App\Models\MasterBank', 'id_bank');
    }

    public function nasabah()
    {
        return $this->belongsTo('\App\Models\Nasabah', 'id_nasabah');
    }
}
