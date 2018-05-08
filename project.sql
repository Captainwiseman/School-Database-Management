-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2018 at 02:24 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `adminid` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `role` varchar(10) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(30) NOT NULL,
  `hash` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`adminid`, `name`, `role`, `phone`, `email`, `image`, `hash`) VALUES
(123, 'Shimi Mallauach', 'Sales', '0264786645', 'pokipoki@gmail.com', 'shimi123.jpg', '$2y$07$X81sYqGxGbB2C2tS.aRk9.dcD7pxz7mcyG8n0hd5bsCljcnlgR9rq'),
(369, 'Antonio Jimenez', 'Owner', '0546986645', 'admin@gmail.com', 'antonio369.jpg', '$2y$07$lNDTKbeA4nie6ND6dgvENu6XnyWEM9Mb21o7GLfq1OHKhmaq7zJqm'),
(91522847789, 'Shlomke Buzaglo', 'Manager', '05466846', 'buzaglo@gmail.com', '5ac4e9ca705561522854346.jpeg', '$2y$07$NYyow/ulnIwdKmmRJb9CLe3ZG6TPb29LetY58ZZw6xmCqX585cVqC'),
(91522848995, 'Shragazord Empu', 'Manager', '0543987', 'shraga@gmail.com', '5ac4e8cbc573f1522854091.jpeg', '$2y$07$CwfVaYP21E8J/n7F9VZFa.YT9dzIJPWMcGUStaPAE1grGRxv7rm9y');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `courseid` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(500) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseid`, `name`, `description`, `image`) VALUES
(101, 'Goat Taming', 'Learn how to correctly pet goats, basic tricks and mounting and galloping', '101.jpg'),
(102, 'Cheese and Wine Tasting', 'Envious of your rich or french friends? learn how to act like one!', '102.jpg'),
(103, 'Mimeology', 'The biology, psychology, autonomy of mimes! dissect a mime both mentally and physically and learn what makes a man go silent', '103.jpg'),
(104, 'Advance Goat Taming', 'Time to take your goat skills to next level, to the battlefield! learn how to make your goat a War-Goat and destroy your enemies!', '104.jpg'),
(105, 'Pirating!', 'Yarrr!!!! \'nuff said...', '105.jpg'),
(106, 'History of Curling', 'In the 16th century, the world has been graced by the most amazing sport of curling.\r\nLearn the awe-inspiring tale of this magnificent sport.', '106.jpg'),
(107, 'Camel Wresteling', 'Camels... you just wanna punch them, right? don\'t waste your time dreaming, enroll today!', '107.jpg'),
(108, 'Encostrstising', 'All your friends are studying in the university? do you hate the feeling you get when you say you just sit on your ass all day? do you want the university life without actually studying?\r\nwell this is the course for you!\r\n100% nap time with all the proof you need to actually say that you go to university, plus! a complicated course name you can drop in conversations!', '108.jpg'),
(109, 'Chicken Sewing', 'Want to learn a very, VERY specific craft? only in FlotsiTime you can!', '109.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `name`, `phone`, `email`, `image`) VALUES
(101, 'Shir Zahavy', '0504242424', 'shnozo@gmail.com', 'tshir0101.jpg'),
(1212, 'Matan Benishay', '0506666666', 'yeledmanyak@gmail.com', 'benishay1212.jpg'),
(2323, 'Aviran Green', '0509999999', 'krillin7@walla.co.il', 'aviran2323.jpg'),
(3434, 'Nir Shahrur', '0508888888', 'towelcanon@gmail.com', 'shechi3434.jpg'),
(4545, 'Avraham Benami', '0507447446', 'yeledefes@gmail.com', 'avraham4545.jpg'),
(5656, 'Liron Hassid', '0502525252', 'afikotsis@gmail.com', 'liron5656.jpg'),
(6767, 'Lani Zipori', '0509876444', 'chabeket@yahoo.biz', 'lani6767.jpg'),
(9999, 'BIoris Petonia', '014666695', 'bbbbaaaaa@gmail.com', 'bloris9999.jpg'),
(15228494634, 'Shimi Tavori', '0504123697', 'tavoriman@gmail.com', '5ac4e8d5786781522854101.jpeg'),
(15228495169, 'Gandalf the Grey', '0546698226', 'mordor@gmail.com', '5ac4e8da6330b1522854106.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `studentcourses`
--

CREATE TABLE `studentcourses` (
  `mainid` bigint(20) NOT NULL,
  `studentid` bigint(20) NOT NULL,
  `courseid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentcourses`
--

INSERT INTO `studentcourses` (`mainid`, `studentid`, `courseid`) VALUES
(1, 1212, 103),
(2, 1212, 102),
(3, 101, 106),
(4, 101, 105),
(5, 101, 104),
(6, 2323, 109),
(7, 2323, 101),
(8, 2323, 103),
(9, 2323, 107),
(10, 3434, 101),
(38, 15228495169, 101),
(43, 15228494634, 102),
(44, 15228494634, 103);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`courseid`),
  ADD KEY `courseid` (`courseid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`),
  ADD KEY `studentid` (`studentid`);

--
-- Indexes for table `studentcourses`
--
ALTER TABLE `studentcourses`
  ADD PRIMARY KEY (`mainid`),
  ADD KEY `studentid` (`studentid`),
  ADD KEY `courseid` (`courseid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `courseid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `studentcourses`
--
ALTER TABLE `studentcourses`
  MODIFY `mainid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studentcourses`
--
ALTER TABLE `studentcourses`
  ADD CONSTRAINT `studentcourses_ibfk_1` FOREIGN KEY (`courseid`) REFERENCES `course` (`courseid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `studentcourses_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
