-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 02 fév. 2020 à 14:21
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pinf`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `idArticle` int(11) NOT NULL AUTO_INCREMENT,
  `idU` int(11) NOT NULL,
  `dateArticle` date NOT NULL,
  `titre` text NOT NULL,
  `contenu` longtext NOT NULL,
  PRIMARY KEY (`idArticle`),
  KEY `article_idU` (`idU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `choix_sondage`
--

DROP TABLE IF EXISTS `choix_sondage`;
CREATE TABLE IF NOT EXISTS `choix_sondage` (
  `idChoix` int(11) NOT NULL AUTO_INCREMENT,
  `idSondage` int(11) NOT NULL,
  `choix` text NOT NULL,
  `ouvert` tinyint(1) NOT NULL,
  PRIMARY KEY (`idChoix`),
  KEY `choix_sondage_idSondage` (`idSondage`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `choix_user`
--

DROP TABLE IF EXISTS `choix_user`;
CREATE TABLE IF NOT EXISTS `choix_user` (
  `idU` int(11) NOT NULL,
  `idChoix` int(11) NOT NULL,
  PRIMARY KEY (`idU`,`idChoix`),
  KEY `idChoix` (`idChoix`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `crowd_funding`
--

DROP TABLE IF EXISTS `crowd_funding`;
CREATE TABLE IF NOT EXISTS `crowd_funding` (
  `idCrowdF` int(11) NOT NULL AUTO_INCREMENT,
  `lienUlule` text NOT NULL,
  PRIMARY KEY (`idCrowdF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `date_spectacle`
--

DROP TABLE IF EXISTS `date_spectacle`;
CREATE TABLE IF NOT EXISTS `date_spectacle` (
  `idDate` int(11) NOT NULL AUTO_INCREMENT,
  `idSpectacle` int(11) NOT NULL,
  `dateSpectacle` date NOT NULL,
  PRIMARY KEY (`idDate`),
  KEY `date_spectacle_idSpectacle` (`idSpectacle`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `date_spectacle`
--

INSERT INTO `date_spectacle` (`idDate`, `idSpectacle`, `dateSpectacle`) VALUES
(1, 4, '2020-03-19'),
(2, 2, '2020-02-21'),
(3, 4, '2020-02-12'),
(4, 3, '2020-02-22'),
(5, 1, '2020-02-28'),
(6, 3, '2020-02-26'),
(7, 4, '2020-02-15'),
(8, 1, '2020-02-05');

-- --------------------------------------------------------

--
-- Structure de la table `idee_ville`
--

DROP TABLE IF EXISTS `idee_ville`;
CREATE TABLE IF NOT EXISTS `idee_ville` (
  `id_idee_ville` int(11) NOT NULL AUTO_INCREMENT,
  `idU` int(11) NOT NULL,
  `nomVille` text NOT NULL,
  `prevenir` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_idee_ville`),
  KEY `idU_idee_ville` (`idU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `droits` text NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sondage`
--

DROP TABLE IF EXISTS `sondage`;
CREATE TABLE IF NOT EXISTS `sondage` (
  `idSondage` int(11) NOT NULL AUTO_INCREMENT,
  `idU` int(11) NOT NULL,
  `intitule` text NOT NULL,
  `nbChoix` int(11) NOT NULL,
  `cacherResultats` tinyint(1) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  PRIMARY KEY (`idSondage`),
  UNIQUE KEY `sondage_idU` (`idU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `spectacle`
--

DROP TABLE IF EXISTS `spectacle`;
CREATE TABLE IF NOT EXISTS `spectacle` (
  `idSpectacle` int(11) NOT NULL AUTO_INCREMENT,
  `ville` tinytext NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idSpectacle`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `spectacle`
--

INSERT INTO `spectacle` (`idSpectacle`, `ville`, `description`) VALUES
(1, 'Paris', 'Spectacle 1'),
(2, 'Lille', 'spectacle 2'),
(3, 'Marseille', 'spectacle 3'),
(4, 'Brest', 'spectacle 4');

-- --------------------------------------------------------

--
-- Structure de la table `spectacle_user`
--

DROP TABLE IF EXISTS `spectacle_user`;
CREATE TABLE IF NOT EXISTS `spectacle_user` (
  `idDate` int(11) NOT NULL,
  `idU` int(11) NOT NULL,
  `idSpectacle` int(11) NOT NULL,
  PRIMARY KEY (`idDate`,`idU`,`idSpectacle`),
  KEY `idDate` (`idDate`),
  KEY `idU` (`idU`),
  KEY `idSpectacle` (`idSpectacle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `spectacle_user`
--

INSERT INTO `spectacle_user` (`idDate`, `idU`, `idSpectacle`) VALUES
(1, 2, 4),
(2, 2, 2),
(3, 2, 4),
(4, 1, 3),
(5, 2, 1),
(6, 1, 3),
(7, 1, 4),
(8, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idU` int(11) NOT NULL AUTO_INCREMENT,
  `email` tinytext NOT NULL,
  `nom` tinytext NOT NULL,
  `prenom` tinytext NOT NULL,
  `passe` text NOT NULL,
  `superadmin` tinyint(1) NOT NULL,
  `code` tinyint(1) NOT NULL,
  `hashCode` text NOT NULL,
  PRIMARY KEY (`idU`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idU`, `email`, `nom`, `prenom`, `passe`, `superadmin`, `code`, `hashCode`) VALUES
(1, 'toto@gmail.com', 'TOTO', 'toto', '0ced5f8206650e18dfae568c7cb802d4ba84a224', 0, 0, '0'),
(2, 'tata@gmail.com', 'TATA', 'tata', '0ced5f8206650e18dfae568c7cb802d4ba84a224', 1, 0, '0');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `idU` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  PRIMARY KEY (`idU`,`idRole`),
  KEY `idRole` (`idRole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `idVideo` int(11) NOT NULL AUTO_INCREMENT,
  `lien` text NOT NULL,
  `idYoutube` text NOT NULL,
  PRIMARY KEY (`idVideo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `choix_sondage`
--
ALTER TABLE `choix_sondage`
  ADD CONSTRAINT `choix_sondage_ibfk_1` FOREIGN KEY (`idSondage`) REFERENCES `sondage` (`idSondage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `choix_user`
--
ALTER TABLE `choix_user`
  ADD CONSTRAINT `choix_user_ibfk_1` FOREIGN KEY (`idChoix`) REFERENCES `choix_sondage` (`idChoix`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `choix_user_ibfk_2` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `date_spectacle`
--
ALTER TABLE `date_spectacle`
  ADD CONSTRAINT `date_spectacle_ibfk_1` FOREIGN KEY (`idSpectacle`) REFERENCES `spectacle` (`idSpectacle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `idee_ville`
--
ALTER TABLE `idee_ville`
  ADD CONSTRAINT `idee_ville_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sondage`
--
ALTER TABLE `sondage`
  ADD CONSTRAINT `sondage_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `spectacle_user`
--
ALTER TABLE `spectacle_user`
  ADD CONSTRAINT `spectacle_user_ibfk_1` FOREIGN KEY (`idSpectacle`) REFERENCES `spectacle` (`idSpectacle`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spectacle_user_ibfk_2` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `spectacle_user_ibfk_3` FOREIGN KEY (`idDate`) REFERENCES `date_spectacle` (`idDate`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `user` (`idU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
