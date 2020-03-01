-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 27 fév. 2020 à 13:10
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idU`, `email`, `nom`, `prenom`, `passe`, `superadmin`, `code`, `hashCode`) VALUES
(1, 'toto@gmail.com', 'TOTO', 'toto', '0ced5f8206650e18dfae568c7cb802d4ba84a224', 0, 1, '0'),
(2, 'tata@gmail.com', 'TATA', 'tata', '0ced5f8206650e18dfae568c7cb802d4ba84a224', 1, 1, '0'),
(3, 'clementboyaval@gmail.com', 'Clément', 'Boyaval', '0ea97408e22da28e7c02244c20287d49077951fc', 0, 1, '1ab57a44a6f2ff1a4c85221559bd90d4');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `videoId` text NOT NULL,
  `publishedAt` date NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `thumbnails` text NOT NULL,
  `checked` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `videoId`, `publishedAt`, `title`, `description`, `thumbnails`, `checked`) VALUES
(1, 'egYaJSANywk', '2020-02-16', 'Balkany libéré, Griveaux retiré &amp; Marlène trop dévouée ! (J&#39;SUIS PAS CONTENT ! #S06E06)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/egYaJSANywk/default.jpg', 0),
(2, 'xji-m3VWSSg', '2020-02-11', 'L&#39;épisode du bout de ma vie ! [J&#39;SUIS PAS CONTENT ! - Hors-Série]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/xji-m3VWSSg/default.jpg', 0),
(3, '6pyuSfiLjdU', '2020-01-17', 'Ségolène au chomage, Macron au partage &amp; Rokhaya au largage  ! (J&#39;SUIS PAS CONTENT ! #S06E05)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/6pyuSfiLjdU/default.jpg', 0),
(4, 'l9SxhPd4P6E', '2020-01-14', 'Retrogaming LREM, Pierre-Alain le malin &amp; Marlène la mathématicienne ! (J&#39;SUIS PAS CONTENT! #S06E04)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/l9SxhPd4P6E/default.jpg', 0),
(5, 'JIXPGDxIf-w', '2020-01-10', 'Carlos Ghosn au Libran &amp; Sac plastiques dans 20 ans ! (J&#39;SUIS PAS CONTENT ! #06SE03)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/JIXPGDxIf-w/default.jpg', 0),
(6, 'T0ErdUZSx14', '2020-01-08', 'Grèves sur le déclin (?), Faure fait le malin &amp; Balkany MacLeod ! (J&#39;SUIS PAS CONTENT !  #S06E02)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/T0ErdUZSx14/default.jpg', 0),
(7, 'GRydtHMFyVw', '2020-01-06', 'Légion d&#39;honneur, Smarties &amp; Squeezie 2.0 ! (J&#39;SUIS PAS CONTENT ! #S06E01)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/GRydtHMFyVw/default.jpg', 0),
(8, 'WOKByxYVmIo', '2019-12-14', 'Réforme des retraites : Schiappa atteint le stade LEGENDAIRE ! (Vive la France ! #S02E25)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/WOKByxYVmIo/default.jpg', 0),
(9, 'n8hpM36-19Q', '2019-12-10', 'TF1 VS Grévistes, Darmanin VS Décence &amp; Aubry VS Dignité ! (Vive la France ! #S02E24)', 'Lien ULULE du Tome 2 des FDP DE TUBONIA : https://fr.ulule.com/tubonia-tome-2/ · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/n8hpM36-19Q/default.jpg', 0),
(10, 'TchlXuPWBYk', '2019-12-04', 'Samuraï du Wakanda / Loto du patrimoine / Quotidien en PLS [EN LIVE ! #04 - Partie 2/3]', 'LES TROIS PARTIES DU LIVE : - PARTIE 1/3 : https://www.youtube.com/watch?v=OL6N-5xGTx8 - PARTIE 2/3 ...', 'https://i.ytimg.com/vi/TchlXuPWBYk/default.jpg', 0),
(11, 'OL6N-5xGTx8', '2019-12-04', 'Candidats Eco+ / Gauche 2.0 / Branco rate son buzz  [EN LIVE ! #04 - Partie 1/3]', 'LES TROIS PARTIES DU LIVE : - PARTIE 1/3 : https://www.youtube.com/watch?v=OL6N-5xGTx8 - PARTIE 2/3 ...', 'https://i.ytimg.com/vi/OL6N-5xGTx8/default.jpg', 0),
(12, 'DA3DIB-IREs', '2019-12-04', 'Démocratie 2.0  / Journalisme de qualitay / On sort un jeu en 2020 ! [EN LIVE ! #04 - Partie 3/3]', 'LES TROIS PARTIES DU LIVE : - PARTIE 1/3 : https://www.youtube.com/watch?v=OL6N-5xGTx8 - PARTIE 2/3 ...', 'https://i.ytimg.com/vi/DA3DIB-IREs/default.jpg', 0),
(13, 'L8bQrsXiydQ', '2019-11-28', 'J&#39;SUIS PAS CONTENT ! #238  : Macron tout triste, Pénicaud toute réac &amp; Schiappa toute mystique !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/L8bQrsXiydQ/default.jpg', 0),
(14, 'vQ8WjmVENgY', '2019-11-24', 'Castor énervé, Macron effrayé &amp; Black Blocs déterminés ! (VIVE LA FRANCE ! #S02E23)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/vQ8WjmVENgY/default.jpg', 0),
(15, 'yDLJ6wOVFKM', '2019-11-23', 'Mac Do pas vraiment Hallal &amp; Polanski pas vraiment défendu ! (VIVE LA FRANCE ! #S02E22)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/yDLJ6wOVFKM/default.jpg', 0),
(16, 'HoCRltAVu0U', '2019-11-16', 'MANIF CONTRE L&#39;ISLAMOPHOBIE : PARLONS-EN ! (Vive la France ! #Hors-Série 03)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/HoCRltAVu0U/default.jpg', 0),
(17, 'Aps7Zwid6sQ', '2019-11-04', 'VIVE LA FRANCE ! #S02E21 : T&#39;as voulu voir Honfleur &amp; tu as vu Honfleur !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/Aps7Zwid6sQ/default.jpg', 0),
(18, 'PxB3emvpR8c', '2019-10-31', '[BEST OF LIVE ! #04] Rokhaya VS Pansements &amp; Mythe des révolutions pacifistes', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/PxB3emvpR8c/default.jpg', 0),
(19, 'O8MfBmQlz4U', '2019-10-30', 'Fraude fiscale, Zemmour le Gaulois &amp; 11 Septembre Eco+ ! (VIVE LA FRANCE ! #S02E20)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/O8MfBmQlz4U/default.jpg', 0),
(20, 'TPDuRFRCwTU', '2019-10-29', '[BEST OF LIVE ! #03] La dernière &quot;bourde&quot; de Sibeth / La fabrication du complotisme', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/TPDuRFRCwTU/default.jpg', 0),
(21, '5qGZXvizwG8', '2019-10-28', 'Macron dans les îles, Berger qui roupille et Quotidien qui patine ! (VIVE LA FRANCE ! #S02E19)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/5qGZXvizwG8/default.jpg', 0),
(22, '9qY_reND7gU', '2019-10-14', 'LE TOP 10 DU PROGRÈS DE LA FIN DU MONDE ! [Vive la France ! #Hors-Série 02]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/9qY_reND7gU/default.jpg', 0),
(23, 'WbwWbvjtuRo', '2019-10-11', 'CATASTROPHE SANITAIRE, GOULARD QUI GALÈRE &amp; ATTALI CHEZ E/R ! (Vive la France ! #S02E18)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/WbwWbvjtuRo/default.jpg', 0),
(24, 'kDNPHKLPF3Q', '2019-10-10', 'POURQUOI J&#39;AI FAILLI ARRETER LA CHAINE / CE QUI VA CHANGER.', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/kDNPHKLPF3Q/default.jpg', 0),
(25, 'eZLkgp3vCuA', '2019-10-09', 'POLICE ENDEUILLÉE, MARLÈNE POSSÉDÉE &amp; GÉGÉ ÉNERVÉ ! (Vive la France ! #S02E17)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/eZLkgp3vCuA/default.jpg', 0),
(26, 'rv-Qu2ZGi9o', '2019-09-29', 'GRETA FAIT LA PESTE, LAREM RETOURNE SA VESTE ! (Vive la France ! #S02E16)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/rv-Qu2ZGi9o/default.jpg', 0),
(27, 'C1V7sGDmD2I', '2019-09-25', 'LE PERE NOEL EST EN AVANCE !!! (Vive la France ! #S02E15)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/C1V7sGDmD2I/default.jpg', 0),
(28, 'ChI_hOpB4ys', '2019-09-21', 'BALKANY EN ZONZON &amp; YANN BARTHES TROP MIGNON ! (Vive La France ! #S02E14)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/ChI_hOpB4ys/default.jpg', 0),
(29, 'RmTJYdOgyMU', '2019-09-19', 'Tous unis contre le RN, Gad Elmaleh nous invite &amp; Villani a Paris ! (Vive la France ! #S02E13)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/RmTJYdOgyMU/default.jpg', 0),
(30, 'rXnQh2bFk1U', '2019-09-18', 'RETRAITES, ECOLOGIE MARQUE REPÈRE &amp; VIVRE ENSEMBLE  ! (Vive la France ! #S02E12)', 'Voici le mail de Jahbulon ! (et non son \"numéro\" comme dit dans la vidéo lol) : brokjah@gmail.com · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/rXnQh2bFk1U/default.jpg', 0),
(31, 'IehYhLkjSow', '2019-09-14', 'ADP : Empêchons la pire privatisation de l’histoire ! (Ft. pleins de gens) [Le OFF #10]', 'Rarement un projet de privatisation n\'aura été aussi injustifiable et mal fichu. Le gouvernement s\'apprête à vendre, à un prix sous-estimé, un monopole qu\'il ne ...', 'https://i.ytimg.com/vi/IehYhLkjSow/default.jpg', 0),
(32, 'rC7anXckvfM', '2019-09-11', 'TROP DE PROGREEEEEEEEEES ! (Sauf pour Yann Moix) [Vive la France #S02E11]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/rC7anXckvfM/default.jpg', 0),
(33, 'VGVJTlTc520', '2019-09-10', 'BENALLA DETER, CASTANER LE MYTHO &amp; ECOLOGIE DECOMPLEXEE ! (Vive la France ! #S02E10)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/VGVJTlTc520/default.jpg', 0),
(34, 'TKhN2zXLE8w', '2019-09-09', 'ACTE 43, NICO IS BACK &amp; JUSTICE POUR LES GALLINACÉS ! (Vive la France ! #S02E09)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/TKhN2zXLE8w/default.jpg', 0),
(35, 'nGbODVGXaOY', '2019-09-06', 'Schiappa VS &quot;Féminicides&quot;, Castaner VS bon gout &amp; Chine VS LREM ! (Vive la France ! #S02E08)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/nGbODVGXaOY/default.jpg', 0),
(36, '7xpzitgyFhU', '2019-09-05', 'AMAZONIE, MACRON LE THUG &amp; CUILLÈRE DU PROGRES ! (Vive la France ! #S02E07)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/7xpzitgyFhU/default.jpg', 0),
(37, 'd9Nbas4p6bc', '2019-08-17', 'NESTLE DANS LE CACA (ou l&#39;inverse), MARLENE NCIS &amp; CLIFFHANGER ECO+ (Vive la France ! #S02E05)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/d9Nbas4p6bc/default.jpg', 0),
(38, 'dZ43E772XtM', '2019-08-16', 'MACRON VS PIZZA, POLICE VS CAILLOU &amp; CHAISES VS PROGRES ! (Vive la France ! #S02E04)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/dZ43E772XtM/default.jpg', 0),
(39, 'iX6tYBfC-X0', '2019-08-10', 'CHANSON : Marlène ! [extrait de l&#39;épisode 237 de JSPC]', 'Lien de l\'épisode original : https://www.youtube.com/watch?v=Z3GjU-yKeGc&lc=Ugy57UrUKZ4-A0K-hTp4AaABAg · Ecrite et interprétée par Eddy Pero, Greg ...', 'https://i.ytimg.com/vi/iX6tYBfC-X0/default.jpg', 0),
(40, 'Z3GjU-yKeGc', '2019-08-09', 'J&#39;SUIS PAS CONTENT! #237: Fini les vacances ! [Ft. Bruno le Salé, Eddy Pero, Jaïs, JR &amp; Les poules]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/Z3GjU-yKeGc/default.jpg', 0),
(41, 'L3VMYk9wW-I', '2019-08-06', 'DE RUGY / LA DRAGUE DU PROGRES / MERKEL DANS LE MAL [EN LIVE ! #03 - Partie 1/4]', 'SOMMAIRE DE LA PARTIE 1 : Rugy et es Homards : 0:00 Angela et les Tremblement : 13:41 Le Progrès : 15:43 · LES AUTRES PARTIES DU LIVE : - PARTIE ...', 'https://i.ytimg.com/vi/L3VMYk9wW-I/default.jpg', 0),
(42, 'EfXmyJJHXaE', '2019-08-06', 'De Retour !!! 4 VIDEOS dans la DESCRIPTION !!! :)', 'LES QUATRES PARTIES DU LIVE : PARTIE 1 (DE RUGY / LA DRAGUE DU PROGRES / MERKEL DANS LE MAL) ...', 'https://i.ytimg.com/vi/EfXmyJJHXaE/default.jpg', 0),
(43, 'wEDjM4p7Pr8', '2019-08-06', 'LOI AVIA / MACRON EN PLS / CHARLINE FANFENFOFFEN [EN LIVE ! #03 - Partie 2/4]', 'SOMMAIRE DE LA PARTIE 2 : Loi Lætitia Avia : 0:00 Macron PLS : 9:04 Charline Fanfenfoffen : 11:10 · LES AUTRES PARTIES DU LIVE : - PARTIE 1 ...', 'https://i.ytimg.com/vi/wEDjM4p7Pr8/default.jpg', 0),
(44, 'aL1M_ErXrtQ', '2019-08-06', 'PETITE SIRENE / HEROINES 90&#39;S / MASTER 2.0 / MARECHAL RECALEE [EN LIVE ! #03 - Partie 3/4]', 'SOMMAIRE DE LA PARTIE 3 : Petite Sirène : 0:00 Héroïnes 90\'S: 12:57 Sorbonne Gender-Power : 16:24 Maréchale : 20:23 · LES AUTRES PARTIES DU LIVE ...', 'https://i.ytimg.com/vi/aL1M_ErXrtQ/default.jpg', 0),
(45, 'RO5x55uLRlk', '2019-08-06', 'FRANCE VS FRANCE / GAUCHE VS DROITE [EN LIVE ! #03 - Partie 4/4]', 'SOMMAIRE DE LA PARTIE 4 : FRANCE VS FRANCE : 0:00 GAUCHE VS DROITE : 7:53 · LES AUTRES PARTIES DU LIVE : - PARTIE 1 ...', 'https://i.ytimg.com/vi/RO5x55uLRlk/default.jpg', 0),
(46, 'qV2NoYfqbLo', '2019-07-09', 'CHANSON : Je suis un CIS ! (bonus épisode 236)', 'Lien de l\'épisode 236 en intégralité : https://www.youtube.com/watch?v=zPZL-W22b1Y · Les autres chansons de la chaine (saison 2) ...', 'https://i.ytimg.com/vi/qV2NoYfqbLo/default.jpg', 0),
(47, 'zPZL-W22b1Y', '2019-07-08', 'J&#39;SUIS PAS CONTENT ! #236 : Vive les Vacances ! [Feat. JR Lombard, Eddy Pero &amp; Arielle Lecomte]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/zPZL-W22b1Y/default.jpg', 0),
(48, '6LzAKerPu_g', '2019-06-25', 'CSA / VALLS / Notion(s) de Peuple(s) [EN LIVE ! #02 - Partie 1/4]', 'SOMMAIRE DE LA PARTIE 1 : CSA : 0:00 VALLS : 6:02 NOTIONS DE PEUPLES 7:04 · LES AUTRES PARTIES DU LIVE : - PARTIE 2 : Homme VS Triton ...', 'https://i.ytimg.com/vi/6LzAKerPu_g/default.jpg', 0),
(49, 'wBrDLkvMZFk', '2019-06-25', 'La polémique Étienne Chouard : Réaction à chaud [EN LIVE ! #02 - Partie 3/4]', 'LES AUTRES PARTIES DU LIVE : - PARTIE 1 : CSA / VALLS / Notion(s) de Peuple(s) : https://youtu.be/6LzAKerPu_g - PARTIE 2 : Homme VS Triton / Balkany ...', 'https://i.ytimg.com/vi/wBrDLkvMZFk/default.jpg', 0),
(50, '_Rc5giSbvJw', '2019-06-25', 'Homme VS Triton / Balkany VS Morale(s) / SJW VS Marvel (feat. Le Chat) [EN LIVE ! #02 - Partie 2/4]', 'EDIT : MISE A JOURS : FAIT EXCEPTIONNEL, Youtube a décidé de revenir sur sa décision et a monétisé les deux premières parties ainsi que la 4éme partie ...', 'https://i.ytimg.com/vi/_Rc5giSbvJw/default.jpg', 0),
(51, 'APMA6kBEdRY', '2019-06-25', 'AYAAAAA ! 4 nouvelles vidéos en DESCRIPTION !!!', 'LES QUATRE PARTIES DU LIVE : - PARTIE 1 : CSA / VALLS / Notion(s) de Peuple(s) : https://youtu.be/6LzAKerPu_g - PARTIE 2 : Homme VS Triton / Balkany ...', 'https://i.ytimg.com/vi/APMA6kBEdRY/default.jpg', 0),
(52, 'EFyQPeilbZI', '2019-06-25', 'Watch Dogs Legion / Si-Bête / Révolution Eco+ / Télé-Réalité 2.0 [EN LIVE ! #02 - Partie 4/4]', 'SOMMAIRE DE LA PARTIE 4 : Watch Dogs Legion : 0:00 Si-Bête VS Service civique : 3:07 Révolution Eco+ : 4:42 Télé-Réalité 2.0 : 6:56 Le Self Made Man ...', 'https://i.ytimg.com/vi/EFyQPeilbZI/default.jpg', 0),
(53, 's9q-vvQaP9Y', '2019-06-17', 'J&#39;SUIS PAS CONTENT ! #235 : La République de l&#39;Anneau !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/s9q-vvQaP9Y/default.jpg', 0),
(54, 'aSg5TNbIYUc', '2019-06-15', 'J&#39;SUIS PAS CONTENT ! #234 : Philippe l&#39;écolo, Macron le démago &amp; Borne la dingo !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/aSg5TNbIYUc/default.jpg', 0),
(55, 'b7Iv3cfAN3g', '2019-06-11', 'Schiappa / Marion Maréchal / Test du Privilège / Climatisation sexiste  [EN LIVE ! #01]', 'Time Code : INTRODUCTION : 00:00 - 00:55 La dernière de Schiappa : 00:55 - 04:35 Réponse à Usul : 04:35 - 05:24 Marion Maréchal revient : 05:24 - 11:17 ...', 'https://i.ytimg.com/vi/b7Iv3cfAN3g/default.jpg', 0),
(56, 'c9Fgd0WitFo', '2019-06-11', 'Ben alors Laurent Ruquier ??? [Alerte Vidéo censurée]', 'LE LIEN DU LIVE EN VERSION AMPUTEE DE 15 MINUTES : https://www.youtube.com/watch?v=b7Iv3cfAN3g · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/c9Fgd0WitFo/default.jpg', 0),
(57, 'gCaIFJ6epSM', '2019-06-07', 'J&#39;SUIS PAS CONTENT ! #233 : Fake News, Jeanne d&#39;Arc 2.0 &amp; Robotique apocalyptique ?', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/gCaIFJ6epSM/default.jpg', 0),
(58, '-CRb3rjDuMo', '2019-06-04', 'J&#39;SUIS PAS CONTENT ! #232 : Gégé rassure, Schiappa perdure &amp; Loiseau endure !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/-CRb3rjDuMo/default.jpg', 0),
(59, 'XMywADU8Ixk', '2019-05-28', 'Elections européennes, c&#39;est la caca, c&#39;est la cata, c&#39;est la catastrophe ! (JSPC #Hors Série 06)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/XMywADU8Ixk/default.jpg', 0),
(60, '9J5CxAVou3c', '2019-05-25', 'J&#39;SUIS PAS CONTENT ! #231 : Elections Européennes, Asselineau buggé &amp; Loiseau Hassani !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/9J5CxAVou3c/default.jpg', 0),
(61, '0ml_F9mzzJU', '2019-05-24', 'J&#39;SUIS PAS CONTENT ! #230 : Hamon en PLS &amp; Si Bête la muette !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/0ml_F9mzzJU/default.jpg', 0),
(62, 'ET4T8--mICY', '2019-05-19', 'J&#39;SUIS PAS CONTENT ! #229 : Eurovision, Nick Conrad &amp; Kebab européen !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/ET4T8--mICY/default.jpg', 0),
(63, 'GTywbuUibVk', '2019-05-18', 'J&#39;SUIS PAS CONTENT ! #228 : Balkany jugé, Temps de parole cheaté &amp; Esclavage remboursé !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/GTywbuUibVk/default.jpg', 0),
(64, 'JYeI4XjXKvw', '2019-05-13', 'J&#39;SUIS PAS CONTENT ! #227 : Macron l&#39;incompris, Faux followers &amp; Services publics !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/JYeI4XjXKvw/default.jpg', 0),
(65, 'BSDdKNG28WY', '2019-05-09', 'Conflit d&#39;intêret VS Progrès &amp; Schiappa VS Malaise ! (VIVE LA FRANCE ! #S02E03)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/BSDdKNG28WY/default.jpg', 0),
(66, 'usdfiCn8f3k', '2019-05-08', 'J&#39;SUIS PAS CONTENT ! #226 : Salpétrière VS Castaner, Marche pour l&#39;Europe &amp; Chasse au gaspi !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/usdfiCn8f3k/default.jpg', 0),
(67, 'c8vu0vuqIHw', '2019-05-07', 'J&#39;SUIS PAS CONTENT ! #225 : Diplomates arrêtés, Julien Dray amusé, Notre-Dame fantasmée !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/c8vu0vuqIHw/default.jpg', 0),
(68, 'Sx2mbXGdvgM', '2019-04-30', 'J&#39;SUIS PAS CONTENT ! #224 : Castaner roupille, Loiseau s&#39;écrase &amp; Schiappa n&#39;y va pas !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/Sx2mbXGdvgM/default.jpg', 0),
(69, '_wWPceME3zw', '2019-04-25', 'J&#39;SUIS PAS CONTENT ! #223 : Nathalie Loiseau en sueur, Suppression de l&#39;ENA, &amp; Propagande à gogo !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/_wWPceME3zw/default.jpg', 0),
(70, '2wzWclPt9R8', '2019-04-18', 'J&#39;SUIS PAS CONTENT ! #222 : Meyer Habib le conspi, Loiseau l&#39;historienne &amp; Schiappa la sauveuse !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/2wzWclPt9R8/default.jpg', 0),
(71, 'RxLew01e2Ko', '2019-04-16', 'Nôtre-Dame Brûle, les réseaux sociaux s&#39;enflamment [J&#39;SUIS PAS CONTENT #Hors-Série #05]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/RxLew01e2Ko/default.jpg', 0),
(72, '05RBZvbppFk', '2019-04-09', 'J&#39;SUIS PAS CONTENT ! #221 : Genevieve Legay, vers un scandale d&#39;état ?', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/05RBZvbppFk/default.jpg', 0),
(73, 'Fn8RRxgk-2Y', '2019-04-07', 'J&#39;SUIS PAS CONTENT ! #220 : Sibeth VS Marlène, déception anticipée &amp; progrès expliqué !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/Fn8RRxgk-2Y/default.jpg', 0),
(74, 'RaNjh4a-mfc', '2019-04-04', 'J&#39;SUIS PAS CONTENT ! #219 : Ndiaye attaquée, Hamon boycotté &amp; LREM veut nous protéger !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/RaNjh4a-mfc/default.jpg', 0),
(75, 'N6ItT4l_zRA', '2019-04-02', 'J&#39;SUIS PAS CONTENT ! #218 : Ndiaye porte parole, Geneviève Legay &amp; Macron VS Enfants !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/N6ItT4l_zRA/default.jpg', 0),
(76, 'N5LTJ36qv1c', '2019-03-26', 'J&#39;SUIS PAS CONTENT ! #217 : Gilets Jaunes VS Armée, République en danger ?', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/N5LTJ36qv1c/default.jpg', 0),
(77, 'JS-jYVz7FKc', '2019-03-21', 'DES CHOSES A VOUS DIRE : concert, rencontre abonnés, nouveau spectacle, livre, collab, etc...', 'RDV Samedi 23 Mars à 19h30 avec Jean-Robert : 58 Boulevard de Picpus, 75012 Paris · VIDEO avec Absol : https://www.youtube.com/watch?v=AAi7uv1l-_w ...', 'https://i.ytimg.com/vi/JS-jYVz7FKc/default.jpg', 0),
(78, 'z2tGVWXu9Kg', '2019-03-16', 'J&#39;SUIS PAS CONTENT ! #216 : Castaner pète un plomb &amp; Bigard l&#39;a dans l&#39;fion !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/z2tGVWXu9Kg/default.jpg', 0),
(79, 'VtvQr0qfRK0', '2019-03-12', 'J&#39;SUIS PAS CONTENT ! #215b : HS : Air-France KLM : la France en PLS ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/VtvQr0qfRK0/default.jpg', 0),
(80, '_k1O97OA-YU', '2019-03-08', 'Affaire Benalla, ça sent le caca ! (VIVE LA FRANCE ! #S02E02)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/_k1O97OA-YU/default.jpg', 0),
(81, '0OiZ_tbtDtU', '2019-02-28', 'Castaner au tableau &amp; Marlène Schiappa dans les choux ! (VIVE LA FRANCE ! #S02E01)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/0OiZ_tbtDtU/default.jpg', 0),
(82, 'z4kce_9EVE0', '2019-02-22', '[Reupload] J&#39;SUIS PAS CONTENT ! #213 : Finkielkraut &amp; 18-25 Eco + !', 'LIEN DE L\'EPISODE INTEGRAL SUR DAILYMOTION : https://www.dailymotion.com/video/x72vcfp · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/z4kce_9EVE0/default.jpg', 0),
(83, '2xqarWTTN9o', '2019-02-21', 'J&#39;SUIS PAS CONTENT ! #214 : Macron stand-upper &amp; Parent 1 /X Parent 2 !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/2xqarWTTN9o/default.jpg', 0),
(84, 'fszRR8z1OqM', '2019-02-20', 'VIVE LA FRANCE ! #22 : BFM les mythos, Macron &quot;investi&quot; &amp; Justice pour tous !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/fszRR8z1OqM/default.jpg', 0),
(85, 'AuGsqhfLn4I', '2019-02-11', 'J&#39;SUIS PAS CONTENT ! #212 : Castaner en roue libre VS Wauquiez version Les Experts !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/AuGsqhfLn4I/default.jpg', 0),
(86, '_yBhjVxnlVs', '2019-02-09', '[Reupload] JSPC ! #211 : Rosé de Provence, Castaner en mode réal &amp; Fillarçon mon cochon !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/_yBhjVxnlVs/default.jpg', 0),
(87, 'u6Ig4qleUJg', '2019-02-07', 'J&#39;SUIS PAS CONTENT ! #210 : Marlène mon amour, Macron en banlieue et Culture pour tous !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/u6Ig4qleUJg/default.jpg', 0),
(88, 'lbzEthW7F1Y', '2019-01-31', 'J&#39;SUIS PAS CONTENT ! #209 : Schiappa VS Galilée, Macron VS Peuple, Guerel VS Cerveau !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/lbzEthW7F1Y/default.jpg', 0),
(89, 'F1SAqZHyZ7w', '2019-01-29', 'J&#39;SUIS PAS CONTENT ! #208 : Alain Minc le rebelle VS Griveaux deux points zero !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/F1SAqZHyZ7w/default.jpg', 0),
(90, 'IQ-vqqoLJpY', '2019-01-17', 'J&#39;SUIS PAS CONTENT ! #206 : Médias réveillés, Miss Algérie pas kiffée &amp; Juanno écartée !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/IQ-vqqoLJpY/default.jpg', 0),
(91, 'j3_ZVRt_xjM', '2019-01-16', 'J&#39;SUIS PAS CONTENT ! #205 : Le JDD censure, Trump construit son mur &amp; Jupiter créa le monde...', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/j3_ZVRt_xjM/default.jpg', 0),
(92, 'u8cVacb9nK8', '2019-01-15', 'Acte IX, Peuple fainéant &amp; Sauveurs japonais ! (Vive la France 21)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/u8cVacb9nK8/default.jpg', 0),
(93, 'XAdAloMLEXk', '2019-01-10', 'J&#39;SUIS PAS CONTENT ! #204 : Apathie fatigué, Gallinacés déters &amp; Macron excusé ! [Feat. Code Rno]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/XAdAloMLEXk/default.jpg', 0),
(94, '-EfO9IH4aLM', '2019-01-10', 'Les journalistes, chroniqueurs, éditorialistes &amp; animateurs que vous détestez le plus ? ;)', 'LIEN DU SONDAGE : https://www.askabox.fr/repondre.php?s=222199&r=SPZb8HKyz11j.', 'https://i.ytimg.com/vi/-EfO9IH4aLM/default.jpg', 0),
(95, 'rqOmT4srSz8', '2019-01-09', 'Luc Ferry, Boxeur VS Police &amp; Schiappa VS Leetchi ! (Vive la France #20)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/rqOmT4srSz8/default.jpg', 0),
(96, 'Evckv1kuIw0', '2019-01-08', 'Elections européennes, Espoir à gauche &amp; Burundi ! (Vive la France #19)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/Evckv1kuIw0/default.jpg', 0),
(97, 'deAu21jnGGA', '2019-01-07', 'J&#39;SUIS PAS CONTENT ! #203 : Bonne année 2019 avec Macron !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/deAu21jnGGA/default.jpg', 0),
(98, 'BYD3LlzUr0Y', '2018-12-18', '&quot;Hausse&quot; du SMIC, Marseillaise genrée &amp; Berger déconnecté ! (Vive La France #18)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/BYD3LlzUr0Y/default.jpg', 0),
(99, 'UqZMbR4sSzQ', '2018-12-16', 'Strasbourg VS Acte V : concours de récup ! (Vive la France #17)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/UqZMbR4sSzQ/default.jpg', 0),
(100, 'xJrGBxjqACw', '2018-12-13', 'J&#39;SUIS PAS CONTENT ! #202 : En Marche VS GJ : Florilège d&#39;incompétence !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/xJrGBxjqACw/default.jpg', 0),
(101, 'dev07XK4VB4', '2018-12-11', 'Discours de Macron, réaction et analyse (Le OFF #09)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/dev07XK4VB4/default.jpg', 0),
(102, 'TMsOLye--RE', '2018-12-07', 'Wauquiez le kéké, Barbier le héros &amp; Députés dépensiers ! (Vive la France #16)', 'CHEZ GUDULE : 58 Boulevard de Picpus, 75012 Paris · Mon intervention chez RT hier (faite péter les like et les commentaires ...', 'https://i.ytimg.com/vi/TMsOLye--RE/default.jpg', 0),
(103, 'DoLdZbun4vo', '2018-12-05', 'J&#39;SUIS PAS CONTENT ! #201 : Moratoire, Gilets Jaunes &amp; Info de qualitay !', 'POUR LE RDV DU 8 DECEMBRE : Bar \"chez Gudule\", début du concert a 20H ! Adresse : 58 Boulevard de Picpus, 75012 Paris On compte sur votre présence !', 'https://i.ytimg.com/vi/DoLdZbun4vo/default.jpg', 0),
(104, 'VAemgjKeerk', '2018-11-29', 'France Insoumise VS Orcs Islamistes ! (Vive la France #15)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/VAemgjKeerk/default.jpg', 0),
(105, 'EpNxxrgA8ss', '2018-11-27', 'JSPC #200 : Au cœur des Gilets Jaunes ! (Ft. T.Ventôse, JR Lombard, P. Pascot, Soan Le Fil D&#39;actu)', 'Musique du Générique : - Soan \"Mort à ce monde\" : https://www.youtube.com/watch?v=7EmFE45eWvU - Lien de sa page ULLULE pour son prochain album ...', 'https://i.ytimg.com/vi/EpNxxrgA8ss/default.jpg', 0),
(106, 'zx5BQYMk0HU', '2018-11-22', 'J&#39;SUIS PAS CONTENT ! #199 : Espoir à gauche, Mexicain déter &amp; Propagande &quot;à la cool&quot; !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/zx5BQYMk0HU/default.jpg', 0),
(107, 'FUD19t0cl70', '2018-11-21', 'Carlos Ghosn, Fake news à gogo &amp; Macron VS Jeunesse ! (Vive la France ! #14)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/FUD19t0cl70/default.jpg', 0),
(108, 'D_piY78FImw', '2018-11-20', 'J&#39;SUIS PAS CONTENT ! #198 : Gilets Jaunes, petite leçon de manipulation médiatique :)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/D_piY78FImw/default.jpg', 0),
(109, '4Hxjft94tGA', '2018-11-19', 'Gilets Jaunes, en (avant) marche ! (Vive la France ! #13)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/4Hxjft94tGA/default.jpg', 0),
(110, 'B9DB_1zXqfw', '2018-11-18', 'J&#39;SUIS PAS CONTENT ! #197 : Loto volé, Augmentation de l&#39;essence &amp; Ballerines du Progrès !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/B9DB_1zXqfw/default.jpg', 0),
(111, 'DSkCqwqEG1Y', '2018-11-17', 'J&#39;SUIS PAS CONTENT ! #196 : Ventes d&#39;armes, Bolsonaro &amp; Militantisme wiccan !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/DSkCqwqEG1Y/default.jpg', 0),
(112, 'HfZkeM11Jbs', '2018-11-16', 'Du 11 au 17 Novembre, des héros du passés aux couillons du présent ! (Vive la France #12)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/HfZkeM11Jbs/default.jpg', 0),
(113, 'DtyK693AQ9g', '2018-10-31', 'En LIVE avec Frédéric Taddeï ce soir à 19H sur RT !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/DtyK693AQ9g/default.jpg', 0),
(114, 'YE-vHdpyx-E', '2018-10-29', 'Quand une &quot;féministe&quot; met la vie de son enfant en danger - MERCI A TOUS (Le OFF #08)', 'La vidéo de l\'OBS sur Youtube : https://www.youtube.com/watch?time_continue=1&v=40dEig6KldI · La vidéo sur leur site (ils ont une tendance a la mettre en ...', 'https://i.ytimg.com/vi/YE-vHdpyx-E/default.jpg', 0),
(115, '3TxwO7QNnM8', '2018-10-28', 'J&#39;SUIS PAS CONTENT ! #195 : Castaner bizuté, Macron embêté &amp; Benalla piraté !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/3TxwO7QNnM8/default.jpg', 0),
(116, '3_9-L-7B_W0', '2018-10-25', 'J&#39;SUIS PAS CONTENT ! #193 : Pas de vagues, Service pudique &amp; Garrido Guevara !', 'Lien de l\'épisode 194 : https://www.youtube.com/watch?v=MaGX5M41xxc · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/3_9-L-7B_W0/default.jpg', 0),
(117, 'MaGX5M41xxc', '2018-10-25', 'J&#39;SUIS PAS CONTENT ! #194 : Macron épuisé, Castaner deter &amp; Bergé déconnectée ! [Quickie]', 'Lien vers l\'épisode 193 : https://www.youtube.com/watch?v=3_9-L-7B_W0 · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/MaGX5M41xxc/default.jpg', 0),
(118, '_FsZP88YPkU', '2018-10-23', 'J&#39;SUIS PAS CONTENT ! #192 : Macron VS Education, Schiappa in love &amp; Mélenchon le chansonnier !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/_FsZP88YPkU/default.jpg', 0),
(119, 'gyzs8qA7ueM', '2018-10-19', 'POURQUOI Mélenchon a pété un plomb (Le OFF #07)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/gyzs8qA7ueM/default.jpg', 0),
(120, 'ffYqBjmLqWA', '2018-10-18', 'Perquisition chez Mélenchon... vers la réconciliation ? (Vive la France #11)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/ffYqBjmLqWA/default.jpg', 0),
(121, 'isR1EHThzbQ', '2018-10-16', 'J&#39;SUIS PAS CONTENT ! #191 : Le remaniement, c&#39;est maintenant ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/isR1EHThzbQ/default.jpg', 0),
(122, '3XsVSGTCQ0g', '2018-10-15', 'J&#39;SUIS PAS CONTENT ! #190 : Redevance pour tous, Aznavour VS Macron &amp; O&#39;Petit VS Langue française !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/3XsVSGTCQ0g/default.jpg', 0),
(123, 'VrUfxGtp88M', '2018-10-11', 'J&#39;SUIS PAS CONTENT ! #189 : Remaniement, Française des jeux &amp; Canidés révolutionnaires !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/VrUfxGtp88M/default.jpg', 0),
(124, '2bP73EbxJKk', '2018-10-05', 'J&#39;SUIS PAS CONTENT ! #188 : Schiappa dans la place, Gros malaise dans la classe !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/2bP73EbxJKk/default.jpg', 0),
(125, 'rpJTiof-NUw', '2018-10-03', 'J&#39;SUIS PAS CONTENT ! #187 : Collomb démissione, Macron &quot;entre deux&quot; &amp; Benalla VIP ! (Feat. Code-Rno)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · La Chaie de Code-Rno ...', 'https://i.ytimg.com/vi/rpJTiof-NUw/default.jpg', 0),
(126, 'jix3BJ1uq-Q', '2018-09-30', 'J&#39;SUIS PAS CONTENT ! #186 : Nick Conrad, Martine is back &amp; Vraie bonne nouvelle !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/jix3BJ1uq-Q/default.jpg', 0),
(127, 'UUN_j_CCaJ0', '2018-09-29', 'J&#39;SUIS PAS CONTENT ! #185 : Elysée fashion, Travail le dimanche &amp; Valls le lèche-botte ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/UUN_j_CCaJ0/default.jpg', 0),
(128, 'GX4E1n853JI', '2018-09-28', 'Libre antenne #01 : Le gouvernement veut &quot;civiliser&quot; internet ! (avec Tatiana Ventôse)', 'Lien du Formulaire \"Le Système en PLS\" : https://framaforms.org/mettre-le-systeme-en-pls-1537377194 ATTENTION : si vous résidez à l\'étranger, il y a un bug ...', 'https://i.ytimg.com/vi/GX4E1n853JI/default.jpg', 0),
(129, 'oqAdjfP-noE', '2018-09-27', 'J&#39;SUIS PAS CONTENT ! #184 : Hapsatou Sy VS Zemmour, Spiderman VS Islam &amp; Benalla VS Mythos !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/oqAdjfP-noE/default.jpg', 0),
(130, 'rvb57FlOJTc', '2018-09-25', 'J&#39;SUIS PAS CONTENT ! #183 : Internet &quot;en marche&quot;, Le Pen à l&#39;asile &amp; Lunettes du progrès !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/rvb57FlOJTc/default.jpg', 0),
(131, 'YmwtWF7NEoo', '2018-09-23', 'J&#39;ai récupéré notre  chaîne ! (ça tourne bien) EXPLICATIONS &amp; ANNONCES', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...', 'https://i.ytimg.com/vi/YmwtWF7NEoo/default.jpg', 0),
(132, 'HousWX3KwG8', '2018-09-22', 'ON A PIRATÉE LA CHAINE  (ça tourne mal) MESSAGE TRÈS IMPORTANT !!!', 'LIEN VERS LA CHAÎNE DE SECOURS : https://www.youtube.com/channel/UC9QvVwHqRLpQF0TXsTQSWhg · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/HousWX3KwG8/default.jpg', 0),
(133, 'skJAV2ryoYM', '2018-09-19', 'J&#39;SUIS PAS CONTENT ! #182 : Traverse la rue pour du taff &amp; Bruno Lemaire est une tache !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/skJAV2ryoYM/default.jpg', 0),
(134, 'o3jVV-uSIkg', '2018-09-13', 'J&#39;SUIS PAS CONTENT ! #181 : FERRAND président, WAUQUIEZ est chaud &amp; ARISTOTE en marche !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/o3jVV-uSIkg/default.jpg', 0),
(135, 'rjVB6D1xRUI', '2018-09-12', 'J&#39;SUIS PAS CONTENT ! #180 : Mélenchon humilié, Gégé fatigué &amp; Bergé ramassée...', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/rjVB6D1xRUI/default.jpg', 0),
(136, 'ekRHx38lV6s', '2018-09-08', 'TOP 10 des politiciens que vous détestez le plus ! [Feat. Tatiana Ventôse] (ISVG #01)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/ekRHx38lV6s/default.jpg', 0),
(137, 'DDVHszfL3JI', '2018-09-06', 'J&#39;SUIS PAS CONTENT ! #179 :  De Rugy ministre, Darmanin persiste &amp; Assemblée Kawai !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/DDVHszfL3JI/default.jpg', 0),
(138, 'Mbo8QEFWmpo', '2018-09-05', 'J&#39;SUIS PAS CONTENT ! #178 : Trump VS Migrants, Les Experts 2.0 &amp; Cartes postales du progrès !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/Mbo8QEFWmpo/default.jpg', 0),
(139, '-0935gWxUhM', '2018-09-04', 'J&#39;SUIS PAS CONTENT ! #177 : Hulot démissione, Darmanin mitone et Dragon Ball déconne !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/-0935gWxUhM/default.jpg', 0),
(140, 'QiOghEKtf5g', '2018-08-13', 'J&#39;SUIS PAS CONTENT ! #176 : Hollande 2022, Tata Christiane is back &amp; Kaaris VS Booba !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/QiOghEKtf5g/default.jpg', 0),
(141, 'BjSYtptmZeg', '2018-08-12', 'J&#39;SUIS PAS CONTENT ! #175 :  Faux Compte à Schiappa, Monde qui change &amp; Macron humaniste !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/BjSYtptmZeg/default.jpg', 0),
(142, 'i4uDa5Sno4M', '2018-08-11', 'La Loi SCHIAPPA légalise t-elle la pédophilie ? (LE OFF #06)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/i4uDa5Sno4M/default.jpg', 0),
(143, 'YkfHmqX53xM', '2018-07-30', 'J&#39;SUIS PAS CONTENT ! #174 : Benalla, ça n&#39;est que le début d&#39;accord d&#39;accord. ???? (+ptit kdo du 18-25)', 'Lien vers le PDF réalisé par le 18-25 : https://drive.google.com/file/d/1r2l3_LvhfNDrJxMClBU_qFTO1GzCaGV2/view · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/YkfHmqX53xM/default.jpg', 0),
(144, 'RsD3vbvFH2Q', '2018-07-27', 'J&#39;SUIS PAS CONTENT ! #173 : Benalla, et ça continue encore et encore... ????', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/RsD3vbvFH2Q/default.jpg', 0),
(145, 'xYUxtg0LNik', '2018-07-25', 'J&#39;SUIS PAS CONTENT ! #171 : Affaire Benalla, Macron dans le caca !', 'Lien de l\'épisode 172 [qui complète cet épisode] : https://www.youtube.com/watch?v=wW5JfttZXJM · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/xYUxtg0LNik/default.jpg', 0),
(146, 'wW5JfttZXJM', '2018-07-25', 'J&#39;SUIS PAS CONTENT ! #172 : Qu&#39;ils viennent me chercher ! (chiche ?) Quand SCHIAPPA défend MACRON...', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/wW5JfttZXJM/default.jpg', 0),
(147, 'q3Qxjwh4uMs', '2018-07-21', 'TOP 5 des plus grosses récup&#39; (de gauche) de la victoires des Bleus VS Decodex (JSPC Hors-Série #04)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/q3Qxjwh4uMs/default.jpg', 0),
(148, 'BVumO7Lm9Xo', '2018-07-18', 'J&#39;SUIS PAS CONTENT ! #170 : Combine à Macron, Supermarchés délaissés &amp; Grossophobie !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/BVumO7Lm9Xo/default.jpg', 0),
(149, 'Gjs2mrqWpTA', '2018-07-17', 'J&#39;SUIS PAS CONTENT ! #169 : Schiappa VS Juncker, concours de PLS !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/Gjs2mrqWpTA/default.jpg', 0);
INSERT INTO `video` (`id`, `videoId`, `publishedAt`, `title`, `description`, `thumbnails`, `checked`) VALUES
(150, 'pK6enjD1OkM', '2018-07-16', 'J&#39;SUIS PAS CONTENT ! #168 : La COUPE du MONDE est FINIE ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/pK6enjD1OkM/default.jpg', 0),
(151, 'pWeEZtMsKeU', '2018-07-05', 'J&#39;SUIS PAS CONTENT ! #167 : MINISTRE VS HELICO &amp; PROGRES VS PATRIMOINE ! [Feat. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/pWeEZtMsKeU/default.jpg', 0),
(152, 'KRp8XQ4sXns', '2018-07-04', 'J&#39;SUIS PAS CONTENT ! #166 : Pause Caca au Vatican ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/KRp8XQ4sXns/default.jpg', 0),
(153, 'ozlb7w38DgQ', '2018-07-03', 'JSPC 165 : Schiappa VS Vandamme &amp; Simone Veil VS La mort [lien vers l&#39;épisode sous cette vidéo]', 'LIEN DE L\'EPISODE SUR DAILYMOTION : https://www.dailymotion.com/video/x6nhh2w Si certains n\'arrivent pas a la voir sur Dailymotion, essayez de virer ...', 'https://i.ytimg.com/vi/ozlb7w38DgQ/default.jpg', 0),
(154, 'oeTM4iBLMCM', '2018-06-26', 'J&#39;SUIS PAS CONTENT ! #164 : Les Guignols de l&#39;Info s&#39;arrêtent, Nadine continue ! [Quickie]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/oeTM4iBLMCM/default.jpg', 0),
(155, 'Pupp-CK9fK8', '2018-06-25', 'J&#39;SUIS PAS CONTENT ! #163 : Troll de 13 ans, Fête de la musique &amp; Chocolatines pour tous !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/Pupp-CK9fK8/default.jpg', 0),
(156, '2kwXXMJ5ROU', '2018-06-20', 'UNBOXING Trophée 100k abonnés !!! (ça tourne mal) ? ? ?', 'MERCI à vous. MERCI à nous. MERCI aux Spectateurs. MERCI aux Tipeurs. MERCI aux Détracteurs. MERCI aux Monteurs. Bref, MERCI, du fond du coeur.', 'https://i.ytimg.com/vi/2kwXXMJ5ROU/default.jpg', 0),
(157, 'IRzfl-n6ZKg', '2018-06-19', 'J&#39;SUIS PAS CONTENT ! #162 : Pognon de dingue, RSA caca &amp; Grèves Ultra Instinct !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/IRzfl-n6ZKg/default.jpg', 0),
(158, 'DvL_0OYwDag', '2018-06-14', 'MEDINE AU BATACLAN ? Ou pas. (LE OFF #05)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/DvL_0OYwDag/default.jpg', 0),
(159, 'ScRA41hE7Jw', '2018-06-04', 'J&#39;SUIS PAS CONTENT ! #160 : MACRON VS POUTINE, ELECTIONS ITALIENNES &amp; AUTOCRITIQUES DIFFICILES !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/ScRA41hE7Jw/default.jpg', 0),
(160, 'ioAzEliLmQQ', '2018-06-01', 'J&#39;SUIS PAS CONTENT ! #159 : MAMOUDOU LE HEROS ET FAKE NEWS A GOGO !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/ioAzEliLmQQ/default.jpg', 0),
(161, 'MCRYn1Uoc0A', '2018-05-31', 'Message TRES IMPORTANT : cette chaine risque de FERMER. Lien vers une chaine de secours', 'LIEN VERS LA CHAÎNE DE SECOURS : https://www.youtube.com/channel/UC9QvVwHqRLpQF0TXsTQSWhg · Pour ceux qui veulent lire les nouvelles CGU ...', 'https://i.ytimg.com/vi/MCRYn1Uoc0A/default.jpg', 0),
(162, '7ZHY4CHG7VE', '2018-05-28', 'J&#39;SUIS PAS CONTENT ! #158 : Macron en BANLIEUE &amp; Collomb le GÂTEUX !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/7ZHY4CHG7VE/default.jpg', 0),
(163, '5S0giRYUOT4', '2018-05-23', 'J&#39;SUIS PAS CONTENT ! #157 : SNCF en grève, Quenelles au Cannabis &amp; Corruption des Elus !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/5S0giRYUOT4/default.jpg', 0),
(164, 'r6Y2czfcTUc', '2018-05-21', 'J&#39;SUIS PAS CONTENT ! #156 :  Urbanisme inclusif, Combine à Collomb &amp; Journalisme engagé !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/r6Y2czfcTUc/default.jpg', 0),
(165, 'ZaTvpB46HiY', '2018-05-19', 'J&#39;SUIS PAS CONTENT ! #155 : Tuto pour pécho, Fuite des cerveaux &amp; Barbie extrème !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/ZaTvpB46HiY/default.jpg', 0),
(166, 'SXxIJ5dzqLg', '2018-05-17', 'J&#39;SUIS PAS CONTENT ! #154 : Fin du monde, Eurovision &amp; Warhammer israelien !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/SXxIJ5dzqLg/default.jpg', 0),
(167, 'UwHG9nwoaTs', '2018-05-15', 'J&#39;SUIS PAS CONTENT ! #153 : Examens annulés, Coquerel gazé &amp; Echarpe magique !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux sociaux : · D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/UwHG9nwoaTs/default.jpg', 0),
(168, 'KJGYsLg85J4', '2018-05-14', 'J&#39;SUIS PAS CONTENT ! #152 : Macron l&#39;illuminé est de retour ! [Quickie ????]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux sociaux : · D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/KJGYsLg85J4/default.jpg', 0),
(169, 'w5GUDOmMe_k', '2018-05-10', 'J&#39;SUIS PAS CONTENT ! (Hors-Série #03) : L&#39;appropriation culturelle, un pouvoir bien naze !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux sociaux : · D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/w5GUDOmMe_k/default.jpg', 0),
(170, 'Kg39Py1akIY', '2018-05-08', 'J&#39;SUIS PAS CONTENT ! #151 : Fête à Macron, Quenelle BETA &amp; Complots Facebookiens !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux sociaux : · D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/Kg39Py1akIY/default.jpg', 0),
(171, 'Xbr_EQ20KPU', '2018-05-05', 'J&#39;SUIS PAS CONTENT ! #149 &amp; #150 : épisodes dans la description ! ????', 'L\'EPISODE 149 : https://www.youtube.com/watch?v=T5eYnAx3IWg L\'EPISODE 150 : https://www.youtube.com/watch?v=bz0T2eHZtVE Précision : l\'épisode 150 ...', 'https://i.ytimg.com/vi/Xbr_EQ20KPU/default.jpg', 0),
(172, 'bz0T2eHZtVE', '2018-05-05', 'J&#39;SUIS PAS CONTENT ! #150 : Mélenchon, la précieuse ridicule (mise en scène Clémentine Autain)', 'L\'EPISODE 149 : https://www.youtube.com/watch?v=T5eYnAx3IWg · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux ...', 'https://i.ytimg.com/vi/bz0T2eHZtVE/default.jpg', 0),
(173, 'T5eYnAx3IWg', '2018-05-05', 'J&#39;SUIS PAS CONTENT ! #149 : Tolbiac évacuée, Manuel Valls largué &amp; Prénom interchangé !', 'L\'EPISODE 150 : https://www.youtube.com/watch?v=bz0T2eHZtVE · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Réseaux ...', 'https://i.ytimg.com/vi/T5eYnAx3IWg/default.jpg', 0),
(174, 'JW3aQoDdyyU', '2018-04-21', 'J&#39;SUIS PAS CONTENT ! #147 : Macron VS les Rangers du Risque &amp; Christophe Barbier VS Malaise(s) !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/JW3aQoDdyyU/default.jpg', 0),
(175, 'q1uI9SlpuV4', '2018-04-19', 'VIVE LA FRANCE ! : Telford, l&#39;humiliation ultime du journalisme français [Hors-Série #01]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/q1uI9SlpuV4/default.jpg', 0),
(176, 'a2P3sjqGpwY', '2018-04-17', 'VIVE LA FRANCE ! #10 : Racisme ordinaire, Mauvaises blagues en série &amp; Macron VS hôpitaux !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/a2P3sjqGpwY/default.jpg', 0),
(177, '1qemW3hFD3E', '2018-04-16', 'VIVE LA FRANCE ! #09 : Macron VS Syrie, S.J.W. VS Bonjour &amp; Parti Socialiste VS Grosse lose !!!', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/1qemW3hFD3E/default.jpg', 0),
(178, 'SGL3YDAmtIk', '2018-04-11', 'J&#39;SUIS PAS CONTENT ! #146 : JV Placé bourré, Sarkozy embêté &amp; Université sélectionnée !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/SGL3YDAmtIk/default.jpg', 0),
(179, '7g2e9cKUAfs', '2018-04-03', 'J&#39;SUIS PAS CONTENT ! #145 - Soralite aiguë, Pognon en masse &amp; Darmanin le sagouin !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/7g2e9cKUAfs/default.jpg', 0),
(180, '4z-Z3NqIbYM', '2018-04-02', 'J&#39;SUIS PAS CONTENT ! #144 : Poisson d&#39;Avril, Stephen Hawking &amp; Arnaud Beltrame', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/4z-Z3NqIbYM/default.jpg', 0),
(181, 'JR6NmYTSWmc', '2018-03-23', 'VIVE LA FRANCE ! #08 : Puces RFID, Cd AOL &amp; Concours de Point Godwin !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/JR6NmYTSWmc/default.jpg', 0),
(182, 'qqjtLkRc4NM', '2018-03-22', 'Réunion en non-mixité &quot;ethnique&quot; : un racisme qui ne dit pas son nom ? [Le OFF #04]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/qqjtLkRc4NM/default.jpg', 0),
(183, 'eHjwI0pQ-3I', '2018-03-19', 'J&#39;SUIS PAS CONTENT ! #143 : Hidalgo dans les fesses &amp; Ségolène dans l&#39;espace !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/eHjwI0pQ-3I/default.jpg', 0),
(184, 'I2f5dEmrH38', '2018-03-16', 'VIVE LA FRANCE ! #07 : Soutien au cheminots &amp; Chocolats féministes !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/I2f5dEmrH38/default.jpg', 0),
(185, 'vke-cWO1peU', '2018-03-13', 'J&#39;SUIS PAS CONTENT !  #142 : Le FN change de nom, Macron change de job !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/vke-cWO1peU/default.jpg', 0),
(186, '6hWS5ZjrM30', '2018-03-07', 'Annonce importante ! A lundi prochain !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Chanson de fin par Eddy Pero et Greg Tabibian.', 'https://i.ytimg.com/vi/6hWS5ZjrM30/default.jpg', 0),
(187, 'AFjd6tHpLUY', '2018-03-02', 'Laura Laune, Dieudonné, Usul, Copy Comics : qui veut la peau des humoristes ? [Le OFF #03]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/AFjd6tHpLUY/default.jpg', 0),
(188, 'oPreyPndVXE', '2018-02-28', 'J&#39;SUIS PAS CONTENT ! #141 : SNCF, Agriculteurs &amp; Macron VS La poulette !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/oPreyPndVXE/default.jpg', 0),
(189, 'r5k7NU_4Mdw', '2018-02-26', 'J&#39;SUIS PAS CONTENT ! #140 : Darmanin  VS KAMOULOX &amp; Wauquiez VS SMARTPHONES !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/r5k7NU_4Mdw/default.jpg', 0),
(190, 'n7FhePnDMDM', '2018-02-24', 'J&#39;SUIS PAS CONTENT ! (Hors-Série #02) : Rokaya dit du caca !', 'LIEN DE L\'EPISODE SUR DAILYMOTION : https://www.dailymotion.com/video/x6f8nwj · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/n7FhePnDMDM/default.jpg', 0),
(191, 'LP0FV3etOYU', '2018-02-21', 'VIVE LA FRANCE ! #06 : Orelsan VS Gilles Verdez &amp; Macron VS Nature !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/LP0FV3etOYU/default.jpg', 0),
(192, 'Nc4-r97tTqU', '2018-02-20', 'J&#39;SUIS PAS CONTENT ! #139 : Dieudonné le tricheur, Valls le sauveur &amp; Volkswagen les menteurs !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/Nc4-r97tTqU/default.jpg', 0),
(193, 'bZugb41t6H4', '2018-02-19', 'VIVE LA FRANCE ! #05 : Réponse &quot;d&#39;artiste&quot; à Christine ANGOT (et Caroline de HAAS)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/bZugb41t6H4/default.jpg', 0),
(194, '_RZA_d4Dvsg', '2018-02-18', 'JAWAD relaxé : réaction et avis [Le OFF de JSPC #02]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/_RZA_d4Dvsg/default.jpg', 0),
(195, 'ctWNC18r9WM', '2018-02-16', 'J&#39;SUIS PAS CONTENT ! #138 : Yemen, Morano &amp; Nuit de la Solidarité !', 'SUITE A UNE LIMITE D\'AGE -18 IMPOSEE PAR YOUTUBE, CERTAINS D\'ENTRE VOUS POURRONS SE VOIR INTERDIT L\'ACCES A L\'EPISODE.', 'https://i.ytimg.com/vi/ctWNC18r9WM/default.jpg', 0),
(196, 'BX-6dpOjBQ4', '2018-02-14', 'TUTO : Comment fabriquer 200 fachos en 2 heures !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/BX-6dpOjBQ4/default.jpg', 0),
(197, 'WbLgUypBCB8', '2018-02-13', 'MENNEL IBTISSEM : (tentative) d&#39;explication d&#39;un fiasco complet [Le OFF de JSPC #01]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/WbLgUypBCB8/default.jpg', 0),
(198, 'hVmSgTPHIm4', '2018-02-12', 'J&#39;SUIS PAS CONTENT ! #137 : Matérialisme, Tian au caca &amp; Christophe Colomb !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/hVmSgTPHIm4/default.jpg', 0),
(199, 'L0aB_P0nFnk', '2018-02-10', 'ON FAIT QUOI ? #01 : Comment les riches ont pris le pouvoir (avec Etienne Chouard)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/L0aB_P0nFnk/default.jpg', 0),
(200, 'thUu2RDaOqc', '2018-02-09', 'J&#39;SUIS PAS CONTENT ! #136 : Neige à Paris, Soeur Emmanuelle &amp; Banque de France ! [Ft. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/thUu2RDaOqc/default.jpg', 0),
(201, 'LZJ5ZdU_eAc', '2018-02-06', 'J&#39;SUIS PAS CONTENT ! #135 : Hypocrisie macronnienne,  Victor Hugo &amp; Ministre exemplaire ! [Ft. JR]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/LZJ5ZdU_eAc/default.jpg', 0),
(202, 'BrqzTa1T27M', '2018-02-05', 'J&#39;SUIS PAS CONTENT ! #134 : Macron en Tunisie et Jumanji à Paris !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/BrqzTa1T27M/default.jpg', 0),
(203, 'tsW2iJ_YVRI', '2018-02-02', 'Pourquoi il faut INTERDIRE le Jeu de Rôle (les aventures de Jean-Progrès #01) [feat Jaïs]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/tsW2iJ_YVRI/default.jpg', 0),
(204, 'rNgwL9lXM8g', '2018-02-01', 'ISVG #00 : Je vais vous donner envie de voter !', 'NOTES IMPORTANTES : J\'ai modifié le sondage pour que vous puissiez indiquer TROIS noms. Cela évitera les réponses trop similaires et donnera un peu d\'air ...', 'https://i.ytimg.com/vi/rNgwL9lXM8g/default.jpg', 0),
(205, 'bfpsMPtFzbs', '2018-01-31', 'J&#39;SUIS PAS CONTENT ! #133 : Zadistes dehors, Gégé le plus fort &amp; impôts pour tous !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/bfpsMPtFzbs/default.jpg', 0),
(206, 'HYn-j04cOB4', '2018-01-30', 'FDP #02 : Peno Tube (Format D&#39;utilité Publique)', 'LIEN DE LA CHAINE DE PENO : https://www.youtube.com/channel/UClaZ2KITbEWBjaUSELMwzvg · LE TWITTER DE PENO ...', 'https://i.ytimg.com/vi/HYn-j04cOB4/default.jpg', 0),
(207, '9YpvzpckT_4', '2018-01-29', 'J&#39;SUIS PAS CONTENT ! #132 :   80 km/h sur les routes &amp; contrôleurs cailleras hippies !', 'Retrouve-nous sur : · D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS · Pour me ...', 'https://i.ytimg.com/vi/9YpvzpckT_4/default.jpg', 0),
(208, 'GTQ7tf7O2CI', '2018-01-25', 'J&#39;SUIS PAS CONTENT ! #131 : Nabilla Eco+, Pays de &quot;m....&quot; &amp; Demolition Man !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/GTQ7tf7O2CI/default.jpg', 0),
(209, 'n8cMshH95hM', '2018-01-22', 'J&#39;SUIS PAS CONTENT ! #130 : Ouverture officielle de la Chasse aux Fake News !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/n8cMshH95hM/default.jpg', 0),
(210, 'f-uOQLCK9BU', '2018-01-10', 'J&#39;SUIS PAS CONTENT !  #128 : MACRON-BOUDDHA &amp; la Sainte Trinité EN MARCHE !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/f-uOQLCK9BU/default.jpg', 0),
(211, 'OHYtKvQqbOs', '2018-01-02', 'J&#39;SUIS PAS CONTENT ! #127 : Bonne année EN MARCHE !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/OHYtKvQqbOs/default.jpg', 0),
(212, 'IeCMFlLTEUM', '2017-12-31', 'J&#39;SUIS PAS CONTENT ! (Hors-Série #01) : Est-ce que je suis de GAUCHE ou de DROITE ?', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/IeCMFlLTEUM/default.jpg', 0),
(213, '43zZPrqvAkI', '2017-12-20', 'J&#39;SUIS PAS CONTENT ! #126 : Lutte contre le Porno, Tex &amp; Comm&#39; de Schlag !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/43zZPrqvAkI/default.jpg', 0),
(214, 'A7pTtBbiFss', '2017-12-19', 'FDP #01 : Le Docteur Alwest ! (Format D&#39;utilité Publique)', 'LA CHAINE DU DR ALWEST : https://www.youtube.com/channel/UCAgUV11t0UuSn0BOF0BlZ3w · LA PAGE FACEBOOK DU DR ALWEST ...', 'https://i.ytimg.com/vi/A7pTtBbiFss/default.jpg', 0),
(215, 'iLNQ-x1fSZE', '2017-12-19', 'J&#39;SUIS PAS CONTENT ! 125 : Valls le tricheur, Gel du SMIC &amp; humour Hollandais !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/iLNQ-x1fSZE/default.jpg', 0),
(216, 'm_QxI34BU8A', '2017-12-18', 'J&#39;SUIS PAS CONTENT ! #124 : Johnny est parti &amp; Macron en Algérie !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/m_QxI34BU8A/default.jpg', 0),
(217, 'rkHcoXT4owE', '2017-12-16', 'J&#39;SUIS PAS CONTENT ! #123 : Black Friday, Brigitte le Panda &amp; Bilderberg !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/rkHcoXT4owE/default.jpg', 0),
(218, 'iS9JopBmtY8', '2017-12-15', '100k abonnés !!! : l&#39;avenir de cette chaine !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/iS9JopBmtY8/default.jpg', 0),
(219, '6EFwqx_nh68', '2017-12-14', 'J&#39;SUIS PAS CONTENT ! #122 : Chasse aux SDF, Paradis Fiscaux et Joyeux Noel !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/6EFwqx_nh68/default.jpg', 0),
(220, 'PcaZOZzQbNY', '2017-12-01', 'J&#39;SUIS PAS CONTENT ! #121 : Mini Remaniement, Marlène Schiappa &amp; Pochaontas !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/PcaZOZzQbNY/default.jpg', 0),
(221, 'D0WD6Vkrao8', '2017-11-29', 'J&#39;SUIS PAS CONTENT ! #120 : Mon patron pète un plomb, Féminisme Hallal &amp; Macron au Burkina Faso !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/D0WD6Vkrao8/default.jpg', 0),
(222, '9EwuNd-zQ3s', '2017-11-28', 'J&#39;SUIS PAS CONTENT ! #119 : Nicolas HULOT le MYTHO &amp; Mégots pour les Corbeaux !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/9EwuNd-zQ3s/default.jpg', 0),
(223, '7YSY_1Vo0cY', '2017-11-23', 'J&#39;SUIS PAS CONTENT ! #118 : JE SUIS MINIKEUMS... [Squeezie VS Ardisson &amp; Filoche en PLS]', 'L\'EPISODE SUR DAILYMOTION : http://www.dailymotion.com/video/x6af007 · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/7YSY_1Vo0cY/default.jpg', 0),
(224, 'XLSVj1RKvmM', '2017-11-21', 'J&#39;SUIS PAS CONTENT ! #117 : Députés au MacDo, Cthulhu fhtagn &amp; Caca Boudin ! [Feat. JRLombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/XLSVj1RKvmM/default.jpg', 0),
(225, 'G-GFk6rsl8Q', '2017-11-20', 'J&#39;SUIS PAS CONTENT ! #116 : W. is Back, Valls qui chouine &amp; Drapeau européen !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/G-GFk6rsl8Q/default.jpg', 0),
(226, 'mu9zucdE270', '2017-11-18', 'J&#39;SUIS PAS CONTENT ! #115 : Harvey Weinstein, Tarik Ramadan &amp; Mr Caca !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/mu9zucdE270/default.jpg', 0),
(227, 'k5F66eD-B10', '2017-11-17', 'J&#39;SUIS PAS CONTENT ! #114 : Trump VS Asie, Vodka Frelatée et WW3 ! [Feat. JR. Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/k5F66eD-B10/default.jpg', 0),
(228, 'sM35pHqwOAg', '2017-11-15', 'TELE D&#39;AVANT ! #06 : Les humoristes sont-ils censurés en France ? (avec F. Rollin, Merri, R.Cheylan)', 'La Version Longue sur Dailymotion : https://goo.gl/B4fhYq · Pour voir les parties manquantes et les sketchs mentionnées dans la vidéo (regroupées en un lien ...', 'https://i.ytimg.com/vi/sM35pHqwOAg/default.jpg', 0),
(229, 'PTqLlUj5mHw', '2017-11-09', 'J&#39;SUIS PAS CONTENT ! #113 [Ft. Superflame] : Protection animale, Dieudonné &amp; Déliquant financier !', 'LA CHAINE DE SUPERFLAME, probablement le meilleur imitateur de tout le Youtube Game : https://www.youtube.com/watch?v=_fhYveH-BPY · Pour me ...', 'https://i.ytimg.com/vi/PTqLlUj5mHw/default.jpg', 0),
(230, '4NzTbvZraEk', '2017-11-07', 'TELE D&#39;AVANT ! #05 : Présentation des invités : F. Rollin, R.Cheylan &amp; Merri (version courte)', 'Version Longue sur Dailymotion : http://www.dailymotion.com/video/x684m3g · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/4NzTbvZraEk/default.jpg', 0),
(231, 'decbh5ItdUs', '2017-11-07', 'TELE D&#39;AVANT ! #05 : Présentation des invités ! [avec François Rollin, Romain Cheylan &amp; Merri]', 'Version Longue sur Dailymotion : http://www.dailymotion.com/video/x684m3g · Version Courte sur Youtube : https://www.youtube.com/watch?v=4NzTbvZraEk ...', 'https://i.ytimg.com/vi/decbh5ItdUs/default.jpg', 0),
(232, 'nZJxX7Byzdw', '2017-11-01', 'J&#39;SUIS PAS CONTENT ! #112 : Petits Dormeurs, Dame Caca &amp; Rescapés du Titanic ! [Ft. JR Lombard]', 'L\'épisode sur DAILYMOTION : http://www.dailymotion.com/video/x678epy · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/nZJxX7Byzdw/default.jpg', 0),
(233, '4kdwDNFdy1U', '2017-10-30', 'J&#39;SUIS PAS CONTENT ! #111 : Père noël, Suce pension &amp; Démonettes de Slaneesh ! [Feat. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/4kdwDNFdy1U/default.jpg', 0),
(234, 'qeyolT37prY', '2017-10-28', 'VIVE LA FRANCE ! #04 : Jacques Attali, Nabilla et René Girard sont dans un bateau', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/qeyolT37prY/default.jpg', 0),
(235, 'zfByJCiFlA8', '2017-10-24', 'J&#39;SUIS PAS CONTENT ! #110 : VALLS VS MELENCHON, SURVEILLANCE POUR TOUS &amp; TROLL DE L&#39;AFP !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/zfByJCiFlA8/default.jpg', 0),
(236, 'qImSq6dtCwU', '2017-10-17', 'J&#39;SUIS PAS CONTENT ! #109 : Francophonie, Morale politique &amp; Retour de Mimolette !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/qImSq6dtCwU/default.jpg', 0),
(237, 'SHhHXCoEbWk', '2017-10-16', 'VIVE LA FRANCE ! #03 : Au boulot bande de FAINEANTS !!!', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/SHhHXCoEbWk/default.jpg', 0),
(238, 'TMHxXQGl-2k', '2017-10-14', 'J&#39;SUIS PAS CONTENT ! #108 : Trump VS Corée &amp; Révolution jupitérienne !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/TMHxXQGl-2k/default.jpg', 0),
(239, 'AxhVq2MZz7g', '2017-10-04', 'J&#39;SUIS PAS CONTENT ! #107 : PMA, Harcèlement(s) de rue &amp; Gégé le boulet !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : D I S C O R D : https://discord.gg/R5J9f27 • T W I T T E R ...', 'https://i.ytimg.com/vi/AxhVq2MZz7g/default.jpg', 0),
(240, 'ALOPyG0hW0c', '2017-10-02', 'VIVE LA FRANCE ! #02 : 2 fois plus de caractères sur Twitter, 2 fois moins de démocratie en France !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/ALOPyG0hW0c/default.jpg', 0),
(241, 'Y9JxkYYA4D0', '2017-10-01', 'VIVE LA FRANCE ! #01 : Ecologie macronnienne &amp; Poésie française', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/VYDpV5R • T W I T T E R ...', 'https://i.ytimg.com/vi/Y9JxkYYA4D0/default.jpg', 0),
(242, '2lnAU6hP7XU', '2017-09-29', 'J&#39;SUIS PAS CONTENT ! #106 : JE SUIS... FAINEANT !', 'Lien de l\'épisode sur Dailymotion : http://www.dailymotion.com/video/x62hyzp · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content ...', 'https://i.ytimg.com/vi/2lnAU6hP7XU/default.jpg', 0),
(243, 'AgcgRgKwbUg', '2017-09-14', 'J&#39;SUIS PAS CONTENT ! #105 : Philippot bashing, Trump VS Corée &amp; Magouilles macronienne !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/AgcgRgKwbUg/default.jpg', 0),
(244, 'Ip89WaShXnE', '2017-09-05', 'J&#39;SUIS PAS CONTENT ! #104 : JE SUIS YORITSUME :) (Merci O&#39;Petit !)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/Ip89WaShXnE/default.jpg', 0),
(245, 'XGEyDftKGpI', '2017-08-01', 'J&#39;SUIS PAS CONTENT ! #103 : Mimolette de retour, Najat la voyante &amp; Café facho !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/XGEyDftKGpI/default.jpg', 0),
(246, 'yHtl2fQLtXM', '2017-07-27', 'J&#39;SUIS PAS CONTENT ! #102 : Cuisson des frites, Homo sapiens sapiens sapiens sapiens &amp; Progrès 3.0 !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/yHtl2fQLtXM/default.jpg', 0),
(247, 'Ij75ikYK8M8', '2017-07-24', 'J&#39;SUIS PAS CONTENT ! #101 : Général de Villiers, épisode censuré ?', 'LIEN DE L\'EPISODE SUR DAILYMOTION VIA MON SITE : http://gregtabibian.com/video-jsuis-pas-content-101-general-de-villiers-macroneries-sf-journalistique/ ...', 'https://i.ytimg.com/vi/Ij75ikYK8M8/default.jpg', 0),
(248, 'tY9LF0kVoqQ', '2017-07-21', 'J&#39;SUIS PAS CONTENT ! #100 : Extra-Terrestres pro-Poutine, Mélenchon la victime &amp; Macron le KimJong !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/tY9LF0kVoqQ/default.jpg', 0),
(249, 'nRoWHtJSNhI', '2017-07-19', 'J&#39;SUIS PAS CONTENT ! #99 : RATP version GAME OF THRONES &amp; Macron en mode LE PEN !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/nRoWHtJSNhI/default.jpg', 0),
(250, '5TE0Z2OY3nI', '2017-07-18', 'J&#39;SUIS PAS CONTENT ! #98 : CDI dans ton cul, Valls collabo &amp; Mélenchon sans cravate !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/5TE0Z2OY3nI/default.jpg', 0),
(251, 'TDeR8213chM', '2017-07-14', 'J&#39;SUIS PAS CONTENT ! #97 : Trump au 14 Juillet &amp; Manuel Valls au piquet !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/TDeR8213chM/default.jpg', 0),
(252, '_KoCQ7wwJnE', '2017-07-13', 'J&#39;SUIS PAS CONTENT ! #96 : Manspreading, Photo pourrie &amp; Cannibalisme en marche ! [feat. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/_KoCQ7wwJnE/default.jpg', 0),
(253, 'v5A0dM0xyto', '2017-07-01', 'J&#39;SUIS PAS CONTENT ! #95 : Américains dans l&#39;espace &amp; En Marche vers Uranus !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux :T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/v5A0dM0xyto/default.jpg', 0),
(254, 'jNnehkuOOD4', '2017-06-30', 'J&#39;SUIS PAS CONTENT ! #94 : Jeux Olympiques, Racisme de &quot;gauche&quot; &amp; Ségolène qui fait de la peine !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux :T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/jNnehkuOOD4/default.jpg', 0),
(255, 'BaTMj1dFodo', '2017-06-23', 'J&#39;SUIS PAS CONTENT ! #92 :  Big Data, Bayrou en &quot;off&quot; &amp; Robots sexuels ! [feat. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/BaTMj1dFodo/default.jpg', 0),
(256, '4T3k6b2Y9Og', '2017-06-22', 'J&#39;SUIS PAS CONTENT ! #91 [Quickie] : NKM agressée, Féministes cosplayées &amp; Philippot survolté !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/4T3k6b2Y9Og/default.jpg', 0),
(257, 'S1_LOpP4nSE', '2017-06-21', 'J&#39;SUIS PAS CONTENT ! #90 : Victoire de Valls, Préfets fantômes &amp; Députée teubée ! [feat. JR Lombard]', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/S1_LOpP4nSE/default.jpg', 0),
(258, 'W_U4VS16AXE', '2017-06-18', 'J&#39;SUIS PAS CONTENT ! #89 [Quickie] : Manuel Valls en PLS à Evry ? (dernier hommage)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/W_U4VS16AXE/default.jpg', 0),
(259, '7BUdi4ey72I', '2017-06-17', 'J&#39;SUIS PAS CONTENT ! #88 : Retraités arnaqués, Armée Ork &amp; Sextoys socialistes !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/7BUdi4ey72I/default.jpg', 0),
(260, 'K8UKXbeI6qE', '2017-06-14', 'J&#39;SUIS PAS CONTENT ! #87 : Ramadan, Hanouna, Transhumanisme &amp; Mégaman II (monde de m****)', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/K8UKXbeI6qE/default.jpg', 0),
(261, 'xJ5gqcCHcIY', '2017-06-13', 'J&#39;SUIS PAS CONTENT ! #86 : Législatives bien soumises, Guaino bien rageux &amp; Métaphores aquatiques !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/xJ5gqcCHcIY/default.jpg', 0),
(262, 'mRjmb5-M3gY', '2017-06-11', 'TELE D&#39;AVANT ! #04 : Progrès et urbanisme... (Teaser deuxième émission !)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • • D I S C O R D : https://discord.gg/RaksmAn · Pour me ...', 'https://i.ytimg.com/vi/mRjmb5-M3gY/default.jpg', 0),
(263, 'T5sxN5MEtzE', '2017-06-08', 'J&#39;SUIS PAS CONTENT ! #85 : Macron le Jupitérien (mi Raptor-Jésus) VS la Paluche à Donald', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/T5sxN5MEtzE/default.jpg', 0),
(264, 'BqOd9z2RiYA', '2017-06-06', 'J&#39;SUIS PAS CONTENT ! #84 : Moralisation mon cochon !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/BqOd9z2RiYA/default.jpg', 0),
(265, 'YcdGJ4G-XE4', '2017-05-26', 'J&#39;SUIS PAS CONTENT ! #83 : Lalanne &amp; Dieudo à Evry, Trump chez Bibi &amp; Hanouna dans le caca !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux sociaux : T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/YcdGJ4G-XE4/default.jpg', 0),
(266, 'udkhS3aQOWs', '2017-05-24', 'J&#39;SUIS PAS CONTENT ! #82 : Attentat de Manchester, Journalistes ringards &amp; Pause caca !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS ...', 'https://i.ytimg.com/vi/udkhS3aQOWs/default.jpg', 0),
(267, 'SmPehaETF4k', '2017-05-23', 'J&#39;SUIS PAS CONTENT ! #81 : Gouvernement Macron = Féminisme en PLS + Dissidence trollée !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS ...', 'https://i.ytimg.com/vi/SmPehaETF4k/default.jpg', 0),
(268, 'D8d7bTcL7t8', '2017-05-18', 'J&#39;SUIS PAS CONTENT ! #80 : Gouvernement Macron, dans le Collomb !', 'Pour assister ce Vendredi au Pas Content Comedy Club : http://www.billetreduc.com/173019/evt.htm · Pour assister au tournage de Télé d\'Avant ce Dimanche ...', 'https://i.ytimg.com/vi/D8d7bTcL7t8/default.jpg', 0),
(269, 'roZeF6fHvLU', '2017-05-17', 'TELE D&#39;AVANT ! #03 : Débrief Macron &amp; Prochaine émission !', 'Pour assister à l\'émission ce dimanche : https://www.weezevent.com/tournage-tele-d-avant-special-humoristes-et-liberte-d-expression · Pour me soutenir sur ...', 'https://i.ytimg.com/vi/roZeF6fHvLU/default.jpg', 0),
(270, 'RgB5mwfsry4', '2017-05-11', 'J&#39;SUIS PAS CONTENT ! #79 : Macron Président !!! Le changement c&#39;est maintenant !!!', 'Pour venir au PAS CONTENT COMEDY CLUB ce Vendredi : http://www.billetreduc.com/173019/evt.htm · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/RgB5mwfsry4/default.jpg', 0),
(271, '3kl2PvWUhtQ', '2017-05-09', 'LIVE #01 : La victoire de Macron / Pourquoi je n&#39;ai pas voté FN', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Pour venir me voir Mercredi en première partie de John ...', 'https://i.ytimg.com/vi/3kl2PvWUhtQ/default.jpg', 0),
(272, '_x8rQM3yTGE', '2017-05-06', 'J&#39;SUIS PAS CONTENT ! #78 : Philippot en mode House of Cards &amp; Yamcha en mode Roi de France !', 'Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/_x8rQM3yTGE/default.jpg', 0),
(273, 'L_F7o0LQKAA', '2017-05-04', 'J&#39;SUIS PAS CONTENT ! #77 : Débat du second tour, Macron VS Le Pen &amp; Ségolène fait de la peine !', 'Pour venir ce Vendredi au Pas Content Comedy Club : http://www.billetreduc.com/173019/evt.htm · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/L_F7o0LQKAA/default.jpg', 0),
(274, 'CnMIl-fBftc', '2017-05-02', 'Télé D&#39;Avant ! : la première émission est dispo !', 'Pour venir me voir en première partie demain : http://www.billetreduc.com/182754/evt.htm · Lien de la première émission ...', 'https://i.ytimg.com/vi/CnMIl-fBftc/default.jpg', 0),
(275, '-VRAPAY0Ung', '2017-05-02', 'TELE D&#39;AVANT ! #02 : Si on parlait de Youtube ? [avec Kriss, TeddyBoy RSA &amp; KamaDesTrucs]', 'Que se passe t\'il quand un animateur radio de gauche des années de 1985 (Daniel Carrucci) et un journaliste au Figaro de 1975 se retrouvent téléportés à ...', 'https://i.ytimg.com/vi/-VRAPAY0Ung/default.jpg', 0),
(276, 'P8P-TYtcKpg', '2017-04-23', 'J&#39;SUIS PAS CONTENT ! #76 : Attentat sur les Champs, Trump VS Corée &amp; Fillon veut rien lacher !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • • D I S C O R D : https://discord.gg/RaksmAn Y O U T U B E ...', 'https://i.ytimg.com/vi/P8P-TYtcKpg/default.jpg', 0),
(277, 'vV45krWe2Js', '2017-04-22', 'TELE D&#39;AVANT ! #01 : Les voyageurs du passé', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • • D I S C O R D : https://discord.gg/RaksmAn Y O U T U B E ...', 'https://i.ytimg.com/vi/vV45krWe2Js/default.jpg', 0),
(278, 'tZOc4sBQcdQ', '2017-04-20', 'VLOG #S02E01 : Pour qui je vais voter en 2017 / L&#39; abstention [feat. JR Lombard]', 'Pour réserver pour ma toute dernière date de spectacle : http://www.billetreduc.com/172701/evt.htm · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/tZOc4sBQcdQ/default.jpg', 0),
(279, 'nvWrZVT1Yl0', '2017-04-11', 'J&#39;SUIS PAS CONTENT ! 75 : Macron atomise Audiard, Trump bombarde Bachar &amp; l&#39;Arabie explose la Bourse', 'Liens pour réserver : · pour mon One Man Show a Lyon ce jeudi : https://www.weezevent.com/greg-tabibian-dans-j-suis-pas-content-a-lyon · pour le Pas ...', 'https://i.ytimg.com/vi/nvWrZVT1Yl0/default.jpg', 0),
(280, 'e7kaD1bOGWk', '2017-04-05', 'J&#39;SUIS PAS CONTENT ! #74 : Débat Présidentiel, tous en maternelle ! (Poutou ne fait pas de poutoux)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • • D I S C O R D : https://discord.gg/RaksmAn Y O U T U B E ...', 'https://i.ytimg.com/vi/e7kaD1bOGWk/default.jpg', 0),
(281, '94FgGTXyWU4', '2017-04-04', 'J&#39;SUIS PAS CONTENT ! #73 : Tous unis contre le FN ! Vive la France ! Et vive le cassoulet !', 'Pour réserver pour mon spectacle ce Vendredi à Paris (dernières dates) : http://www.billetreduc.com/172701/evt.htm · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/94FgGTXyWU4/default.jpg', 0),
(282, '4rdJX-pDxNk', '2017-04-03', 'J&#39;SUIS PAS CONTENT ! #72 : Macron VS Hollande, concours de connerie ! (et décadence culturelle...)', 'Pour réserver pour mon spectacle ce Vendredi à Paris (dernières dates) : http://www.billetreduc.com/172701/evt.htm · Pour me soutenir sur T I P E E E ...', 'https://i.ytimg.com/vi/4rdJX-pDxNk/default.jpg', 0),
(283, '8-Qwxm2lutM', '2017-03-30', 'J&#39;SUIS PAS CONTENT ! #71 : Macron en Guyane, Trahison de Valls &amp; Ségolène Lannister !', 'Pour réserver pour le Pas Content Comedy Club : · https://www.weezevent.com/pas-content-comedy-club-31-03-2017 Retrouve-nous sur : · T W I T T E R ...', 'https://i.ytimg.com/vi/8-Qwxm2lutM/default.jpg', 0),
(284, 'Zze8zOJPfxY', '2017-03-28', 'GREG TABIBIAN dans J&#39;SUIS PAS CONTENT ! (les 10 premières minutes)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa • D I S C O R D ...', 'https://i.ytimg.com/vi/Zze8zOJPfxY/default.jpg', 0),
(285, 'YIUCmAN5EUQ', '2017-03-27', 'J&#39;SUIS PAS CONTENT ! #70 : Attentat de Londres, attentat d&#39;Orly &amp; Etat d&#39;urgence mon kiki !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • • D I S C O R D : https://discord.gg/RaksmAn Y O U T U B E ...', 'https://i.ytimg.com/vi/YIUCmAN5EUQ/default.jpg', 0),
(286, 'tbGyeglGipY', '2017-03-22', 'J&#39;SUIS PAS CONTENT ! #69 : Macron, le PNJ de l’enfer… (VS Asselineau &amp; le 18-25)', 'Pour réserver ta place pour ce Vendredi à Toulouse : https://www.weezevent.com/greg-tabibian-dans-j-suis-pas-content Retrouve-nous sur : · T W I T T E R ...', 'https://i.ytimg.com/vi/tbGyeglGipY/default.jpg', 0),
(287, 'B_Kkt3gETjk', '2017-03-21', 'J&#39;SUIS PAS CONTENT ! #68 : Débat Présidentiel, arnaque Macron &amp; féminisme contrarié !', 'Pour réserver ta place pour ce Vendredi à Toulouse ...', 'https://i.ytimg.com/vi/B_Kkt3gETjk/default.jpg', 0),
(288, 'i8fv50huT4g', '2017-03-13', 'J&#39;SUIS PAS CONTENT ! #66 : PSG Humilié, Indécence socialiste &amp; Porno pour tous ! [Quickie 21]', 'Pour réserver pour la tournée : NANTES : http://www.billetreduc.com/182021/evt.htm ROUEN : http://www.billetreduc.com/182225/evt.htm LILLE ...', 'https://i.ytimg.com/vi/i8fv50huT4g/default.jpg', 0),
(289, 'TJWRv_zic9o', '2017-03-10', 'Résa tournée disponible, Comedy club surprise &amp; Vlogs ! (la vidéo du jeudi #10)', 'Pour réserver pour le comedy club, ce soir 21h30 : http://www.billetreduc.com/173019/evt.htm · Pour réserver pour la tournée : NANTES ...', 'https://i.ytimg.com/vi/TJWRv_zic9o/default.jpg', 0),
(290, 'F4DuPZu-CiE', '2017-02-28', 'J&#39;SUIS PAS CONTENT ! #64 : Ferme ta gueule Macron ! [Quickie #19]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/F4DuPZu-CiE/default.jpg', 0),
(291, 'RbNiMMiiAFs', '2017-02-24', 'J&#39;SUIS PAS CONTENT ! #63 : Affaire Théo, FN &amp; Dragon Ball ! [Quickie #18]', 'Pour réserver pour la tournée : · http://mercipublic.com/artist/greg-tabibian/ Retrouve-nous sur : Discord : https://discord.gg/R5J9f27 · T W I T T E R ...', 'https://i.ytimg.com/vi/RbNiMMiiAFs/default.jpg', 0),
(292, 'NVSDKCZ7zF4', '2017-02-12', 'Annonce importante ! on a besoin de vous !', 'Les inscriptions sont maintenant terminées ! Nous sommes complets ! Merci à tous ceux qui ont joué le jeu :) Je vous kiffe !!!', 'https://i.ytimg.com/vi/NVSDKCZ7zF4/default.jpg', 0),
(293, '8NVwFUQB1go', '2017-02-09', 'J&#39;SUIS PAS CONTENT ! #62 : Valls à la trappe, le PS en PLS !!! [Quickie #17]', 'Pré-Réservations GRATUITES pour le spectacle : · http://mercipublic.com/artist/greg-tabibian/ Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E ...', 'https://i.ytimg.com/vi/8NVwFUQB1go/default.jpg', 0),
(294, '_MlKm6e5zWI', '2017-01-25', 'J&#39;SUIS PAS CONTENT... sur scène ! c&#39;est parti pour la tournée !', 'PRECISION importante : le spectable n\'est PAS une reprise de mes vidéos j\'suis pas content ! C\'est un spectacle totalement différent :) · Pour pré-réserver ...', 'https://i.ytimg.com/vi/_MlKm6e5zWI/default.jpg', 0),
(295, '_Pdh8KB6uFI', '2017-01-23', 'J&#39;SUIS PAS CONTENT ! #60 : Polanski mon kiki, Prédicat mon caca ! [Quickie #15]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/_Pdh8KB6uFI/default.jpg', 0),
(296, 'fuyAey-u5m4', '2017-01-19', 'J&#39;SUIS PAS CONTENT ! #59 : La ptite giflette à Manu ! [Quickie #14]', 'o Lien de la pétition : · http://www.mesopinions.com/petition/social/legion-honneur-nolan-18-ans-gifle/27431 o Retrouve-nous sur : · T W I T T E R ...', 'https://i.ytimg.com/vi/fuyAey-u5m4/default.jpg', 0),
(297, 'f1GIZHlIQ5w', '2017-01-11', 'J&#39;SUIS PAS CONTENT ! #58 : Bonne année mon CUL ! [Quickie #13]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/f1GIZHlIQ5w/default.jpg', 0),
(298, 'J4mIXL6cJWI', '2016-12-27', 'J&#39;SUIS PAS CONTENT ! #57 : Les Chtis Kdos de Manuel Valls ! (et Mimolette...) [Quickie #12]', 'Retrouve-nous sur : Discord : https://discord.gg/R5J9f27 · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E ...', 'https://i.ytimg.com/vi/J4mIXL6cJWI/default.jpg', 0);
INSERT INTO `video` (`id`, `videoId`, `publishedAt`, `title`, `description`, `thumbnails`, `checked`) VALUES
(299, '9WyVpUrjHoQ', '2016-12-08', 'J&#39;SUIS PAS CONTENT! #56: Hollande renonce, Najat s&#39;enfonce, Fillon défonce &amp; YT Drama???? [ft. Pavalek]', 'Retrouve-nous sur : Discord : https://discord.gg/R5J9f27 · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E ...', 'https://i.ytimg.com/vi/9WyVpUrjHoQ/default.jpg', 0),
(300, '3Z8mjP5PXeo', '2016-11-15', 'J&#39;SUIS PAS CONTENT ! #54 (Feat. Raptor Dissident) : Flics en manif, Nuit debout &amp; Président teubé...', 'Retrouve-nous sur : Discord : https://discord.gg/R5J9f27 · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E ...', 'https://i.ytimg.com/vi/3Z8mjP5PXeo/default.jpg', 0),
(301, '-4UEiNWlNlA', '2016-11-09', 'J&#39;SUIS PAS CONTENT ! #53 :  Donald Trump a gagné les élections ! [Quickie #10]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/-4UEiNWlNlA/default.jpg', 0),
(302, 'Ar0x9PefcAU', '2016-11-08', 'J&#39;SUIS PAS CONTENT ! #52 : Wifi terroriste, Manuel Valls &amp; Haute... ? [Quickie #09]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/Ar0x9PefcAU/default.jpg', 0),
(303, 'zfOcVBnz_q0', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #15 - Les voeux 2015 de François Hollande...', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/zfOcVBnz_q0/default.jpg', 0),
(304, 'k_eHPKovL2w', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #02 - Une bande de clowns terrorise la France !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/k_eHPKovL2w/default.jpg', 0),
(305, 'Vbs4XkujCoQ', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #12 - France, Qatar et Coupe du monde...', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/Vbs4XkujCoQ/default.jpg', 0),
(306, '8kKmV3TwpC8', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #11 - Mimolette en CHAPKA, Antifas au COMBAT !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/8kKmV3TwpC8/default.jpg', 0),
(307, 'cB0DiyXp_uU', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #07 - Merkel VS Poutine (et Mimolette...)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/cB0DiyXp_uU/default.jpg', 0),
(308, 'w7KnmYrlors', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #13 - Nicolas et Fatima !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/w7KnmYrlors/default.jpg', 0),
(309, 'fX3MFiZtk84', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #08 - Mimolette et Dassault VS Florange', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/fX3MFiZtk84/default.jpg', 0),
(310, '-t4ZDhzuCV8', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #06 - Obama VS Mimolette !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/-t4ZDhzuCV8/default.jpg', 0),
(311, 'zQbH9l3yRlM', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #01 - Fleur Pellerin (et son plug anal)...', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/zQbH9l3yRlM/default.jpg', 0),
(312, 'QPhNKRsGM5Y', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #14 - Travail le dimanche, pédophilie et ventres à louer !', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/QPhNKRsGM5Y/default.jpg', 0),
(313, 'NtPJZnHsJ3E', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #03 - BHL hué en Tunisie (vous faites chier les tunisiens !)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/NtPJZnHsJ3E/default.jpg', 0),
(314, 'XF94KHJ7WhQ', '2016-11-03', 'J&#39;SUIS PAS CONTENT ! #04 - 10% des députés ne payent pas leurs impôts...', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/XF94KHJ7WhQ/default.jpg', 0),
(315, 'r9J5e9xg_Zw', '2016-11-01', 'J&#39;SUIS PAS CONTENT ! #51 : Pains au chocolat, Lobby sioniste &amp; Warhammer...  [Quickie #08]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/r9J5e9xg_Zw/default.jpg', 0),
(316, 'VaHKbh807o4', '2016-10-27', 'J&#39;SUIS PAS CONTENT ! #50 : La merveilleuse histoire... de Solférino ! (en PLS...) [Quickie #07]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/VaHKbh807o4/default.jpg', 0),
(317, 'HM_bu9WwQro', '2016-10-04', 'J’SUIS PAS CONTENT ! #48 : Dé-radicalisation mon cochon ! [Quickie #05]', 'Enfin une bonne nouvelle !!! Mimolette a enfin décidé de sortir l\'artillerie lourde face au terrorisme… Mais que fait Eric Ciotti ??? Retrouve-nous sur ...', 'https://i.ytimg.com/vi/HM_bu9WwQro/default.jpg', 0),
(318, 'Ch_oWl02Qug', '2016-10-03', 'J’SUIS PAS CONTENT ! #47 : Jean-Vincent « Placé »… dans l’armée ! [Quickie #04]', 'Décidément, il lui faut toute les places à Jean-Vincent Placé ! Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/Ch_oWl02Qug/default.jpg', 0),
(319, 'YjJAnvZQYHY', '2016-10-02', 'J’SUIS PAS CONTENT ! #46 : Grâce à Sarkozy, les arabes ne crient plus mort au Juifs ! [Quickie #03]', 'Lien pour voir l\'épisode depuis mon site internet ...', 'https://i.ytimg.com/vi/YjJAnvZQYHY/default.jpg', 0),
(320, '5hCJ_e_j2jk', '2016-10-02', 'J&#39;SUIS PAS CONTENT ! #45 : La merveilleuse histoire... de Patrick Buisson ! [Quickie #02]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/5hCJ_e_j2jk/default.jpg', 0),
(321, 'l3BN0Gdc4ac', '2016-10-01', 'J&#39;SUIS PAS CONTENT ! #44 : Mimolette élu &quot;Homme d&#39;Etat&quot; de l&#39;année 2016... [Quickie #01]', 'Lien pour voir la vidéo depuis mon site internet : http://gregtabibian.com/jsuis-pas-content-quickie-01-mimolette-elu-homme-detat-mondial-de-lannee-2016/', 'https://i.ytimg.com/vi/l3BN0Gdc4ac/default.jpg', 0),
(322, 'AIjD4KBsoUQ', '2016-09-30', 'VLOG #52 - Reboot de la chaine, mes excuses &amp; nouvelles vidéos !', 'Mon site internet : gregtabibian.com · Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Pour pré-réserver gratuitement pour mon ...', 'https://i.ytimg.com/vi/AIjD4KBsoUQ/default.jpg', 0),
(323, 'Q90OmwFtMWQ', '2016-09-29', 'VLOG #51 : Réactions à la mort de Shimon Peres', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/Q90OmwFtMWQ/default.jpg', 0),
(324, '1k7BDNL-t_s', '2016-09-21', 'VLOG #50 : Quand Christine Boutin annonce la mort de Jacques Chirac... [TROLLEZ MOI CETTE CONNE #01]', 'MAJ : Christine a retiré son Tweet ! Il n\'y a donc plus de raisons de la faire \"chier\". Merci pour vos messages twitter qui étaient tous intelligents, droles, critiques, ...', 'https://i.ytimg.com/vi/1k7BDNL-t_s/default.jpg', 0),
(325, 'RtU9T75pPi4', '2016-09-14', 'La théorie du complot est-elle un complot ? ????? (Complots? #01)', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/RtU9T75pPi4/default.jpg', 0),
(326, 'ZZP5gvgiz3c', '2016-09-07', 'VLOG #49 - Lancement officiel de la tournée en province !!!', 'Lien Mercipublic.com pour pouvoir me voir : http://mercipublic.com/artist/greg-tabibian/ · Précision 1 : J\'ai oublié de le préciser, mais il est aussi possible ...', 'https://i.ytimg.com/vi/ZZP5gvgiz3c/default.jpg', 0),
(327, 'nJRgcBQPIgQ', '2016-09-06', 'Les &quot;PAS CONTENTS&quot; : Merci Macron ! (chanson bonus de l&#39;épisode 43 de JSPC) [par Eddy Pero]', 'Interprété par : Eddy Pero Textes de Greg Tabibian D\'après une chanson originale des Charlots. · Lien de l\'épisode complet ...', 'https://i.ytimg.com/vi/nJRgcBQPIgQ/default.jpg', 0),
(328, 'DmeBTEcCM9Q', '2016-09-06', 'J&#39;SUIS PAS CONTENT ! #43 : Burkini mon kiki, Macron démission &amp; Sarko en PLS [feat. Eddy Pero]', 'PRÉCISION POUR LES RAGEUX : Oui techniquement Macron n\'était pas ministre de l\'Emploi mais de l\'économie, de l\'industrie et du numérique… Mais sa ...', 'https://i.ytimg.com/vi/DmeBTEcCM9Q/default.jpg', 0),
(329, '1D0tBnyt2K4', '2016-08-02', 'Les &quot;PAS CONTENTS&quot; : Tu sais qu&#39; t&#39;as pas l&#39; droit ! [feat. Feryel &amp; Damien 17]', 'Lien de l\'épisode complet : · https://www.youtube.com/watch?v=ehrnR2Pr-gk Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/1D0tBnyt2K4/default.jpg', 0),
(330, 'ehrnR2Pr-gk', '2016-08-01', 'J&#39;SUIS PAS CONTENT ! #42 - Nice, Brexit &amp; Flics de Choc... un bel été de merde ! [FINAL saison 2]', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/ehrnR2Pr-gk/default.jpg', 0),
(331, 'A_RJZ1czZFQ', '2016-07-21', 'VLOG #48 : Depuis cette après-midi, nous sommes dans 1984...', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/A_RJZ1czZFQ/default.jpg', 0),
(332, 'LNm9K3KgrFg', '2016-07-11', 'VLOG #45 : victoire de la France !!!', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/LNm9K3KgrFg/default.jpg', 0),
(333, 'GGpOjy15MPE', '2016-06-25', 'VLOG #44 : Top 5 des conséquences du Brexit', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/GGpOjy15MPE/default.jpg', 0),
(334, 'M-2QySymocE', '2016-06-15', 'J&#39;SUIS PAS CONTENT ! #41 - Grèves, inondations &amp; communautarismes ! (?????????? )', 'Retrouve-moi sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/M-2QySymocE/default.jpg', 0),
(335, '_7sFuRfFyrw', '2016-06-05', 'DAMIEN 17 : &quot;Je suis&quot; (chanson bonus du #jspc37, par &quot;LES PAS CONTENTS&quot;)', 'Regarde l\'épisode en entier ici : https://www.youtube.com/watch?v=-ZI3QSC4TYw Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K ...', 'https://i.ytimg.com/vi/_7sFuRfFyrw/default.jpg', 0),
(336, 'xjQxvo7Z-hU', '2016-06-02', '&quot;LES PAS CONTENTS !&quot; : Merci El Khomri ! (chanson bonus du jspc #40, feat Eddy Pero)', 'LIen de l\'épisode : https://www.youtube.com/watch?v=_alajWXietw LIen de la page facebook d\'Eddy Pero : https://www.facebook.com/amazonzero/?fref=ts Lien ...', 'https://i.ytimg.com/vi/xjQxvo7Z-hU/default.jpg', 0),
(337, 'zUGVyO_5P5w', '2016-06-01', 'Parler de Dieudonné sur Scène... (petite expérience socio-humoristique)', 'Pour réserver pour le spectacle : http://www.billetreduc.com/162866/evt.htm · Prochaine date sur facebook ...', 'https://i.ytimg.com/vi/zUGVyO_5P5w/default.jpg', 0),
(338, '_alajWXietw', '2016-05-30', 'J&#39;SUIS PAS CONTENT ! #40 - Nuit Debout, 49.3 &amp; Trolls en série ! [Feat. Eddy Pero] (?????????? )', 'Retrouve-nous sur : · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E : https://goo.gl/iOTGSa · Pour me soutenir ...', 'https://i.ytimg.com/vi/_alajWXietw/default.jpg', 0),
(339, 'i2D7XdCMOWk', '2016-05-10', 'VLOG #43 - Loi Travail : Manuel Valls utilise le 49.3 (reaction)', 'Ca faisait bien longtemps que je n\'avais pas fait de ?#?vlog?... Mais là, ils ont quand même fait très fort ce matin... Petite réaction matinale face à l\'utilisation du ...', 'https://i.ytimg.com/vi/i2D7XdCMOWk/default.jpg', 0),
(340, 'baJBQ1mhyXs', '2016-05-04', 'J&#39;SUIS PAS CONTENT ! #39 - Mimolette en débat, Joey Starr le ninja + Infos importantes !', 'Lien vers l\'épisode sur Dailymotion : http://www.dailymotion.com/video/x4819fz_j-suis-pas-content-39-mimolette-en-debat-joey-starr-le-ninja_fun · Pour me ...', 'https://i.ytimg.com/vi/baJBQ1mhyXs/default.jpg', 0),
(341, '9wejguwi7NY', '2016-04-15', 'J&#39;SUIS PAS CONTENT ! #38 - Nuit Debout, Pédés &amp; Macarons !  (?????????? )', 'Retrouve-nous sur : Disdcor : https://discord.gg/R5J9f27 · T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS • Y O U T U B E ...', 'https://i.ytimg.com/vi/9wejguwi7NY/default.jpg', 0),
(342, 'UTkUA17SIA4', '2016-04-15', 'J&#39;SUIS PAS CONTENT ! #37 et #38 (?????????? )', 'Pour voir les épisodes sur dailymotion : o Episode 38 : http://goo.gl/CgZ4PK o Episode 37 : http://goo.gl/sb2uIa Pour voir les épisodes sur Youtube : o Episode ...', 'https://i.ytimg.com/vi/UTkUA17SIA4/default.jpg', 0),
(343, '-ZI3QSC4TYw', '2016-04-15', 'JSPC #37 - Remaniement, Loi Travail &amp; Défaites de la musique ! [Feat Eddy Pero &amp; Marc Altorffer]', 'o Vidéo écrite et enregistrée entre Février 2016 et Mars 2016. Désolé pour le retard ! o Retrouve nous sur facebook ...', 'https://i.ytimg.com/vi/-ZI3QSC4TYw/default.jpg', 0),
(344, 'MqcpcnAYZ48', '2016-03-14', 'VLOG #42 - Liste des sites conspirationnistes et nouvelle série ! (?????????? )', 'Petite vidéo sur pouce, originalement prévue pour facebook, histoire de remercier une fois de plus nos amis belges et vous annoncer une petite surprise :) Liste ...', 'https://i.ytimg.com/vi/MqcpcnAYZ48/default.jpg', 0),
(345, 'mFnwoigKXEM', '2016-03-09', 'VLOG #41 : Diner du CRIF et réponse à Manuel Valls ! (?????????? )', 'o POUR ASSISTER AU PAS CONTENT COMEDY CLUB (attention, humour qui pique), c\'est ici : http://www.billetreduc.com/148023/evt... o Article mentionné ...', 'https://i.ytimg.com/vi/mFnwoigKXEM/default.jpg', 0),
(346, 'DQsB3fxorkI', '2016-03-08', 'VLOG #40 : Réponse à Jean Vincent Placé... #OnVautMieuxQueCa (?????????? )', 'En attendant la manif de demain, et après un petit mois d\'absence, je suis de retour !!!', 'https://i.ytimg.com/vi/DQsB3fxorkI/default.jpg', 0),
(347, '1BE8kKjYoDE', '2016-02-07', 'Les &quot;PAS CONTENTS&quot; : Dur dur d&#39;être un conspi !!! (bonus jspc#36)', 'Vous avez été nombreux à le demander : voici donc le clip de \"dur dur d\'être un conspi\", la chanson présente dans l\'épisode 36 de JSPC ! Pour voir l\'épisode ...', 'https://i.ytimg.com/vi/1BE8kKjYoDE/default.jpg', 0),
(348, 'Ne7CAK9NBPM', '2016-02-04', 'JSPC #36 - Star Wars, progrès sexuel et conspirationnisme ! [LIRE LA DESCRIPTION DE LA VIDEO]', 'ATTENTION !!!!!!!!!!!!!! Pour des raisons de droits d\'auteurs, cette vidéo ne peut être visionnée NI sur téléphone portable NI en Allemagne. Pour remédier à ce ...', 'https://i.ytimg.com/vi/Ne7CAK9NBPM/default.jpg', 0),
(349, '48BRmLwUdZw', '2016-01-27', 'VLOG #38 -  Taubira démissionne ! (hommage à tata Christiane) (?????????? )', 'Et oui, Christiane Taubira à quitté le gouvernement ce matin ! Certains m\'ont reprochés d\'être un peu trop vulgaire dans les derniers vlogs. Place à la poésie ...', 'https://i.ytimg.com/vi/48BRmLwUdZw/default.jpg', 0),
(350, 'DxBLH3BiqHA', '2016-01-23', 'VLOG #37 - Le projet de loi débile de deux députés socialistes... (?????????? )', 'o Article mentionné dan la vidéo : http://www.numerama.com/politique/139435-un-amendement-pour-interdire-les-liens-hypertextes.html o Retrouve-nous sur ...', 'https://i.ytimg.com/vi/DxBLH3BiqHA/default.jpg', 0),
(351, 'K4ksP3273BI', '2016-01-19', 'VLOG #35 - La liberté d&#39;exprè-fion selon Manuel Valls (?????????? ) !', 'Petit rappel : pour ceux qui veulent se changer les idées, rire et réfléchir (et qui sont sur Paris), vous êtes conviés à la cinquième édition du PAS CONTENT ...', 'https://i.ytimg.com/vi/K4ksP3273BI/default.jpg', 0),
(352, 'MJXEtLUZM5A', '2016-01-14', 'VLOG #34 - MEGA Lol Bébé CHAT #XPTDR SWAGG (?????????? )', 'o Retrouve-nous sur facebook : https://www.facebook.com/pascontenttv/?ref=tn_tnmn.', 'https://i.ytimg.com/vi/MJXEtLUZM5A/default.jpg', 0),
(353, 'mY949ROPKus', '2016-01-13', 'VLOG #33 - La dernière vidéo de la chaine ? (?????????? )', 'Petit vlog improvisé à l\'occasion de la loi actuellement en cours de vote à l\'Assemblée ce mercredi, dans le silence médiatique le plus total. Tourné avec les ...', 'https://i.ytimg.com/vi/mY949ROPKus/default.jpg', 0),
(354, '7bV-2gLRYyY', '2015-12-27', 'VLOG #32 - La nouvelle réforme électo-anale ! (?????????? )', 'Vidéo originalement postée le 24/12/2015. J\'avais pas prévu de refaire un VLOG avant la fin de l\'année mais là… c\'est du lourd… C\'est mon petit cadeau de ...', 'https://i.ytimg.com/vi/7bV-2gLRYyY/default.jpg', 0),
(355, '7uSuui9Tjkw', '2015-12-25', 'J&#39;SUIS PAS CONTENT ! #35 ?+ infos importantes !?', 'o LIEN POUR VOIR L\'EPISODE VIA DAILYMOTION : http://goo.gl/ENA7I5 N\'hésitez pas à vous abonner à la newsletter de mon site internet afin de ne rien ...', 'https://i.ytimg.com/vi/7uSuui9Tjkw/default.jpg', 0),
(356, '37cfq8bfOnY', '2015-12-05', 'VLOG #31 - La dénonciation enfin de retour en France ! Youpi !!! (?????????? )', 'Nouveau Vlog !!! et pour une fois, une BONNE nouvelle à l\'intérieur !!! Youpi !!! ?#?jspc? ?#?vlog31? ?#?heureslesplussombres? o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/37cfq8bfOnY/default.jpg', 0),
(357, 'xETwdIblofQ', '2015-12-04', 'Le point sur la chaine (première partie) : Vlogs et prochain JSPC', 'Lien des épisodes de VLOG : https://www.youtube.com/playlist?list=PLMliZY3QWQlJO5fRHX-Ofw3AXlMfBUIjl Lien de la page facebook JSPC-TV (chaine d\'info ...', 'https://i.ytimg.com/vi/xETwdIblofQ/default.jpg', 0),
(358, '0LQSs9Jta-E', '2015-12-04', 'VLOG #25 - Etat d&#39;urgence et Cop 21 [REUPLOAD 29/11/2015]', 'o Vidéo originalement postée sur Facebook le : 29/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/0LQSs9Jta-E/default.jpg', 0),
(359, 'kfdU18KEVgA', '2015-12-04', 'VLOG #14 - Jambon vs Terrorisme [REUPLOAD 16/11/2015]', 'o Vidéo originalement postée sur Facebook le : o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/kfdU18KEVgA/default.jpg', 0),
(360, '3nXwJI4Hpfw', '2015-12-04', 'VLOG #02 - La générosité selon Cyril Hanouna [REUPLOAD 17/04/2015]', 'Date originale de publication : 17/04/2015. Crise de générosité passagère pour Cyril Hanouna. Rassurez vous il va bien! - Vlog du 17/04/2015 Rejoins nous sur ...', 'https://i.ytimg.com/vi/3nXwJI4Hpfw/default.jpg', 0),
(361, 'GQHUg6qf5fQ', '2015-12-04', 'VLOG #17 : Après les attentats, ce qui nous attend dans trois mois ! [REUPLOAD 18/11/2015]', 'o Vidéo originalement postée sur Facebook le : 18/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/GQHUg6qf5fQ/default.jpg', 0),
(362, '4QiGrQJybhM', '2015-12-04', 'VLOG #28 : Alerte Info !!! Prise d&#39;otages à Roubaix !!! [REUPLOAD 01/12/2015]', 'o Vidéo originalement postée sur Facebook le : 01/12/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/4QiGrQJybhM/default.jpg', 0),
(363, 'S0v1Soi36ig', '2015-12-04', 'VLOG #16 -  Réponse à la polémique sur le Coran [REUPLOAD 18/11/2015]', 'o Vidéo originalement postée sur Facebook le : 18/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/S0v1Soi36ig/default.jpg', 0),
(364, 'aTBRxmpUuIg', '2015-12-04', 'VLOG #09 - Réponse à Julien Dray [REUPLOAD 21/10/2015]', 'Date originale de publication : 21/10/2015 Les socialistes ça ose tout : c\'est même à ça qu\'on les reconnait... Même sortir Julien Dray du placard, pour l\'envoyer ...', 'https://i.ytimg.com/vi/aTBRxmpUuIg/default.jpg', 0),
(365, 'QCDkgEOV9Lg', '2015-12-04', 'VLOG #30 - Réaction à l&#39;interview de Karim Benzema [REUPLOAD 03/12/2015]', 'o Vidéo originalement postée sur Facebook le : 03/12/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/QCDkgEOV9Lg/default.jpg', 0),
(366, 'C696luPiveU', '2015-12-04', 'VLOG #27 - Alerte Info !!!  Nouvelle prise d&#39;otages en France !!! [REUPLOAD 01/12/2015]', 'o Vidéo originalement postée sur Facebook le : 01/12/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/C696luPiveU/default.jpg', 0),
(367, 'lv5ROd05gQo', '2015-12-04', 'VLOG #29 -  Etat d&#39;urgence dans ton cul ! [REUPLOAD 03/12/2015]', 'o Vidéo originalement postée sur Facebook le : 03/12/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/lv5ROd05gQo/default.jpg', 0),
(368, 'NWurhLIdELE', '2015-12-04', 'VLOG #19 - Juste une question sur les kamikazes... [REUPLOAD 20/11/2015]', 'o Vidéo originalement postée sur Facebook le : 20/11/2015 (AVANT que l\'on apprenne que la présumée kamikaze du Bataclan ne s\'était en réalité pas faite ...', 'https://i.ytimg.com/vi/NWurhLIdELE/default.jpg', 0),
(369, 'gelsq9XnlAw', '2015-12-04', 'VLOG #04 - F. Hollande et V. Poutine, comparatif de styles [REUPLOAD 23/04/2015]', 'Date originale de publication : 23 avril 2015. Mimolette veut faire la guéguerre avec Poutine ? Pas sûr que se soit une bonne idée fanfan… Petit comparatif de ...', 'https://i.ytimg.com/vi/gelsq9XnlAw/default.jpg', 0),
(370, 'UhLD0zpb2wY', '2015-12-04', 'VLOG #20 - Sommes-nous vraiment en démocratie ? 1/2 [REUPLOAD 22/11/2015]', 'o Vidéo originalement postée sur Facebook le : 22/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/UhLD0zpb2wY/default.jpg', 0),
(371, 'S_tU0SXxlLQ', '2015-12-04', 'VLOG #12 - François Hollande envoie le Charles de Gaulle ! [REUPLOAD 16/11/2015]', 'o Vidéo originalement postée sur Facebook le : 16/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/S_tU0SXxlLQ/default.jpg', 0),
(372, '9pMZz3iPxnw', '2015-12-04', 'VLOG #23 - La vraie raison des attentats 2/2 [REUPLOAD 25/11/2015]', 'o Vidéo originalement postée sur Facebook le : 25/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/9pMZz3iPxnw/default.jpg', 0),
(373, 'vcMRWTXU6Zk', '2015-12-04', 'VLOG #11 - Terrorisme la première réponse de francois hollande [REUPLOAD 15/11/2015]', 'o Vidéo originalement postée sur Facebook le : 15/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/vcMRWTXU6Zk/default.jpg', 0),
(374, '2QZ6FCn0GBA', '2015-12-04', 'VLOG#18 : Attentat au Bataclan : appel à témoins [REUPLOAD 19/11/2015]', 'o Vidéo originalement postée sur Facebook le : 19/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/2QZ6FCn0GBA/default.jpg', 0),
(375, 'kymH8tTTFzY', '2015-12-04', 'VLOG #24 - Beaujolais nouveau et gros gros merci ! [REUPLOAD 26/11/2015]', 'o Vidéo originalement postée sur Facebook le : 26/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/kymH8tTTFzY/default.jpg', 0),
(376, '5aS72lAI8Bs', '2015-12-04', 'VLOG #22 - La vraie raison des attentats 1/2 [REUPLOAD 24/11/2015]', 'o Vidéo originalement postée sur Facebook le : 24/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/5aS72lAI8Bs/default.jpg', 0),
(377, '_Lku3-7AySs', '2015-12-04', 'VLOG #13 - Nicolas, ferme là ! [REUPLOAD 16/11/2015]', 'o Vidéo originalement postée sur Facebook le : 16/11/2015] o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/_Lku3-7AySs/default.jpg', 0),
(378, 'ALUFsd68Q1g', '2015-12-04', 'VLOG #03 - Bernard Cazeneuve est il conspirationniste ? [REUPLOAD 16/04/2015]', 'Date originale de pulication : 16/04/2015. Petite crise de conspirationnisme de Bernard Cazeneuve à l\'Assemblée Nationale… Rassurez-vous, il va bien !', 'https://i.ytimg.com/vi/ALUFsd68Q1g/default.jpg', 0),
(379, 'VEz5EferpZU', '2015-12-04', 'VLOG #15 -  Le Coran et les attentats [REUPLOAD 17/11/2015]', 'o Vidéo originalement postée sur Facebook le : 17/11/2015 o Toutes nos excuses pour la perte de qualité occasionnée ! o Retrouve-nous sur facebook ...', 'https://i.ytimg.com/vi/VEz5EferpZU/default.jpg', 0),
(380, 'eN0KWD1Sm1U', '2015-12-04', 'VLOG #07 - La Grèce reste dans la zone Euro : la réaction d&#39;Hollande [REUPLOAD 10/07/2015]', 'Date originale de publication : 10 juillet 2015. Ca y est c\'est official le gouvernement grec l\'a annoncé dans la nuit : la Grèce reste dans la zone euro (donc ...', 'https://i.ytimg.com/vi/eN0KWD1Sm1U/default.jpg', 0),
(381, 'QNmkdu4GwOQ', '2015-11-11', 'VLOG #10 - Le sondage de la honte !', 'En attendant le prochain ?#?jspc? voici un petit ?#?vlog? enregistré à l\'arrache pour parler d\'un sondage qui m\'a vraiment trouvé l\'anus... Le foutage de gu**** c\'est ...', 'https://i.ytimg.com/vi/QNmkdu4GwOQ/default.jpg', 0),
(382, 'fN5Jfi0gTus', '2015-10-31', 'JSPC #34 - Air France, Néga-Sionisme et Sarkozy du futur ! [LIRE LA DESCRIPTION]', 'Pour assister au Pas Content Comedy Club : http://www.billetreduc.com/148023/evt.htm · Lien de l\'épisode sur Dailymotion ...', 'https://i.ytimg.com/vi/fN5Jfi0gTus/default.jpg', 0),
(383, 'gjbZgAHzbC8', '2015-10-11', 'Top 10 des meilleurs moments de Nadine Morano', 'Après le Top8 des déclarations de l\'Imam Chalghoumi, le top10 des mensonges et délires de Caroline Fourest et le Top20 des dérapages de JMLP, voici le Top ...', 'https://i.ytimg.com/vi/gjbZgAHzbC8/default.jpg', 0),
(384, 'alxMqnjq1yE', '2015-10-09', 'J&#39;SUIS PAS CONTENT ! #33 - Lapsus en série, Valls candidat et Comedy Club !', 'Pour réserver ta place via BilletReduc (2€) : http://www.billetreduc.com/148023/evt.htm Pour indiquer votre participation à l\'évènement ...', 'https://i.ytimg.com/vi/alxMqnjq1yE/default.jpg', 0),
(385, 'R8FURP2tRdg', '2015-09-17', 'J&#39;SUIS PAS CONTENT ! #32 - BHL, Aylan et féminisme [Feat Mawin]', 'Lien vers l\'épisode : http://gregtabibian.com/video-jspc-32-bhl-aylan-et-feminisme-feat-amazon-zero-mawin/ Lien vers la page \"Mawin-Comédienne\" ...', 'https://i.ytimg.com/vi/R8FURP2tRdg/default.jpg', 0),
(386, 'xMH5SVwB5N8', '2015-09-11', 'VLOG #08 : 11 septembre, n&#39;oublions jamais !  [Feat. Marc Altorffer]', 'En ce jour de deuil et de mémoire, je tenais à apporter mon soutien à toutes les victimes d\'un acte barbare qui changea a jamais la face du monde…', 'https://i.ytimg.com/vi/xMH5SVwB5N8/default.jpg', 0),
(387, 'E_bon-bEH08', '2015-09-02', 'J&#39;SUIS PAS CONTENT ! #31 - Balkany, Terrorisme et Jeux vidéo !', 'Lien de l\'épisode : http://gregtabibian.com/video-jspc-31-balkany-terrorisme-et-jeux-videos PS : certaines personnes semblent rencontrer un problème de son ...', 'https://i.ytimg.com/vi/E_bon-bEH08/default.jpg', 0),
(388, 'X9bhXXtvLvg', '2015-08-12', 'J&#39;SUIS PAS CONTENT ! #30 - Nouvelle planète et chasse aux Nazis...', 'T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS · Notre site internet : www.gregtabibian.com · Lien de notre partenaire Dolycam ...', 'https://i.ytimg.com/vi/X9bhXXtvLvg/default.jpg', 0),
(389, 'wBT2qVER87s', '2015-07-19', 'J&#39;SUIS PAS CONTENT ! #29 - Crise grecque, Facebook et DSK...', 'T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS · Retrouve nous également sur DAILYMOTION (vidéos inédites) ...', 'https://i.ytimg.com/vi/wBT2qVER87s/default.jpg', 0),
(390, 'mVKHrEJw4nQ', '2015-05-19', 'J&#39;SUIS PAS CONTENT ! #28 - Najat et Nico retournent au collège... [Feat. Mawin]', 'T W I T T E R : https://goo.gl/7rYM6E • F A C E B O O K : https://goo.gl/LUkciS · Retrouve nous également sur YOUTUBE : https://goo.gl/iOTGSa · Lien de notre ...', 'https://i.ytimg.com/vi/mVKHrEJw4nQ/default.jpg', 0),
(391, 'CW6JkSlrFXo', '2015-05-13', 'J&#39;SUIS PAS CONTENT ! #27 - Robert Ménard fait d&#39;la Résistance !', 'Après des vacances bien méritées, en route pour l\'épisode 27 ! Entre Robert Ménard qui fiche les musulmans et Valls qui fiche le pays, le temps est à la douleur ...', 'https://i.ytimg.com/vi/CW6JkSlrFXo/default.jpg', 0),
(392, 'F8yuxC8cs3c', '2015-03-28', 'Top 8 des meilleurs moments de l&#39;Imam Chalghoumi (Best Of)', 'J\'ai été surpris de constater qu\'il n\'existait pas de Best Of digne de ce nom de notre ami l\'Imam Chalghoumi. Erreur réparée :) · Pour me soutenir sur ...', 'https://i.ytimg.com/vi/F8yuxC8cs3c/default.jpg', 0),
(393, 'k7ssH10jQMM', '2015-03-27', 'J&#39;SUIS PAS CONTENT ! #25 - Cher François Hollande...', 'Comme promis, voici l\'épisode sur Youtube :)', 'https://i.ytimg.com/vi/k7ssH10jQMM/default.jpg', 0),
(394, '21t-DhakAtc', '2015-03-02', 'J&#39;SUIS PAS CONTENT ! #23 - 49.3 nuances de gré (ou de force...) [feat. Mawin &amp; Le Débrancheur]', 'J\'suis pas content ! Le nouveau Podcast satyrique présenté par Simplet ! Rejoins nous sur Facebook ...', 'https://i.ytimg.com/vi/21t-DhakAtc/default.jpg', 0),
(395, 'PPSaCO9j63Y', '2015-02-20', 'J&#39;SUIS PAS CONTENT ! #22 - Case prison, sans papiers et &quot;bons&quot; musulmans', 'Comment enlever la désactivation des annotations (faire le procédé inverse) ...', 'https://i.ytimg.com/vi/PPSaCO9j63Y/default.jpg', 0),
(396, '2OROHBiCAG0', '2015-02-11', 'J&#39;SUIS PAS CONTENT ! #21 - Gad Elmaleh, fraude fiscale et Enfoirés...', 'J\'suis pas content ! Le nouveau Podcast satyrique présenté par Simplet ! Rejoins nous sur Facebook ...', 'https://i.ytimg.com/vi/2OROHBiCAG0/default.jpg', 0),
(397, 'wafbP6_7gfI', '2015-02-06', 'J&#39;SUIS PAS CONTENT ! #20 - DSK en procès et terrorisme juvénile...', 'J\'suis pas content ! Le nouveau Podcast satyrique présenté par Simplet ! Rejoins nous sur Facebook ...', 'https://i.ytimg.com/vi/wafbP6_7gfI/default.jpg', 0),
(398, 'RwNHrJFEPBw', '2015-02-03', 'J&#39;SUIS PAS CONTENT ! #19 - Concours de connerie : Najat VS Ségolène', 'J\'suis pas content ! Le nouveau Podcast satyrique présenté par Simplet ! Rejoins nous sur Facebook ...', 'https://i.ytimg.com/vi/RwNHrJFEPBw/default.jpg', 0),
(399, 'oa4qimG2rfg', '2020-02-24', 'TOP 5 du Progrès, Griveaux, Macron, Israel, Mila, etc... [EN LIVE ! #05]', 'SOMMAIRE : 1. 00:56 : Actualités en vrac (Castaner, \"Conseil\" de lecture, Humoristes, Brigitte Macron) 2. 07:02 : Le Top 5 du Progrès de la semaine 3. 25:51 ...', 'https://i.ytimg.com/vi/oa4qimG2rfg/default.jpg', 0);

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
