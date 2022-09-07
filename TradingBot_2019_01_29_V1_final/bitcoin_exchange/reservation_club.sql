/*
SQLyog Community
MySQL - 10.1.32-MariaDB : Database - reservation_club
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`reservation_club` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `reservation_club`;

/*Table structure for table `admins` */

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `midname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`firstname`,`midname`,`lastname`,`email`,`address`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','admin','admin','admin@admin.com','test','$2y$10$IEqDjNIrp2WwshhArY64F.G9Je2132PMA02Yk1Jy0H25BAaUHXen6','XQ3RVTLsRFUHXhkLOqhxyuBnI2qxCte8G4k1K4p5I4qJzauT6TaKGXrNFuS9','2018-11-22 08:00:00','2018-11-19 08:00:00');

/*Table structure for table `commings` */

CREATE TABLE `commings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `reserve` int(11) DEFAULT '0',
  `transport` tinyint(1) DEFAULT '0',
  `payment` int(11) DEFAULT '0',
  `phone_number` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `commings` */

insert  into `commings`(`id`,`user_id`,`offer_id`,`reserve`,`transport`,`payment`,`phone_number`,`created_at`,`updated_at`) values 
(1,1,1,0,0,0,'978156441','2018-12-03 17:54:38','2018-12-03 17:54:38'),
(2,2,1,200,1,1,'978156441','2018-12-03 17:54:44','2018-12-03 16:47:56'),
(3,3,1,0,1,2,'978156441','2018-12-03 17:54:49','2018-12-03 16:47:36'),
(4,4,2,230,1,0,'978156441','2018-12-03 17:55:05','2018-12-03 17:55:05'),
(5,4,1,0,0,1,'978156441','2018-12-03 17:55:14','2018-12-03 16:47:29'),
(7,2,2,500,1,2,'978156441','2018-12-03 17:55:43','2018-12-03 17:55:43'),
(10,5,1,300,0,0,'978156441','2018-12-04 01:03:25','2018-12-03 16:47:17'),
(13,8,7,0,1,0,NULL,'2018-12-04 17:16:05','2018-12-04 17:16:05'),
(14,1,7,0,1,0,NULL,'2018-12-04 17:18:50','2018-12-04 17:18:50');

/*Table structure for table `interest_cate` */

CREATE TABLE `interest_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `interest_cate` */

insert  into `interest_cate`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Cena e ir a club','2018-11-27 01:00:17','2018-11-27 01:00:17'),
(2,'Salidas de 1 día a casa rural','2018-11-27 01:00:32','2018-11-27 01:00:32'),
(3,'Salidas de 2 días a casa rural','2018-11-27 01:00:53','2018-11-27 01:00:53'),
(4,'Esquí','2018-11-27 01:01:08','2018-11-27 01:01:08'),
(5,'Vacaciones en velero','2018-11-27 01:01:21','2018-11-27 01:01:21'),
(6,'Fin de semana en velero','2018-11-27 01:01:37','2018-11-27 01:01:37'),
(7,'Viajes organizados por España','2018-11-27 01:01:51','2018-11-27 01:01:51'),
(8,'Viajes organizados por extranjero','2018-11-27 01:02:06','2018-11-27 01:02:06'),
(9,'Salidas a Cap d´Age11','2018-11-27 10:02:39','2018-11-27 10:02:39'),
(10,'new interest','2018-11-27 10:02:51','2018-11-27 10:02:51'),
(11,'test interests','2018-11-27 10:02:57','2018-11-27 10:02:57');

/*Table structure for table `membership` */

CREATE TABLE `membership` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `membership` */

insert  into `membership`(`id`,`name`,`price`,`created_at`,`updated_at`) values 
(1,'free',0.00,'2018-11-05 01:25:54','2018-11-05 01:25:54'),
(2,'weekly',100.00,'2018-11-05 01:27:05','2018-11-05 01:27:05'),
(3,'monthly',300.00,'2018-11-05 01:27:30','2018-11-05 01:27:30');

/*Table structure for table `offers` */

CREATE TABLE `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `attendees` int(11) DEFAULT NULL,
  `track` int(11) DEFAULT '0',
  `price` int(11) DEFAULT NULL,
  `description` text,
  `amount` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `offers` */

insert  into `offers`(`id`,`name`,`place`,`start_date`,`end_date`,`attendees`,`track`,`price`,`description`,`amount`,`created_at`,`updated_at`) values 
(1,'Love','Madrid','12/03/2018 9:52 AM','12/04/2018 9:52 AM',30,0,500,'This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing.',150,'2018-11-27 00:54:46','2018-12-03 17:49:21'),
(2,'Romain','France','11/27/2018 10:45 AM','11/29/2018 10:45 AM',100,0,500,'This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. ',20,'2018-11-27 01:47:18','2018-11-27 01:47:18'),
(3,'Artemova and Kashirin','Russia','11/28/2018 10:48 AM','11/30/2018 10:48 AM',70,0,600,'This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. ',10,'2018-11-27 01:48:52','2018-11-27 01:48:52'),
(5,'Madrid Festival','Madrid','12/03/2018 6:25 AM','12/05/2018 6:27 PM',123,0,250,'This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. This is my offer testing. ',20,'2018-12-01 21:26:19','2018-12-01 21:26:19'),
(7,'2018 Madrid Festival','Spain Madrid','12/05/2018 12:02 AM','12/05/2018 12:02 AM',20,0,500,'This is my offer creating test.This is my offer creating test.This is my offer creating test.This is my offer creating test.This is my offer creating test.This is my offer creating test.This is my offer creating test.',350,'2018-12-04 15:03:32','2018-12-04 15:03:32');

/*Table structure for table `preferences` */

CREATE TABLE `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `hetero` tinyint(1) DEFAULT NULL,
  `bi` tinyint(1) DEFAULT NULL,
  `testing` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `preferences` */

insert  into `preferences`(`id`,`user_id`,`gender`,`year`,`hetero`,`bi`,`testing`,`created_at`,`updated_at`) values 
(1,1,0,1997,1,1,1,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(2,1,1,1995,1,1,1,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(3,2,0,1996,1,1,1,'2018-11-27 01:22:07','2018-11-27 01:22:07'),
(4,2,1,1995,1,0,1,'2018-11-27 01:22:07','2018-11-27 01:22:07'),
(5,3,0,1998,1,1,0,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(6,3,1,1995,1,0,1,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(7,4,1,1995,1,1,1,'2018-11-27 01:28:00','2018-11-27 01:28:00'),
(8,5,0,1996,1,0,1,'2018-11-27 01:30:33','2018-11-27 01:30:33'),
(9,7,0,1998,1,0,0,'2018-12-01 19:42:33','2018-12-01 19:42:33'),
(10,6,0,1996,1,0,1,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(11,7,0,1997,1,0,1,'2018-12-04 15:12:35','2018-12-04 15:12:35'),
(12,7,1,1990,1,1,0,'2018-12-04 15:12:35','2018-12-04 15:12:35'),
(13,8,0,1997,1,0,1,'2018-12-04 15:26:40','2018-12-04 15:26:40'),
(14,8,1,1995,1,1,0,'2018-12-04 15:26:40','2018-12-04 15:26:40');

/*Table structure for table `profile_images` */

CREATE TABLE `profile_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `profile_images` */

insert  into `profile_images`(`id`,`filename`,`user_id`,`created_at`,`updated_at`) values 
(1,'mypicture1.jpg',1,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(2,'nLfLb15413956013.jpg',1,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(3,'nLfLb15413956013.jpg',2,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(4,'QAaWU15418063458.jpg',2,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(5,'1gO5f15413965962.jpg',3,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(6,'alek-minassian.png',3,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(7,'KkgWW15418062107.jpg',4,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(8,'MGgbf15413997982.jpg',4,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(9,'1541413757_categories_.png',5,'2018-11-27 01:30:33','2018-11-27 01:30:33'),
(10,'1541414645_categories_.png',5,'2018-11-27 01:30:33','2018-11-27 01:30:33'),
(12,'user.jpg',6,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(17,'russia_girl.jpg',8,'2018-12-04 15:26:40','2018-12-04 15:26:40'),
(18,'spain.jpg',8,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(19,'vladibostok.jpg',8,'2018-12-04 15:26:41','2018-12-04 15:26:41');

/*Table structure for table `tag_cate` */

CREATE TABLE `tag_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `tag_cate` */

insert  into `tag_cate`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Parejas para salir','2018-11-27 00:57:07','2018-11-27 00:57:07'),
(2,'Intercambio completo','2018-11-27 00:57:34','2018-11-27 00:57:34'),
(3,'Intercambio light','2018-11-27 00:57:58','2018-11-27 00:57:58'),
(4,'Sexo en grupo','2018-11-27 00:58:12','2018-11-27 00:58:12'),
(5,'Fiestas locas','2018-11-27 00:58:27','2018-11-27 00:58:27'),
(6,'Tríos HHM','2018-11-27 00:58:41','2018-11-27 00:58:41'),
(7,'Tríos MMH','2018-11-27 00:58:55','2018-11-27 00:58:55'),
(8,'BDSM','2018-11-27 00:59:09','2018-11-27 00:59:09'),
(9,'Juguetes sexuales','2018-11-27 00:59:41','2018-11-27 00:59:41'),
(10,'testing tags','2018-11-27 00:59:55','2018-11-27 01:04:19');

/*Table structure for table `user_interest` */

CREATE TABLE `user_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `interest_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `user_interest` */

insert  into `user_interest`(`id`,`user_id`,`interest_id`,`created_at`,`updated_at`) values 
(1,1,2,'2018-11-27 01:19:25','2018-11-27 01:19:25'),
(2,1,4,'2018-11-27 01:19:25','2018-11-27 01:19:25'),
(3,1,5,'2018-11-27 01:19:25','2018-11-27 01:19:25'),
(4,1,7,'2018-11-27 01:19:25','2018-11-27 01:19:25'),
(5,1,8,'2018-11-27 01:19:25','2018-11-27 01:19:25'),
(6,2,3,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(7,2,4,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(8,2,5,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(9,3,1,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(10,3,3,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(11,3,6,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(12,3,7,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(13,3,8,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(14,4,2,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(15,4,6,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(16,4,7,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(17,5,1,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(18,5,2,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(19,5,3,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(20,5,4,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(23,6,1,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(24,6,2,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(25,6,6,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(26,6,8,'2018-12-04 12:06:53','2018-12-04 12:06:53'),
(27,6,11,'2018-12-04 12:06:53','2018-12-04 12:06:53'),
(32,8,3,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(33,8,6,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(34,8,7,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(35,8,11,'2018-12-04 15:26:41','2018-12-04 15:26:41');

/*Table structure for table `user_tags` */

CREATE TABLE `user_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `user_tags` */

insert  into `user_tags`(`id`,`user_id`,`tag_id`,`created_at`,`updated_at`) values 
(1,1,2,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(2,1,3,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(3,1,4,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(4,1,5,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(5,1,8,'2018-11-27 01:19:24','2018-11-27 01:19:24'),
(6,2,1,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(7,2,2,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(8,2,3,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(9,2,4,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(10,2,9,'2018-11-27 01:22:08','2018-11-27 01:22:08'),
(11,3,1,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(12,3,2,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(13,3,4,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(14,3,7,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(15,3,8,'2018-11-27 01:24:04','2018-11-27 01:24:04'),
(16,4,1,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(17,4,7,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(18,4,9,'2018-11-27 01:28:01','2018-11-27 01:28:01'),
(19,5,1,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(20,5,2,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(21,5,3,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(22,5,7,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(23,5,9,'2018-11-27 01:30:34','2018-11-27 01:30:34'),
(25,6,2,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(26,6,3,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(27,6,9,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(28,6,10,'2018-12-04 12:06:52','2018-12-04 12:06:52'),
(34,8,1,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(35,8,7,'2018-12-04 15:26:41','2018-12-04 15:26:41'),
(36,8,10,'2018-12-04 15:26:41','2018-12-04 15:26:41');

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `category` int(11) DEFAULT '1' COMMENT '2:couple, 1:man, 0:woman',
  `phone_number` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `description` text,
  `subscribtion_preference` int(11) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`email_verified_at`,`category`,`phone_number`,`country`,`city`,`status`,`description`,`subscribtion_preference`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Alex','alex@alex.com','$2y$10$J8klAc2eZWlf9khg3bDeEeCnUISlcdnDYFc9QaLsidc3rVCcDzNUG','2018-11-27 10:19:24',2,'123456789','Russia','Vladibostok',1,'This is my first testing. This is my first testing. This is my first testing. This is my first testing. This is my first testing. This is my first testing. This is my first testing.',NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-11-27 01:19:24','2018-11-27 01:19:24'),
(2,'Artemova','artemova@artemova.com','$2y$10$wktmX/EZcKcbtx5m.Ex5zeys2PFHSmztJuJ5Mu7yAl3aOkmna.sNS','2018-11-27 10:22:07',2,'12345678','Russia','Vladibostok',1,'This is my 2nd testing. This is my 2nd testing. This is my 2nd testing. This is my 2nd testing. This is my 2nd testing. This is my 2nd testing. This is my 2nd testing. This is my 2nd testing.',NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-11-27 01:22:07','2018-11-27 01:22:07'),
(3,'Maria','maria@maria.com','$2y$10$/5nqOIF0lONPAWEFdv6/.O/sg9VdC0tt8tpwZ034yitBt2hFYWnSm','2018-11-27 10:24:04',2,'1234567','Spain','Madrid',1,NULL,NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-11-27 01:24:04','2018-11-27 01:24:04'),
(4,'Danie','danie@danie.com','$2y$10$7Ucxc9vohTZTevluiYzZCemCTeJUXNyxVZebV01F4hQ7ckYHD/KQK','2018-11-27 10:28:00',1,'123456','Spain','Barcelona',1,'Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona. Barcelona.',NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-11-27 01:28:00','2018-11-27 01:28:00'),
(5,'Marta','marta@marta.com','$2y$10$qXAWBm.e1H5FE5dj7DBcp.louCWhAyEXFFd3xjFaj0o3FXtZJOKve','2018-11-27 10:30:33',0,'1234567','Spain','Granada',1,'Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Marta. Mart',NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-11-27 01:30:33','2018-11-27 01:30:33'),
(6,'Betty','betty@gmail.com','$2y$10$po.IWonbUoRIt2yTeg2qYOYRmvtvBK.sSPDQMF04w9HN0JBHvTVnu','2018-12-04 21:06:52',0,'12345','Spain','Madrid',1,'This is my testing. This is my testing. This is my testing. This is my testing. This is my testing. This is my testing. This is my testing. This is my testing. This is my testing. This is my testing.',NULL,'hANBKoisT4Y2CxdlPy87TdHdfBL1B8kBEQGQdYSo','2018-12-04 12:06:52','2018-12-04 12:06:52'),
(8,'Pere Q','pere@pere.com','$2y$10$CuCVJeG0wPzfBN2ApdTJd.oOnQr5gZb2ek/BZBq.9H3PNco3CgO5K','2018-12-05 00:26:40',2,'1234567','Spain','Madrid',1,'This is register testing. This is register testing. This is register testing. This is register testing. This is register testing.',NULL,'FB4WJyETAoiC79TlB3bxjY0RMn5rXOL5tzVyuuFr','2018-12-04 15:26:40','2018-12-04 15:26:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
