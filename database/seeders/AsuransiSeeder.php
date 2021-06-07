<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\AsuransiPinjaman;

class AsuransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asuransi = new AsuransiPinjaman;
        $asuransi->jumlah_asuransi = 100000;
        $asuransi->save();
    }
}
