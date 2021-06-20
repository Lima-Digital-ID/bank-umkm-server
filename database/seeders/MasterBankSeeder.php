<?php

namespace Database\Seeders;

use App\Models\MasterBank;
use Illuminate\Database\Seeder;

class MasterBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank BCA';
        $newBank->kode_bank = '014';
        $newBank->save();
        
        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank Mandiri';
        $newBank->kode_bank = '008';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank BNI';
        $newBank->kode_bank = '009';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank BNI Syariah';
        $newBank->kode_bank = '427';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank BRI';
        $newBank->kode_bank = '002';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank Syariah Mandiri';
        $newBank->kode_bank = '451';
        $newBank->save();
        
        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank CIMB Niaga';
        $newBank->kode_bank = '022';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank CIMB Niaga Syariah';
        $newBank->kode_bank = '022';
        $newBank->save();

        $newBank = new MasterBank;
        $newBank->nama_bank = 'Bank Jatim';
        $newBank->kode_bank = '114';
        $newBank->save();
    }
}
