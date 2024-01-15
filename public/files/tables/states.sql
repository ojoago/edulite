-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2024 at 06:59 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edulite_edulite`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(2) NOT NULL,
  `state` varchar(11) DEFAULT NULL,
  `zone` varchar(13) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state`, `zone`) VALUES
(1, 'Abia', 'South East'),
(2, 'Benue', 'North Central'),
(3, 'Kogi', 'North Central'),
(4, 'Kwara', 'North Central'),
(5, 'Nasarawa', 'North Central'),
(6, 'Niger', 'North Central'),
(7, 'Plateau', 'North Central'),
(8, 'F.C.T', 'North Central'),
(9, 'Adamawa', 'North East'),
(10, 'Bauchi', 'North East'),
(11, 'Borno', 'North East'),
(12, 'Gombe', 'North East'),
(13, 'Taraba', 'North East'),
(14, 'Yobe', 'North East'),
(15, 'Jigawa', 'North West'),
(16, 'Kaduna', 'North West'),
(17, 'Kano', 'North West'),
(18, 'Katsina', 'North West'),
(19, 'Kebbi', 'North West'),
(20, 'Sokoto', 'North West'),
(21, 'Zamfara', 'North West'),
(22, 'Anambra', 'South East'),
(23, 'Ebonyi', 'South East'),
(24, 'Enugu', 'South East'),
(25, 'Imo', 'South East'),
(26, 'Akwa Ibom', 'South South'),
(27, 'Cross River', 'South South'),
(28, 'Bayelsa', 'South South'),
(29, 'Rivers', 'South South'),
(30, 'Delta', 'South South'),
(31, 'Edo', 'South South'),
(32, 'Ekiti', 'South West'),
(33, 'Lagos', 'South West'),
(34, 'Ogun', 'South West'),
(35, 'Ondo', 'South West'),
(36, 'Osun', 'South West'),
(37, 'Oyo', 'South West');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
