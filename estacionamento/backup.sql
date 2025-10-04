-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23/09/2025 às 19:53
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estacionamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carro`
--

DROP TABLE IF EXISTS `carro`;
CREATE TABLE IF NOT EXISTS `carro` (
  `Placa` varchar(10) NOT NULL,
  `Modelo` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`Placa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `registro`
--

DROP TABLE IF EXISTS `registro`;
CREATE TABLE IF NOT EXISTS `registro` (
  `id_registro` int NOT NULL AUTO_INCREMENT,
  `Placa` varchar(10) DEFAULT NULL,
  `hora_entrada` datetime DEFAULT NULL,
  `hora_saida` datetime DEFAULT NULL,
  `valor_cobrado` decimal(10,2) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_registro`),
  KEY `Placa` (`Placa`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
