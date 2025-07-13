-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 13, 2025 at 06:38 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maintera`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_deletions`
--

DROP TABLE IF EXISTS `chat_deletions`;
CREATE TABLE IF NOT EXISTS `chat_deletions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_deletions_user_id_order_id_unique` (`user_id`,`order_id`),
  KEY `chat_deletions_order_id_foreign` (`order_id`),
  KEY `chat_deletions_user_id_deleted_at_index` (`user_id`,`deleted_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `sender_type` enum('customer','technician') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_type` enum('text','image','file','location') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_data` json DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_sender_id_foreign` (`sender_id`),
  KEY `chat_messages_order_id_created_at_index` (`order_id`,`created_at`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `order_id`, `sender_id`, `sender_type`, `message`, `message_type`, `file_path`, `file_name`, `file_size`, `location_data`, `read_at`, `created_at`, `updated_at`) VALUES
(14, 17, 1, 'customer', 'hii', 'text', NULL, NULL, NULL, NULL, '2025-07-13 10:24:43', '2025-07-13 10:24:43', '2025-07-13 10:24:43'),
(13, 17, 2, 'technician', 'hey', 'text', NULL, NULL, NULL, NULL, '2025-07-13 10:24:39', '2025-07-13 10:24:37', '2025-07-13 10:24:39'),
(12, 16, 1, 'customer', 'hi', 'text', NULL, NULL, NULL, NULL, NULL, '2025-07-13 10:10:35', '2025-07-13 10:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fare_offers`
--

DROP TABLE IF EXISTS `fare_offers`;
CREATE TABLE IF NOT EXISTS `fare_offers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `technician_id` bigint UNSIGNED NOT NULL,
  `proposed_price` decimal(10,2) NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fare_offers_order_id_technician_id_unique` (`order_id`,`technician_id`),
  KEY `fare_offers_technician_id_foreign` (`technician_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fare_offers`
--

INSERT INTO `fare_offers` (`id`, `order_id`, `technician_id`, `proposed_price`, `note`, `status`, `created_at`, `updated_at`) VALUES
(8, 17, 2, 1000.00, 'test fare', 'accepted', '2025-07-13 10:22:19', '2025-07-13 10:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_05_03_162208_create_order_reviews_table', 1),
(2, '2014_10_12_000000_create_users_table', 2),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 2),
(4, '2019_08_19_000000_create_failed_jobs_table', 2),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(6, '2024_03_19_000000_create_technician_profiles_table', 2),
(7, '2024_03_19_000001_create_order_requests_table', 2),
(8, '2025_04_03_184516_add_role_to_users_table', 2),
(9, '2025_04_09_200008_create_service_categories_table', 2),
(10, '2025_04_09_200014_create_services_table', 2),
(11, '2025_04_09_200019_create_service_category_service_table', 2),
(12, '2025_05_03_162207_create_fare_offers_table', 2),
(13, '2025_05_03_162208_create_payments_table', 2),
(14, '2025_05_03_163543_create_orders_table', 2),
(15, '2025_05_04_063116_add_technician_id_to_orders_table', 2),
(16, '2025_05_04_165630_add_status_to_users_table', 2),
(17, '2025_05_20_115436_create_notifications_table', 2),
(18, '2025_05_29_060625_add_media_columns_to_orders_table', 2),
(19, '2025_07_01_184054_change_occupation_to_json_in_technician_profiles_table', 2),
(20, '2025_07_12_193149_create_support_requests_table', 2),
(21, '2025_07_12_200315_create_chat_messages_table', 2),
(22, '2025_07_13_082216_add_cancellation_reason_to_orders_table', 2),
(23, '2025_07_13_094229_create_chat_deletions_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('6006defd-62a2-46b1-bdb2-8955182a3e12', 'App\\Notifications\\NewOrderRequest', 'App\\Models\\User', 2, '{\"order_id\":12,\"message\":\"New service request received\",\"type\":\"new_request\",\"scheduled_at\":\"1979-09-13T01:32:00.000000Z\",\"location\":\"H529+5CG, River Gardens Housing Scheme, Islamabad, Pakistan\"}', '2025-07-13 07:04:35', '2025-07-13 05:55:23', '2025-07-13 07:04:35'),
('c5b51871-5d61-45eb-bb04-e6a85b010a4c', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 1, '{\"order_id\":12,\"fare_offer_id\":1,\"technician_id\":2,\"proposed_price\":\"5000.00\",\"note\":\"i will fix it\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', '2025-07-13 06:04:23', '2025-07-13 05:55:54', '2025-07-13 06:04:23'),
('dca1135a-fbc1-4b27-815e-d778f642069b', 'App\\Notifications\\OrderAccepted', 'App\\Models\\User', 1, '{\"order_id\":12,\"message\":\"Your order has been accepted by a technician\",\"type\":\"order_accepted\",\"location\":\"H529+5CG, River Gardens Housing Scheme, Islamabad, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\"}', '2025-07-13 06:04:23', '2025-07-13 05:56:17', '2025-07-13 06:04:23'),
('c93389fd-614c-4023-b579-866e1597d63c', 'App\\Notifications\\OrderCompleted', 'App\\Models\\User', 1, '{\"order_id\":12,\"message\":\"\\ud83c\\udf89 Your order has been completed successfully! Rate your experience.\",\"type\":\"order_completed\",\"location\":\"H529+5CG, River Gardens Housing Scheme, Islamabad, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\",\"completed_at\":\"2025-07-13T11:05:12.268757Z\",\"review_url\":\"http:\\/\\/127.0.0.1:8000\\/customer\\/orders\\/12\\/review\"}', '2025-07-13 07:03:46', '2025-07-13 06:05:12', '2025-07-13 07:03:46'),
('82c29032-39f4-4a3a-ac64-38477999637d', 'App\\Notifications\\OrderStatusUpdated', 'App\\Models\\User', 3, '{\"order_id\":12,\"message\":\"Your order status has been updated to Accepted\",\"type\":\"order_status_updated\",\"old_status\":\"pending\",\"new_status\":\"accepted\",\"location\":\"H529+5CG, River Gardens Housing Scheme, Islamabad, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\"}', NULL, '2025-07-13 05:56:25', '2025-07-13 05:56:25'),
('e532cdcf-e5d6-46be-bce5-40e03969fd81', 'App\\Notifications\\OrderStatusUpdated', 'App\\Models\\User', 3, '{\"order_id\":12,\"message\":\"Your order status has been updated to Completed\",\"type\":\"order_status_updated\",\"old_status\":\"pending\",\"new_status\":\"completed\",\"location\":\"H529+5CG, River Gardens Housing Scheme, Islamabad, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\"}', NULL, '2025-07-13 06:05:16', '2025-07-13 06:05:16'),
('3d338604-c829-4185-88c3-e5b8bc209ce0', 'App\\Notifications\\NewOrderRequest', 'App\\Models\\User', 2, '{\"order_id\":13,\"message\":\"New service request received\",\"type\":\"new_request\",\"scheduled_at\":\"2008-02-13T02:51:00.000000Z\",\"location\":\"J3VH+6J5, Dhoke Paracha, Rawalpindi, Pakistan\"}', '2025-07-13 07:04:35', '2025-07-13 06:08:20', '2025-07-13 07:04:35'),
('bbae6a67-ccb3-41d4-b1e3-b828d0fd4fbf', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 1, '{\"order_id\":13,\"fare_offer_id\":2,\"technician_id\":2,\"proposed_price\":\"1000.00\",\"note\":\"will be done\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', '2025-07-13 07:03:46', '2025-07-13 06:08:55', '2025-07-13 07:03:46'),
('54eb6bd8-989f-4ffb-8573-ce4bf8d40747', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":3,\"technician_id\":5,\"proposed_price\":\"800.00\",\"note\":\"Professional service offer from Test Technician 1\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:35:42', '2025-07-13 06:35:42'),
('0a563f51-bad8-46d4-85df-33bfa2738c46', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":4,\"technician_id\":6,\"proposed_price\":\"950.00\",\"note\":\"Professional service offer from Test Technician 2\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:35:48', '2025-07-13 06:35:48'),
('401af66c-582c-4fbe-9145-651d99d2b6b7', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":5,\"technician_id\":7,\"proposed_price\":\"1200.00\",\"note\":\"Professional service offer from Test Technician 3\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:35:50', '2025-07-13 06:35:50'),
('d9197feb-6dfa-4548-83b7-10eb0767a10a', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":3,\"technician_id\":5,\"proposed_price\":\"800.00\",\"note\":\"Professional service offer from Test Technician 1\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:37:50', '2025-07-13 06:37:50'),
('f0ab8cb8-0cf3-4d11-8787-ec82bb58ce1f', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":4,\"technician_id\":6,\"proposed_price\":\"950.00\",\"note\":\"Professional service offer from Test Technician 2\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:37:54', '2025-07-13 06:37:54'),
('c3fd1365-a319-40e9-b156-003dad932733', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 4, '{\"order_id\":14,\"fare_offer_id\":5,\"technician_id\":7,\"proposed_price\":\"1200.00\",\"note\":\"Professional service offer from Test Technician 3\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', NULL, '2025-07-13 06:37:57', '2025-07-13 06:37:57'),
('a8244ec8-60f1-437b-98d1-221172f49d0a', 'App\\Notifications\\OrderAccepted', 'App\\Models\\User', 2, '{\"order_id\":13,\"message\":\"Your order has been accepted by a technician\",\"type\":\"order_accepted\",\"location\":\"J3VH+6J5, Dhoke Paracha, Rawalpindi, Pakistan\",\"technician_name\":\"N\\/A\",\"service_name\":\"Drain Cleaning\"}', '2025-07-13 07:06:49', '2025-07-13 07:05:57', '2025-07-13 07:06:49'),
('8f34e2f9-34fe-41dc-bb06-56b13a6bb7a2', 'App\\Notifications\\NewOrderRequest', 'App\\Models\\User', 2, '{\"order_id\":15,\"message\":\"New service request received\",\"type\":\"new_request\",\"scheduled_at\":\"2009-09-04T09:35:00.000000Z\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\"}', '2025-07-13 09:26:26', '2025-07-13 09:21:50', '2025-07-13 09:26:26'),
('5f02a05b-9711-41f0-8710-69c51d0b179f', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 1, '{\"order_id\":15,\"fare_offer_id\":6,\"technician_id\":2,\"proposed_price\":\"1000.00\",\"note\":null,\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', '2025-07-13 09:27:40', '2025-07-13 09:22:43', '2025-07-13 09:27:40'),
('50735e71-bca7-4486-8c8a-78ac97b684d3', 'App\\Notifications\\OrderAccepted', 'App\\Models\\User', 2, '{\"order_id\":15,\"message\":\"Your order has been accepted by a technician\",\"type\":\"order_accepted\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\",\"technician_name\":\"N\\/A\",\"service_name\":\"Ceiling Fan Installation\"}', '2025-07-13 09:26:26', '2025-07-13 09:24:31', '2025-07-13 09:26:26'),
('ca2c62ee-d1c7-493f-978b-3dbd8851d46f', 'App\\Notifications\\NewOrderRequest', 'App\\Models\\User', 2, '{\"order_id\":16,\"message\":\"New service request received\",\"type\":\"new_request\",\"scheduled_at\":\"1975-01-20T16:18:00.000000Z\",\"location\":\"J3VH+6J5, Dhoke Paracha, Rawalpindi, Pakistan\"}', '2025-07-13 13:16:06', '2025-07-13 09:59:53', '2025-07-13 13:16:06'),
('887d7dd0-c8fe-496f-9267-6029a40df8cc', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 1, '{\"order_id\":16,\"fare_offer_id\":7,\"technician_id\":2,\"proposed_price\":\"500.00\",\"note\":\"test offer\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', '2025-07-13 10:27:21', '2025-07-13 10:00:59', '2025-07-13 10:27:21'),
('1aecf1a7-5793-40b7-bc23-184e4e669a24', 'App\\Notifications\\OrderAccepted', 'App\\Models\\User', 2, '{\"order_id\":16,\"message\":\"Your order has been accepted by a technician\",\"type\":\"order_accepted\",\"location\":\"J3VH+6J5, Dhoke Paracha, Rawalpindi, Pakistan\",\"technician_name\":\"N\\/A\",\"service_name\":\"Door Hinge Repair\"}', '2025-07-13 13:16:06', '2025-07-13 10:02:38', '2025-07-13 13:16:06'),
('9e39ef75-ce3e-4304-9607-0ee09c5c57fa', 'App\\Notifications\\NewOrderRequest', 'App\\Models\\User', 2, '{\"order_id\":17,\"message\":\"New service request received\",\"type\":\"new_request\",\"scheduled_at\":\"1987-05-24T08:00:00.000000Z\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\"}', '2025-07-13 13:16:06', '2025-07-13 10:21:45', '2025-07-13 13:16:06'),
('35fcbe56-a1ed-4cf7-8f63-e1081dae2665', 'App\\Notifications\\TechnicianFareOffer', 'App\\Models\\User', 1, '{\"order_id\":17,\"fare_offer_id\":8,\"technician_id\":2,\"proposed_price\":\"1000.00\",\"note\":\"test fare\",\"message\":\"A technician has offered a fare for your order.\",\"type\":\"technician_fare_offer\"}', '2025-07-13 10:27:21', '2025-07-13 10:22:19', '2025-07-13 10:27:21'),
('abe37bda-e69d-4111-8c3f-fef323d107c1', 'App\\Notifications\\OrderAccepted', 'App\\Models\\User', 2, '{\"order_id\":17,\"message\":\"Your order has been accepted by a technician\",\"type\":\"order_accepted\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\"}', '2025-07-13 13:16:06', '2025-07-13 10:23:49', '2025-07-13 13:16:06'),
('a166c362-445f-4abd-82ec-eb52848184ad', 'App\\Notifications\\OrderCompleted', 'App\\Models\\User', 1, '{\"order_id\":17,\"message\":\"\\ud83c\\udf89 Your order has been completed successfully! Rate your experience.\",\"type\":\"order_completed\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\",\"completed_at\":\"2025-07-13T15:26:29.549463Z\",\"review_url\":\"http:\\/\\/127.0.0.1:8000\\/customer\\/orders\\/17\\/review\"}', '2025-07-13 10:27:21', '2025-07-13 10:26:29', '2025-07-13 10:27:21'),
('f580439c-bbc9-4fff-8223-b7df23eb281a', 'App\\Notifications\\OrderStatusUpdated', 'App\\Models\\User', 3, '{\"order_id\":17,\"message\":\"Your order status has been updated to Completed\",\"type\":\"order_status_updated\",\"old_status\":\"pending\",\"new_status\":\"completed\",\"location\":\"J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan\",\"technician_name\":\"Technician\",\"service_name\":\"Ceiling Fan Installation\"}', NULL, '2025-07-13 10:26:34', '2025-07-13 10:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `technician_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `subcategory_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `street_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `payment_mode` enum('cash','online') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','offer_received','accepted','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `media_images` json DEFAULT NULL,
  `media_videos` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_category_id_foreign` (`category_id`),
  KEY `orders_subcategory_id_foreign` (`subcategory_id`),
  KEY `orders_technician_id_foreign` (`technician_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `technician_id`, `category_id`, `subcategory_id`, `description`, `street_address`, `city`, `area`, `sub_area`, `latitude`, `longitude`, `payment_mode`, `scheduled_at`, `status`, `cancellation_reason`, `media_images`, `media_videos`, `created_at`, `updated_at`) VALUES
(17, 1, 2, 1, 1, 'Nobis a voluptatem', 'J3WH+MRC, Murree Rd, Shamsabad, Rawalpindi, Pakistan', 'Rawalpindi', '', '', 33.6461824, 73.0791936, 'online', '1987-05-24 03:00:00', 'completed', NULL, NULL, NULL, '2025-07-13 10:21:45', '2025-07-13 10:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_requests`
--

DROP TABLE IF EXISTS `order_requests`;
CREATE TABLE IF NOT EXISTS `order_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `technician_id` bigint UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `distance` decimal(8,2) DEFAULT NULL,
  `fare_offer` decimal(10,2) DEFAULT NULL,
  `accepted_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_requests_order_id_technician_id_unique` (`order_id`,`technician_id`),
  KEY `order_requests_technician_id_foreign` (`technician_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_requests`
--

INSERT INTO `order_requests` (`id`, `order_id`, `technician_id`, `status`, `distance`, `fare_offer`, `accepted_at`, `rejected_at`, `created_at`, `updated_at`) VALUES
(5, 17, 2, 'Pending', 13.53, 1.00, NULL, NULL, '2025-07-13 10:21:45', '2025-07-13 10:22:19'),
(4, 16, 2, 'Pending', 13.24, 1.00, NULL, NULL, '2025-07-13 09:59:53', '2025-07-13 10:00:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_reviews`
--

DROP TABLE IF EXISTS `order_reviews`;
CREATE TABLE IF NOT EXISTS `order_reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `technician_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `service_quality` tinyint DEFAULT NULL,
  `communication` tinyint DEFAULT NULL,
  `punctuality` tinyint DEFAULT NULL,
  `professionalism` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_reviews_order_id_unique` (`order_id`),
  KEY `order_reviews_customer_id_foreign` (`customer_id`),
  KEY `order_reviews_technician_id_foreign` (`technician_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_reviews`
--

INSERT INTO `order_reviews` (`id`, `order_id`, `customer_id`, `technician_id`, `rating`, `review`, `service_quality`, `communication`, `punctuality`, `professionalism`, `created_at`, `updated_at`) VALUES
(2, 17, 1, 2, 5, NULL, 4, 4, 2, 2, '2025-07-13 10:27:07', '2025-07-13 10:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_method` enum('cash','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Ceiling Fan Installation', 'Ceiling Fan Installation description...', 1, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(2, 'Switchboard Repair', 'Switchboard Repair description...', 1, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(3, 'Leaky Faucet Fix', 'Leaky Faucet Fix description...', 2, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(4, 'Drain Cleaning', 'Drain Cleaning description...', 2, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(5, 'Home Deep Cleaning', 'Home Deep Cleaning description...', 3, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(6, 'AC Gas Refilling', 'AC Gas Refilling description...', 4, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(7, 'Wall Painting', 'Wall Painting description...', 7, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(8, 'Door Hinge Repair', 'Door Hinge Repair description...', 5, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(9, 'Washing Machine Repair', 'Washing Machine Repair description...', 6, '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(10, 'Test Service', 'Test service for fare system', NULL, '2025-07-13 06:30:14', '2025-07-13 06:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE IF NOT EXISTS `service_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Electrical', 'electrical', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(2, 'Plumbing', 'plumbing', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(3, 'Cleaning', 'cleaning', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(4, 'AC Services', 'ac-services', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(5, 'Carpentry', 'carpentry', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(6, 'Appliance Repair', 'appliance-repair', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(7, 'Painting', 'painting', '2025-07-13 05:49:07', '2025-07-13 05:49:07'),
(8, 'Test Category', NULL, '2025-07-13 06:30:14', '2025-07-13 06:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `service_category_service`
--

DROP TABLE IF EXISTS `service_category_service`;
CREATE TABLE IF NOT EXISTS `service_category_service` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_category_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_category_service_service_category_id_foreign` (`service_category_id`),
  KEY `service_category_service_service_id_foreign` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_category_service`
--

INSERT INTO `service_category_service` (`id`, `service_category_id`, `service_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 2, 3, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 8, 10, '2025-07-13 06:30:14', '2025-07-13 06:30:14');

-- --------------------------------------------------------

--
-- Table structure for table `support_requests`
--

DROP TABLE IF EXISTS `support_requests`;
CREATE TABLE IF NOT EXISTS `support_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('customer','technician','admin','guest') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guest',
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','in_progress','resolved','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `attachments` json DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_requests_user_id_foreign` (`user_id`),
  KEY `support_requests_assigned_to_foreign` (`assigned_to`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_requests`
--

INSERT INTO `support_requests` (`id`, `name`, `email`, `subject`, `message`, `user_type`, `user_id`, `status`, `priority`, `attachments`, `admin_notes`, `assigned_to`, `resolved_at`, `created_at`, `updated_at`) VALUES
(2, 'junaid', 'junaid@gmail.com', 'billing', 'billing issue with tech', 'customer', 1, 'resolved', 'medium', '[{\"path\": \"support-attachments/1752416935_pixlr-image-generator-686ecbdf0fb44aae448b60b6.png\", \"size\": 42555, \"type\": \"image/jpeg\", \"filename\": \"pixlr-image-generator-686ecbdf0fb44aae448b60b6.png\"}, {\"path\": \"support-attachments/1752416935_pixlr-image-generator-686ecbdf0fb44aae448b60b6.png\", \"size\": 42555, \"type\": \"image/jpeg\", \"filename\": \"pixlr-image-generator-686ecbdf0fb44aae448b60b6.png\"}]', NULL, NULL, '2025-07-13 09:29:35', '2025-07-13 09:28:55', '2025-07-13 09:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `technician_profiles`
--

DROP TABLE IF EXISTS `technician_profiles`;
CREATE TABLE IF NOT EXISTS `technician_profiles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` json DEFAULT NULL,
  `experience` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `street_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locality` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pakistan',
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `skills` json DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `total_orders` int NOT NULL DEFAULT '0',
  `completed_orders` int NOT NULL DEFAULT '0',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `technician_profiles_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `technician_profiles`
--

INSERT INTO `technician_profiles` (`id`, `user_id`, `phone`, `occupation`, `experience`, `qualification`, `address`, `street_number`, `route`, `locality`, `area`, `state`, `postal_code`, `country`, `latitude`, `longitude`, `profile_image`, `bio`, `skills`, `is_available`, `rating`, `total_orders`, `completed_orders`, `is_verified`, `verified_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '123456789', '[\"Electrician\", \"Plumber\", \"Painter\", \"Carpenter\", \"Housekeeping\"]', '1-3', 'ITI', 'G5X9+R9M, River Gardens Housing Scheme, Islamabad, Pakistan', NULL, NULL, 'Islamabad', NULL, 'Islamabad Capital Territory', NULL, 'Pakistan', 33.549635, 73.168031, 'uploads/technician-profiles/1752404103.png', NULL, NULL, 1, 0.00, 0, 0, 0, NULL, '2025-07-13 05:55:03', '2025-07-13 08:49:55', NULL),
(2, 5, '0300-1234561', '\"[\\\"Plumber\\\",\\\"Electrician\\\"]\"', '7', NULL, 'Test Address 1', NULL, NULL, NULL, NULL, NULL, NULL, 'Pakistan', NULL, NULL, NULL, 'Experienced technician with 1 years of service', NULL, 1, 0.00, 0, 0, 0, NULL, '2025-07-13 06:30:13', '2025-07-13 06:30:13', NULL),
(3, 6, '0300-1234562', '\"[\\\"Plumber\\\",\\\"Electrician\\\"]\"', '4', NULL, 'Test Address 2', NULL, NULL, NULL, NULL, NULL, NULL, 'Pakistan', NULL, NULL, NULL, 'Experienced technician with 2 years of service', NULL, 1, 0.00, 0, 0, 0, NULL, '2025-07-13 06:30:13', '2025-07-13 06:30:13', NULL),
(4, 7, '0300-1234563', '\"[\\\"Plumber\\\",\\\"Electrician\\\"]\"', '5', NULL, 'Test Address 3', NULL, NULL, NULL, NULL, NULL, NULL, 'Pakistan', NULL, NULL, NULL, 'Experienced technician with 3 years of service', NULL, 1, 0.00, 0, 0, 0, NULL, '2025-07-13 06:30:14', '2025-07-13 06:30:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `status`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'junaid zaib', 'junaid@gmail.com', 'active', NULL, '$2y$12$b9ahB7ih/5/9n8HJzqkF3uNEO8iOvnCb1DlXjqZEY8RoD.vI6t3Yy', 'customer', NULL, '2025-07-13 05:48:00', '2025-07-13 05:48:00'),
(2, 'Technician', 'technician@gmail.com', 'active', NULL, '$2y$12$NhhtkCwjdQ9y1t046oGoAu0jxOx2NmFNTRepZsyQri.ciTKg9c0CS', 'technician', NULL, '2025-07-13 05:50:10', '2025-07-13 05:50:10'),
(3, 'admin', 'admin@admin.com', 'active', NULL, '$2y$12$kAmbAIjvKkQQwvz5lomON.9aLjUJd8QhKd3y6RGat/0wXzqcpEaKy', 'admin', NULL, '2025-07-13 05:51:25', '2025-07-13 05:51:25'),
(4, 'Test Customer', 'customer.fare@test.com', 'active', NULL, '$2y$12$bK0bD38uJrSqjtiPv/qebuLctB8OaBmkP1cxIkjeowP9NNh85Usx.', 'customer', NULL, '2025-07-13 06:30:12', '2025-07-13 06:30:12'),
(5, 'Test Technician 1', 'technician.fare1@test.com', 'active', NULL, '$2y$12$x.YExCAYggVI1j0n/GIDDOEtRdeFjxK0l6cysT0EsivvnbVwNgFgG', 'technician', NULL, '2025-07-13 06:30:13', '2025-07-13 06:30:13'),
(6, 'Test Technician 2', 'technician.fare2@test.com', 'active', NULL, '$2y$12$JPVIhxtSubPSJvbPI5JkT.kfRwH9MabglI6Af36lRMhRcqYbJilia', 'technician', NULL, '2025-07-13 06:30:13', '2025-07-13 06:30:13'),
(7, 'Test Technician 3', 'technician.fare3@test.com', 'active', NULL, '$2y$12$4mfj5Qsoq05Bk9CnQUrNP.U140qxeg6oESoBkF.ffczblUTdmID6u', 'technician', NULL, '2025-07-13 06:30:14', '2025-07-13 06:30:14'),
(8, 'Khalid', 'khalid@gmail.com', 'active', NULL, '$2y$12$NgTeJLLUmeYcTnx3z1nb1urwU3B1nkxdHcQLOVopi7gG9Ol22U4CC', 'customer', NULL, '2025-07-13 13:22:45', '2025-07-13 13:22:45');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
