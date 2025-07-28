-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 juil. 2025 à 14:44
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vehicule`
--

-- --------------------------------------------------------

--
-- Structure de la table `color`
--

CREATE TABLE `color` (
  `Id_color` int(11) NOT NULL,
  `name_color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `color`
--

INSERT INTO `color` (`Id_color`, `name_color`) VALUES
(1, 'red'),
(2, 'blue'),
(3, 'purple'),
(4, 'black'),
(6, 'yellow'),
(8, 'white'),
(9, 'orange'),
(12, 'brown');

-- --------------------------------------------------------

--
-- Structure de la table `type_vl`
--

CREATE TABLE `type_vl` (
  `Id_typeVL` int(11) NOT NULL,
  `name_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_vl`
--

INSERT INTO `type_vl` (`Id_typeVL`, `name_type`) VALUES
(12, 'DS3'),
(13, 'MEGANE'),
(14, 'AUDI A3'),
(15, 'PEUGEOT 3008'),
(16, 'Renault 5'),
(21, 'Alpha Roméo');

-- --------------------------------------------------------

--
-- Structure de la table `vl`
--

CREATE TABLE `vl` (
  `Id_VL` int(11) NOT NULL,
  `immatriculation` varchar(15) NOT NULL,
  `Id_typeVL` int(11) NOT NULL,
  `Id_color` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vl`
--

INSERT INTO `vl` (`Id_VL`, `immatriculation`, `Id_typeVL`, `Id_color`) VALUES
(8, 'DG-266-ZN', 12, 1),
(9, 'AA-365-KK', 13, 4),
(11, 'AA-222-BB', 14, 4),
(13, 'AA-444-BB', 13, 4),
(14, 'AA-555-BB', 15, 1),
(40, 'TT-555-MM', 12, 3),
(41, 'VV-888-XX', 15, 6),
(42, 'PP-562-MM', 21, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`Id_color`);

--
-- Index pour la table `type_vl`
--
ALTER TABLE `type_vl`
  ADD PRIMARY KEY (`Id_typeVL`);

--
-- Index pour la table `vl`
--
ALTER TABLE `vl`
  ADD PRIMARY KEY (`Id_VL`),
  ADD KEY `FK_vl_id_type_vehicule_type_vl` (`Id_typeVL`),
  ADD KEY `FK_vl_id_color_color` (`Id_color`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `color`
--
ALTER TABLE `color`
  MODIFY `Id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `type_vl`
--
ALTER TABLE `type_vl`
  MODIFY `Id_typeVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `vl`
--
ALTER TABLE `vl`
  MODIFY `Id_VL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `vl`
--
ALTER TABLE `vl`
  ADD CONSTRAINT `FK_vehicule_id_type_vehicule_type_vehicule` FOREIGN KEY (`Id_typeVL`) REFERENCES `type_vl` (`Id_typeVL`),
  ADD CONSTRAINT `FK_vl_id_color_color` FOREIGN KEY (`Id_color`) REFERENCES `color` (`Id_color`),
  ADD CONSTRAINT `FK_vl_id_type_vehicule_type_vl` FOREIGN KEY (`Id_typeVL`) REFERENCES `type_vl` (`Id_typeVL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
