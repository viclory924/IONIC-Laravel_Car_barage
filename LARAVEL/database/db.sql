create database mykaraj;

use mykaraj;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=2006 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Laravel Personal Access Client', 'kM6ySSrghScnAWfmXwjHFlgz1npkD28JUY7cY0Mf', 'http://localhost', 1, 0, 0, '2019-04-27 11:12:05', '2019-04-27 11:12:05'),
	(2, NULL, 'Laravel Password Grant Client', 'Qcd1aww1KY1EkdxjjQPtro6DDRM3f2DoDaDjLaAo', 'http://localhost', 0, 1, 0, '2019-04-27 11:12:05', '2019-04-27 11:12:05'),
	(4, NULL, 'Online', 'nc0sdfBrF1a6wluFwJRdSaqDFNf4lrRf6IpbW9vg', 'http://mykaraj.com', 1, 0, 0, '2019-09-06 21:22:35', '2019-09-06 21:22:37');

CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2019-04-27 11:12:05', '2019-04-27 11:12:05');
	
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `list_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `list_brand` (
	`id` INT NULL AUTO_INCREMENT,
	`country` VARCHAR(255) NULL DEFAULT '0',
	`brand` VARCHAR(255) NULL DEFAULT '0'
)COLLATE='utf8_general_ci' ENGINE=InnoDB;


INSERT INTO `list_country` (`id`, `ar_name`, `en_name`, `code`) VALUES
	(1, 'الإمارات العربية المتحدة', 'United arab emirates', '+971');

CREATE TABLE IF NOT EXISTS `list_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `list_city_fk` (`country_id`),
  CONSTRAINT `list_city_fk` FOREIGN KEY (`country_id`) REFERENCES `list_country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO `list_city` (`id`, `country_id`, `ar_name`, `en_name`) VALUES
	(1, 1, 'أبوظبي', 'Abu Dhabi'),
	(2, 1, 'دبي', 'Dubai'),
	(3, 1, 'الشارقة', 'Sharjah'),
	(4, 1, 'عجمان', 'Ajman'),
	(5, 1, 'ام القيوين', 'Umm Al Quwain'),
	(6, 1, 'رأس الخيمة', 'Ras Al-Khamah'),
	(7, 1, 'الفجيرة', 'Fujairah');

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ar_description` varchar(255) DEFAULT NULL,
  `en_description` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_fk` (`country_id`),
  KEY `workshop_city_fk_city` (`city_id`),
  CONSTRAINT `workshop_city_fk` FOREIGN KEY (`city_id`) REFERENCES `list_city` (`id`),
  CONSTRAINT `workshop_fk` FOREIGN KEY (`country_id`) REFERENCES `list_country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
	(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
	(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
	(6, '2016_06_01_000004_create_oauth_clients_table', 1),
	(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
	(8, '2019_06_17_174100_create_jobs_table', 2),
	(9, '2019_07_08_063608_create_address_table', 0),
	(10, '2019_07_08_063608_create_car_table', 0),
	(11, '2019_07_08_063608_create_car_history_table', 0),
	(12, '2019_07_08_063608_create_jobs_table', 0),
	(13, '2019_07_08_063608_create_list_city_table', 0),
	(14, '2019_07_08_063608_create_list_country_table', 0),
	(15, '2019_07_08_063608_create_oauth_access_tokens_table', 0),
	(16, '2019_07_08_063608_create_oauth_auth_codes_table', 0),
	(17, '2019_07_08_063608_create_oauth_clients_table', 0),
	(18, '2019_07_08_063608_create_oauth_personal_access_clients_table', 0),
	(19, '2019_07_08_063608_create_oauth_refresh_tokens_table', 0),
	(20, '2019_07_08_063608_create_password_resets_table', 0),
	(21, '2019_07_08_063608_create_role_user_table', 0),
	(22, '2019_07_08_063608_create_roles_table', 0),
	(23, '2019_07_08_063608_create_service_category_table', 0),
	(24, '2019_07_08_063608_create_service_sub_category_table', 0),
	(25, '2019_07_08_063608_create_setting_table', 0),
	(26, '2019_07_08_063608_create_user_notification_table', 0),
	(27, '2019_07_08_063608_create_users_table', 0),
	(28, '2019_07_08_063608_create_users_validation_table', 0),
	(29, '2019_07_08_063608_create_versions_table', 0),
	(30, '2019_07_08_063608_create_workshop_table', 0),
	(31, '2019_07_08_063608_create_workshop_calender_table', 0),
	(32, '2019_07_08_063608_create_workshop_categories_table', 0),
	(33, '2019_07_08_063608_create_workshop_rate_table', 0),
	(34, '2019_07_08_063608_create_workshop_request_table', 0),
	(35, '2019_07_08_063610_add_foreign_keys_to_address_table', 0),
	(36, '2019_07_08_063610_add_foreign_keys_to_car_table', 0),
	(37, '2019_07_08_063610_add_foreign_keys_to_car_history_table', 0),
	(38, '2019_07_08_063610_add_foreign_keys_to_list_city_table', 0),
	(39, '2019_07_08_063610_add_foreign_keys_to_service_sub_category_table', 0),
	(40, '2019_07_08_063610_add_foreign_keys_to_user_notification_table', 0),
	(41, '2019_07_08_063610_add_foreign_keys_to_users_table', 0),
	(42, '2019_07_08_063610_add_foreign_keys_to_users_validation_table', 0),
	(43, '2019_07_08_063610_add_foreign_keys_to_workshop_table', 0),
	(44, '2019_07_08_063610_add_foreign_keys_to_workshop_calender_table', 0),
	(45, '2019_07_08_063610_add_foreign_keys_to_workshop_categories_table', 0),
	(46, '2019_07_08_063610_add_foreign_keys_to_workshop_rate_table', 0);
	
	
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `service_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

INSERT INTO `service_category` (`id`, `ar_name`, `en_name`, `image`) VALUES
	(18, 'مكانيك', 'Mechanical', 'categories/main/FqJGhojQUv0IgNL3LbiBmlYWkltL5KZF8nVyHlKb.jpeg'),
	(20, 'كهرباء', 'Electrical', 'categories/main/v5oMZuCYdRrPqhdCj21zLzmRzumUNl7EdsYKam64.jpeg'),
	(21, 'خدمات', 'Service', 'categories/main/zyeLD9mCs6e9LdMw80XsVwST3fLWWaQoCloHzTRP.jpeg'),
	(22, 'دهان', 'Painting', 'categories/main/Pw0TIVXGykAkHuXPTDXCjnWjNDiteVR85cm9sVbd.jpeg'),
	(23, 'ضبط', 'Tuning', 'categories/main/D5UPsQSo3PcnRMiJXXhtfT0Hrxi7moREXNWz5Ewa.jpeg');

CREATE TABLE IF NOT EXISTS `service_sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) DEFAULT NULL,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_sub_category_fk` (`cat_id`),
  CONSTRAINT `service_sub_category_fk` FOREIGN KEY (`cat_id`) REFERENCES `service_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `service_sub_category` (`id`, `cat_id`, `ar_name`, `en_name`, `image`) VALUES
	(3, 21, 'بريكات', 'Brake', 'categories/sub/GYk1tgINGTH2Ws3gY9CYVyhrJZQNxBGHx7qe9bLz.jpeg'),
	(5, 21, 'غيار زيت', 'Oil', 'categories/sub/bXQXtRulwoEYbUFLE5wxLDYz9YyD6EhTVf6iwgbS.jpeg'),
	(6, 21, 'إطارات', 'Tyer', 'categories/sub/q7PqPKgZEBVw2Fzv9YTWaRq0dAdOlA530YAEsRws.jpeg'),
	(7, 21, 'تكيف', 'A/C Filter', 'categories/sub/MixxySmn1upYqdpvwkmLOEYKksgAW93HDDDD9ywt.jpeg');

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `setting` (`id`, `field`, `value`) VALUES
	(1, 'Booking fess', 'Free'),
	(2, 'View rate', 'Yes'),
	(3, 'Show customer comments', 'Yes'),
	(4, 'Show workshop review', 'Yes');
	
CREATE TABLE IF NOT EXISTS `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) DEFAULT NULL,
  `android` varchar(255) DEFAULT NULL,
  `ios` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `versions` (`id`, `version`, `android`, `ios`) VALUES
	(1, '0.0.1', '1', '1');
	
CREATE TABLE IF NOT EXISTS `workshop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `brand_id` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `ar_name` varchar(255) DEFAULT NULL,
  `en_name` varchar(255) DEFAULT NULL,
  `ar_description` varchar(255) DEFAULT NULL,
  `en_description` varchar(255) DEFAULT NULL,
  `ar_address` varchar(255) DEFAULT NULL,
  `en_address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `google_lat` varchar(45) DEFAULT NULL,
  `google_lng` varchar(45) DEFAULT NULL,
  `start_from` varchar(50) DEFAULT NULL,
  `end_at` varchar(50) DEFAULT NULL,
  `totl_rate` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_list_city_id_fk` (`city_id`),
  KEY `workshop_list_country_id_fk` (`country_id`),
  CONSTRAINT `workshop_list_city_id_fk` FOREIGN KEY (`city_id`) REFERENCES `list_city` (`id`),
  CONSTRAINT `workshop_list_country_id_fk` FOREIGN KEY (`country_id`) REFERENCES `list_country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

INSERT INTO `workshop` (`id`, `country_id`, `city_id`, `logo`, `ar_name`, `en_name`, `ar_description`, `en_description`, `ar_address`, `en_address`, `mobile`, `email`, `telephone`, `website`, `google_lat`, `google_lng`, `start_from`, `end_at`, `totl_rate`) VALUES
	(44, 1, 3, 'workshop/4V2TPVmpBoTLOuag6v2wySd1tzcKhJ9Y8BrhR2eG.png', 'العالم الجميل', 'Beauty World', 'عربي شرح عن العملعربي شرح عن العمل عربي شرح عن العمل عربي شرح عن العمل', 'English descrition labm lob leee mansd dan English descrition labm lob leee mansd dan', 'Rose tower1', 'Rose tower1', '0562133692', 'w3maker@gmail.com', '0562133692', NULL, '25.319203853422113', '55.38772363448493', '08:00', '00:00', 3.9),
	(47, 1, 3, 'workshop/NymEkprSIHqvu3ycynf10vjaDdHretCKb8Ass3YP.jpeg', 'الفنان', 'ArtIst', 'عربي شرح عن العملعربي شرح عن العمل عربي شرح عن العمل عربي شرح عن العمل', 'English descrition labm lob leee mansd dan English descrition labm lob leee mansd dan', 'Rose tower1', 'Rose tower1', '05622222223', 'tstststs@tstyyy.com', '0565656565', NULL, '25.317182220987718', '55.39727365047963', '09:00', '22:00', 4.3),
	(49, 1, 3, NULL, 'sdfsdfs', 'sdfsdf', NULL, 'sdfsdf', 'sdf', 'sdf', '056545', 'sdfsdf@sdfd.com', '05465454', 'sdfsdf.com', '25.3222672', '55.3754882', '10:00', '00:00', NULL);
	

CREATE TABLE IF NOT EXISTS `workshop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_id` int(11) DEFAULT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_categories_service_sub_category_id_fk` (`sub_cat_id`),
  KEY `workshop_categories_workshop_id_fk` (`workshop_id`),
  CONSTRAINT `workshop_categories_service_sub_category_id_fk` FOREIGN KEY (`sub_cat_id`) REFERENCES `service_sub_category` (`id`),
  CONSTRAINT `workshop_categories_workshop_id_fk` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

INSERT INTO `workshop_categories` (`id`, `sub_cat_id`, `workshop_id`) VALUES
	(139, 3, 44),
	(140, 5, 44),
	(141, 6, 44),
	(142, 7, 44),
	(147, 3, 47),
	(148, 5, 47),
	(149, 6, 47),
	(150, 7, 47);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `workshop_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `customer_id_type` (`workshop_id`,`type`),
  UNIQUE KEY `mobile` (`mobile`),
  CONSTRAINT `FK_users_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `workshop_id`, `name`, `image`, `email`, `mobile`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active`, `type`) VALUES
	(1, NULL, 'Test User1', '', 'test1@test.com', NULL, '2019-06-17 20:58:50', '$2y$10$5vFCWyCjATEbnBhFp8KfR.6cv4ZAnyiKCZ6ejnA7MkGYEXWgaruGK', NULL, '2019-06-17 20:58:50', '2019-06-17 20:58:50', 0, 'admin'),
	(2, NULL, 'Tariq Momani', 'profile/2/1562783930.jpeg', 'tmomani@3wmaker.com', '0562133691', NULL, '$2y$10$yUP6HEvNLuUX9hHD3.Auw.B7XUsRz2DYv4hSb44qBZT.qj2Jcn7k2', 'mgdQ69FUWuNwOeANvkkL9rPdmsiVAs0S7Sqe1gS5qn694k3sXgR2y1bMQv3Q', '2019-04-27 11:18:07', '2019-04-27 11:18:07', 1, 'admin'),
	(18, 44, 'Beauty World', 'profile/2/1562783930.jpeg', 'w3maker123@gmail.com', NULL, NULL, '$2y$10$h9fVsmCxGymAwJN93Po/0eJ.7B2h5BPdVbSQE/3yej/TE6FNP.MnO', NULL, NULL, NULL, 1, 'workshop'),
	(42, NULL, 'Test Customer', NULL, 'tmomanittt@3wmaker.com', '056323232', NULL, '$2y$10$b3BIkr5Sf/PC6.pPf.bpvOcMjW2rAIrReDrORklakzyNYZk.9QoSi', NULL, NULL, NULL, 1, 'customer'),
	(43, NULL, 'Test number2', NULL, 'testststs@tsts.ae', '0566666666', NULL, '$2y$10$nlOKpz5/kZ7tgzOZZGSWPON18K7vEDNhyPryCX0B8uR4VgmORVs7.', NULL, NULL, NULL, 1, 'customer'),
	(44, 47, 'ArtIst', NULL, 'tstststs@tstyyy.com', '05622222223', NULL, '$2y$10$xNe.BB8Wg6hUFoANRWqBwekHqTY6Pcc4QBJfdkMsB0eK65S5jHxM2', NULL, NULL, NULL, 1, 'workshop'),
	(46, NULL, 'Test', NULL, 'paypal@3wmaker.com', NULL, NULL, '$2y$10$IHwAq.gQsN/ho.QqrOCaTesxCBwatauwqZPYd2ZikNGRG1n.nZGKy', NULL, NULL, NULL, 1, NULL),
	(47, 49, 'test test', NULL, 'tmomani35@3wmaker.com', '56222222', NULL, '$2y$10$phUUAJBl9CfqFNfM4O0xLefo1eLt6BiUipdftJ/fF9VYu.FdOpaKa', NULL, NULL, NULL, 1, 'workshop');

CREATE TABLE IF NOT EXISTS `users_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `send_to` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `valid` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_users_validation_users` (`user_id`),
  CONSTRAINT `FK_users_validation_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT 0,
  `model` varchar(50) DEFAULT NULL,
  `origin` varchar(50) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `eng_no` varchar(50) DEFAULT NULL,
  `chassis_no` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deleted` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK__users` (`user_id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `car` (`id`, `user_id`, `model`, `origin`, `vehicle_type`, `eng_no`, `chassis_no`, `image`, `deleted`) VALUES
	(1, 43, '2016', 'JAPAN', 'MITSUBISHI', '6G74YL9272', 'JMYLYV95WGJ730934', NULL, 0),
	(2, 2, '2012', 'ASDASD', 'ASDA', 'ASDASD', 'SDASD', 'car/2/2_1562783942.jpeg', 0),
	(3, 47, 'TEST DATA', 'KORI', 'BMW', 'EN6564654NO', 'CH098798789NO', NULL, 0);

CREATE TABLE IF NOT EXISTS `car_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` int(10) DEFAULT 0,
  `user_id` int(10) unsigned DEFAULT 0,
  `workshop_id` int(10) DEFAULT 0,
  `note` varchar(255) DEFAULT '0',
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime DEFAULT NULL,
  `price` float DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_car_history_car` (`car_id`),
  KEY `FK_car_history_users` (`user_id`),
  KEY `FK_car_history_workshop` (`workshop_id`),
  CONSTRAINT `FK_car_history_car` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
  CONSTRAINT `FK_car_history_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_car_history_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `car_history` (`id`, `car_id`, `user_id`, `workshop_id`, `note`, `date_in`, `date_out`, `price`) VALUES
	(3, 2, 2, 44, 'Test data for only view', '2019-07-10 12:50:37', '2019-07-10 12:50:39', 200),
	(4, 2, 2, 44, 'فثسف سيبسيب شسيشسي', '2019-07-10 13:02:17', '2019-07-10 13:02:19', 160);

CREATE TABLE IF NOT EXISTS `workshop_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT 0,
  `workshop_id` int(11) DEFAULT 0,
  `request_dat` datetime DEFAULT NULL,
  `action` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Dumping data for table karaj.workshop_request: ~3 rows (approximately)
/*!40000 ALTER TABLE `workshop_request` DISABLE KEYS */;
INSERT INTO `workshop_request` (`id`, `car_id`, `workshop_id`, `request_dat`, `action`) VALUES
	(5, 2, 47, '2019-07-11 20:27:14', 'new'),
	(6, 2, 44, '2019-09-06 20:40:10', 'new'),
	(7, 3, 44, '2019-09-15 11:46:17', 'new');


CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned DEFAULT NULL,
  `to_id` int(10) unsigned DEFAULT NULL,
  `reques_id` int(11) DEFAULT NULL,
  `noti_date` datetime DEFAULT NULL,
  `noti_text` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_notification_form_id_users` (`form_id`),
  KEY `FK_notification_to_id_users_2` (`to_id`),
  KEY `FK_notification_workshop_request` (`reques_id`),
  CONSTRAINT `FK_notification_form_id_users` FOREIGN KEY (`form_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_notification_to_id_users_2` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_notification_workshop_request` FOREIGN KEY (`reques_id`) REFERENCES `workshop_request` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `notification` (`id`, `form_id`, `to_id`, `reques_id`, `noti_date`, `noti_text`, `status`) VALUES
	(4, 2, 44, 5, '2019-07-11 20:27:14', 'request', 'new'),
	(5, 2, 18, 6, '2019-09-06 20:40:10', 'request', 'new'),
	(6, 47, 18, 7, '2019-09-15 11:46:17', 'request', 'new');

CREATE TABLE IF NOT EXISTS `workshop_calender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT 0,
  `user_id` int(10) unsigned DEFAULT 0,
  `workshop_id` int(11) DEFAULT 0,
  `request_id` int(11) DEFAULT NULL,
  `date_in` datetime DEFAULT NULL,
  `date_out` datetime DEFAULT NULL,
  `issue_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_workshop_calender_car` (`car_id`),
  KEY `FK_workshop_calender_users` (`user_id`),
  KEY `FK_workshop_calender_workshop` (`workshop_id`),
  KEY `FK_workshop_calender_workshop_request` (`request_id`),
  CONSTRAINT `FK_workshop_calender_car` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
  CONSTRAINT `FK_workshop_calender_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_workshop_calender_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`),
  CONSTRAINT `FK_workshop_calender_workshop_request` FOREIGN KEY (`request_id`) REFERENCES `workshop_request` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `workshop_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `Column 5` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workshop_rate_fk` (`workshop_id`),
  KEY `customer_fk_rate` (`customer_id`),
  CONSTRAINT `workshop_rate_fk` FOREIGN KEY (`workshop_id`) REFERENCES `workshop` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

