-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: incidencias
-- ------------------------------------------------------
-- Server version	8.0.33

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

--
-- Table structure for table `avance_incidencia`
--

DROP TABLE IF EXISTS `avance_incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avance_incidencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_incidencia` int NOT NULL,
  `control_usu` int NOT NULL,
  `avances` text NOT NULL,
  `estatus` enum('atendiendo','atendido') NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_incidencia_avance` (`id_incidencia`),
  KEY `fk_usuario_avance` (`control_usu`),
  CONSTRAINT `fk_incidencia_avance` FOREIGN KEY (`id_incidencia`) REFERENCES `incidencia` (`id`),
  CONSTRAINT `fk_usuario_avance` FOREIGN KEY (`control_usu`) REFERENCES `usuario` (`control_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avance_incidencia`
--

LOCK TABLES `avance_incidencia` WRITE;
/*!40000 ALTER TABLE `avance_incidencia` DISABLE KEYS */;
INSERT INTO `avance_incidencia` VALUES (1,1,1,'Primer avance','atendiendo','2023-12-15 23:59:18'),(2,1,1,'Segundo avance','atendiendo','2023-12-15 23:59:18'),(3,1,1,'Tercer avance','atendido','2023-12-15 23:59:18'),(4,2,4,'progresando','atendiendo','2023-12-16 01:36:47'),(5,2,4,'progresando','atendiendo','2023-12-16 01:37:32'),(6,2,4,'progresando','atendiendo','2023-12-16 01:37:39'),(7,2,4,'listo','atendido','2023-12-16 02:03:16'),(8,3,4,'hay va brother ya le cambie el sistema','atendiendo','2023-12-16 18:22:17'),(9,3,4,'ya quedo','atendido','2023-12-16 18:22:31');
/*!40000 ALTER TABLE `avance_incidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incidencia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `detalles` text NOT NULL,
  `fecha` datetime NOT NULL,
  `control_usu` int NOT NULL,
  `control_pro` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_incidencia` (`control_usu`),
  KEY `fk_producto_incidencia` (`control_pro`),
  CONSTRAINT `fk_producto_incidencia` FOREIGN KEY (`control_pro`) REFERENCES `productos` (`control_pro`),
  CONSTRAINT `fk_usuario_incidencia` FOREIGN KEY (`control_usu`) REFERENCES `usuario` (`control_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencia`
--

LOCK TABLES `incidencia` WRITE;
/*!40000 ALTER TABLE `incidencia` DISABLE KEYS */;
INSERT INTO `incidencia` VALUES (1,'no sirve porq es china','2023-12-15 23:00:32',4,1),(2,'dejo de prender','2023-12-16 01:28:19',4,3),(3,'pueno sirve bro','2023-12-16 18:22:02',4,1);
/*!40000 ALTER TABLE `incidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modf_usu`
--

DROP TABLE IF EXISTS `modf_usu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modf_usu` (
  `num_modf` int NOT NULL AUTO_INCREMENT,
  `fecha_modf` datetime NOT NULL,
  `statusantes_modf` enum('activo','inactivo') NOT NULL,
  `statusdesp_modf` enum('activo','inactivo') NOT NULL,
  `control_usu` int NOT NULL,
  PRIMARY KEY (`num_modf`),
  KEY `control_usu` (`control_usu`),
  CONSTRAINT `modf_usu_ibfk_1` FOREIGN KEY (`control_usu`) REFERENCES `usuario` (`control_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modf_usu`
--

LOCK TABLES `modf_usu` WRITE;
/*!40000 ALTER TABLE `modf_usu` DISABLE KEYS */;
/*!40000 ALTER TABLE `modf_usu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso_usuario`
--

DROP TABLE IF EXISTS `permiso_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permiso_usuario` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `control_usu` int NOT NULL,
  `modulo` varchar(50) NOT NULL,
  `permiso_leer` int NOT NULL,
  `permiso_eliminar` int NOT NULL,
  `permiso_editar` int NOT NULL,
  `permiso_actualizar` int NOT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `control_usu` (`control_usu`),
  CONSTRAINT `permiso_usuario_ibfk_1` FOREIGN KEY (`control_usu`) REFERENCES `usuario` (`control_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso_usuario`
--

LOCK TABLES `permiso_usuario` WRITE;
/*!40000 ALTER TABLE `permiso_usuario` DISABLE KEYS */;
INSERT INTO `permiso_usuario` VALUES (4,3,'usuarios',0,1,0,0),(5,3,'incidencias',0,1,0,0),(6,3,'productos',1,0,0,0),(7,1,'usuarios',0,1,0,1),(8,1,'incidencias',0,0,1,1),(9,1,'productos',0,1,1,1),(10,4,'usuarios',1,1,1,1),(11,4,'incidencias',1,1,1,1),(12,4,'productos',1,1,1,1),(13,2,'usuarios',1,1,0,0),(14,2,'incidencias',1,0,0,0),(15,2,'productos',0,1,0,0),(16,6,'usuarios',1,0,1,0),(17,6,'incidencias',0,1,0,1),(18,6,'productos',0,0,0,0),(19,7,'usuarios',1,1,1,1),(20,7,'incidencias',1,1,1,0),(21,7,'productos',1,0,0,0),(22,8,'usuarios',1,0,0,1),(23,8,'incidencias',0,0,0,0),(24,8,'productos',1,1,1,1);
/*!40000 ALTER TABLE `permiso_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `num_per` int NOT NULL,
  `nom_per` varchar(50) NOT NULL,
  `app_per` varchar(50) NOT NULL,
  `apm_per` varchar(50) NOT NULL,
  PRIMARY KEY (`num_per`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `control_pro` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `fechaentrada_pro` datetime NOT NULL,
  `control_usu` int NOT NULL,
  `caracteristicas` json DEFAULT NULL,
  `estatus` enum('activo','inactivo') DEFAULT NULL,
  PRIMARY KEY (`control_pro`),
  KEY `control_usu` (`control_usu`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`control_usu`) REFERENCES `usuario` (`control_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Laptop HP','laptop','2023-01-15 08:30:00',1,'{\"RAM\": \"8GB\", \"Marca\": \"HP\", \"Almacenamiento\": \"256GB SSD\"}','activo'),(3,'Laptop HP','laptop','2023-01-15 08:30:00',1,'{\"RAM\": \"8GB\", \"Marca\": \"HP\", \"Almacenamiento\": \"256GB SSD\"}','activo'),(4,'Proyector Epson','proyector','2023-01-16 09:45:00',2,'{\"Marca\": \"Epson\", \"Lúmenes\": \"3000\", \"Resolución\": \"1080p\"}','activo'),(5,'Mouse Inalámbrico','mouse','2023-01-17 10:15:00',3,'{\"Tipo\": \"Inalámbrico\", \"Color\": \"Negro\", \"Marca\": \"Logitech\"}','activo'),(6,'Teclado Mecánico','teclado','2023-01-18 11:00:00',4,'{\"Tipo\": \"Mecánico\", \"Marca\": \"Corsair\", \"Retroiluminación\": \"RGB\"}','activo'),(12,'laptop gamer','laptop','2023-12-16 20:13:31',8,'{\"ram\": \"8gb\", \"tipo\": \"gamer\"}','activo');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `control_usu` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `status_usu` enum('activo','inactivo') NOT NULL,
  `correo_usu` varchar(100) NOT NULL,
  `fi_usu` datetime NOT NULL,
  `contrasena_usu` varchar(255) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`control_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'bob','inactivo','bob@gmail.com','2023-12-16 20:26:02','$2y$10$qab8BFxWszh/tgJgVDKUxOxa8Neq5AXm3U.jCqS3Xv0FHhPmEw5cG','1bd5051dc31a67d7afcac425adf8d668'),(2,'mario','inactivo','bro@gmail.com','2023-12-15 22:54:18','$2y$10$TbkIdsEdtHceYPQrOG5ZO.dOBPLJFNPFa5RjvCP2hDfLHNsPQ0A9G','ccdf20968e6a3ca318c8abb33db284b0'),(3,'bob esponja','inactivo','mario@gmail.com','2023-12-15 18:54:27','$2y$10$ots4/P4d5fxg1QSLojC3B./TTJBFvci2hwzHK89xIKyhXP7tdKtrC','3ffea39e36bc2083281e4ba03989bbcb'),(4,'isaac','activo','isv@gmail.com','2023-12-15 18:53:48','$2y$10$G8NgfSkpMvl/8gKqKM8IAOpL07q2HqsEu1t5KY2H6BkXHQhl1Xl4O','0aa2fb3f0d792c256a97971b3cbea459'),(6,'test','activo','test@gmail.com','2023-12-16 01:28:00','$2y$10$MluDHoIeMF.3o3CuI1rvX.97yJ/mA8lAre2wy0FQQKYKmRboafd2C','de7ac5186c049aed34ff46e1a9344299'),(7,'test','inactivo','test1@gmail.com','2023-12-16 18:21:39','$2y$10$hb28PSUTcY2yQAVBEJrzauBCFie09GUUi.sDkL6JBbRg2lsXIp.xi','08378aa01bd0964a4c2f50118a7a70b9'),(8,'permisos','activo','permisos@gmail.com','2023-12-16 20:25:44','$2y$10$7aC.NDG.pU1RTzIGd4zkT.hd5Uf2AKsJHycZNbxCEqem.eFes2lq6','51c82619cd0a5d98d518c62753c67bb4');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-16 20:28:08
