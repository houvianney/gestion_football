-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 mars 2026 à 10:42
-- Version du serveur : 9.1.0
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_football`
--

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

DROP TABLE IF EXISTS `club`;
CREATE TABLE IF NOT EXISTS `club` (
  `id_Club` int NOT NULL AUTO_INCREMENT,
  `nom_Club` varchar(100) NOT NULL,
  `id_Commune` int NOT NULL,
  PRIMARY KEY (`id_Club`),
  KEY `id_Commune` (`id_Commune`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `club`
--

INSERT INTO `club` (`id_Club`, `nom_Club`, `id_Commune`) VALUES
(1, 'Barcelone', 2),
(2, 'Madrid', 2);

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

DROP TABLE IF EXISTS `commune`;
CREATE TABLE IF NOT EXISTS `commune` (
  `id_Commune` int NOT NULL AUTO_INCREMENT,
  `lib_Commune` varchar(100) NOT NULL,
  `id_depart` int NOT NULL,
  PRIMARY KEY (`id_Commune`),
  KEY `id_depart` (`id_depart`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commune`
--

INSERT INTO `commune` (`id_Commune`, `lib_Commune`, `id_depart`) VALUES
(2, 'porto', 1);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

DROP TABLE IF EXISTS `departement`;
CREATE TABLE IF NOT EXISTS `departement` (
  `id_departement` int NOT NULL AUTO_INCREMENT,
  `lib_depart` varchar(100) NOT NULL,
  PRIMARY KEY (`id_departement`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_departement`, `lib_depart`) VALUES
(1, 'Ouémé'),
(2, 'Littoral'),
(3, 'Atlantique');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id_Joueur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `joueur` tinyint(1) DEFAULT '1',
  `id_Club` int NOT NULL,
  `poste` enum('gardien','défenseur','milieu','attaquant') NOT NULL,
  PRIMARY KEY (`id_Joueur`),
  KEY `id_Club` (`id_Club`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_Joueur`, `nom`, `prenom`, `photo`, `joueur`, `id_Club`, `poste`) VALUES
(3, 'Promotion GE3-SIL', 'vianney', '1773916205_gettyimages-157186390-612x612.jpg', 1, 1, 'milieu'),
(4, 'Génie info', 'Caroline', '1773916574_gettyimages-157186390-612x612.jpg', 1, 1, 'gardien');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
