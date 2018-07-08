-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2016 at 12:02 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formuladb`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL,
  `caption` varchar(32) NOT NULL,
  `text` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `path` varchar(128) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `lastupdate_datetime` datetime NOT NULL,
  `declaration` tinyint(1) NOT NULL,
  `banner_type` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `caption`, `text`, `description`, `path`, `id_admin`, `creation_datetime`, `lastupdate_datetime`, `declaration`, `banner_type`) VALUES
(43, 'naslov', 'poruka', 'test', 'tpl/posts/banners/naslov-naslov.png', 18, '2016-07-17 23:24:30', '2016-07-17 23:24:30', 0, 0),
(45, 'naslovna', 'porukanaslovna', 'tst', 'tpl/posts/banners/naslovna-1.png', 18, '2016-07-17 23:26:16', '2016-07-17 23:26:16', 1, 1),
(46, 'naslov banera', 'poruka banera', 'testni opis banera', 'tpl/posts/banners/naslov-banera-1.png', 18, '2016-07-17 23:28:10', '2016-07-17 23:28:10', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE IF NOT EXISTS `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `birthdate` date NOT NULL,
  `mobile_phone` varchar(18) NOT NULL,
  `email` varchar(128) NOT NULL,
  `remark` varchar(634) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `permalink` varchar(128) NOT NULL,
  `licence` varchar(128) NOT NULL,
  `id_vehicle` int(11) NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `lastupdate_datetime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `surname`, `birthdate`, `mobile_phone`, `email`, `remark`, `id_admin`, `permalink`, `licence`, `id_vehicle`, `creation_datetime`, `lastupdate_datetime`) VALUES
(160, 'Marija', 'Marinovic', '1968-04-29', '+385 (35) 362-662', '', 'test', 18, 'images/drivers/ronaldo3-uplakan3.jpg', 'images/drivers/licences/ronaldo-1956.jpg', 74, '2016-06-12 16:48:26', '2016-06-12 16:48:26'),
(161, 'test3masta', 'tsts', '2013-04-04', '+385 (35) 362-662', '', 'dadada', 18, 'images/drivers/ronaldo2-uplakan2.jpg', 'images/drivers/licences/ronaldo-1955.jpg', 71, '2016-06-22 16:19:27', '2016-06-22 16:19:27'),
(163, 'Ivo', 'Andric', '1961-08-05', '+385 (51) 651-4651', '', 'Opis instruktora Amir', 18, 'posts/drivers/ivo-andric.jpg', 'posts/drivers/licences/ivo-1961.jpg', 73, '2016-06-27 17:59:59', '2016-06-27 17:59:59'),
(177, 'test šimun', 'dfasfa', '2011-04-04', '+385 (54) 688-4788', 'nives@mail.com', 'dadada', 18, 'tpl/posts/drivers/test-simun-dfasfa.png', 'tpl/posts/drivers/licences/test-simun-2011.png', 91, '2016-07-18 01:15:48', '2016-07-18 01:15:48'),
(178, 'Ivan', 'Ivaniš', '1966-07-29', '+385 (95) 258-7410', 'ivanis@mail.com', 'Branislav je naš dugogodišnji instruktor, uvijek spreman bodriti mladog vozača.', 18, 'tpl/posts/drivers/ivan-ivanis.jpg', 'tpl/posts/drivers/licences/ivan-1966.jpg', 92, '2016-07-18 12:17:07', '2016-07-18 12:17:07'),
(179, 'Nenad', 'Majranović', '1969-11-13', '+385 (98) 134-5678', 'nenad@mail.com', 'Mladi instruktor autoškole "Formula" s puno strpljenja za mlade neoprezne vozače.', 18, 'tpl/posts/drivers/nenad-majranovic.jpg', 'tpl/posts/drivers/licences/nenad-1969.jpg', 114, '2016-07-18 12:35:06', '2016-07-18 12:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `lastupdate_datetime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `id_admin`, `description`, `date`, `creation_datetime`, `lastupdate_datetime`) VALUES
(29, 18, 'najnovija vijest odrzava se predavanje preksutra', '2011-07-07', '2016-07-18 01:57:07', '2016-07-18 01:57:07'),
(30, 18, 'novo', '2016-08-25', '2016-07-18 02:00:55', '2016-07-18 02:00:55'),
(31, 18, 'da', '2014-04-04', '2016-07-18 02:01:54', '2016-07-18 02:01:54'),
(32, 18, 'najnovija vijest', '2016-08-08', '2016-07-18 02:02:22', '2016-07-18 02:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `licensing_categories`
--

CREATE TABLE IF NOT EXISTS `licensing_categories` (
  `id` int(11) NOT NULL,
  `label` varchar(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `min_age` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `licensing_categories`
--

INSERT INTO `licensing_categories` (`id`, `label`, `description`, `min_age`) VALUES
(1, 'A1', 'Motocikli radnog obujma motora do 125 cm3 i snage motora do 11 kW.', '16'),
(2, 'A2', 'Motocikli cija snaga ne prelazi 35 kW i ciji omjer snaga/masa ne prelazi 0,2 kW/kg, a ne potjecu od vozila ?ija je snaga dvostruko veca i vise', '18'),
(3, 'A', 'Motocikli sa ili bez bocne prikolice', '24/21'),
(4, 'B', 'kombinacija vucnog vozila u B kategoriji i priklju?nog vozila, uz uvjet da najve?a dopuštena masa priklju?nog vozila nije ve?a od mase vu?nog vozila', '18'),
(5, 'BE', 'Kombinacija vozila koja se sastoji od vu?nog vozila u B kategoriji i prikolice ?ija se kombinacija ne uklapa u B kategoriju', '18'),
(6, 'C1', 'Motorna vozila do 7.500 kg najvece dopustene mase.', '18'),
(7, 'C', 'Motorna vozila cija je najveca dopustena masa iznad 7.500 kg.', '21/18'),
(8, 'CE', 'Skupine vozila koje se sastoje od vucnoga motornog vozila C kategorije i prikljucnog vozila cija najveca dopustena masa iznosi vise od 750 kg.', '21/18'),
(9, 'AM', 'Mopedi i motokultivatori', '15'),
(10, 'C1E', 'Kombinacija vozila koja se sastoji od vucnog vozila kategorije C1/B i prikljucnog vozila s dopustenom masom do 750kg/3500kg, a najveca dopustena masa kombinacije vozila nije veca od 12000kg\n', '18'),
(11, 'D1', 'Motorna vozila projektirana za prijevoz najvise 16 putnika uz vozaca i cija maksimalna duljina nije veca od 8m; motorna vozila ove kategorije mogu se kombinirati s prikljucnim vozilom cija najveca dopustena masa nije veca od 750kg', '21'),
(12, 'D1E', 'Sastoji se od vucnog vozila D1 i njegova prikljucnog vozila koje ima najvecu dopustenu masu vc?u od 750 kg.', '21'),
(13, 'D', 'Motorna vozila ove kategorije mogu se kombinirati s prikljucnim vozilom cija najveca dopustena masa nije veca od 750 kg', '24/23/21'),
(14, 'DE', 'Kombinacija vozila koja se sastoji od vucnog vozila kategorije D i njegova prikljucnog vozila koje ima najvecu dopustenu masu vecu od 750kg', '24/23/21'),
(15, 'F', 'Traktori sa ili bez prikolice', '16'),
(16, 'G', 'Radni strojevi', '16'),
(17, 'H', 'Tramvaji', '21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(40) NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `lastupdate_datetime` datetime NOT NULL,
  `permission` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `creation_datetime`, `lastupdate_datetime`, `permission`) VALUES
(18, 'Djeljana', 'Gljet', 'test', 'test@test.com', 'd625fc319a744dd916251e56a472cfef5a98f0b2', '2016-04-24 15:34:35', '2016-04-24 15:34:35', 1),
(20, 'Franjo', 'Tudjman', 'tudjman', 'franjo@franjo.com', 'c6a69871fba99a1c1f1e0e44e2248cd953799d5a', '2016-04-26 19:34:12', '2016-04-26 19:34:12', 0),
(23, 'korisnik', 'korisnik', 'korisnik', 'korisnik12@mail.com', '4ac90e97cc0dff5bcfab7307fc975aba5cc4ba4d', '2016-04-26 20:31:52', '2016-04-26 20:31:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` int(11) NOT NULL,
  `id_licence_category` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `model` varchar(128) NOT NULL,
  `year` int(5) NOT NULL,
  `vehicle_type` tinyint(1) NOT NULL,
  `fuel_type` tinyint(3) NOT NULL,
  `manual_automatic` tinyint(1) NOT NULL,
  `engine_power` varchar(16) NOT NULL,
  `wheel_drive` tinyint(2) NOT NULL,
  `description` text NOT NULL,
  `permalink` varchar(128) NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `lastupdate_datetime` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `id_licence_category`, `id_admin`, `model`, `year`, `vehicle_type`, `fuel_type`, `manual_automatic`, `engine_power`, `wheel_drive`, `description`, `permalink`, `creation_datetime`, `lastupdate_datetime`) VALUES
(95, 1, 18, 'Kawasaki', 2009, 1, 0, 0, '11', 1, 'Opis motornog vozila Kawasaki.', 'posts/vehicles/kawasaki-2009.jpg', '2016-06-29 19:19:07', '2016-06-29 19:19:07'),
(110, 3, 18, 'dadada', 2016, 0, 0, 0, '32', 0, 'dadadada', 'tpl/posts/vehicles/dadada-2016.png', '2016-07-17 20:42:46', '2016-07-17 20:42:46'),
(112, 3, 18, 'novi modelic', 2016, 0, 0, 0, '24', 0, 'test noovo', 'tpl/posts/vehicles/novi-modelic-2016.png', '2016-07-18 01:41:47', '2016-07-18 01:41:47'),
(113, 3, 18, 'najnoviji', 2016, 0, 0, 0, '12', 0, 'dadada', 'tpl/posts/vehicles/najnoviji-2016.png', '2016-07-18 01:44:29', '2016-07-18 01:44:29'),
(114, 2, 18, 'Yamaha YBR250', 2008, 1, 0, 0, '34', 0, 'Motocikl koji je vrlo upravljiv i jednostavan za vožnju. Namjenjen je osobama koje stječu početno iskustvo na motociklu i osobama koje polažu vozački Ispit za motocikle A2 kategorije sa 18 godina.', 'tpl/posts/vehicles/yamaha-ybr250-2008.jpg', '2016-07-18 12:24:41', '2016-07-18 12:24:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `text` (`text`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_vehicle` (`id_vehicle`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `licensing_categories`
--
ALTER TABLE `licensing_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_licence_category` (`id_licence_category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=180;
--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `licensing_categories`
--
ALTER TABLE `licensing_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=115;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
