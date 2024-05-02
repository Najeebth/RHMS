-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2019 at 07:42 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_house`
--

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contract_id` int(3) NOT NULL,
  `tenant_id` int(3) NOT NULL,
  `house_id` int(3) NOT NULL,
  `duration_month` int(2) NOT NULL,
  `total_rent` int(7) NOT NULL,
  `terms` int(2) NOT NULL,
  `rent_per_term` int(7) NOT NULL,
  `start_day` date NOT NULL,
  `end_day` date NOT NULL,
  `date_contract_sign` datetime NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`contract_id`, `tenant_id`, `house_id`, `duration_month`, `total_rent`, `terms`, `rent_per_term`, `start_day`, `end_day`, `date_contract_sign`, `status`) VALUES
(1, 1, 2, 12, 720000, 2, 360000, '2019-08-01', '2020-07-31', '2019-08-07 20:40:22', 'Active'),
(4, 5, 1, 3, 240000, 1, 240000, '2019-08-01', '2019-10-31', '2019-08-07 00:18:18', 'Active'),
(5, 6, 4, 12, 840000, 4, 210000, '2019-08-01', '2020-07-31', '2019-08-07 00:25:47', 'Active'),
(8, 9, 6, 6, 480000, 2, 240000, '2019-07-01', '2019-12-31', '2019-07-15 02:52:34', 'Active'),
(9, 4, 2, 3, 180000, 1, 180000, '2019-08-01', '2019-07-20', '2019-07-19 03:12:17', 'Inactive'),
(12, 10, 2, 12, 720000, 4, 180000, '2019-07-01', '2020-06-30', '2019-07-23 12:20:10', 'Inactive'),
(15, 4, 7, 3, 180000, 1, 180000, '2019-08-01', '2019-10-31', '2019-08-04 00:18:11', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

CREATE TABLE `house` (
  `house_id` int(3) NOT NULL,
  `house_name` varchar(10) NOT NULL,
  `compartment` text NOT NULL,
  `rent_per_month` int(6) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_id`, `house_name`, `compartment`, `rent_per_month`, `status`) VALUES
(1, 'A10', 'Yes', 80000, 'Occupied'),
(2, 'A20', 'No', 60000, 'Occupied'),
(3, 'D30', 'No', 60000, 'Empty'),
(4, 'C40', 'Yes', 70000, 'Occupied'),
(6, 'A30', 'Yes', 80000, 'Occupied'),
(7, 'A40', 'No', 60000, 'Occupied'),
(8, 'B30', 'Yes', 70000, 'Empty'),
(9, 'G56', 'Yes', 80000, 'Empty');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(3) NOT NULL,
  `tenant_id` int(7) NOT NULL,
  `ref_no` varchar(11) NOT NULL,
  `amount` int(7) NOT NULL,
  `pay_from` text NOT NULL,
  `pay_to` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `tenant_id`, `ref_no`, `amount`, `pay_from`, `pay_to`, `date`) VALUES
(2, 4, '2147483647', 180000, 'August 2019', 'October 2019', '2019-08-08 11:11:19'),
(4, 4, '8654712358', 180000, 'February 2020', 'April 2020', '2019-08-08 12:56:45'),
(5, 6, '784156978', 210000, 'August 2019', 'October 2019', '2019-08-08 13:10:15'),
(6, 6, '7456257832', 210000, 'November 2019', 'January 2020', '2019-08-08 13:40:31'),
(7, 6, '39222962841', 210000, 'February 2020', 'April 2020', '2019-08-08 14:15:58'),
(8, 5, '1551327804', 240000, 'August 2019', 'October 2019', '2019-08-09 14:24:29'),
(9, 6, '71308220851', 60000, 'May 2020', 'June 2020', '2019-08-14 11:06:25'),
(10, 6, '72912660562', 70000, 'June 2020', 'July 2020', '2019-08-14 11:22:13'),
(11, 6, '36480604749', 30000, 'August 2020', 'August 2020', '2019-08-14 11:30:35'),
(12, 9, '2099451721', 150000, 'August 2019', 'October 2019', '2019-08-15 10:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenant_id` int(3) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `programme` varchar(30) NOT NULL,
  `reg_no` varchar(20) NOT NULL,
  `occupation` text NOT NULL,
  `p_no` varchar(15) NOT NULL,
  `pno1` varchar(15) NOT NULL,
  `e_address` varchar(30) NOT NULL,
  `p_address` varchar(40) NOT NULL,
  `city` varchar(15) NOT NULL,
  `region` varchar(15) NOT NULL,
  `u_name` text NOT NULL,
  `p_word` text NOT NULL,
  `day_reg` date NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenant_id`, `fname`, `lname`, `programme`, `reg_no`, `occupation`, `p_no`, `pno1`, `e_address`, `p_address`, `city`, `region`, `u_name`, `p_word`, `day_reg`, `status`) VALUES
(1, 'Faith', 'Tunzo', 'BSc. IT', 'BSc-IT-18389', '', '255717812676', '255746553132', 'faithtunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'hope', '8f38430f9d60b28e01fd3248dc025b2d', '2019-07-14', 0),
(4, 'Genny', 'Mnzava', '', '', 'Lecturer', '', '255746553132', 'genesisf@yahoo.com', '2522, Arusha', 'Arusha', 'Arusha', 'geneswaa', 'fe3742082b02380c86075d11ba88ebc0', '2019-07-14', 1),
(5, 'Agape', 'Tunzo', '', '', 'Saleswoman', '255717812676', '255746553132', 'agapemnzava@yahoo.com', '2522, Arusha', 'Arusha', 'Arusha', 'narindwa', '144d87c8323749c9bf3f0c71d3182f9d', '2019-07-14', 1),
(6, 'Emma', 'Tunzo', '', '', 'Teacher', '255717812676', '255746553132', 'emanueltunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'emanuel', '25f9e794323b453885f5181f1b624d0b', '2019-07-15', 1),
(9, 'Andy', 'Tunzo', '', '', 'Manager', '255717812676', '255746553132', 'andy123@hotmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'andrew', 'd41555c72445d4a3b05de048fe5f3e0d', '2019-07-15', 1),
(10, 'Love', 'Faith', '', '', 'Assistant Manager', '255717812676', '255746553132', 'faithtunzo@google.com', '2522, Arusha', 'Arusha', 'Arusha', 'loveness', 'e807f1fcf82d132f9bb018ca6738a19f', '2019-07-23', 2),
(11, 'qwert', 'yuiop', '', '', 'Plumber', '0784565656', '0784565656', 'faith.tunzo@yahoo.com', '345,Iringa', 'Iringa', 'Iringa', 'asdfg', '123456789', '2019-08-04', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_contacts`
--

CREATE TABLE `tenant_contacts` (
  `contact_id` int(3) NOT NULL,
  `tenant_id` int(3) NOT NULL,
  `fname1` text NOT NULL,
  `lname1` text NOT NULL,
  `occupation1` text NOT NULL,
  `nature1` text NOT NULL,
  `pno1` varchar(15) NOT NULL,
  `pno2` varchar(15) NOT NULL,
  `e_address1` varchar(30) NOT NULL,
  `p_address1` varchar(40) NOT NULL,
  `city1` varchar(15) NOT NULL,
  `region1` varchar(15) NOT NULL,
  `fname2` text NOT NULL,
  `lname2` text NOT NULL,
  `occupation2` text NOT NULL,
  `nature2` text NOT NULL,
  `pno3` varchar(15) NOT NULL,
  `pno4` varchar(15) NOT NULL,
  `e_address2` varchar(30) NOT NULL,
  `p_address2` varchar(40) NOT NULL,
  `city2` varchar(15) NOT NULL,
  `region2` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_contacts`
--

INSERT INTO `tenant_contacts` (`contact_id`, `tenant_id`, `fname1`, `lname1`, `occupation1`, `nature1`, `pno1`, `pno2`, `e_address1`, `p_address1`, `city1`, `region1`, `fname2`, `lname2`, `occupation2`, `nature2`, `pno3`, `pno4`, `e_address2`, `p_address2`, `city2`, `region2`) VALUES
(1, 1, 'Twazihirwa', 'Mnzava', 'Lecturer', 'Daddy', '0784949021', '0717225082', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Teacher', 'Mom', '0754698589', '0658698589', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(4, 4, 'Tunzo', 'Mnzava', 'Lecturer', 'Grandfather', '0712121212', '0745121212', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Teacher', 'Grandmother', '0745151515', '0754151515', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(5, 5, 'Tunzo', 'Mnzava', 'Lecturer', 'Daddy', '0712121212', '0745121212', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Lecturer', 'Mom', '0745151515', '0754151515', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(6, 6, 'Tunzo', 'Mnzava', 'Lecturer', 'Daddy', '0712121212', '0745121212', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Teacher', 'Mom', '0745151515', '0754151515', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(9, 9, 'Tunzo', 'Mnzava', 'Lecturer', 'Daddy', '0712121212', '0745121212', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Lecturer', 'Mom', '0745151515', '0754151515', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(11, 10, 'Tunzo', 'Mnzava', 'Lecturer', 'Grandfather', '0712121212', '0745121212', 'mnzavatunzo@gmail.com', '2522, Arusha', 'Arusha', 'Arusha', 'Gloria', 'Mnzava', 'Teacher', 'Grand mother', '0745151515', '0754151515', 'gloriamzava@gmail.com', '2522, Arusha', 'Arusha', 'Arusha'),
(12, 11, 'Tunzo', 'Mnzava', 'Lecturer', 'dad', '0717454545', '0745151515', '', '54, Arusha', 'Arusha', 'Arusha', 'Glory', 'Mnzava', 'Lecturer', 'mom', '0745151515', '0717454545', '', '54, Arusha', 'Arusha', 'Arusha');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_in`
--

CREATE TABLE `tenant_in` (
  `in_id` int(3) NOT NULL,
  `contract_id` int(3) NOT NULL,
  `stat_keyholder` text NOT NULL,
  `stat_electricityRemote` text NOT NULL,
  `no_bulbs` int(2) NOT NULL,
  `stat_bulbs` text NOT NULL,
  `stat_paint` text NOT NULL,
  `stat_Windows` text NOT NULL,
  `stat_toiletSink` text NOT NULL,
  `stat_washingSink` text NOT NULL,
  `stat_doorLock` text NOT NULL,
  `stat_toiletDoorLock` text NOT NULL,
  `water_units` int(5) NOT NULL,
  `comments` text NOT NULL,
  `date_reg` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='"stat" represents the status/condition of an item';

--
-- Dumping data for table `tenant_in`
--

INSERT INTO `tenant_in` (`in_id`, `contract_id`, `stat_keyholder`, `stat_electricityRemote`, `no_bulbs`, `stat_bulbs`, `stat_paint`, `stat_Windows`, `stat_toiletSink`, `stat_washingSink`, `stat_doorLock`, `stat_toiletDoorLock`, `water_units`, `comments`, `date_reg`, `status`) VALUES
(1, 5, 'Good', 'Average', 2, 'Good', 'Average', 'Average', 'Broken', 'Average', 'Average', 'Average', 123, 'Please fix', '2019-08-08', 'Checked');

-- --------------------------------------------------------

--
-- Table structure for table `tenant_out`
--

CREATE TABLE `tenant_out` (
  `out_id` int(3) NOT NULL,
  `contract_id` int(3) NOT NULL,
  `stat_keyholder` text NOT NULL,
  `stat_electricityRemote` text NOT NULL,
  `no_bulbs` int(2) NOT NULL,
  `stat_bulbs` text NOT NULL,
  `stat_paint` text NOT NULL,
  `stat_Windows` text NOT NULL,
  `stat_toiletSink` text NOT NULL,
  `stat_washingSink` text NOT NULL,
  `stat_doorLock` text NOT NULL,
  `stat_toiletDoorLock` text NOT NULL,
  `comments` text NOT NULL,
  `date_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant_out`
--

INSERT INTO `tenant_out` (`out_id`, `contract_id`, `stat_keyholder`, `stat_electricityRemote`, `no_bulbs`, `stat_bulbs`, `stat_paint`, `stat_Windows`, `stat_toiletSink`, `stat_washingSink`, `stat_doorLock`, `stat_toiletDoorLock`, `comments`, `date_reg`) VALUES
(1, 9, 'Good', 'Good', 2, 'Average', 'Good', 'Good', 'Good', 'Good', 'Average', 'Average', 'Gotta Pay', '2019-08-08'),
(2, 12, 'No key holder', 'Bad', 1, 'Some missing', 'Average', 'Good', 'Average', 'Good', 'Good', 'Average', 'Has to pay', '2019-08-12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(3) NOT NULL,
  `name` text NOT NULL,
  `role` text NOT NULL,
  `pno` varchar(15) NOT NULL,
  `u_name` varchar(10) NOT NULL,
  `pword` text NOT NULL,
  `date_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `role`, `pno`, `u_name`, `pword`, `date_reg`) VALUES
(1, 'RHMS', 'Administrator', '255717812676', 'Admin', '200ceb26807d6bf99fd6f4f0d1ca54d4', '2019-07-15'),
(2, 'Juma Jux', 'Manager', '255787966996', 'JJ', 'e807f1fcf82d132f9bb018ca6738a19f', '2019-08-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contract_id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`house_id`),
  ADD UNIQUE KEY `house_name` (`house_name`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `ref_no` (`ref_no`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenant_id`);

--
-- Indexes for table `tenant_contacts`
--
ALTER TABLE `tenant_contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `tenant_in`
--
ALTER TABLE `tenant_in`
  ADD PRIMARY KEY (`in_id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Indexes for table `tenant_out`
--
ALTER TABLE `tenant_out`
  ADD PRIMARY KEY (`out_id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `contract_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `house`
--
ALTER TABLE `house`
  MODIFY `house_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenant_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tenant_contacts`
--
ALTER TABLE `tenant_contacts`
  MODIFY `contact_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tenant_in`
--
ALTER TABLE `tenant_in`
  MODIFY `in_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tenant_out`
--
ALTER TABLE `tenant_out`
  MODIFY `out_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `house` (`house_id`),
  ADD CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`ref_no`) REFERENCES `tuma_pesa`.`transaction` (`ref_no`);

--
-- Constraints for table `tenant_contacts`
--
ALTER TABLE `tenant_contacts`
  ADD CONSTRAINT `tenant_contacts_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenant` (`tenant_id`);

--
-- Constraints for table `tenant_in`
--
ALTER TABLE `tenant_in`
  ADD CONSTRAINT `tenant_in_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contract` (`contract_id`);

--
-- Constraints for table `tenant_out`
--
ALTER TABLE `tenant_out`
  ADD CONSTRAINT `tenant_out_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contract` (`contract_id`);

--
-- Table structure for table `room_rental_registrations`
--

CREATE TABLE `room_rental_registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alternat_mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `landmark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sale` varchar(190) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plot_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rooms` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accommodation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open_for_sharing` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacant` int(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_rental_registrations`
--

INSERT INTO `room_rental_registrations` (`id`, `fullname`, `mobile`, `alternat_mobile`, `email`, `country`, `state`, `city`, `landmark`, `rent`, `sale`, `deposit`, `plot_number`, `rooms`, `address`, `accommodation`, `description`, `image`, `open_for_sharing`, `other`, `vacant`, `created_at`, `updated_at`, `user_id`) VALUES
(13, 'Liam Moore', '7777788888', '6666666656', 'admin@admin.com', 'US', 'AZ', 'Phoenix', 'test', '565', '19500', '8000', '78 nh', '2 BHK', '110 Dt St', '4', 'dssd', 'uploads/sample_image.jpg', NULL, 'zx', 0, '2018-02-16 12:21:43', '2018-02-16 12:21:43', 1),
(14, 'Lizabeth', '5555555550', '1470000000', 'lizb@mail.com', 'US', 'LA', 'Lafayette', 'test', '880', '23330', '10000', '70 nh', '1 BHK', '5569 St Fran Road', '', '', 'uploads/sample_image.jpg', NULL, NULL, 1, '2018-03-09 05:06:43', '2018-03-09 05:06:43', 2),
(15, 'Zeigger', '2222222222', '4444022222', 'admin@admmmin.com', 'US', 'IL', 'Dupo', 'test', '600', '18500', '10000', '69 nh', '1 BHK', '76 Ross Street', 'WiFi, Fridge', 'good to see', 'uploads/sample_image.jpg', NULL, NULL, 1, '2018-04-04 11:19:09', '2018-04-04 11:19:09', 1),
(16, 'Alex', '7896666666', '6666666665', 'alexm@mail.com', 'US', 'VA', 'Martinsville', 'test', '656', '20000', '10999', '78p', '2BHK', '4602 Douglas Rd', 'demo demo demo demo', 'Demo Description', 'uploads/sample_image.jpg', NULL, NULL, 1, '2021-11-29 15:23:02', '2021-11-29 15:23:02', 7),
(17, 'Demo Name', '7770000000', '7774440001', 'demo@demo.com', 'DemoCountry', 'DemoState', 'DemoCity', 'Demo Landmark', '555', '36000', '15200', 'D 8', '3 BHK', '770 DemoAddress', 'demo facilities', 'This is a demo description for testing!', 'uploads/sample_image.jpg', NULL, NULL, 1, '2021-11-29 16:03:03', '2021-11-29 16:03:03', 7);

-- --------------------------------------------------------


-- Indexes for table `room_rental_registrations`
--
ALTER TABLE `room_rental_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_rental_registrations_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `room_rental_registrations_email_unique` (`email`);


----
-- AUTO_INCREMENT for table `room_rental_registrations`
--
ALTER TABLE `room_rental_registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--


CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    plot_number VARCHAR(50) NOT NULL,
    tenant_id INT NOT NULL, -- Added user_id column
    
);

----------------------------------------------
CREATE TABLE messages (
    msg_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


------------------------------------------
CREATE TABLE inquiries (
    inquiry_id INT AUTO_INCREMENT PRIMARY KEY,
    house_id INT,
    tenant_id INT,
    landlord_id INT,
    inquiry_date DATE
);

ALTER TABLE inquiries
ADD COLUMN status VARCHAR(50); 

-------------------------------------------
CREATE TABLE paymentaccount (
    accountid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    accountholdername VARCHAR(255) NOT NULL,
    accountnumber VARCHAR(20) NOT NULL,
    bankname VARCHAR(255) NOT NULL,
    createdat DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE paymentaccount
ADD COLUMN password VARCHAR(255) NOT NULL;

---------------------------------------------
CREATE TABLE transactions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_accntid INT(10) NOT NULL,
    receiver_accntid INT(10) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description ENUM('rent', 'deposit') NOT NULL,
    pay_from_date DATE NOT NULL,
    pay_to_date DATE NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);




COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
