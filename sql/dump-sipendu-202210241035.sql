-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sipendu
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengguna` (
  `id_pengguna` int unsigned NOT NULL AUTO_INCREMENT,
  `nik` char(16) COLLATE utf8mb4_general_ci NOT NULL,
  `username` char(25) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `id_level` smallint unsigned NOT NULL,
  `tgl_registrasi` datetime NOT NULL,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `pengguna_username_unique` (`username`),
  UNIQUE KEY `pengguna_email_unique` (`email`),
  UNIQUE KEY `pengguna_nik_unique` (`nik`),
  KEY `pengguna_level_fk` (`id_level`),
  CONSTRAINT `pengguna_level_fk` FOREIGN KEY (`id_level`) REFERENCES `ref_level_pengguna` (`id_level`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `pengguna_nik_fk` FOREIGN KEY (`nik`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengguna`
--

LOCK TABLES `pengguna` WRITE;
/*!40000 ALTER TABLE `pengguna` DISABLE KEYS */;
INSERT INTO `pengguna` VALUES (1,'3524071034538452','admin','admin@gmail.com','$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq',1,'2022-10-22 19:33:43'),(2,'3524071034538445','pakrw','pakrw@gmail.com','$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq',3,'2022-10-22 19:33:43'),(3,'3524071034538454','pakrt','pakrt@gmail.com','$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq',2,'2022-10-22 19:33:43'),(4,'3524071034538492','operator','operator@gmail.com','$2y$10$U2OHTk00YpisSZxDfx6Oi.nWPG1ybTGn3.Jvpm0NGjNMaIC/Urbkq',4,'2022-10-22 19:33:43');
/*!40000 ALTER TABLE `pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_agama`
--

DROP TABLE IF EXISTS `ref_agama`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_agama` (
  `id_agama` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_agama`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_agama`
--

LOCK TABLES `ref_agama` WRITE;
/*!40000 ALTER TABLE `ref_agama` DISABLE KEYS */;
INSERT INTO `ref_agama` VALUES (1,'Islam'),(2,'Kristen'),(3,'Katolik'),(4,'Hindu'),(5,'Budha'),(6,'Kong Hu Cu');
/*!40000 ALTER TABLE `ref_agama` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_level_pengguna`
--

DROP TABLE IF EXISTS `ref_level_pengguna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_level_pengguna` (
  `id_level` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_level_pengguna`
--

LOCK TABLES `ref_level_pengguna` WRITE;
/*!40000 ALTER TABLE `ref_level_pengguna` DISABLE KEYS */;
INSERT INTO `ref_level_pengguna` VALUES (1,'Administrator'),(2,'Ketua RT'),(3,'Ketua RW'),(4,'Operator'),(5,'Warga');
/*!40000 ALTER TABLE `ref_level_pengguna` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_pekerjaan`
--

DROP TABLE IF EXISTS `ref_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_pekerjaan` (
  `id_pekerjaan` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pekerjaan`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_pekerjaan`
--

LOCK TABLES `ref_pekerjaan` WRITE;
/*!40000 ALTER TABLE `ref_pekerjaan` DISABLE KEYS */;
INSERT INTO `ref_pekerjaan` VALUES (1,'Belum/Tidak Bekerja'),(2,'Mengurus Rumah Tangga'),(3,'Pelajar/Mahasiswa'),(4,'Pensiunan'),(5,'Pewagai Negeri Sipil'),(6,'Tentara Nasional Indonesia'),(7,'Kepolisisan RI'),(8,'Perdagangan'),(9,'Petani/Pekebun'),(10,'Peternak'),(11,'Nelayan/Perikanan'),(12,'Industri'),(13,'Konstruksi'),(14,'Transportasi'),(15,'Karyawan Swasta'),(16,'Karyawan BUMN'),(17,'Karyawan BUMD'),(18,'Karyawan Honorer'),(19,'Buruh Harian Lepas'),(20,'Buruh Tani/Perkebunan'),(21,'Buruh Nelayan/Perikanan'),(22,'Buruh Peternakan'),(23,'Pembantu Rumah Tangga'),(24,'Tukang Cukur'),(25,'Tukang Listrik'),(26,'Tukang Batu'),(27,'Tukang Kayu'),(28,'Tukang Sol Sepatu'),(29,'Tukang Las/Pandai Besi'),(30,'Tukang Jahit'),(31,'Tukang Gigi'),(32,'Penata Rias'),(33,'Penata Busana'),(34,'Penata Rambut'),(35,'Mekanik'),(36,'Seniman'),(37,'Tabib'),(38,'Paraji'),(39,'Perancang Busana'),(40,'Penterjemah'),(41,'Imam Masjid'),(42,'Pendeta'),(43,'Pastor'),(44,'Wartawan'),(45,'Ustadz/Mubaligh'),(46,'Juru Masak'),(47,'Promotor Acara'),(48,'Anggota DPR-RI'),(49,'Anggota DPD'),(50,'Anggota DPD'),(51,'Presiden'),(52,'Wakil Presiden'),(53,'Anggota Mahkamah Konstitusi'),(54,'Anggota Kabinet/Kementerian'),(55,'Duta Besar'),(56,'Gubernur'),(57,'Wakil Gubernur'),(58,'Bupati'),(59,'Wakil Bupati'),(60,'Walikota'),(61,'Wakil Walikota'),(62,'Anggota DPRD Provinsi'),(63,'Anggota DPRD Kabupaten/Kota'),(64,'Dosen'),(65,'Guru'),(66,'Pilot'),(67,'Pengacara'),(68,'Notaris'),(69,'Arsitek'),(70,'Akuntan'),(71,'Konsultan'),(72,'Dokter'),(73,'Bidan'),(74,'Perawat'),(75,'Apoteker'),(76,'Psikiater/Psikolog'),(77,'Penyiar Televisi'),(78,'Penyiar Radio'),(79,'Pelaut'),(80,'Peneliti'),(81,'Sopir'),(82,'Pialang'),(83,'Paranormal'),(84,'Pedagang'),(85,'Perangkat Desa'),(86,'Kepala Desa'),(87,'Biarawati'),(88,'Wiraswasta'),(89,'Lainnya');
/*!40000 ALTER TABLE `ref_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_pendidikan`
--

DROP TABLE IF EXISTS `ref_pendidikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_pendidikan` (
  `id_pendidikan` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pendidikan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_pendidikan`
--

LOCK TABLES `ref_pendidikan` WRITE;
/*!40000 ALTER TABLE `ref_pendidikan` DISABLE KEYS */;
INSERT INTO `ref_pendidikan` VALUES (1,'TAMAT SD / SEDERAJAT'),(2,'TIDAK / BELUM SEKOLAH'),(3,'SLTA / SEDERAJAT'),(4,'SLTP / SEDERAJAT'),(5,'BELUM TAMAT SD/SEDERAJAT'),(6,'DIPLOMA IV/ STRATA I'),(7,'DIPLOMA I / II'),(8,'AKADEMI/ DIPLOMA III/S. MUDA'),(9,'STRATA II'),(10,'STRATA III');
/*!40000 ALTER TABLE `ref_pendidikan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_status_hubungan`
--

DROP TABLE IF EXISTS `ref_status_hubungan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_status_hubungan` (
  `id_status_hubungan` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_status_hubungan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_status_hubungan`
--

LOCK TABLES `ref_status_hubungan` WRITE;
/*!40000 ALTER TABLE `ref_status_hubungan` DISABLE KEYS */;
INSERT INTO `ref_status_hubungan` VALUES (1,'Kepala Rumah Tangga');
/*!40000 ALTER TABLE `ref_status_hubungan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_status_kawin`
--

DROP TABLE IF EXISTS `ref_status_kawin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ref_status_kawin` (
  `id_status_kawin` smallint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_status_kawin`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_status_kawin`
--

LOCK TABLES `ref_status_kawin` WRITE;
/*!40000 ALTER TABLE `ref_status_kawin` DISABLE KEYS */;
INSERT INTO `ref_status_kawin` VALUES (1,'Belum Kawin'),(2,'Kawin (Tercatat dan Belum Tercatat)'),(3,'Cerai Hidup'),(4,'Cerai Mati');
/*!40000 ALTER TABLE `ref_status_kawin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwt_pengajuan`
--

DROP TABLE IF EXISTS `rwt_pengajuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwt_pengajuan` (
  `id_pengajuan` int unsigned NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik_pemohon` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tujuan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `validasi_rt` tinyint(1) DEFAULT NULL,
  `validasi_rw` tinyint(1) DEFAULT NULL,
  `tgl_validasi_rt` datetime DEFAULT NULL,
  `tgl_validasi_rw` datetime DEFAULT NULL,
  `tgl_ajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengajuan`),
  KEY `rwt_pengajuan_FK` (`nik_pemohon`),
  CONSTRAINT `rwt_pengajuan_FK` FOREIGN KEY (`nik_pemohon`) REFERENCES `warga` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwt_pengajuan`
--

LOCK TABLES `rwt_pengajuan` WRITE;
/*!40000 ALTER TABLE `rwt_pengajuan` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwt_pengajuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warga`
--

DROP TABLE IF EXISTS `warga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `warga` (
  `nik` char(16) COLLATE utf8mb4_general_ci NOT NULL,
  `kartu_keluarga` char(16) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `jk` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `tmp_lahir` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_lahir` date NOT NULL,
  `gol_darah` enum('A','B','AB','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_agama` smallint unsigned NOT NULL,
  `id_pendidikan` smallint unsigned NOT NULL,
  `id_pekerjaan` smallint unsigned NOT NULL,
  `id_status_kawin` smallint unsigned NOT NULL,
  `id_status_hubungan` smallint unsigned NOT NULL,
  PRIMARY KEY (`nik`),
  UNIQUE KEY `penduduk_nik_kk_unique` (`nik`,`kartu_keluarga`),
  KEY `penduduk_agama_fk` (`id_agama`),
  KEY `penduduk_pekerjaan_fk` (`id_pekerjaan`),
  KEY `penduduk_status_kawin_fk` (`id_status_kawin`),
  KEY `penduduk_status_hubungan_fk` (`id_status_hubungan`),
  KEY `penduduk_pendidikan_fk` (`id_pendidikan`),
  CONSTRAINT `penduduk_agama_fk` FOREIGN KEY (`id_agama`) REFERENCES `ref_agama` (`id_agama`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `penduduk_pekerjaan_fk` FOREIGN KEY (`id_pekerjaan`) REFERENCES `ref_pekerjaan` (`id_pekerjaan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `penduduk_pendidikan_fk` FOREIGN KEY (`id_pendidikan`) REFERENCES `ref_pendidikan` (`id_pendidikan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `penduduk_status_hubungan_fk` FOREIGN KEY (`id_status_hubungan`) REFERENCES `ref_status_hubungan` (`id_status_hubungan`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `penduduk_status_kawin_fk` FOREIGN KEY (`id_status_kawin`) REFERENCES `ref_status_kawin` (`id_status_kawin`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warga`
--

LOCK TABLES `warga` WRITE;
/*!40000 ALTER TABLE `warga` DISABLE KEYS */;
INSERT INTO `warga` VALUES ('3524071034538445','3524071034538483','Pak RW','L','Surabaya','2022-10-22','A',1,4,22,1,1),('3524071034538452','3524071034538425','Mas Admin','L','Surabaya','2022-10-22','A',1,4,22,1,1),('3524071034538454','3524071034538426','Pak RT','L','Surabaya','2022-10-22','A',1,4,22,1,1),('3524071034538492','3524071034538434','Operator','L','Surabaya','2022-10-22','A',1,4,22,1,1);
/*!40000 ALTER TABLE `warga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sipendu'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-24 10:35:59
