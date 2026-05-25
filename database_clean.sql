-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: laravel
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('pharmacy-cache-elmer.customer@gmail.com|127.0.0.1','i:1;',1778538702),('pharmacy-cache-elmer.customer@gmail.com|127.0.0.1:timer','i:1778538702;',1778538702),('pharmacy-cache-elmer.staff@gmail.com|127.0.0.1','i:2;',1778517230),('pharmacy-cache-elmer.staff@gmail.com|127.0.0.1:timer','i:1778517230;',1778517230),('pharmacy-cache-superadmin@gmial.com|127.0.0.1','i:1;',1778538289),('pharmacy-cache-superadmin@gmial.com|127.0.0.1:timer','i:1778538289;',1778538289),('pharmacy-cache-wdwdwd.customer@gmail.com|127.0.0.1','i:1;',1778517844),('pharmacy-cache-wdwdwd.customer@gmail.com|127.0.0.1:timer','i:1778517844;',1778517844),('pharmacy-cache-wdwdwd@gmail.com|127.0.0.1','i:2;',1778517828),('pharmacy-cache-wdwdwd@gmail.com|127.0.0.1:timer','i:1778517828;',1778517828);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `medicines`
--

DROP TABLE IF EXISTS `medicines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `dosage_form` varchar(255) NOT NULL,
  `dosage_strength` decimal(8,2) DEFAULT NULL,
  `dosage_unit` varchar(255) DEFAULT NULL,
  `weight_grams` decimal(8,4) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) NOT NULL DEFAULT 10,
  `unit_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `storage_condition` varchar(255) DEFAULT NULL,
  `requires_prescription` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `side_effects` text DEFAULT NULL,
  `contraindications` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `supplied_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicines_supplied_by_foreign` (`supplied_by`),
  CONSTRAINT `medicines_supplied_by_foreign` FOREIGN KEY (`supplied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicines`
--

LOCK TABLES `medicines` WRITE;
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
INSERT INTO `medicines` VALUES (1,'Amoxicillin','Amoxicillin Trihydrate','Amoxil','Antibiotic','Capsule',500.00,'mg',0.6000,'GlaxoSmithKline','AMX-2024-001','2024-01-15','2026-01-15',198,30,8.50,12.00,'Room Temperature',1,'Broad-spectrum antibiotic used to treat bacterial infections.','Nausea, diarrhea, skin rash, allergic reactions.','Penicillin allergy, mononucleosis.','active',NULL,'2026-05-11 17:16:04','2026-05-11 18:21:33'),(2,'Paracetamol','Acetaminophen','Biogesic','Analgesic/Antipyretic','Tablet',500.00,'mg',0.5500,'Unilab','PCM-2024-002','2024-02-01','2027-02-01',500,50,2.00,4.50,'Room Temperature',0,'Used for relief of mild to moderate pain and fever.','Rare: liver damage with overdose.','Severe liver disease.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(3,'Metformin','Metformin Hydrochloride','Glucophage','Antidiabetic','Tablet',500.00,'mg',0.6500,'Merck','MET-2024-003','2024-03-01','2026-05-12',58,20,5.00,9.00,'Room Temperature',1,'First-line medication for type 2 diabetes.','Nausea, vomiting, diarrhea, lactic acidosis (rare).','Renal impairment, liver disease.','active',NULL,'2026-05-11 17:16:04','2026-05-11 18:25:13'),(4,'Vitamin C','Ascorbic Acid','Ceelin','Vitamin/Supplement','Tablet',500.00,'mg',0.5000,'Unilab','VTC-2024-004','2024-01-01','2026-12-31',300,40,3.00,6.00,'Room Temperature',0,'Essential vitamin for immune support and antioxidant protection.','Stomach upset at high doses.','Kidney stones history.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(5,'Losartan','Losartan Potassium','Cozaar','Antihypertensive','Tablet',50.00,'mg',0.4500,'Merck','LOS-2024-005','2024-04-01','2026-04-01',3,15,12.00,18.00,'Room Temperature',1,'Used to treat high blood pressure and protect kidneys in diabetics.','Dizziness, hyperkalemia, renal impairment.','Pregnancy, bilateral renal artery stenosis.','active',NULL,'2026-05-11 17:16:04','2026-05-11 18:22:38'),(6,'Salbutamol','Albuterol','Ventolin','Bronchodilator','Inhaler',100.00,'mcg',18.0000,'GSK','SAL-2024-006','2024-05-01','2026-05-01',45,10,150.00,220.00,'Room Temperature, away from heat',1,'Relieves bronchospasm in asthma and COPD.','Tremor, palpitations, headache.','Hypersensitivity to salbutamol.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(7,'Cetirizine','Cetirizine Hydrochloride','Zyrtec','Antihistamine','Tablet',10.00,'mg',0.4000,'UCB Pharma','CTZ-2024-007','2024-03-10','2027-03-10',150,25,5.00,9.00,'Room Temperature',0,'Used to relieve allergy symptoms such as runny nose, sneezing, and itchy eyes.','Drowsiness, dry mouth, headache.','Severe renal impairment.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(8,'Omeprazole','Omeprazole','Losec','Antacid/PPI','Capsule',20.00,'mg',0.5000,'AstraZeneca','OMP-2024-008','2024-02-15','2026-08-15',120,20,10.00,16.00,'Room Temperature',0,'Reduces stomach acid. Used for GERD, ulcers, and acid reflux.','Headache, nausea, diarrhea, abdominal pain.','Hypersensitivity to proton pump inhibitors.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(9,'Ibuprofen','Ibuprofen','Advil','NSAID/Analgesic','Tablet',400.00,'mg',0.5500,'Pfizer','IBU-2024-009','2024-04-20','2027-04-20',250,30,4.00,7.50,'Room Temperature',0,'Used for pain relief, fever reduction, and anti-inflammation.','Stomach upset, nausea, GI bleeding with prolonged use.','Peptic ulcer, renal impairment, aspirin allergy.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(10,'Amlodipine','Amlodipine Besylate','Norvasc','Antihypertensive','Tablet',5.00,'mg',0.4000,'Pfizer','AML-2024-010','2024-01-20','2026-07-20',180,25,8.00,14.00,'Room Temperature',1,'Calcium channel blocker used to treat high blood pressure and chest pain.','Swelling of ankles, flushing, dizziness, palpitations.','Severe hypotension, aortic stenosis.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04'),(11,'Diatabs','Attapulgite','Diatabs','Antidiarrheal','Tablet',750.00,'mg',0.8500,'Unilab','DIA-2024-011','2024-03-01','2027-03-01',198,30,3.50,6.00,'Room Temperature',0,'Used to treat diarrhea by absorbing excess fluid in the intestines.','Constipation with prolonged use.','Bowel obstruction.','active',NULL,'2026-05-11 17:16:04','2026-05-11 18:22:38'),(12,'Mefenamic Acid','Mefenamic Acid','Ponstan','NSAID/Analgesic','Capsule',500.00,'mg',0.6000,'Pfizer','MEF-2024-012','2024-04-01','2027-04-01',160,25,5.50,10.00,'Room Temperature',0,'Used for mild to moderate pain relief including menstrual pain and headache.','Stomach upset, nausea, diarrhea, GI bleeding.','Peptic ulcer, renal impairment, inflammatory bowel disease.','active',NULL,'2026-05-11 17:16:04','2026-05-11 17:16:04');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_05_004319_add_role_to_users_table',1),(5,'2026_05_05_004319_create_medicines_table',1),(6,'2026_05_05_004320_create_orders_table',1),(7,'2026_05_05_004321_create_order_items_table',1),(8,'2026_05_05_004322_create_supply_requests_table',1),(9,'2026_05_06_000002_add_dispensed_by_to_orders_table',1),(10,'2026_05_06_000003_add_approved_to_users_table',2),(11,'2026_05_06_000004_add_walkin_to_orders_table',3),(12,'2026_05_06_000005_create_stock_logs_table',4),(13,'2026_05_06_000006_add_status_to_stock_logs_table',5),(14,'2026_05_06_000007_create_user_removal_requests_table',6),(15,'2026_05_10_000001_create_procedures_and_triggers',7),(16,'2026_05_12_000001_create_views',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_medicine_id_foreign` (`medicine_id`),
  CONSTRAINT `order_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (137,137,1,2,12.00,24.00,'2026-05-11 18:20:32','2026-05-11 18:20:32'),(138,138,5,2,18.00,36.00,'2026-05-11 18:22:38','2026-05-11 18:22:38'),(139,138,11,2,6.00,12.00,'2026-05-11 18:22:38','2026-05-11 18:22:38');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `prescription_required` tinyint(1) NOT NULL DEFAULT 0,
  `prescription_file` varchar(255) DEFAULT NULL,
  `is_walkin` tinyint(1) NOT NULL DEFAULT 0,
  `walkin_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `dispensed_by` bigint(20) unsigned DEFAULT NULL,
  `dispensed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_dispensed_by_foreign` (`dispensed_by`),
  CONSTRAINT `orders_dispensed_by_foreign` FOREIGN KEY (`dispensed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,'ORD-GQ1OALWE',54.00,'dispensed','card','paid',NULL,0,NULL,1,'Walk-in Customer','2026-05-11 08:33:56','2026-05-11 08:33:56',4,'2026-05-11 08:33:56'),(2,6,'ORD-NMACKTS1',4.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-05-11 08:44:57','2026-05-11 08:46:15',4,'2026-05-11 08:46:15'),(3,6,'ORD-5K0NHQIQ',18.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-05-11 14:20:30','2026-05-11 14:21:31',4,'2026-05-11 14:21:30'),(4,NULL,'ORD-OHMCHNGX',12.00,'dispensed','cash','paid',NULL,0,NULL,1,'Walk-in Customer','2026-05-11 14:22:01','2026-05-11 14:22:01',4,'2026-05-11 14:22:01'),(5,NULL,'ORD-OLAFMBHK',28.00,'dispensed','cash','paid',NULL,1,NULL,1,'Maria Santos','2026-03-09 16:00:00','2026-03-09 16:00:00',4,'2026-03-09 16:00:00'),(6,NULL,'ORD-HTWPTK9J',1100.00,'dispensed','card','paid',NULL,1,NULL,1,'Maria Santos','2026-03-10 16:00:00','2026-03-10 16:00:00',4,'2026-03-10 16:00:00'),(7,NULL,'ORD-RX98QOHE',30.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Maria Reyes','2026-01-09 16:00:00','2026-01-09 16:00:00',4,'2026-01-09 16:00:00'),(8,8,'ORD-Q0XNYH6L',36.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-01-12 16:00:00','2026-01-12 16:00:00',4,'2026-01-12 16:00:00'),(9,NULL,'ORD-ZVCVFKNK',18.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Maria Reyes','2026-01-12 16:00:00','2026-01-12 16:00:00',4,'2026-01-12 16:00:00'),(10,NULL,'ORD-W00OPE0H',90.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Maria Cruz','2026-01-25 16:00:00','2026-01-25 16:00:00',4,'2026-01-25 16:00:00'),(11,9,'ORD-6ZD2ZJOD',36.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-01-23 16:00:00','2026-01-23 16:00:00',4,'2026-01-23 16:00:00'),(12,10,'ORD-SWMAO3HU',60.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-01-23 16:00:00','2026-01-23 16:00:00',4,'2026-01-23 16:00:00'),(13,NULL,'ORD-ROKGIRZF',36.00,'dispensed','card','paid',NULL,1,NULL,1,'Maria Ocampo','2026-03-14 16:00:00','2026-03-14 16:00:00',4,'2026-03-14 16:00:00'),(14,NULL,'ORD-HBLXZH7U',4.50,'dispensed','gcash','paid',NULL,0,NULL,1,'Maria Ocampo','2026-03-18 16:00:00','2026-03-18 16:00:00',4,'2026-03-18 16:00:00'),(15,11,'ORD-XLHMDQHM',36.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-03-13 16:00:00','2026-03-13 16:00:00',4,'2026-03-13 16:00:00'),(16,NULL,'ORD-T63GNI8C',18.00,'dispensed','cash','paid',NULL,0,NULL,1,'Maria Garcia','2026-04-06 16:00:00','2026-04-06 16:00:00',4,'2026-04-06 16:00:00'),(17,NULL,'ORD-GG3RW8ES',18.00,'dispensed','card','paid',NULL,1,NULL,1,'Maria Mendoza','2026-04-09 16:00:00','2026-04-09 16:00:00',4,'2026-04-09 16:00:00'),(18,14,'ORD-VHL7N6BJ',60.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-03-11 16:00:00','2026-03-11 16:00:00',4,'2026-03-11 16:00:00'),(19,NULL,'ORD-OH6YMAGP',1100.00,'dispensed','card','paid',NULL,1,NULL,1,'Maria Flores','2026-05-06 16:00:00','2026-05-06 16:00:00',4,'2026-05-06 16:00:00'),(20,NULL,'ORD-3YIGBVJV',18.00,'dispensed','card','paid',NULL,0,NULL,1,'Maria Flores','2026-05-05 16:00:00','2026-05-05 16:00:00',4,'2026-05-05 16:00:00'),(21,NULL,'ORD-4GUKIGTS',24.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Maria Villanueva','2026-03-25 16:00:00','2026-03-25 16:00:00',4,'2026-03-25 16:00:00'),(22,NULL,'ORD-2CX0WFJL',45.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Maria Villanueva','2026-03-26 16:00:00','2026-03-26 16:00:00',4,'2026-03-26 16:00:00'),(23,17,'ORD-V3XI57TW',54.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-04-20 16:00:00','2026-04-20 16:00:00',4,'2026-04-20 16:00:00'),(24,NULL,'ORD-QWTLL61Q',36.00,'dispensed','cash','paid',NULL,1,NULL,1,'Maria Ramos','2026-04-19 16:00:00','2026-04-19 16:00:00',4,'2026-04-19 16:00:00'),(25,17,'ORD-6FZAPSJN',42.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-04-21 16:00:00','2026-04-21 16:00:00',4,'2026-04-21 16:00:00'),(26,NULL,'ORD-DYYEU7PI',9.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Maria Aquino','2026-03-18 16:00:00','2026-03-18 16:00:00',4,'2026-03-18 16:00:00'),(27,18,'ORD-C3KAYGSS',72.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-03-20 16:00:00','2026-03-20 16:00:00',4,'2026-03-20 16:00:00'),(28,18,'ORD-EXMHAIHT',7.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-03-19 16:00:00','2026-03-19 16:00:00',4,'2026-03-19 16:00:00'),(29,NULL,'ORD-HNW2AOX1',18.00,'dispensed','cash','paid',NULL,0,NULL,1,'Maria DelaC ruz','2026-03-24 16:00:00','2026-03-24 16:00:00',4,'2026-03-24 16:00:00'),(30,NULL,'ORD-CYZMVQAD',18.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Maria DelaC ruz','2026-03-23 16:00:00','2026-03-23 16:00:00',4,'2026-03-23 16:00:00'),(31,NULL,'ORD-DQZF8QWQ',56.00,'dispensed','cash','paid',NULL,1,NULL,1,'Maria DelaC ruz','2026-03-20 16:00:00','2026-03-20 16:00:00',4,'2026-03-20 16:00:00'),(32,20,'ORD-DRQN527D',220.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-03-28 16:00:00','2026-03-28 16:00:00',4,'2026-03-28 16:00:00'),(33,NULL,'ORD-IHSPKXLG',36.00,'dispensed','cash','paid',NULL,1,NULL,1,'Maria Gonzales','2026-03-25 16:00:00','2026-03-25 16:00:00',4,'2026-03-25 16:00:00'),(34,NULL,'ORD-RQTAMM8S',30.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Maria Gonzales','2026-03-26 16:00:00','2026-03-26 16:00:00',4,'2026-03-26 16:00:00'),(35,21,'ORD-NJOFCYMJ',1100.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-04-18 16:00:00','2026-04-18 16:00:00',4,'2026-04-18 16:00:00'),(36,21,'ORD-KQLIXEUO',36.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-04-14 16:00:00','2026-04-14 16:00:00',4,'2026-04-14 16:00:00'),(37,NULL,'ORD-FU9EFJTU',45.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Maria Hernandez','2026-02-24 16:00:00','2026-02-24 16:00:00',4,'2026-02-24 16:00:00'),(38,22,'ORD-I9DNVMSL',18.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00',4,'2026-02-19 16:00:00'),(39,23,'ORD-HAXHCH4Y',90.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-03-24 16:00:00','2026-03-24 16:00:00',4,'2026-03-24 16:00:00'),(40,23,'ORD-XOABOKEM',36.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-03-24 16:00:00','2026-03-24 16:00:00',4,'2026-03-24 16:00:00'),(41,24,'ORD-ZTWQ2GFD',60.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-04-10 16:00:00','2026-04-10 16:00:00',4,'2026-04-10 16:00:00'),(42,NULL,'ORD-CDZM4S56',27.00,'dispensed','cash','paid',NULL,1,NULL,1,'Maria Castillo','2026-04-22 16:00:00','2026-04-22 16:00:00',4,'2026-04-22 16:00:00'),(43,NULL,'ORD-IAIFM2FB',9.00,'dispensed','cash','paid',NULL,0,NULL,1,'Maria Castillo','2026-04-25 16:00:00','2026-04-25 16:00:00',4,'2026-04-25 16:00:00'),(44,25,'ORD-5KJOPUSX',54.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-04-24 16:00:00','2026-04-24 16:00:00',4,'2026-04-24 16:00:00'),(45,26,'ORD-CNDZFGOG',9.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-02-18 16:00:00','2026-02-18 16:00:00',4,'2026-02-18 16:00:00'),(46,27,'ORD-AU35N5DP',18.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-04-26 16:00:00','2026-04-26 16:00:00',4,'2026-04-26 16:00:00'),(47,27,'ORD-5LLGTY2D',13.50,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-04-25 16:00:00','2026-04-25 16:00:00',4,'2026-04-25 16:00:00'),(48,27,'ORD-EZGE4AKA',880.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-04-25 16:00:00','2026-04-25 16:00:00',4,'2026-04-25 16:00:00'),(49,NULL,'ORD-INU9Y49X',660.00,'dispensed','cash','paid',NULL,1,NULL,1,'Juan Reyes','2026-02-01 16:00:00','2026-02-01 16:00:00',4,'2026-02-01 16:00:00'),(50,29,'ORD-JSFNREWW',12.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-03-11 16:00:00','2026-03-11 16:00:00',4,'2026-03-11 16:00:00'),(51,29,'ORD-I54JGRWE',45.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-03-09 16:00:00','2026-03-09 16:00:00',4,'2026-03-09 16:00:00'),(52,30,'ORD-7FGAY99P',18.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-01-19 16:00:00','2026-01-19 16:00:00',4,'2026-01-19 16:00:00'),(53,NULL,'ORD-CD1CENQ0',12.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Juan Ocampo','2026-05-13 16:00:00','2026-05-13 16:00:00',4,'2026-05-13 16:00:00'),(54,32,'ORD-EJVQBSME',880.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-01-19 16:00:00','2026-01-19 16:00:00',4,'2026-01-19 16:00:00'),(55,33,'ORD-ICZO1POY',36.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-01-04 16:00:00','2026-01-04 16:00:00',4,'2026-01-04 16:00:00'),(56,NULL,'ORD-57ZKIWZG',18.00,'dispensed','card','paid',NULL,1,NULL,1,'Juan Torres','2026-02-22 16:00:00','2026-02-22 16:00:00',4,'2026-02-22 16:00:00'),(57,NULL,'ORD-EPX2AMHE',72.00,'dispensed','card','paid',NULL,1,NULL,1,'Juan Torres','2026-02-23 16:00:00','2026-02-23 16:00:00',4,'2026-02-23 16:00:00'),(58,NULL,'ORD-QONUYADK',12.00,'dispensed','card','paid',NULL,0,NULL,1,'Juan Flores','2026-04-05 16:00:00','2026-04-05 16:00:00',4,'2026-04-05 16:00:00'),(59,NULL,'ORD-E5K8RSZL',16.00,'dispensed','cash','paid',NULL,0,NULL,1,'Juan Flores','2026-04-01 16:00:00','2026-04-01 16:00:00',4,'2026-04-01 16:00:00'),(60,NULL,'ORD-KTY0DSUU',54.00,'dispensed','card','paid',NULL,1,NULL,1,'Juan Villanueva','2026-01-26 16:00:00','2026-01-26 16:00:00',4,'2026-01-26 16:00:00'),(61,NULL,'ORD-X0TEMPZT',880.00,'dispensed','card','paid',NULL,1,NULL,1,'Juan Villanueva','2026-01-24 16:00:00','2026-01-24 16:00:00',4,'2026-01-24 16:00:00'),(62,37,'ORD-QDKWACEH',18.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-01-21 16:00:00','2026-01-21 16:00:00',4,'2026-01-21 16:00:00'),(63,38,'ORD-S1JVLD2M',70.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-04-02 16:00:00','2026-04-02 16:00:00',4,'2026-04-02 16:00:00'),(64,38,'ORD-OTPRU6JV',9.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-03-30 16:00:00','2026-03-30 16:00:00',4,'2026-03-30 16:00:00'),(65,NULL,'ORD-GB6YFVU5',64.00,'dispensed','card','paid',NULL,0,NULL,1,'Juan Aquino','2026-03-30 16:00:00','2026-03-30 16:00:00',4,'2026-03-30 16:00:00'),(66,39,'ORD-TCATVGDT',56.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-03-16 16:00:00','2026-03-16 16:00:00',4,'2026-03-16 16:00:00'),(67,NULL,'ORD-YPWZ7INV',36.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Juan Gonzales','2026-05-03 16:00:00','2026-05-03 16:00:00',4,'2026-05-03 16:00:00'),(68,40,'ORD-YEZTN3OT',15.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-05-06 16:00:00','2026-05-06 16:00:00',4,'2026-05-06 16:00:00'),(69,40,'ORD-R2ZYAW2P',18.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-05-03 16:00:00','2026-05-03 16:00:00',4,'2026-05-03 16:00:00'),(70,41,'ORD-UNTYWCKO',660.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-03-04 16:00:00','2026-03-04 16:00:00',4,'2026-03-04 16:00:00'),(71,NULL,'ORD-TF26M3VC',6.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Juan Hernandez','2026-04-07 16:00:00','2026-04-07 16:00:00',4,'2026-04-07 16:00:00'),(72,NULL,'ORD-DCQHKLGG',880.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Juan Perez','2026-02-11 16:00:00','2026-02-11 16:00:00',4,'2026-02-11 16:00:00'),(73,NULL,'ORD-CBY401BR',18.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Juan David','2026-01-21 16:00:00','2026-01-21 16:00:00',4,'2026-01-21 16:00:00'),(74,45,'ORD-L4EBMIHS',9.00,'dispensed','card','paid',NULL,0,NULL,0,NULL,'2026-04-14 16:00:00','2026-04-14 16:00:00',4,'2026-04-14 16:00:00'),(75,NULL,'ORD-6C8NDR1J',12.00,'dispensed','cash','paid',NULL,1,NULL,1,'Juan Morales','2026-04-06 16:00:00','2026-04-06 16:00:00',4,'2026-04-06 16:00:00'),(76,NULL,'ORD-6ZRMDZ3A',72.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Juan Morales','2026-04-08 16:00:00','2026-04-08 16:00:00',4,'2026-04-08 16:00:00'),(77,NULL,'ORD-AXNT432S',48.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Santos','2026-05-08 16:00:00','2026-05-08 16:00:00',4,'2026-05-08 16:00:00'),(78,NULL,'ORD-IZPUQWS1',18.00,'dispensed','cash','paid',NULL,1,NULL,1,'Jose Reyes','2026-03-16 16:00:00','2026-03-16 16:00:00',4,'2026-03-16 16:00:00'),(79,NULL,'ORD-TOEPE0TU',18.00,'dispensed','cash','paid',NULL,1,NULL,1,'Jose Reyes','2026-03-18 16:00:00','2026-03-18 16:00:00',4,'2026-03-18 16:00:00'),(80,49,'ORD-IMDL0EFM',36.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-04-06 16:00:00','2026-04-06 16:00:00',4,'2026-04-06 16:00:00'),(81,NULL,'ORD-RUMIO9SN',60.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Bautista','2026-04-05 16:00:00','2026-04-05 16:00:00',4,'2026-04-05 16:00:00'),(82,NULL,'ORD-8PAQOGUH',36.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Bautista','2026-04-04 16:00:00','2026-04-04 16:00:00',4,'2026-04-04 16:00:00'),(83,NULL,'ORD-M2PNDJQR',4.50,'dispensed','card','paid',NULL,0,NULL,1,'Jose Ocampo','2026-03-21 16:00:00','2026-03-21 16:00:00',4,'2026-03-21 16:00:00'),(84,NULL,'ORD-K5EID5IU',60.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Ocampo','2026-03-19 16:00:00','2026-03-19 16:00:00',4,'2026-03-19 16:00:00'),(85,NULL,'ORD-9EDLJ1AI',18.00,'dispensed','card','paid',NULL,1,NULL,1,'Jose Garcia','2026-03-02 16:00:00','2026-03-02 16:00:00',4,'2026-03-02 16:00:00'),(86,NULL,'ORD-C2Y9IB59',9.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Jose Garcia','2026-03-02 16:00:00','2026-03-02 16:00:00',4,'2026-03-02 16:00:00'),(87,52,'ORD-UA7X6KYY',22.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-02-25 16:00:00','2026-02-25 16:00:00',4,'2026-02-25 16:00:00'),(88,NULL,'ORD-LLVZJ5XQ',36.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Mendoza','2026-02-21 16:00:00','2026-02-21 16:00:00',4,'2026-02-21 16:00:00'),(89,54,'ORD-WQ1TGGDW',15.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-02-22 16:00:00','2026-02-22 16:00:00',4,'2026-02-22 16:00:00'),(90,54,'ORD-3EY8LKNP',72.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-02-18 16:00:00','2026-02-18 16:00:00',4,'2026-02-18 16:00:00'),(91,54,'ORD-1RTCM0RT',36.00,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00',4,'2026-02-19 16:00:00'),(92,55,'ORD-PE6PWVSS',9.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-02-08 16:00:00','2026-02-08 16:00:00',4,'2026-02-08 16:00:00'),(93,NULL,'ORD-I2QZE5A8',27.00,'dispensed','card','paid',NULL,1,NULL,1,'Jose Flores','2026-02-07 16:00:00','2026-02-07 16:00:00',4,'2026-02-07 16:00:00'),(94,NULL,'ORD-9JGQGIS6',1100.00,'dispensed','cash','paid',NULL,1,NULL,1,'Jose Villanueva','2026-02-01 16:00:00','2026-02-01 16:00:00',4,'2026-02-01 16:00:00'),(95,57,'ORD-UNIBAL1K',16.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-03-11 16:00:00','2026-03-11 16:00:00',4,'2026-03-11 16:00:00'),(96,57,'ORD-NWPYE4WC',45.00,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-03-16 16:00:00','2026-03-16 16:00:00',4,'2026-03-16 16:00:00'),(97,57,'ORD-V3CTARP1',80.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-03-16 16:00:00','2026-03-16 16:00:00',4,'2026-03-16 16:00:00'),(98,NULL,'ORD-ESPWVTIT',220.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Aquino','2026-03-24 16:00:00','2026-03-24 16:00:00',4,'2026-03-24 16:00:00'),(99,NULL,'ORD-DVVKREC5',4.50,'dispensed','card','paid',NULL,0,NULL,1,'Jose Aquino','2026-03-25 16:00:00','2026-03-25 16:00:00',4,'2026-03-25 16:00:00'),(100,NULL,'ORD-ENHOEM9V',660.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Aquino','2026-03-24 16:00:00','2026-03-24 16:00:00',4,'2026-03-24 16:00:00'),(101,59,'ORD-7ELAXTLL',4.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-02-04 16:00:00','2026-02-04 16:00:00',4,'2026-02-04 16:00:00'),(102,NULL,'ORD-WXOYI3FP',45.00,'dispensed','gcash','paid',NULL,0,NULL,1,'Jose DelaC ruz','2026-01-31 16:00:00','2026-01-31 16:00:00',4,'2026-01-31 16:00:00'),(103,60,'ORD-6BKK3OHE',22.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-02-22 16:00:00','2026-02-22 16:00:00',4,'2026-02-22 16:00:00'),(104,60,'ORD-VKN2K4XI',48.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-02-23 16:00:00','2026-02-23 16:00:00',4,'2026-02-23 16:00:00'),(105,NULL,'ORD-YRYZKVRH',9.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Gonzales','2026-02-23 16:00:00','2026-02-23 16:00:00',4,'2026-02-23 16:00:00'),(106,NULL,'ORD-HLEWKZIF',880.00,'dispensed','card','paid',NULL,1,NULL,1,'Jose Lopez','2026-01-22 16:00:00','2026-01-22 16:00:00',4,'2026-01-22 16:00:00'),(107,NULL,'ORD-XTFLNISP',24.00,'dispensed','cash','paid',NULL,0,NULL,1,'Jose Lopez','2026-01-24 16:00:00','2026-01-24 16:00:00',4,'2026-01-24 16:00:00'),(108,NULL,'ORD-N28VQZUF',440.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Jose Hernandez','2026-04-24 16:00:00','2026-04-24 16:00:00',4,'2026-04-24 16:00:00'),(109,NULL,'ORD-OORVHFDI',22.50,'dispensed','gcash','paid',NULL,0,NULL,1,'Jose Perez','2026-03-02 16:00:00','2026-03-02 16:00:00',4,'2026-03-02 16:00:00'),(110,NULL,'ORD-ICWUYRWS',36.00,'dispensed','cash','paid',NULL,1,NULL,1,'Jose Perez','2026-02-27 16:00:00','2026-02-27 16:00:00',4,'2026-02-27 16:00:00'),(111,64,'ORD-FEPRFPSD',54.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-02-15 16:00:00','2026-02-15 16:00:00',4,'2026-02-15 16:00:00'),(112,65,'ORD-I1KXVNPO',18.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-04-02 16:00:00','2026-04-02 16:00:00',4,'2026-04-02 16:00:00'),(113,66,'ORD-PMYMJFVJ',70.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-02-25 16:00:00','2026-02-25 16:00:00',4,'2026-02-25 16:00:00'),(114,NULL,'ORD-CRWNAC1O',9.00,'dispensed','card','paid',NULL,1,NULL,1,'Jose Morales','2026-02-28 16:00:00','2026-02-28 16:00:00',4,'2026-02-28 16:00:00'),(115,NULL,'ORD-GAMOHOVJ',660.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Ana Santos','2026-04-07 16:00:00','2026-04-07 16:00:00',4,'2026-04-07 16:00:00'),(116,68,'ORD-H5AEWLV9',13.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-05-09 16:00:00','2026-05-09 16:00:00',4,'2026-05-09 16:00:00'),(117,69,'ORD-IS62DREF',440.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-02-20 16:00:00','2026-02-20 16:00:00',4,'2026-02-20 16:00:00'),(118,NULL,'ORD-ZAYIUF0W',48.00,'dispensed','cash','paid',NULL,1,NULL,1,'Ana Cruz','2026-02-20 16:00:00','2026-02-20 16:00:00',4,'2026-02-20 16:00:00'),(119,69,'ORD-KZETYG3E',9.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00',4,'2026-02-19 16:00:00'),(120,70,'ORD-D9P4HQDI',27.00,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-01-17 16:00:00','2026-01-17 16:00:00',4,'2026-01-17 16:00:00'),(121,70,'ORD-YLCJFMUH',22.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-01-13 16:00:00','2026-01-13 16:00:00',4,'2026-01-13 16:00:00'),(122,70,'ORD-P2VVP2WD',14.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-01-13 16:00:00','2026-01-13 16:00:00',4,'2026-01-13 16:00:00'),(123,NULL,'ORD-CQLFM7VM',18.00,'dispensed','cash','paid',NULL,1,NULL,1,'Ana Ocampo','2026-04-19 16:00:00','2026-04-19 16:00:00',4,'2026-04-19 16:00:00'),(124,NULL,'ORD-ZXU3TNXK',36.00,'dispensed','cash','paid',NULL,1,NULL,1,'Ana Garcia','2026-01-23 16:00:00','2026-01-23 16:00:00',4,'2026-01-23 16:00:00'),(125,NULL,'ORD-MOMJNADK',12.00,'dispensed','cash','paid',NULL,0,NULL,1,'Ana Garcia','2026-01-25 16:00:00','2026-01-25 16:00:00',4,'2026-01-25 16:00:00'),(126,73,'ORD-DN3NAEPD',80.00,'dispensed','gcash','paid',NULL,0,NULL,0,NULL,'2026-02-24 16:00:00','2026-02-24 16:00:00',4,'2026-02-24 16:00:00'),(127,73,'ORD-AI6CPBI9',660.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-02-25 16:00:00','2026-02-25 16:00:00',4,'2026-02-25 16:00:00'),(128,NULL,'ORD-KRZQXC2X',7.50,'dispensed','card','paid',NULL,0,NULL,1,'Ana Mendoza','2026-02-26 16:00:00','2026-02-26 16:00:00',4,'2026-02-26 16:00:00'),(129,74,'ORD-YVVAP2GM',27.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-04-03 16:00:00','2026-04-03 16:00:00',4,'2026-04-03 16:00:00'),(130,74,'ORD-HEWNBCWH',45.00,'dispensed','cash','paid',NULL,1,NULL,0,NULL,'2026-04-03 16:00:00','2026-04-03 16:00:00',4,'2026-04-03 16:00:00'),(131,NULL,'ORD-GAAXKQX8',12.00,'dispensed','gcash','paid',NULL,1,NULL,1,'Ana Torres','2026-04-08 16:00:00','2026-04-08 16:00:00',4,'2026-04-08 16:00:00'),(132,75,'ORD-XLTRYNBZ',22.50,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-03-03 16:00:00','2026-03-03 16:00:00',4,'2026-03-03 16:00:00'),(133,NULL,'ORD-RTVA63AF',36.00,'dispensed','cash','paid',NULL,0,NULL,1,'Ana Flores','2026-03-04 16:00:00','2026-03-04 16:00:00',4,'2026-03-04 16:00:00'),(134,76,'ORD-XMDNEIFK',12.00,'dispensed','card','paid',NULL,1,NULL,0,NULL,'2026-05-04 16:00:00','2026-05-04 16:00:00',4,'2026-05-04 16:00:00'),(135,NULL,'ORD-UQDACPUZ',54.00,'dispensed','card','paid',NULL,1,NULL,1,'Ana Villanueva','2026-05-04 16:00:00','2026-05-04 16:00:00',4,'2026-05-04 16:00:00'),(136,76,'ORD-6GACGRQX',18.00,'dispensed','cash','paid',NULL,0,NULL,0,NULL,'2026-05-04 16:00:00','2026-05-04 16:00:00',4,'2026-05-04 16:00:00'),(137,6,'ORD-LZYMCMRS',24.00,'dispensed','gcash','paid',NULL,1,NULL,0,NULL,'2026-05-11 18:20:32','2026-05-11 18:21:33',4,'2026-05-11 18:21:33'),(138,NULL,'ORD-IIJ8GUHU',48.00,'dispensed','cash','paid',NULL,0,NULL,1,'Walk-in Customer','2026-05-11 18:22:38','2026-05-11 18:22:38',4,'2026-05-11 18:22:38');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('bH7A6bbF2EIEnOJpqUV60q0tI1XoZOzHyv0nDTZy',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3NqZVpzYmxzZ1lzQ2dSWHNUWjhSY2VPSTZnN05GclJsUlp3VlBZNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1778552079),('hbne0sIsOaMrH7XQ8WBkNuj4pqA9jsVXHjDiKo0K',77,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXg5bHJCc0JRMG5PbzJuOHJBVlNyc0dhR3ZNdWtaOTVBM3E1WEVBeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjc3O30=',1778552852);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_logs`
--

DROP TABLE IF EXISTS `stock_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `staff_id` bigint(20) unsigned NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `stock_before` int(11) NOT NULL,
  `stock_after` int(11) NOT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_logs_medicine_id_foreign` (`medicine_id`),
  KEY `stock_logs_staff_id_foreign` (`staff_id`),
  KEY `stock_logs_approved_by_foreign` (`approved_by`),
  CONSTRAINT `stock_logs_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_logs_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_logs_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_logs`
--

LOCK TABLES `stock_logs` WRITE;
/*!40000 ALTER TABLE `stock_logs` DISABLE KEYS */;
INSERT INTO `stock_logs` VALUES (3,3,4,'in',50,8,58,NULL,'2026-05-12',NULL,'approved','2026-05-11 18:24:07','2026-05-11 18:25:13',5,'2026-05-11 18:25:13');
/*!40000 ALTER TABLE `stock_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_removal_requests`
--

DROP TABLE IF EXISTS `user_removal_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_removal_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `target_user_id` bigint(20) unsigned NOT NULL,
  `requested_by` bigint(20) unsigned NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_removal_requests_target_user_id_foreign` (`target_user_id`),
  KEY `user_removal_requests_requested_by_foreign` (`requested_by`),
  KEY `user_removal_requests_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `user_removal_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_removal_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `user_removal_requests_target_user_id_foreign` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_removal_requests`
--

LOCK TABLES `user_removal_requests` WRITE;
/*!40000 ALTER TABLE `user_removal_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_removal_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'ewewew wewew','logely','wdwdwd@gmail.com','customer','2323232','Biao Escuela Tugbok',0,NULL,'$2y$12$6hkqqOWfTTz/L0pE5klBY.xTr9N31.DrALHdinepfyx0Dg.BT7qb6',NULL,'2026-05-10 04:03:05','2026-05-10 04:03:05'),(3,'Super Admin','superadmin','superadmin@gmail.com','superadmin',NULL,NULL,1,NULL,'$2y$12$qewWnTfhHsTny.TfB49dNu5pOYnAXrvLHFRhiTZRmrpciY04fkTyi',NULL,'2026-05-10 04:46:36','2026-05-10 04:46:36'),(4,'Selwyne Clyde Mahinay','Selwyne','selwyne.staff@gmail.com','staff','09631823431','Biao Escuela Tugbok',1,NULL,'$2y$12$HCrLOfqP0H0aHPU4UYkQHuxjm5lWAWKLThudYmuQD3X1.eJFlaYCy',NULL,'2026-05-11 06:39:22','2026-05-11 06:40:12'),(5,'Elmer Arellano','Elmer','elmer.admin@gmail.com','admin','092323232','Biao Escuela Tugbok',1,NULL,'$2y$12$1e3sjaRXQd4OkyyrhfhLCeccaretkuBqEnQt2JIfa3m0cV2Dg4rZ6',NULL,'2026-05-11 07:21:48','2026-05-11 07:22:47'),(6,'Seam Mondejar','Sean','sean.customer@gmail.com','customer','0973763773','Panabo, Davao City',1,NULL,'$2y$12$d4jq3YcBZrE4/Hv3zfNC/OYmROK4QksnuThkwBNQL0W1OBH2VQNM.',NULL,'2026-05-11 08:44:32','2026-05-11 08:44:32'),(7,'Maria Santos','maria1','maria.santos.customer@gmail.com','customer','09171000000','Toril, Davao City',1,NULL,'$2y$12$fozbDEWqrJanVTXrc43yXufkdnY0uJ4efvoGeyclyxkGARvlwEUBK',NULL,'2026-03-09 16:00:00','2026-03-09 16:00:00'),(8,'Maria Reyes','maria2','maria.reyes.customer@gmail.com','customer','09171000001','Toril, Davao City',1,NULL,'$2y$12$NwCQ6Z2mC36ZpYHV/JktbuN8lcSEaJtvEe/qUlV.P9/b851rFwaMm',NULL,'2026-01-08 16:00:00','2026-01-08 16:00:00'),(9,'Maria Cruz','maria3','maria.cruz.customer@gmail.com','customer','09171000002','Toril, Davao City',1,NULL,'$2y$12$/Y1EUS/lfAkb2mm/5nOXWuNu/fUls5bVXkC0X1O2tpmK0UHlynQkO',NULL,'2026-01-22 16:00:00','2026-01-22 16:00:00'),(10,'Maria Bautista','maria4','maria.bautista.customer@gmail.com','customer','09171000003','Toril, Davao City',1,NULL,'$2y$12$IhULPEI2N0G/F2rLGqiumu8i8EhJPaIQeZMKPSWooo1St0JkW7.86',NULL,'2026-01-22 16:00:00','2026-01-22 16:00:00'),(11,'Maria Ocampo','maria5','maria.ocampo.customer@gmail.com','customer','09171000004','Toril, Davao City',1,NULL,'$2y$12$Bgr.qaqZe.sF4vz/9kczV.PpR5wJ.QxqAZQqNuEVNwc2mhamWrENm',NULL,'2026-03-13 16:00:00','2026-03-13 16:00:00'),(12,'Maria Garcia','maria6','maria.garcia.customer@gmail.com','customer','09171000005','Toril, Davao City',1,NULL,'$2y$12$BqdzsX.ZMdH4IXivryOY..GWPDkSOiAe6a5saI4tgmWFuw8jK.rY2',NULL,'2026-04-04 16:00:00','2026-04-04 16:00:00'),(13,'Maria Mendoza','maria7','maria.mendoza.customer@gmail.com','customer','09171000006','Toril, Davao City',1,NULL,'$2y$12$24KIT1C.1UwS7TIOUJ5Zle.lTyZA04hiWJ3DuemQurRRMELx9aQri',NULL,'2026-04-07 16:00:00','2026-04-07 16:00:00'),(14,'Maria Torres','maria8','maria.torres.customer@gmail.com','customer','09171000007','Toril, Davao City',1,NULL,'$2y$12$lSeBhLbpu4hyuPwq4hY3xO46i5eGKGGleIoAR9CL0PL7uakUmBh0y',NULL,'2026-03-07 16:00:00','2026-03-07 16:00:00'),(15,'Maria Flores','maria9','maria.flores.customer@gmail.com','customer','09171000008','Toril, Davao City',1,NULL,'$2y$12$fi5zBN8LXo3DZ1XjBJqGce.al34ycIzDuHKu5yVM/.uwXxNZFTvHa',NULL,'2026-05-05 16:00:00','2026-05-05 16:00:00'),(16,'Maria Villanueva','maria10','maria.villanueva.customer@gmail.com','customer','09171000009','Toril, Davao City',1,NULL,'$2y$12$5p6oOODZhdhif2HfdIuYIezPjJK4Sjg7PQ6bREibUtzF1Fu5LZq02',NULL,'2026-03-21 16:00:00','2026-03-21 16:00:00'),(17,'Maria Ramos','maria11','maria.ramos.customer@gmail.com','customer','09171000010','Toril, Davao City',1,NULL,'$2y$12$ZF4uASnfAzPNeR69YnxQQO84NiYXchJ9PQR7HKZlt94sQpbw6egTq',NULL,'2026-04-19 16:00:00','2026-04-19 16:00:00'),(18,'Maria Aquino','maria12','maria.aquino.customer@gmail.com','customer','09171000011','Toril, Davao City',1,NULL,'$2y$12$0HufrUQmc7DrFLoHv0IthecK6rrS5075NitYEXsjLGaTjPKkTGAbu',NULL,'2026-03-17 16:00:00','2026-03-17 16:00:00'),(19,'Maria DelaC ruz','maria13','maria.delacruz.customer@gmail.com','customer','09171000012','Toril, Davao City',1,NULL,'$2y$12$Kv4dfyjuMrj74q1KJ6ZCJ.1R2lWOMt4aL1Uj4sNHRSn/rh.J/N1pK',NULL,'2026-03-19 16:00:00','2026-03-19 16:00:00'),(20,'Maria Gonzales','maria14','maria.gonzales.customer@gmail.com','customer','09171000013','Toril, Davao City',1,NULL,'$2y$12$CMy1nZiBQVtt5oZKgXGOYOXWGzSVDDk10RAYs432WgcmsPh0JsjaO',NULL,'2026-03-24 16:00:00','2026-03-24 16:00:00'),(21,'Maria Lopez','maria15','maria.lopez.customer@gmail.com','customer','09171000014','Toril, Davao City',1,NULL,'$2y$12$dMPzS8zGvQEGSKT9g2j3Lus2ZCLw6oeH1ikg4cCctKjaI3PJ43Rgm',NULL,'2026-04-14 16:00:00','2026-04-14 16:00:00'),(22,'Maria Hernandez','maria16','maria.hernandez.customer@gmail.com','customer','09171000015','Toril, Davao City',1,NULL,'$2y$12$5iflzSsE27F848.NR0B7r.A/9HhHcP.1s2aVmgNh30xqBlAFCSC6C',NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00'),(23,'Maria Perez','maria17','maria.perez.customer@gmail.com','customer','09171000016','Toril, Davao City',1,NULL,'$2y$12$gNgzmeJBGLTjOU0cdYDNBuaBQoOqtKHk2/oUfNLXSMFnT5cn8JhR6',NULL,'2026-03-19 16:00:00','2026-03-19 16:00:00'),(24,'Maria David','maria18','maria.david.customer@gmail.com','customer','09171000017','Toril, Davao City',1,NULL,'$2y$12$ZA7ThH0AtCGmXqewJuzxYuajR/IQXoOEczQ2EJvWgo26RsjoiAInC',NULL,'2026-04-07 16:00:00','2026-04-07 16:00:00'),(25,'Maria Castillo','maria19','maria.castillo.customer@gmail.com','customer','09171000018','Toril, Davao City',1,NULL,'$2y$12$kdfXr1WOCjqgKVPrsDWL6uK8MnyORcwMcIZ3SYr97BRMZojjK5Jhq',NULL,'2026-04-20 16:00:00','2026-04-20 16:00:00'),(26,'Maria Morales','maria20','maria.morales.customer@gmail.com','customer','09171000019','Toril, Davao City',1,NULL,'$2y$12$Gg4gSv8c2M.1WIiH18yz9OODUPwMVtXHqPwJrVxZ5OcRUPXsNpr/m',NULL,'2026-02-16 16:00:00','2026-02-16 16:00:00'),(27,'Juan Santos','juan21','juan.santos.customer@gmail.com','customer','09171000020','Toril, Davao City',1,NULL,'$2y$12$Ot..8SUVH6RFrbgrwX2n7.nw2ebi2v.D0MF0kqdE5rPbCjXFBxj1m',NULL,'2026-04-23 16:00:00','2026-04-23 16:00:00'),(28,'Juan Reyes','juan22','juan.reyes.customer@gmail.com','customer','09171000021','Toril, Davao City',1,NULL,'$2y$12$cljjUjFurqngsCVLFefBBOd42aNPawkQlMSPCiHRjuD0Jw4x9mo0.',NULL,'2026-01-30 16:00:00','2026-01-30 16:00:00'),(29,'Juan Cruz','juan23','juan.cruz.customer@gmail.com','customer','09171000022','Toril, Davao City',1,NULL,'$2y$12$FQwCQI5tvdFWFJVeh.ET4uobhXMFC24xAIQMDo7pGJGg9sRhotGIC',NULL,'2026-03-08 16:00:00','2026-03-08 16:00:00'),(30,'Juan Bautista','juan24','juan.bautista.customer@gmail.com','customer','09171000023','Toril, Davao City',1,NULL,'$2y$12$Ke7oSjPSmnNeAx1uJT5/eu6zZ2aDlCW.zYcwo0pYwgvCHYqvU.Tnm',NULL,'2026-01-15 16:00:00','2026-01-15 16:00:00'),(31,'Juan Ocampo','juan25','juan.ocampo.customer@gmail.com','customer','09171000024','Toril, Davao City',1,NULL,'$2y$12$ZQ/2d867NKijtnOEP3xfiOzsxMbprLeor10IEcktjvUbC2Mbids0i',NULL,'2026-05-09 16:00:00','2026-05-09 16:00:00'),(32,'Juan Garcia','juan26','juan.garcia.customer@gmail.com','customer','09171000025','Toril, Davao City',1,NULL,'$2y$12$/aERIm24oNFFLrl1tTcviu6AYvLW/00Tct2ljuAeMSYFRaCv28FNa',NULL,'2026-01-18 16:00:00','2026-01-18 16:00:00'),(33,'Juan Mendoza','juan27','juan.mendoza.customer@gmail.com','customer','09171000026','Toril, Davao City',1,NULL,'$2y$12$EJg8KWoLSgokXkDBGI0SP.TDCpziG7f5eQbuW1MAngU1MPrDD8DQK',NULL,'2026-01-01 16:00:00','2026-01-01 16:00:00'),(34,'Juan Torres','juan28','juan.torres.customer@gmail.com','customer','09171000027','Toril, Davao City',1,NULL,'$2y$12$i46SF/NmxS32lU26f62mBOcym6egLVSclGDG9EQQThJfs/cZda76u',NULL,'2026-02-20 16:00:00','2026-02-20 16:00:00'),(35,'Juan Flores','juan29','juan.flores.customer@gmail.com','customer','09171000028','Toril, Davao City',1,NULL,'$2y$12$ThguBgW5YRWBivctrno2jOCC7abspTi4wVgVnyUPfC0ZPG7SCXa4C',NULL,'2026-03-31 16:00:00','2026-03-31 16:00:00'),(36,'Juan Villanueva','juan30','juan.villanueva.customer@gmail.com','customer','09171000029','Toril, Davao City',1,NULL,'$2y$12$G0J5dOZn6eouqjgHZ3czPeyKuiMgNZAV2tTxR2.AtJfxHrhjiUbIO',NULL,'2026-01-22 16:00:00','2026-01-22 16:00:00'),(37,'Juan Ramos','juan31','juan.ramos.customer@gmail.com','customer','09171000030','Toril, Davao City',1,NULL,'$2y$12$919oWCXllSdfUnFx25rT.uVPR8ngHianTpI22ks4nDTQy1gBmlwx6',NULL,'2026-01-19 16:00:00','2026-01-19 16:00:00'),(38,'Juan Aquino','juan32','juan.aquino.customer@gmail.com','customer','09171000031','Toril, Davao City',1,NULL,'$2y$12$6AQknWA5GVIHdfXNJKeLteENdK694Ec1rd6LtcNFiQp09Y0p7xCam',NULL,'2026-03-28 16:00:00','2026-03-28 16:00:00'),(39,'Juan DelaC ruz','juan33','juan.delacruz.customer@gmail.com','customer','09171000032','Toril, Davao City',1,NULL,'$2y$12$tBkvzvM1U2102xtwd.pWwuSSnBK8/WgGFasLjbpRxXHCgID5iDuFy',NULL,'2026-03-14 16:00:00','2026-03-14 16:00:00'),(40,'Juan Gonzales','juan34','juan.gonzales.customer@gmail.com','customer','09171000033','Toril, Davao City',1,NULL,'$2y$12$XqEbJvtZNxGXIW2dOvfnBe68pjWcKxj6SQU8OnvsA1yta.Rk1ReSK',NULL,'2026-05-03 16:00:00','2026-05-03 16:00:00'),(41,'Juan Lopez','juan35','juan.lopez.customer@gmail.com','customer','09171000034','Toril, Davao City',1,NULL,'$2y$12$UIKYfOCzHhEoi/szGUyXkewemyjmgV1Qm0pqoQzuECYvtf09TztFy',NULL,'2026-03-02 16:00:00','2026-03-02 16:00:00'),(42,'Juan Hernandez','juan36','juan.hernandez.customer@gmail.com','customer','09171000035','Toril, Davao City',1,NULL,'$2y$12$7q5Wc2eQy6LjT7IleGSQgut.Wv95nUNCCA8Vo86XKdq/L97.m7njm',NULL,'2026-04-07 16:00:00','2026-04-07 16:00:00'),(43,'Juan Perez','juan37','juan.perez.customer@gmail.com','customer','09171000036','Toril, Davao City',1,NULL,'$2y$12$3h0hElTiQZRs2BS4PPgYNOV8b1JetoJHIzFFjzZAY9yBj2GVExPj.',NULL,'2026-02-09 16:00:00','2026-02-09 16:00:00'),(44,'Juan David','juan38','juan.david.customer@gmail.com','customer','09171000037','Toril, Davao City',1,NULL,'$2y$12$K8zTr3egWBLWu6u7N87KB.rjzdsA7cW25xCyReDiVGOj/vOJ3VMTK',NULL,'2026-01-16 16:00:00','2026-01-16 16:00:00'),(45,'Juan Castillo','juan39','juan.castillo.customer@gmail.com','customer','09171000038','Toril, Davao City',1,NULL,'$2y$12$Nnj/g9SMVaylABRoMd5.ROtAUbES4FkN2h2HYfeubRZrT5vNj00zK',NULL,'2026-04-12 16:00:00','2026-04-12 16:00:00'),(46,'Juan Morales','juan40','juan.morales.customer@gmail.com','customer','09171000039','Toril, Davao City',1,NULL,'$2y$12$9nO5cVte.MlogiinUS447e4MQFH2oO4L9.1xt2W.1hw0cpU92Vh56',NULL,'2026-04-04 16:00:00','2026-04-04 16:00:00'),(47,'Jose Santos','jose41','jose.santos.customer@gmail.com','customer','09171000040','Toril, Davao City',1,NULL,'$2y$12$kAB1rGv3Fw/3/m6LDc3rgOrUfk8u7RLND1QrZ4hjC7IBUG7XsizRu',NULL,'2026-05-08 16:00:00','2026-05-08 16:00:00'),(48,'Jose Reyes','jose42','jose.reyes.customer@gmail.com','customer','09171000041','Toril, Davao City',1,NULL,'$2y$12$PgSrzHt8l5FIBsJBsZHEqOx/mgPUaj6VpUSjTCOKYylk20BsmmWwG',NULL,'2026-03-16 16:00:00','2026-03-16 16:00:00'),(49,'Jose Cruz','jose43','jose.cruz.customer@gmail.com','customer','09171000042','Toril, Davao City',1,NULL,'$2y$12$WTrBHZjFaTgrkZGHQH4Gw.XNXLqwKTQ3cFATSDpCMnH2ex6zKXQXm',NULL,'2026-04-05 16:00:00','2026-04-05 16:00:00'),(50,'Jose Bautista','jose44','jose.bautista.customer@gmail.com','customer','09171000043','Toril, Davao City',1,NULL,'$2y$12$JkPycNZiXfEwiUNsRdMtcObmGgsm5uaQ4SGbrmZMffAQEWksi975a',NULL,'2026-04-04 16:00:00','2026-04-04 16:00:00'),(51,'Jose Ocampo','jose45','jose.ocampo.customer@gmail.com','customer','09171000044','Toril, Davao City',1,NULL,'$2y$12$I4vYbcNioDgSYCkqrP.KUuZycx6L1kgEf5OcnP2m72chM/6t37c4G',NULL,'2026-03-18 16:00:00','2026-03-18 16:00:00'),(52,'Jose Garcia','jose46','jose.garcia.customer@gmail.com','customer','09171000045','Toril, Davao City',1,NULL,'$2y$12$.qT12AcRX10OpVnmq8j1I.xEzxomQWj0zhRUe2614rspy9WdmP3Tu',NULL,'2026-02-25 16:00:00','2026-02-25 16:00:00'),(53,'Jose Mendoza','jose47','jose.mendoza.customer@gmail.com','customer','09171000046','Toril, Davao City',1,NULL,'$2y$12$qoapwSMID7Z.NiHCzhgM4.YPkicQWw8xoMs/VutbOAK6sHXOclHe.',NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00'),(54,'Jose Torres','jose48','jose.torres.customer@gmail.com','customer','09171000047','Toril, Davao City',1,NULL,'$2y$12$MqNzpjxuF8q3BiXxbL8uIuMg8s59os/57Iat779XlXZPhR7m7jdM6',NULL,'2026-02-18 16:00:00','2026-02-18 16:00:00'),(55,'Jose Flores','jose49','jose.flores.customer@gmail.com','customer','09171000048','Toril, Davao City',1,NULL,'$2y$12$dUjQMZQiaO1QkSgmUeBZReFIMSoaM5OBHMvfNnnalPNzciBcxdGRS',NULL,'2026-02-04 16:00:00','2026-02-04 16:00:00'),(56,'Jose Villanueva','jose50','jose.villanueva.customer@gmail.com','customer','09171000049','Toril, Davao City',1,NULL,'$2y$12$tdgYY8rjjqW.POxsDtxY2OYRMF2LTYwdx2qnjPQOws4BbwCo24Vf2',NULL,'2026-01-27 16:00:00','2026-01-27 16:00:00'),(57,'Jose Ramos','jose51','jose.ramos.customer@gmail.com','customer','09171000050','Toril, Davao City',1,NULL,'$2y$12$lAlqiBeddaJ6gJE5M2Xw7.p23TEDpCv5HuOnQndn/wsywnHRS5Aei',NULL,'2026-03-11 16:00:00','2026-03-11 16:00:00'),(58,'Jose Aquino','jose52','jose.aquino.customer@gmail.com','customer','09171000051','Toril, Davao City',1,NULL,'$2y$12$Ez5QCKlUyUKkYVUXEvNBHuElIC7bVgmstCQcWR3BIWuobv7Sv4rs.',NULL,'2026-03-20 16:00:00','2026-03-20 16:00:00'),(59,'Jose DelaC ruz','jose53','jose.delacruz.customer@gmail.com','customer','09171000052','Toril, Davao City',1,NULL,'$2y$12$c8F4jEFyB4kHtprt8y5vNuIsPDYoGta7ghujpCaKaZy9dnWHgs00i',NULL,'2026-01-31 16:00:00','2026-01-31 16:00:00'),(60,'Jose Gonzales','jose54','jose.gonzales.customer@gmail.com','customer','09171000053','Toril, Davao City',1,NULL,'$2y$12$6fN9e0j2WGcENAJrgWau8ezlu7E44AqAipn3/RauhwQ2hqmP1KAHG',NULL,'2026-02-19 16:00:00','2026-02-19 16:00:00'),(61,'Jose Lopez','jose55','jose.lopez.customer@gmail.com','customer','09171000054','Toril, Davao City',1,NULL,'$2y$12$8Qjm2L1F1yW9rbqQBcAAyuUEj8pJW6NFef2iHVwdaUJ61tbFQkR4i',NULL,'2026-01-21 16:00:00','2026-01-21 16:00:00'),(62,'Jose Hernandez','jose56','jose.hernandez.customer@gmail.com','customer','09171000055','Toril, Davao City',1,NULL,'$2y$12$KeMDBmMJvcUqzURJ.Nxv3.8z9ju0q4wzZhK3Mp0DxLlJUBuu5E./e',NULL,'2026-04-21 16:00:00','2026-04-21 16:00:00'),(63,'Jose Perez','jose57','jose.perez.customer@gmail.com','customer','09171000056','Toril, Davao City',1,NULL,'$2y$12$A0nxo1B8gVGLFs90/PNeXejfYB/7fTaUsXX2ra0WABqpAv/Fdm3Fq',NULL,'2026-02-26 16:00:00','2026-02-26 16:00:00'),(64,'Jose David','jose58','jose.david.customer@gmail.com','customer','09171000057','Toril, Davao City',1,NULL,'$2y$12$4RcVFlQq3kYx0wf0dUPtpO4QK.KfIClld41qIDYdLktVEVuz6tuEW',NULL,'2026-02-11 16:00:00','2026-02-11 16:00:00'),(65,'Jose Castillo','jose59','jose.castillo.customer@gmail.com','customer','09171000058','Toril, Davao City',1,NULL,'$2y$12$WQHFq0OnX8sUNFTlvajfz.L/X45zAgmYEzM12kMKFlNCYDJY59LG.',NULL,'2026-03-28 16:00:00','2026-03-28 16:00:00'),(66,'Jose Morales','jose60','jose.morales.customer@gmail.com','customer','09171000059','Toril, Davao City',1,NULL,'$2y$12$UTgUERMlrnZ2TXawUue3Gujdc1uDGPjEiySSv4L6T6cTKjaXMAc9G',NULL,'2026-02-23 16:00:00','2026-02-23 16:00:00'),(67,'Ana Santos','ana61','ana.santos.customer@gmail.com','customer','09171000060','Toril, Davao City',1,NULL,'$2y$12$1hZ7K686JmmS76zHftlYNekeif931JVW7bIzj/q/sbskrktXqKcT.',NULL,'2026-04-05 16:00:00','2026-04-05 16:00:00'),(68,'Ana Reyes','ana62','ana.reyes.customer@gmail.com','customer','09171000061','Toril, Davao City',1,NULL,'$2y$12$8syHj6VSIXRB/ZAZO3dQhu0f/VZ4.TEte5R/5Cg2Am9Idl2L7Mw96',NULL,'2026-05-04 16:00:00','2026-05-04 16:00:00'),(69,'Ana Cruz','ana63','ana.cruz.customer@gmail.com','customer','09171000062','Toril, Davao City',1,NULL,'$2y$12$rS.5zK0DBKupT5X1F22rm.vBPeaIFCSZ7j.jNAwlK33obdzFLsv7y',NULL,'2026-02-16 16:00:00','2026-02-16 16:00:00'),(70,'Ana Bautista','ana64','ana.bautista.customer@gmail.com','customer','09171000063','Toril, Davao City',1,NULL,'$2y$12$NNU/73N7KCW3ChMHwmX9rOqC5NeJs4UbF.hg4nWhGBjVdjYDcfRmu',NULL,'2026-01-13 16:00:00','2026-01-13 16:00:00'),(71,'Ana Ocampo','ana65','ana.ocampo.customer@gmail.com','customer','09171000064','Toril, Davao City',1,NULL,'$2y$12$y4LeYlH.jABuOIztQr/XcuFYY/N9qTKtHzpCa2Zp6flh1vnrODw6q',NULL,'2026-04-15 16:00:00','2026-04-15 16:00:00'),(72,'Ana Garcia','ana66','ana.garcia.customer@gmail.com','customer','09171000065','Toril, Davao City',1,NULL,'$2y$12$DYAbmL3D4Pysi/nEcSpoOezv7wH36VoojgLPE44YGlCM3T/3lMPMu',NULL,'2026-01-22 16:00:00','2026-01-22 16:00:00'),(73,'Ana Mendoza','ana67','ana.mendoza.customer@gmail.com','customer','09171000066','Toril, Davao City',1,NULL,'$2y$12$zT/gVg/InSH/7PTyw/oCOO9MdBJehonZlmhauRcB3QzeqculkTsbC',NULL,'2026-02-21 16:00:00','2026-02-21 16:00:00'),(74,'Ana Torres','ana68','ana.torres.customer@gmail.com','customer','09171000067','Toril, Davao City',1,NULL,'$2y$12$yciatJdnuH7gT/whVkHbOOzNQ7CwWOYBykBaTuk9aov0fXmrIQUuu',NULL,'2026-04-03 16:00:00','2026-04-03 16:00:00'),(75,'Ana Flores','ana69','ana.flores.customer@gmail.com','customer','09171000068','Toril, Davao City',1,NULL,'$2y$12$XWxF4Dg2oCTG71vSA1m3TO52y.KMM4yhVpAVpYrY6O2FPmwg1fpjC',NULL,'2026-02-27 16:00:00','2026-02-27 16:00:00'),(76,'Ana Villanueva','ana70','ana.villanueva.customer@gmail.com','customer','09171000069','Toril, Davao City',1,NULL,'$2y$12$gis3Pvur24opA.imeKsOg.SxixVwvtjDiXpFMlOLFI.fwNlW4MT/.',NULL,'2026-05-01 16:00:00','2026-05-01 16:00:00'),(77,'Maria Santos','sasa','maria.admin@gmail.com','admin','23232323','Biao Escuela Tugbok',1,NULL,'$2y$12$TY4sbtnNAoPuOqlvPmyMqeVAEXMRjNcKll6k7KHf6dxIPXGW7m3DK',NULL,'2026-05-11 18:26:01','2026-05-11 18:27:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_low_stock_medicines`
--

DROP TABLE IF EXISTS `view_low_stock_medicines`;
/*!50001 DROP VIEW IF EXISTS `view_low_stock_medicines`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_low_stock_medicines` AS SELECT
 1 AS `id`,
  1 AS `name`,
  1 AS `generic_name`,
  1 AS `brand`,
  1 AS `category`,
  1 AS `dosage_form`,
  1 AS `dosage_strength`,
  1 AS `dosage_unit`,
  1 AS `stock_quantity`,
  1 AS `reorder_level`,
  1 AS `expiry_date`,
  1 AS `status` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_order_summary`
--

DROP TABLE IF EXISTS `view_order_summary`;
/*!50001 DROP VIEW IF EXISTS `view_order_summary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_order_summary` AS SELECT
 1 AS `id`,
  1 AS `order_number`,
  1 AS `customer_name`,
  1 AS `total_amount`,
  1 AS `payment_method`,
  1 AS `payment_status`,
  1 AS `status`,
  1 AS `is_walkin`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_stock_log_history`
--

DROP TABLE IF EXISTS `view_stock_log_history`;
/*!50001 DROP VIEW IF EXISTS `view_stock_log_history`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_stock_log_history` AS SELECT
 1 AS `id`,
  1 AS `medicine_name`,
  1 AS `dosage_strength`,
  1 AS `dosage_unit`,
  1 AS `staff_name`,
  1 AS `approved_by_name`,
  1 AS `type`,
  1 AS `quantity`,
  1 AS `stock_before`,
  1 AS `stock_after`,
  1 AS `status`,
  1 AS `approved_at`,
  1 AS `created_at` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_low_stock_medicines`
--

/*!50001 DROP VIEW IF EXISTS `view_low_stock_medicines`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_low_stock_medicines` AS select `medicines`.`id` AS `id`,`medicines`.`name` AS `name`,`medicines`.`generic_name` AS `generic_name`,`medicines`.`brand` AS `brand`,`medicines`.`category` AS `category`,`medicines`.`dosage_form` AS `dosage_form`,`medicines`.`dosage_strength` AS `dosage_strength`,`medicines`.`dosage_unit` AS `dosage_unit`,`medicines`.`stock_quantity` AS `stock_quantity`,`medicines`.`reorder_level` AS `reorder_level`,`medicines`.`expiry_date` AS `expiry_date`,`medicines`.`status` AS `status` from `medicines` where `medicines`.`stock_quantity` <= `medicines`.`reorder_level` and `medicines`.`status` = 'active' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_order_summary`
--

/*!50001 DROP VIEW IF EXISTS `view_order_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_order_summary` AS select `o`.`id` AS `id`,`o`.`order_number` AS `order_number`,case when `o`.`is_walkin` = 1 then `o`.`walkin_name` else `u`.`name` end AS `customer_name`,`o`.`total_amount` AS `total_amount`,`o`.`payment_method` AS `payment_method`,`o`.`payment_status` AS `payment_status`,`o`.`status` AS `status`,`o`.`is_walkin` AS `is_walkin`,`o`.`created_at` AS `created_at` from (`orders` `o` left join `users` `u` on(`u`.`id` = `o`.`user_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_stock_log_history`
--

/*!50001 DROP VIEW IF EXISTS `view_stock_log_history`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_stock_log_history` AS select `sl`.`id` AS `id`,`m`.`name` AS `medicine_name`,`m`.`dosage_strength` AS `dosage_strength`,`m`.`dosage_unit` AS `dosage_unit`,`s`.`name` AS `staff_name`,`a`.`name` AS `approved_by_name`,`sl`.`type` AS `type`,`sl`.`quantity` AS `quantity`,`sl`.`stock_before` AS `stock_before`,`sl`.`stock_after` AS `stock_after`,`sl`.`status` AS `status`,`sl`.`approved_at` AS `approved_at`,`sl`.`created_at` AS `created_at` from (((`stock_logs` `sl` join `medicines` `m` on(`m`.`id` = `sl`.`medicine_id`)) join `users` `s` on(`s`.`id` = `sl`.`staff_id`)) left join `users` `a` on(`a`.`id` = `sl`.`approved_by`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-25 14:59:24
