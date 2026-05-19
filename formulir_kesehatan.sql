-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 01:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formulir_kesehatan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@admin.com|127.0.0.1', 'i:1;', 1777200142),
('laravel-cache-admin@admin.com|127.0.0.1:timer', 'i:1777200141;', 1777200142);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_25_134345_create_pemeriksaan_kesehatans_table', 2),
(5, '2026_04_26_000000_add_bukti_pembayaran_to_pemeriksaan_kesehatans_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan_kesehatans`
--

CREATE TABLE `pemeriksaan_kesehatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `usia` int(11) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `tempat_tanggal_lahir` varchar(255) NOT NULL,
  `disabilitas` varchar(255) NOT NULL DEFAULT 'Tidak Ada',
  `tinggi_badan` decimal(5,2) NOT NULL,
  `berat_badan` decimal(5,2) NOT NULL,
  `imt` decimal(4,2) NOT NULL,
  `riwayat_sakit` varchar(255) DEFAULT NULL,
  `keluhan` text DEFAULT NULL,
  `status_pembayaran` varchar(255) NOT NULL DEFAULT 'pending',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemeriksaan_kesehatans`
--

INSERT INTO `pemeriksaan_kesehatans` (`id`, `user_id`, `nik`, `name`, `nim`, `jenis_kelamin`, `usia`, `fakultas`, `prodi`, `tempat_tanggal_lahir`, `disabilitas`, `tinggi_badan`, `berat_badan`, `imt`, `riwayat_sakit`, `keluhan`, `status_pembayaran`, `bukti_pembayaran`, `created_at`, `updated_at`) VALUES
(5, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'tidak ada keluhan', 'pending', NULL, '2026-04-25 07:09:34', '2026-04-25 07:09:34'),
(6, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 19:31:47', '2026-04-25 19:31:47'),
(7, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 20:26:18', '2026-04-25 20:26:18'),
(8, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 20:30:14', '2026-04-25 20:30:14'),
(9, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 20:32:55', '2026-04-25 20:32:55'),
(10, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 20:35:10', '2026-04-25 20:35:10'),
(11, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'pending', NULL, '2026-04-25 20:35:25', '2026-04-25 20:35:25'),
(12, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'hjkbnlkj', 'menunggu_verifikasi', 'bukti_pembayaran/KmA0Er8sAVzIYcDJmjL3eVKqjG6VBW5gkkPKxG4x.jpg', '2026-04-25 20:36:15', '2026-04-25 20:36:22'),
(13, 2, '1111', 'Fajar Mahasiswa', '1111', 'laki-laki', 11, 'FIP', 'S1 Bimbingan dan Konseling', 'malang, 20 april 2020', 'Tidak Ada', 170.00, 80.00, 27.70, 'tidak ada riwayat sakit', 'asd', 'pending', NULL, '2026-04-26 04:50:05', '2026-04-26 04:50:05');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gzMSFjsbvMsh8fHwsZwCHxwHqZGxL8ma0Tn151H0', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoianp2R0RWMDhxQVROeUFjT21yY0RjNFFTdmgybFhSTE5XOTlmUFVLcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9mb3JtdWxpciI7czo1OiJyb3V0ZSI7czo4OiJmb3JtdWxpciI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1777126174),
('ONuCkiHvmGDIfMGsYEJokkAdOt6tXH1gxifBdNVh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHVBMmN3alJxaXNiQzRIQzlBYmtxbklaM1ZlUDU2UEw5WHlBd2hGciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777201227),
('UjAVSgWwpyVoQrMG3xgJgn4HcLFq7TmjBqpkETWG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGZSenFSRzdScDhQUDVPOFRvNlVDcVFtVjk3TFN4UjI2d1FEbFFQeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fX0=', 1777179027);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Administrator Utama', 'admin@mail.com', NULL, '$2y$12$zojWG32F2Gf.3Cw9LRr5OObw2FiZdYiGumT73AlRkYFGoCgyy3PQ2', NULL, '2026-04-24 23:46:53', '2026-04-24 23:46:53', 'admin'),
(2, 'Fajar Mahasiswa', 'mahasiswa@mail.com', NULL, '$2y$12$eHC4lxXbxnx7WxAMlJyujO94O7LCFo6RMz7LQY4YEtaXxTVX0DO7i', NULL, '2026-04-24 23:46:53', '2026-04-24 23:46:53', 'mahasiswa'),
(3, 'Puji Astuti', 'puji@email.com', NULL, '$2y$12$PsK1DoBFLl9OQDiAFCFWb.W4p3zpFEkgnMe5HfNz5n32SXayZHQ7e', NULL, '2026-04-24 23:48:29', '2026-04-24 23:48:29', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemeriksaan_kesehatans`
--
ALTER TABLE `pemeriksaan_kesehatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaan_kesehatans_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pemeriksaan_kesehatans`
--
ALTER TABLE `pemeriksaan_kesehatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemeriksaan_kesehatans`
--
ALTER TABLE `pemeriksaan_kesehatans`
  ADD CONSTRAINT `pemeriksaan_kesehatans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
