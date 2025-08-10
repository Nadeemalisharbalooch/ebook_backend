-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2025 at 09:44 AM
-- Server version: 8.0.42
-- PHP Version: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dc_dashboard_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` mediumint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `translations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `wikiDataId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Rapid API GeoDB Cities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name`, `translations`, `created_at`, `updated_at`, `flag`, `wikiDataId`) VALUES
(1, 'Africa', '{\"br\":\"Afrika\",\"ko\":\"아프리카\",\"pt-BR\":\"África\",\"pt\":\"África\",\"nl\":\"Afrika\",\"hr\":\"Afrika\",\"fa\":\"آفریقا\",\"de\":\"Afrika\",\"es\":\"África\",\"fr\":\"Afrique\",\"ja\":\"アフリカ\",\"it\":\"Africa\",\"zh-CN\":\"非洲\",\"tr\":\"Afrika\",\"ru\":\"Африка\",\"uk\":\"Африка\",\"pl\":\"Afryka\"}', '2023-08-14 10:41:03', '2023-08-14 10:41:03', 1, 'Q15'),
(2, 'Americas', '{\"br\":\"Amerika\",\"ko\":\"아메리카\",\"pt-BR\":\"América\",\"pt\":\"América\",\"nl\":\"Amerika\",\"hr\":\"Amerika\",\"fa\":\"قاره آمریکا\",\"de\":\"Amerika\",\"es\":\"América\",\"fr\":\"Amérique\",\"ja\":\"アメリカ州\",\"it\":\"America\",\"zh-CN\":\"美洲\",\"tr\":\"Amerika\",\"ru\":\"Америка\",\"uk\":\"Америка\",\"pl\":\"Ameryka\"}', '2023-08-14 10:41:03', '2024-06-16 04:09:55', 1, 'Q828'),
(3, 'Asia', '{\"br\":\"Azia\",\"ko\":\"아시아\",\"pt-BR\":\"Ásia\",\"pt\":\"Ásia\",\"nl\":\"Azië\",\"hr\":\"Ázsia\",\"fa\":\"آسیا\",\"de\":\"Asien\",\"es\":\"Asia\",\"fr\":\"Asie\",\"ja\":\"アジア\",\"it\":\"Asia\",\"zh-CN\":\"亚洲\",\"tr\":\"Asya\",\"ru\":\"Азия\",\"uk\":\"Азія\",\"pl\":\"Azja\"}', '2023-08-14 10:41:03', '2023-08-14 10:41:03', 1, 'Q48'),
(4, 'Europe', '{\"br\":\"Europa\",\"ko\":\"유럽\",\"pt-BR\":\"Europa\",\"pt\":\"Europa\",\"nl\":\"Europa\",\"hr\":\"Európa\",\"fa\":\"اروپا\",\"de\":\"Europa\",\"es\":\"Europa\",\"fr\":\"Europe\",\"ja\":\"ヨーロッパ\",\"it\":\"Europa\",\"zh-CN\":\"欧洲\",\"tr\":\"Avrupa\",\"ru\":\"Европа\",\"uk\":\"Європа\",\"pl\":\"Europa\"}', '2023-08-14 10:41:03', '2023-08-14 10:41:03', 1, 'Q46'),
(5, 'Oceania', '{\"br\":\"Okeania\",\"ko\":\"오세아니아\",\"pt-BR\":\"Oceania\",\"pt\":\"Oceania\",\"nl\":\"Oceanië en Australië\",\"hr\":\"Óceánia és Ausztrália\",\"fa\":\"اقیانوسیه\",\"de\":\"Ozeanien und Australien\",\"es\":\"Oceanía\",\"fr\":\"Océanie\",\"ja\":\"オセアニア\",\"it\":\"Oceania\",\"zh-CN\":\"大洋洲\",\"tr\":\"Okyanusya\",\"ru\":\"Океания\",\"uk\":\"Океанія\",\"pl\":\"Oceania\"}', '2023-08-14 10:41:03', '2023-08-14 10:41:03', 1, 'Q55643'),
(6, 'Polar', '{\"br\":\"Antartika\",\"ko\":\"남극\",\"pt-BR\":\"Antártida\",\"pt\":\"Antártida\",\"nl\":\"Antarctica\",\"hr\":\"Antarktika\",\"fa\":\"جنوبگان\",\"de\":\"Antarktika\",\"es\":\"Antártida\",\"fr\":\"Antarctique\",\"ja\":\"南極大陸\",\"it\":\"Antartide\",\"zh-CN\":\"南極洲\",\"tr\":\"Antarktika\",\"ru\":\"Антарктика\",\"uk\":\"Антарктика\",\"pl\":\"Antarktyka\"}', '2023-08-14 10:41:03', '2024-06-16 04:20:26', 1, 'Q51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
