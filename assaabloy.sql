-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 23, 2017 alle 14:21
-- Versione del server: 5.7.14
-- Versione PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assaabloy`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `rates`
--

CREATE TABLE `rates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `rates`
--

INSERT INTO `rates` (`id`, `name`, `value`) VALUES
(1, 'workRate', 22),
(2, 'travelRate', 15),
(4, 'kmCost', 0.3);

-- --------------------------------------------------------

--
-- Struttura della tabella `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `ofo` varchar(255) NOT NULL,
  `callNumber` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `interventionPlace` varchar(255) NOT NULL,
  `techNum` int(11) NOT NULL,
  `totalWHours` double NOT NULL,
  `totalTHours` double NOT NULL,
  `km` double NOT NULL,
  `fix` tinyint(1) NOT NULL,
  `WRate` double NOT NULL,
  `TRate` double NOT NULL,
  `kmRate` double NOT NULL,
  `fixRate` double NOT NULL,
  `WCost` double NOT NULL,
  `TCost` double NOT NULL,
  `kmCost` double NOT NULL,
  `fixCost` double NOT NULL,
  `totalServices` double NOT NULL,
  `spareCost` double NOT NULL,
  `transportCost` double NOT NULL,
  `totalCost` double NOT NULL,
  `insertedBy` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `report`
--

INSERT INTO `report` (`id`, `date`, `ofo`, `callNumber`, `client`, `interventionPlace`, `techNum`, `totalWHours`, `totalTHours`, `km`, `fix`, `WRate`, `TRate`, `kmRate`, `fixRate`, `WCost`, `TCost`, `kmCost`, `fixCost`, `totalServices`, `spareCost`, `transportCost`, `totalCost`, `insertedBy`) VALUES
(1, '08/11/2017', '17/05389', '17/0000005766', 'COOP', 'Rubiera', 1, 2, 3, 40, 0, 22, 15, 0.3, 0, 44, 45, 0.9, 0, 89.9, 0, 0, 89.9, 0),
(2, '08/10/2017', '17/05389', '17/0000005766', 'COOP', 'Rubiera', 1, 2, 3, 40, 0, 22, 15, 0.3, 0, 44, 45, 0.9, 0, 89.9, 0, 0, 89.9, 0),
(3, '08/07/2016', '17/05389', '17/0000005766', 'COOP', 'Rubiera', 1, 2, 3, 40, 0, 22, 15, 0.3, 0, 44, 45, 0.9, 0, 89.9, 0, 0, 89.9, 0),
(5, '13/11/2017', '17/05389', '17/0000005766', 'COOP', 'Rubiera', 1, 2, 3, 40, 0, 22, 15, 0.3, 0, 44, 45, 0.9, 0, 89.9, 0, 0, 89.9, 0),
(6, '20/11/2017', '17/05389', '17/0000005766', 'COOP', 'Rubiera', 1, 2, 3, 40, 0, 22, 15, 0.3, 0, 44, 45, 0.9, 0, 89.9, 0, 0, 89.9, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `rates`
--
ALTER TABLE `rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT per la tabella `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
