-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2022 at 10:39 PM
-- Server version: 8.0.31-0ubuntu0.20.04.1
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siak`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int UNSIGNED NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_level` smallint UNSIGNED NOT NULL,
  `tgl_registrasi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nik`, `username`, `email`, `password`, `id_level`, `tgl_registrasi`) VALUES
(1, '3524071034538452', 'admin', 'admin@gmail.com', '$2y$10$QAyfvQmKbuz5cbvmpJaD4.SW7LHtuiBshdznmuw5PB4NLtb0d7rS2', 1, '2022-10-22 19:33:43'),
(2, '3524071034538445', 'pakrw', 'pakrw@gmail.com', '$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq', 3, '2022-10-22 19:33:43'),
(3, '3524071034538454', 'pakrt', 'pakrt@gmail.com', '$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq', 2, '2022-10-22 19:33:43'),
(4, '3524071034538492', 'operator', 'operator@gmail.com', '$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq', 4, '2022-10-22 19:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `ref_agama`
--

CREATE TABLE `ref_agama` (
  `id_agama` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_agama`
--

INSERT INTO `ref_agama` (`id_agama`, `nama`) VALUES
(1, 'Islam'),
(2, 'Kristen'),
(3, 'Katolik'),
(4, 'Hindu'),
(5, 'Budha'),
(6, 'Kong Hu Cu');

-- --------------------------------------------------------

--
-- Table structure for table `ref_level_pengguna`
--

CREATE TABLE `ref_level_pengguna` (
  `id_level` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_level_pengguna`
--

INSERT INTO `ref_level_pengguna` (`id_level`, `nama`) VALUES
(1, 'Administrator'),
(2, 'Ketua RT'),
(3, 'Ketua RW'),
(4, 'Operator'),
(5, 'Warga');

-- --------------------------------------------------------

--
-- Table structure for table `ref_pekerjaan`
--

CREATE TABLE `ref_pekerjaan` (
  `id_pekerjaan` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_pekerjaan`
--

INSERT INTO `ref_pekerjaan` (`id_pekerjaan`, `nama`) VALUES
(1, 'Belum/Tidak Bekerja'),
(2, 'Mengurus Rumah Tangga'),
(3, 'Pelajar/Mahasiswa'),
(4, 'Pensiunan'),
(5, 'Pewagai Negeri Sipil'),
(6, 'Tentara Nasional Indonesia'),
(7, 'Kepolisisan RI'),
(8, 'Perdagangan'),
(9, 'Petani/Pekebun'),
(10, 'Peternak'),
(11, 'Nelayan/Perikanan'),
(12, 'Industri'),
(13, 'Konstruksi'),
(14, 'Transportasi'),
(15, 'Karyawan Swasta'),
(16, 'Karyawan BUMN'),
(17, 'Karyawan BUMD'),
(18, 'Karyawan Honorer'),
(19, 'Buruh Harian Lepas'),
(20, 'Buruh Tani/Perkebunan'),
(21, 'Buruh Nelayan/Perikanan'),
(22, 'Buruh Peternakan'),
(23, 'Pembantu Rumah Tangga'),
(24, 'Tukang Cukur'),
(25, 'Tukang Listrik'),
(26, 'Tukang Batu'),
(27, 'Tukang Kayu'),
(28, 'Tukang Sol Sepatu'),
(29, 'Tukang Las/Pandai Besi'),
(30, 'Tukang Jahit'),
(31, 'Tukang Gigi'),
(32, 'Penata Rias'),
(33, 'Penata Busana'),
(34, 'Penata Rambut'),
(35, 'Mekanik'),
(36, 'Seniman'),
(37, 'Tabib'),
(38, 'Paraji'),
(39, 'Perancang Busana'),
(40, 'Penterjemah'),
(41, 'Imam Masjid'),
(42, 'Pendeta'),
(43, 'Pastor'),
(44, 'Wartawan'),
(45, 'Ustadz/Mubaligh'),
(46, 'Juru Masak'),
(47, 'Promotor Acara'),
(48, 'Anggota DPR-RI'),
(49, 'Anggota DPD'),
(50, 'Anggota DPD'),
(51, 'Presiden'),
(52, 'Wakil Presiden'),
(53, 'Anggota Mahkamah Konstitusi'),
(54, 'Anggota Kabinet/Kementerian'),
(55, 'Duta Besar'),
(56, 'Gubernur'),
(57, 'Wakil Gubernur'),
(58, 'Bupati'),
(59, 'Wakil Bupati'),
(60, 'Walikota'),
(61, 'Wakil Walikota'),
(62, 'Anggota DPRD Provinsi'),
(63, 'Anggota DPRD Kabupaten/Kota'),
(64, 'Dosen'),
(65, 'Guru'),
(66, 'Pilot'),
(67, 'Pengacara'),
(68, 'Notaris'),
(69, 'Arsitek'),
(70, 'Akuntan'),
(71, 'Konsultan'),
(72, 'Dokter'),
(73, 'Bidan'),
(74, 'Perawat'),
(75, 'Apoteker'),
(76, 'Psikiater/Psikolog'),
(77, 'Penyiar Televisi'),
(78, 'Penyiar Radio'),
(79, 'Pelaut'),
(80, 'Peneliti'),
(81, 'Sopir'),
(82, 'Pialang'),
(83, 'Paranormal'),
(84, 'Pedagang'),
(85, 'Perangkat Desa'),
(86, 'Kepala Desa'),
(87, 'Biarawati'),
(88, 'Wiraswasta'),
(89, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `ref_pendidikan`
--

CREATE TABLE `ref_pendidikan` (
  `id_pendidikan` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_pendidikan`
--

INSERT INTO `ref_pendidikan` (`id_pendidikan`, `nama`) VALUES
(1, 'Tamat SD / Sederajat'),
(2, 'Tidak / Belum Sekolah'),
(3, 'SLTA / Sederajat'),
(4, 'SLTP / Sederajat'),
(5, 'Belum Tamat SD / Sederajat'),
(6, 'Diploma IV/ Strata I'),
(7, 'Diploma I / II'),
(8, 'Akademi / Diploma III /S. Muda'),
(9, 'Strata II'),
(10, 'Strata III');

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_hubungan`
--

CREATE TABLE `ref_status_hubungan` (
  `id_status_hubungan` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_status_hubungan`
--

INSERT INTO `ref_status_hubungan` (`id_status_hubungan`, `nama`) VALUES
(1, 'Kepala Keluarga'),
(2, 'Suami'),
(3, 'Istri'),
(4, 'Anak'),
(5, 'Menantu'),
(6, 'Cucu'),
(7, 'Orang tua'),
(8, 'Mertua'),
(9, 'Famili Lain'),
(10, 'Pembantu'),
(11, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `ref_status_kawin`
--

CREATE TABLE `ref_status_kawin` (
  `id_status_kawin` smallint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_status_kawin`
--

INSERT INTO `ref_status_kawin` (`id_status_kawin`, `nama`) VALUES
(1, 'Belum Kawin'),
(2, 'Kawin (Tercatat dan Belum Tercatat)'),
(3, 'Cerai Hidup'),
(4, 'Cerai Mati');

-- --------------------------------------------------------

--
-- Table structure for table `rwt_kelahiran`
--

CREATE TABLE `rwt_kelahiran` (
  `id_rwt_kelahiran` int UNSIGNED NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_lapor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rwt_kelahiran`
--

INSERT INTO `rwt_kelahiran` (`id_rwt_kelahiran`, `nik`, `tgl_lapor`) VALUES
(1, '6524450589328026', '2022-11-21 07:24:02'),
(2, '6524450636510824', '2022-11-21 07:25:07'),
(3, '6524450646500252', '2022-11-21 07:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `rwt_kematian`
--

CREATE TABLE `rwt_kematian` (
  `id_rwt_kematian` int UNSIGNED NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_meninggal` date NOT NULL,
  `tgl_lapor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rwt_kematian`
--

INSERT INTO `rwt_kematian` (`id_rwt_kematian`, `nik`, `tgl_meninggal`, `tgl_lapor`) VALUES
(3, '6524450660549921', '2021-10-05', '2022-11-21 06:33:41'),
(4, '6524450190845317', '2022-10-12', '2022-11-21 06:33:48'),
(5, '6524450322587271', '2022-09-13', '2022-11-21 06:33:54'),
(7, '3524047004957683', '2022-12-01', '2022-12-04 06:20:09'),
(8, '3524071004950356', '2022-12-15', '2022-12-19 14:12:28');

-- --------------------------------------------------------

--
-- Table structure for table `rwt_mutasi`
--

CREATE TABLE `rwt_mutasi` (
  `id_rwt_mutasi` int UNSIGNED NOT NULL,
  `jenis_mutasi` enum('masuk','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_mutasi` date NOT NULL,
  `tgl_lapor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rwt_mutasi`
--

INSERT INTO `rwt_mutasi` (`id_rwt_mutasi`, `jenis_mutasi`, `nik`, `tgl_mutasi`, `tgl_lapor`) VALUES
(2, 'masuk', '6524450540739715', '2022-12-19', '2022-12-19 15:38:16'),
(3, 'masuk', '6524450515453692', '2022-12-01', '2022-12-01 12:17:35'),
(4, 'keluar', '3524071034538454', '2022-12-01', '2022-12-01 12:52:24'),
(5, 'keluar', '3524071034538452', '2022-12-01', '2022-12-01 12:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `rwt_pengajuan`
--

CREATE TABLE `rwt_pengajuan` (
  `id_pengajuan` int UNSIGNED NOT NULL,
  `no_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `filektp` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `validasi_rt` tinyint(1) DEFAULT NULL,
  `tgl_validasi_rt` datetime DEFAULT NULL,
  `catatan_val_rt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `validasi_rw` tinyint(1) DEFAULT NULL,
  `tgl_validasi_rw` datetime DEFAULT NULL,
  `catatan_val_rw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tgl_ajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rwt_pengajuan`
--

INSERT INTO `rwt_pengajuan` (`id_pengajuan`, `no_surat`, `nik`, `tujuan`, `keperluan`, `keterangan`, `filektp`, `validasi_rt`, `tgl_validasi_rt`, `catatan_val_rt`, `validasi_rw`, `tgl_validasi_rw`, `catatan_val_rw`, `tgl_ajuan`) VALUES
(2, NULL, '3524071004950067', 'hgj', 'hgjgh', 'hjghj', 'upload/ausaid-logo.png', NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-19 22:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kartu_keluarga` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `jk` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tmp_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `gol_darah` enum('A','B','AB','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_agama` smallint UNSIGNED NOT NULL,
  `id_pendidikan` smallint UNSIGNED NOT NULL,
  `id_pekerjaan` smallint UNSIGNED NOT NULL,
  `id_status_kawin` smallint UNSIGNED NOT NULL,
  `id_status_hubungan` smallint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`nik`, `kartu_keluarga`, `nama`, `alamat`, `jk`, `tmp_lahir`, `tgl_lahir`, `gol_darah`, `id_agama`, `id_pendidikan`, `id_pekerjaan`, `id_status_kawin`, `id_status_hubungan`) VALUES
('3524047004957683', '3524071004957683', 'Hudan Studiawan', NULL, 'L', 'Surabaya', '2022-12-01', NULL, 1, 2, 1, 1, 4),
('3524071004950005', '3524071004950003', 'Suyono', NULL, 'L', 'Surabaya', '2022-11-29', NULL, 1, 1, 1, 1, 1),
('3524071004950067', '3524071004950058', 'Almu\'minun', 'Jl. Kertajaya No. 73B Gubeng Surabaya', 'L', 'Surabaya', '2022-11-28', NULL, 1, 1, 1, 1, 1),
('3524071004950356', '3524071004950356', 'Luqman Hakim', NULL, 'L', 'Surabaya', '2022-12-01', NULL, 1, 2, 1, 1, 4),
('3524071004956264', '3524071004956253', 'Nadiyatul Adabiyyah', NULL, 'L', 'Surabaya', '2022-12-01', NULL, 1, 2, 1, 1, 4),
('3524071034538445', '3524071034538483', 'Luluh Simanjuntak', NULL, 'L', 'Surabaya', '1981-06-16', NULL, 1, 4, 22, 1, 1),
('3524071034538452', '3524071034538425', 'Eka Usada', NULL, 'L', 'Surabaya', '1994-04-22', 'A', 1, 4, 22, 1, 1),
('3524071034538454', '3524071034538426', 'Edi Megantara', NULL, 'L', 'Surabaya', '1996-12-17', 'A', 1, 4, 22, 1, 1),
('3524071034538492', '3524071034538434', 'Wirda Sudiati', NULL, 'L', 'Surabaya', '2012-05-02', 'A', 1, 4, 22, 1, 1),
('6524450027272303', '3524078333752780', 'Kuncara Mahendra', NULL, 'L', 'Surabaya', '2001-02-13', 'O', 3, 1, 33, 4, 6),
('6524450051792311', '3524078333752780', 'Sidiq Mandala', NULL, 'L', 'Sidoarjo', '1982-01-15', 'O', 2, 1, 59, 4, 11),
('6524450060888210', '3524078333752780', 'Galak Hardiansyah', NULL, 'L', 'Surabaya', '1993-03-14', 'O', 4, 1, 86, 3, 5),
('6524450095999418', '3524078333752781', 'Adikara Prakasa', NULL, 'P', 'Surabaya', '2006-06-23', 'A', 4, 4, 85, 3, 1),
('6524450139599568', '3524078333752780', 'Lala Suartini', NULL, 'P', 'Surabaya', '1977-03-09', 'O', 3, 7, 55, 3, 9),
('6524450181062771', '3524072590932243', 'Virman Pradana', NULL, 'L', 'Sidoarjo', '2022-10-22', 'B', 1, 8, 11, 3, 10),
('6524450190845317', '3524072590932243', 'Artanto Wasita', NULL, 'L', 'Surabaya', '1987-11-17', 'O', 1, 2, 15, 1, 8),
('6524450192112821', '3524072590932243', 'Nilam Sudiati', NULL, 'P', 'Sidoarjo', '1981-01-21', 'O', 6, 9, 23, 3, 6),
('6524450256872317', '3524072590932243', 'Jail Putra', NULL, 'L', 'Surabaya', '1977-12-26', 'O', 4, 3, 37, 3, 3),
('6524450319296644', '3524072590932243', 'Ihsan Hutagalung', NULL, 'L', 'Sidoarjo', '1972-11-04', 'A', 5, 4, 82, 3, 2),
('6524450320352781', '3524072188994213', 'Ellis Laksmiwati', NULL, 'P', 'Surabaya', '2022-10-22', 'A', 2, 4, 42, 3, 5),
('6524450322587271', '3524072188994213', 'Clara Fujiati', NULL, 'P', 'Sidoarjo', '2022-10-22', 'A', 1, 8, 22, 4, 9),
('6524450331530325', '3524074232482474', 'Hasim Wibisono', NULL, 'L', 'Surabaya', '2022-10-22', 'O', 4, 5, 40, 3, 2),
('6524450515453692', '3524074232482474', 'Damar Tamba', NULL, 'L', 'Sidoarjo', '1998-01-21', 'A', 5, 7, 23, 3, 9),
('6524450529285126', '3524074232482474', 'Titin Suartini', NULL, 'P', 'Surabaya', '2005-06-04', 'O', 6, 1, 86, 4, 3),
('6524450540739715', '3524074619202487', 'Perkasa Hidayat', NULL, 'L', 'Surabaya', '2022-10-22', 'O', 5, 3, 66, 2, 3),
('6524450587400080', '3524074619202487', 'Luwes Rajata', NULL, 'L', 'Sidoarjo', '2016-01-23', 'AB', 4, 7, 88, 2, 2),
('6524450589328026', '3524074619202487', 'Indah Haryanti', NULL, 'P', 'Sidoarjo', '2020-11-02', 'A', 5, 5, 53, 3, 2),
('6524450636510824', '3524074619202487', 'Kani Permata', NULL, 'P', 'Sidoarjo', '2022-07-03', 'O', 5, 2, 51, 3, 5),
('6524450646500252', '3524077508459822', 'Jamalia Handayani', NULL, 'P', 'Sidoarjo', '2022-11-22', 'O', 1, 9, 24, 2, 3),
('6524450660549921', '3524077508459822', 'Aisyah Oktaviani', NULL, 'P', 'Sidoarjo', '2019-07-10', 'O', 1, 6, 46, 1, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `pengguna_username_unique` (`username`),
  ADD UNIQUE KEY `pengguna_email_unique` (`email`),
  ADD UNIQUE KEY `pengguna_nik_unique` (`nik`),
  ADD KEY `pengguna_level_fk` (`id_level`);

--
-- Indexes for table `ref_agama`
--
ALTER TABLE `ref_agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indexes for table `ref_level_pengguna`
--
ALTER TABLE `ref_level_pengguna`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `ref_pekerjaan`
--
ALTER TABLE `ref_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `ref_pendidikan`
--
ALTER TABLE `ref_pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indexes for table `ref_status_hubungan`
--
ALTER TABLE `ref_status_hubungan`
  ADD PRIMARY KEY (`id_status_hubungan`);

--
-- Indexes for table `ref_status_kawin`
--
ALTER TABLE `ref_status_kawin`
  ADD PRIMARY KEY (`id_status_kawin`);

--
-- Indexes for table `rwt_kelahiran`
--
ALTER TABLE `rwt_kelahiran`
  ADD PRIMARY KEY (`id_rwt_kelahiran`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `rwt_kematian`
--
ALTER TABLE `rwt_kematian`
  ADD PRIMARY KEY (`id_rwt_kematian`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `rwt_mutasi`
--
ALTER TABLE `rwt_mutasi`
  ADD PRIMARY KEY (`id_rwt_mutasi`),
  ADD KEY `rwt_mutasi_ibfk_1` (`nik`);

--
-- Indexes for table `rwt_pengajuan`
--
ALTER TABLE `rwt_pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD UNIQUE KEY `rwt_pengajuan_no_surat_unique` (`no_surat`),
  ADD KEY `rwt_pengajuan_FK` (`nik`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`nik`),
  ADD UNIQUE KEY `penduduk_nik_kk_unique` (`nik`,`kartu_keluarga`),
  ADD KEY `penduduk_agama_fk` (`id_agama`),
  ADD KEY `penduduk_pekerjaan_fk` (`id_pekerjaan`),
  ADD KEY `penduduk_status_kawin_fk` (`id_status_kawin`),
  ADD KEY `penduduk_status_hubungan_fk` (`id_status_hubungan`),
  ADD KEY `penduduk_pendidikan_fk` (`id_pendidikan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ref_agama`
--
ALTER TABLE `ref_agama`
  MODIFY `id_agama` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ref_level_pengguna`
--
ALTER TABLE `ref_level_pengguna`
  MODIFY `id_level` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_pekerjaan`
--
ALTER TABLE `ref_pekerjaan`
  MODIFY `id_pekerjaan` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `ref_pendidikan`
--
ALTER TABLE `ref_pendidikan`
  MODIFY `id_pendidikan` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ref_status_hubungan`
--
ALTER TABLE `ref_status_hubungan`
  MODIFY `id_status_hubungan` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ref_status_kawin`
--
ALTER TABLE `ref_status_kawin`
  MODIFY `id_status_kawin` smallint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rwt_kelahiran`
--
ALTER TABLE `rwt_kelahiran`
  MODIFY `id_rwt_kelahiran` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rwt_kematian`
--
ALTER TABLE `rwt_kematian`
  MODIFY `id_rwt_kematian` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rwt_mutasi`
--
ALTER TABLE `rwt_mutasi`
  MODIFY `id_rwt_mutasi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rwt_pengajuan`
--
ALTER TABLE `rwt_pengajuan`
  MODIFY `id_pengajuan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_level_fk` FOREIGN KEY (`id_level`) REFERENCES `ref_level_pengguna` (`id_level`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `pengguna_nik_fk` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rwt_kelahiran`
--
ALTER TABLE `rwt_kelahiran`
  ADD CONSTRAINT `rwt_kelahiran_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rwt_kematian`
--
ALTER TABLE `rwt_kematian`
  ADD CONSTRAINT `rwt_kematian_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rwt_mutasi`
--
ALTER TABLE `rwt_mutasi`
  ADD CONSTRAINT `rwt_mutasi_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rwt_pengajuan`
--
ALTER TABLE `rwt_pengajuan`
  ADD CONSTRAINT `rwt_pengajuan_FK` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `penduduk_agama_fk` FOREIGN KEY (`id_agama`) REFERENCES `ref_agama` (`id_agama`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_pekerjaan_fk` FOREIGN KEY (`id_pekerjaan`) REFERENCES `ref_pekerjaan` (`id_pekerjaan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_pendidikan_fk` FOREIGN KEY (`id_pendidikan`) REFERENCES `ref_pendidikan` (`id_pendidikan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_status_hubungan_fk` FOREIGN KEY (`id_status_hubungan`) REFERENCES `ref_status_hubungan` (`id_status_hubungan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `penduduk_status_kawin_fk` FOREIGN KEY (`id_status_kawin`) REFERENCES `ref_status_kawin` (`id_status_kawin`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
