-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Feb 2023 pada 07.38
-- Versi server: 5.7.33
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cost`
--

CREATE TABLE `cost` (
  `id` int(5) NOT NULL,
  `cost` varchar(10) DEFAULT NULL,
  `customer_code` int(10) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `active` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cost`
--

INSERT INTO `cost` (`id`, `cost`, `customer_code`, `area`, `active`) VALUES
(1, '10003', 100002, 'dsfdsfdfdsf', 1),
(2, '9001', 100001, 'HSM (Hot Streep Mill)', 1),
(3, '9002', 100001, 'CRM (Control Rolling Mill)', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(5) NOT NULL,
  `customer_code` int(10) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `alamat` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `active` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `customer_code`, `customer`, `alamat`, `created_at`, `updated_at`, `active`) VALUES
(1, 100001, 'PT Krakatau Steel', 'Gedung Krakatau IT, Jl. Raya Anyer Km 3, Cilegon, Banten, 42441', NULL, NULL, 1),
(2, 100002, 'PT Krakatau Posco', 'Gedung Krakatau IT, Jl. Raya Anyer Km 3, Cilegon, Banten, 42441', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `employe`
--

CREATE TABLE `employe` (
  `id` int(10) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `jabatan_id` int(5) DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL,
  `active` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `employe`
--

INSERT INTO `employe` (`id`, `nama`, `nik`, `jabatan_id`, `role_id`, `active`) VALUES
(1, 'Exmpe 12', '100001', 1, 1, 1),
(2, 'Exmpe 2', '100002', 2, 3, 1),
(3, 'Exmpe 3', '100003', 3, 4, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(5) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id`, `jabatan`) VALUES
(1, 'Direktur'),
(2, 'Manager'),
(3, 'Superintendent'),
(4, 'Supervisor'),
(5, 'Operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token_device` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`, `token_device`, `active_status`) VALUES
(1, 'App\\Models\\User', 2, 'MyApp', 'a4f090c1537cf4c5b55d64422013fa7797bdd3d2987b5bcfc5e47973ee8c80c7', '[\"*\"]', NULL, '2022-10-30 19:02:20', '2022-10-30 19:02:20', NULL, NULL),
(2, 'App\\Models\\User', 2, 'MyApp', '6df1d183430c4ec77211d1bee436456f26a54d3d2e5e50ecfea7b1a53ee21972', '[\"*\"]', NULL, '2022-10-30 19:03:37', '2022-10-30 19:03:37', NULL, NULL),
(3, 'App\\Models\\User', 1, 'MyApp', '736c40f0636359c0ef06f9e414973c62c66a9e2d7d93d8bbb951aaa5f41618d8', '[\"*\"]', NULL, '2022-10-30 19:14:00', '2022-10-30 19:14:00', NULL, NULL),
(4, 'App\\Models\\User', 2, 'MyApp', '022a6d454de6f0239bb9567498c76fb5e7be9389c30fc6df706a1d823bd07911', '[\"*\"]', NULL, '2022-10-30 19:14:21', '2022-10-30 19:14:21', NULL, NULL),
(5, 'App\\Models\\User', 2, 'MyApp', '2c65dda38771f2ed68efdb93bbbaab32eddcba6a9ef0815a6526aa74bfa2337a', '[\"*\"]', NULL, '2022-10-30 19:15:35', '2022-10-30 19:15:35', NULL, NULL),
(6, 'App\\Models\\User', 2, 'MyApp', '13750d4e69c58eb7734c436a9e2526236c600910ff358c9f26da9745acce076c', '[\"*\"]', NULL, '2022-10-30 19:16:47', '2022-10-30 19:16:47', NULL, NULL),
(7, 'App\\Models\\User', 2, 'MyApp', '7737abbaaf36ba3aa2278078ebe8987e123a92faa88827949407c66e4302b40e', '[\"*\"]', NULL, '2022-10-30 19:20:04', '2022-10-30 19:20:04', NULL, NULL),
(8, 'App\\Models\\User', 2, 'MyApp', '79c420e8a27c1b9e313158c4eef730b2d288251c83302c680887e1d759dc7c09', '[\"*\"]', '2022-11-04 13:36:02', '2022-10-30 19:20:22', '2022-11-04 13:36:02', NULL, NULL),
(9, 'App\\Models\\User', 2, 'MyApp', '2539d8a6fa65d2b7a71e0393e93647ef0d1b6e7c3cfa030b37d59fa3f6451ffb', '[\"*\"]', NULL, '2022-11-03 04:56:33', '2022-11-03 04:56:33', NULL, NULL),
(10, 'App\\Models\\User', 2, 'MyApp', '489cdaf1a0200f0cc16fca66b3b328321413fcb0cf89caaa43e805ac340a972b', '[\"*\"]', NULL, '2022-11-03 05:01:36', '2022-11-03 05:01:36', NULL, NULL),
(11, 'App\\Models\\User', 2, 'MyApp', '4ad9c62598c45ed5edcc307b920ab269e9bf804d9d15dc9fb5c3e4d3b55279ae', '[\"*\"]', NULL, '2022-11-03 05:03:05', '2022-11-03 05:03:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_detail`
--

CREATE TABLE `project_detail` (
  `id` int(10) NOT NULL,
  `kode_project` varchar(20) DEFAULT NULL,
  `employe_id` int(10) DEFAULT NULL,
  `mulai` date DEFAULT NULL,
  `sampai` date DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `create` datetime DEFAULT NULL,
  `update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `project_header`
--

CREATE TABLE `project_header` (
  `id` int(10) NOT NULL,
  `cost_center` varchar(20) DEFAULT NULL,
  `nama_project` varchar(1000) DEFAULT NULL,
  `deskripsi_project` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `create` datetime DEFAULT NULL,
  `update` datetime DEFAULT NULL,
  `cost` varchar(10) DEFAULT NULL,
  `status_id` int(5) DEFAULT NULL,
  `file_kontrak` varchar(255) DEFAULT NULL,
  `nilai` bigint(20) DEFAULT NULL,
  `terbilang` varchar(1000) DEFAULT NULL,
  `customer_code` varchar(20) DEFAULT NULL,
  `active` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `project_header`
--

INSERT INTO `project_header` (`id`, `cost_center`, `nama_project`, `deskripsi_project`, `start_date`, `end_date`, `create`, `update`, `cost`, `status_id`, `file_kontrak`, `nilai`, `terbilang`, `customer_code`, `active`) VALUES
(1, '9002001', NULL, 'Project pengadaan barang material gedung', '2023-02-01', '2023-02-28', '2023-02-15 11:18:16', NULL, '9002', 1, '9002001-230215111816.pdf', 10000, 'Sepuluh Ribu', '9002', 1),
(5, '10003001', NULL, NULL, '2023-02-01', '2023-02-25', '2023-02-15 11:44:06', NULL, '10003', 1, '10003001-230215114406.pdf', 1111111, 'Satu Juta Seratus Sebelas Ribu Seratus Sebelas', '10003', 1),
(6, '10003002', NULL, 'dsfdsfdsf', '2023-02-01', '2023-02-25', '2023-02-15 11:51:55', NULL, '10003', 1, '10003002-230215115155.pdf', 111111111, 'Seratus Sebelas Juta Seratus Sebelas Ribu Seratus Sebelas', '10003', 1),
(7, '9001001', NULL, 'sa', '2023-02-01', '2023-02-28', '2023-02-15 11:52:22', NULL, '9001', 1, '9001001-230215115222.pdf', 111111111, 'Seratus Sebelas Juta Seratus Sebelas Ribu Seratus Sebelas', '9001', 1),
(8, '10003004', NULL, 'sddd', '2023-02-01', '2023-02-25', '2023-02-15 11:54:48', NULL, '10003', 1, '10003004-230215115448.pdf', 222222222, 'Dua Ratus Dua Puluh Dua Juta Dua Ratus Dua Puluh Dua Ribu Dua Ratus Dua Puluh Dua', '10003', 1),
(9, '10003005', NULL, 'sadas', '2023-02-01', '2023-02-28', '2023-02-15 11:55:30', NULL, '10003', 1, '10003005-230215115530.pdf', 1000000, 'Satu Juta', '10003', 1),
(10, '9001002', NULL, 'ydydfy', '2023-02-01', '2023-02-25', '2023-02-15 14:19:00', NULL, '9001', 1, '9001002-230215021900.pdf', 100000000, 'Seratus  Juta', '9001', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`, `color`) VALUES
(1, 'Admin', 'blue'),
(2, 'Direktur', 'green'),
(3, 'Manager', 'aqua'),
(4, 'Komersil / Enginering', 'yellow'),
(5, 'Procurement', 'red'),
(6, 'Kadis', 'orange'),
(7, 'Kadis Operasional', 'aqua'),
(8, 'Project Manager', 'blue');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `id` int(5) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `role_id` int(5) DEFAULT NULL,
  `kembali` int(5) DEFAULT NULL,
  `text` varchar(20) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `singkatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`id`, `status`, `role_id`, `kembali`, `text`, `color`, `singkatan`) VALUES
(1, 'Baru', 6, 0, 'Kembalikan', 'orange', 'Baru'),
(2, 'Konfirmasi Komersil', 4, 1, 'Kembalikan', 'yellow', 'Konf Komersil'),
(3, 'Konfirmasi Procurement', 5, 2, 'Kembalikan', 'red', 'Konf Procurement'),
(4, 'Konfirmasi Operasional', 7, 3, 'Kembalikan', 'green', 'Konf Operasional'),
(5, 'Approve Kontrak Manager', 3, 4, 'Kembalikan', 'blue', 'Aprv Manager'),
(6, 'Persetujuan Direktur', 2, 5, 'Kembalikan', 'red', 'Aprv Direktur'),
(7, 'Penentuan Team & MR', 6, 6, 'Kembalikan', 'orange', 'Konf Team'),
(8, 'Validasi Team & MR', 3, 7, 'Kembalikan', 'aqua', 'Val Team & MR'),
(9, 'Validasi Pengadaan', 5, 8, 'Kembalikan', 'red', 'Val Pengadaan'),
(10, 'Menentukan Task List', 8, 9, 'Kembalikan', 'blue', 'Task List');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `kode_unit` int(11) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `posisi_id` int(11) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `name`, `role_id`, `kode_unit`, `jabatan`, `updated_at`, `created_at`, `password`, `remember_token`, `id`, `posisi_id`, `kode`) VALUES
('admin', 'Admin', 1, 111301, 'Manager Commercial Audit', '2022-12-21 07:09:12', '2021-01-06 07:07:01', '$2y$10$9KPhLjg2Sv/dS6kkNEGiKOzxL32qZh9qWMy0.1/rieMt5V0LV0JOO', NULL, 1, 7, NULL),
('10001', 'Example 3', 6, NULL, NULL, NULL, NULL, '$2y$10$9KPhLjg2Sv/dS6kkNEGiKOzxL32qZh9qWMy0.1/rieMt5V0LV0JOO', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_cost`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_cost` (
`customer` varchar(255)
,`alamat` text
,`id` int(5)
,`cost` varchar(10)
,`customer_code` int(10)
,`area` varchar(255)
,`active` int(5)
,`no_cost` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_employe`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_employe` (
`jabatan` varchar(255)
,`role` varchar(255)
,`color` varchar(255)
,`id` int(10)
,`nama` varchar(255)
,`nik` varchar(20)
,`jabatan_id` int(5)
,`role_id` int(5)
,`active` int(5)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_project`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_project` (
`area` varchar(255)
,`customer` varchar(255)
,`status` varchar(255)
,`role_id` int(5)
,`id` int(10)
,`cost_center` varchar(20)
,`nama_project` varchar(1000)
,`deskripsi_project` text
,`create` datetime
,`update` datetime
,`cost` varchar(10)
,`status_id` int(5)
,`start_date` date
,`end_date` date
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_project_header`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_project_header` (
`area` varchar(255)
,`customer` varchar(255)
,`status` varchar(255)
,`role_id` int(5)
,`id` int(10)
,`cost_center` varchar(20)
,`nama_project` varchar(1000)
,`deskripsi_project` text
,`create` datetime
,`update` datetime
,`cost` varchar(10)
,`status_id` int(5)
,`start_date` date
,`end_date` date
,`selisih` varchar(7)
,`color` varchar(20)
,`text` varchar(20)
,`kembali` int(5)
,`file_kontrak` varchar(255)
,`nilai` bigint(20)
,`terbilang` varchar(1000)
,`customer_code` varchar(20)
,`active` int(5)
,`singkatan` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_role`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_role` (
`id` int(10) unsigned
,`role` varchar(255)
,`color` varchar(255)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_status`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_status` (
`role` varchar(255)
,`keterangan` varchar(266)
,`id` int(5)
,`status` varchar(255)
,`role_id` int(5)
,`kembali` int(5)
,`text` varchar(20)
,`color` varchar(20)
,`singkatan` varchar(255)
,`total` bigint(21)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_cost`
--
DROP TABLE IF EXISTS `view_cost`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_cost`  AS SELECT `customer`.`customer` AS `customer`, `customer`.`alamat` AS `alamat`, `cost`.`id` AS `id`, `cost`.`cost` AS `cost`, `cost`.`customer_code` AS `customer_code`, `cost`.`area` AS `area`, `cost`.`active` AS `active`, `cost`.`cost` AS `no_cost` FROM (`cost` left join `customer` on((`cost`.`customer_code` = `customer`.`customer_code`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_employe`
--
DROP TABLE IF EXISTS `view_employe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_employe`  AS SELECT `jabatan`.`jabatan` AS `jabatan`, `role`.`role` AS `role`, `role`.`color` AS `color`, `employe`.`id` AS `id`, `employe`.`nama` AS `nama`, `employe`.`nik` AS `nik`, `employe`.`jabatan_id` AS `jabatan_id`, `employe`.`role_id` AS `role_id`, `employe`.`active` AS `active` FROM ((`employe` left join `jabatan` on((`employe`.`jabatan_id` = `jabatan`.`id`))) left join `role` on((`employe`.`role_id` = `role`.`id`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_project`
--
DROP TABLE IF EXISTS `view_project`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_project`  AS SELECT `cost`.`area` AS `area`, `customer`.`customer` AS `customer`, `status`.`status` AS `status`, `status`.`role_id` AS `role_id`, `project_header`.`id` AS `id`, `project_header`.`cost_center` AS `cost_center`, `project_header`.`nama_project` AS `nama_project`, `project_header`.`deskripsi_project` AS `deskripsi_project`, `project_header`.`create` AS `create`, `project_header`.`update` AS `update`, `project_header`.`cost` AS `cost`, `project_header`.`status_id` AS `status_id`, `project_header`.`start_date` AS `start_date`, `project_header`.`end_date` AS `end_date` FROM (((`project_header` left join `cost` on((`project_header`.`cost` = `cost`.`cost`))) left join `customer` on((`cost`.`customer_code` = `customer`.`customer_code`))) left join `status` on((`project_header`.`status_id` = `status`.`id`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_project_header`
--
DROP TABLE IF EXISTS `view_project_header`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_project_header`  AS SELECT `cost`.`area` AS `area`, `customer`.`customer` AS `customer`, `status`.`status` AS `status`, `status`.`role_id` AS `role_id`, `project_header`.`id` AS `id`, `project_header`.`cost_center` AS `cost_center`, `project_header`.`nama_project` AS `nama_project`, `project_header`.`deskripsi_project` AS `deskripsi_project`, `project_header`.`create` AS `create`, `project_header`.`update` AS `update`, `project_header`.`cost` AS `cost`, `project_header`.`status_id` AS `status_id`, `project_header`.`start_date` AS `start_date`, `project_header`.`end_date` AS `end_date`, replace((to_days(`project_header`.`start_date`) - to_days(`project_header`.`end_date`)),'-','') AS `selisih`, `status`.`color` AS `color`, `status`.`text` AS `text`, `status`.`kembali` AS `kembali`, `project_header`.`file_kontrak` AS `file_kontrak`, `project_header`.`nilai` AS `nilai`, `project_header`.`terbilang` AS `terbilang`, `project_header`.`customer_code` AS `customer_code`, `project_header`.`active` AS `active`, `status`.`singkatan` AS `singkatan` FROM (((`project_header` left join `cost` on((`project_header`.`cost` = `cost`.`cost`))) left join `customer` on((`cost`.`customer_code` = `customer`.`customer_code`))) left join `status` on((`project_header`.`status_id` = `status`.`id`)))  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_role`
--
DROP TABLE IF EXISTS `view_role`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_role`  AS SELECT `role`.`id` AS `id`, `role`.`role` AS `role`, `role`.`color` AS `color`, ifnull((select count(0) from `employe` where ((`employe`.`role_id` = `role`.`id`) and (`employe`.`active` = 1))),0) AS `total` FROM `role``role`  ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_status`
--
DROP TABLE IF EXISTS `view_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_status`  AS SELECT `role`.`role` AS `role`, concat('Kembalikan',' ',`role`.`role`) AS `keterangan`, `status`.`id` AS `id`, `status`.`status` AS `status`, `status`.`role_id` AS `role_id`, `status`.`kembali` AS `kembali`, `status`.`text` AS `text`, `status`.`color` AS `color`, `status`.`singkatan` AS `singkatan`, ifnull((select count(`project_header`.`id`) from `project_header` where (`project_header`.`status_id` = `status`.`id`)),0) AS `total` FROM (`status` join `role` on((`status`.`role_id` = `role`.`id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `project_detail`
--
ALTER TABLE `project_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `project_header`
--
ALTER TABLE `project_header`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cost`
--
ALTER TABLE `cost`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `employe`
--
ALTER TABLE `employe`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `project_detail`
--
ALTER TABLE `project_detail`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `project_header`
--
ALTER TABLE `project_header`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `status`
--
ALTER TABLE `status`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
