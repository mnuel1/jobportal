-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 01:25 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobsearchv1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$K1astOBWwu.EzF9DDM7mRuco38WDit6/RMGPewmzr/CnjmCph3aJa');

-- --------------------------------------------------------

--
-- Table structure for table `apply_job_post`
--

CREATE TABLE `apply_job_post` (
  `id_apply` int(11) NOT NULL,
  `id_jobpost` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apply_job_post`
--

INSERT INTO `apply_job_post` (`id_apply`, `id_jobpost`, `id_users`, `status`, `createdAt`) VALUES
(1, 25, 4, 3, '2024-09-22 16:00:00'),
(2, 2, 4, 2, '2024-09-22 16:00:00'),
(3, 3, 4, 0, '2024-09-22 16:00:00'),
(4, 4, 4, 0, '2024-09-22 16:00:00'),
(5, 5, 4, 0, '2024-09-22 16:00:00'),
(6, 6, 4, 0, '2024-09-22 16:00:00'),
(7, 7, 4, 0, '2024-09-22 16:00:00'),
(8, 8, 4, 0, '2024-09-22 16:00:00'),
(9, 9, 4, 0, '2024-09-22 16:00:00'),
(10, 10, 4, 0, '2024-09-22 16:00:00'),
(12, 12, 4, 0, '2024-09-22 16:00:00'),
(13, 13, 4, 0, '2024-09-22 16:00:00'),
(14, 14, 4, 0, '2024-09-22 16:00:00'),
(16, 25, 4, 0, '2024-09-25 22:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `baranggay`
--

CREATE TABLE `baranggay` (
  `baranggay_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `zipcode` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baranggay`
--

INSERT INTO `baranggay` (`baranggay_id`, `name`, `zipcode`) VALUES
(1, 'Bagumbayan', '1630'),
(2, 'Bagong Tanyag', '1632'),
(3, 'Bambang', '1637'),
(4, 'Calzada', '1632'),
(5, 'Central Bicutan', '1631'),
(6, 'Central Signal Village', '1631'),
(7, 'Fort Bonifacio', '1630'),
(8, 'Hagonoy', '1630'),
(9, 'Ibayo-Tipas', '1637'),
(10, 'Ligid-Tipas', '1637'),
(11, 'Lower Bicutan', '1632'),
(12, 'Maharlika Village', '1631'),
(13, 'Napindan', '1633'),
(14, 'New Lower Bicutan', '1632'),
(15, 'North Daang Hari', '1632'),
(16, 'North Signal Village', '1631'),
(17, 'Palingon', '1630'),
(18, 'Pinagsama', '1634'),
(19, 'San Miguel', '1630'),
(20, 'Santa Ana', '1630'),
(21, 'South Daang Hari', '1632'),
(22, 'South Signal Village', '1631'),
(23, 'Tuktukan', '1637'),
(24, 'Upper Bicutan', '1633'),
(25, 'Ususan', '1638'),
(26, 'Wawa', '1637'),
(27, 'Western Bicutan', '1630');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id_company` int(11) NOT NULL,
  `baranggay_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `companyname` varchar(200) NOT NULL,
  `contactno` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `aboutme` varchar(200) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 2,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id_company`, `baranggay_id`, `name`, `companyname`, `contactno`, `website`, `email`, `password`, `aboutme`, `logo`, `active`, `createdAt`) VALUES
(1, 1, 'Juan Dela Cruz', 'Dela Cruz Manufacturing', '09171234567', 'www.delacruzmfg.com', 'juan@delacruzmfg.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'A leading manufacturing company in the Philippines.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(2, 2, 'Maria Santos', 'Santos Trading', '09181234567', 'www.santostrading.com', 'maria@santostrading.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'We specialize in trade and import services.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(3, 3, 'Pedro Reyes', 'Reyes Construction', '09192234567', 'www.reyescon.com', 'pedro@reyescon.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Construction company specializing in commercial projects.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(4, 4, 'Ana Garcia', 'Garcia Food Products', '09173214567', 'www.garciafoods.com', 'ana@garciafoods.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Producer of premium food products.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(5, 5, 'Jose Ramos', 'Ramos IT Solutions', '09174214567', 'www.ramositsolutions.com', 'jose@ramositsolutions.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'IT solutions provider for small businesses.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(6, 6, 'Emily Cruz', 'Cruz Logistics', '09175214567', 'www.cruzlogistics.com', 'emily@cruzlogistics.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Logistics and supply chain management company.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(7, 7, 'Michael De Leon', 'De Leon Pharmaceuticals', '09176214567', 'www.deleonpharma.com', 'michael@deleonpharma.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Leading pharmaceutical company.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(8, 8, 'Karla Mendoza', 'Mendoza Marketing', '09177214567', 'www.mendozamarketing.com', 'karla@mendozamarketing.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Marketing and advertising solutions provider.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(9, 9, 'Luis Villanueva', 'Villanueva Realty', '09178214567', 'www.villanuevarealty.com', 'luis@villanuevarealty.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Real estate development and brokerage firm.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(10, 10, 'Carmen Bautista', 'Bautista Legal Services', '09179214567', 'www.bautistalegal.com', 'carmen@bautistalegal.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Full-service law firm specializing in corporate law.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(12, 12, 'Beatriz Lim', 'Lim Architecture', '09181234568', 'www.limarchitecture.com', 'beatriz@limarchitecture.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Architectural design and consultancy services.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(13, 13, 'Rafael Gonzales', 'Gonzales Apparel', '09192234568', 'www.gonzalesapparel.com', 'rafael@gonzalesapparel.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Retailer of high-end apparel and fashion.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(14, 14, 'Sophia Rivera', 'Rivera Travel Agency', '09173214568', 'www.riveratravel.com', 'sophia@riveratravel.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Travel and tour services.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(15, 15, 'David Castillo', 'Castillo Security Systems', '09174214568', 'www.castillosecurity.com', 'david@castillosecurity.com', '$2y$10$4rKJZ9GlLOS.0vL.c3a29edyo0Nz.wbKiSBqc.PXi.uGuzre30kiq', 'Providing security solutions and services.', '59d3a01dc8209.png', 1, '2024-09-22 16:00:00'),
(17, 1, 'Juan Delacruz', 'Juan Corporation', '1111111111', 'facebook.com', 'juancorp@gmail.com', '$2y$10$wqstmQi0aQDSnU6HQlcWzOhTVCpiiFytzNtNf9mWcfdDhaaRiaTQi', 'brief is about meyesyesyesyes', '66f29cdf79c32.png', 1, '2024-09-24 11:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `job_post`
--

CREATE TABLE `job_post` (
  `id_jobpost` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  `jobtitle` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `minimumsalary` double NOT NULL,
  `maximumsalary` double NOT NULL,
  `experience` int(11) NOT NULL,
  `qualification` varchar(200) NOT NULL,
  `job_type` enum('Full Time','Part Time','','') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_post`
--

INSERT INTO `job_post` (`id_jobpost`, `id_company`, `jobtitle`, `description`, `minimumsalary`, `maximumsalary`, `experience`, `qualification`, `job_type`, `createdAt`) VALUES
(1, 1, 'Software Engineer', 'Develop and maintain software applications.', 40000, 60000, 2, 'Bachelor\'s Degree in Computer Science or related field', 'Full Time', '2024-09-22 16:00:00'),
(2, 2, 'Marketing Specialist', 'Create and execute marketing strategies to promote products.', 30000, 45000, 1, 'Bachelor\'s Degree in Marketing, Communications or related field', 'Full Time', '2024-09-22 16:00:00'),
(3, 3, 'Construction Project Manager', 'Oversee construction projects from planning to completion.', 60000, 90000, 5, 'Degree in Civil Engineering or related field', 'Full Time', '2024-09-22 16:00:00'),
(4, 4, 'Sales Representative', 'Promote and sell food products to clients.', 25000, 40000, 1, 'Experience in Sales, Marketing, or a related field', 'Full Time', '2024-09-22 16:00:00'),
(5, 5, 'IT Support Specialist', 'Provide technical support to internal and external users.', 25000, 35000, 2, 'Degree in IT or equivalent experience', 'Full Time', '2024-09-22 16:00:00'),
(6, 6, 'Logistics Coordinator', 'Coordinate and manage transportation and supply chain operations.', 28000, 42000, 3, 'Degree in Supply Chain Management or equivalent', 'Full Time', '2024-09-22 16:00:00'),
(7, 7, 'Pharmaceutical Sales Representative', 'Promote pharmaceutical products to healthcare professionals.', 30000, 50000, 2, 'Bachelor\'s Degree in Business, Marketing, or related field', 'Full Time', '2024-09-22 16:00:00'),
(8, 8, 'Digital Marketing Manager', 'Lead digital marketing efforts including SEO and social media.', 40000, 70000, 3, 'Experience in Digital Marketing, SEO, and SEM', 'Full Time', '2024-09-22 16:00:00'),
(9, 9, 'Real Estate Agent', 'Assist clients in buying, selling, and renting properties.', 20000, 60000, 2, 'Real Estate License and experience in sales', 'Full Time', '2024-09-22 16:00:00'),
(10, 10, 'Legal Associate', 'Assist lawyers in legal documentation and research.', 45000, 70000, 1, 'Degree in Law or related field, Bar exam passer', 'Full Time', '2024-09-22 16:00:00'),
(12, 12, 'Architect', 'Design and oversee the construction of buildings and infrastructure.', 60000, 100000, 5, 'Degree in Architecture, PRC license', 'Full Time', '2024-09-22 16:00:00'),
(13, 13, 'Fashion Designer', 'Create and design new clothing lines for retail.', 30000, 60000, 3, 'Experience in Fashion Design, degree preferred', 'Full Time', '2024-09-22 16:00:00'),
(14, 14, 'Travel Consultant', 'Provide travel planning services and customer support.', 20000, 35000, 2, 'Experience in travel industry or tourism, degree preferred', 'Full Time', '2024-09-22 16:00:00'),
(16, 17, 'I am looking for you maybe thats you ', '', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:18:31'),
(17, 17, 'I am looking for you maybe thats you ', '<p>I need someone to be you</p>', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:19:06'),
(18, 17, 'I am looking for you maybe thats you ', '', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:19:30'),
(19, 17, 'I am looking for you maybe thats you ', '<p>you and you</p>', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:19:40'),
(20, 17, 'I am looking for you maybe thats you ', '', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:20:22'),
(21, 17, 'I am looking for you maybe thats you ', '<p>yes you</p>', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:20:25'),
(22, 17, 'I am looking for you maybe thats you ', '<p>yes you</p>', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:21:53'),
(23, 17, 'I am looking for you maybe thats you ', '<p>adadasdasdasd</p>', 10000, 20000, 3, 'qualified enough to be you', 'Full Time', '2024-09-25 16:21:57'),
(24, 17, 'sadadas', '<p>adadadada</p>', 10000, 1000000, 2, 'qualified enough to be you', 'Full Time', '2024-09-25 16:22:45'),
(25, 17, 'lets try again', '<p>yes you read it right</p>', 10000, 10000, 2, 'qualified enough to be you', 'Full Time', '2024-09-25 16:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `mailbox`
--

CREATE TABLE `mailbox` (
  `id_mailbox` int(11) NOT NULL,
  `id_fromuser` int(11) NOT NULL,
  `fromuser` varchar(255) NOT NULL,
  `id_touser` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `mailbox`
--

INSERT INTO `mailbox` (`id_mailbox`, `id_fromuser`, `fromuser`, `id_touser`, `subject`, `message`, `createdAt`) VALUES
(6, 10, 'user', 12, 'hi', '<p>thanks</p>', '2017-10-03 16:12:52'),
(7, 17, 'company', 4, 'hi', '<p><strong>hi</strong></p>', '2019-08-10 12:57:04'),
(8, 4, 'user', 1, '', '', '2024-09-24 19:58:10'),
(9, 4, 'user', 1, 'whyyyy', '', '2024-09-24 19:59:55'),
(10, 4, 'user', 1, 'whyyyy', '<p>WHY DID YOU DO THAT</p>', '2024-09-24 20:00:31'),
(11, 4, 'user', 1, 'whyyyy', '<p>WHY DID YOU DO THAT&lt;p&gt;&lt;strong&gt;hi&lt;/strong&gt;&lt;/p&gt;</p>', '2024-09-24 20:00:59'),
(12, 4, 'user', 1, 'whyyyy', '<p><strong>WHY DID YOU DO THA</strong>T&lt;p&gt;&lt;strong&gt;hi&lt;/strong&gt;&lt;/p&gt;</p>', '2024-09-24 20:01:11'),
(13, 4, 'user', 1, 'whyyyy', '<p><strong>WHY DID YOU DO THA</strong>T</p>', '2024-09-24 20:01:21'),
(14, 4, 'user', 1, 'whyyyy', '<p>WHY DID YOU DO THAT</p>', '2024-09-24 20:01:27'),
(17, 17, 'company', 4, 'close your eyes', '<p>because i close my eyes</p>', '2024-09-25 20:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `reply_mailbox`
--

CREATE TABLE `reply_mailbox` (
  `id_reply` int(11) NOT NULL,
  `id_mailbox` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reply_mailbox`
--

INSERT INTO `reply_mailbox` (`id_reply`, `id_mailbox`, `id_user`, `usertype`, `message`, `createdAt`) VALUES
(1, 7, 4, 'user', '<p>nsc;nc;</p>', '2019-08-10 12:58:12'),
(2, 7, 17, 'company', '<p>okay okay i close my eeyes</p>', '2024-09-25 20:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `baranggay_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contactno` varchar(200) NOT NULL,
  `qualification` varchar(200) NOT NULL,
  `stream` varchar(200) NOT NULL,
  `passingyear` varchar(200) NOT NULL,
  `dob` varchar(200) NOT NULL,
  `age` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `resume` varchar(200) NOT NULL,
  `skills` varchar(200) NOT NULL,
  `aboutme` varchar(200) NOT NULL,
  `work_type` enum('Part Time','Full Time','','') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `baranggay_id`, `firstname`, `lastname`, `email`, `password`, `address`, `contactno`, `qualification`, `stream`, `passingyear`, `dob`, `age`, `designation`, `resume`, `skills`, `aboutme`, `work_type`, `active`) VALUES
(1, 1, 'Manuel', 'Marin', 'asdasdasdas@gmail.com', '$2y$10$k9g/UcJrfud3nbWFN.hIWO/ry0mNfeagSjcfKeHIbDfYq.oSWXuPS', 'my address is right there at the back of 8/12', '0968601292', 'qualified enough', 'go stream my live', '2024-09-24', '1998-01-10', '26', 'im designated to everything', '66f25904675d6.pdf', 'my skill is being me', 'about me is about you', 'Part Time', 1),
(4, 2, 'Juan ', 'Dela Cruz', 'abc888043@gmail.com', '$2y$10$tIdGZeKFnLPWzkK6.02jdOOj27fQHvAAxDfhzgJfnmUpgR1o6rS8e', 'Address', '0912345678', 'qualified enough', 'go stream my live', '2024-09-23', '1999-01-24', '25', 'im designated to everything', '66f273d313cec.pdf', 'skillzasdaasdasd', 'about me', 'Full Time', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `apply_job_post`
--
ALTER TABLE `apply_job_post`
  ADD PRIMARY KEY (`id_apply`),
  ADD KEY `jobpost` (`id_jobpost`),
  ADD KEY `user` (`id_users`);

--
-- Indexes for table `baranggay`
--
ALTER TABLE `baranggay`
  ADD PRIMARY KEY (`baranggay_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id_company`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `baranggay` (`baranggay_id`);

--
-- Indexes for table `job_post`
--
ALTER TABLE `job_post`
  ADD PRIMARY KEY (`id_jobpost`),
  ADD KEY `company` (`id_company`);

--
-- Indexes for table `mailbox`
--
ALTER TABLE `mailbox`
  ADD PRIMARY KEY (`id_mailbox`);

--
-- Indexes for table `reply_mailbox`
--
ALTER TABLE `reply_mailbox`
  ADD PRIMARY KEY (`id_reply`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD KEY `baranggay-user` (`baranggay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apply_job_post`
--
ALTER TABLE `apply_job_post`
  MODIFY `id_apply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `baranggay`
--
ALTER TABLE `baranggay`
  MODIFY `baranggay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id_company` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `job_post`
--
ALTER TABLE `job_post`
  MODIFY `id_jobpost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mailbox`
--
ALTER TABLE `mailbox`
  MODIFY `id_mailbox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reply_mailbox`
--
ALTER TABLE `reply_mailbox`
  MODIFY `id_reply` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apply_job_post`
--
ALTER TABLE `apply_job_post`
  ADD CONSTRAINT `jobpost` FOREIGN KEY (`id_jobpost`) REFERENCES `job_post` (`id_jobpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `baranggay` FOREIGN KEY (`baranggay_id`) REFERENCES `baranggay` (`baranggay_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_post`
--
ALTER TABLE `job_post`
  ADD CONSTRAINT `company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `baranggay-user` FOREIGN KEY (`baranggay_id`) REFERENCES `baranggay` (`baranggay_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
