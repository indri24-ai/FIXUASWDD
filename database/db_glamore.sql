/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 8.0.30 : Database - db_glamore
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_glamore` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_glamore`;

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `card_name` varchar(100) DEFAULT NULL,
  `card_info` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `product_id` varchar(100) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`email`,`payment_method`,`card_name`,`card_info`,`contact`,`product_id`,`quantity`,`order_date`) values 
(1,'indri@gmail.com','Card','Indri','1111-1111-1111','089765888000','organic-soap',1,'2025-06-27 21:28:17'),
(2,'indri@gmail.com','Card','Indri','1111-1111-1111','089765888000','glycerin-soap',2,'2025-06-27 21:28:17'),
(3,'indri@gmail.com','Card','Indri','1111-1111-1111','089765888000','oliveoil-serum',4,'2025-06-27 21:28:17'),
(4,'ambar@gmail.com','Card','Ambar','222-222-22222','087657333245','glycerin-soap',2,'2025-06-27 21:36:32'),
(5,'ambar@gmail.com','Card','Ambar','222-222-22222','087657333245','organic-soap',1,'2025-06-27 21:36:32'),
(6,'ambar@gmail.com','Card','Ambar','222-222-22222','087657333245','glycerin-moisturizer',3,'2025-06-27 21:36:32'),
(7,'ambar@gmail.com','Card','Ambar','222-222-22222','087657333245','oil-serum',2,'2025-06-27 21:36:32'),
(8,'Cecep@gmail.com','PayPal','Cecep','333-333-33333','08234567890','glycerin-moisturizer',1,'2025-06-27 22:52:15'),
(9,'Cecep@gmail.com','PayPal','Cecep','333-333-33333','08234567890','oliveoil-moisturizer',1,'2025-06-27 22:52:15'),
(10,'aldin@gmail.com','Card','Aldinxander','123-123-1234','000987654321','organic-soap',2,'2025-07-02 13:07:30'),
(11,'aldin@gmail.com','Card','Aldinxander','123-123-1234','000987654321','glycerin-soap',1,'2025-07-02 13:07:30');

/*Table structure for table `reviews` */

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `reviews` */

insert  into `reviews`(`id`,`name`,`email`,`subject`,`message`) values 
(1,'Yoseph','linglingrambu@gmail.com','Oil Soap','Bahannya Lembut!'),
(2,'Indri','indri@gmail.com','Oil Serum','Oke Banget!'),
(3,'Indri','indri@gmail.com','Oil Soap','Bahannya Bagus!'),
(4,'Aldin','aldin@gmail.com','Olive Oil Soap','Bahannya Kasar!  :C');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
