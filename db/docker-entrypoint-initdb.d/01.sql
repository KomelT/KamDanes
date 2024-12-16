-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: db
-- Čas nastanka: 16. dec 2024 ob 22.02
-- Različica strežnika: 9.1.0
-- Različica PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `kamdanes`
--

-- --------------------------------------------------------

--
-- Struktura tabele `event`
--

CREATE TABLE `event` (
  `id` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `organisation` varchar(255) DEFAULT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `loc_x` double DEFAULT NULL,
  `loc_y` double DEFAULT NULL,
  `time_from` time DEFAULT NULL,
  `time_to` time DEFAULT NULL,
  `age_lim` int DEFAULT NULL,
  `description` text,
  `price` decimal(10,0) DEFAULT NULL,
  `type` int DEFAULT NULL,
  `link` text,
  `online` tinyint(1) DEFAULT NULL,
  `url_hash` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` int DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Odloži podatke za tabelo `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `name`, `phone`, `role`, `disabled`) VALUES
(100, 'UL-scraper', '1234', 'polz@fri.uni-lj.si', 'UniverzaVLjubljaniScraper', '113', 69, 0),
(101, 'Eventim-scraper', '1234', 'info@eventim.si', 'EventimScraper', '113', 69, 0),
(102, 'Metelkova-scraper', '1234', 'info@metelkova.si', 'MetelkovaScraper', '113', 69, 0),
(103, 'VisitLjubljana-scraper', '1234', 'info@visit-ljubljana.si', 'VisitLjubljanaScraper', '113', 69, 0);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_hash` (`url_hash`),
  ADD KEY `event_ibfk_1` (`id_user`);

--
-- Indeksi tabele `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `event`
--
ALTER TABLE `event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Events
CREATE DEFINER=`kamdanes`@`%` EVENT `Deleting_past_events` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-16 21:33:33' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM event WHERE (`date_to` < CURRENT_DATE()) OR (`date_from` < CURRENT_DATE() AND `date_to` IS NULL)