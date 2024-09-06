-- MySQL dump 10.13  Distrib 5.6.21, for Win32 (x86)
--
-- Host: localhost    Database: newme
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `user` varchar(20) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','7834924460948f587efc2613d1c175ab');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id_client` varchar(10) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `nama_client` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` VALUES ('110001','2015-10-26','PT.Angkasa'),('110002','2015-10-26','PT.Bumi');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kendaraan`
--

DROP TABLE IF EXISTS `kendaraan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kendaraan` (
  `no_kendaraan` varchar(8) DEFAULT NULL,
  `tipe_kendaraan` varchar(10) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kendaraan`
--

LOCK TABLES `kendaraan` WRITE;
/*!40000 ALTER TABLE `kendaraan` DISABLE KEYS */;
INSERT INTO `kendaraan` VALUES ('B2351CJD','minibus',NULL),('B2334DEF','minibus',NULL),('B4362FGE','sedan',NULL),('B3256KDS','sedan',NULL),('B3273DDS','sedan',NULL),('B2456CDS','sedan',NULL),('B3256CDS','sedan',NULL),('B3826KDS','minibus',NULL),('B3976KDS','minibus',NULL),('B8956KDS','minibus',NULL),('100017','sedan',NULL),('B2342KLF','sedan',NULL),('B980GB','sedan',NULL),('B9234DCF','sedan',NULL),('B4325DFS','mini bus',NULL),('B1193LKD','minibus',NULL);
/*!40000 ALTER TABLE `kendaraan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_perusahaan`
--

DROP TABLE IF EXISTS `sub_perusahaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_perusahaan` (
  `id_perusahaan` varchar(8) NOT NULL,
  `nama_perusahaan` varchar(40) DEFAULT NULL,
  `id_client` varchar(10) DEFAULT NULL,
  `no_perusahaan` int(5) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`no_perusahaan`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_perusahaan`
--

LOCK TABLES `sub_perusahaan` WRITE;
/*!40000 ALTER TABLE `sub_perusahaan` DISABLE KEYS */;
INSERT INTO `sub_perusahaan` VALUES ('001','perushaan a','110001',1),('002','perushaan b','110001',2),('003','perushaan c','110002',3),('004','perushaan d','110001',4),('005','perushaan e','110001',5),('006','perushaan f','110002',6),('007','perusahaan g','110001',7),('008','perusahaan h','110002',8);
/*!40000 ALTER TABLE `sub_perusahaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `track`
--

DROP TABLE IF EXISTS `track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `track` (
  `id` int(11) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lgt` double DEFAULT NULL,
  `kecepatan` double DEFAULT NULL,
  `task` varchar(40) DEFAULT NULL,
  `date_p` date DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `time_e` time DEFAULT NULL,
  `no_kendaraan` varchar(9) DEFAULT NULL,
  `no` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `track`
--

LOCK TABLES `track` WRITE;
/*!40000 ALTER TABLE `track` DISABLE KEYS */;
INSERT INTO `track` VALUES (100005,-6.215442,107.139002,60.03,'waiting','2015-10-06','1','20:03:00','B1977KYF',1),(100001,-6.187001,107.003755,60.3,'kebandara','2015-09-29','1','00:00:00','B2351CJD',2),(100001,-6.188001,107.003855,60.3,'kebandara','2015-09-30','1','00:00:00','B2351CJD',3),(100001,-6.189001,107.003955,60.3,'kebandara','2015-10-01','1','00:00:00','B2351CJD',4),(100001,-6.190001,107.004055,60.3,'kebandara','2015-10-02','1','00:00:00','B2351CJD',5),(100001,-6.191001,107.004155,60.3,'kebandara','2015-10-03','1','00:00:00','B2351CJD',6),(100001,-6.192001,107.004255,60.3,'kebandara','2015-10-04','1','00:00:00','B2351CJD',7),(100001,-6.193001,107.004355,60.3,'kebandara','2015-10-05','1','00:00:00','B2351CJD',8),(100001,-6.194001,107.004455,60.3,'kebandara','2015-10-06','1','00:00:00','B2351CJD',9),(100001,-6.195001,107.004555,60.3,'kebandara','2015-10-07','1','00:00:00','B2351CJD',10),(100001,-6.196001,107.004655,60.3,'kebandara','2015-10-08','1','00:00:00','B2351CJD',11),(100002,-6.145001,106.86402,50.7,'jemput tamu','2015-09-30','0','00:00:00','B2334DEF',12),(100002,-6.138001,106.86502,50.7,'jemput tamu','2015-10-01','0','00:00:00','B2334DEF',13),(100002,-6.139001,106.86602,50.7,'jemput tamu','2015-10-02','0','00:00:00','B2334DEF',14),(100002,-6.140001,106.86702,50.7,'jemput tamu','2015-10-03','0','00:00:00','B2334DEF',15),(100002,-6.141001,106.86802,50.7,'jemput tamu','2015-10-04','0','00:00:00','B2334DEF',16),(100002,-6.142001,106.86902,50.7,'jemput tamu','2015-10-05','0','00:00:00','B2334DEF',17),(100002,-6.143001,106.87002,50.7,'jemput tamu','2015-10-06','0','00:00:00','B2334DEF',18),(100002,-6.144001,106.87102,50.7,'jemput tamu','2015-10-07','0','00:00:00','B2334DEF',19),(100002,-6.145001,106.87202,50.7,'jemput tamu','2015-10-08','0','00:00:00','B2334DEF',20),(100003,-6.134742,107.100102,70,'kembali','2015-09-30','0','00:00:00','B4362FGE',21),(100003,-6.134842,107.100202,70,'kembali','2015-10-01','0','00:00:00','B4362FGE',22),(100003,-6.134942,107.100302,70,'kembali','2015-10-02','0','00:00:00','B4362FGE',23),(100003,-6.135042,107.100402,70,'kembali','2015-10-03','0','00:00:00','B4362FGE',24),(100003,-6.135142,107.100502,70,'kembali','2015-10-04','0','00:00:00','B4362FGE',25),(100003,-6.135242,107.100602,70,'kembali','2015-10-05','0','00:00:00','B4362FGE',26),(100003,-6.135342,107.100702,70,'kembali','2015-10-06','0','00:00:00','B4362FGE',27),(100003,-6.135442,107.100802,70,'kembali','2015-10-07','0','00:00:00','B4362FGE',28),(100003,-6.135542,107.100902,70,'kembali','2015-10-08','0','00:00:00','B4362FGE',29),(100004,-6.205542,107.119002,68,'antar paket','2015-10-08','1','00:00:00','B2367FGE',30),(100011,-6.2134542,108.12801,41.03,'waiting','2015-10-14','1','10:24:16','b2373DDS',31),(100001,-6.196021,107.004635,50.03,'working','2015-10-08','1','22:00:00','B2351CJD',32),(100001,-6.196321,107.004735,50.03,'working','2015-10-08','1','22:00:00','B2351CJD',33),(100001,-6.196421,107.004835,50.03,'working','2015-10-08','1','22:00:00','B2351CJD',34),(100001,-6.186421,107.014835,50.03,'working','2015-10-08','1','22:00:00','B2351CJD',35),(100001,-6.146421,107.012835,50.03,'working','2015-10-08','1','22:00:00','B2351CJD',36);
/*!40000 ALTER TABLE `track` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `update_position` AFTER INSERT ON `track` FOR EACH ROW BEGIN UPDATE v_status SET lat=new.lat , lgt=new.lgt, kecepatan=new.kecepatan, task=new.task ,date_p=new.date_p, status=new.status, time_e=new.time_e, no_kendaraan=new.no_kendaraan WHERE id=new.id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(60) DEFAULT NULL,
  `nama_depan` varchar(40) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `alamat` varchar(80) DEFAULT 'alamat',
  `id_client` varchar(10) DEFAULT NULL,
  `nama_belakang` varchar(40) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('akhasa','c6490bc1d06c7bd7220d25570669ce5d','akhasa','akhasa@email.com','jakarta','110001','akhasa juga',NULL),('ichigo','c6490bc1d06c7bd7220d25570669ce5d','ichigo','ichigo@email.com','kosong','110001','ichigo','kosong'),('lucifer','c6490bc1d06c7bd7220d25570669ce5d','dechiko','dechiko@email.com','jakarta','110001','princess',NULL),('sozaemon','c6490bc1d06c7bd7220d25570669ce5d','arif','sozaemonafro@gmail.com','alamat','110002',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `v_status`
--

DROP TABLE IF EXISTS `v_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `v_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` varchar(10) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lgt` double DEFAULT NULL,
  `id_perusahaan` varchar(8) DEFAULT 'tersedia',
  `kecepatan` double DEFAULT NULL,
  `task` varchar(40) DEFAULT NULL,
  `date_p` date DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `time_e` time DEFAULT NULL,
  `no_kendaraan` varchar(9) DEFAULT NULL,
  KEY `id` (`id`,`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=100021 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `v_status`
--

LOCK TABLES `v_status` WRITE;
/*!40000 ALTER TABLE `v_status` DISABLE KEYS */;
INSERT INTO `v_status` VALUES (100001,'110001',-6.146421,107.012835,'001',50.03,'working','2015-10-08','1','22:00:00','B2351CJD'),(100002,'110001',-6.145001,106.87202,'001',50.7,'jemput tamu','2015-10-08','0','00:00:00','B2334DEF'),(100003,'110001',-6.135542,107.100002,'004',70,'kembali','2015-10-08','0','00:00:00','B4362FGE'),(100004,'110001',-6.205542,107.119002,'004',68,'antar paket','2015-10-08','1','00:00:00','B2367FGE'),(100005,'110001',-6.215442,107.139002,NULL,NULL,NULL,NULL,'1',NULL,NULL),(100006,'110001',-6.215542,108.138001,'001',60.03,'working','2015-10-25','1','20:00:00','B3256KDS'),(100011,'110001',-6.2134542,108.12801,'001',41.03,'waiting','2015-10-14','1','10:24:16','B3273DDS'),(100012,'110001',-6.218542,105.138001,'002',60.03,'working','2015-10-25','1','21:00:00','B2456KDS'),(100013,'110001',-6.205242,107.188001,'002',40.03,'working','2015-10-25','1','22:00:00','B3256CDS'),(100014,'110002',-6.223542,108.138101,'003',40.03,'working','2015-10-18','1','22:00:00','B3826KDS'),(100009,'110001',-6.205542,108.139201,'004',30.03,'working','2015-10-25','1','23:00:00','B3976KDS'),(100010,'110001',-6.215432,108.138201,'005',32.03,'working','2015-10-15','1','19:00:00','B8956KDS'),(100019,'110001',NULL,NULL,'007',NULL,NULL,NULL,NULL,NULL,'B9234DCF'),(100017,'110001',NULL,NULL,'007',NULL,NULL,NULL,NULL,NULL,'B4325DFS'),(100020,'110001',NULL,NULL,'007',NULL,NULL,NULL,NULL,NULL,'B1193LKD');
/*!40000 ALTER TABLE `v_status` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-06 22:35:36
