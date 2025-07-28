-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 juil. 2025 à 14:53
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
-- Base de données : `library`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id_author` int(11) NOT NULL,
  `name_author` varchar(100) NOT NULL,
  `first_name_author` varchar(100) NOT NULL,
  `birth_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id_author`, `name_author`, `first_name_author`, `birth_date`) VALUES
(1, 'Orwell', 'George', '1903-06-25'),
(2, 'de Saint-Exupéry', 'Antoine', '1900-06-29'),
(3, 'Camus', 'Albert', '1913-11-07'),
(4, 'Austen', 'Jane', '1775-12-16'),
(5, 'Hugo', 'Victor', '1802-02-26'),
(6, 'Eco', 'Umberto', '1932-01-05'),
(7, 'Morrison', 'Toni', '1931-02-18'),
(8, 'Proust', 'Marcel', '1871-07-10'),
(9, 'García Márquez', 'Gabriel', '1927-03-06'),
(10, 'Huxley', 'Aldous', '1894-07-26'),
(11, 'Flaubert', 'Gustave', '1821-12-12'),
(12, 'Brontë', 'Charlotte', '1816-04-21'),
(13, 'Baudelaire', 'Charles', '1821-04-09'),
(14, 'Lee', 'Harper', '1926-04-28'),
(16, 'Tolstoï', 'Léon', '1928-08-28'),
(17, 'Spinoza', 'Baruch', '1632-11-24');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id_book` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `publication_date` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id_book`, `title`, `publication_date`, `id_type`, `id_author`, `disponible`) VALUES
(1, '1984', 1949, 1, 1, 1),
(2, 'Le Petit Prince', 1943, 2, 2, 0),
(3, 'L’Étranger', 1942, 3, 3, 1),
(4, 'Orgueil et Préjugés', 1813, 4, 4, 1),
(5, 'Les Misérables', 1862, 5, 5, 0),
(6, 'Le Nom de la rose', 1980, 6, 6, 1),
(7, 'Beloved', 1987, 7, 7, 1),
(8, 'Du côté de chez Swann', 1913, 8, 8, 1),
(9, 'Cent ans de solitude', 1967, 9, 9, 1),
(10, 'Le Meilleur des mondes', 1932, 10, 10, 1),
(11, 'Madame Bovary', 1857, 11, 11, 0),
(12, 'La Peste', 1947, 12, 3, 1),
(13, 'Jane Eyre', 1847, 13, 12, 1),
(14, 'Les Fleurs du mal', 1857, 14, 13, 1),
(15, 'Ne tirez pas sur l’oiseau moqueur', 1960, 15, 14, 1),
(17, 'Dans la dèche à Paris et à Londres', 1933, 5, 1, 1),
(18, 'guerre et paix', 1867, 17, 16, 1);

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE `loan` (
  `id_loan` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `loan_return` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id_type` int(11) NOT NULL,
  `name_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `name_type`) VALUES
(1, 'Dystopie, science-fiction politique'),
(2, 'Conte philosophique'),
(3, 'Roman existentialiste'),
(4, 'Roman de mœurs, comédie romantique'),
(5, 'Roman social et historique'),
(6, 'Roman historique, policier'),
(7, 'Fiction historique, réalisme magique'),
(8, 'Roman moderniste, introspectif'),
(9, 'Réalisme magique'),
(10, 'Dystopie, science-fiction'),
(11, 'Roman réaliste'),
(12, 'Roman philosophique, allégorie'),
(13, 'Roman gothique, roman d’apprentissage'),
(14, 'Poésie symboliste'),
(15, 'Roman social, roman d’apprentissage'),
(16, 'Biographie'),
(17, 'Chronique');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_inscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `name`, `firstName`, `email`, `date_inscription`) VALUES
(1, 'Alice', 'Dupont', 'alice.dupont@example.com', '2023-01-15'),
(2, 'Thomas', 'Martin', 'thomas.martin@example.com', '2023-02-01'),
(3, 'Claire', 'Bernard', 'claire.bernard@example.com', '2023-02-14'),
(4, 'Hugo', 'Lefebvre', 'hugo.lefebvre@example.com', '2023-03-05'),
(5, 'Emma', 'Moreau', 'emma.moreau@example.com', '2023-03-22'),
(6, 'Nathan', 'Petit', 'nathan.petit@example.com', '2023-04-09'),
(7, 'Léa', 'Girard', 'lea.girard@example.com', '2023-04-25'),
(8, 'Julien', 'Laurent', 'julien.laurent@example.com', '2023-05-10'),
(9, 'Camille', 'Gauthier', 'camille.gauthier@example.com', '2023-05-27'),
(10, 'Louis', 'Garcia', 'louis.garcia@example.com', '2023-06-13'),
(11, 'Manon', 'Faure', 'manon.faure@example.com', '2023-06-30'),
(12, 'Lucas', 'André', 'lucas.andre@example.com', '2023-07-12'),
(13, 'Sarah', 'Lambert', 'sarah.lambert@example.com', '2023-07-25'),
(14, 'Enzo', 'Chevalier', 'enzo.chevalier@example.com', '2023-08-08'),
(15, 'Jade', 'Roussel', 'jade.roussel@example.com', '2023-08-20');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`);

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `id_type` (`id_type`),
  ADD KEY `id_author` (`id_author`);

--
-- Index pour la table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id_loan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_book` (`id_book`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `loan`
--
ALTER TABLE `loan`
  MODIFY `id_loan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`);

--
-- Contraintes pour la table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `loan_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
