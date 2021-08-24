-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2021 at 11:06 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_umkm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kantor_cabang`
--

CREATE TABLE `kantor_cabang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_area` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `fax` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kantor_cabang`
--

INSERT INTO `kantor_cabang` (`id`, `kode_area`, `nama`, `jenis`, `kecamatan_id`, `alamat`, `phone`, `fax`, `created_at`, `updated_at`) VALUES
(1, '031', 'Surabaya', 'Pusat', '3578110', 'Jl. Ciliwung No. 11, Surabaya', '5677844, 5688542-45', '5661099', '2021-08-24 07:46:39', '2021-08-24 08:02:50'),
(2, '0324', 'Pamekasan', 'Cabang', '3528020', 'Jl. Jokotole No. 114, Pamekasan', '334726', '334725', '2021-08-24 08:07:56', '2021-08-24 08:07:56'),
(3, '031', 'Bangkalan', 'Cabang', '3526110', 'Jl. Teuku Umar No. 33 A,  Bangkalan', '3099760', '3061490', '2021-08-24 08:09:20', '2021-08-24 08:09:20'),
(4, '0333', 'Banyuwangi', 'Cabang', '3510180', 'Jl. Letkol Istiqlah No. 9, Banyuwangi', '411585', '421061', '2021-08-24 08:11:12', '2021-08-24 08:11:12'),
(5, '0334', 'Lumajang', 'Cabang', '3508060', 'Jl. Veteran No. 18 B,  Lumajang', '894101', '890400', '2021-08-24 08:12:25', '2021-08-24 08:12:25'),
(6, '0335', 'Probolinggo', 'Cabang', '3574031', 'Jl. KH. Hasan Genggong No. 244, Kebonsari Wetan, Kec. Kanigaran, Probolinggo', '432774', '436484', '2021-08-24 08:13:30', '2021-08-24 08:13:30'),
(7, '0343', 'Pasuruan', 'Cabang', '3575020', 'Jl. KH. Ahmad Dahlan No. 10,  Pasuruan', '431530', '417600', '2021-08-24 08:40:02', '2021-08-24 08:40:02'),
(8, '0341', 'Malang', 'Cabang', '3573040', 'Jl. R. Tumenggung Suryo No. 35 Kav. 7,  Malang', '419325', '405818', '2021-08-24 08:40:49', '2021-08-24 08:40:49'),
(9, '0351', 'Ngawi', 'Cabang', '3521110', 'Jl. S. Parman No. 8, Ngawi', '749778', '749419', '2021-08-24 08:41:36', '2021-08-24 08:41:36'),
(10, '0342', 'Blitar', 'Cabang', '3572030', 'Jl. Kalimantan No. 59, Sananwetan - Blitar', '816369', '816866', '2021-08-24 08:42:24', '2021-08-24 08:42:24'),
(11, '0354', 'Kediri', 'Cabang', '3571030', 'Jl. Kilisuci No. 81 C-D, RT. 28 / RW. 6, Kel. Singonegaran, Kec. Pesantren - Kediri', '2892410', '2893413', '2021-08-24 08:43:09', '2021-08-24 08:43:09'),
(12, '0321', 'Mojokerto', 'Cabang', '3576010', 'Jl. Majapahit No. 381, Prajurit Kulon - Mojokerto', '396422', '323228', '2021-08-24 08:44:12', '2021-08-24 08:44:12'),
(13, '0321', 'Jombang', 'Cabang', '3517180', 'Jl. Dr. Sutomo No. 7 Ploso, Jombang', '855056', '855057', '2021-08-24 08:48:10', '2021-08-24 08:48:10'),
(14, '0358', 'Nganjuk', 'Cabang', '3518140', 'Jl. Merdeka 2 Kav. 2 B, Kec. Nganjuk, Kab. Nganjuk', '323152', '325665', '2021-08-24 08:48:57', '2021-08-24 08:48:57'),
(15, '0351', 'Madiun', 'Cabang', '3577030', 'Jl. Parikesit No. 6, Madiun', '481197', '481196', '2021-08-24 08:49:45', '2021-08-24 08:49:45'),
(16, '0355', 'Tulungagung', 'Cabang', '3504110', 'Jl. Ki Mangun Sarkoro Vila Satwika No. A 1', '328436', '333354', '2021-08-24 08:51:29', '2021-08-24 08:51:29'),
(17, '0355', 'Trenggalek', 'Cabang', '3503110', 'JL. Jaksa Agung Suprapto No. 17, Trenggalek', '792831', '796695', '2021-08-24 08:52:27', '2021-08-24 08:52:27'),
(18, '0352', 'Ponorogo', 'Cabang', '3502170', 'JL. MH. Thamrin No. 51, Ponorogo', '487475', '484063', '2021-08-24 08:53:14', '2021-08-24 08:53:14'),
(19, '031', 'Gresik', 'Cabang', '3525100', 'Jl. Jaksa Agung Suprapto No. 8,  Gresik', '3982985', '3982983', '2021-08-24 08:54:09', '2021-08-24 08:54:09'),
(20, '0322', 'Lamongan', 'Cabang', '3524130', 'Jl. Wahidin Sudiro Husodo No. 96, Banjar Mendalan - Lamongan', '324920', '318921', '2021-08-24 08:54:50', '2021-08-24 08:54:50'),
(21, '0351', 'Magetan', 'Cabang', '3520040', 'Jl. Raya Gorang - gareng, Maospati, Magetan', '439960', '438407', '2021-08-24 08:56:16', '2021-08-24 08:56:16'),
(22, '0357', 'Pacitan', 'Cabang', '3501040', 'Jl. Tentara Pelajar No. 165,  Pacitan', '886042', '886043', '2021-08-24 08:56:59', '2021-08-24 08:56:59'),
(23, '031', 'Sidoarjo', 'Cabang', '3515070', 'Jl. Raya Gelam No. 49, Kec. Candi - Sidoarjo', '8923886', '8062076', '2021-08-24 08:57:34', '2021-08-24 08:57:34'),
(24, '0331', 'Jember', 'Cabang', '3509210', 'Jl. Darmawangsa Ruko Graha Wijaya Kav. 14, Kec. Sukorambi - Jember', '484200', '410083', '2021-08-24 08:58:21', '2021-08-24 08:58:21'),
(25, '0356', 'Tuban', 'Cabang', '3523130', 'Jl. Pramuka No. 10 A,  Tuban', '323331', '320110', '2021-08-24 08:59:43', '2021-08-24 08:59:43'),
(26, '0341', 'Batu', 'Cabang', '3579010', 'Jl. A Yani nomor 4, Kel. Ngaglik, Kec. Batu, Kota Batu', '594414', '594415', '2021-08-24 09:00:19', '2021-08-24 09:00:19'),
(27, '0338', 'Situbondo', 'Cabang', '3512100', 'Jl. Wijaya Kusuma 82 A RT.04 RW.01 Des/Kel. Dawuhan Kec/Kab. Situbondo.', '678810', '674225', '2021-08-24 09:01:09', '2021-08-24 09:01:09'),
(28, '0353', 'Bojonegoro', 'Cabang', '3522160', 'Jl. Teuku Umar No. 30, Bojonegoro', '311122', '311500', '2021-08-24 09:01:52', '2021-08-24 09:01:52'),
(29, '0332', 'Bondowoso', 'Cabang', '3511100', 'Jl. Kyai Haji Wahid Hasyim Nomor 168, Ruko Crown Plaza Kavling 3 Bondowoso, Kab. Bondowoso', '420430', '420431', '2021-08-24 09:02:35', '2021-08-24 09:02:35'),
(30, '0328', 'Sumenep', 'Cabang', '3529070', 'Jl. Trunojoyo, Desa Kolor, Kec Kota Sumenep, Kab. Sumenep (Komplek Ruko Arya Wiraraja)', '664642', '664643', '2021-08-24 09:04:24', '2021-08-24 09:04:24'),
(31, '0341', 'Kepanjen', 'Cabang', '3507160', 'Jl. Kawi, Kec. Kepanjen, Kab. Malang (Ruko Kepanjen City)', '394466', '398815', '2021-08-24 09:05:33', '2021-08-24 09:05:33'),
(32, '0323', 'Sampang', 'Cabang', '3527030', 'Jl. Rajawali No. 48, Kel. Karangdalem, Kec. Sampang, Kab. Sampang', '325228', '325229', '2021-08-24 09:06:11', '2021-08-24 09:06:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kantor_cabang`
--
ALTER TABLE `kantor_cabang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kantor_cabang_kecamatan_id_foreign` (`kecamatan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kantor_cabang`
--
ALTER TABLE `kantor_cabang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kantor_cabang`
--
ALTER TABLE `kantor_cabang`
  ADD CONSTRAINT `kantor_cabang_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `wilayah_kecamatan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
