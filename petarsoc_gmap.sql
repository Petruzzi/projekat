-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2017 at 05:42 PM
-- Server version: 10.2.8-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petarsoc_gmap`
--

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  `image_path1` varchar(255) DEFAULT NULL,
  `image_path2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `user_email`, `address`, `lat`, `lng`, `type`, `image_path1`, `image_path2`) VALUES
(33, 'fotos1992@gmail.com', 'test', 44.765751, 20.387192, 'ekocid', 'assets/img/939815welcome.png', NULL),
(32, 'pustric91@gmail.com', 'Banatska bb', 45.556599, 19.797556, 'deponija', 'assets/img/22051deponija-3---martin-martinov_660x330.jpg', NULL),
(35, 'crnamambica@gmail.com', 'aaaaa', 44.812286, 20.378609, 'ekocid', 'assets/img/122975dsc_0240.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `activationcode` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `suspend` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `activationcode`, `password`, `status`, `admin`, `suspend`) VALUES
(3, 'Petar', 'proba', 'fotos1992@gmail.com', 'f6da05af21e4064cee40d1ce76e46775', '$2y$10$ekAWlTIy74gxBfYkPU.TFOpHCoPQs..KjoDai.NYztq2CoUyVX95i', 1, 1, 0),
(1, 'stevan', 'pivnicki', 'stevan314@gmail.com', '32a7c3ee29fa526e92d55b76f0d4a446', '$2y$10$N3jwXNxj5oMpvSXeW1rQoeqKVHGVRKlivirklMIwN6w/3gUMH.3ee', 1, 1, 0),
(4, 'Dobrica', 'Damjanac', 'dobrica3@gmail.com', '1dd68ef070aa3370d5b04698b07667cb', '$2y$10$crtpYtgu9VnwArT8THI/fewG9CU9a0PDJ2nP1kz.2CSuxhcXOMGnm', 1, 0, 0),
(2, 'Bojana', 'Puštri?', 'pustric91@gmail.com', 'fea706e4b8b75860cca4b80df0cc5d11', '$2y$10$4Pwmwqsz/wzOPZt9ZgxuuuGVVnCgqROdDmdBimjLUYatlaSPr.KOy', 1, 0, 0),
(13, 'proba', 'proba', 'crnamambica@gmail.com', 'c87c0d6d3170c876a7364e7455ecf664', '$2y$10$qsKY/BjCO9PyJTlcGsjg0uF80Fsobuk2BapRscax13jXxZV5g6MLG', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
