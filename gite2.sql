-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 09:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gite2`
--

-- --------------------------------------------------------

--
-- Table structure for table `appartiene`
--

CREATE TABLE `appartiene` (
  `u_id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL,
  `gestisce` tinyint(1) NOT NULL,
  `approvato` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appartiene`
--

INSERT INTO `appartiene` (`u_id`, `g_id`, `gestisce`, `approvato`) VALUES
(1, 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gita`
--

CREATE TABLE `gita` (
  `id` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `m_id` int(11) NOT NULL,
  `max-partecipanti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gita`
--

INSERT INTO `gita` (`id`, `nome`, `data_inizio`, `data_fine`, `m_id`, `max-partecipanti`) VALUES
(1, 'Gita fine anno Terze', '2025-04-15', '2025-04-18', 4, 50),
(2, 'Gita quinte', '2025-04-20', '2025-04-24', 1, 40),
(3, 'Erasmus', '2025-05-06', '2025-05-20', 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `include`
--

CREATE TABLE `include` (
  `g_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `include`
--

INSERT INTO `include` (`g_id`, `t_id`) VALUES
(2, 1),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `meta`
--

CREATE TABLE `meta` (
  `id` int(11) NOT NULL,
  `citta` varchar(58) NOT NULL,
  `prezzo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meta`
--

INSERT INTO `meta` (`id`, `citta`, `prezzo`) VALUES
(1, 'Barcellona', 400),
(2, 'Berlino', 350),
(3, 'Roma', 200),
(4, 'Napoli', 275),
(5, 'Dublino', 300);

-- --------------------------------------------------------

--
-- Table structure for table `recensione`
--

CREATE TABLE `recensione` (
  `id` int(11) NOT NULL,
  `testo` text NOT NULL,
  `stelle` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `gita_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `id` int(11) NOT NULL,
  `citta` varchar(58) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `prezzo` double NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`id`, `citta`, `nome`, `prezzo`, `descrizione`) VALUES
(1, 'Barcellona', 'Giro Sagrada Familia', 40, 'Giro dentro alla Sagrada Familia con guida. Durata circa 1h'),
(2, 'Berlino', 'Memoriale agli Ebrei d\'Europa', 0, 'Visita al memoriale degli Ebrei uccisi d\'europa'),
(3, 'Berlino', 'Visita Zoo', 16, 'Visita dentro allo Zoologischer Garten. Circa mezza giornata'),
(4, '', 'Dublin walking tour', 10, 'Walking tour del centro storico di Dublino. Durata 1h');

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(35) NOT NULL,
  `classe` char(3) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `classe`, `email`, `password`) VALUES
(1, 'Davide', 'Passantino', '5Ai', 'davide.passantino@itismajo.school', 'davide'),
(2, 'Cosmin', 'Amelian', '5Ai', 'cosmin.amelian@itismajo.school', 'cosmin'),
(3, 'Aurora', 'Porpiglia', '3Bb', 'aurora.porpiglia@itismajo.school', 'aurora'),
(4, 'Stefano', 'Marchese', 'PRF', 'stefano.marchese.majorana@gmail.com', 'marchez'),
(5, 'test', 'test', 'TST', 'test', 'test'),
(6, 'Alessandro', 'Porpiglia', '5Ai', 'alessandro.porpiglia@itismajo.school', 'ale');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appartiene`
--
ALTER TABLE `appartiene`
  ADD KEY `u_id` (`u_id`),
  ADD KEY `g_id` (`g_id`);

--
-- Indexes for table `gita`
--
ALTER TABLE `gita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id` (`m_id`);

--
-- Indexes for table `include`
--
ALTER TABLE `include`
  ADD KEY `g_id_fk` (`g_id`),
  ADD KEY `fk_t_id` (`t_id`);

--
-- Indexes for table `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gita`
--
ALTER TABLE `gita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meta`
--
ALTER TABLE `meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recensione`
--
ALTER TABLE `recensione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartiene`
--
ALTER TABLE `appartiene`
  ADD CONSTRAINT `g_id` FOREIGN KEY (`g_id`) REFERENCES `gita` (`id`),
  ADD CONSTRAINT `u_id` FOREIGN KEY (`u_id`) REFERENCES `utente` (`id`);

--
-- Constraints for table `gita`
--
ALTER TABLE `gita`
  ADD CONSTRAINT `m_id` FOREIGN KEY (`m_id`) REFERENCES `meta` (`id`);

--
-- Constraints for table `include`
--
ALTER TABLE `include`
  ADD CONSTRAINT `fk_t_id` FOREIGN KEY (`t_id`) REFERENCES `tour` (`id`),
  ADD CONSTRAINT `g_id_fk` FOREIGN KEY (`g_id`) REFERENCES `gita` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
