# Host: 127.0.0.1  (Version 5.5.5-10.4.32-MariaDB)
# Date: 2025-08-09 18:22:04
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "akun_regis"
#

DROP TABLE IF EXISTS `akun_regis`;
CREATE TABLE `akun_regis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `unit` varchar(25) DEFAULT NULL,
  `ap` varchar(3) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "akun_regis"
#

INSERT INTO `akun_regis` VALUES (92,'DRAGUNOV','DRAG.UNO.V','HO_MJL',NULL,'6285399014003','Pria','2025-03-16 17:39:33','2025-03-16 17:39:33'),(93,'JIN KAZAMA','1234.MTK.2222','BNJ',NULL,'6285399014003','Pria','2025-03-29 14:24:51','2025-03-29 14:24:51'),(94,'LEROY SMITH','1236.MTK.0092','BWN',NULL,'6285399014003','Pria','2025-03-29 14:25:25','2025-03-29 14:25:25'),(95,'KAZUYA MISHIMA','7722.MTK.1133','CIA',NULL,'6285399014003','Pria','2025-03-29 14:26:51','2025-03-29 14:26:51'),(96,'LEON SCOOT KENNEDY','1254.MTK.9933','KRA',NULL,'6285399014003','Pria','2025-03-29 14:33:21','2025-03-29 14:33:21'),(97,'ADA WONG','2211.MTK.3211','CJR',NULL,'6285399014003','Wanita','2025-03-29 14:33:52','2025-03-29 14:33:52'),(98,'OBI WAN','0077.MTK.9933','BSN',NULL,'6285399014003','Pria','2025-03-29 14:34:26','2025-03-29 14:34:26'),(99,'ANAKIN SKYWALKER','4110.MTK.6688','TRG',NULL,'6285399014003','Pria','2025-03-29 14:35:58','2025-03-29 14:35:58');

#
# Structure for table "answer_vote"
#

DROP TABLE IF EXISTS `answer_vote`;
CREATE TABLE `answer_vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `id_jawaban` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `jawaban` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "answer_vote"
#


#
# Structure for table "comments"
#

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `clip` varchar(100) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "comments"
#


#
# Structure for table "comments_likes"
#

DROP TABLE IF EXISTS `comments_likes`;
CREATE TABLE `comments_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_comment` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "comments_likes"
#

INSERT INTO `comments_likes` VALUES (1,1,4,'admin','We must be better','2025-08-06 19:18:09','2025-08-06 19:18:09'),(2,2,4,'admin','test','2025-08-06 19:18:18','2025-08-06 19:18:18');

#
# Structure for table "comments_replies"
#

DROP TABLE IF EXISTS `comments_replies`;
CREATE TABLE `comments_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_comment` int(11) NOT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `comment` text NOT NULL,
  `clip` varchar(100) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "comments_replies"
#


#
# Structure for table "failed_jobs"
#

DROP TABLE IF EXISTS `failed_jobs`;
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

#
# Data for table "failed_jobs"
#


#
# Structure for table "logs"
#

DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `activity` tinytext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "logs"
#

INSERT INTO `logs` VALUES (1,'2025-07-12','admin','Login ke sistem Pendarrasa','2025-07-12 12:44:04','2025-07-12 12:44:04'),(2,'2025-07-12','admin','Keluar dari sistem Pendarrasa','2025-07-12 19:05:38','2025-07-12 19:05:38'),(5,'2025-07-12','user.it','Login ke sistem Pendarrasa','2025-07-12 19:31:33','2025-07-12 19:31:33'),(6,'2025-07-13','user.it','Keluar dari sistem Pendarrasa','2025-07-13 06:22:25','2025-07-13 06:22:25'),(8,'2025-07-13','user.it','Login ke sistem Pendarrasa','2025-07-13 06:25:21','2025-07-13 06:25:21'),(9,'2025-07-13','user.it','Keluar dari sistem Pendarrasa','2025-07-13 22:59:35','2025-07-13 22:59:35'),(10,'2025-07-13','ashley.it','Login ke sistem Pendarrasa','2025-07-13 22:59:41','2025-07-13 22:59:41'),(11,'2025-07-13','ashley.it','Keluar dari sistem Pendarrasa','2025-07-13 23:03:18','2025-07-13 23:03:18'),(12,'2025-07-13','admin','Login ke sistem Pendarrasa','2025-07-13 23:03:25','2025-07-13 23:03:25'),(13,'2025-08-06','admin','Login ke sistem Pendarrasa','2025-08-06 17:46:11','2025-08-06 17:46:11'),(14,'2025-08-06','admin','Keluar dari sistem Pendarrasa','2025-08-06 18:37:45','2025-08-06 18:37:45'),(15,'2025-08-06','admin','Login ke sistem Pendarrasa','2025-08-06 18:38:20','2025-08-06 18:38:20'),(16,'2025-08-06','admin','Keluar dari sistem Pendarrasa','2025-08-06 18:53:26','2025-08-06 18:53:26'),(17,'2025-08-06','user.it','Login ke sistem Pendarrasa','2025-08-06 18:53:41','2025-08-06 18:53:41'),(18,'2025-08-06','user.it','Keluar dari sistem Pendarrasa','2025-08-06 18:54:51','2025-08-06 18:54:51'),(19,'2025-08-06','ashley.it','Login ke sistem Pendarrasa','2025-08-06 18:54:58','2025-08-06 18:54:58'),(20,'2025-08-06','ashley.it','Keluar dari sistem Pendarrasa','2025-08-06 19:10:29','2025-08-06 19:10:29'),(21,'2025-08-06','admin','Login ke sistem Pendarrasa','2025-08-06 19:10:41','2025-08-06 19:10:41');

#
# Structure for table "message"
#

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "message"
#


#
# Structure for table "migrations"
#

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "migrations"
#

INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_10_20_999999_add_active_status_to_users',2),(6,'2024_10_20_999999_add_avatar_to_users',2),(7,'2024_10_20_999999_add_dark_mode_to_users',2),(8,'2024_10_20_999999_add_messenger_color_to_users',2),(9,'2024_10_20_999999_create_chatify_favorites_table',2),(10,'2024_10_20_999999_create_chatify_messages_table',2),(11,'2024_10_24_999999_add_active_status_to_users',3),(12,'2024_10_24_999999_add_avatar_to_users',3),(13,'2024_10_24_999999_add_dark_mode_to_users',3),(14,'2024_10_24_999999_add_messenger_color_to_users',3),(15,'2024_10_24_999999_create_chatify_favorites_table',3),(16,'2024_10_24_999999_create_chatify_messages_table',3),(17,'2024_10_26_999999_add_active_status_to_users',4),(18,'2024_10_26_999999_add_avatar_to_users',4),(19,'2024_10_26_999999_add_dark_mode_to_users',4),(20,'2024_10_26_999999_add_messenger_color_to_users',4),(21,'2024_10_26_999999_create_chatify_favorites_table',4),(22,'2024_10_26_999999_create_chatify_messages_table',4);

#
# Structure for table "notif_badge"
#

DROP TABLE IF EXISTS `notif_badge`;
CREATE TABLE `notif_badge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `value` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_badge"
#

INSERT INTO `notif_badge` VALUES (1,'admin',3,'2025-07-12 12:44:04','2025-08-06 19:18:46'),(3,'user.it',0,'2025-07-12 19:31:33','2025-07-12 19:31:33'),(4,'ashley.it',3,'2025-07-13 22:59:41','2025-08-06 19:18:36'),(5,'daniel.it',0,'2025-08-06 19:19:46','2025-08-06 19:19:46');

#
# Structure for table "notif_post"
#

DROP TABLE IF EXISTS `notif_post`;
CREATE TABLE `notif_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT 'Membagikan Postingan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_post"
#


#
# Structure for table "notif_post_comment"
#

DROP TABLE IF EXISTS `notif_post_comment`;
CREATE TABLE `notif_post_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_comment` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT 'Mengomentari Postingan Anda:',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_post_comment"
#


#
# Structure for table "notif_post_commentbalas"
#

DROP TABLE IF EXISTS `notif_post_commentbalas`;
CREATE TABLE `notif_post_commentbalas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_comment` int(11) DEFAULT NULL,
  `id_commentReplies` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT 'Membalas Komentar Anda:',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_post_commentbalas"
#


#
# Structure for table "notif_post_commentlike"
#

DROP TABLE IF EXISTS `notif_post_commentlike`;
CREATE TABLE `notif_post_commentlike` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_comment` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT 'Menyukai Komentar Anda:',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_post_commentlike"
#


#
# Structure for table "notif_post_like"
#

DROP TABLE IF EXISTS `notif_post_like`;
CREATE TABLE `notif_post_like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `info` varchar(50) DEFAULT 'Menyukai Postingan Anda',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "notif_post_like"
#


#
# Structure for table "password_resets"
#

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "password_resets"
#


#
# Structure for table "personal_access_tokens"
#

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "personal_access_tokens"
#


#
# Structure for table "poll_answers"
#

DROP TABLE IF EXISTS `poll_answers`;
CREATE TABLE `poll_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `jawaban` varchar(150) DEFAULT NULL,
  `value` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "poll_answers"
#

INSERT INTO `poll_answers` VALUES (1,1,3,'Yes',0,'2025-07-12 19:40:02','2025-07-12 19:40:02'),(2,1,3,'Not yet',0,'2025-07-12 19:40:02','2025-07-12 19:40:02');

#
# Structure for table "polls"
#

DROP TABLE IF EXISTS `polls`;
CREATE TABLE `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `soal` longtext DEFAULT NULL,
  `voting` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "polls"
#

INSERT INTO `polls` VALUES (1,3,'user.it','Have you ever played the Resident Evil series before?',1,'2025-07-12 19:40:02','2025-07-12 19:40:02');

#
# Structure for table "post_gambar"
#

DROP TABLE IF EXISTS `post_gambar`;
CREATE TABLE `post_gambar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `media` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "post_gambar"
#

INSERT INTO `post_gambar` VALUES (1,1,'1752321762_61rWCEI11M.jpeg','2025-07-12 19:02:43','2025-07-12 19:02:43'),(2,2,'https://youtu.be/8yh9BPUBbbQ?si=RaThySe1N-QcCDQ0','2025-07-12 19:28:22','2025-07-12 19:28:22'),(3,3,'https://www.youtube.com/watch?v=POz1-EmLsTY','2025-07-12 19:39:03','2025-07-12 19:39:03'),(4,3,'1752323943_w7QizeoI97.jpg','2025-07-12 19:39:03','2025-07-12 19:39:03'),(5,3,'1752323943_S3f7m7DzFR.png','2025-07-12 19:39:03','2025-07-12 19:39:03'),(6,3,'1752323943_74LxeBBhzf.png','2025-07-12 19:39:04','2025-07-12 19:39:04'),(7,3,'https://youtu.be/UChAP-zibHw?si=gbLxAIGlFmImyjwE','2025-07-12 19:39:04','2025-07-12 19:39:04'),(8,4,'https://youtu.be/EE-4GvjKcfs?si=79JNpc0GnW2b7Rd9','2025-07-13 23:02:14','2025-07-13 23:02:14'),(9,4,'1752422534_iDULj8Rilt.jpg','2025-07-13 23:02:14','2025-07-13 23:02:14');

#
# Structure for table "post_like"
#

DROP TABLE IF EXISTS `post_like`;
CREATE TABLE `post_like` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "post_like"
#


#
# Structure for table "posts"
#

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(100) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `media` varchar(50) DEFAULT NULL,
  `media_file` varchar(50) DEFAULT NULL,
  `deskripsi` longtext DEFAULT NULL,
  `like` int(11) DEFAULT 0,
  `komen` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "posts"
#

INSERT INTO `posts` VALUES (1,'admin','Laravel',NULL,NULL,'<p>Laravel is a web application framework with expressive, elegant syntax. A web framework provides a structure and starting point for creating your application, allowing you to focus on creating something amazing while we sweat the details.</p>\r\n<p>Laravel strives to provide an amazing developer experience while providing powerful features such as thorough dependency injection, an expressive database abstraction layer, queues and scheduled jobs, unit and integration testing, and more.</p>\r\n<p>Whether you are new to PHP or web frameworks or have years of experience, Laravel is a framework that can grow with you. We\'ll help you take your first steps as a web developer or give you a boost as you take your expertise to the next level. We can\'t wait to see what you build.</p>',0,0,'2025-07-12 19:02:42','2025-07-12 19:02:42'),(2,'user.it','F1® The Movie | Main Trailer',NULL,NULL,'<p>From Apple Original Films and the filmmakers from Top Gun: Maverick comes the high-octane, action-packed feature film F1® The Movie, starring Brad Pitt and directed by Joseph Kosinski.  The film is produced by Jerry Bruckheimer, Kosinski, seven-time FORMULA 1® world champion Lewis Hamilton, Pitt, Dede Gardner, Jeremy Kleiner and Chad Oman.\r\n\r\nDubbed “the greatest that never was,” Sonny Hayes (Brad Pitt) was FORMULA 1’s most promising phenom of the 1990s until an accident on the track nearly ended his career.  Thirty years later, he’s a nomadic racer-for-hire when he’s approached by his former teammate Ruben Cervantes (Javier Bardem), owner of a struggling FORMULA 1 team that is on the verge of collapse.  Ruben convinces Sonny to come back to FORMULA 1 for one last shot at saving the team and being the best in the world.  He’ll drive alongside Joshua Pearce (Damson Idris), the team\'s hotshot rookie intent on setting his own pace.  But as the engines roar, Sonny’s past catches up with him and he finds that in FORMULA 1, your teammate is your fiercest competition—and the road to redemption is not something you can travel alone.\r\n\r\nF1® The Movie also stars Damson Idris, Kerry Condon, Tobias Menzies, Kim Bodnia, and Javier Bardem, and was shot during actual Grand Prix weekends as the team competed against the titans of the sport.\r\n\r\nKosinski directs from a screenplay by Ehren Kruger, story by Kosinski & Kruger.  The film is executive produced by Daniel Lupi.  Collaborating with Kosinski behind the scenes are his creative team, including director of photography Claudio Miranda, production designers Mark Tildesley and Ben Munro, editor Stephen Mirrione, costume designer Julian Day, casting director Lucy Bevan and composer Hans Zimmer.\r\n\r\nApple Original Films and Warner Bros. Pictures Present A Monolith Pictures / Jerry Bruckheimer / Plan B Entertainment / Dawn Apollo Films Production, A Joseph Kosinski Film, F1® The Movie, distributed worldwide by Warner Bros. Pictures, in theaters and IMAX® nationwide on June 27, 2025 and internationally beginning 25 June 2025.</p>',0,0,'2025-07-12 19:28:22','2025-07-12 19:28:22'),(3,'user.it','Resident Evil 9 Requiem',NULL,NULL,'<p>Requiem for the dead.</p>\r\n<p>Nightmare for the living. Resident Evil Requiem is the highly anticipated ninth title in the mainline Resident Evil series.&nbsp;</p>\r\n<p>Prepare to escape death in a heart-stopping experience that will chill you to your core.&nbsp;</p>\r\n<p>A new era of survival horror begins when Resident Evil Requiem launches February 27, 2026 for PlayStation&reg;5, Xbox Series X|S and Steam.</p>',0,0,'2025-07-12 19:39:03','2025-07-12 19:39:03'),(4,'ashley.it','God Of War Ragnarök',NULL,NULL,'<p>God&nbsp;<em>of War R</em>agnar&ouml;k is an action-adventure game where players take the role of Kratos and his son as they embark on a quest to prevent the coming of Ragnar&ouml;k.</p>',0,0,'2025-07-13 23:02:14','2025-08-06 19:18:46');

#
# Structure for table "saves"
#

DROP TABLE IF EXISTS `saves`;
CREATE TABLE `saves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "saves"
#


#
# Structure for table "tbl_ai"
#

DROP TABLE IF EXISTS `tbl_ai`;
CREATE TABLE `tbl_ai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `text` longtext DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "tbl_ai"
#

INSERT INTO `tbl_ai` VALUES (2,'admin','Requiem for the dead.\r\nNightmare for the living. Resident Evil Requiem is the highly anticipated ninth title in the mainline Resident Evil series.&nbsp;\r\nPrepare to escape death in a heart-stopping experience that will chill you to your core.&nbsp;\r\nA new era of survival horror begins when Resident Evil Requiem launches February 27, 2026 for PlayStation&reg;5, Xbox Series X|S and Steam.','Penjelasan teks tersebut adalah sebagai berikut:\n\nTeks tersebut merupakan pengumuman dan deskripsi singkat mengenai game terbaru dalam seri Resident Evil, berjudul \"Resident Evil Requiem\". Berikut rinciannya:\n\n*   **Judul:** Resident Evil Requiem\n*   **Posisi dalam Seri:** Game kesembilan dalam seri utama Resident Evil.\n*   **Tema:** Requiem untuk yang mati, mimpi buruk bagi yang hidup. Ini mengindikasikan narasi yang kelam dan menakutkan.\n*   **Pengalaman:** Dijanjikan pengalaman yang menegangkan dan sangat menakutkan.\n*   **Genre:** Dimulai era baru untuk survival horror.\n*   **Tanggal Rilis:** 27 Februari 2026.\n*   **Platform:** PlayStation 5, Xbox Series X|S, dan Steam (PC).\n\nSingkatnya, teks ini adalah **iklan dan deskripsi singkat** yang bertujuan untuk membangkitkan antisipasi untuk game Resident Evil Requiem yang akan datang. Tujuannya adalah untuk membuat pembaca tertarik dengan game tersebut dengan menyoroti tema yang menakutkan, pengalaman menegangkan, dan ketersediaan di berbagai platform.','','2025-08-06 18:43:13','2025-08-06 18:43:13');

#
# Structure for table "tbl_history_ai"
#

DROP TABLE IF EXISTS `tbl_history_ai`;
CREATE TABLE `tbl_history_ai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "tbl_history_ai"
#

INSERT INTO `tbl_history_ai` VALUES (3,'admin','user','Requiem for the dead.\r\nNightmare for the living. Resident Evil Requiem is the highly anticipated ninth title in the mainline Resident Evil series.&nbsp;\r\nPrepare to escape death in a heart-stopping experience that will chill you to your core.&nbsp;\r\nA new era of survival horror begins when Resident Evil Requiem launches February 27, 2026 for PlayStation&reg;5, Xbox Series X|S and Steam.','2025-08-06 18:43:13'),(4,'admin','assistant','Penjelasan teks tersebut adalah sebagai berikut:\n\nTeks tersebut merupakan pengumuman dan deskripsi singkat mengenai game terbaru dalam seri Resident Evil, berjudul \"Resident Evil Requiem\". Berikut rinciannya:\n\n*   **Judul:** Resident Evil Requiem\n*   **Posisi dalam Seri:** Game kesembilan dalam seri utama Resident Evil.\n*   **Tema:** Requiem untuk yang mati, mimpi buruk bagi yang hidup. Ini mengindikasikan narasi yang kelam dan menakutkan.\n*   **Pengalaman:** Dijanjikan pengalaman yang menegangkan dan sangat menakutkan.\n*   **Genre:** Dimulai era baru untuk survival horror.\n*   **Tanggal Rilis:** 27 Februari 2026.\n*   **Platform:** PlayStation 5, Xbox Series X|S, dan Steam (PC).\n\nSingkatnya, teks ini adalah **iklan dan deskripsi singkat** yang bertujuan untuk membangkitkan antisipasi untuk game Resident Evil Requiem yang akan datang. Tujuannya adalah untuk membuat pembaca tertarik dengan game tersebut dengan menyoroti tema yang menakutkan, pengalaman menegangkan, dan ketersediaan di berbagai platform.','2025-08-06 18:43:13');

#
# Structure for table "tbl_pt"
#

DROP TABLE IF EXISTS `tbl_pt`;
CREATE TABLE `tbl_pt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `koderegion` varchar(20) DEFAULT NULL,
  `namaregion` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "tbl_pt"
#


#
# Structure for table "units"
#

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kodeunit` varchar(10) DEFAULT NULL,
  `namaunit` varchar(50) NOT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `lat` longtext DEFAULT NULL,
  `lon` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "units"
#

INSERT INTO `units` VALUES (1,'BTG','BATANG','','-7.0161805','109.9167441'),(2,'KJN','KAJEN','','-7.032875','109.584254'),(3,'PML','PEMALANG','PERUM VICTORIA Blok D 8 Duku Bandelan 2 DESA Taman, Kec. Taman, Kabupaten Pemalang, Jawa Tengah 52361','-6.8960947','109.420214'),(4,'PKL','PEKALONGAN','','-6.9027567','109.658459'),(5,'SMD','SUMEDANG','','-6.8435445','107.9136172'),(6,'SBG','SUBANG','','-6.5628233','107.7472459'),(7,'MJK','MAJALENGKA','','-6.8385807','108.2464123'),(8,'CJR','CIANJUR','JL. KH. ABDULLAH BIN NUH PERUM PESONA CIANJUR INDAH BLOK H4 NO 2-3 RT 04 RW 15 DESA NAGRAK KEC. CIANJUR KAB. CIANJUR KODE POS 43215','-6.8341852','107.1119126'),(9,'BDG','BANDUNG','','-6.9172724','107.4961624'),(10,'BMA','BUMIAYU','','-7.2497433','109.0046525'),(11,'BRB','BREBES','','-6.872433','109.1192636'),(12,'TGL','TEGAL','','-6.9679425','109.1304999'),(13,'PBG','PURBALINGGA','','-7.4009684','109.3622012'),(14,'BJN','BANJARNEGARA','','-7.3824142','109.3604748'),(15,'PWT','PURWOKERTO','PERUM GRIYA SATRIA PERMAI 2 NO 15 SUMAMPIR\nPURWOKERTO UTARA','-7.403593','109.2374333'),(16,'CLP','CILACAP','','-7.6241683','109.250438'),(17,'KBM','KEBUMEN','','-7.6737803','109.6446142'),(18,'MGL','MAGELANG','','-7.4371031','110.2299691'),(19,'TMG','TEMANGGUNG','','-7.3187706','110.1766225'),(20,'WNB','WONOSOBO','','-7.3501997','109.9028997'),(21,'MGT','MAGETAN','','-7.6447163','111.3095255'),(22,'MDN','MADIUN','','-7.6386936','111.5328866'),(23,'PNG','PONOROGO','Jl. Halim Perdana Kusuma, Kepatihan, Ponorogo, Jawa Timur','-7.8702376','111.4961024'),(24,'NGW','NGAWI','Jl. Sudirman, RT.:003 RW:002, Kb. Agung, Keras Wetan, Kec. Geneng, Kabupaten Ngawi, Jawa Timur 63271','-7.530477923115392',' 111.42890151731378'),(25,'GML','GEMOLONG','','-7.3952052','110.8290483'),(26,'SKH','SUKOHARJO','','-7.605346','110.8057975'),(27,'MTG','MANTINGAN','','-7.375945','111.1403246'),(28,'KLT','KLATEN','','-7.6933277','110.616886'),(29,'SGN','SRAGEN','','-7.4227562','111.0095079'),(30,'WNG','WONOGIRI','','-7.8147875','110.9311412'),(31,'KRA','KARANGANYAR','','-7.5962682','110.9231772'),(32,'KDR','KEDIRI','Perumahan BTN Rejomulyo GG III No 62 RT 002 RW 001 Rejomulyo Kota, Kota Kediri, Jawa Timur','-7.852194',' 112.028378'),(33,'BLR','BLORA','','-6.961451','111.424728'),(34,'RBG','REMBANG','','-6.7326386','111.3537247'),(35,'BJO','BOJONEGORO','','-7.16011','111.8762851'),(36,'PTI','PATI','','-6.7465009','111.0246948'),(37,'KDS','KUDUS','','-6.7823138','110.8613729'),(38,'JPR','JEPARA','DK Krajan RT 2/1 Senenan Tahunan Jepara 59246','-6.6088596','110.6807795'),(39,'PWD','PURWODADI','','-7.0803875','110.917865'),(40,'SMG','SEMARANG','','-7.0900136','110.3133606'),(41,'BJA','BOJA','','-7.089821','110.3129632'),(42,'UNG','UNGARAN','','-7.1207698','110.4008572'),(43,'GDO','GODONG','','-7.0206503','110.6969304'),(44,'DMK','DEMAK','','-7.0260039','110.4942619'),(45,'KLA','KALIKONDANG','','-6.8804856','110.618943'),(46,'LSR','LOSARI','','-6.9386595','108.8902192'),(47,'PTR','PATROL','','-6.3300515','107.9410922'),(48,'IDM','INDRAMAYU','','-6.7094829','108.4474931'),(49,'CIA','CIAMIS','','-7.3070222','108.2375322'),(50,'PPT','PRAPATAN','','-6.698256','108.3560661'),(51,'CRB','CIREBON','','-6.7385659','108.5628189'),(52,'PDG','PANDEGLANG','','',''),(53,'BTL','BANTUL','','-7.8271307','110.3784498'),(54,'KLP','KULONPROGO','','-7.8525815','110.1577224'),(55,'GKD','GUNUNGKIDUL','','-7.9302863','110.5536097'),(56,'SMN','SLEMAN','','-7.7201424','110.3516006'),(57,'KTA','KUTOARJO','','-7.7272746','109.9130982'),(58,'BWN','BAWEN','','-7.242145','110.4339695'),(59,'SLG','SALATIGA','','-7.3418712','110.4885881'),(60,'GRB','GRABAG','','-7.3696341','110.3063076'),(61,'KRD','KARANGGEDE','','-7.3539987','110.6394851'),(62,'BYL','BOYOLALI','','-7.5393231','110.5994872'),(63,'BSW','BANDAR SRIBHAWONO','','-0','0'),(64,'BDL','BANDAR LAMPUNG','','-0','0'),(65,'JMR','JEMBER','','',''),(66,'BSN','BANJARMASIN','','0','0'),(67,'JBG','JOMBANG','Perumahan BTN Rejomulyo GG III No 62 RT 002 RW 001 Rejomulyo Kota, Kota Kediri, Jawa Timur','-7.852194',' 112.028378'),(68,'TBN','TUBAN','','-0','0'),(69,'GSK','GRESIK','','-0','0'),(70,'TRG','TAROGONG','','',''),(71,'BNJ','BANJAR PATROMAN','','',''),(72,'BGR','BOGOR','','',''),(73,'MYR','MANYARAN','','-0','0'),(74,'HO_MJL','SEMARANG','Ruko Royal Square, Jl. Marina Raya No.42 blok A, Tawangsari, Kec. Semarang Barat, Kota Semarang, Jawa Tengah 50144','-6.956792,','110.391487'),(76,'HO_BRU','BAROKAH RESTU UTAMA',NULL,NULL,NULL),(77,'HO_BTB','BINTANG TERANG BERSINAR',NULL,NULL,NULL),(78,'HO_GPS','GILAR PERWIRA SATRIA',NULL,NULL,NULL),(79,'HO_KLB','KEDU LINTAS BERBINTANG',NULL,NULL,NULL),(80,'HO_KSM','KARYA SATWA MULIA',NULL,NULL,NULL),(81,'HO_LAN','LAWU ABADI NUSA',NULL,NULL,NULL),(82,'HO_LSW','LAJU SATWA WISESA',NULL,NULL,NULL),(83,'HO_MJR','MURIA JAYA RAYA',NULL,NULL,NULL),(84,'HO_MMB','MITRA MAHKOTA BUANA',NULL,NULL,NULL),(85,'HO_MPU','MITRA PETERNAKAN UNGGAS',NULL,NULL,NULL),(86,'HO_MUM','MITRA UNGGAS MAKMUR',NULL,NULL,NULL),(87,'HO_SGA','SAWUNG GEMA ABADI',NULL,NULL,NULL);

#
# Structure for table "users"
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `ap` varchar(3) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'User',
  `foto` text DEFAULT NULL,
  `no_hp` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`nik`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

#
# Data for table "users"
#

INSERT INTO `users` VALUES (1,'Admin','admin','HO_MJL',NULL,'Pria','$2y$10$1aDvtWVpNjRiPI3D9QxsSuDeNd0xs43U5uEkK7j5khr2T9dYq2Lcy','Admin',NULL,'6285399014003','2025-07-12 12:43:15','2025-08-06 19:20:20'),(3,'User','user.it','TGL',NULL,'Pria','$2y$10$C1QrCYIoNNlN7h1NLZrYYevNgEjnYFdJoreMyntCo6V7E64C38Sxa','User',NULL,'12001210201','2025-07-12 12:45:05','2025-07-12 12:45:05'),(4,'leone','leone.it','TGL',NULL,'Pria','$2y$10$GXTYCEZ4z6Im.i39UkfJ.uhmacHmwBHCG6MvMDeWAW//jS6YTx7si','Pengamat',NULL,'44545454','2025-07-12 12:45:33','2025-07-12 12:45:33'),(5,'Ashley','ashley.it','PWT',NULL,'Wanita','$2y$10$WYxXLVuLIDZuPRFUfOWlJOUQMc8xrFZ.nVazlyFr8NgfWHIDeuUs.','Anonymous',NULL,'6288228714761','2025-07-12 12:46:26','2025-07-12 12:46:26');
