-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2023 at 08:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sel_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `u_hm_preregistration`
--

CREATE TABLE `u_hm_preregistration` (
  `REGNO` varchar(10) DEFAULT NULL,
  `OPT1_PRGM_ID` float DEFAULT NULL,
  `OPT2_PRGM_ID` float DEFAULT NULL,
  `OPT3_PRGM_ID` float DEFAULT NULL,
  `CGPA` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `u_hm_preregistration`
--

INSERT INTO `u_hm_preregistration` (`REGNO`, `OPT1_PRGM_ID`, `OPT2_PRGM_ID`, `OPT3_PRGM_ID`, `CGPA`) VALUES
('21ME1016', 33, 35, 28, NULL),
('21ME1017', 33, 34, 37, 8.67),
('21ME1018', 33, 39, 40, 8.90),
('21ME1019', 33, 38, 39, 9.10),
('21ME1020', 33, 39, 40, 8.87),
('21ME1021', 33, 34, 40, 8.93),
('21ME1022', 33, 39, 38, 9.27),
('21ME1023', 33, 38, 35, 8.67),
('21ME1024', 33, 39, 38, 8.73),
('21ME1025', 33, 35, 40, 9.13),
('21ME1026', 33, 39, 40, 9.33),
('21ME1027', 33, 38, 35, 8.87),
('21ME1028', 33, 34, 38, 8.60);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `u_hm_preregistration`
--
ALTER TABLE `u_hm_preregistration`
  ADD UNIQUE KEY `unique_regno` (`REGNO`),
  ADD KEY `FK_REGNO4` (`REGNO`),
  ADD KEY `FK_PRGM_ID_HM1` (`OPT1_PRGM_ID`),
  ADD KEY `FK_PRGM_ID_HM2` (`OPT2_PRGM_ID`),
  ADD KEY `FK_PRGM_ID_HM3` (`OPT3_PRGM_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `u_hm_preregistration`
--
ALTER TABLE `u_hm_preregistration`
  ADD CONSTRAINT `FK_PRGM_ID_HM1` FOREIGN KEY (`OPT1_PRGM_ID`) REFERENCES `u_prgm` (`PRGM_ID`),
  ADD CONSTRAINT `FK_PRGM_ID_HM2` FOREIGN KEY (`OPT2_PRGM_ID`) REFERENCES `u_prgm` (`PRGM_ID`),
  ADD CONSTRAINT `FK_PRGM_ID_HM3` FOREIGN KEY (`OPT3_PRGM_ID`) REFERENCES `u_prgm` (`PRGM_ID`),
  ADD CONSTRAINT `FK_REGNO4` FOREIGN KEY (`REGNO`) REFERENCES `u_student` (`REGNO`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
