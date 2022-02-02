-- CREATED BY LAHATRA AND DAMA 
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- BASE DE DONNÉES: `QUIZ` 
CREATE DATABASE IF NOT EXISTS quiz;
USE quiz;

-- --------------------------------------------------------

--
-- Structure de la table `ADMINISTRATEUR`
--

CREATE TABLE `ADMINISTRATEUR` (
  `ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `PSEUDO` varchar(100) DEFAULT NULL,
  `MDP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ADMINISTRATEUR`
--

INSERT INTO `ADMINISTRATEUR` (`ID`, `PSEUDO`, `MDP`) VALUES
(1, 'user1', 'b3daa77b4c04a9551b8781d03191fe098f325e67');

-- --------------------------------------------------------

--
-- Structure de la table `CHOIX`
--

CREATE TABLE `CHOIX` (
  `ID` int(11) NOT NULL,
  `IDQUESTION` int(11) DEFAULT NULL,
  `CHOIX` text NOT NULL,
  `ETAT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `CHOIX`
--

INSERT INTO `CHOIX` (`ID`, `IDQUESTION`, `CHOIX`, `ETAT`) VALUES
(1, 1, ' a) 50 %', 0),
(2, 1, 'b) 49,5 %', 0),
(3, 1, 'c) 50,5 %', 1),
(4, 2, 'a) 50 %', 0),
(5, 2, 'b) 49,5 %', 1),
(6, 2, 'c) 50,5 %', 0),
(7, 3, 'a) 41 %', 1),
(8, 3, 'b) 50 %', 0),
(9, 3, 'c) 47 %', 0),
(10, 4, 'a) pair', 0),
(11, 4, 'b) 6', 1),
(12, 4, 'c) 2', 0),
(13, 5, 'a) 4,5 %', 0),
(14, 5, 'b) 50 %', 0),
(15, 5, 'c) 15 %', 1),
(16, 6, 'a) 70 %', 0),
(17, 6, 'b) 65 %', 0),
(18, 6, 'c) 30 %', 1),
(19, 7, 'a) 65 %', 1),
(20, 7, 'b) 21 %', 0),
(21, 7, 'c) 19,5 %', 0),
(22, 8, 'a) 3 %', 0),
(23, 8, 'b) 10 %', 1),
(24, 8, 'c) 4,5 %', 0),
(25, 9, 'a) 20 %', 1),
(26, 9, 'b) 12,1 %', 0),
(27, 9, 'c) 21 %', 0),
(28, 10, 'a) un prix inchangé', 0),
(29, 10, 'b) une augmentation de 1 %', 0),
(30, 10, 'c) une baisse de 1 %', 1);

-- --------------------------------------------------------

--
-- Structure de la table `GROUPEQUEST`
--

CREATE TABLE `GROUPEQUEST` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(100) NOT NULL,
  `ENONCE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `GROUPEQUEST`
--

INSERT INTO `GROUPEQUEST` (`ID`, `NOM`, `ENONCE`) VALUES
(1, 'I', 'On lance 200 fois un dé pipé. Le tableau ci-dessous donne le nombre d\'apparitions de chaque numéro. On admet la stabilité des résultats si on procède à d\'autres jets. '),
(2, 'II', 'Dans une population de lycéens, 30 % font du sport hors du lycée. Parmi les sportifs, 15 % font du volley, 20 % de la natation, et 5 % font à la fois du volley et de la natation. Alors, le pourcentage de lycéens faisant : '),
(3, 'III', 'On s\'intéresse aux variations de prix d\'un produit donné. ');

-- --------------------------------------------------------

--
-- Structure de la table `QUESTION`
--

CREATE TABLE `QUESTION` (
  `ID` int(11) NOT NULL,
  `IDGROUPEQUEST` int(11) DEFAULT NULL,
  `ENONCE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `QUESTION`
--

INSERT INTO `QUESTION` (`ID`, `IDGROUPEQUEST`, `ENONCE`) VALUES
(1, 1, 'Le pourcentage d\'apparition d\'un numéro pair est : '),
(2, 1, 'Le pourcentage d\'apparition d\'un numéro impair est :'),
(3, 1, 'Le pourcentage d\'apparition d\'un numéro supérieur ou égal à 4 est : '),
(4, 1, 'Le numéro qui apparaît le plus souvent est : '),
(5, 2, 'du volley hors du lycée est : '),
(6, 2, 'aucun sport hors du lycée est : '),
(7, 2, 'un sport mais ni volley, ni natation est : '),
(8, 2, 'du volley, mais pas de natation est : '),
(9, 3, 'Deux augmentations successives de 10 % donnent une augmentation de : '),
(10, 3, 'Une augmentation de 10 % puis une baisse de 10 % donnent : ');

-- --------------------------------------------------------

--
-- Structure de la table `REPONSE`
--

CREATE TABLE `REPONSE` (
  `ID` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) DEFAULT NULL,
  `IDCHOIX` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `UTILISATEUR`
--

CREATE TABLE `UTILISATEUR` (
  `ID` int(11) NOT NULL,
  `NOM` varchar(100) NOT NULL,
  `PRENOM` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `MDP` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `UTILISATEUR`
--

INSERT INTO `UTILISATEUR` (`ID`, `NOM`, `PRENOM`, `EMAIL`, `MDP`) VALUES
(1, 'RAKOTO', 'Koto', 'Koto@gmail.com', '8dcc4c95e994519ac6161a8a692110fc55e0a6f8');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `CHOIX`
--
ALTER TABLE `CHOIX`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDQUESTION` (`IDQUESTION`);

--
-- Index pour la table `GROUPEQUEST`
--
ALTER TABLE `GROUPEQUEST`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `QUESTION`
--
ALTER TABLE `QUESTION`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDGROUPEQUEST` (`IDGROUPEQUEST`);

--
-- Index pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDUTILISATEUR` (`IDUTILISATEUR`),
  ADD KEY `IDCHOIX` (`IDCHOIX`);

--
-- Index pour la table `UTILISATEUR`
--
ALTER TABLE `UTILISATEUR`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `ADMINISTRATEUR`
--
ALTER TABLE `ADMINISTRATEUR`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `CHOIX`
--
ALTER TABLE `CHOIX`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `GROUPEQUEST`
--
ALTER TABLE `GROUPEQUEST`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `QUESTION`
--
ALTER TABLE `QUESTION`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `UTILISATEUR`
--
ALTER TABLE `UTILISATEUR`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `CHOIX`
--
ALTER TABLE `CHOIX`
  ADD CONSTRAINT `CHOIX_ibfk_1` FOREIGN KEY (`IDQUESTION`) REFERENCES `QUESTION` (`ID`);

--
-- Contraintes pour la table `QUESTION`
--
ALTER TABLE `QUESTION`
  ADD CONSTRAINT `QUESTION_ibfk_1` FOREIGN KEY (`IDGROUPEQUEST`) REFERENCES `GROUPEQUEST` (`ID`);

--
-- Contraintes pour la table `REPONSE`
--
ALTER TABLE `REPONSE`
  ADD CONSTRAINT `REPONSE_ibfk_1` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `UTILISATEUR` (`ID`),
  ADD CONSTRAINT `REPONSE_ibfk_2` FOREIGN KEY (`IDCHOIX`) REFERENCES `CHOIX` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
