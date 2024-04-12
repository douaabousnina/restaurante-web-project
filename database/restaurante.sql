-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 avr. 2024 à 21:44
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
-- Base de données : `restaurante`
--

-- --------------------------------------------------------

--
-- Structure de la table `meals`
--

CREATE TABLE `meals` (
  `meal_id` int(11) NOT NULL,
  `meal_name` varchar(255) NOT NULL,
  `meal_price` decimal(10,2) NOT NULL,
  `meal_image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `meals`
--

INSERT INTO `meals` (`meal_id`, `meal_name`, `meal_price`, `meal_image_url`) VALUES
(6, 'Burger', 33.00, 'https://cdn.pixabay.com/photo/2023/05/29/17/01/hamburger-8026582_640.jpg'),
(7, 'Salade César', 12.50, 'https://cdn.pixabay.com/photo/2017/03/19/14/59/italian-salad-2156719_640.jpg'),
(8, 'Pizza Margherita', 11.95, 'https://cdn.pixabay.com/photo/2017/09/30/15/10/plate-2802332_640.jpg'),
(9, 'Grilled Salmon', 18.99, 'https://cdn.pixabay.com/photo/2014/11/05/15/57/salmon-518032_640.jpg'),
(11, 'Vegetable Stir-Fry', 10.99, 'https://cdn.pixabay.com/photo/2018/03/18/20/06/vegetables-3238149_640.jpg'),
(12, 'Fish Tacos', 17.99, 'https://cdn.pixabay.com/photo/2017/05/31/03/31/fish-tacos-2358938_640.jpg'),
(13, 'Shrimp Scampi', 60.99, 'https://cdn.pixabay.com/photo/2014/01/06/18/46/spaghetti-239563_640.jpg'),
(14, 'Greek Salad', 10.00, 'https://cdn.pixabay.com/photo/2017/01/09/20/23/pasta-salad-1967501_640.jpg'),
(15, 'Ojja', 13.00, 'https://cdn.pixabay.com/photo/2017/11/16/18/51/kagyana-2955466_1280.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `meal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `order_status`, `meal_id`, `user_id`) VALUES
(42, '2024-04-12', 'Pending', 14, 32),
(43, '2024-04-12', 'Pending', 12, 32),
(44, '2024-04-12', 'Pending', 6, 32);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_surname` varchar(40) NOT NULL,
  `user_age` int(10) UNSIGNED NOT NULL,
  `user_login` varchar(40) NOT NULL,
  `user_password` varchar(600) NOT NULL,
  `user_role` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_surname`, `user_age`, `user_login`, `user_password`, `user_role`) VALUES
(29, 'admin@gmail.com', 'admin', 23, 'admin', '$2y$10$3YHL9THxFhv0DOFNGHlMheU1mpv2N/IUMEkaEZXqRW/c9JWFgSM6e', 1),
(31, 'douaa.bousnina2@gmail.com', 'Douaa', 21, 'do333', '$2y$10$0kt8eV/f1NZ6pRnK.tpo0en4RudBx4S3CH0PW3edDutDXDgBNL5n6', 0),
(32, 'zakaria@gmail.com', 'Zakaria', 23, 'zekzek', '$2y$10$Q0qBuQq4942WaMeSywO/uuWcKpkUIvD7TXf02aL/B58udJnNASO/y', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `meals`
--
ALTER TABLE `meals`
  ADD PRIMARY KEY (`meal_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `meal_id` (`meal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `meals`
--
ALTER TABLE `meals`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`meal_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
  ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
