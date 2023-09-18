-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 21 jan. 2020 à 19:56
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `app`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL DEFAULT 'mdp',
  `birthday` date NOT NULL,
  `phone` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `genre` int(1) NOT NULL,
  `pays` text NOT NULL,
  `ville` text NOT NULL,
  `ZIP` int(11) NOT NULL,
  `adresse` text NOT NULL,
  `adresse2` text NOT NULL,
  `typeUtilisateur` int(14) NOT NULL DEFAULT '2',
  `imageProfile` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id`, `mail`, `mdp`, `birthday`, `phone`, `nom`, `prenom`, `genre`, `pays`, `ville`, `ZIP`, `adresse`, `adresse2`, `typeUtilisateur`, `imageProfile`) VALUES
(18, 'ok@google.com', '$2y$10$1bii32T95nZHgnujbX8OAOx9uciTAwyGhMrwWhu4dIS.XBw75RfK6', '1900-01-01', 1023456789, 'ah', 'Cyril', 1, 'France', 'ISSY', 92130, '4 Bis rue CHENIER', 'NR', 0, 'stress.png'),
(26, 'canchero@yopmail.com', '$2y$10$1bii32T95nZHgnujbX8OAOx9uciTAwyGhMrwWhu4dIS.XBw75RfK6', '1999-07-02', 6, 'lacroix', 'leopold', 1, 'france', 'paris', 21, '21 av', '', 0, ''),
(27, 'oks@gmail.com', '$2y$10$1bii32T95nZHgnujbX8OAOx9uciTAwyGhMrwWhu4dIS.XBw75RfK6', '0001-01-01', 1, 'aA', 'a', 0, 'a', 'a', 1, 'a', 'a', 1, '78-hex-abstract-material-design-wallpaper.jpg'),
(28, 'oka@gmail.com', '$2y$10$1bii32T95nZHgnujbX8OAOx9uciTAwyGhMrwWhu4dIS.XBw75RfK6', '0001-01-01', 11, '1', '1', 0, '1', '1', 1, '1', '', 2, 'stopwatch-icon-260nw-681013417.webp');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
