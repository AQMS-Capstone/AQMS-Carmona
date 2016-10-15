-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2016 at 06:21 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aqms`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `a_id` bigint(20) NOT NULL,
  `a_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`a_id`, `a_name`) VALUES
(1, 'SLEX Carmona Exit, Cavite'),
(2, 'Bancal, Carmona, Cavite');

-- --------------------------------------------------------

--
-- Table structure for table `elements`
--

CREATE TABLE `elements` (
  `e_id` bigint(20) NOT NULL,
  `e_name` text NOT NULL,
  `e_symbol` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `elements`
--

INSERT INTO `elements` (`e_id`, `e_name`, `e_symbol`) VALUES
(1, 'Carbon Monoxide', 'CO'),
(2, 'Sulfur Dioxide', 'SO2'),
(3, 'Nitrogen Dioxide', 'NO2'),
(4, 'Ozone', 'O3'),
(5, 'Particulate Matter 2.5', 'PM 2.5'),
(6, 'Particulate Matter 10', 'PM 10');

-- --------------------------------------------------------

--
-- Table structure for table `master`
--

CREATE TABLE `master` (
  `m_id` bigint(20) NOT NULL,
  `a_id` bigint(20) NOT NULL,
  `e_id` bigint(20) NOT NULL,
  `concentLevel` bigint(20) NOT NULL,
  `dateUpdated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `elements`
--
ALTER TABLE `elements`
  ADD PRIMARY KEY (`e_id`);

--
-- Indexes for table `master`
--
ALTER TABLE `master`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `a_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `elements`
--
ALTER TABLE `elements`
  MODIFY `e_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `master`
--
ALTER TABLE `master`
  MODIFY `m_id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
