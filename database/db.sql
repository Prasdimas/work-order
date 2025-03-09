-- Adminer 4.8.1 MySQL 5.5.5-10.4.11-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4,	'2014_10_12_000000_create_users_table',	1),
(5,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(6,	'2025_03_04_023533_create_roles_table',	1),
(7,	'2025_03_04_033349_create_work_orders_table',	1),
(8,	'2025_03_04_033415_create_work_order_progress_table',	1);

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\User',	1,	'auth_token',	'db81e6c385a30bb4b96cb655ef009c07be53cb9c44554ee02ab9703a1fe62a54',	'[\"*\"]',	'2025-03-03 23:25:03',	'2025-03-03 20:48:00',	'2025-03-03 23:25:03'),
(2,	'App\\Models\\User',	2,	'auth_token',	'817091bfb1786b9e5cdfdf92820d7365877682960106551ed208fe2f9baf6470',	'[\"*\"]',	'2025-03-03 22:49:31',	'2025-03-03 21:49:29',	'2025-03-03 22:49:31'),
(5,	'App\\Models\\User',	1,	'auth_token',	'26fa608766bc5b2e2586b3bad0737f7956263ef2edacdb961b6ff8144df0fa82',	'[\"*\"]',	'2025-03-08 18:21:27',	'2025-03-08 18:21:03',	'2025-03-08 18:21:27');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1,	'Production Manager'),
(2,	'Operator');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
(1,	'Manager',	'$2y$10$6FL999eaY8Rv.SyRp0uzButAuOT1f5NNdJJsEsD1EwvRbMtDBUUtK',	1,	'2025-03-03 13:01:48',	'2025-03-03 13:01:48'),
(2,	'Operator 1',	'$2y$10$NHJ9H0/G/oJY2.44NLtUk.u69dehfUKtcgIcDiCFLihOnhQ2YOShW',	2,	'2025-03-03 21:00:47',	'2025-03-03 21:00:47'),
(3,	'Operator 3',	'$2y$10$NHJ9H0/G/oJY2.44NLtUk.u69dehfUKtcgIcDiCFLihOnhQ2YOShW',	2,	'2025-03-03 21:00:47',	'2025-03-03 21:00:47');

DROP TABLE IF EXISTS `work_orders`;
CREATE TABLE `work_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `work_order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('Pending','Progress','Completed','Canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `assigned_operator_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `work_orders_work_order_number_unique` (`work_order_number`),
  KEY `work_orders_assigned_operator_id_foreign` (`assigned_operator_id`),
  CONSTRAINT `work_orders_assigned_operator_id_foreign` FOREIGN KEY (`assigned_operator_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `work_orders` (`id`, `work_order_number`, `product_name`, `quantity`, `due_date`, `status`, `assigned_operator_id`, `created_at`, `updated_at`) VALUES
(1,	'WO-20250304-022',	'Produk A',	100,	'2025-04-01',	'Progress',	2,	'2025-03-03 20:55:25',	'2025-03-03 21:09:02'),
(3,	'WO-20250304-332',	'Produk B',	100,	'2025-04-01',	'Pending',	2,	'2025-03-03 21:02:45',	'2025-03-03 21:02:45'),
(4,	'WO-20250304-779',	'Produk C',	100,	'2025-04-01',	'Progress',	2,	'2025-03-03 22:57:52',	'2025-03-08 02:29:25');

DROP TABLE IF EXISTS `work_order_progress`;
CREATE TABLE `work_order_progress` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `work_order_id` bigint(20) unsigned NOT NULL,
  `status` enum('Pending','Progress','Completed','Canceled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_order_progress_work_order_id_foreign` (`work_order_id`),
  CONSTRAINT `work_order_progress_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `work_orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `work_order_progress` (`id`, `work_order_id`, `status`, `quantity`, `notes`, `created_at`, `updated_at`) VALUES
(1,	1,	'Progress',	50,	'Mulai pemotongan bahan',	'2025-03-03 21:49:57',	'2025-03-03 21:49:57'),
(2,	4,	'Pending',	100,	'',	'2025-03-03 22:57:52',	'2025-03-03 22:57:52'),
(3,	4,	'Progress',	5,	NULL,	'2025-03-08 02:29:25',	'2025-03-08 02:29:25'),
(4,	4,	'Progress',	5,	'Pemasangan',	'2025-03-08 02:30:30',	'2025-03-08 02:30:30');

-- 2025-03-09 01:22:37