-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 09:07 AM
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
  `candidateName` varchar(64) NOT NULL,
  `posID` int(64) NOT NULL,
  `partyName` varchar(64) NOT NULL,
  `electionCode` int(64) NOT NULL,
  `votesNum` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbcandidate`
--

INSERT INTO `tbcandidate` (`candidateID`, `candidateName`, `posID`, `partyName`, `electionCode`, `votesNum`) VALUES
(6, 'John Doe', 7, 'Example Party', 5, 1),
(7, 'Jane Smith', 7, 'Another Party', 5, 0),
(8, 'Bob Johnson', 8, 'Sausage Party', 5, 1),
(9, 'Bob JMarley', 8, 'Jannah Party', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbelect`
--

CREATE TABLE `tbelect` (
  `electionID` bigint(64) NOT NULL,
  `electName` varchar(64) NOT NULL,
  `startDate` varchar(64) NOT NULL,
  `endDate` varchar(64) NOT NULL,
  `expTime` varchar(64) NOT NULL,
  `startTime` varchar(64) NOT NULL,
  `description` varchar(200) NOT NULL,
  `posterID` int(64) NOT NULL,
  `college` varchar(64) NOT NULL,
  `pendingPostBool` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbelect`
--

INSERT INTO `tbelect` (`electionID`, `electName`, `startDate`, `endDate`, `expTime`, `startTime`, `description`, `posterID`, `college`, `pendingPostBool`) VALUES
(3, 'Example Election', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is an example election.', 1, '', 1),
(4, 'Example Election', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is an example election.', 1, '', 0),
(5, 'Example Election1', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is an example election.', 1, '', 0),
(6, 'Sample Election with college and pendingPostBool', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is a sample election.', 1, 'Sample College', 1),
(7, 'Sample Election with college and pendingPostBool2', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is a sample election.', 2, 'Sample College', 1),
(10, 'Sample Election', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is a sample election.', 123, 'Sample College', 1),
(11, 'Sample Electionqweq', '2023-01-01', '2023-01-15', '15:00:00', '09:00:00', 'This is a sample election.', 123, 'Sample College', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbpositions`
--

CREATE TABLE `tbpositions` (
  `positionID` int(64) NOT NULL,
  `positionName` varchar(200) NOT NULL,
  `electionCode` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbpositions`
--

INSERT INTO `tbpositions` (`positionID`, `positionName`, `electionCode`) VALUES
(1, 'Mayor', 4321),
(2, 'Mayor', 4321),
(3, 'President', 3),
(4, 'Vice President', 3),
(5, 'Mayor', 3),
(6, 'PIO', 3),
(7, 'President', 5),
(8, 'Vice President', 5),
(9, 'Secretary', 5),
(10, 'Treasurer', 5),
(11, 'PIO', 5);

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
-- Table structure for table `tbstuds`
--

CREATE TABLE `tbstuds` (
  `ID` int(8) NOT NULL,
  `email` varchar(46) DEFAULT NULL,
  `fullname` varchar(30) DEFAULT NULL,
  `dob` varchar(10) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `address` varchar(42) DEFAULT NULL,
  `course` varchar(25) DEFAULT NULL,
  `cpnum` varchar(10) DEFAULT NULL,
  `pass` varchar(3) DEFAULT NULL,
  `college` varchar(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbstuds`
--

INSERT INTO `tbstuds` (`ID`, `email`, `fullname`, `dob`, `gender`, `address`, `course`, `cpnum`, `pass`, `college`) VALUES
(19108242, 'javebrevin.torres_2@student.dmmmsu.edu.ph', 'Jave Brevinn O. Torres', '11/26/1999', 'MALE', 'San Benito Sur, Aringay, La Union', 'BS INFORMATION TECHNOLOGY', '9384552602', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(19110602, 'evaldez10602@student.dmmmsu.edu.ph', 'Enrico Zephan A. Valdez', '08/06/2000', 'MALE', 'Santiago Norte, CSFLU', 'BS INFORMATION TECHNOLOGY', '9695639119', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20113082, 'piercejeremy.posas@student.dmmmsu.edu.ph', 'Pierce Jeremy A. Posas', '09-07-2001', 'MALE', 'Central East Bauang, La Union', 'BS INFORMATION TECHNOLOGY', '9459758551', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20113162, 'erven.poblete@student.dmmmsu.edu.ph', 'Erven A. Poblete', '07/13/2002', 'MALE', 'Parian Este, Bauang La Union', 'BS INFORMATION TECHNOLOGY', '9458229663', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114212, 'edlhyn.mendeoro@student.dmmmsu.edu.ph', 'Edlhyn T. Mendeoro', '12/04/2001', 'FEMALE', 'San Vicente, City of San Fernando La Union', 'BS INFORMATION TECHNOLOGY', '9776082276', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114562, 'danica.gatchallan@student.dmmmsu.edu.ph', 'Danica R. Gatchallan', '08/12/2001', 'FEMALE', 'San Eugenio, Aringay La Union', 'BS INFORMATION TECHNOLOGY', '9703936709', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114582, 'eden.ariz@student.dmmmsu.edu.ph', 'Eden B. Ariz', '09/09/1999', 'FEMALE', 'Dasol, Pangasinan', 'BS INFORMATION TECHNOLOGY', '9163765893', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114812, 'trishamae.cervania@student.dmmmsu.edu.ph', 'Trisha Mae C. Cervania', '09/13/02', 'FEMALE', 'Paringao, Bauang, La Union', 'BS INFORMATION TECHNOLOGY', '9482086374', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114902, 'donellcarl.oconer@student.dmmmsu.edu.ph', 'Donell Carl G. Oconer', '09/18/2001', 'MALE', 'Sta.Rita Bacnotan La Union', 'BS INFORMATION TECHNOLOGY', '9451830225', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20114992, 'kingdavidreuel.almadrigo@student.dmmms.edu.ph', 'King David Reuel V. Almadrigo', '01/06/2002', 'MALE', 'Payocpoc Sur, Bauang, La Union', 'BS INFORMATION TECHNOLOGY', '9953608245', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20115272, 'aljen.lagarto@student.dmmmsu.edu.ph', 'Aljen R. Lagarto', '02/14/2002', 'MALE', 'Parian City of San Fernando La Union', 'BS INFORMATION TECHNOLOGY', '9084790138', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116212, 'janangeline.pacio@student.dmmmsu.edu.ph', 'Jan Angeline F. Pacio', '01/21/2002', 'FEMALE', 'Sevilla, San Fernando City, La Union', 'BS INFORMATION TECHNOLOGY', '9984205444', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116422, 'milven.gabayan@student.dmmmsu.edu.ph', 'Milven S. Gabayan', '11/21/2001', 'MALE', 'Pagdildilan, San Juan, La Union', 'BS INFORMATION TECHNOLOGY', '9814016622', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116432, 'justineraphael.necida@student.dmmmsu.edu.ph', 'Justine Raphael C. Necida', '06/02/2002', 'MALE', '', 'BS INFORMATION TECHNOLOGY', '', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116602, 'laptopnacer@gmail.com', 'Niels Azer M. Agustin', '03/06/2002', 'MALE', 'Calautit Bacnotan, La Union', 'BS INFORMATION TECHNOLOGY', '', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116632, 'xtynnjann.orpilla@student.dmmmsu.edu.ph', 'X\'tynn J\'ann S. Orpilla', '12/24/2001', 'FEMALE', 'San Carlos, Caba, La Union', 'BS INFORMATION TECHNOLOGY', '9369305821', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20116712, 'gleanneyvankhyle.orofino@student.dmmmsu.edu.ph', 'Gleanne Yvan Khyle Y. Orofino ', '11/26/2001', 'MALE', 'Sunrise SD, Pagdaraoan SFC La Union', 'BS INFORMATION TECHNOLOGY', '9568813879', '123', 'COLLEGE OF INFORMATION TEHNOLOGY'),
(20116822, 'davidjustine.javillonar@student.dmmmsu.edu.ph', 'David Justine A. Javillonar', '07/07/2002', 'MALE', 'Pagdalagan Sur, Bauang, La Union', 'BS INFORMATION TECHNOLOGY', '9458309021', '123', 'COLLEGE OF INFORMATION TECHNOLOGY'),
(20119122, 'jarold.rimorin@student.dmmmsu.edu.ph', 'Jarold B. Rimorin', '04/22/2002', 'MALE', 'Bautista, Caba, La Union', 'BS INFORMATION TECHNOLOGY', '9123438932', '123', 'COLLEGE OF INFORMATION TECHNOLOGY');

-- --------------------------------------------------------

--
-- Table structure for table `tbvoters`
--

CREATE TABLE `tbvoters` (
  `voterID` int(64) NOT NULL,
  `electionCode` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbvoters`
--

INSERT INTO `tbvoters` (`voterID`, `electionCode`) VALUES
(19108242, 3),
(19108242, 3);

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
-- Indexes for table `tbpositions`
--
ALTER TABLE `tbpositions`
  ADD PRIMARY KEY (`positionID`);

--
-- Indexes for table `tbrecovery`
--
ALTER TABLE `tbrecovery`
  ADD PRIMARY KEY (`recoveryID`);

--
-- Indexes for table `tbstuds`
--
ALTER TABLE `tbstuds`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbcandidate`
--
ALTER TABLE `tbcandidate`
  MODIFY `candidateID` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbelect`
--
ALTER TABLE `tbelect`
  MODIFY `electionID` bigint(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbpositions`
--
ALTER TABLE `tbpositions`
  MODIFY `positionID` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
