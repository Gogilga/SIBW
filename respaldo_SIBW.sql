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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (1,1,'jabon-sal-himalaya-ecoreciclat-3.png'),(1,2,'jabon-sal-himalaya-ecoreciclat.png'),(3,4,'cepillo_dientes.png'),(3,5,'cepillo.jpg');
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
  `contenido` varchar(8000) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `etiquetas` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'Sal del Himalaya','Jabón de sal de roca del Himalaya 100% pura y natural, acabado suave.','BARRA de sal del Himalaya con forma de jabón, 300gr.\r\n\r\nDesodorante y exfoliante 100% natural que aporta los beneficios de sus minerales a la piel, pero en un formato cómodo para el uso diario. El bloque de sal se selecciona y pule a mano para darle la forma de jabón (no contiene jabón, es sólo sal). En cocina elimina el olor de pescado, ajo o cebolla de las manos.\r\n\r\nAlgunos usos:\r\n\r\n1- Desodorante:\r\n\r\nMoja ligeramente la piedra, frotala con las manos y usa ese agua en axilas, pies o cualquier parte del cuerpo. En una solución de sal ninguna bacteria sobrevive, ayuda a impedir el olor y la formación de bacterias. No tapa los poros, no es antitranspirante.\r\n\r\n2. Baño de sal:\r\n\r\nDejar que el jabón se disuelva parcialmente en agua caliente. Usar el agua rica en minerales para relajar y nutrir la piel, puede añadir un aceite esencial.\r\n\r\n3. Exfoliación:\r\n\r\nFrotar suavemente pies, codos o callosidades con la barra de sal, previamente humedecida entre las manos con agua tibia y un aceite, aceite esencial o jabón. Su uso directo en otras zonas puede resultar abrasivo.\r\n\r\nBeneficios:\r\n\r\nRelaja, exfolia, mejora la circulación, combate la celulitis y la retención de líquidos, reduce calambres, tirones, dolores reumáticos, la migraña, el acné, equilibra el ph de la piel y desodoriza.','sal_himalaya.png',3,'jabón,sal,desodorante'),(2,'Champú','Champú con fórmula milenaria que cuida, aporta brillo y protege a tu cabello.','Hola que tal','champu-solido.png',1.5,'champú,ducha'),(3,'Cepillo de dientes','Cerdas suaves para una limpieza bucal completa.','Cerdas suaves sin BPA - Nuestras cerdas mezcladas con carbón de bambú se sienten suaves en los dientes y las encías. Sólo utilizamos materiales de primera calidad que son de origen sostenible, lo que hace que todos los productos de Greenzla sean naturales y libres de BPA.\r\n\r\nMango de bambú suave y natural - Nuestros cepillos de dientes de madera no sólo son suaves para los dientes, sino también para las manos. El cómodo mango encaja perfectamente en la palma de su mano para un mayor nivel de comodidad.\r\n\r\nCalidad en la que puedes confiar - La marca Greenzla está comprometida con productos de alta calidad, respetuosos con el medio ambiente y compostables. Creemos tanto en nuestros productos que ofrecemos una garantía de devolución de dinero si no está completamente satisfecho.','cepillos-dientes-bambu.jpg',2.5,'cepillo'),(4,'Gel sólido','Para pieles sensibles, hidratante y duradero.','Hola que tal gel con jabón.','gel_solido.png',6,''),(5,'Desodorante','Con aceite que assadjfuas hljdfhlsajhlfkh laskdjfhlkja shldkjf hlakjsdh fldaddds.','El desodorante sólido Amakandu es un producto orgánico, natural, vegano y no testado en animales. Fabricado en España y certificado.\r\n\r\nFormulado especialmente para neutralizar el mal olor de las axilas, con dos fragancias naturales duraderas a elegir. Muy eficaz, refrescante y cuidadoso con tu piel. No irrita e hidrata.\r\n\r\nNo contiene aluminio ni bicarbonato. Con ingredientes activos protectores, humectantes y antitranspirantes. Con Karité y aloe vera de primerísima calidad.\r\n\r\nEnvase 100% reciclable y sin plástico, respetuoso con el medio ambiente. Apto para llevar en el avión en el equipaje de mano.\r\n\r\nEs de fácil absorción. No engrasa tu piel ni da deja una sensación pegajosa. No es necesario lavarse las manos después de su aplicación.\r\n\r\nSe puede usar como jabón para manos.','desodorante.png',4.99,'jabón');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
INSERT INTO `usuarios` VALUES (1,'Gogilga','$2y$10$Bv2OZoC5cC2qTh67bJzlse.tN/UWUL7uTiTBnybuP7gFib1BW1TJm','santigilegaza@gmail.com',_binary '',_binary '',_binary ''),(2,'Pepe','$2y$10$XfxLjcJB.54YreU8SOr1y.vEeRMnuu6izd0xAZwSeuQQZGyJ1TT.y','pepe@gmail.com',_binary '\0',_binary '',_binary ''),(3,'Santi','$2y$10$jzCoVUbIQqoXVyuwtpavauRZ.DCkgd6L9Uvfwj.T/1tk9WULcAFoK','santigilegaza@gmail.es',_binary '',_binary '\0',_binary ''),(5,'Pedro','$2y$10$vM/BlgLMx2n5/9juAcNLr./bjgcL1.sgfJOoE/Iq1sG4NdMLQBjAS','pedro@gmail.com',_binary '\0',_binary '\0',_binary '');
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

-- Dump completed on 2022-05-13 19:41:00
