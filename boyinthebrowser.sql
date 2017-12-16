-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2017 at 09:41 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boyinthebrowser`
--

-- --------------------------------------------------------

--
-- Table structure for table `malware`
--

CREATE TABLE `malware` (
  `name` varchar(128) NOT NULL,
  `signature` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `malware`
--

INSERT INTO `malware` (`name`, `signature`) VALUES
('MyDoom', 'The&nbsp;MyDoom&nbsp'),
('Slammer', 'Slammer worms is a c'),
('Storm Worm', 'Storm Worm was a Tro'),
('Stuxtnext', 'Stuxnet is easily th'),
('Boy', 'The Boy in the Brows');

-- --------------------------------------------------------

--
-- Table structure for table `putative_malware`
--

CREATE TABLE `putative_malware` (
  `name` varchar(128) NOT NULL,
  `signature` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `putative_malware`
--

INSERT INTO `putative_malware` (`name`, `signature`) VALUES
('ILOVEYOU', 'The Love Letter Viru'),
('Crypto', 'RansomCryptolocker i'),
('Anna Kournikova', 'The Anna Kournikova');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `privilege`) VALUES
('Admin123', '4482a9c5a85d84c3ab9c73fca32dd26e', 'Admin123@gmail.com', 1),
('administrator', 'f8d6eecc50e00651ee43b94fd2010794', 'administrator@gmail.com', 1),
('Thomas', '8b4d9f8fab56135dfd93c1b9898d12e1', 'Thomas@gmail.com', 0),
('Thomas123', '8b4d9f8fab56135dfd93c1b9898d12e1', 'Thomas123@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
