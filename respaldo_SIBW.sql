-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: SIBW
-- ------------------------------------------------------
-- Server version	8.0.28

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
-- Table structure for table `censuras`
--

DROP TABLE IF EXISTS `censuras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `censuras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `palabra` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `censuras`
--

LOCK TABLES `censuras` WRITE;
/*!40000 ALTER TABLE `censuras` DISABLE KEYS */;
INSERT INTO `censuras` VALUES (1,'puto'),(2,'Puto'),(3,'Puta'),(4,'puta'),(5,'maricas'),(6,'mierda'),(7,'asco');
/*!40000 ALTER TABLE `censuras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `idProducto` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `foto` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`idProducto`),
  CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (1,1,'jabon-sal-himalaya-ecoreciclat-3.png'),(1,2,'jabon-sal-himalaya-ecoreciclat.png');
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `contenido` varchar(500) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Sal del Himalaya','Jabón de sal de roca del Himalaya 100% pura y natural, acabado suave.','BARRA de sal del Himalaya con forma de jabón, 300gr.','sal_himalaya.png',3),(2,'Champú sólido','Champú con fórmula milenaria que cuida, aporta brillo y protege a tu cabello.','Hola que tal','champu-solido.png',1.5),(3,'Cepillo de dientes','Cerdas suaves para una limpieza bucal completa.','Hola que tal cepillo','cepillo_dientes.png',1),(4,'Gel sólido de ortigas','Para pieles sensibles, hidratante y duradero.','Hola que tal gel','gel_solido.png',6),(5,'Desodorante sólido','Con aceite de ricino que neutraliza y absorbe el malo olor de las axilas.','Hola que tal desodorante','desodorante.png',4.95);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reseñas`
--

DROP TABLE IF EXISTS `reseñas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reseñas` (
  `idProducto` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `puntuación` int DEFAULT NULL,
  `reseña` varchar(200) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`idProducto`),
  CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reseñas`
--

LOCK TABLES `reseñas` WRITE;
/*!40000 ALTER TABLE `reseñas` DISABLE KEYS */;
INSERT INTO `reseñas` VALUES (2,6,'Santi','2022-05-08 11:55:46',4,'Me ha gustado mucho, huele muy bien el verde. Pero es verdad que se gasta bastante rápido.',NULL),(1,12,'Gogilga','2022-05-09 14:16:54',5,'Me gusta mucho esta mierda. Pero huele muy bien.\nReseña editada.',NULL),(1,13,'Gogilga','2022-05-09 15:53:57',1,'Es una mierda de producto.',NULL);
/*!40000 ALTER TABLE `reseñas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `pass` varchar(1000) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `super` bit(1) DEFAULT NULL,
  `moderador` bit(1) DEFAULT NULL,
  `gestor` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Gogilga','$2y$10$Bv2OZoC5cC2qTh67bJzlse.tN/UWUL7uTiTBnybuP7gFib1BW1TJm','santigilegaza@correo.ugr.es',_binary '',_binary '',_binary ''),(2,'Pepe','$2y$10$XfxLjcJB.54YreU8SOr1y.vEeRMnuu6izd0xAZwSeuQQZGyJ1TT.y','pepe@gmail.com',_binary '\0',_binary '',_binary ''),(3,'Santi','$2y$10$jzCoVUbIQqoXVyuwtpavauRZ.DCkgd6L9Uvfwj.T/1tk9WULcAFoK','santigilegaza@gmail.es',_binary '\0',_binary '\0',_binary ''),(5,'Maria','$2y$10$vM/BlgLMx2n5/9juAcNLr./bjgcL1.sgfJOoE/Iq1sG4NdMLQBjAS','santigilegaza@gmail.com',_binary '\0',_binary '',_binary '');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-09 19:43:27
