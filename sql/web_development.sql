-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2016 at 11:10 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_development`
--
CREATE DATABASE IF NOT EXISTS `web_development` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `web_development`;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_entry_type` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `id_user`, `id_entry_type`, `date`, `start_time`, `end_time`) VALUES
(1, 2, 1, '2016-11-01', '09:00:00', '12:00:00'),
(2, 2, 1, '2016-11-01', '14:00:00', '16:00:00'),
(3, 2, 1, '2016-11-08', '11:00:00', '12:00:00'),
(4, 2, 1, '2016-11-08', '13:00:00', '16:00:00'),
(5, 2, 2, '2016-11-09', '14:00:00', '16:00:00'),
(6, 2, 1, '2016-11-10', '14:00:00', '15:00:00'),
(7, 2, 3, '2016-11-11', '16:00:00', '17:00:00'),
(8, 2, 4, '2016-11-14', '08:00:00', '12:00:00'),
(9, 2, 3, '2016-11-15', '16:00:00', '17:00:00'),
(10, 2, 1, '2016-11-16', '12:00:00', '17:00:00'),
(11, 2, 3, '2016-11-17', '10:00:00', '12:00:00'),
(12, 1, 1, '2016-11-01', '09:00:00', '12:00:00'),
(13, 1, 1, '2016-11-01', '14:00:00', '16:00:00'),
(14, 1, 1, '2016-11-08', '11:00:00', '12:00:00'),
(15, 1, 1, '2016-11-08', '13:00:00', '16:00:00'),
(16, 1, 2, '2016-11-09', '14:00:00', '16:00:00'),
(19, 2, 1, '2016-11-24', '05:00:00', '08:00:00'),
(20, 2, 3, '2016-11-24', '13:00:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `entry_types`
--

CREATE TABLE `entry_types` (
  `id` int(11) NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entry_types`
--

INSERT INTO `entry_types` (`id`, `description`) VALUES
(1, 'Produção de Conteúdo'),
(2, 'Versionamento'),
(3, 'Capacitação'),
(4, 'Empréstimo');

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_status_periods` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `id_user`, `id_status_periods`, `start_date`, `end_date`) VALUES
(1, 1, 2, '2016-11-01', '2016-11-30'),
(2, 2, 2, '2016-11-01', '2016-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `description`) VALUES
(1, 'Trabalhador'),
(2, 'Coordenador de Curso'),
(3, 'Coordenador do Núcleo Pedagógico');

-- --------------------------------------------------------

--
-- Table structure for table `status_periods`
--

CREATE TABLE `status_periods` (
  `id` int(11) NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `status_periods`
--

INSERT INTO `status_periods` (`id`, `description`) VALUES
(1, 'Iniciado'),
(2, 'Encaminhado para o coordenador do curso'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'User Test', 'test@test.com', '123'),
(2, 'Ricardo Linck', 'ricardo.linck@live.com', '321');

-- --------------------------------------------------------

--
-- Table structure for table `users_profiles`
--

CREATE TABLE `users_profiles` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_profile` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users_profiles`
--

INSERT INTO `users_profiles` (`id`, `id_user`, `id_profile`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_entry_users` (`id_user`),
  ADD KEY `FK_entry_entry_types` (`id_entry_type`);

--
-- Indexes for table `entry_types`
--
ALTER TABLE `entry_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_periods_users` (`id_user`),
  ADD KEY `FK_periods_status_periods` (`id_status_periods`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_periods`
--
ALTER TABLE `status_periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_profiles_users` (`id_user`),
  ADD KEY `fk_users_profiles_profiles` (`id_profile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `entry_types`
--
ALTER TABLE `entry_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `status_periods`
--
ALTER TABLE `status_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users_profiles`
--
ALTER TABLE `users_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `FK_entry_entry_types` FOREIGN KEY (`id_entry_type`) REFERENCES `entry_types` (`id`),
  ADD CONSTRAINT `FK_entry_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `periods`
--
ALTER TABLE `periods`
  ADD CONSTRAINT `FK_periods_status_periods` FOREIGN KEY (`id_status_periods`) REFERENCES `status_periods` (`id`),
  ADD CONSTRAINT `FK_periods_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
