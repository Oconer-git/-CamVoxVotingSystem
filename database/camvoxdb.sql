-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2023 at 10:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camvoxdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbcandidate`
--

CREATE TABLE `tbcandidate` (
  `candidateID` int(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `posName` varchar(64) NOT NULL,
  `partyName` varchar(64) NOT NULL,
  `electioncode` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbelect`
--

CREATE TABLE `tbelect` (
  `electionID` int(32) NOT NULL,
  `electName` varchar(64) NOT NULL,
  `startDate` varchar(64) NOT NULL,
  `endDate` varchar(64) NOT NULL,
  `expTime` varchar(64) NOT NULL,
  `startTime` varchar(64) NOT NULL,
  `description` int(64) NOT NULL,
  `posterID` int(64) NOT NULL,
  `passcode` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbrecovery`
--

CREATE TABLE `tbrecovery` (
  `recoveryID` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `question1` varchar(64) NOT NULL,
  `question2` varchar(64) NOT NULL,
  `question3` varchar(64) NOT NULL,
  `question4` varchar(64) NOT NULL,
  `answer1` varchar(64) NOT NULL,
  `answer2` varchar(64) NOT NULL,
  `answer3` varchar(64) NOT NULL,
  `answer4` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbresults`
--

CREATE TABLE `tbresults` (
  `resultID` int(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `posName` varchar(64) NOT NULL,
  `partyName` varchar(64) NOT NULL,
  `votesNum` int(64) NOT NULL,
  `fromElectID` int(64) NOT NULL,
  `fromCandidateID` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbstud`
--

CREATE TABLE `tbstud` (
  `ID` int(36) NOT NULL,
  `email` varchar(64) NOT NULL,
  `fullname` varchar(64) NOT NULL,
  `dob` varchar(64) NOT NULL,
  `gender` varchar(64) NOT NULL,
  `address` varchar(64) NOT NULL,
  `course` varchar(64) NOT NULL,
  `college` varchar(64) NOT NULL,
  `cpnum` int(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbcandidate`
--
ALTER TABLE `tbcandidate`
  ADD PRIMARY KEY (`candidateID`);

--
-- Indexes for table `tbelect`
--
ALTER TABLE `tbelect`
  ADD PRIMARY KEY (`electionID`);

--
-- Indexes for table `tbresults`
--
ALTER TABLE `tbresults`
  ADD PRIMARY KEY (`resultID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbcandidate`
--
ALTER TABLE `tbcandidate`
  MODIFY `candidateID` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbelect`
--
ALTER TABLE `tbelect`
  MODIFY `electionID` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbresults`
--
ALTER TABLE `tbresults`
  MODIFY `resultID` int(64) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
