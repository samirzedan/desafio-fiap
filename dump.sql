-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: db_fiap
-- ------------------------------------------------------
-- Server version	8.4.6

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
-- Table structure for table `alunos`
--

DROP TABLE IF EXISTS `alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alunos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `turma_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_turma` (`turma_id`),
  CONSTRAINT `fk_turma` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alunos`
--

LOCK TABLES `alunos` WRITE;
/*!40000 ALTER TABLE `alunos` DISABLE KEYS */;
INSERT INTO `alunos` VALUES (16,'Thiago Lima','1995-11-10','98765432100','thiago.lima95@example.com','$2y$12$L5yUSTQabO9dPAAYNrWnreuNFx3DF30l5xQatRJtKxBwACKSxHnAK',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(17,'Maria Clara Oliveira','1995-03-12','12345678901','maria.oliveira95@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(18,'Pedro Henrique Silva','1998-11-25','12345678902','pedro.silva98@example.com','$2y$10$hashfalso1234567890abcd',5,'2025-08-27 23:51:36','2025-08-28 04:19:54'),(19,'Ana Beatriz Souza','1993-08-30','12345678903','ana.souza93@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 04:14:55'),(20,'Lucas Gabriel Costa','2000-01-05','12345678904','lucas.costa00@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(21,'Juliana Mendes','1989-09-14','12345678905','juliana.mendes89@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(22,'Felipe Rocha','1994-04-18','12345678906','felipe.rocha94@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(23,'Camila Ferreira','1997-02-21','12345678907','camila.ferreira97@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:36:24'),(24,'Ricardo Alves','1992-12-10','12345678908','ricardo.alves92@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:30'),(25,'Bianca Martins','1999-07-22','12345678909','bianca.martins99@example.com','$2y$10$hashfalso1234567890abcd',5,'2025-08-27 23:51:36','2025-08-28 04:14:54'),(26,'Rafael Moreira','1996-05-01','12345678910','rafael.moreira96@example.com','$2y$10$hashfalso1234567890abcd',5,'2025-08-27 23:51:36','2025-08-28 04:20:03'),(27,'Fernanda Lima','1990-10-19','12345678911','fernanda.lima90@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(28,'Diego Barbosa','1993-06-07','12345678912','diego.barbosa93@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(29,'Carolina Pires','2001-01-29','12345678913','carolina.pires01@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:36:28'),(30,'Mateus Cardoso','1997-04-03','12345678914','mateus.cardoso97@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(31,'Patrícia Gomes','1988-11-16','21524360082','patricia.gomes88@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(32,'André Ribeiro','1999-02-09','77295559051','andre.ribeiro99@example.com','$2y$10$hashfalso1234567890abcd',1,'2025-08-27 23:51:36','2025-08-28 04:14:51'),(33,'Gabriela Dias','1992-05-24','12345678917','gabriela.dias92@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(34,'Bruno Azevedo','1996-07-27','12345678918','bruno.azevedo96@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:36:28'),(35,'Isabela Nunes','1995-12-02','12345678919','isabela.nunes95@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(36,'Marcelo Teixeira','1990-09-13','12345678920','marcelo.teixeira90@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(37,'Larissa Castro','1998-06-04','12345678921','larissa.castro98@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(38,'Thiago Melo','1994-03-28','12345678922','thiago.melo94@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(39,'Amanda Figueiredo','1991-12-07','12345678923','amanda.figueiredo91@example.com','$2y$10$hashfalso1234567890abcd',1,'2025-08-27 23:51:36','2025-08-28 04:14:46'),(40,'Rodrigo Duarte','1997-10-22','12345678924','rodrigo.duarte97@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(41,'Sabrina Almeida','1995-08-14','12345678925','sabrina.almeida95@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(42,'Eduardo Araújo','1993-04-11','12345678926','eduardo.araujo93@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(43,'Vanessa Monteiro','2000-01-17','12345678927','vanessa.monteiro00@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(44,'Leonardo Batista','1998-07-05','12345678928','leonardo.batista98@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(45,'Tatiane Campos','1996-02-15','12345678929','tatiane.campos96@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(46,'Guilherme Moraes','1991-11-09','12345678930','guilherme.moraes91@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(47,'Priscila Correia','1997-09-26','12345678931','priscila.correia97@example.com','$2y$10$hashfalso1234567890abcd',5,'2025-08-27 23:51:36','2025-08-28 04:19:59'),(48,'Daniel Freitas','1994-05-30','12345678932','daniel.freitas94@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(49,'Cláudia Rezende','1992-12-20','12345678933','claudia.rezende92@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:33:42'),(51,'Luana Barros','1996-01-08','12345678935','luana.barros96@example.com','$2y$10$hashfalso1234567890abcd',11,'2025-08-27 23:51:36','2025-08-28 04:20:11'),(52,'Vinícius Cunha','1993-03-27','12345678936','vinicius.cunha93@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(53,'Elaine Tavares','1991-06-19','12345678937','elaine.tavares91@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(54,'Otávio Ramos','1995-09-11','43203273063','otavio.ramos95@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 02:19:28'),(56,'César Borges','1990-10-21','12345678940','cesar.borges90@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 03:36:27'),(57,'Michele Carvalho','1998-07-13','12345678941','michele.carvalho98@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(58,'Douglas Peixoto','1997-11-29','12345678942','douglas.peixoto97@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(59,'Aline Assis','1992-01-25','12345678943','aline.assis92@example.com','$2y$10$hashfalso1234567890abcd',1,'2025-08-27 23:51:36','2025-08-28 04:14:44'),(60,'Sérgio Prado','1995-05-06','12345678944','sergio.prado95@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(61,'Monique Cunha','1999-08-23','12345678945','monique.cunha99@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(62,'Fábio Santana','1993-02-14','12345678946','fabio.santana93@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(63,'Tatiana Ribeiro','1994-06-08','12345678947','tatiana.ribeiro94@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(64,'Cristiano Lopes','1991-12-31','12345678948','cristiano.lopes91@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-27 23:51:36'),(66,'Murilo Queiroz','1996-09-02','61238382029','murilo.queiroz96@example.com','$2y$10$hashfalso1234567890abcd',NULL,'2025-08-27 23:51:36','2025-08-28 02:20:19');
/*!40000 ALTER TABLE `alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turmas`
--

DROP TABLE IF EXISTS `turmas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `turmas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turmas`
--

LOCK TABLES `turmas` WRITE;
/*!40000 ALTER TABLE `turmas` DISABLE KEYS */;
INSERT INTO `turmas` VALUES (1,'ADS 1A','Análise e Desenvolvimento de Sistemas - 1º semestre, turno manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(2,'ADS 1B','Análise e Desenvolvimento de Sistemas - 1º semestre, turno noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(3,'Engenharia de Software 2A','Engenharia de Software - 2º semestre, turno manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(4,'Engenharia de Software 2B','Engenharia de Software - 2º semestre, turno noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(5,'Ciência da Computação 3A','Ciência da Computação - 3º semestre, turno manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(6,'Ciência da Computação 3B','Ciência da Computação - 3º semestre, turno noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(7,'Redes de Computadores 4A','Curso de Redes de Computadores - 4º semestre, manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(8,'Redes de Computadores 4B','Curso de Redes de Computadores - 4º semestre, noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(9,'Sistemas de Informação 5A','Curso de Sistemas de Informação - 5º semestre, manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(10,'Sistemas de Informação 5B','Curso de Sistemas de Informação - 5º semestre, noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(11,'Gestão de TI 6A','Curso de Gestão da Tecnologia da Informação - 6º semestre, manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(12,'Gestão de TI 6B','Curso de Gestão da Tecnologia da Informação - 6º semestre, noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(13,'Banco de Dados 7A','Especialização em Banco de Dados - 7º semestre, manhã','2025-08-28 03:35:57','2025-08-28 03:35:57'),(14,'Banco de Dados 7B','Especialização em Banco de Dados - 7º semestre, noite','2025-08-28 03:35:57','2025-08-28 03:35:57'),(15,'Segurança da Informação 8A','Curso de Segurança da Informação - 8º semestre, manhã','2025-08-28 03:35:57','2025-08-28 03:35:57');
/*!40000 ALTER TABLE `turmas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Admin','admin@fiap.com','$2y$12$kbbff9KJmQqB4B7aIx56FutqtHXc4dbVg6m1dRzIQbMpQtHop1hz.','2025-08-28 04:18:43','2025-08-28 04:18:58');
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

-- Dump completed on 2025-08-28  1:25:44
