-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 08:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruitmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievement`
--

CREATE TABLE `achievement` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `achievement` text NOT NULL,
  `date_given` date NOT NULL,
  `given_by` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievement`
--

INSERT INTO `achievement` (`id`, `employee_name`, `department`, `achievement`, `date_given`, `given_by`) VALUES
(1, 'admin admin', 'hr department', 'No available', '2024-01-01', 'No available'),
(3, 'admin admin 1', 'driver', '', '0000-00-00', ''),
(4, 'admin admin 2', 'it department', '', '0000-00-00', ''),
(5, 'admin admin 3', 'it department', '', '0000-00-00', ''),
(6, 'admin admin 4', 'driver', '', '0000-00-00', ''),
(7, 'admin admin 5', 'hr department', '', '0000-00-00', ''),
(8, 'admin admin 6', 'finance', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_users`
--

CREATE TABLE `applicant_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_offers`
--

CREATE TABLE `job_offers` (
  `id` int(11) NOT NULL,
  `job_name` char(50) DEFAULT NULL,
  `status` enum('OPEN','CLOSE','Active') DEFAULT 'OPEN',
  `Applicant_count` int(255) NOT NULL,
  `Delete_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_offers`
--

INSERT INTO `job_offers` (`id`, `job_name`, `status`, `Applicant_count`, `Delete_status`) VALUES
(18, 'driver', '', 0, 'is_deleted'),
(19, 'driver', 'OPEN', 0, 'is_deleted'),
(20, 'hr', 'OPEN', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `onboarding_status`
--

CREATE TABLE `onboarding_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `interview_status` enum('INITIAL INTERVIEW','FINAL INTERVIEW','','') NOT NULL DEFAULT '',
  `application_status` enum('ON PROCESS','TO BE CALL','HIRED','') DEFAULT NULL,
  `onboarding_status` enum('PRE-BOARDING','ORIENTATION','TRAINING','') DEFAULT NULL,
  `Delete_Status` varchar(100) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `onboarding_status`
--

INSERT INTO `onboarding_status` (`id`, `name`, `interview_status`, `application_status`, `onboarding_status`, `Delete_Status`) VALUES
(15, 'RICMON', 'INITIAL INTERVIEW', 'TO BE CALL', 'TRAINING', 'Active'),
(16, 'kjnknjknjkj', 'INITIAL INTERVIEW', 'ON PROCESS', 'PRE-BOARDING', 'is_deleted'),
(17, 'Guia marie', 'FINAL INTERVIEW', 'ON PROCESS', 'PRE-BOARDING', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `screening_selection`
--

CREATE TABLE `screening_selection` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `applied_position` char(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `Status` enum('PENDING','ONGOING','REJECTED','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screening_selection`
--

INSERT INTO `screening_selection` (`id`, `name`, `applied_position`, `age`, `email`, `document_path`, `Status`) VALUES
(33, 'kjnknjknjkj', 'JAKOLERO', 909, 'jnbhhbuhb@gmail.com', 'ORDER-FORM - SALARDA.pdf', 'ONGOING'),
(34, 'Guia marie', 'hr', 212, 'ging@gmail.com', 'Session 3_ Python Fundamentals with an Introduction to AI.pdf', 'ONGOING'),
(35, 'Guia marie', 'hr', 21, 'ging@gmail.com', 'ORDER-FORM.pdf', 'PENDING'),
(36, 'TEST', 'hr', 20, 'zxc123@gmail.com', 'Research-clearance.pdf', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `training_performance`
--

CREATE TABLE `training_performance` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `training_program` varchar(255) NOT NULL,
  `evaluator` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_given` date DEFAULT NULL,
  `actions` varchar(255) DEFAULT NULL,
  `development` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_performance`
--

INSERT INTO `training_performance` (`id`, `employee_name`, `training_program`, `evaluator`, `remarks`, `date_given`, `actions`, `development`) VALUES
(1, 'raisen', 'leadership', 'mr. vasquez', 'Success', '2024-10-21', NULL, 'developed leadership skilss'),
(2, 'raisen', 'leadership', 'mr. vasquez', 'Success', '2024-10-21', NULL, 'developed leadership skilss'),
(3, 'raisen', 'leadership', 'mr. vasquez', 'Success', '2024-10-21', NULL, 'developed leadership skilss'),
(4, 'guia', 'leadership', 'mr. vasquez', 'Success', '2024-10-22', NULL, 'developed leadership skilss'),
(5, 'raisen', 'leadership', 'mr. vasquez', 'Failed', '2024-10-22', NULL, 'developed leadership skilss');

-- --------------------------------------------------------

--
-- Table structure for table `training_program`
--

CREATE TABLE `training_program` (
  `id` int(11) NOT NULL,
  `training_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_program`
--

INSERT INTO `training_program` (`id`, `training_name`, `date`, `time`, `place`) VALUES
(1, 'safety,', '2024-11-02', '13:58:00', 'quezon City'),
(2, 'leadership', '2024-10-22', '10:10:00', 'quezon City');

-- --------------------------------------------------------

--
-- Table structure for table `training_schedule`
--

CREATE TABLE `training_schedule` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `training_program` varchar(255) NOT NULL,
  `starting_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_status`
--

CREATE TABLE `training_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `training_program` varchar(255) DEFAULT NULL,
  `start_date` varchar(100) DEFAULT NULL,
  `end_date` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `firstname`, `lastname`) VALUES
(1, 'guia', 'guiamarie30@gmail.com', '$2y$10$Ijcx9mLjbE2Da7vXKyStT.GLmhGLO8zY90.od1nvsFg2NTciQrn06', 'guia', 'marie'),
(2, 'ging', 'guiamarie30@gmail.com', '$2y$10$dvwGwEoY1q3o4S2OFUBpm.3mqtC2X00U7O/zmIJFoIf.9oic.Xyoe', 'guia', 'torres');

-- --------------------------------------------------------

--
-- Table structure for table `worked_hours`
--

CREATE TABLE `worked_hours` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `total_hours` decimal(5,2) GENERATED ALWAYS AS (timestampdiff(MINUTE,`time_in`,`time_out`) / 60.0 - 1) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worked_hours`
--

INSERT INTO `worked_hours` (`id`, `employee_name`, `date`, `time_in`, `time_out`, `department`) VALUES
(4, 'raisen vasquez', '2024-10-21', '09:00:00', '17:00:00', 'hr department'),
(5, 'raisen vasquez 1', '2024-10-21', '09:00:00', '17:00:00', 'it department'),
(6, 'raisen vasquez 2', '2024-10-21', '09:00:00', '17:00:00', 'hr department'),
(7, 'raisen vasquez 3', '2024-10-21', '09:00:00', '17:00:00', 'hr department'),
(8, 'raisen vasquez 4', '2024-10-21', '09:00:00', '17:00:00', 'it department'),
(9, 'raisen vasquez', '0000-00-00', '00:00:00', '00:00:00', 'hr department'),
(10, 'raisen vasquez', '2024-10-10', '08:00:00', '17:00:00', 'hr department'),
(11, 'raisen vasquez 5', '0000-00-00', '00:00:00', '00:00:00', 'driver');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_offers`
--
ALTER TABLE `job_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onboarding_status`
--
ALTER TABLE `onboarding_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `screening_selection`
--
ALTER TABLE `screening_selection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_performance`
--
ALTER TABLE `training_performance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_program`
--
ALTER TABLE `training_program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_schedule`
--
ALTER TABLE `training_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_status`
--
ALTER TABLE `training_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worked_hours`
--
ALTER TABLE `worked_hours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievement`
--
ALTER TABLE `achievement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `job_offers`
--
ALTER TABLE `job_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `onboarding_status`
--
ALTER TABLE `onboarding_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `screening_selection`
--
ALTER TABLE `screening_selection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `training_performance`
--
ALTER TABLE `training_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `training_program`
--
ALTER TABLE `training_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `training_schedule`
--
ALTER TABLE `training_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_status`
--
ALTER TABLE `training_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `worked_hours`
--
ALTER TABLE `worked_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
