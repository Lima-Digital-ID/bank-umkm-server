<?php

namespace Database\Seeders;

use App\Models\KantorCabang;
use App\Models\WilayahKabupaten;
use App\Models\WilayahKecamatan;
use App\Models\WilayahProvinsi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminSeeder::class,
            AsuransiSeeder::class,
            MasterBankSeeder::class,
            JenisPinjamanSeeder::class,
            WilayahProvinsiSeeder::class,
            WilayahKabupatenSeeder::class,
            WilayahKecamatanSeeder::class,
            KantorCabangSeeder::class,
        ]);
    }
}
