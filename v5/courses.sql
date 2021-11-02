-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 12, 2021 at 05:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `cao_points` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `course_code`, `cao_points`, `start_date`, `image_id`) VALUES
(7, 'Creative Computing', 'DL836', '235', '2021-10-01', 1),
(8, 'Animation', 'DL832', '989', '2021-10-01', 2),
(9, 'Applied Psychology', 'DL825', '413', '2021-10-01', 3),
(10, 'Art', 'DL827', '574', '2021-10-01', 4),
(11, 'Arts Management', 'DL822', '254', '2021-10-01', 5),
(12, 'Business - Applied Entrepreneurship', 'DL701', '162', '2021-10-01', 6),
(13, 'Business Studies - Entrepreneurship & Management', 'DL823', '220', '2021-10-01', 7),
(14, 'Creative Music Production', 'DL838', '713', '2021-10-01', 8),
(15, 'Design for Film', 'DL845', '628', '2021-10-01', 9),
(16, 'Digital Marketing', 'DL840', '210', '2021-10-01', 10),
(17, 'English and Equality Studies', 'DL841', '277', '2021-10-01', 11),
(18, 'Film', 'DL843', '874', '2021-10-01', 12),
(19, 'Graphic Design', 'DL826', '591', '2021-10-01', 13),
(20, 'Interaction and User Experience Design', 'DL839', '757', '2021-10-01', 14),
(21, 'New Media Studies', 'DL837', '293', '2021-10-01', 15),
(22, 'Photography and Visual Media', 'DL833', '671', '2021-10-01', 16);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`) VALUES
(1, 'assets/img/course_01.png'),
(2, 'assets/img/course_02.png'),
(3, 'assets/img/course_03.png'),
(4, 'assets/img/course_04.png'),
(5, 'assets/img/course_05.png'),
(6, 'assets/img/course_06.png'),
(7, 'assets/img/course_07.png'),
(8, 'assets/img/course_08.png'),
(9, 'assets/img/course_09.png'),
(10, 'assets/img/course_10.png'),
(11, 'assets/img/course_11.png'),
(12, 'assets/img/course_12.png'),
(13, 'assets/img/course_13.png'),
(14, 'assets/img/course_14.png'),
(15, 'assets/img/course_15.png'),
(16, 'assets/img/course_16.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_image_fk` (`image_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_image_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
