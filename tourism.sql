-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 06, 2024 at 02:39 AM
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
-- Database: `tourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `people` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `destination_id`, `booking_date`, `people`, `payment`) VALUES
(2, NULL, 10, NULL, 0, ''),
(3, 3, 2, '2024-07-26', 0, ''),
(4, 3, 8, '2024-07-25', 3, 'credit_card'),
(5, 2, 17, '2024-07-27', 12, 'bank'),
(6, 4, 22, '2024-07-31', 1, 'bank');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `destination_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `towns` text DEFAULT NULL,
  `cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`destination_id`, `name`, `description`, `image_path`, `location`, `distance`, `towns`, `cost`) VALUES
(1, 'camels ride', 'chris hemsworth camel riding', 'img/camels ride.jpg', 'ol pajeta', 230, 'Nanyuki', 2000),
(2, 'coast masaai', 'maasai at coast', 'img/coast maasai.jpg', 'lamu', 466, 'Lamu', 6500),
(3, 'elephant ride', 'tourist riding elephants', 'img/elephant ride.jpg', 'amboseli', 204, 'Namanga', 1800),
(4, 'giraffe crossing', 'Offers wildlife safaris and is home to the last two northern white rhinos.', 'img/giraffe.jpg', 'ol pajeta', 230, 'Nanyuki', 2000),
(5, 'giraffe expenditure', 'Experience the greatest giraffe experience', 'img/kenya-exp1.jpg', 'ol pajeta', 230, 'Nanyuki', 2000),
(6, 'elephants', 'Includes the second-highest mountain in Africa, offering trekking and climbing opportunities.', 'img/Kenya.jpeg', 'mt kenya', 192, 'Narumoru', 1500),
(7, 'landscape view', 'Known for its waterfalls, moorlands, and diverse wildlife.', 'img/landscape view.jpg', 'aberdares', 180, 'Nyeri', 1500),
(8, 'savannah view', 'Home to unique wildlife species like the Grevy’s zebra and the elephants', 'img/large savannah view.jpg', 'aberdares', 180, 'Nyeri', 1500),
(9, 'masaai jumping', 'Known for the Great Migration and diverse wildlife.', 'img/maasai jumping 2.jpeg', 'masai mara', 230, 'Narok', 2100),
(10, 'mount suswa view point', 'Getting the view at mount suswa', 'img/mount suswa pointing.jpg', 'suswa', 125, 'Mai mahiu', 1200),
(11, 'mount kenya peaks', 'The second highest mountain in  Africa', 'img/Mount-Kenya-Climbing.jpg', 'mount kenya', 192, 'Narumoru', 1500),
(12, 'mountain hiking', 'Explore trekking and climbing opportunity', 'img/mountain hiking.jpg', 'mountain', 192, 'Naru moru', 1500),
(13, 'hiking mount kenya', 'Includes the second-highest mountain in Africa, offering trekking and climbing opportunities.', 'img/mt kenya hiking.jpg', 'mt kenya', 192, 'Narumoru', 1500),
(14, 'hiking', 'Try mountain climbing', 'img/mt kenya hiking.jpg', 'kenya', 192, 'Narumoru', 1500),
(15, 'ostrich', 'Experience the largest non flying birds', 'img/ostrich.jpg', 'lake naivasha', 104, 'Naivasha', 1100),
(16, 'road viewpoint', 'Escarpment view point', 'img/road viewpont.jpg', 'escarpment', 60, 'Nakuru', 1000),
(17, 'safari', 'Travel with us and experience nature', 'img/safari.jpg', 'safari', 314, 'Voi', 3500),
(18, 'samburu landscape', 'Home to unique wildlife species like the Grevy’s zebra and the reticulated giraffe.', 'img/samburu game reserve.webp', 'samburu', 314, 'Samburu', 4500),
(19, 'zebras', 'Offers wildlife safaris and is home to the zebras.\r\n', 'img/savannah zebras.jpg', 'savannah', 282, 'Voi', 3600),
(20, 'savannah', 'Experience the maasai culture', 'img/savannah.jpg', 'savannah', 282, 'Samburu', 4550),
(21, 'sunset', 'experience the sunset landscape', 'img/sunset giraffe.webp', 'masai mara', 230, 'Narok', 2000),
(22, 'thompsons  falls', 'Known for its waterfalls, moorlands, and diverse wildlife.', 'img/thompson falls 2.jpg', 'nyahururu thompson', 188, 'Nyahururu', 3300),
(23, 'falls', 'Watch the falls', 'img/thompsons falls.jpg', 'thompson', 188, 'Nyahururu', 3300),
(24, 'camping', 'Experience the maasai culture', 'img/wilderness safari.jpg', 'masai mara', 230, 'Narok', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `search_queries`
--

CREATE TABLE `search_queries` (
  `id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `search_count` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_queries`
--

INSERT INTO `search_queries` (`id`, `location`, `search_count`) VALUES
(1, 'ol pajeta', 1),
(2, 'kenya', 96),
(3, 'thompson', 83),
(4, 'suswa', 1),
(5, 'lamu', 82),
(6, 'sdd', 2),
(7, 'Nanyuki', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_number`, `address`) VALUES
(2, 'zakas', 'zachwambugu70@gmail.com', '$2y$10$IhCA/Ig3Iocy7Eh7qa.P5OJ8/2P5SAg9FiNR7uEQgzw0NdeVs/Xo6', '7031111111', 'thika'),
(3, 'wambugu', 'zachwambugu847@gmail.com', '$2y$10$ItFJcTkgGmGmELnTgMmlpum3K6aLrRYx.txjuNUAoOPbI549aOZNa', '710811359', 'Nairobi'),
(4, 'jalikoi', 'jalikoi@gmail.com', '$2y$10$12rkRPe5D9FNZx0GS0QY1eJKy.a/DObsJmjbC35DjQdoRXqZ/L9Pi', '0711688260', 'nanyuki');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`destination_id`);

--
-- Indexes for table `search_queries`
--
ALTER TABLE `search_queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `destination_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `search_queries`
--
ALTER TABLE `search_queries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`destination_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
