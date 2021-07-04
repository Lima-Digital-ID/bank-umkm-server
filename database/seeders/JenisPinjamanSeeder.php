<?php

namespace Database\Seeders;

use App\Models\JenisPinjaman;
use Illuminate\Database\Seeder;

class JenisPinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newJenisPinjaman = new JenisPinjaman;
        $newJenisPinjaman->jenis_pinjaman = 'Haji/Umroh';
        $newJenisPinjaman->limit_pinjaman = 10000000;
        $newJenisPinjaman->save();

        $newJenisPinjaman = new JenisPinjaman;
        $newJenisPinjaman->jenis_pinjaman = 'Pinjaman Cepat';
        $newJenisPinjaman->limit_pinjaman = 5000000;
        $newJenisPinjaman->save();

        $newJenisPinjaman = new JenisPinjaman;
        $newJenisPinjaman->jenis_pinjaman = 'Diatas 5jt';
        $newJenisPinjaman->limit_pinjaman = 50000000;
        $newJenisPinjaman->save();


    }
}
