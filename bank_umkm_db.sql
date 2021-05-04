-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 04, 2021 at 03:59 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

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
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `informasi_bank`
--

CREATE TABLE `informasi_bank` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nasabah` int(10) UNSIGNED NOT NULL,
  `id_bank` int(10) UNSIGNED NOT NULL,
  `no_rekening` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_rekening` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pinjaman`
--

CREATE TABLE `jenis_pinjaman` (
  `id` int(10) UNSIGNED NOT NULL,
  `jenis_pinjaman` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_pinjaman` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pinjaman`
--

INSERT INTO `jenis_pinjaman` (`id`, `jenis_pinjaman`, `limit_pinjaman`, `created_at`, `updated_at`) VALUES
(1, 'Haji/Umroh', 10000000, '2021-05-02 18:46:24', '2021-05-02 18:46:24'),
(2, 'Dibawah 5jt', 5000000, '2021-05-02 18:46:24', '2021-05-02 18:46:24'),
(3, 'Diatas 5jt', 50000000, '2021-05-02 18:47:12', '2021-05-02 18:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `master_bank`
--

CREATE TABLE `master_bank` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_bank` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_bank` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2021_04_30_221447_create_tipe_nasabah_table', 1),
(11, '2021_04_30_221557_create_master_bank_table', 1),
(12, '2021_04_30_221734_create_nasabah_table', 1),
(13, '2021_04_30_222532_create_informasi_bank_table', 1),
(14, '2021_04_30_223125_create_jenis_pinjaman_table', 1),
(15, '2021_04_30_223801_create_pinjaman_table', 1),
(16, '2021_04_30_225132_create_pelunasan_table', 1),
(17, '2021_04_30_234724_alter_nasabah_table', 1),
(18, '2021_05_02_211848_add_tanggal_pengajuan', 1),
(19, '2021_05_03_230136_add_limit_to_nasabah_table', 2),
(20, '2021_05_03_230641_add_username_to_nasabah_table', 3),
(21, '2021_05_03_202013_add_saldo_and_hutang_nasabah', 4),
(22, '2021_05_03_223912_add_field_view_on_pinjaman', 4),
(23, '2021_05_03_231838_add_limit_pinjaman', 5),
(24, '2021_05_03_233347_add_alasan_penolakan', 5),
(25, '2021_05_03_235147_add_alasan_penolakan_pinjaman', 5);

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scan_ktp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selfie_ktp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_nikah` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_jaminan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_domisili_usaha` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo` int(11) NOT NULL DEFAULT 0,
  `hutang` int(11) NOT NULL DEFAULT 0,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tipe_nasabah` int(10) UNSIGNED DEFAULT NULL,
  `limit_pinjaman` int(11) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `alasan_penolakan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`id`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `no_hp`, `alamat`, `foto_profil`, `scan_ktp`, `selfie_ktp`, `npwp`, `surat_nikah`, `surat_jaminan`, `surat_domisili_usaha`, `saldo`, `hutang`, `email`, `username`, `password`, `id_tipe_nasabah`, `limit_pinjaman`, `is_verified`, `alasan_penolakan`, `token`, `created_at`, `updated_at`) VALUES
(1, 'Diablo', '1991-05-09', 'Laki-laki', '3511182612000001', '85331053300', 'Bondowoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 'diablo@gmail.com', 'diablo', '$2y$10$xiu4iuolcMlkdPHELTbO2ey19mUUaXy4LG0kHrcjbzF2efk4NBOPS', NULL, 2000000, 1, '', NULL, '2021-05-02 19:51:57', '2021-05-02 19:51:57'),
(2, 'Inant Kharisma', NULL, 'Laki-laki', NULL, '081224563321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 'inant', '$2y$10$mL1kpbwYr0huU4EYViLIeeIr0blj500drNWItm4FDHzbu/Rigx9xK', NULL, 5000000, 1, '', NULL, '2021-05-04 00:52:59', '2021-05-04 00:52:59'),
(3, 'Marceline', NULL, 'Laki-laki', NULL, '081224563215', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, 'celine', '$2y$10$YKWAllFBHAgk2.XPeJ.x9u7GgHRy.glttRH1uDykXWhjSXqq9mVKG', NULL, 5000000, 1, '', NULL, '2021-05-04 01:19:01', '2021-05-04 01:19:01'),
(4, 'Amelia Kamila', NULL, 'Laki-laki', NULL, '081224563223', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5000000, 5000000, NULL, 'amelia', '$2y$10$kJlWph.ZgFqlvOPMv6Uhre5os1vj27xtDXHJkkWzWfZW5Xkz9VgLK', NULL, 5000000, 1, '', NULL, '2021-05-04 01:20:13', '2021-05-04 01:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelunasan`
--

CREATE TABLE `pelunasan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pinjaman` int(10) UNSIGNED NOT NULL,
  `nominal_pembayaran` int(11) NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `cicilan_ke` tinyint(4) NOT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelunasan`
--

INSERT INTO `pelunasan` (`id`, `id_pinjaman`, `nominal_pembayaran`, `tanggal_pembayaran`, `cicilan_ke`, `metode_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 1, 200000, '2021-06-01', 1, 'Indomaret', '2021-05-03 15:08:49', '2021-05-03 15:08:49'),
(2, 1, 200000, '2021-07-01', 2, 'Indomaret', '2021-05-03 15:08:49', '2021-05-03 15:08:49'),
(3, 1, 200000, '2021-08-01', 3, 'Alfamart', '2021-05-03 15:09:37', '2021-05-03 15:09:37'),
(4, 3, 41667, '2021-05-04', 1, 'Indomaret', '2021-05-03 21:57:25', '2021-05-03 21:57:25'),
(5, 3, 41667, '2021-05-04', 2, 'Indomaret', '2021-05-03 22:36:43', '2021-05-03 22:36:43'),
(6, 3, 41667, '2021-05-04', 3, 'Alfamart', '2021-05-03 23:45:54', '2021-05-03 23:45:54'),
(7, 3, 41667, '2021-05-04', 4, 'Bank UMKM', '2021-05-04 00:05:58', '2021-05-04 00:05:58'),
(8, 3, 41667, '2021-05-04', 5, 'Bank UMKM', '2021-05-04 00:06:34', '2021-05-04 00:06:34'),
(9, 3, 41667, '2021-05-04', 6, 'Alfamart', '2021-05-04 00:07:11', '2021-05-04 00:07:11'),
(10, 3, 41667, '2021-05-04', 7, 'Indomaret', '2021-05-04 00:08:12', '2021-05-04 00:08:12'),
(11, 3, 41667, '2021-05-04', 8, 'Bank UMKM', '2021-05-04 00:08:59', '2021-05-04 00:08:59'),
(12, 3, 41667, '2021-05-04', 9, 'Alfamart', '2021-05-04 00:10:07', '2021-05-04 00:10:07'),
(13, 3, 41667, '2021-05-04', 10, 'Bank UMKM', '2021-05-04 00:10:24', '2021-05-04 00:10:24'),
(14, 3, 41667, '2021-05-04', 11, 'Alfamart', '2021-05-04 00:10:58', '2021-05-04 00:10:58'),
(15, 4, 833333, '2021-05-04', 1, 'Alfamart', '2021-05-04 00:12:03', '2021-05-04 00:12:03'),
(16, 4, 833333, '2021-05-04', 2, 'Bank UMKM', '2021-05-04 00:12:49', '2021-05-04 00:12:49'),
(17, 4, 833333, '2021-05-04', 3, 'Bank UMKM', '2021-05-04 00:13:08', '2021-05-04 00:13:08'),
(18, 20, 1666667, '2021-05-04', 1, 'Alfamart', '2021-05-04 01:57:24', '2021-05-04 01:57:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Nasabah', 1, 'token', 'a8adf2291224954904f6f97012ad2181247f35b3b41eff52e07eb8e7c7ba0e54', '[\"*\"]', NULL, '2021-05-03 18:07:22', '2021-05-03 18:07:22'),
(2, 'App\\Models\\Nasabah', 1, 'token', '3cbf37edb26717f21f81543eda9c480cc02965a9ef0afffcbd01f95a28e8f190', '[\"*\"]', NULL, '2021-05-03 18:07:39', '2021-05-03 18:07:39'),
(3, 'App\\Models\\Nasabah', 1, 'token', '860f69b8d87c9fecfffd39ee047591b3fbc06d4695f3861a592fbd6e226e6c70', '[\"*\"]', NULL, '2021-05-03 18:07:40', '2021-05-03 18:07:40'),
(4, 'App\\Models\\Nasabah', 1, 'token', 'af7d1b9f117daac45b74adbbbb048a870309e560ef04012e5bd6980217eea3c7', '[\"*\"]', NULL, '2021-05-03 18:07:42', '2021-05-03 18:07:42'),
(5, 'App\\Models\\Nasabah', 1, 'token', '23d8db5ebf4d00f45a34e5766d11e530200cdef1a08a8255766ff2929233cad3', '[\"*\"]', NULL, '2021-05-03 19:25:48', '2021-05-03 19:25:48'),
(6, 'App\\Models\\Nasabah', 1, 'token', '034a3241d075ee167c111c0aaf7c03fa1d21251aa103f2d33187029dbac0f1c7', '[\"*\"]', NULL, '2021-05-03 19:26:59', '2021-05-03 19:26:59'),
(7, 'App\\Models\\Nasabah', 1, 'token', '7f897fec3cdb330ce45376cd9dc66cc82bfcb9c4ace4d34fae524d734677c8bb', '[\"*\"]', NULL, '2021-05-03 19:28:21', '2021-05-03 19:28:21'),
(8, 'App\\Models\\Nasabah', 1, 'token', 'df281d031c90f466664b53656adb10749dc19f9a5c9f159b6267d081ab238955', '[\"*\"]', NULL, '2021-05-03 19:28:44', '2021-05-03 19:28:44'),
(9, 'App\\Models\\Nasabah', 1, 'token', '586d5c0820be044f3d8c66b7193e956fd5e09fc84d3a5c932ce3f2c23b584903', '[\"*\"]', NULL, '2021-05-03 19:28:52', '2021-05-03 19:28:52'),
(10, 'App\\Models\\Nasabah', 1, 'token', '2eef406598ad28fca9d28d4c741b62649281a38fa425d4bd6377fca58460b18c', '[\"*\"]', NULL, '2021-05-03 19:29:26', '2021-05-03 19:29:26'),
(12, 'App\\Models\\Nasabah', 1, 'token', '62e714a5b536c19cb5e84dd8c1753bc5ec437769efba2a8a90a7584749f84c9c', '[\"*\"]', '2021-05-04 00:13:08', '2021-05-03 19:54:01', '2021-05-04 00:13:08'),
(13, 'App\\Models\\Nasabah', 3, 'token', 'a809fdffc8d0767757acd73c2cc65f24a35754ee41d95e4ac4a62b46e9bf2e27', '[\"*\"]', NULL, '2021-05-04 01:23:30', '2021-05-04 01:23:30'),
(14, 'App\\Models\\Nasabah', 3, 'token', '981a30a4fc14be51011034bb5f9e954e70bc65dcb94613e12bc10e92aca9f270', '[\"*\"]', NULL, '2021-05-04 01:24:58', '2021-05-04 01:24:58'),
(15, 'App\\Models\\Nasabah', 3, 'token', '0c8f2d33ed2ded7a826221dea0ed443dd8babdd7ab40f61e6d04ec136afbca6f', '[\"*\"]', NULL, '2021-05-04 01:25:49', '2021-05-04 01:25:49'),
(16, 'App\\Models\\Nasabah', 3, 'token', 'a58da74738d90c0f2e029e7056fa0751832d70607925f3c22f2e59de25f57120', '[\"*\"]', NULL, '2021-05-04 01:26:35', '2021-05-04 01:26:35'),
(17, 'App\\Models\\Nasabah', 3, 'token', '773ff78bdc89eee51994b6b2f3be57165a6684a4e3b92e88c1d64d110c25e0cb', '[\"*\"]', NULL, '2021-05-04 01:27:37', '2021-05-04 01:27:37'),
(18, 'App\\Models\\Nasabah', 2, 'token', 'd0a718581a283fc223c9889dbe47640825b25532cf7345053258ead0ffc40311', '[\"*\"]', NULL, '2021-05-04 01:28:57', '2021-05-04 01:28:57'),
(21, 'App\\Models\\Nasabah', 4, 'token', 'd49c20d76efb06c33eb82781ec418a7f8107351645a30de84fa1b4b0aafc8afe', '[\"*\"]', '2021-05-04 01:57:39', '2021-05-04 01:41:32', '2021-05-04 01:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_nasabah` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `id_jenis_pinjaman` int(10) UNSIGNED NOT NULL,
  `nominal` int(11) NOT NULL,
  `jangka_waktu` tinyint(4) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status` enum('Pending','Terima','Tolak','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_penolakan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `tanggal_lunas` date DEFAULT NULL,
  `terbayar` int(11) DEFAULT 0,
  `view` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `id_nasabah`, `id_user`, `id_jenis_pinjaman`, `nominal`, `jangka_waktu`, `tanggal_pengajuan`, `status`, `alasan_penolakan`, `tanggal_diterima`, `jatuh_tempo`, `tanggal_lunas`, `terbayar`, `view`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, 600000, 3, '2021-05-03', 'Lunas', '', '2021-05-05', '2021-08-05', '2021-08-04', 1, '0', '2021-05-02 20:07:40', '2021-05-02 20:07:40'),
(2, 1, NULL, 2, 1000000, 6, '2021-05-03', 'Tolak', '', NULL, NULL, NULL, 0, '0', '2021-05-03 13:52:52', '2021-05-03 13:52:52'),
(3, 1, NULL, 1, 500000, 12, '2021-05-03', 'Terima', '', '2021-05-05', '2022-05-05', NULL, 0, '0', '2021-05-03 13:57:03', '2021-05-03 13:57:03'),
(4, 1, NULL, 3, 5000000, 6, '2021-05-03', 'Terima', '', '2021-05-10', '2021-11-10', NULL, 0, '0', '2021-05-03 14:49:25', '2021-05-03 14:49:25'),
(5, 1, NULL, 3, 5000000, 6, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 14:50:47', '2021-05-03 14:50:47'),
(6, 1, NULL, 3, 8000000, 3, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 14:51:12', '2021-05-03 14:51:12'),
(7, 1, NULL, 1, 5500000, 3, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 14:53:29', '2021-05-03 14:53:29'),
(8, 1, NULL, 3, 5500000, 12, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 14:55:09', '2021-05-03 14:55:09'),
(9, 1, NULL, 2, 3000000, 6, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 14:59:03', '2021-05-03 14:59:03'),
(10, 1, NULL, 3, 8000000, 12, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 15:00:53', '2021-05-03 15:00:53'),
(11, 1, NULL, 2, 2500000, 3, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 15:05:42', '2021-05-03 15:05:42'),
(12, 1, NULL, 2, 2000000, 6, '2021-05-03', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 15:57:30', '2021-05-03 15:57:30'),
(13, 1, NULL, 2, 1000000, 6, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 17:03:43', '2021-05-03 17:03:43'),
(14, 1, NULL, 2, 1000000, 6, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 17:57:10', '2021-05-03 17:57:10'),
(15, 1, NULL, 2, 2000000, 3, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 17:57:43', '2021-05-03 17:57:43'),
(16, 1, NULL, 2, 1500000, 12, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 18:01:14', '2021-05-03 18:01:14'),
(17, 1, NULL, 2, 1000000, 3, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 19:35:33', '2021-05-03 19:35:33'),
(18, 1, NULL, 2, 500000, 3, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 19:41:50', '2021-05-03 19:41:50'),
(19, 1, NULL, 2, 1500000, 3, '2021-05-04', 'Pending', '', NULL, NULL, NULL, 0, '0', '2021-05-03 19:44:02', '2021-05-03 19:44:02'),
(20, 4, 1, 2, 5000000, 3, '2021-05-04', 'Terima', '-', '2021-05-04', NULL, NULL, 0, '0', '2021-05-04 01:45:12', '2021-05-04 01:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_nasabah`
--

CREATE TABLE `tipe_nasabah` (
  `id` int(10) UNSIGNED NOT NULL,
  `tipe` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@mail.com', NULL, '$2y$10$09USt79sGpuqyyTkpArceuCtIsp0AeH39i1byB0D3rRewK6pL2VSu', NULL, '2021-05-02 18:44:30', '2021-05-02 18:44:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `informasi_bank`
--
ALTER TABLE `informasi_bank`
  ADD PRIMARY KEY (`id`),
  ADD KEY `informasi_bank_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `informasi_bank_id_bank_foreign` (`id_bank`);

--
-- Indexes for table `jenis_pinjaman`
--
ALTER TABLE `jenis_pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_bank`
--
ALTER TABLE `master_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nasabah_email_unique` (`email`),
  ADD KEY `nasabah_id_tipe_nasabah_foreign` (`id_tipe_nasabah`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelunasan`
--
ALTER TABLE `pelunasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelunasan_id_pinjaman_foreign` (`id_pinjaman`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjaman_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `pinjaman_id_user_foreign` (`id_user`),
  ADD KEY `pinjaman_id_jenis_pinjaman_foreign` (`id_jenis_pinjaman`);

--
-- Indexes for table `tipe_nasabah`
--
ALTER TABLE `tipe_nasabah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `informasi_bank`
--
ALTER TABLE `informasi_bank`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pinjaman`
--
ALTER TABLE `jenis_pinjaman`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_bank`
--
ALTER TABLE `master_bank`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelunasan`
--
ALTER TABLE `pelunasan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tipe_nasabah`
--
ALTER TABLE `tipe_nasabah`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `informasi_bank`
--
ALTER TABLE `informasi_bank`
  ADD CONSTRAINT `informasi_bank_id_bank_foreign` FOREIGN KEY (`id_bank`) REFERENCES `master_bank` (`id`),
  ADD CONSTRAINT `informasi_bank_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id`);

--
-- Constraints for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_id_tipe_nasabah_foreign` FOREIGN KEY (`id_tipe_nasabah`) REFERENCES `tipe_nasabah` (`id`);

--
-- Constraints for table `pelunasan`
--
ALTER TABLE `pelunasan`
  ADD CONSTRAINT `pelunasan_id_pinjaman_foreign` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id`);

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_id_jenis_pinjaman_foreign` FOREIGN KEY (`id_jenis_pinjaman`) REFERENCES `jenis_pinjaman` (`id`),
  ADD CONSTRAINT `pinjaman_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id`),
  ADD CONSTRAINT `pinjaman_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
