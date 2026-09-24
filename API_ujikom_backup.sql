-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: API_ujikom
-- ------------------------------------------------------
-- Server version	8.0.45

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
-- Table structure for table `alat`
--

DROP TABLE IF EXISTS `alat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `status_kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alat_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `alat_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alat`
--

LOCK TABLES `alat` WRITE;
/*!40000 ALTER TABLE `alat` DISABLE KEYS */;
INSERT INTO `alat` VALUES (1,1,'Router Mikrotik RB941-2nD',15,'Baik','Router nirkabel rumahan yang cocok untuk \npraktik jaringan dasar.','mikrotik_rb941.jpg','2026-08-12 06:22:41','2026-08-12 06:22:41'),(2,2,'Kamera DSLR Canon EOS 3000D',5,'Baik','Kamera pemula untuk kebutuhan dokumentasi \ndan pembuatan aset media.','canon_3000d.jpg','2026-08-12 06:22:41','2026-08-12 06:22:41'),(3,3,'Mini PC Intel NUC 11',8,'Baik','Perangkat komputasi ringkas untuk server \nlokal skala kecil.','intel_nuc.jpg','2026-08-12 06:22:41','2026-08-12 06:22:41'),(4,4,'Tang Crimping RJ45/RJ11 Proskit',20,'Baik','Alat potong dan pasang konektor kabel \nUTP.','crimping_proskit.jpg','2026-08-12 06:22:41','2026-08-12 06:22:41'),(5,5,'Adapter HDMI to VGA dengan Audio',25,'Baik','Konverter display untuk menyambungkan \nperangkat modern ke proyektor lama.','hdmi_vga.jpg','2026-08-12 06:22:41','2026-08-12 06:22:41');
/*!40000 ALTER TABLE `alat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_pinjam`
--

DROP TABLE IF EXISTS `detail_pinjam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_pinjam` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint unsigned NOT NULL,
  `alat_id` bigint unsigned NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pinjam_peminjaman_id_foreign` (`peminjaman_id`),
  KEY `detail_pinjam_alat_id_foreign` (`alat_id`),
  CONSTRAINT `detail_pinjam_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pinjam_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_pinjam`
--

LOCK TABLES `detail_pinjam` WRITE;
/*!40000 ALTER TABLE `detail_pinjam` DISABLE KEYS */;
INSERT INTO `detail_pinjam` VALUES (1,1,1,2,'2026-08-12 06:45:17','2026-08-12 06:45:17'),(2,2,2,1,'2026-08-12 06:45:17','2026-08-12 06:45:17'),(3,3,3,1,'2026-08-12 06:45:17','2026-08-12 06:45:17'),(4,4,4,2,'2026-08-12 06:45:17','2026-08-12 06:45:17'),(5,5,5,3,'2026-08-12 06:45:17','2026-08-12 06:45:17');
/*!40000 ALTER TABLE `detail_pinjam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Jaringan & Konektivitas','2026-08-12 06:22:41','2026-08-12 06:22:41'),(2,'Multimedia & Audio Visual','2026-08-12 06:22:41','2026-08-12 06:22:41'),(3,'Perangkat Pemrosesan','2026-08-12 06:22:41','2026-08-12 06:22:41'),(4,'Perkakas & Elektronik','2026-08-12 06:22:41','2026-08-12 06:22:41'),(5,'Suku Cadang & Aksesoris','2026-08-12 06:22:41','2026-08-12 06:22:41');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `aktivitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_user_id_foreign` (`user_id`),
  CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES (11,1,'Melakukan import data master \nalat baru sebanyak 5 entitas.','2026-08-12 06:52:37','2026-08-12 06:52:37'),(12,2,'Menyetujui permohonan \npeminjaman ID #4.','2026-08-12 06:52:37','2026-08-12 06:52:37'),(13,3,'Mengajukan peminjaman alat \nbaru untuk kebutuhan praktik kelompok.','2026-08-12 06:52:37','2026-08-12 06:52:37'),(14,2,'Memproses pengembalian alat \ntelat untuk peminjaman ID #3 dan mengenakan denda.','2026-08-12 06:52:37','2026-08-12 06:52:37'),(15,1,'Mengubah konfigurasi hak \nakses aplikasi.','2026-08-12 06:52:37','2026-08-12 06:52:37');
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_05_000000_02_create_kategori_table',1),(5,'2026_08_06_054313_03_create_alat_table',1),(6,'2026_08_06_054454_04_create_peminjaman_table',1),(7,'2026_08_06_061628_05_create_detail_pinjam_table',1),(8,'2026_08_06_062618_06_create_pengembalian_table',1),(9,'2026_08_06_064831_07_create_log_aktivitas_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali_plan` date NOT NULL,
  `status` enum('diajukan','dipinjam','dikembalikan','telat') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_user_id_foreign` (`user_id`),
  CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peminjaman`
--

LOCK TABLES `peminjaman` WRITE;
/*!40000 ALTER TABLE `peminjaman` DISABLE KEYS */;
INSERT INTO `peminjaman` VALUES (1,3,'2026-06-01','2026-06-04','dikembalikan','2026-08-12 06:22:41','2026-08-12 06:22:41'),(2,4,'2026-06-02','2026-06-05','dikembalikan','2026-08-12 06:22:41','2026-08-12 06:22:41'),(3,5,'2026-06-03','2026-06-06','telat','2026-08-12 06:22:41','2026-08-12 06:22:41'),(4,3,'2026-06-08','2026-06-11','dipinjam','2026-08-12 06:22:41','2026-08-12 06:22:41'),(5,4,'2026-06-09','2026-06-12','diajukan','2026-08-12 06:22:41','2026-08-12 06:22:41');
/*!40000 ALTER TABLE `peminjaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengembalian`
--

DROP TABLE IF EXISTS `pengembalian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengembalian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `peminjaman_id` bigint unsigned NOT NULL,
  `tgl_kembali` date NOT NULL,
  `kondisi_kembali` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `denda` int NOT NULL DEFAULT '0',
  `petugas_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengembalian_peminjaman_id_foreign` (`peminjaman_id`),
  KEY `pengembalian_petugas_id_foreign` (`petugas_id`),
  CONSTRAINT `pengembalian_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengembalian_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengembalian`
--

LOCK TABLES `pengembalian` WRITE;
/*!40000 ALTER TABLE `pengembalian` DISABLE KEYS */;
INSERT INTO `pengembalian` VALUES (1,1,'2026-06-04','Lengkap dan Berfungsi Baik',0,2,'2026-08-12 06:47:28','2026-08-12 06:47:28'),(2,2,'2026-06-05','Lengkap dan Berfungsi Baik',0,2,'2026-08-12 06:47:28','2026-08-12 06:47:28'),(3,3,'2026-06-09','Lengkap, Casing Sedikit Tergores',30000,2,'2026-08-12 06:47:28','2026-08-12 06:47:28');
/*!40000 ALTER TABLE `pengembalian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','peminjaman') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peminjaman',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `foto_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Bagus Karim','admin@gmail.com','$2y$12$cz4pQme1nxUXJaZZ.9ekputLoPeravdXUax3ybrGpEfwiuJPHx0qu','admin','081234567890','Bandung, West Java',NULL,'2026-08-12 06:22:40','2026-08-12 06:22:40'),(2,'Arif Muhammad','petugas@gmail.com','$2y$12$ajcrJMSFUsLJvK0jVICWNeZItQVzUwAydSOUOAk8A0fQ4kz9lvR.W','petugas','082345678901','Baleendah, Bandung',NULL,'2026-08-12 06:22:41','2026-08-12 06:22:41'),(3,'Rian Setiawan','rian@gmail.com','$2y$12$u1OANk0.MzYVxZlXcp1qkemHYbGbIhIUO/awFD2.ScEvXmSZRbNYC','peminjaman','083456789012','Ciparay, Bandung',NULL,'2026-08-12 06:22:41','2026-08-12 06:22:41'),(4,'Siti Aminah','siti@gmail.com','$2y$12$rFRiA1T4BMKiHgh7JE8RP.4xVmUlxP67GOVXIypnbq5KbjFrdv9gy','peminjaman','084567890123','Dayeuhkolot, Bandung',NULL,'2026-08-12 06:22:41','2026-08-12 06:22:41'),(5,'Eka Pratama','eka@gmail.com','$2y$12$WR/4eehlxnDh/XS3f.SfPug7LKGkUm.HVS1vabAFIHOaLED9aIek.','peminjaman','085678901234','Banjaran, Bandung',NULL,'2026-08-12 06:22:41','2026-08-12 06:22:41');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-08-13  1:15:32
