-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 23 Wrz 2010, 09:44
-- Wersja serwera: 5.1.41
-- Wersja PHP: 5.2.6-1+lenny9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `sales`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `idaddress` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(100) COLLATE utf8_polish_ci DEFAULT NULL,
  `zipcode` varchar(6) COLLATE utf8_polish_ci DEFAULT NULL,
  `street` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `billing` tinyint(1) DEFAULT NULL,
  `shipping` tinyint(1) DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`idaddress`),
  KEY `client_id_idx` (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=67 ;

--
-- Zrzut danych tabeli `addresses`
--

INSERT INTO `addresses` (`idaddress`, `city`, `zipcode`, `street`, `billing`, `shipping`, `client_id`) VALUES
(14, 'Ciechanów', '06-400', 'Płocka 1A', 1, NULL, 1),
(15, 'Warszawa', '06-300', 'Warszawska 4', 0, NULL, 1),
(32, 'Barlinek', '72-010', 'baranowska', 1, NULL, 2),
(52, 'barlinek', '05-555', 'barlinkowa', 0, NULL, 2),
(62, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Police', '05-478', 'Brązowa', 1, NULL, 19),
(66, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `idclients` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `lastname` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `tel` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `www` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `target` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idclients`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=20 ;

--
-- Zrzut danych tabeli `clients`
--

INSERT INTO `clients` (`idclients`, `name`, `lastname`, `tel`, `email`, `www`, `note`, `target`) VALUES
(1, 'Jan', 'Kowalski', '515000555', 'jan@kowalski.pl', '', NULL, 0),
(2, 'Barlinecki Ośrodek Kultury', '', '943632230', 'coalas@o2.pl', 'www.dokdarlowo.pl', NULL, 0),
(19, 'Karol', 'Nowak', '333258741', 'qqqq@r.pl', '', NULL, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `idemails` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(200) COLLATE utf8_polish_ci DEFAULT NULL,
  `body` text COLLATE utf8_polish_ci,
  `adddate` datetime DEFAULT NULL,
  PRIMARY KEY (`idemails`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=19 ;

--
-- Zrzut danych tabeli `emails`
--

INSERT INTO `emails` (`idemails`, `subject`, `body`, `adddate`) VALUES
(1, 'email testowy', '<p>&nbsp;<img title=\\"Logo\\" src=\\"../media/logo.jpg\\" alt=\\"Logo\\" width=\\"53\\" height=\\"53\\" /></p>\r\n<p>foto</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', '2010-09-23 09:12:36'),
(10, 'test', '<p>test</p>', '2010-09-23 09:13:09'),
(17, 'Re: zlecenie', '<p>&nbsp;</p>\r\n<p>Wiadomosc</p>\r\n<p>&nbsp;</p>', '2010-09-23 09:13:29');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `email_package`
--

CREATE TABLE IF NOT EXISTS `email_package` (
  `idemailpackage` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` text COLLATE utf8_polish_ci,
  `address` text COLLATE utf8_polish_ci,
  `email_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idemailpackage`,`email_id`),
  KEY `email_package_email_id_emails_idemails` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=33 ;

--
-- Zrzut danych tabeli `email_package`
--

INSERT INTO `email_package` (`idemailpackage`, `recipient`, `address`, `email_id`) VALUES
(1, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(2, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(3, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(4, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(5, 'Miejski Ośrodek Kultury ', 'coalas@o2.pl', 1),
(6, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(7, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(8, 'Karol Nowak', 'qqqq@r.pl', 1),
(9, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(10, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(11, 'Karol Nowak', 'qqqq@r.pl', 1),
(12, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(13, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(14, 'Karol Nowak', 'qqqq@r.pl', 1),
(15, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(16, 'Karol Nowak', 'qqqq@r.pl', 1),
(17, 'Karol Nowak', 'qqqq@r.pl', 1),
(18, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(19, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(20, 'Jan Kowalski', 'jan@kowalski.pl', 1),
(21, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 1),
(22, 'Karol Nowak', 'qqqq@r.pl', 1),
(23, 'Karol Nowak', 'qqqq@r.pl', 1),
(24, 'Karol Nowak', 'qqqq@r.pl', 1),
(25, 'Karol Nowak', 'qqqq@r.pl', 1),
(26, 'Karol Nowak', 'qqqq@r.pl', 1),
(27, 'Karol Nowak', 'qqqq@r.pl', 1),
(28, 'Karol Nowak', 'qqqq@r.pl', 1),
(31, 'Karol Nowak', 'qqqq@r.pl', 10),
(32, 'Barlinecki Ośrodek Kultury ', 'coalas@o2.pl', 17);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `idorders` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(15) COLLATE utf8_polish_ci DEFAULT NULL,
  `payment` bigint(20) DEFAULT NULL,
  `orderstatus` bigint(20) DEFAULT NULL,
  `adddate` datetime DEFAULT NULL,
  `senddate` datetime DEFAULT NULL,
  `packingcost` decimal(18,2) DEFAULT NULL,
  `shippingcost` decimal(18,2) DEFAULT NULL,
  `sendreceipt` tinyint(1) DEFAULT NULL,
  `sendinfo` tinyint(1) DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`idorders`),
  KEY `client_id_idx` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `orders`
--


--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`idclients`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `email_package`
--
ALTER TABLE `email_package`
  ADD CONSTRAINT `email_package_email_id_emails_idemails` FOREIGN KEY (`email_id`) REFERENCES `emails` (`idemails`);

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_client_id_clients_idclients` FOREIGN KEY (`client_id`) REFERENCES `clients` (`idclients`);
