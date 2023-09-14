-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Sep 2023 pada 14.22
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spfcv2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `aturanbreadths`
--

CREATE TABLE `aturanbreadths` (
  `id` int UNSIGNED NOT NULL,
  `id_aturan` int UNSIGNED NOT NULL,
  `parent_kode_gejala` int UNSIGNED NOT NULL,
  `child_kode_gejala` int UNSIGNED NOT NULL,
  `id_kerusakan` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `aturanbreadths`
--

INSERT INTO `aturanbreadths` (`id`, `id_aturan`, `parent_kode_gejala`, `child_kode_gejala`, `id_kerusakan`) VALUES
(1, 1, 1, 4, 1),
(2, 2, 1, 5, NULL),
(3, 2, 5, 6, 2),
(4, 3, 1, 5, NULL),
(5, 3, 5, 7, 3),
(6, 4, 2, 8, NULL),
(7, 4, 8, 9, 4),
(8, 5, 2, 10, 5),
(9, 6, 3, 11, 6),
(10, 7, 3, 12, 7),
(11, 8, 3, 13, NULL),
(12, 8, 13, 14, 8),
(13, 9, 3, 15, NULL),
(14, 9, 15, 16, NULL),
(15, 9, 16, 17, 9),
(16, 10, 3, 15, NULL),
(17, 10, 15, 18, 10),
(18, 11, 3, 15, NULL),
(19, 11, 15, 19, 11),
(20, 12, 3, 20, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `aturans`
--

CREATE TABLE `aturans` (
  `id` int UNSIGNED NOT NULL,
  `id_kerusakan` int UNSIGNED NOT NULL,
  `gejala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `aturans`
--

INSERT INTO `aturans` (`id`, `id_kerusakan`, `gejala`) VALUES
(1, 1, '1->4'),
(2, 2, '1->5->6'),
(3, 3, '1->5->7'),
(4, 4, '2->8->9'),
(5, 5, '2->10'),
(6, 6, '3->11'),
(7, 7, '3->12'),
(8, 8, '3->13->14'),
(9, 9, '3->15->16->17'),
(10, 10, '3->15->18'),
(11, 11, '3->15->19'),
(12, 12, '3->20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detperbaikans`
--

CREATE TABLE `detperbaikans` (
  `id` int UNSIGNED NOT NULL,
  `id_perbaikan` int UNSIGNED NOT NULL,
  `id_kerusakan` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `detperbaikans`
--

INSERT INTO `detperbaikans` (`id`, `id_perbaikan`, `id_kerusakan`) VALUES
(2, 14, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `gejalas`
--

CREATE TABLE `gejalas` (
  `id` int UNSIGNED NOT NULL,
  `kode_gejala` varchar(255) NOT NULL,
  `nama_gejala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `gejalas`
--

INSERT INTO `gejalas` (`id`, `kode_gejala`, `nama_gejala`) VALUES
(1, 'G1', 'LED Pada Panel Depan Set Top Box Tidak Menyala						'),
(2, 'G2', 'LED Pada Panel Depan Set Top BoX Menyala Merah						'),
(3, 'G3', 'LED Pada Panel Depan Set Top Box Menyala Hijau						'),
(4, 'G4', 'Kabel Adaptor Power Set Top Box Terkelupas						'),
(5, 'G5', 'Tersetrum Saat Menyentuh Set Top Box						'),
(6, 'G6', 'Terlihat Atau Tercium Bau Gosong Pada Port Antena STB						'),
(7, 'G7', 'Power Adaptor Terasa Panas Berlebih						'),
(8, 'G8', 'Display Pada Set Top Box Bertuliskan “UP”						'),
(9, 'G9', 'Tampilan Bootlogo Set Top Box Pada Televisi Hanya Diam Dalam Waktu Lama						'),
(10, 'G10', 'Display Pada Set Top Box Bertuliskan “ON”						'),
(11, 'G11', 'Remote Control Set Top Box Tidak Respon 						'),
(12, 'G12', 'Tidak Ada Video Dan Suara Pada Televisi						'),
(13, 'G13', 'Channel Berbayar Tidak Tampil						'),
(14, 'G14', 'Terdapat Pesan Berulang Peringatan Masa Aktif 						'),
(15, 'G15', 'Tampilan Jelek / Berkedip 						'),
(16, 'G16', 'Tampil Pesan Error \"Searching For Signal\"						'),
(17, 'G17', 'Bar Sinyal Naik Turun Tidak Stabil						'),
(18, 'G18', 'Tampil Pesan  \"Data Channel Tidak Keluar\"						'),
(19, 'G19', 'Bar Sinyal <50%						'),
(20, 'G20', 'Isi Channel Berbeda Dengan Nama Channel');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kerusakans`
--

CREATE TABLE `kerusakans` (
  `id` int UNSIGNED NOT NULL,
  `kode_kerusakan` varchar(255) NOT NULL,
  `nama_kerusakan` varchar(255) NOT NULL,
  `penyebab_kerusakan` text NOT NULL,
  `solusi_kerusakan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `kerusakans`
--

INSERT INTO `kerusakans` (`id`, `kode_kerusakan`, `nama_kerusakan`, `penyebab_kerusakan`, `solusi_kerusakan`) VALUES
(1, 'K1', 'Kabel Power Terputus', '<ul>\n	<li>Kabel Belum Terpasang Dengan Benar <br></li>\n	<li>Tergigit Tikus <br></li>\n</ul>\n', '<ul>\n	<li>Cek Pemasangan Kabel Power Dan Pastikan Pemasangannya Benar <br></li>\n	<li>Penggantian Power Adaptor <br></li>\n	<li>Jauhkan Sekiranya Dari Jangkauan Tikus <br></li>\n</ul>\n'),
(2, 'K2', 'MainBoard Set Top Box Bermasalah', '<ul>\n	<li>Tegangan Listrik Sering Tidak Stabil<br></li>\n	<li>Terlalu Sering Mati Listrik Secara Tiba-Tiba<br></li>\n	<li>Terdapat Komponen Yang Short Atau Tidak Normal<br></li>\n</ul>\n', '<ul>\n	<li>Pastikan Tegangan Normal Dan Nilai Setiap Komponen Sesuai<br></li>\n	<li>Penggantian Komponen Yang Terindikasi Tidak Normal<br></li>\n	<li>Menawarkan Penggantian Set Top Box<br></li>\n</ul>\n'),
(3, 'K3', 'Power Adaptor Set Top Box Bermasalah', '<ul>\n	<li>Arus Listrik Sering Tidak Stabil<br></li>\n	<li>Usia Adaptor<br></li>\n</ul>\n', '<ul>\n	<li>Penggantian Power Adaptor<br></li>\n</ul>\n'),
(4, 'K4', 'Mode Up / Bootloop', '<ul>\n	<li>Bug Pada Frimware</li>\n	<li>Kegagalan Upgrade Frimware OTA&nbsp;(Over The Air) Maupun Via USB<br></li>\n	<li>Menggunakan Frimware Modifikasi.<br></li>\n</ul>\n', '<ul>\n	<li>Flash Ulang Menggunakan Frimware Asli Dan Terbaru Menggunakan Metode USB Flash.<br></li>\n</ul>\n'),
(5, 'K5', 'Mode On / Mata Merah', '<ul>\n	<li>Kegagalan Upgrade Frimware OTA&nbsp;(Over The Air) Maupun Via USB</li>\n	<li>Terlalu Sering Mati Listrik Secara Tiba-Tiba<br></li>\n	<li>Terdapat Komponen Yang Tidak Dapat Mensuplay Daya Dengan Normal<br></li>\n</ul>\n', '<ul>\n	<li>Pastikan Tegangan Normal Dan Nilai Setiap Komponen Sesuai.<br></li>\n	<li>Penggantian Komponen Yang Terindikasi Tidak Normal.</li>\n	<li>Lakukan Direct Flash Ke IC EPROM&nbsp;Menggunakan USB TTL<br></li>\n	<li>Penggantian Set Top Box<br></li>\n</ul>\n'),
(6, 'K6', 'Remote Control STB Bermasalah', '<ul>\n	<li>Baterai Tidak Terpasang Dengan Benar<br></li>\n	<li>Kapasitas Baterai Habis<br></li>\n	<li>Kesalahan Pemakaian</li>\n</ul>\n', '<ul>\n	<li>Pastikan Pemasangan Baterai Tepat<br></li>\n	<li>Penggantian Baterai<br></li>\n	<li>Penggantian Remote Control<br></li>\n</ul>\n'),
(7, 'K7', 'Kabel HDMI / RCA Bermasalah', '<ul>\n	<li>Plug HDMI/RCA Tidak Terpasang Dengan Benar.<br></li>\n	<li>Salah Memilih Video Input Source Dari Menu Televisi.<br></li>\n	<li>Kabel Putus.<br></li>\n</ul>\n', '<ul>\n	<li>Pastikan HDMI/RCA Terpasang Dengan Benar <br></li>\n	<li>Pastikan Televisi Tidak Dalam Mode Mute.<br></li>\n	<li>Pastikan Pilihan Video Input Source Pada Televisi Benar.<br></li>\n	<li>Penggantian Kabel HDMI/RCA.<br></li>\n</ul>\n'),
(8, 'K8', 'Masa Aktif Habis ', '<ul>\n	<li>Masa Paket Atau Voucher Berbayar Habis<br></li>\n</ul>\n', '<ul>\n	<li>Beli Voucher Di Aplikasi Tanaka Voucher<br></li>\n	<li>Restart Receiver<br></li>\n</ul>\n'),
(9, 'K9', 'Perangkat Antena Bermasalah', '<ul>\n	<li>Antena Tidak Terpasang Dengan Tepat.<br></li>\n	<li>Masalah Di LNB.<br></li>\n	<li>Kabel Antena Tidak Terpasang Dengan Kencang.<br></li>\n</ul>\n', '<ul>\n	<li>Luruskan Antena Secara Tepat Dan Periksa Kekuatan Sinyal Pada Menu Auto Scan <br></li>\n	<li>Penggantian Perangkat LNB &nbsp;Yang Sesuai<br></li>\n	<li>Periksa Kabel Antena Dan Kencangkan<br></li>\n	<li>Lakukan Penggantian Kabel Antena Bila Diperlukan<br></li>\n</ul>\n'),
(10, 'K10', 'Data Channel Kosong', '<ul>\n	<li>Tidak Ada Channel Yang Tersimpan.<br></li>\n	<li>Tidak Mengisi Data Pengaturan Antena.<br></li>\n</ul>\n', '<ul>\n	<li>Isi Data Pengaturan Antena Sesuai Data Dari Penyedia Layanan.<br></li>\n	<li>Pilih Menu Auto Scan Atau Manual Scan Dan Lakukan Scan Ulang.<br></li>\n</ul>\n'),
(11, 'K11', 'Sinyal Lemah', '<ul>\n	<li>Sinyal Yang Ada Terlalu Lemah</li><li>Pemasangan Dudukan Antena Kurang Kencang<br></li>\n	<li>Terdapat Banyak Halangan Di Sekitar Antena<br></li>\n</ul>\n', '<ul>\n	<li>Pindahkan Antenna Ke Tempat Yang Terhidar Dari Halangan</li><li>Pastikan Baut Dudukan Antena Sudah Kencang<br></li>\n	<li>Periksa Sinyal Pada Menu Auto Scan Dan Arahkan Antenna Dengan Tepat<br></li>\n</ul>\n'),
(12, 'K12', 'Data Channel Belum Terupdate', '<ul>\n	<li>Belum Melakukan Update Frimware</li>\n</ul>\n', '<ul>\n	<li>Melakukan Refresh Akun Pada Aplikasi Tanaka<br></li>\n	<li>Update Frimware Terbaru<br></li>\n</ul>\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsultasitmps`
--

CREATE TABLE `konsultasitmps` (
  `id` int UNSIGNED NOT NULL,
  `id_cs` int UNSIGNED NOT NULL,
  `parent_gejala` int UNSIGNED DEFAULT NULL,
  `child_gejala` int UNSIGNED DEFAULT NULL,
  `answer` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `konsultasitmps`
--

INSERT INTO `konsultasitmps` (`id`, `id_cs`, `parent_gejala`, `child_gejala`, `answer`) VALUES
(104, 1, NULL, 1, 0),
(105, 1, 1, 4, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-12-02-051738', 'App\\Database\\Migrations\\Role', 'default', 'App', 1694700943, 1),
(2, '2021-12-02-051836', 'App\\Database\\Migrations\\Pegawai', 'default', 'App', 1694700943, 1),
(3, '2021-12-02-055204', 'App\\Database\\Migrations\\Gejala', 'default', 'App', 1694700943, 1),
(4, '2021-12-02-055314', 'App\\Database\\Migrations\\Kerusakan', 'default', 'App', 1694700943, 1),
(5, '2021-12-03-031818', 'App\\Database\\Migrations\\User', 'default', 'App', 1694700943, 1),
(6, '2021-12-06-043025', 'App\\Database\\Migrations\\Aturan', 'default', 'App', 1694700943, 1),
(7, '2021-12-06-043039', 'App\\Database\\Migrations\\AturanBreadth', 'default', 'App', 1694700943, 1),
(8, '2021-12-07-080518', 'App\\Database\\Migrations\\Perbaikan', 'default', 'App', 1694700943, 1),
(9, '2021-12-07-083850', 'App\\Database\\Migrations\\KonsultasiTmp', 'default', 'App', 1694700943, 1),
(10, '2021-12-07-083923', 'App\\Database\\Migrations\\Mperbaikan', 'default', 'App', 1694700943, 1),
(11, '2022-01-29-050521', 'App\\Database\\Migrations\\DetPerbaikan', 'default', 'App', 1694700943, 1),
(51, '2021-12-02-051738', 'App\\Database\\Migrations\\Role', 'default', 'App', 1640757562, 1),
(52, '2021-12-02-051836', 'App\\Database\\Migrations\\Pegawai', 'default', 'App', 1640757562, 1),
(53, '2021-12-02-055204', 'App\\Database\\Migrations\\Gejala', 'default', 'App', 1640757562, 1),
(54, '2021-12-02-055314', 'App\\Database\\Migrations\\Kerusakan', 'default', 'App', 1640757562, 1),
(55, '2021-12-03-031818', 'App\\Database\\Migrations\\User', 'default', 'App', 1640757562, 1),
(56, '2021-12-06-043025', 'App\\Database\\Migrations\\Aturan', 'default', 'App', 1640757562, 1),
(57, '2021-12-06-043039', 'App\\Database\\Migrations\\AturanBreadth', 'default', 'App', 1640757562, 1),
(58, '2021-12-07-080518', 'App\\Database\\Migrations\\Perbaikan', 'default', 'App', 1640757562, 1),
(59, '2021-12-07-083850', 'App\\Database\\Migrations\\KonsultasiTmp', 'default', 'App', 1640757562, 1),
(60, '2021-12-07-083923', 'App\\Database\\Migrations\\Mperbaikan', 'default', 'App', 1640757562, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mperbaikans`
--

CREATE TABLE `mperbaikans` (
  `id` int UNSIGNED NOT NULL,
  `id_perbaikan` int UNSIGNED NOT NULL,
  `id_gejala` int UNSIGNED NOT NULL,
  `answer` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `mperbaikans`
--

INSERT INTO `mperbaikans` (`id`, `id_perbaikan`, `id_gejala`, `answer`) VALUES
(74, 14, 1, 0),
(75, 14, 4, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawais`
--

CREATE TABLE `pegawais` (
  `id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `kode_pegawai` varchar(255) NOT NULL,
  `nama_pegawai` varchar(255) DEFAULT NULL,
  `alamat_pegawai` text,
  `nomor_telepon_pegawai` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `pegawais`
--

INSERT INTO `pegawais` (`id`, `role_id`, `kode_pegawai`, `nama_pegawai`, `alamat_pegawai`, `nomor_telepon_pegawai`) VALUES
(1, 1, 'admin', 'admin', 'Surabaya', '0899 8911 285'),
(2, 3, 'CS2', 'Anastasia Sudiati', 'Sidoarjo', '083333323112'),
(3, 4, 'TK3', 'Alvin Yoandika', 'Mojosari', '081646542961'),
(5, 4, 'TK5', 'Mahendra Wicaksono', 'Sidoarjo', '083369830721'),
(6, 4, 'TK6', 'Robby', 'Askjdhask', '212312');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbaikans`
--

CREATE TABLE `perbaikans` (
  `id` int UNSIGNED NOT NULL,
  `id_cs` int UNSIGNED NOT NULL,
  `id_kerusakan` int UNSIGNED DEFAULT NULL,
  `id_teknisi` int UNSIGNED NOT NULL,
  `nama_customer` varchar(255) NOT NULL,
  `alamat_customer` text NOT NULL,
  `no_telepon_customer` varchar(255) NOT NULL,
  `tanggal_konsultasi` date DEFAULT NULL,
  `tanggal_mulai_perbaikan` date DEFAULT NULL,
  `tanggal_selesai_perbaikan` date DEFAULT NULL,
  `status_perbaikan` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `perbaikans`
--

INSERT INTO `perbaikans` (`id`, `id_cs`, `id_kerusakan`, `id_teknisi`, `nama_customer`, `alamat_customer`, `no_telepon_customer`, `tanggal_konsultasi`, `tanggal_mulai_perbaikan`, `tanggal_selesai_perbaikan`, `status_perbaikan`) VALUES
(13, 1, NULL, 3, 'robby', 'Jl. Jagir Sidomukti 4 No.1, Surabaya', '+6285606500085', '2023-09-14', '2023-09-14', NULL, 0),
(14, 1, NULL, 3, 'robby', 'Jl. Jagir Sidomukti 4 No.1, Surabaya', '+6285606500085', '2023-09-14', '2023-09-14', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `nama_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `nama_role`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Customer Service'),
(4, 'Teknisi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `pegawai_id` int UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_access` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `pegawai_id`, `username`, `password`, `is_access`) VALUES
(1, 1, 'admin', 'ee11cbb19052e40b07aac0ca060c23ee', '0'),
(2, 2, 'CS2', '202cb962ac59075b964b07152d234b70', '0');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `aturanbreadths`
--
ALTER TABLE `aturanbreadths`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aturanbreadths_id_aturan_foreign` (`id_aturan`),
  ADD KEY `aturanbreadths_parent_kode_gejala_foreign` (`parent_kode_gejala`),
  ADD KEY `aturanbreadths_child_kode_gejala_foreign` (`child_kode_gejala`),
  ADD KEY `aturanbreadths_id_kerusakan_foreign` (`id_kerusakan`);

--
-- Indeks untuk tabel `aturans`
--
ALTER TABLE `aturans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aturans_id_kerusakan_foreign` (`id_kerusakan`);

--
-- Indeks untuk tabel `detperbaikans`
--
ALTER TABLE `detperbaikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detperbaikans_id_perbaikan_foreign` (`id_perbaikan`),
  ADD KEY `detperbaikans_id_kerusakan_foreign` (`id_kerusakan`);

--
-- Indeks untuk tabel `gejalas`
--
ALTER TABLE `gejalas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kerusakans`
--
ALTER TABLE `kerusakans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `konsultasitmps`
--
ALTER TABLE `konsultasitmps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `konsultasitmps_id_cs_foreign` (`id_cs`),
  ADD KEY `konsultasitmps_parent_gejala_foreign` (`parent_gejala`),
  ADD KEY `konsultasitmps_child_gejala_foreign` (`child_gejala`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mperbaikans`
--
ALTER TABLE `mperbaikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mperbaikans_id_perbaikan_foreign` (`id_perbaikan`),
  ADD KEY `mperbaikans_id_gejala_foreign` (`id_gejala`);

--
-- Indeks untuk tabel `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawais_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `perbaikans`
--
ALTER TABLE `perbaikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perbaikans_id_cs_foreign` (`id_cs`),
  ADD KEY `perbaikans_id_teknisi_foreign` (`id_teknisi`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_pegawai_id_foreign` (`pegawai_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `aturanbreadths`
--
ALTER TABLE `aturanbreadths`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `aturans`
--
ALTER TABLE `aturans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `detperbaikans`
--
ALTER TABLE `detperbaikans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `gejalas`
--
ALTER TABLE `gejalas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `kerusakans`
--
ALTER TABLE `kerusakans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `konsultasitmps`
--
ALTER TABLE `konsultasitmps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `mperbaikans`
--
ALTER TABLE `mperbaikans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `perbaikans`
--
ALTER TABLE `perbaikans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aturanbreadths`
--
ALTER TABLE `aturanbreadths`
  ADD CONSTRAINT `aturanbreadths_child_kode_gejala_foreign` FOREIGN KEY (`child_kode_gejala`) REFERENCES `gejalas` (`id`),
  ADD CONSTRAINT `aturanbreadths_id_aturan_foreign` FOREIGN KEY (`id_aturan`) REFERENCES `aturans` (`id`),
  ADD CONSTRAINT `aturanbreadths_id_kerusakan_foreign` FOREIGN KEY (`id_kerusakan`) REFERENCES `kerusakans` (`id`),
  ADD CONSTRAINT `aturanbreadths_parent_kode_gejala_foreign` FOREIGN KEY (`parent_kode_gejala`) REFERENCES `gejalas` (`id`);

--
-- Ketidakleluasaan untuk tabel `aturans`
--
ALTER TABLE `aturans`
  ADD CONSTRAINT `aturans_id_kerusakan_foreign` FOREIGN KEY (`id_kerusakan`) REFERENCES `kerusakans` (`id`);

--
-- Ketidakleluasaan untuk tabel `detperbaikans`
--
ALTER TABLE `detperbaikans`
  ADD CONSTRAINT `detperbaikans_id_kerusakan_foreign` FOREIGN KEY (`id_kerusakan`) REFERENCES `kerusakans` (`id`),
  ADD CONSTRAINT `detperbaikans_id_perbaikan_foreign` FOREIGN KEY (`id_perbaikan`) REFERENCES `perbaikans` (`id`);

--
-- Ketidakleluasaan untuk tabel `konsultasitmps`
--
ALTER TABLE `konsultasitmps`
  ADD CONSTRAINT `konsultasitmps_child_gejala_foreign` FOREIGN KEY (`child_gejala`) REFERENCES `gejalas` (`id`),
  ADD CONSTRAINT `konsultasitmps_id_cs_foreign` FOREIGN KEY (`id_cs`) REFERENCES `pegawais` (`id`),
  ADD CONSTRAINT `konsultasitmps_parent_gejala_foreign` FOREIGN KEY (`parent_gejala`) REFERENCES `gejalas` (`id`);

--
-- Ketidakleluasaan untuk tabel `mperbaikans`
--
ALTER TABLE `mperbaikans`
  ADD CONSTRAINT `mperbaikans_id_gejala_foreign` FOREIGN KEY (`id_gejala`) REFERENCES `gejalas` (`id`),
  ADD CONSTRAINT `mperbaikans_id_perbaikan_foreign` FOREIGN KEY (`id_perbaikan`) REFERENCES `perbaikans` (`id`);

--
-- Ketidakleluasaan untuk tabel `pegawais`
--
ALTER TABLE `pegawais`
  ADD CONSTRAINT `pegawais_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Ketidakleluasaan untuk tabel `perbaikans`
--
ALTER TABLE `perbaikans`
  ADD CONSTRAINT `perbaikans_id_cs_foreign` FOREIGN KEY (`id_cs`) REFERENCES `pegawais` (`id`),
  ADD CONSTRAINT `perbaikans_id_teknisi_foreign` FOREIGN KEY (`id_teknisi`) REFERENCES `pegawais` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawais` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
