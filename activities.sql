-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2019 at 02:32 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `activities`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activityID` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `street` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_520_ci,
  `state` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `city` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `postal` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `name`, `street`, `description`, `state`, `city`, `postal`) VALUES
(1, 'McAuliffe-Shepard Discovery Center', '2 Institute Dr', 'The McAuliffe-Shepard Discovery Center is a museum of Earth and space science featuring interactive exhibits, an observatory, and a planetarium theater.', 'NH', 'Concord', '03301'),
(2, 'Regal Cinemas Concord 10', '282 Loudon Rd', 'Movie theater in Concord with comfortable seats and a small arcade.', 'NH', 'Concord', '03301'),
(3, 'Escape Room Concord NH', '240 Airport Rd', '\'Escape Rooms\' are games in which a small group of people are \'locked\' in a room and must find clues, solve puzzles, and solve riddles to escape the room. Note that the entrance doors are never locked, in case players need to leave to use the restroom or any other reason.', 'NH', 'Concord', '03301'),
(4, 'Capitol Center for the Arts', '44 South Main St', 'A non-profit performing arts theater that is home to The Chubb Theatre, The Spotlight Café and a large function room called The Governor\'s Hall. Performances can include broadway shows, pop and country stars, and dance performances.', 'NH', 'Concord', '03301'),
(5, 'NH Audubon McLane Center', '84 Silk Farm Rd', 'A wildlife refuge that is home to the Silk Farm Sanctuary, which has three wooded hiking trails. The facility also has indoor animal displays and an exhibit.', 'NH', 'Concord', '03301'),
(6, 'New Hampshire Historical Society', '30 Park St', 'A nonprofit organization that has been preserving New Hampshire\'s history since 1823.', 'NH', 'Concord', '03301'),
(7, 'Concord Craft Brewing Company', '117 Storrs St', 'A small batch craft brewery in downtown Concord with a beer store, tasting room, brewery tour, and gift shop.', 'NH', 'Concord', '03301');

-- --------------------------------------------------------

--
-- Table structure for table `activitytype`
--

CREATE TABLE `activitytype` (
  `typeID` bigint(20) UNSIGNED NOT NULL,
  `typeName` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `activitytype`
--

INSERT INTO `activitytype` (`typeID`, `typeName`) VALUES
(1, 'Museums'),
(2, 'Parks'),
(3, 'Entertainment'),
(4, 'Interactive');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `imageID` bigint(20) UNSIGNED NOT NULL,
  `activityID` bigint(20) UNSIGNED NOT NULL,
  `filePath` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `altText` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`imageID`, `activityID`, `filePath`, `altText`) VALUES
(1, 1, 'https://static1.squarespace.com/static/58aac884725e25c4fababc32/t/58f7741259cc681f3e85a57b/1492612115828/theatre-people.jpg', 'An audience gazing at the stars in the dome-shaped planetary theater'),
(2, 2, 'https://upload.wikimedia.org/wikipedia/commons/4/49/Regal_Cinemas_Concord_NH.jpg', 'The outside view of Regal Cinemas from the front'),
(3, 3, 'https://media-cdn.tripadvisor.com/media/photo-s/0f/b2/4c/6a/the-waiting-area.jpg', 'The red-bricked waiting room of the Escape Room building'),
(4, 4, 'https://ccanh.com/app/uploads/crowd.jpg', 'A crowd of an audience in the Chubb Theatre.'),
(5, 5, 'http://www.nhaudubon.org/wp-content/uploads/2010/10/McLane-Center.png', 'The front of the main building.'),
(6, 6, 'http://www.hlturner.com/images/NHHistoricalSociety.jpg', 'The front of the New Hampshire Historical Society building.'),
(7, 7, 'https://media-cdn.tripadvisor.com/media/photo-s/0e/6f/c4/4a/storefront.jpg', 'The front side of the Concord Craft Brewing Company Building, with the sign in-view.');

-- --------------------------------------------------------

--
-- Table structure for table `typeassoc`
--

CREATE TABLE `typeassoc` (
  `activityID` bigint(20) NOT NULL,
  `typeID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityID`),
  ADD UNIQUE KEY `activityID` (`activityID`) USING BTREE;

--
-- Indexes for table `activitytype`
--
ALTER TABLE `activitytype`
  ADD PRIMARY KEY (`typeID`),
  ADD UNIQUE KEY `typeID` (`typeID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imageID`),
  ADD UNIQUE KEY `imageID` (`imageID`),
  ADD KEY `image_activity` (`activityID`) USING BTREE;

--
-- Indexes for table `typeassoc`
--
ALTER TABLE `typeassoc`
  ADD PRIMARY KEY (`activityID`,`typeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `activitytype`
--
ALTER TABLE `activitytype`
  MODIFY `typeID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `imageID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_attraction` FOREIGN KEY (`activityID`) REFERENCES `activity` (`activityID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
