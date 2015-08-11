-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 08 aug 2015 om 12:20
-- Serverversie: 5.5.34
-- PHP-versie: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `referrals` int(10) NOT NULL,
  `rank` int(11) NOT NULL,
  `displayname` text NOT NULL,
  `email` text NOT NULL,
  `invite_url` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`displayname`, `email`, `rank`, `referrals`, `invite_url`) VALUES
('KeithLi', 'kpd20062000@yahoo.com.hk', 2803, 82, 'https://oneplus.net/ca_en/invites?kolid=5BADZG'),
('lorenzovinci19', 'lorenzovinci19@yahoo.it', 7185, 21, 'https://oneplus.net/ca_en/invites?kolid=6G3MC'),
('Gopal kedia', 'gopal.kedia009@gmail.com', 9205, 15, 'https://oneplus.net/ca_en/invites?kolid=6GCYW'),
('BjornDer', 'bjorn.derudder@gmail.com', 21743, 5, 'https://oneplus.net/ca_en/invites?kolid=WBJPAV'),
('SunnyHQ', 'zsunnyy.lv@gmail.com', 73167, 0, 'https://oneplus.net/ca_en/invites?kolid=6G3SA'),
('Gazzer2k', 'gazzer2k@yahoo.com', 245456, 0, 'https://oneplus.net/ca_en/invites?kolid=LYTKA0'),
('mato22', 'mato252@gmail.com', 2074008, 0, 'https://oneplus.net/ca_en/invites?kolid=MAHGSP'),
('Jamesst20', 'Jamesst20@gmail.com', 2443, 102, 'https://oneplus.net/ca_en/invites?kolid=AFKQRB');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
