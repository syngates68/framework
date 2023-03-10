-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 mars 2023 à 13:59
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `framework`
--

-- --------------------------------------------------------

--
-- Structure de la table `components`
--

DROP TABLE IF EXISTS `components`;
CREATE TABLE IF NOT EXISTS `components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_projet` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `classname` varchar(255) NOT NULL,
  `html_component` varchar(255) DEFAULT NULL,
  `html_content` text,
  `component_parent` int(11) DEFAULT NULL,
  `main` int(11) NOT NULL DEFAULT '0',
  `actif` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `components`
--

INSERT INTO `components` (`id`, `id_projet`, `type`, `nom`, `classname`, `html_component`, `html_content`, `component_parent`, `main`, `actif`) VALUES
(1, 1, 'buttons', 'Bouton par défaut', 'btn', NULL, NULL, NULL, 1, 1),
(2, 1, 'buttons', 'Bouton principal', 'primary', NULL, NULL, NULL, 0, 1),
(3, 1, 'buttons', 'Bouton secondaire', 'secondary', NULL, NULL, NULL, 0, 1),
(4, 1, 'buttons', 'Bouton succès', 'success', NULL, NULL, NULL, 0, 1),
(5, 1, 'buttons', 'Bouton danger', 'danger', NULL, NULL, NULL, 0, 1),
(6, 1, 'buttons', 'Bouton alerte', 'warning', NULL, NULL, NULL, 0, 1),
(7, 1, 'buttons', 'Bouton information', 'info', NULL, NULL, NULL, 0, 1),
(8, 1, 'alerts', 'Alerte par défaut', 'alert', NULL, NULL, NULL, 1, 1),
(9, 1, 'alerts', 'Alerte de succès', 'success', NULL, NULL, NULL, 0, 1),
(10, 3, 'buttons', 'Bouton par défaut', 'btn', NULL, NULL, NULL, 1, 1),
(11, 3, 'buttons', 'Bouton principal', 'primary', NULL, NULL, NULL, 0, 1),
(12, 3, 'buttons', 'Bouton secondaire', 'secondary', NULL, NULL, NULL, 0, 1),
(13, 3, 'buttons', 'Bouton succès', 'success', NULL, NULL, NULL, 0, 1),
(14, 3, 'buttons', 'Bouton danger', 'danger', NULL, NULL, NULL, 0, 1),
(15, 3, 'buttons', 'Bouton alerte', 'warning', NULL, NULL, NULL, 0, 1),
(16, 3, 'buttons', 'Bouton information', 'info', NULL, NULL, NULL, 0, 1),
(17, 3, 'alerts', 'Message par défaut', 'alert', NULL, NULL, NULL, 1, 1),
(18, 3, 'alerts', 'Message principal', 'primary', NULL, NULL, NULL, 0, 1),
(19, 3, 'alerts', 'Message secondaire', 'secondary', NULL, NULL, NULL, 0, 1),
(20, 3, 'alerts', 'Message succès', 'success', NULL, NULL, NULL, 0, 1),
(21, 3, 'alerts', 'Message danger', 'danger', NULL, NULL, NULL, 0, 1),
(22, 3, 'alerts', 'Message alerte', 'warning', NULL, NULL, NULL, 0, 1),
(23, 3, 'alerts', 'Message information', 'info', NULL, NULL, NULL, 0, 1),
(24, 4, 'buttons', 'Bouton par défaut', 'btn', NULL, NULL, NULL, 1, 1),
(25, 4, 'buttons', 'Bouton principal', 'primary', NULL, NULL, NULL, 0, 1),
(26, 4, 'buttons', 'Bouton secondaire', 'secondary', NULL, NULL, NULL, 0, 1),
(27, 4, 'buttons', 'Bouton succès', 'success', NULL, NULL, NULL, 0, 1),
(28, 4, 'buttons', 'Bouton danger', 'danger', NULL, NULL, NULL, 0, 1),
(29, 4, 'buttons', 'Bouton alerte', 'warning', NULL, NULL, NULL, 0, 1),
(30, 4, 'buttons', 'Bouton information', 'info', NULL, NULL, NULL, 0, 1),
(31, 4, 'alerts', 'Message par défaut', 'alert', NULL, NULL, NULL, 1, 1),
(32, 4, 'alerts', 'Message principal', 'primary', NULL, NULL, NULL, 0, 1),
(33, 4, 'alerts', 'Message secondaire', 'secondary', NULL, NULL, NULL, 0, 1),
(34, 4, 'alerts', 'Message succès', 'success', NULL, NULL, NULL, 0, 1),
(35, 4, 'alerts', 'Message danger', 'danger', NULL, NULL, NULL, 0, 1),
(36, 4, 'alerts', 'Message alerte', 'warning', NULL, NULL, NULL, 0, 1),
(37, 4, 'alerts', 'Message information', 'info', NULL, NULL, NULL, 0, 1),
(38, 4, 'alerts', 'Message avec titre', 'info', NULL, NULL, NULL, 0, 1),
(39, 4, 'alerts', NULL, 'alert-title', 'div', 'Ceci est un titre', 38, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `uniqid` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `nom`, `uniqid`, `date_creation`) VALUES
(1, 'COPROTEC', '63ce8f170f8d8', '2023-01-23 14:44:02'),
(2, 'TEST', '63e3dbcfc2b02', '2023-02-08 18:28:47'),
(3, 'TEST', '63e3df84b92d3', '2023-02-08 18:44:36'),
(4, 'TEST', '63e3e0de91e4a', '2023-02-08 18:50:22');

-- --------------------------------------------------------

--
-- Structure de la table `regles`
--

DROP TABLE IF EXISTS `regles`;
CREATE TABLE IF NOT EXISTS `regles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_component` int(11) NOT NULL,
  `regle` varchar(255) NOT NULL,
  `valeur` varchar(255) NOT NULL,
  `unite` varchar(20) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `regles`
--

INSERT INTO `regles` (`id`, `id_component`, `regle`, `valeur`, `unite`, `actif`) VALUES
(1, 1, 'border-width', '1', 'px', 1),
(2, 1, 'padding-top', '12', 'px', 1),
(3, 1, 'padding-bottom', '12', 'px', 1),
(4, 1, 'padding-left', '24', 'px', 1),
(5, 1, 'padding-right', '24', 'px', 1),
(6, 1, 'font-size', '12', 'px', 1),
(13, 1, 'background-color', '#FFFFFF', NULL, 1),
(14, 1, 'border-radius', '5', 'px', 1),
(15, 1, 'color', '#000000', '', 1),
(16, 1, 'font-family', '\'Open Sans\', sans-serif', '', 1),
(17, 2, 'background-color', '#03428F', '', 1),
(18, 2, 'color', '#FFFFFF', '', 1),
(21, 1, 'font-weight', '600', '', 1),
(22, 1, 'border-color', '#FFFFFF', '', 1),
(23, 1, 'border-style', 'solid', '', 1),
(25, 1, 'box-shadow', '2px 2px 6px 0px #d2d2d2', '', 1),
(35, 3, 'color', '#000000', '', 1),
(46, 3, 'background-color', '#ffffff', '', 1),
(47, 4, 'color', '#ffffff', '', 1),
(58, 5, 'background-color', '#fe3d3d', '', 1),
(59, 5, 'color', '#ffffff', '', 1),
(68, 6, 'color', '#ffffff', '', 1),
(69, 6, 'background-color', '#f9c14f', '', 1),
(76, 4, 'background-color', '#2d971a', '', 1),
(77, 7, 'background-color', '#68caf9', '', 1),
(78, 7, 'color', '#ffffff', '', 1),
(79, 2, 'border-color', '#03428F', '', 1),
(80, 3, 'border-color', '#D8D8D8', '', 1),
(81, 5, 'border-color', '#fe3d3d', '', 1),
(82, 6, 'border-color', '#f9c14f', '', 1),
(83, 7, 'border-color', '#68caf9', '', 1),
(84, 4, 'border-color', '#2d971a', '', 1),
(85, 8, 'font-family', '\'Roboto\', sans-serif', '', 1),
(87, 9, 'background-color', '#fcfff5', '', 1),
(88, 8, 'padding-left', '16', 'px', 1),
(89, 8, 'padding-right', '16', 'px', 1),
(90, 8, 'padding-top', '16', 'px', 1),
(91, 8, 'padding-bottom', '16', 'px', 1),
(92, 8, 'box-shadow', '0px 0px 0px 0px #CCCCCC', '', 1),
(93, 9, 'color', '#2c662d', '', 1),
(94, 8, 'border-width', '1', 'px', 1),
(95, 8, 'border-radius', '0', 'px', 1),
(96, 8, 'border-style', 'solid', '', 1),
(97, 9, 'border-color', '#2c662d', '', 1),
(98, 8, 'font-size', '13', 'px', 1),
(99, 8, 'font-weight', '300', '', 1),
(100, 8, 'color', '#000000', '', 1),
(101, 24, 'color', '#000000', NULL, 1),
(102, 24, 'background-color', '#FFFFFF', NULL, 1),
(103, 24, 'font-size', '13', 'px', 1),
(104, 25, 'color', '#000000', NULL, 1),
(105, 25, 'background-color', '#FFFFFF', NULL, 1),
(106, 25, 'font-size', '13', 'px', 1),
(107, 26, 'color', '#000000', NULL, 1),
(108, 26, 'background-color', '#FFFFFF', NULL, 1),
(109, 26, 'font-size', '13', 'px', 1),
(110, 27, 'color', '#000000', NULL, 1),
(111, 27, 'background-color', '#FFFFFF', NULL, 1),
(112, 27, 'font-size', '13', 'px', 1),
(113, 28, 'color', '#000000', NULL, 1),
(114, 28, 'background-color', '#FFFFFF', NULL, 1),
(115, 28, 'font-size', '13', 'px', 1),
(116, 29, 'color', '#000000', NULL, 1),
(117, 29, 'background-color', '#FFFFFF', NULL, 1),
(118, 29, 'font-size', '13', 'px', 1),
(119, 30, 'color', '#000000', NULL, 1),
(120, 30, 'background-color', '#FFFFFF', NULL, 1),
(121, 30, 'font-size', '13', 'px', 1),
(122, 31, 'color', '#000000', NULL, 1),
(123, 31, 'background-color', '#FFFFFF', NULL, 1),
(124, 31, 'font-size', '13', 'px', 1),
(125, 32, 'color', '#005C0A', NULL, 1),
(126, 32, 'background-color', '#CCF8E4', NULL, 1),
(127, 32, 'font-size', '13', 'px', 1),
(128, 33, 'color', '#000000', NULL, 1),
(129, 33, 'background-color', '#FFFFFF', NULL, 1),
(130, 33, 'font-size', '13', 'px', 1),
(131, 34, 'color', '#000000', NULL, 1),
(132, 34, 'background-color', '#FFFFFF', NULL, 1),
(133, 34, 'font-size', '13', 'px', 1),
(134, 35, 'color', '#000000', NULL, 1),
(135, 35, 'background-color', '#FFFFFF', NULL, 1),
(136, 35, 'font-size', '13', 'px', 1),
(137, 36, 'color', '#000000', NULL, 1),
(138, 36, 'background-color', '#FFFFFF', NULL, 1),
(139, 36, 'font-size', '13', 'px', 1),
(140, 37, 'color', '#000000', NULL, 1),
(141, 37, 'background-color', '#FFFFFF', NULL, 1),
(142, 37, 'font-size', '13', 'px', 1),
(143, 31, 'padding-left', '12', 'px', 1),
(144, 31, 'padding-right', '12', 'px', 1),
(145, 31, 'padding-top', '16', 'px', 1),
(146, 31, 'padding-bottom', '16', 'px', 1),
(147, 31, 'border-radius', '4', 'px', 1),
(148, 32, 'border-color', '#005C0A', '', 1),
(149, 31, 'border-width', '1', 'px', 1),
(150, 31, 'border-style', 'solid', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
