-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 02:56 AM
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
-- Database: `alumni_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `2024-2025`
--

CREATE TABLE `2024-2025` (
  `id` int(11) NOT NULL,
  `alumni_id` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `college` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `section` varchar(20) NOT NULL,
  `year_graduated` year(4) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `personal_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2024-2025`
--

INSERT INTO `2024-2025` (`id`, `alumni_id`, `last_name`, `first_name`, `college`, `department`, `section`, `year_graduated`, `contact_number`, `personal_email`) VALUES
(21, '001', 'Mallo', 'Ivan', 'CITCS', 'CITCS', 'CS3G', '2024', '09124578869', 'ivan@gmail.com'),
(23, '003', 'Argame', 'Cyril', 'CITCS', 'Computer Science', 'CS3G', '2024', '09124578869', 'Anne@gmail.com'),
(24, '002', 'Bandalan', 'Juliana Patricia', 'CITCS', 'Computer Science', 'CS3G', '2024', '09124578865', 'Julie@gmail.com'),
(25, '004', 'Go', 'Troy', 'CCJ', 'Criminology', 'C3A', '2024', '09124578869', 'Go@gmail.com'),
(26, '005', 'Mamador', 'Christian', 'CBA', 'Marketing', 'BA4C', '2024', '09124578862', 'Chris@gmail.com'),
(27, '006', 'Calalang', 'Nea', 'CITCS', 'ACT', 'AC4A', '2024', '09124578890', 'Neaaa@gmail.com'),
(33, '012', 'Martinez', 'Dansoy', 'CITCS', 'Information Technology', 'IT3Z', '2024', '09124588870', 'dan@gmail.com'),
(34, '013', 'Mallo', 'Tristan', 'CITCS', 'Information Technology', 'IT3A', '2024', '09124578888', 'Tris@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `2024-2025-ws`
--

CREATE TABLE `2024-2025-ws` (
  `alumni_id` varchar(11) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `working_status` enum('Employed','Unemployed','Self-Employed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2024-2025-ws`
--

INSERT INTO `2024-2025-ws` (`alumni_id`, `last_name`, `first_name`, `working_status`) VALUES
('001', 'Mallo', 'Ivan Joshua', 'Unemployed'),
('002', 'Bandalan', 'Juliana Patricia', 'Unemployed'),
('003', 'Argame', 'Cyril', 'Self-Employed'),
('004', 'Go', 'Troy', 'Employed'),
('005', 'Mamador', 'Christian', 'Unemployed'),
('006', 'Calalang', 'Nea', 'Unemployed'),
('012', 'Martinez', 'Dansoy', 'Self-Employed'),
('013', 'Mallo', 'Tristan', 'Unemployed'),
('100', 'Glover', 'Reinhold', 'Employed'),
('101', 'Walsh', 'Eryn', 'Unemployed'),
('102', 'O\'Connell', 'Eldred', 'Employed'),
('103', 'Zulauf', 'Enola', 'Employed'),
('104', 'Langworth', 'Karl', 'Employed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('registrar','alumni') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'Staff', 'staff@plmun.com', '$2y$10$v7eL1YsM6eC5/O9JQVLzeeU.BS/Ehz31IsZXoIM025fL44l/Yrz9i', 'registrar'),
(2, 'anneee', 'anne@argame.com', '$2y$10$q8CyKwHxpEoElwaKFBxyUu1eA0e78PRjUM35cqYfVryPTyvdpJIVa', 'registrar'),
(3, 'root', 'root@123.com', '$2y$10$cShUfvoBJpvYMfTw.xQGIOYlRuXVamSM0xlrIxMllX0Lvo9EkR8C6', 'registrar'),
(4, 'admin', 'anneee@argame.com', '$2y$10$km3Yu8JeYmP5sy.UwzTdp.BtEBceN.8qeucxp0tlxTrp/GVKLlyc.', 'registrar'),
(5, 'nomiki45', 'nomiki@viktoria.com', '$2y$10$He/sLGxksDKH.G2jRUzJO.1Ef8Dfma2rNzJms6pNtkFvjT5gOeTYm', 'registrar'),
(6, 'Ivan', 'Ivan@gmail.com', '$2y$10$lBJ6sJWWgH/NnU40vVkXIu.cbvh6Hj6EziQ/uQ.X90aAF0IaYgn8K', 'registrar'),
(8, 'mallo', 'Ivanmolang@gmail.com', '$2y$10$WtT1TfZdT3qSKAa5ZMPgCOLqMH5wVFkABTIMKL0C0piTKf1arU0UG', 'registrar'),
(9, 'Ivanqt', 'cohivoh84@tgmph.shop', '$2y$10$rtTp2cmI35YkoLCnNsEySOWuhS/nuqmegIvnU.d7ZvczrocppDqta', 'alumni'),
(10, 'grey', 'grey2@gmail.com', '$2y$10$hc2FR4EIjJZtPjshV148sufCIkM96fKErH988k7gs0DS9h9dwbETG', 'alumni');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2024-2025`
--
ALTER TABLE `2024-2025`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`alumni_id`);

--
-- Indexes for table `2024-2025-ws`
--
ALTER TABLE `2024-2025-ws`
  ADD PRIMARY KEY (`alumni_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `2024-2025`
--
ALTER TABLE `2024-2025`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
