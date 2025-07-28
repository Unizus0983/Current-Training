-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 28 juil. 2025 à 07:32
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bibliotheque`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `return_book` (IN `p_loan_id` INT)   BEGIN
    DECLARE book_id INT;
    
    START TRANSACTION;
    
    -- 1. Marquer comme retourné
    UPDATE loan 
    SET returned = 1, 
        return_date = CURDATE()
    WHERE id_loan = p_loan_id;
    
    -- 2. Récupérer l'ID du livre
    SELECT id_book INTO book_id FROM loan WHERE id_loan = p_loan_id;
    
    -- 3. Mettre à jour la disponibilité
    UPDATE book SET is_available = 1 WHERE id_book = book_id;
    
    -- 4. Historique
    INSERT INTO history (id_loan, event_type) VALUES (p_loan_id, 'returned');
    
    COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id_author` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `birth_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id_author`, `last_name`, `first_name`, `birth_date`) VALUES
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
(17, 'Spinoza', 'Baruch', '1632-11-24'),
(18, 'Jovanovic', 'Pierre', '1960-01-03'),
(19, 'Christie', 'Agatha', '1890-09-15');

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id_book` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `publication_date` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id_book`, `title`, `publication_date`, `id_type`, `id_author`, `is_available`) VALUES
(1, '1984', 1949, 1, 1, 1),
(2, 'Le Petit Prince', 1943, 2, 2, 0),
(3, 'L’Étranger', 1942, 3, 3, 1),
(4, 'Orgueil et Préjugés', 1813, 4, 4, 1),
(5, 'Les Misérables', 1862, 5, 5, 1),
(6, 'Le Nom de la rose', 1980, 6, 6, 1),
(7, 'Beloved', 1987, 7, 7, 1),
(8, 'Du côté de chez Swann', 1913, 8, 8, 1),
(9, 'Cent ans de solitude', 1967, 9, 9, 1),
(10, 'Le Meilleur des mondes', 1932, 10, 10, 1),
(11, 'Madame Bovary', 1857, 11, 11, 0),
(12, 'La Peste', 1947, 12, 3, 1),
(13, 'Jane Eyre', 1847, 13, 12, 1),
(14, 'Les Fleurs du mal', 1857, 14, 13, 0),
(15, 'Ne tirez pas sur l’oiseau moqueur', 1960, 15, 14, 1),
(17, 'Dans la dèche à Paris et à Londres', 1933, 5, 1, 1),
(18, 'guerre et paix', 1867, 17, 16, 1),
(21, 'Le Crime de l\'Orient-Express', 1934, 6, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `book_type`
--

CREATE TABLE `book_type` (
  `id_type` int(11) NOT NULL,
  `name_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book_type`
--

INSERT INTO `book_type` (`id_type`, `name_type`) VALUES
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
(17, 'Chronique'),
(18, 'Theologie');

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `id_loan` int(11) NOT NULL,
  `event_type` enum('created','returned','overdue') NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `history`
--

INSERT INTO `history` (`id_history`, `id_loan`, `event_type`, `event_date`) VALUES
(1, 7, 'created', '2025-07-26 19:53:19');

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE `loan` (
  `id_loan` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `returned` tinyint(1) DEFAULT 0
) ;

--
-- Déchargement des données de la table `loan`
--

INSERT INTO `loan` (`id_loan`, `loan_date`, `return_date`, `id_user`, `id_book`, `returned`) VALUES
(2, '2025-07-25', '2025-07-26', 1, 2, 1),
(3, '2025-07-25', '2025-07-26', 5, 5, 1),
(4, '2025-07-25', NULL, 9, 11, 0),
(5, '2025-07-26', '2025-07-26', 6, 15, 1),
(6, '2025-07-26', NULL, 4, 14, 0),
(7, '2025-07-26', NULL, 5, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `registration_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `last_name`, `first_name`, `email`, `registration_date`, `is_active`) VALUES
(1, 'Dupont', 'Alice', 'alice@example.com', '2024-01-10', 1),
(2, 'Martin', 'Jean', 'jean@example.com', '2024-03-20', 1),
(3, 'Roy', 'Leïla', 'leila@example.com', '2024-05-05', 1),
(4, 'Fupont', 'Pierre', 'fupont@example.com', '2024-02-10', 1),
(5, 'Lartin', 'Jean-Marie', 'lartin@example.com', '2024-01-20', 1),
(6, 'Roy', 'Laurent', 'laurent@example.com', '2024-05-09', 1),
(7, 'Pont', 'Pierrette', 'pont@example.com', '2024-05-10', 1),
(8, 'Sartin', 'Marie', 'sartin@example.com', '2024-08-20', 1),
(9, 'Royer', 'Laurence', 'royer@example.com', '2024-05-09', 1),
(10, 'Leboulanger', 'nathalie', 'licorne.ocean@hotmail.fr', '2025-07-26', 1);

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
-- Index pour la table `book_type`
--
ALTER TABLE `book_type`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_loan` (`id_loan`);

--
-- Index pour la table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id_loan`),
  ADD UNIQUE KEY `unique_loan_per_date` (`id_user`,`id_book`,`loan_date`),
  ADD KEY `id_book` (`id_book`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `book_type`
--
ALTER TABLE `book_type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `loan`
--
ALTER TABLE `loan`
  MODIFY `id_loan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `book_type` (`id_type`),
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`id_author`) REFERENCES `author` (`id_author`);

--
-- Contraintes pour la table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_loan`) REFERENCES `loan` (`id_loan`);

--
-- Contraintes pour la table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `loan_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
