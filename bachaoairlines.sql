-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 02:18 PM
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
-- Database: `bachaoairlines`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `flight_number` varchar(20) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `contact`, `email`, `country`, `flight_number`, `rating`, `comments`, `created_at`) VALUES
(5, 'Saad', '01705502194', '', '', NULL, 5, 'Exquisite', '2025-01-03 12:31:45'),
(6, 'Ifaz', '135136126', '', '', NULL, 3, 'Immaculate', '2025-01-03 17:52:56'),
(7, ' Zawad', '01705502194', '', '', NULL, 5, 'Verrrrrryyyyyyyyy Goooooood', '2025-01-04 17:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `flight-1`
--

CREATE TABLE `flight-1` (
  `Start_time` time DEFAULT NULL,
  `Duration` varchar(20) DEFAULT NULL,
  `End_time` time DEFAULT NULL,
  `Flight_from` varchar(10) DEFAULT NULL,
  `Type` varchar(10) DEFAULT NULL,
  `Flight_to` varchar(10) DEFAULT NULL,
  `Start_date` date DEFAULT NULL,
  `Land_date` date DEFAULT NULL,
  `Flight_ID` varchar(10) NOT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight-1`
--

INSERT INTO `flight-1` (`Start_time`, `Duration`, `End_time`, `Flight_from`, `Type`, `Flight_to`, `Start_date`, `Land_date`, `Flight_ID`, `Price`) VALUES
('19:00:00', '45min', '19:45:00', 'CGP', 'Non-stop', 'DHK', '2024-12-30', '2024-12-30', 'TBACAO001', 3500),
('14:00:00', '45min', '14:45:00', 'DHK', 'Non-stop', 'CGP', '2024-12-31', '2024-12-31', 'TBACAO002', 3205),
('20:00:00', '30min', '20:30:00', 'DHK', 'Non-stop', 'COX', '2025-01-01', '2025-01-01', 'TBACAO003', 3870),
('15:30:00', '1hour 15min', '16:45:00', 'COX', 'Non-stop', 'DHK', '2025-01-02', '2025-01-02', 'TBACAO004', 3750),
('19:00:00', '45min', '19:45:00', 'DHK', 'Non-stop', 'CGP', '2025-01-02', '2025-01-02', 'TBACAO005', 3905),
('08:00:00', '55min', '20:55:00', 'CGP', 'Non-stop', 'DHK', '2025-01-03', '2025-01-03', 'TBACAO006', 3205),
('09:35:00', '1hour', '10:35:00', 'DHK', 'Non-stop', 'SYL', '2025-01-04', '2025-01-04', 'TBACAO007', 4000),
('20:00:00', '1hour', '21:00:00', 'SYL', 'Non-stop', 'DHK', '2025-01-04', '2025-01-04', 'TBACAO008', 4310),
('02:00:00', '20hours 10min', '22:10:00', 'DHK', 'Non-stop', 'SYD', '2025-01-09', '2025-01-09', 'TBACAO010', 130000);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `flight_id` varchar(50) DEFAULT NULL,
  `seat_number` varchar(10) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT 'available',
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `flight_id`, `seat_number`, `status`, `transaction_id`) VALUES
(52, 'TBACAO001', '1A', 'booked', 76),
(53, 'TBACAO001', '1F', 'booked', 77),
(55, 'TBACAO003', '6B', 'booked', 79),
(57, 'TBACAO001', '1C', 'booked', 81),
(58, 'TBACAO002', '1A', 'booked', 82);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flight_id` varchar(50) DEFAULT NULL,
  `passenger_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `passport_number` varchar(50) DEFAULT NULL,
  `seat_number` varchar(20) DEFAULT NULL,
  `seat_type` varchar(20) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_number` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `insurance_amount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `flight_id`, `passenger_name`, `email`, `phone`, `passport_number`, `seat_number`, `seat_type`, `payment_method`, `payment_number`, `amount`, `total_amount`, `status`, `created_at`, `insurance_amount`) VALUES
(76, 35, 'TBACAO001', 'Monir Akib', 'monirakib@gmail.com', '01705502194', '15123637372', '1A', 'window', 'bkash', '01705502194', 3325.00, 5325.00, 'pending', '2025-01-04 14:35:55', 2000),
(77, 32, 'TBACAO001', 'Imteshar Ahmed', 'ia.yamin@gmail.com', '01855211622', '15123637372', '1F', 'window', 'bkash', '01855211622', 3500.00, 4000.00, 'pending', '2025-01-04 14:36:44', 500),
(79, 35, 'TBACAO003', 'Monir Akib', 'monirakib@gmail.com', '01705502194', '15123637372', '6B', 'middle', 'bkash', '01705502194', 3676.00, 3676.00, 'pending', '2025-01-04 17:15:49', 0),
(81, 40, 'TBACAO001', 'Mini Clips', 'mini@gmail.com', '01818181811', '15123637372', '1C', 'aisle', 'credit', '01855211622', 3500.00, 4000.00, 'pending', '2025-01-05 13:08:31', 500),
(82, 40, 'TBACAO002', 'Mini Clips', 'mini@gmail.com', '01739933678', '15123637372', '1A', 'window', 'bkash', '01705502194', 3205.00, 5205.00, 'pending', '2025-01-05 13:08:51', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_type` enum('Customer','Admin') NOT NULL DEFAULT 'Customer',
  `reward_point` int(11) DEFAULT 0,
  `membership_level` enum('Gold','Silver','Bronze') NOT NULL DEFAULT 'Bronze',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `date_of_birth`, `gender`, `phone`, `user_type`, `reward_point`, `membership_level`, `created_at`) VALUES
(32, 'Imteshar', 'Ahmed', 'ia.yamin@gmail.com', '$2y$10$E0suJsoKM5jpwsoWdS7SmOt0GuuGm76vU82186/8jU5yRA8Zxiq9G', '2002-02-05', 'male', '01855211622', 'Admin', 1030, 'Gold', '2025-01-03 10:47:34'),
(35, 'Monir', 'Akib', 'monirakib@gmail.com', '$2y$10$euRBKoWIS7zHOCmnBLuMfubyeiMJdCum5WBVUnGPGtlSe59X7mhce', '2001-09-09', 'male', '01705502194', 'Admin', 1400, 'Gold', '2025-01-03 12:07:19'),
(37, 'Ifaz', 'Alamgir', 'ifaz@gmail.com', '$2y$10$RWXr8bojQfZFOxZJ9zJz8.4e28VGpzs4wf0hv7Pqbjv0.CUEK9ZF2', '2002-01-07', 'male', '01818181811', 'Customer', 140, 'Bronze', '2025-01-03 17:51:43'),
(38, 'Rabib', 'Hasan', 'rababechan@gmail.com', '$2y$10$ln/xbzkILUysuetdVAoMqeIkEkqEPIjFWZTh0KTNEaDvp3RAiTNfG', '2002-10-15', 'male', '01739933678', 'Customer', 160, 'Bronze', '2025-01-03 18:17:57'),
(40, 'Mini', 'Clips', 'mini@gmail.com', '$2y$10$o4to6ptDH7M7mvKusNn9nOLOhIYHq0YkOFUYJzcnT2eFpF1GX.WiK', '2025-01-08', 'male', '01818181811', 'Customer', 340, 'Bronze', '2025-01-05 13:07:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight-1`
--
ALTER TABLE `flight-1`
  ADD PRIMARY KEY (`Flight_ID`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flight-1` (`Flight_ID`),
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
