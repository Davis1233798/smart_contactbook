-- MySQL dump 10.13  Distrib 8.0.33, for macos13.3 (arm64)
--
-- Host: db-mysql-nyc3-69353-do-user-15481030-0.c.db.ondigitalocean.com    Database: defaultdb
-- ------------------------------------------------------
-- Server version	8.0.30

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '55fb9704-b2df-11ee-a601-ead29b1dcc6f:1-65,
79c95ef9-b3b8-11ee-b930-aa0dae97ee40:1-15,
c51325e9-a6ec-11ee-bc6b-928d44152249:1-163,
d03de1c4-b28c-11ee-a6c7-6e545b85a4f5:1-31,
f402fe16-b3ac-11ee-91dc-9abea904abc7:1-31';

--
-- Table structure for table `attachmentable`
--

DROP TABLE IF EXISTS `attachmentable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachmentable` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `attachmentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachmentable_id` int unsigned NOT NULL,
  `attachment_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attachmentable_attachmentable_type_attachmentable_id_index` (`attachmentable_type`,`attachmentable_id`),
  KEY `attachmentable_attachment_id_foreign` (`attachment_id`),
  CONSTRAINT `attachmentable_attachment_id_foreign` FOREIGN KEY (`attachment_id`) REFERENCES `attachments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachmentable`
--

LOCK TABLES `attachmentable` WRITE;
/*!40000 ALTER TABLE `attachmentable` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachmentable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint NOT NULL DEFAULT '0',
  `sort` int NOT NULL DEFAULT '0',
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alt` text COLLATE utf8mb4_unicode_ci,
  `hash` text COLLATE utf8mb4_unicode_ci,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `user_id` bigint unsigned DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachments`
--

LOCK TABLES `attachments` WRITE;
/*!40000 ALTER TABLE `attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_notification_contents`
--

DROP TABLE IF EXISTS `class_notification_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_notification_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `class_notification_id` bigint unsigned DEFAULT NULL COMMENT '班級通知識別碼',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_notification_contents`
--

LOCK TABLES `class_notification_contents` WRITE;
/*!40000 ALTER TABLE `class_notification_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `class_notification_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_notifications`
--

DROP TABLE IF EXISTS `class_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_class_id` bigint unsigned DEFAULT NULL COMMENT '班級ID',
  `contact_book_id` bigint unsigned DEFAULT NULL COMMENT '聯絡簿ID',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_notifications`
--

LOCK TABLES `class_notifications` WRITE;
/*!40000 ALTER TABLE `class_notifications` DISABLE KEYS */;
INSERT INTO `class_notifications` VALUES (1,1,1,'明天是校運會，請同學們穿著運動服裝。',NULL,NULL),(2,1,1,'下週一將進行月考，請同學們準備好所有科目。',NULL,NULL),(3,1,1,'學校將舉辦科學展覽，請各班準備展示項目。',NULL,NULL);
/*!40000 ALTER TABLE `class_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communications`
--

DROP TABLE IF EXISTS `communications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `communications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communications`
--

LOCK TABLES `communications` WRITE;
/*!40000 ALTER TABLE `communications` DISABLE KEYS */;
/*!40000 ALTER TABLE `communications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_books`
--

DROP TABLE IF EXISTS `contact_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `communication` text COLLATE utf8mb4_unicode_ci COMMENT '親師溝通',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `remark` text COLLATE utf8mb4_unicode_ci COMMENT '備註',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_sent` tinyint(1) DEFAULT NULL COMMENT '是否已寄出',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_books`
--

LOCK TABLES `contact_books` WRITE;
/*!40000 ALTER TABLE `contact_books` DISABLE KEYS */;
INSERT INTO `contact_books` VALUES (1,'與家長討論學生的數學進度','明天是校運會，請同學們穿著運動服裝。','家長表示會在家輔導',NULL,NULL,NULL),(2,'關於近期的班級活動','下週一將進行月考，請同學們準備好所有科目。','家長已經知悉並確認參加',NULL,NULL,NULL),(3,'學生英語學習進展','學校將舉辦科學展覽，請準備展示項目。','建議家長鼓勵學生多看英語書籍',NULL,NULL,NULL);
/*!40000 ALTER TABLE `contact_books` ENABLE KEYS */;
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
-- Table structure for table `line_notifies`
--

DROP TABLE IF EXISTS `line_notifies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `line_notifies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '資料識別碼',
  `code` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '認證token',
  `state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '檢查碼',
  `remark` text COLLATE utf8mb4_unicode_ci COMMENT '備註資訊',
  `updated_at` datetime NOT NULL COMMENT '最後更新',
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最後更新人',
  `created_at` datetime NOT NULL COMMENT '創建時間',
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '創建人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `line_notifies`
--

LOCK TABLES `line_notifies` WRITE;
/*!40000 ALTER TABLE `line_notifies` DISABLE KEYS */;
/*!40000 ALTER TABLE `line_notifies` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2015_04_12_000000_create_orchid_users_table',1),(4,'2015_10_19_214424_create_orchid_roles_table',1),(5,'2015_10_19_214425_create_orchid_role_users_table',1),(6,'2016_08_07_125128_create_orchid_attachmentstable_table',1),(7,'2017_09_17_125801_create_notifications_table',1),(8,'2019_08_19_000000_create_failed_jobs_table',1),(9,'2019_12_14_000001_create_personal_access_tokens_table',1),(10,'2023_12_22_160836_create_school_classes_table',1),(11,'2023_12_22_235024_create_students_table',1),(12,'2023_12_22_235046_create_scores_table',1),(13,'2023_12_23_001912_create_parent_infos_table',1),(14,'2023_12_23_003256_create_subjects_table',1),(15,'2023_12_23_003545_create_subject_tables_table',1),(16,'2023_12_24_100038_create_class_nofifications_table',1),(17,'2023_12_24_100045_create_student_notifications_table',1),(18,'2023_12_24_100057_create_contact_books_table',1),(19,'2023_12_25_125305_create_communications_table',1),(20,'2023_12_25_135816_create_class_notification_contents_table',1),(21,'2023_12_29_075937_create_line_notifies_table',1),(22,'2023_12_30_102124_create_student_parent_sign_contact_books_table',1),(23,'2023_12_30_170459_add_signed_to_student_table',2),(24,'2023_12_31_002801_change_columns_to_contact_books',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_infos`
--

DROP TABLE IF EXISTS `parent_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parent_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned DEFAULT NULL COMMENT '學生識別碼',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電子郵件',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `relationship` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '關係',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '稱謂',
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '主要聯絡人',
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '職業',
  `contact_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '聯絡時間',
  `main_guardian` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '主要監護人',
  `line_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Line識別碼',
  `line_token` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Line Token',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_infos`
--

LOCK TABLES `parent_infos` WRITE;
/*!40000 ALTER TABLE `parent_infos` DISABLE KEYS */;
INSERT INTO `parent_infos` VALUES (1,1,'王美麗','0912345678','meiliwang@example.com','台北市中山區南京東路一段','母親','媽媽','是','教師','晚上','是','465465416465413','K3H4IQUvMspJ4BUMU9hK16DBqXDtzeYqZ6g8NeyHMmf',NULL,'2023-12-31 04:43:05'),(2,2,'李建國','0912345679','jianguoli@example.com','新北市板橋區文化路一段','父親','爸爸','是','工程師','白天','是','lineid02',NULL,NULL,'2024-01-15 14:57:57'),(3,3,'陳小春','0912345680','xiaochunchen@example.com','桃園市中壢區中大路','母親','媽媽','是','護士','晚上','是','lineid03',NULL,NULL,'2024-01-15 15:00:01'),(4,4,'林志玲','0912345681','zhilinglin@example.com','台中市西屯區西屯路一段','母親','媽媽','是','會計','下午','是','lineid04',NULL,NULL,'2024-01-15 15:00:53'),(5,5,'張鈞甯','0912345682','junniingzhang@example.com','高雄市前鎮區成功二路','父親','爸爸','是','企業家','全天','是','lineid05','2ZifcleZmEaSOK5LS9PxtY9JOOgMa8feSEnN2XBeEap',NULL,'2024-01-14 14:25:53'),(6,6,'蔡依林','0912345683','yilincai@example.com','台南市安平區安平路','母親','媽媽','是','老師','下午','是','lineid06','nXWODOCtfmb7X4YPVvCIvAelAjKNCNCciHZIIR6As9i',NULL,'2024-01-14 14:38:48'),(7,7,'劉德華','0912345684','dehualiu@example.com','基隆市仁愛區愛三路','父親','爸爸','是','商人','晚上','是','lineid07','W0ZNIEdDrWtljwq1NUfSdxJvlPxFWObq8gCN9rsygHk',NULL,'2024-01-15 14:59:29'),(8,8,'趙薇','0912345685','weizhao@example.com','新竹市東區光復路一段','母親','媽媽','是','設計師','白天','是','lineid08','',NULL,NULL),(9,9,'周潤發','0912345686','runfazhou@example.com','苗栗縣苗栗市中正路','父親','爸爸','是','農夫','白天','是','lineid09','',NULL,NULL),(10,10,'林心如','0912345687','xinrulin@example.com','彰化縣彰化市中山路一段','母親','媽媽','是','銀行職員','下午','是','lineid10','',NULL,NULL),(11,11,'吳奇隆','0912345688','qilongwu@example.com','南投縣南投市民族路','父親','爸爸','是','律師','晚上','是','lineid11','',NULL,NULL),(12,12,'賈靜雯','0912345689','jingwenjia@example.com','雲林縣斗六市文化路','母親','媽媽','是','營養師','全天','是','lineid12','',NULL,NULL),(13,13,'陳奕迅','0912345690','yixunchen@example.com','嘉義市東區共和路','父親','爸爸','是','音樂家','下午','是','lineid13','',NULL,NULL),(14,14,'楊冪','0912345691','miyang@example.com','嘉義縣太保市太保路','母親','媽媽','是','家庭主婦','全天','是','lineid14','6YoABlusTWGAjMPiazEr6BK5gg4EaQuZ1vAX5guqKI3',NULL,'2024-01-14 14:38:35'),(15,15,'王力宏','0912345692','lihongwang@example.com','屏東縣屏東市民生路','父親','爸爸','是','醫生','晚上','是','lineid15','94V9oA9CPswQIB4m5rFimk99haTHYKMp6dFkwHg5I4N',NULL,'2024-01-14 14:07:55'),(16,16,'周杰倫','0912345693','jielunzhou@example.com','宜蘭縣宜蘭市復興路一段','父親','爸爸','是','歌手','下午','是','lineid16','',NULL,NULL),(17,17,'林俊傑','0912345694','junjielin@example.com','花蓮縣花蓮市國聯五路','父親','爸爸','是','建築師','白天','是','lineid17','',NULL,NULL),(18,18,'梁朝偉','0912345695','chaoweiliang@example.com','台東縣台東市中正路','父親','爸爸','是','演員','晚上','是','lineid18','',NULL,NULL),(19,19,'張學友','0912345696','xueyouzhang@example.com','澎湖縣馬公市中正路','父親','爸爸','是','商人','全天','是','lineid19','',NULL,NULL),(20,20,'謝霆鋒','0912345697','tingfengxie@example.com','金門縣金城鎮民生路','父親','爸爸','是','廚師','下午','是','lineid20','',NULL,NULL),(21,21,'王菲','0912345698','feiwang@example.com','連江縣南竿鄉介壽村','母親','媽媽','是','歌手','晚上','是','lineid21','',NULL,NULL),(22,22,'劉若英','0912345699','ruoyingliu@example.com','新竹縣竹北市中華路','母親','媽媽','是','導演','全天','是','lineid22','',NULL,NULL),(23,23,'那英','0912345700','yingna@example.com','苗栗縣苗栗市光復路','母親','媽媽','是','歌手','晚上','是','lineid23','',NULL,NULL),(24,24,'莫文蔚','0912345701','wenweimo@example.com','彰化縣彰化市中山路','母親','媽媽','是','演員','下午','是','lineid24','',NULL,NULL),(25,25,'陶喆','0912345702','zhetian@example.com','南投縣南投市民族路','父親','爸爸','是','音樂製作人','全天','是','lineid25','',NULL,NULL),(26,26,'張惠妹','0912345703','huimeizhang@example.com','雲林縣斗六市中山路','母親','媽媽','是','歌手','晚上','是','lineid26','',NULL,NULL),(27,27,'張信哲','0912345704','xinzhezhang@example.com','嘉義市西區仁愛路','父親','爸爸','是','音樂製作人','下午','是','lineid27','',NULL,NULL),(28,28,'王心凌','0912345705','xinlingwang@example.com','嘉義縣民雄鄉建國路一段','母親','媽媽','是','演員','全天','是','lineid28','',NULL,NULL),(29,29,'陳綺貞','0912345706','qizhenchen@example.com','屏東縣屏東市自由路','母親','媽媽','是','歌手','晚上','是','lineid29','',NULL,NULL),(30,30,'林宥嘉','0912345707','youjialin@example.com','宜蘭縣羅東鎮公正路','父親','爸爸','是','音樂教師','白天','是','lineid30','',NULL,NULL),(31,31,'黃老爸','09xx',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-01-14 12:14:35','2024-01-14 12:14:35'),(32,32,'翔','0926272344',NULL,NULL,NULL,NULL,NULL,'工','均可',NULL,NULL,NULL,'2024-01-14 12:32:23','2024-01-14 12:32:23'),(33,11,'吳奇隆','0912345688',NULL,NULL,NULL,NULL,NULL,'律師','晚上','是',NULL,NULL,'2024-01-15 14:44:27','2024-01-15 14:44:27');
/*!40000 ALTER TABLE `parent_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_users`
--

DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_users` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_users_role_id_foreign` (`role_id`),
  CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_users`
--

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_classes`
--

DROP TABLE IF EXISTS `school_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `school_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_male_count` int DEFAULT NULL,
  `student_female_count` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_classes`
--

LOCK TABLES `school_classes` WRITE;
/*!40000 ALTER TABLE `school_classes` DISABLE KEYS */;
INSERT INTO `school_classes` VALUES (1,'甲班','七年級',15,15,'2024-01-14 04:54:10','2024-01-14 12:13:24'),(2,'火丙王Y王','99',2,0,'2024-01-14 12:29:43','2024-01-14 12:29:43');
/*!40000 ALTER TABLE `school_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned DEFAULT NULL COMMENT '學生識別碼',
  `subject_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '科目識別碼',
  `score` int DEFAULT NULL COMMENT '成績',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (1,1,'數學',85,NULL,NULL),(2,1,'英語',90,NULL,NULL),(3,1,'自然科學',88,NULL,NULL),(4,1,'社會科學',20,NULL,NULL);
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_notifications`
--

DROP TABLE IF EXISTS `student_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned DEFAULT NULL COMMENT '學生ID',
  `contact_book_id` bigint unsigned DEFAULT NULL COMMENT '聯絡簿ID',
  `reply` text COLLATE utf8mb4_unicode_ci COMMENT '回覆',
  `sign_time` timestamp NULL DEFAULT NULL COMMENT '簽名時間',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_notifications`
--

LOCK TABLES `student_notifications` WRITE;
/*!40000 ALTER TABLE `student_notifications` DISABLE KEYS */;
INSERT INTO `student_notifications` VALUES (1,1,NULL,NULL,NULL,'請回家後完成數學作業第五章練習。',NULL,NULL),(2,1,NULL,NULL,NULL,'下週三有英語朗讀比賽，請準備。',NULL,NULL),(3,1,NULL,NULL,NULL,'家長會將於下週五舉行。',NULL,NULL);
/*!40000 ALTER TABLE `student_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_parent_sign_contact_books`
--

DROP TABLE IF EXISTS `student_parent_sign_contact_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_parent_sign_contact_books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned DEFAULT NULL COMMENT '學生ID',
  `contact_book_id` bigint unsigned DEFAULT NULL COMMENT '聯絡簿ID',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '簽名連結',
  `reply` text COLLATE utf8mb4_unicode_ci COMMENT '回覆',
  `parent_infos_id` bigint unsigned DEFAULT NULL COMMENT '家長ID',
  `sign_time` timestamp NULL DEFAULT NULL COMMENT '簽名時間',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '內容',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_parent_sign_contact_books`
--

LOCK TABLES `student_parent_sign_contact_books` WRITE;
/*!40000 ALTER TABLE `student_parent_sign_contact_books` DISABLE KEYS */;
INSERT INTO `student_parent_sign_contact_books` VALUES (1,1,1,'https://smartecontbook.me/1//2023-12-30 16:58:19/response',NULL,NULL,NULL,' \n親愛的王美麗您好 \n陳大明同學的 今日聯絡簿 聯絡事項如下: \n1.明天請穿校服 \n2.明天請攜帶體育用品 \n3.明天請攜帶國文課本 \n注意事項如下: \n1.今日上學遲到 \n2.今日國文課踴躍回答問題 \n3.今日數學課睡覺 \n今日小考成績如下: \n國文: 85分 \n數學: 75分 \n英文: 25分 \n自然: 100分 \n請您確認後點擊下列連擊簽名 並提供您的寶貴回覆 \nhttps://smartecontbook.me/1//2023-12-30 16:58:19/response','2023-12-30 16:58:19','2023-12-30 16:58:19'),(2,1,1,'https://smartecontbook.me/1/1//response',NULL,NULL,NULL,' \n親愛的王美麗您好 \n陳大明同學的 今日聯絡簿 聯絡事項如下: \n1.明天請穿校服 \n2.明天請攜帶體育用品 \n3.明天請攜帶國文課本 \n注意事項如下: \n1.今日上學遲到 \n2.今日國文課踴躍回答問題 \n3.今日數學課睡覺 \n今日小考成績如下: \n國文: 85分 \n數學: 75分 \n英文: 25分 \n自然: 100分 \n請您確認後點擊下列連擊簽名 並提供您的寶貴回覆 \nhttps://smartecontbook.me/1/1//response','2023-12-30 17:43:49','2023-12-30 17:43:49'),(3,NULL,NULL,NULL,'謝謝老師用心教導',NULL,'2023-12-30 18:28:28',NULL,'2023-12-30 18:28:30','2023-12-30 18:28:30'),(4,NULL,NULL,NULL,'感謝老師用心回覆，遲到與成績的部分會再與小孩溝通，謝謝!',NULL,'2023-12-30 18:35:02',NULL,'2023-12-30 18:35:05','2023-12-30 18:35:05'),(5,NULL,NULL,NULL,'謝謝老師提醒上課睡覺和遲到的情況，會再與小孩溝通改善，謝謝老師!',NULL,'2023-12-30 18:42:21',NULL,'2023-12-30 18:42:23','2023-12-30 18:42:23'),(6,NULL,NULL,NULL,'感謝老師回覆,會在協助提醒小朋友完成作業與參加比賽事項',NULL,'2023-12-31 04:29:51',NULL,'2023-12-31 04:29:53','2023-12-31 04:29:53'),(7,NULL,NULL,NULL,'社會科學成績的部分會再與小孩溝通,提醒事項會再與小孩提醒,謝謝老師!',NULL,'2023-12-31 04:44:48',NULL,'2023-12-31 04:44:50','2023-12-31 04:44:50'),(8,NULL,NULL,NULL,'感謝',NULL,'2024-01-14 12:17:19',NULL,'2024-01-14 12:17:19','2024-01-14 12:17:19'),(9,NULL,NULL,NULL,'收到',NULL,'2024-01-14 14:03:48',NULL,'2024-01-14 14:03:50','2024-01-14 14:03:50'),(10,NULL,NULL,NULL,'靈兒~~~',NULL,'2024-01-14 14:15:26',NULL,'2024-01-14 14:15:29','2024-01-14 14:15:29'),(11,NULL,NULL,NULL,'歐耶',NULL,'2024-01-14 14:16:16',NULL,'2024-01-14 14:16:19','2024-01-14 14:16:19'),(12,NULL,NULL,NULL,'GGGGGG',NULL,'2024-01-14 14:48:08',NULL,'2024-01-14 14:48:11','2024-01-14 14:48:11'),(13,NULL,NULL,NULL,'安安你好，我女兒學校乖不乖',NULL,'2024-01-14 14:52:41',NULL,'2024-01-14 14:52:44','2024-01-14 14:52:44'),(14,NULL,NULL,NULL,'安安你好，我兒子乖不乖',NULL,'2024-01-14 14:55:13',NULL,'2024-01-14 14:55:15','2024-01-14 14:55:15'),(15,NULL,NULL,NULL,'老師您有沒有看到啊啊啊啊啊',NULL,'2024-01-14 14:55:40',NULL,'2024-01-14 14:55:43','2024-01-14 14:55:43'),(16,NULL,NULL,NULL,'您好',NULL,'2024-01-14 14:58:36',NULL,'2024-01-14 14:58:38','2024-01-14 14:58:38'),(17,NULL,NULL,NULL,'安安您好',NULL,'2024-01-14 14:59:04',NULL,'2024-01-14 14:59:07','2024-01-14 14:59:07'),(18,NULL,NULL,NULL,'asd',NULL,'2024-01-15 14:59:01',NULL,'2024-01-15 14:59:01','2024-01-15 14:59:01'),(19,NULL,NULL,NULL,'asd',NULL,'2024-01-15 15:01:31',NULL,'2024-01-15 15:01:32','2024-01-15 15:01:32');
/*!40000 ALTER TABLE `student_parent_sign_contact_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_class_id` bigint unsigned DEFAULT NULL COMMENT '班級識別碼',
  `seat_number` int DEFAULT NULL COMMENT '座號',
  `school_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '學號',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓名',
  `signed` tinyint(1) DEFAULT NULL COMMENT '簽名',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,1,1,'N1112211001','陳大明',0,NULL,'2024-01-15 15:00:53'),(2,1,2,'N1112211002','林小莉',0,NULL,'2024-01-14 14:51:37'),(3,1,3,'N1112211003','張偉強',1,NULL,'2024-01-14 14:55:27'),(4,1,4,'N1112211004','李思思',1,NULL,'2024-01-14 14:51:45'),(5,1,5,'N1112211005','王小虎',1,NULL,'2024-01-14 14:51:45'),(6,1,6,'N1112211006','趙靜怡',1,NULL,'2024-01-14 17:34:17'),(7,1,7,'N1112211007','孫悟空',NULL,NULL,NULL),(8,1,8,'N1112211008','周星馳',NULL,NULL,NULL),(9,1,9,'N1112211009','吳亦凡',NULL,NULL,NULL),(10,1,10,'N1112211010','楊過',NULL,NULL,NULL),(11,2,11,'N1112211011','郭靖',NULL,NULL,'2024-01-15 14:44:27'),(12,2,2,'N1112211012','黃蓉',NULL,NULL,NULL),(13,2,3,'N1112211013','李逍遙',NULL,NULL,NULL),(14,2,4,'N1112211014','林月如',1,NULL,'2024-01-14 14:58:53'),(15,2,5,'N1112211015','趙靈兒',1,NULL,'2024-01-14 14:58:23'),(16,2,6,'N1112211016','錢多多',NULL,NULL,NULL),(17,2,7,'N1112211017','朱自清',NULL,NULL,NULL),(18,2,8,'N1112211018','魯迅',NULL,NULL,NULL),(19,2,9,'N1112211019','杜甫',NULL,NULL,NULL),(20,2,10,'N1112211020','李白',NULL,NULL,NULL),(21,3,1,'N1112211021','蘇軾',NULL,NULL,NULL),(22,3,2,'N1112211022','白居易',NULL,NULL,NULL),(23,3,3,'N1112211023','李商隱',NULL,NULL,NULL),(24,3,4,'N1112211024','李清照',NULL,NULL,NULL),(25,3,5,'N1112211025','辛棄疾',NULL,NULL,NULL),(26,3,6,'N1112211026','王安石',NULL,NULL,NULL),(27,3,7,'N1112211027','歐陽修',NULL,NULL,NULL),(28,3,8,'N1112211028','蘇東坡',NULL,NULL,NULL),(29,3,9,'N1112211029','曹操',NULL,NULL,NULL),(30,3,10,'N1112211030','孔子',NULL,NULL,NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject_tables`
--

DROP TABLE IF EXISTS `subject_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subject_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '課表代碼',
  `school_class_id` bigint unsigned DEFAULT NULL COMMENT '班級識別碼',
  `subject_id` bigint unsigned DEFAULT NULL COMMENT '科目識別碼',
  `class_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '上課時間',
  `classroom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '上課教室',
  `teacher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '授課老師',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '課表描述',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject_tables`
--

LOCK TABLES `subject_tables` WRITE;
/*!40000 ALTER TABLE `subject_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `subject_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '科目名稱',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '科目代碼',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '科目描述',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permissions` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'陳老師','admin@admin.com',NULL,'$2y$12$wZZIrksANFcTmGjynSd42uB5YAaeys6TaHzAvHHoERgHSDQUEvR16','RoAtekigVkclB1YfmoWPGwlAYBfTkNXdT3hckFWRV9L5TIoXMvXsQlAlazDJ','2023-12-30 15:40:30','2023-12-30 15:40:30','{\"platform.index\": true, \"platform.systems.roles\": true, \"platform.systems.users\": true, \"platform.systems.attachment\": true}');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-16  9:43:25
