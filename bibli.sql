-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 06 Mai 2014 à 12:55
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `bibli`
--
CREATE DATABASE IF NOT EXISTS `bibli` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bibli`;

-- --------------------------------------------------------

--
-- Structure de la table `bdd`
--

CREATE TABLE IF NOT EXISTS `bdd` (
  `nom` varchar(50) NOT NULL,
  `fichier` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `nombre` int(11) NOT NULL,
  `maj` bigint(20) NOT NULL,
  PRIMARY KEY (`nom`),
  UNIQUE KEY `fichier` (`fichier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bdd`
--

INSERT INTO `bdd` (`nom`, `fichier`, `description`, `nombre`, `maj`) VALUES
('Super BDD', '5060514report.csv', 'Tous les livres du monde entier !', 42, 1399380234);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
