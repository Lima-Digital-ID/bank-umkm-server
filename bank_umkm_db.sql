-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2021 pada 16.20
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.14

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
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_resets_table', 1),
(6, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2021_04_19_060215_create_peminjam_table', 2),
(14, '2021_04_22_184622_create_pinjaman_table', 3),
(15, '2021_04_25_042002_create_pelunasan_table', 4),
(17, '2021_04_26_053954_create_tipe_nabasah_table', 5),
(18, '2021_04_26_054735_add_tipe_in_table_nasabah', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nasabah`
--

CREATE TABLE `nasabah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `profil` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'profile-default.png',
  `scan_ktp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_dengan_ktp` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_nikah` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_domisili_usaha` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Nonaktif','Aktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Nonaktif',
  `id_tipe` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nasabah`
--

INSERT INTO `nasabah` (`id`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `no_hp`, `alamat`, `profil`, `scan_ktp`, `foto_dengan_ktp`, `npwp`, `surat_nikah`, `surat_domisili_usaha`, `username`, `email`, `password`, `status`, `id_tipe`, `created_at`, `updated_at`) VALUES
(1, 'asdf', '2021-04-19', 'Laki-laki', '234234234r23', '085258987456', 'asdfdasfasfsdf', 'profile-default.png', 'asdfasdf', 'asdfasf', NULL, NULL, NULL, 'aas', 'ass', 'ass', 'Aktif', NULL, NULL, '2021-04-24 20:32:30'),
(2, 'Ujik', '2021-04-07', 'Laki-laki', '3511085408970004', '087757859915', 'Wonosari, Bondowoso, East Java, Indonesia\r\n-', 'profile-default.png', '1619113340_arr dashboard.jpg', '1619113340_buku besar.jpg', '1619113340_kartu piutang.jpg', '1619113340_kartu stock.jpg', '1619113340_laba rugi.jpg', '3511085408970004', 'inant.kharisma@gmail.com', '$2y$10$wg.xWePjEAThE8fBAYESy.jSNElnn9lu2NQLrngtxll58O5F47E36', 'Aktif', NULL, '2021-04-22 10:42:20', '2021-04-22 11:39:36'),
(3, 'asdf', '2021-04-13', 'Perempuan', '3511094504990005', '0823131231', 'asdfdsf', 'profile-default.png', '1619115664_Google_Interland_Inant_Sertifikat_Ketangguhan.pdf', '1619115664_bca-logo-11551049437hjhgtm00se.png', '1619115664_Air Limbah Industri - CV. Anugerah Alam Abadi (Maret 2021).pdf', '1619115664_Analytical Report - CV. Anugerah Alam Abadi (Semester 2).pdf', '1619115664_GQA 18211146 CV Anugerah Alam Abadi - AAQ,ALI,AB,Noise, Mar 21 (Bgr).pdf', '3511094504990005', 'egasf@mail.com', '$2y$10$TRv76rO7GYbCNUEQ6BC0Ne.6oP/mrPqiM95Z.lkJP6Q.G4SweZLo2', 'Aktif', NULL, '2021-04-22 11:21:04', '2021-04-24 20:24:30'),
(4, 'mes', '2021-04-26', 'Perempuan', '3511085408970003', '083454321123', 'Washington', 'profile-default.png', '1619424735_Air Limbah Industri - CV. Anugerah Alam Abadi (Maret 2021).pdf', '1619424735_Air Limbah Industri - CV. Anugerah Alam Abadi (Semester 2).jpg', '1619424735_Air Limbah Industri - CV. Anugerah Alam Abadi (Semester 2).pdf', '1619424735_Analytical Report - CV. Anugerah Alam Abadi (Semester 2).pdf', '1619424735_Analytical Report - CV. Anugerah Alam Abadi (Semester 2)-5.pdf', '3511085408970003', 'me@mail.com', '$2y$10$j99XVq5i09xz0sXwRJPX2uwGCxTVqCz3gIbfETNhOAQIyvwl1YoJK', 'Aktif', 1, '2021-04-26 01:12:15', '2021-04-26 02:43:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelunasan`
--

CREATE TABLE `pelunasan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pinjaman` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `cicilan_ke` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelunasan`
--

INSERT INTO `pelunasan` (`id`, `id_pinjaman`, `tanggal_pembayaran`, `nominal`, `cicilan_ke`, `created_at`, `updated_at`) VALUES
(1, 2, '2021-04-26', 30000, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_nasabah` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `jangka_waktu` tinyint(4) NOT NULL,
  `nominal` int(11) NOT NULL,
  `status` enum('Pending','Terima','Tolak','Lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `tanggal_batas_pelunasan` date DEFAULT NULL,
  `tanggal_lunas` date DEFAULT NULL,
  `terbayar` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `id_nasabah`, `id_user`, `tanggal_pengajuan`, `jangka_waktu`, `nominal`, `status`, `tanggal_diterima`, `tanggal_batas_pelunasan`, `tanggal_lunas`, `terbayar`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, '2021-04-22', 4, 2000000, 'Terima', '2021-04-23', '2021-08-24', NULL, 0, NULL, NULL),
(2, 2, 1, '2021-04-25', 6, 500000, 'Terima', '2021-04-25', '2021-10-25', NULL, 30000, NULL, '2021-04-24 20:56:08'),
(3, 3, 1, '2021-04-24', 12, 4000000, 'Terima', '2021-04-25', '2022-04-25', NULL, 0, NULL, '2021-04-24 21:02:30'),
(4, 2, NULL, '2021-04-23', 8, 3000000, 'Tolak', NULL, NULL, NULL, 0, NULL, '2021-04-24 21:07:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe_nasabah`
--

CREATE TABLE `tipe_nasabah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `limit_pinjaman` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tipe_nasabah`
--

INSERT INTO `tipe_nasabah` (`id`, `tipe`, `limit_pinjaman`, `created_at`, `updated_at`) VALUES
(1, 'Umum', 3000000, '2021-04-26 00:06:18', '2021-04-26 00:19:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@mail.com', NULL, '$2y$10$CpEK9i2n2OJlUvwJBUDNueLkhmbNnhNTkaETeogPHdHKrNh6zPwli', NULL, '2021-04-18 22:03:06', '2021-04-18 22:03:06'),
(2, 'Inant Kharisma', 'inant', 'inant.kharisma@gmail.com', NULL, '$2y$10$uiHYmjix51nMOMRe5nQT1e1zrua3cs4keig1GtpKSpZVl3No9O.YS', NULL, '2021-04-18 22:56:01', '2021-04-18 22:58:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nasabah_id_tipe_foreign` (`id_tipe`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pelunasan`
--
ALTER TABLE `pelunasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelunasan_id_pinjaman_foreign` (`id_pinjaman`);

--
-- Indeks untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjaman_id_nasabah_foreign` (`id_nasabah`),
  ADD KEY `pinjaman_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `tipe_nasabah`
--
ALTER TABLE `tipe_nasabah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelunasan`
--
ALTER TABLE `pelunasan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tipe_nasabah`
--
ALTER TABLE `tipe_nasabah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD CONSTRAINT `nasabah_id_tipe_foreign` FOREIGN KEY (`id_tipe`) REFERENCES `tipe_nasabah` (`id`);

--
-- Ketidakleluasaan untuk tabel `pelunasan`
--
ALTER TABLE `pelunasan`
  ADD CONSTRAINT `pelunasan_id_pinjaman_foreign` FOREIGN KEY (`id_pinjaman`) REFERENCES `pinjaman` (`id`);

--
-- Ketidakleluasaan untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_id_nasabah_foreign` FOREIGN KEY (`id_nasabah`) REFERENCES `nasabah` (`id`),
  ADD CONSTRAINT `pinjaman_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
