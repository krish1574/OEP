-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 08:58 PM
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
-- Database: `blood`
--

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `preferred_donation_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `last_donated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `user_id`, `name`, `age`, `phone_number`, `blood_group`, `hospital_name`, `preferred_donation_date`, `time_slot`, `last_donated`) VALUES
(1, NULL, 'krish vaghela', 20, '', '', 'Baps Pramukh Swami Hospital', '2024-10-03', '8 AM - 10 AM', '0000-00-00'),
(5, NULL, 'krish vaghela', 20, '', '', 'INS Hospital', '2024-10-03', '8 AM - 10 AM', '0000-00-00'),
(6, NULL, '', 0, '', '', '', '0000-00-00', '', '0000-00-00'),
(7, NULL, 'krish vaghela', 20, '', 'A+', 'INS Hospital', '2024-10-31', '8 AM - 10 AM', '2024-10-03'),
(8, NULL, 'krish vaghela', 18, '', 'A+', 'INS Hospital', '2024-10-24', '8 AM - 10 AM', '2024-09-06'),
(9, 23, 'krish vaghela', 20, '', 'A+', 'INS Hospital', '2024-10-24', '11 AM - 1 PM', '2024-10-03'),
(10, 23, 'krish vaghela', 20, '', 'A+', 'INS Hospital', '2024-10-24', '11 AM - 1 PM', '2024-10-03'),
(11, 23, 'dakshsinh parmar', 22, '', 'AB-', 'Surat Civil Hospital', '2024-10-26', '3 PM - 5 PM', '2024-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `patient_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `required_blood_group` varchar(3) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `required_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `user_id`, `patient_name`, `age`, `phone_number`, `required_blood_group`, `hospital_name`, `required_date`) VALUES
(1, 24, 'krish', 20, '8511479620', 'B+', 'Baps Pramukh Swami Hospital', '2024-10-25'),
(2, 23, 'krish', 10, '8511479620', 'A+', 'Baps Pramukh Swami Hospital', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `user_id` int(11) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`user_id`, `Email`, `phone_number`, `password`) VALUES
(23, 'krish@gmail.com', '9562123456', '$2y$10$JIDG7.QtmM3/ffVcqflZUuSpurT12cLYpYF2RBrdIsvj26OkXPCB.'),
(24, 'krishvaghela@gmail.com', '7894561239', '$2y$10$5kFojc12D8CrzdQQaM5Ui.jmhffjo3UQ/Hv6sG7.sbEJr4.ZN7Y8.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `donation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
