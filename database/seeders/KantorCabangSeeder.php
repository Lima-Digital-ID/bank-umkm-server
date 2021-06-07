<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantorCabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared("INSERT INTO `kantor_cabang` (`nama`, `kecamatan_id`, `alamat`, `phone`) VALUES
            ('BANK UMKM Jawa Timur', '3507160', 'Jl. Kawi, Banurejo, Kepanjen, Kec. Kepanjen, Malang, Jawa Timur 65163', '(0341) 394466'),
            ('BANK UMKM Jawa Timur', '3578110', 'Jl. Ciliwung No.11, Darmo, Kec. Wonokromo, Kota SBY, Jawa Timur 60241', '(031) 5677844'),
            ('BANK UMKM Jawa Timur', '3508060', 'Jalan Veteran, Kepuharjo, Kecamatan Lumajang, Kepuharjo, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316', '-'),
            ('BANK UMKM Jawa Timur', '3578170', 'Sawahan, Kec. Sawahan, Kota SBY, Jawa Timur 60251', '-'),
            ('BANK UMKM Jawa Timur', '3509210', 'kav, Jl. Dharmawangsa No.14, Darungan, Jubung, Kec. Sukorambi, Kabupaten Jember, Jawa Timur 68151', '-'),
            ('BANK UMKM Jawa Timur', '3507300', 'Jl. Raya Jetis, Jetis, Mulyoagung, Kec. Dau, Malang, Jawa Timur 65151', '(0341) 461961'),
            ('BANK UMKM Jawa Timur', '3512100', 'Jl. Wijaya Kusuma No.82A, RT.04/RW.01, Parse, Dawuhan, Kec. Situbondo, Kabupaten Situbondo, Jawa Timur 68311', '(0338) 678810'),
            ('BANK UMKM Jawa Timur', '3517130', 'Jalan Dokter Sutomo No.7, Kepanjen, Kec. Jombang, Kabupaten Jombang, Jawa Timur 61419', '(0321) 855056'),
            ('BANK UMKM Jawa Timur', '3573040', 'Jl. R. Tumenggung Suryo No.Kav. 7, Bunulrejo, Kec. Blimbing, Kota Malang, Jawa Timur 65123', '(0341) 405818'),
            ('BANK UMKM Jawa Timur', '3578070', 'Jl. Rungkut Alang-Alang No.73, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293', '(031) 8709640'),
            ('BANK UMKM Jawa Timur', '3522160', 'Kadipaten, Sumbang, Kec. Bojonegoro, Kabupaten Bojonegoro, Jawa Timur 62115', '(0353) 311122'),
            ('BANK UMKM Jawa Timur', '3510180', 'Singonegaran, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68415', '-'),
            ('BANK UMKM Jawa Timur', '3574031', 'Jl. KH. Hasan Genggong No.126, Kebonsari Wetan, Kec. Kanigaran, Kota Probolinggo, Jawa Timur 67214', '(0323) 325228'),
            ('BANK UMKM Jawa Timur', '3518140', 'Jl. Merdeka No.2, Mangundikaran, Mangun Dikaran, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur 64419', '(0358) 323152'),
            ('BANK UMKM Jawa Timur', '3504110', 'Jalan Ki Mangun Surkoro, Dusun Krajan, Beji, Kec. Boyolangu, Kabupaten Tulungagung, Jawa Timur 66233', '(0355) 328436'),
            ('BANK UMKM Jawa Timur', '3510070', 'Dusun Kp. Baru, Jajag, Kec. Gambiran, Kabupaten Banyuwangi, Jawa Timur 68486', '(0333) 394037'),
            ('BANK UMKM Jawa Timur', '3528050', 'Jl. Jokotole No. 114, Pademawu, Murleke, Barurambat Tim., Kec. Pamekasan, Kabupaten Pamekasan, Jawa Timur 69317', '(0324) 334726'),
            ('BANK UMKM Jawa Timur', '3524130', 'Jl. Dokter Wahidin Sudiro Husodo No.96, Kendaruan, Banjarmendalan, Kec. Lamongan, Kabupaten Lamongan, Jawa Timur 62212', '(0322) 324920'),
            ('BANK UMKM Jawa Timur', '3525100', 'Jl. Jaksa Agung Suprapto No.8, Tlogobendung, Bedilan, Kec. Gresik, Kabupaten Gresik, Jawa Timur 61111', '(031) 3982985'),
            ('BANK UMKM Jawa Timur', '3571010', 'Jl. Kawi No.4 B, Mojoroto, Kec. Mojoroto, Kediri, Jawa Timur 64112', '(0354) 773093'),
        ");
    }
}
