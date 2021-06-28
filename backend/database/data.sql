-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5174
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table twinkl_test.bundle: ~4 rows (approximately)
/*!40000 ALTER TABLE `bundle` DISABLE KEYS */;
REPLACE INTO `bundle` (`id`, `name`, `active`, `order`, `created_at`, `updated_at`) VALUES
	(1, 'Core', 1, 1, '2021-03-10 23:47:50', '2021-03-10 23:47:50'),
	(2, 'Extra', 1, 2, '2021-03-10 23:48:01', '2021-03-10 23:59:47'),
	(3, 'Ultimate', 1, 3, '2021-03-10 23:48:11', '2021-03-10 23:59:51'),
	(4, 'Custom', 1, 4, '2021-03-10 23:48:21', '2021-03-10 23:59:55');
/*!40000 ALTER TABLE `bundle` ENABLE KEYS */;

-- Dumping data for table twinkl_test.bundle_subscription: ~4 rows (approximately)
/*!40000 ALTER TABLE `bundle_subscription` DISABLE KEYS */;
REPLACE INTO `bundle_subscription` (`bundle_id`, `subscription_id`, `created_at`) VALUES
	(1, 1, '2021-03-11 00:08:07'),
	(2, 2, '2021-03-11 00:08:28'),
	(3, 3, '2021-03-11 00:08:28'),
	(4, 1, '2021-03-11 00:09:42');
/*!40000 ALTER TABLE `bundle_subscription` ENABLE KEYS */;

-- Dumping data for table twinkl_test.subscription: ~3 rows (approximately)
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
REPLACE INTO `subscription` (`id`, `start_date`, `end_date`, `active`, `created_at`, `updated_at`) VALUES
	(1, '2021-03-11 00:00:00', '2022-03-11 00:00:00', 1, '2021-03-10 23:49:19', '2021-03-11 00:05:08'),
	(2, '2021-03-11 00:00:00', '2023-03-11 00:00:00', 1, '2021-03-10 23:49:19', '2021-03-11 00:05:08'),
	(3, '2021-03-11 00:00:00', '2026-03-11 00:00:00', 1, '2021-03-10 23:49:19', '2021-03-11 00:05:08');
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;

-- Dumping data for table twinkl_test.subscription_user: ~3 rows (approximately)
/*!40000 ALTER TABLE `subscription_user` DISABLE KEYS */;
REPLACE INTO `subscription_user` (`subscription_id`, `user_id`, `created_at`) VALUES
	(1, 1, '2021-03-11 00:11:11'),
	(2, 3, '2021-03-11 00:11:58'),
	(3, 5, '2021-03-11 00:12:21');
/*!40000 ALTER TABLE `subscription_user` ENABLE KEYS */;

-- Dumping data for table twinkl_test.user: ~5 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
REPLACE INTO `user` (`id`, `firstname`, `lastname`, `active`, `created_at`, `updated_at`) VALUES
	(1, 'jane', 'doe', 1, '2021-03-10 03:28:54', '2021-03-10 13:13:31'),
	(2, 'john', 'smith', 1, '2021-03-10 03:31:45', '2021-03-11 10:03:44'),
	(3, 'karen', 'doyle', 1, '2021-03-10 03:32:36', '2021-03-10 13:13:34'),
	(4, 'kane', 'bond', 1, '2021-03-10 03:32:36', '2021-03-11 10:03:47'),
	(5, 'lisa', 'tam', 1, '2021-03-10 03:32:36', '2021-03-11 00:12:46');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
