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
(101, 'Kulturnik-scraper', '1234', 'info@kulturnik.si', 'KulturnikScraper', '113', 69, 0),
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
CREATE DEFINER=`kamdanes`@`%` EVENT `Deleting_past_events` ON SCHEDULE EVERY 1 DAY STARTS '2024-12-16 21:33:33' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM event WHERE (`date_to` < CURRENT_DATE()) OR (`date_from` < CURRENT_DATE() AND `date_to` IS NULL);

INSERT INTO `event` (`id`, `id_user`, `name`, `organisation`, `artist_name`, `date_from`, `date_to`, `loc_x`, `loc_y`, `time_from`, `time_to`, `age_lim`, `description`, `price`, `type`, `link`, `online`, `url_hash`) VALUES
(1, 100, 'Uvod v podrocje zdravil za napredno zdravljenje', 'Univerza v Ljubljani', NULL, '2025-04-15', '2025-12-21', NULL, NULL, '06:00:00', '17:00:00', NULL, 'Krajse usposabljanje je namenjeno pridobitvi osnovnega znanja s podrocja zdravil za napredno zdravljenje. Tovrstna zdravila imajo izreden potencial za doseganje dolgorocnega izboljsanja ali celo ozdravitve bolezni, ki jih v tem trenutku s sinteznimi in bioloskimi zdravili se ne moremo pozdraviti.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-04-15-uvod-v-podrocje-zdravil-za-napredno-zdravljenje', 1, '898555f6ae58638aba71a5966ea7797da6232fbed41f710694815d04485f03d303b6a44ccf351d8e3ab7e26abbe5385537ddf87611f4806d600cc47701f72063'),
(2, 100, 'Kdo se boji zajcka? | Razstava UL ALUO in UL FF v Arboretumu Volcji Potok', 'Univerza v Ljubljani', NULL, '2025-07-05', '2025-12-31', 14.6066931, 46.1853004, '17:00:00', '20:00:00', NULL, 'Studentke in studenti Akademije za likovno umetnost in oblikovanje Univerze v Ljubljani  (UL ALUO) so v sodelovanju s Filozofsko fakulteto Univerze v Ljubljani  (UL FF) in Arboretumom Volcji potok pripravili razstavo s slikopisi - krajsimi literarnimi deli, namenjenimi opismenjevanju, v katerem so izbrane besede nadomescene s slicicami. \r\nOdprtje razstave bo v petek, 5. julija 2025, ob 18.00, pred Galerijo Janeza Boljke v Arboretumu Volcji potok.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-07-05-kdo-se-boji-zajcka-razstava-ul-aluo-in-ul-ff-v-arboretumu-volcji-potok', 0, 'fda55ea30b54e70f6b5e6fa4d3e118b79c62c535609f30da4a6ca8c23b136e0b9c694ead6b6dc294ef7a52708b9c393081974b2f264cfa6bc71f27186f57a695'),
(3, 100, 'Digitalno zgodovinopisje', 'Univerza v Ljubljani', NULL, '2025-10-15', '2026-01-15', 14.489393, 46.0446209, '08:00:00', '09:00:00', NULL, 'Usposabljanje se osredotoca na pridobivanje vescin in osvajanje orodij s podrocja digitalnih tehnologij ter metod za potrebe preucevanja in predstavitve preteklosti in kulturne dediscine. Udelezenke in udelezenci bodo osvojili specificna digitalna znanja in spretnosti, ki jih bodo lahko uspesno uporabili za usmerjanje digitalnega prehoda v javnih in nevladnih organizacijah.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-10-15-digitalno-zgodovinopisje', 0, 'cd1596fec149bf20191392e3bfd81c7effc58e5f323d2a86113e60e4cd6615c818b33c59d1a7d3773aa5e67f76e8118ea0cdeebe928e92a9369b246f5019941a'),
(4, 100, 'BIO28: Projekt Denton', 'Univerza v Ljubljani', NULL, '2025-11-20', '2026-01-04', 14.5033597, 46.0526878, '18:00:00', '19:00:00', NULL, 'Akademija za likovno umetnost in oblikovanje Univerze v Ljubljani (UL ALUO), Muzej za arhitekturo in oblikovanje (MAO) in Mala galerija Banke Slovenije (MGBS) v otvoritvenem tednu 28. Slovenskega bienala oblikovanja (BIO28 – Dvojna agentka: Govoris jezik roz?) vabimo na odprtje razstave studentk in studentov UL ALUO in Univerze za umetnost in oblikovanje HEAD v Zenevi (HEAD – Genève) z naslovom BIO28: Projekt Denton, ki bo v sredo, 20. novembra 2025, ob 18.00, v Mali galeriji Banke Slovenije.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-11-20-bio28-projekt-denton', 0, 'd9f3b3a8ae464c95f69e1a9e9be3920a38201e4858d99e6ede6cc586976db0df2be193b624c34c158818e0da405a99e65b58c0a1b119c8b5d649f6b9a0e38ddb'),
(5, 100, 'Dogodek Modnovanje 2025 / Za praznike smo doma', 'Univerza v Ljubljani', NULL, '2025-12-17', '2025-12-17', 14.4973801, 46.0465069, '09:00:00', '23:00:00', NULL, 'MODNOVANJE je dogodek, ki ga v decembru ze tradicionalno organiziramo na UL NTF, ko odpremo vrata nase fakultete na Snezniski 5 v Ljubljani. \r\nModnovanje bo potekalo v tednu od od 17. do 20. 12. 2025. Sam dogodek se bo odvil 17. decembra 2025 med 9. in 23. uro, razstava je na voljo za ogled od 17. do 20. 12. 2025, v casu odprtja fakultete.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-17-dogodek-modnovanje-2025-za-praznike-smo-doma', 0, 'b8d748bd21753143879f8a52a1f16c03f51feb18800c96cae34af0c8c470cfcf8b092a4aefe12e5abe2a307c0c3b0824bc391d8e0414d44100d8fb23fc678f58'),
(6, 100, 'Razstava Modnovanje 2025 / Za praznike smo doma', 'Univerza v Ljubljani', NULL, '2025-12-17', '2025-12-20', 14.4973801, 46.0465069, '09:00:00', '23:00:00', NULL, 'MODNOVANJE je dogodek, ki ga v decembru ze tradicionalno organiziramo na UL NTF, ko odpremo vrata nase fakultete na Snezniski 5 v Ljubljani. \r\nModnovanje bo potekalo v tednu od 17. do 20. 12. 2025. Razstava je na ogled od 17. do 20. 12. 2025, v casu odprtja fakultete.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-17-razstava-modnovanje-2025-za-praznike-smo-doma', 0, '1a9173d04d27c6a6bea8e74bb1bc23f9423de64c57c6b103b3d0c563c5ec00ed1303067c3bcd7141c5bc2e87f05f184548e543d36ae65fdb7caf0cf893402fbd'),
(7, 100, 'Novoletni univerzitetni ples', 'Univerza v Ljubljani', NULL, '2025-12-17', '2025-12-17', 14.4865742, 46.0494126, '18:30:00', '22:00:00', NULL, 'Univerza v Ljubljani, Center za obstudijsko dejavnost, v sodelovanju s Studentskim domom Ljubljana, vabi na novoletni univerzitetni ples, ki bo v torek, 17. decembra 2025, od 20. ure naprej v Rozni Kuhni, Svetceva 9 (plesne vaje se zacnejo o.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-17-novoletni-univerzitetni-ples', 0, 'ec38ce8a678a2c58364a87be391153972406f610d15e2a84f5d24f9f971c0b3431129219be2ca3afe92b004c822b7e6736b3107277d0c8cf0a28771e7a85cf45'),
(8, 100, 'Koncert Big bandov UL AG', 'Univerza v Ljubljani', NULL, '2025-12-18', NULL, 14.5033259, 46.0508989, '19:30:00', '19:30:00', NULL, 'Vabljeni na koncert Big bandov Akademije za glasbo Univerze v Ljubljani (UL AG).\r\nUmetniski vodja in dirigent: doc. Matej Hotko\n\r\nVstop prost.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-18-koncert-big-bandov-ul-ag', 0, '7d81dbead536b798bfb9bb851e55ab7e0aada647d383f2d358e65138c4ea62c091f3f2acc8480671906cba46b1f64a7cc08f615a44d938698c73bfb7892fb1c0'),
(9, 100, 'Modra fakulteta: Tecaj Uporaba storitve Google Photo', 'Univerza v Ljubljani', NULL, '2025-12-19', '2025-12-20', 14.5041552, 46.0491938, '16:00:00', '18:30:00', NULL, 'Prosta mesta na tecaju so zapolnjena. Lahko se prijavite na cakalno listo - pisite nam na modrafakulteta@uni-lj.si.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-19-modra-fakulteta-tecaj-uporaba-storitve-google-photo', 0, '94ffa5bd29f387b90bcbe40dfd1e95c6487a4e9f164d45817719284aad318519f5e9e88eb476833b525684433e7ff712cbc8001a688dd626665ec5d27750e534'),
(10, 100, 'kUL kviz', 'Univerza v Ljubljani', NULL, '2025-12-19', '2025-12-19', 14.5151208, 46.0514932, '19:00:00', '21:00:00', NULL, 'Praznicno obarvano druzenje bomo popestrili z zanimivimi vprasanji na kUL kvizu.', NULL, 0, 'https://www.uni-lj.si/dogodki/2025-12-19-kul-kviz', 0, '086467811bec8e43b71d22b578d219ce02a470bd09f91398ce9ed1362231e3d96f55f7b0816851d8014bcc951942e1037fd8625048e3f82a233fcf09cc17378d');