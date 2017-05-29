-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2017 at 09:26 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgc`
--

-- --------------------------------------------------------

--
-- Table structure for table `anunturi`
--

CREATE TABLE `anunturi` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0-normal;1-important;2-urgent;',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `arhiva`
--

CREATE TABLE `arhiva` (
  `id` int(11) NOT NULL,
  `denumire` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commites`
--

CREATE TABLE `commites` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `chair` int(11) DEFAULT NULL,
  `co_chair` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `commites`
--

INSERT INTO `commites` (`id`, `conf_id`, `chair`, `co_chair`) VALUES
(1, 1, 17, 16);

-- --------------------------------------------------------

--
-- Table structure for table `conferinte`
--

CREATE TABLE `conferinte` (
  `id` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `deadline` date NOT NULL,
  `acceptance_date` date NOT NULL,
  `ext_deadline` date DEFAULT NULL,
  `ext_acceptance_date` date DEFAULT NULL,
  `commitee` int(11) DEFAULT NULL,
  `topic` varchar(255) NOT NULL,
  `fee` int(11) NOT NULL,
  `stare` tinyint(1) NOT NULL,
  `obs` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conferinte`
--

INSERT INTO `conferinte` (`id`, `nume`, `data`, `deadline`, `acceptance_date`, `ext_deadline`, `ext_acceptance_date`, `commitee`, `topic`, `fee`, `stare`, `obs`) VALUES
(1, 'Conference 1', '2017-06-20', '2017-06-11', '2017-06-15', NULL, NULL, NULL, 'Robotics', 50, 1, NULL),
(2, 'International Conference', '2017-06-10', '2017-05-21', '2017-06-01', NULL, NULL, NULL, 'Artificial intelligence', 150, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_notes`
--

CREATE TABLE `personal_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_favourite` tinyint(2) NOT NULL DEFAULT '0',
  `is_memento` tinyint(2) NOT NULL DEFAULT '0',
  `memo_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personal_notes`
--

INSERT INTO `personal_notes` (`id`, `title`, `icon`, `content`, `is_favourite`, `is_memento`, `memo_date`, `created_by`, `created_date`) VALUES
(6, 'Evalueaza propunerile ramase', '', 'Din lista de propuneri', 1, 0, NULL, 17, '2017-05-22 18:26:23'),
(7, 'Nu uita de conferinta', '', 'Nu uita', 0, 0, NULL, 17, '2017-05-22 18:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `propuneri`
--

CREATE TABLE `propuneri` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `conf_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL COMMENT 'speaker',
  `abstract` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `stare` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 - default; 2 - approved; 3 - rejected;',
  `created_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `propuneri`
--

INSERT INTO `propuneri` (`id`, `title`, `conf_id`, `author_id`, `abstract`, `keywords`, `file_path`, `stare`, `created_date`) VALUES
(1, 'Propunere 1', 1, 16, 'abs', 'key', NULL, 2, '2017-05-22 14:42:54'),
(2, 'Propunere 2', 1, 26, 'Abstract', 'Keywords', NULL, 2, '2017-05-26 17:40:29'),
(3, 'Propunere 3', 1, 28, 'Test abstract', 'Test keywords', NULL, 1, '2017-05-26 18:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `id` int(11) NOT NULL,
  `propunere_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewers`
--

INSERT INTO `reviewers` (`id`, `propunere_id`, `user_id`) VALUES
(1, 1, 17),
(5, 2, 27);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `propunere_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `calificativ` int(11) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `propunere_id`, `reviewer_id`, `calificativ`, `obs`, `created_date`) VALUES
(2, 1, 17, 1, 'Aroape bine, mai sunt cateva puncte de imbunatatit', '2017-05-26 18:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Speaker'),
(2, 'Reviewer'),
(3, 'Chair'),
(4, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `id` int(11) NOT NULL,
  `nume` varchar(250) CHARACTER SET latin2 NOT NULL,
  `password` varchar(250) CHARACTER SET latin2 NOT NULL,
  `email` varchar(250) CHARACTER SET latin2 NOT NULL,
  `afiliere` varchar(255) NOT NULL,
  `webpage` varchar(255) DEFAULT NULL,
  `rank` tinyint(1) NOT NULL,
  `stare` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - inactiv; 1 - activ;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `password`, `email`, `afiliere`, `webpage`, `rank`, `stare`) VALUES
(1, 'Rank 4 Admin', 'rank4', 'rank4@sample.com', 'DevOps', NULL, 4, 1),
(9, 'Rank 3 Chair', 'rank3', 'rank3@sample.com', 'Profesor', NULL, 3, 1),
(16, 'Rank 1 Speaker', 'rank1', 'rank1@sample.com', 'Inginer', NULL, 1, 1),
(17, 'Rank 2 Reviewer', 'rank2', 'rank2@sample.com', 'Arhitect', NULL, 2, 1),
(26, 'Speaker 1', 'speaker1', 'speaker1@sample.com', 'Software Development', NULL, 1, 1),
(27, 'Reviewer 2', 'reviewer2', 'reviewer2@sample.com', 'Robotics', NULL, 2, 1),
(28, 'Speaker 3', 'speaker3', 'speaker3@sample.com', 'Inginer', NULL, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anunturi`
--
ALTER TABLE `anunturi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arhiva`
--
ALTER TABLE `arhiva`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commites`
--
ALTER TABLE `commites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conferinte`
--
ALTER TABLE `conferinte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_notes`
--
ALTER TABLE `personal_notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `propuneri`
--
ALTER TABLE `propuneri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anunturi`
--
ALTER TABLE `anunturi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `arhiva`
--
ALTER TABLE `arhiva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `commites`
--
ALTER TABLE `commites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `conferinte`
--
ALTER TABLE `conferinte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `personal_notes`
--
ALTER TABLE `personal_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `propuneri`
--
ALTER TABLE `propuneri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
