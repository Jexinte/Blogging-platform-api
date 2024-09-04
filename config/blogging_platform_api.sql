-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 04 sep. 2024 à 20:37
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogging_platform_api`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `category`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'Introduction to SQL', 'SQL is a standard language for accessing and manipulating databases...', 'Database', 'SQL,Database,Introduction', '2024-09-01 10:00:00', '2024-09-01 10:00:00'),
(2, 'Understanding Joins in SQL', 'Joins are used to combine rows from two or more tables...', 'Database', 'SQL,Joins,Advanced', '2024-09-02 12:30:00', '2024-09-02 12:30:00'),
(3, 'Getting Started with PHP', 'PHP is a popular general-purpose scripting language...', 'Programming', 'PHP,Web,Backend', '2024-09-03 09:15:00', '2024-09-03 09:15:00'),
(4, 'Advanced PHP Techniques', 'In this article, we explore some advanced features of PHP...', 'Programming', 'PHP,Advanced,Web', '2024-09-03 14:45:00', '2024-09-03 14:45:00'),
(5, 'Introduction to REST APIs', 'REST stands for Representational State Transfer and is a web standards-based architecture...', 'Web Development', 'API,REST,Web', '2024-09-04 08:00:00', '2024-09-04 08:00:00'),
(6, 'Building Your First REST API with PHP', 'This tutorial guides you through building a REST API using PHP...', 'Web Development', 'API,REST,PHP', '2024-09-04 11:20:00', '2024-09-04 11:20:00'),
(7, 'Getting Started with JavaScript', 'JavaScript is a versatile language used for both client-side and server-side development...', 'Programming', 'JavaScript,Web,Frontend', '2024-09-04 13:50:00', '2024-09-04 13:50:00'),
(8, 'Understanding Asynchronous JavaScript', 'Asynchronous programming in JavaScript can be challenging but is crucial for responsive web applications...', 'Programming', 'JavaScript,Async,Advanced', '2024-09-04 15:00:00', '2024-09-04 15:00:00'),
(9, 'Introduction to CSS', 'CSS is used to control the style and layout of web pages...', 'Web Design', 'CSS,Design,Web', '2024-09-04 16:10:00', '2024-09-04 16:10:00'),
(10, 'Responsive Web Design with CSS', 'Responsive design ensures that your web applications look great on any device...', 'Web Design', 'CSS,Responsive,Web', '2024-09-04 18:30:00', '2024-09-04 18:30:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
