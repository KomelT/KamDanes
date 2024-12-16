CREATE TABLE user (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` int DEFAULT NULL,
  `disabled` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`)
);

CREATE TABLE event (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `organisation` varchar(255) DEFAULT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `loc_x` double DEFAULT NULL,
  `loc_y` double DEFAULT NULL,
  `time` time DEFAULT NULL,
  `age_lim` int DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `type` int DEFAULT NULL,
  `link` text DEFAULT NULL,
  `online` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
/*Tukaj se bodo dodajali scraperji. Vsakič ko se nov naredi mora dobiti svoj id*/
INSERT INTO `user`(`id`, `username`, `password`, `email`, `name`, `phone`, `role`, `disabled`) VALUES (100,'UL-scraper','1234','polz@fri.uni-lj.si','UniverzaVLjubljaniScraper', 113, 69, 0);
COMMIT;