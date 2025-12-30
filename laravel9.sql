-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 05:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel9`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `pesanan_id`, `produk_id`, `jumlah`, `harga_satuan`, `created_at`, `updated_at`) VALUES
(5, 3, 8, 2, 4000, '2024-04-03 21:13:16', '2024-04-03 21:13:16'),
(6, 3, 9, 1, 8000, '2024-04-03 21:13:16', '2024-04-03 21:13:16'),
(7, 4, 10, 1, 4500, '2025-05-04 03:43:11', '2025-05-04 03:43:11'),
(9, 6, 9, 1, 8000, '2025-05-05 09:06:37', '2025-05-05 09:06:37'),
(10, 6, 14, 1, 5000, '2025-05-05 09:06:37', '2025-05-05 09:06:37'),
(11, 7, 10, 1, 4500, '2025-06-16 19:15:32', '2025-06-16 19:15:32');

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
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id`, `user_id`, `produk_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(14, 9, 9, 1, '2025-05-08 19:56:16', '2025-05-08 19:56:16'),
(17, 10, 8, 6, '2025-06-16 19:40:55', '2025-06-16 19:47:50');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_04_30_224944_create_siswa_table', 1),
(6, '2025_05_01_023312_add_foto_to_siswa_table', 2),
(7, '2025_05_02_010553_create_products_table', 3),
(12, '2025_05_02_235556_add_role_to_users_table', 4),
(13, '2025_05_03_030839_add_keranjang', 4),
(14, '2025_05_03_030915_add_pesanan', 4),
(15, '2025_05_03_030955_add_detail_pesanan', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `alamat_pengiriman` varchar(255) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `status` enum('menunggu','diproses','ditolak','dikirim','selesai') NOT NULL DEFAULT 'menunggu',
  `total_harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `alamat_pengiriman`, `metode_pembayaran`, `status`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 2, 'Jl. Setia', 'COD', 'selesai', 6000, '2025-05-03 18:13:55', '2025-05-03 18:45:33'),
(2, 2, 'Jl. inaja', 'COD', 'selesai', 19000, '2025-05-03 18:22:16', '2024-04-03 21:15:56'),
(3, 2, 'JJAJ', 'Transfer', 'selesai', 22000, '2024-04-03 21:13:16', '2024-04-03 21:16:50'),
(4, 8, 'Jl. Santai', 'COD', 'diproses', 4500, '2025-05-04 03:43:11', '2025-05-04 03:43:11'),
(5, 8, 'Jl. Santai', 'Transfer', 'diproses', 7000, '2025-05-04 03:49:25', '2025-05-04 03:49:25'),
(6, 9, 'jln maribaya', 'COD', 'diproses', 13000, '2025-05-05 09:06:37', '2025-05-05 09:06:37'),
(7, 10, 'jl.cikutra', 'cod', 'diproses', 4500, '2025-06-16 19:15:32', '2025-06-16 19:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` enum('sayur','rempah','buah') NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `harga`, `stok`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(8, 'Kangkung Organik', 'sayur', 4000, 14, 'Kangkung Organik berkualitas tinggi dan segar.', '1746166522.jpg', '2025-05-01 21:10:51', '2024-04-03 21:13:16'),
(9, 'Brokoli Hijau', 'sayur', 8000, 40, 'Brokoli Hijau berkualitas tinggi dan segar.', '1746170213.jpg', '2025-05-01 21:10:51', '2025-05-05 09:06:37'),
(10, 'Selada Hijau', 'sayur', 4500, 14, 'Selada Hijau berkualitas tinggi dan segar.', '1746231550.jpg', '2025-05-01 21:10:51', '2025-06-16 19:15:32'),
(12, 'Kol Putih', 'sayur', 5500, 37, 'Kol Putih berkualitas tinggi dan segar.', 'kol-putih.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(14, 'Terong Ungu', 'sayur', 5000, 82, 'Terong Ungu berkualitas tinggi dan segar.', 'terong-ungu.jpg', '2025-05-01 21:10:51', '2025-05-05 09:06:37'),
(15, 'Apel Fuji', 'buah', 10000, 87, 'Apel Fuji berkualitas tinggi dan segar.', 'apel-fuji.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(16, 'Jeruk Sunkist', 'buah', 9500, 18, 'Jeruk Sunkist berkualitas tinggi dan segar.', 'jeruk-sunkist.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(17, 'Pisang Raja', 'buah', 7000, 38, 'Pisang Raja berkualitas tinggi dan segar.', 'pisang-raja.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(18, 'Anggur Merah', 'buah', 12000, 14, 'Anggur Merah berkualitas tinggi dan segar.', 'anggur-merah.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(19, 'Semangka Segar', 'buah', 15000, 30, 'Semangka Segar berkualitas tinggi dan segar.', 'semangka-segar.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(20, 'Melon Hijau', 'buah', 13000, 76, 'Melon Hijau berkualitas tinggi dan segar.', 'melon-hijau.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(21, 'Mangga Harum', 'buah', 11000, 77, 'Mangga Harum berkualitas tinggi dan segar.', 'mangga-harum.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51'),
(22, 'Nanas Manis', 'buah', 9000, 88, 'Nanas Manis berkualitas tinggi dan segar.', 'nanas-manis.jpg', '2025-05-01 21:10:51', '2025-05-01 21:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `nama` varchar(255) NOT NULL,
  `nomor_induk` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`nama`, `nomor_induk`, `alamat`, `created_at`, `updated_at`, `foto`) VALUES
('Jadil', 100, 'jsiakj', '2025-04-30 17:44:04', '2025-04-30 17:44:04', ''),
('Geegoin', 987, 'jhadsads', '2025-04-30 17:48:13', '2025-04-30 17:48:13', ''),
('Aji', 1000, 'Bandung', '2025-04-30 16:01:06', NULL, ''),
('Agus', 1003, 'Bandung', '2025-04-30 16:01:06', '2025-04-30 20:36:19', '250501033619.png'),
('Toni Paat', 123123, 'Jl.an', '2025-04-30 20:35:22', '2025-04-30 20:36:01', '250501033601.png');

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
  `role` varchar(255) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(2, 'aji', 'aji@fresh.com', NULL, '$2y$10$GcWx70Zdm8GSY.B/CLQoo.oyjJpW1rbFBo9smrNYv4I/jRcH11KGu', NULL, NULL, NULL, 'customer'),
(3, 'Aji', 'ji@fresh.com', NULL, '$2y$10$x8QaTFsDc0eTD/8HslvpGeBoX99MssSq4OIjvxzl.eVDKZ9qVdda6', NULL, '2025-04-30 23:21:44', '2025-04-30 23:21:44', 'customer'),
(4, 'Heiya', 'heiya@fresh.com', NULL, '$2y$10$g7zOClYlrSQUx07D.HvcTuDspu0vmsRZNyFB09F08YO4Mq.NLN3A6', NULL, '2025-04-30 23:58:16', '2025-04-30 23:58:16', 'customer'),
(5, 'ajiijjia', 'aidhsai@asa', NULL, '$2y$10$43uPvh17AjzYWyhCyQpTe.6V10huzZZZA5lpMrNCAWksqXRp/WbEW', NULL, '2025-05-02 08:54:51', '2025-05-02 08:54:51', 'customer'),
(6, 'Yumi', 'yum@fresh.com', NULL, '$2y$10$bVAEM8MX/2CAhPSMMjpHx.64wRUHoEUFe/v1CzxM/IGkSesebSP.C', NULL, '2025-05-02 10:12:20', '2025-05-02 10:12:20', 'customer'),
(7, 'Yumi', 'Yumi@fresh.com', NULL, '$2y$10$tbMP3315KuweVlcMokWyw.qn4Am6uZBozfIWHc2KpUMR6fmBwm89y', NULL, NULL, NULL, 'admin'),
(8, 'Yumilia', 'yumilia@fresh.com', NULL, '$2y$10$rG2WjVeFHQ.GSLFsswTyjOrZXY6XAHO/oBRl8Yiszav2p8AhWE9ia', NULL, '2025-05-04 00:03:57', '2025-05-04 00:03:57', 'customer'),
(9, 'luky', 'luky@fresh.id', NULL, '$2y$10$3we1IEf6NCV9oPuih5IO4ul0uFPS26KlJTabwCmBzu83I.6wbcDOa', NULL, '2025-05-05 08:58:08', '2025-05-05 08:58:08', 'customer'),
(10, 'ayum', 'ayum@gmail.com', NULL, '$2y$10$Zv8ipP0ILnKAH3nYS3CHke2Mp1Z2spJKUYN3Yf4WRlOfRlwB.S2hO', NULL, '2025-06-16 18:54:28', '2025-06-16 18:54:28', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pesanan_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `detail_pesanan_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjang_user_id_foreign` (`user_id`),
  ADD KEY `keranjang_produk_id_foreign` (`produk_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_user_id_foreign` (`user_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD UNIQUE KEY `siswa_nomor_induk_unique` (`nomor_induk`);

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
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
