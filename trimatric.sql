-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 10:08 AM
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
-- Database: `trimatric`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'Architectural Design'),
(2, 'Interior Design'),
(3, 'Project Management');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `dist_id` int(11) NOT NULL,
  `dist_name` varchar(100) NOT NULL,
  `div_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`dist_id`, `dist_name`, `div_id`) VALUES
(11, 'Dhaka', 1),
(12, 'Gazipur', 1),
(13, 'Narayanganj', 1),
(21, 'Chattogram', 2),
(22, 'Cox\'s Bazar', 2),
(23, 'Cumilla', 2);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `div_id` int(11) NOT NULL,
  `div_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`div_id`, `div_name`) VALUES
(1, 'Dhaka'),
(2, 'Chattogram'),
(3, 'Khulna'),
(4, 'Rajshahi'),
(5, 'Barishal'),
(6, 'Sylhet'),
(7, 'Rangpur'),
(8, 'Mymensingh');

-- --------------------------------------------------------

--
-- Table structure for table `employee_info`
--

CREATE TABLE `employee_info` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nid` varchar(30) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `photo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_info`
--

INSERT INTO `employee_info` (`employee_id`, `employee_name`, `designation`, `unit_id`, `email`, `image`, `phone`, `address`, `gender`, `date_of_birth`, `nid`, `join_date`, `status`, `photo`) VALUES
(101, 'Ar. Tanvir Hossain', 'Senior Architect', 11, 'tanvir@company.com', NULL, '01711112222', 'House 1, Road 2, Banani, Dhaka', 'Male', '1985-01-10', '1990123456', '2022-03-01', 1, 'tanvir.jpg'),
(102, 'Ar. Nafisa Rahman', 'Junior Architect', 11, 'nafisa@company.com', NULL, '01822223333', 'Uttara, Dhaka', 'Female', '1992-05-15', '1992123456', '2023-01-15', 1, 'nafisa.jpg'),
(103, 'Md. Kamal Uddin', 'Draftsman', 11, 'kamal@company.com', NULL, '01933334444', 'Rampura, Dhaka', 'Male', '1989-09-09', '1989123456', '2022-06-10', 1, 'kamal.jpg'),
(104, 'Ar. Rashed Ahmed', 'BIM Specialist', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(105, 'Jannatul Ferdous', 'CAD Operator', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(106, 'Shakil Mahmud', 'BIM Modeler', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(107, 'Saiful Islam', 'Site Supervisor', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(108, 'Mizanur Rahman', 'Site Engineer', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(109, 'Sumaiya Sharmin', 'Project Coordinator', 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(110, 'Salma Akter', 'Interior Designer', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(111, 'Rashidul Hasan', 'Visualizer', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(112, 'Mahbubur Rahman', 'Client Coordinator', 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(113, 'Arifa Sultana', 'Senior Designer', 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(114, 'Sajjad Hossain', 'Space Planner', 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(115, 'Farzana Yeasmin', 'Design Assistant', 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(116, 'Tania Islam', 'Furniture Designer', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(117, 'Md. Sharif Hossain', '3D Modeler', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(118, 'Jamil Ahmed', 'Carpentry Supervisor', 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(119, 'Hasan Chowdhury', 'Planner', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(120, 'Tasnim Jahan', 'Scheduling Officer', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(121, 'Mahmudul Hasan', 'Cost Estimator', 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(122, 'Nazmul Huda', 'Procurement Officer', 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(123, 'Sharmin Sultana', 'Vendor Manager', 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(124, 'Moinul Islam', 'Logistics Coordinator', 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(125, 'Rubel Miah', 'QA Engineer', 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(126, 'Syeda Farzana', 'Quality Inspector', 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(127, 'Mamun Sarkar', 'Document Controller', 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(128, 'Hamid Ansari', 'Senior Architect', 12, 'hamid@gmail.com', NULL, '01859227761', NULL, NULL, NULL, NULL, NULL, 1, NULL),
(130, 'Hafiz', 'Architect', 11, 'abc@gmail.com', 'emp_687a4d546a2202.29809045.png', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '1978-01-31', '12211212', '1996-01-17', 1, NULL),
(131, 'Babu', 'HR Admin', 31, 'salahuddin081402@gmail.com', NULL, '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-21', '', '2025-07-14', 2, NULL),
(132, 'Iqbal', 'HR', 12, 'iqbal@gmail.com', 'emp_132_1752865742.png', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-15', '', '2025-07-31', 1, NULL),
(133, 'Jamal', 'HR', 11, 'jamal@gmail.com', 'emp_133_1752870470.jpeg', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-15', '12132', '2025-07-23', 1, NULL),
(134, 'shafiq', 'HR', 23, 'shafiq@gmail.com', 'emp_1752870666_205.jpeg', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-31', '2121212', '2025-07-02', 1, NULL),
(135, 'Kamal', 'HR', 12, 'salahuddin081402@gmail.com', 'emp_1753019098_955.png', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-16', '', '2025-07-24', 1, NULL),
(136, 'Jafar', 'HR', 11, 'salahuddin081402@gmail.com', 'emp_1753126063_198.png', '01859227761', '28/8, Prominent Housing, Shekertek RD#03, Adabar', 'Male', '2025-07-08', '', '2025-07-30', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL COMMENT 'Display name of the menu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Creation timestamp'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `created_at`) VALUES
(1, 'Division', '2025-07-15 16:10:30'),
(2, 'District', '2025-07-15 16:10:30'),
(3, 'Upazila', '2025-07-15 16:10:30'),
(4, 'Union', '2025-07-15 16:10:30'),
(5, 'Village', '2025-07-15 16:10:30'),
(6, 'Define Cluster', '2025-07-15 16:10:30'),
(7, 'Cluster Member', '2025-07-15 16:10:30'),
(8, 'Cluster Project', '2025-07-15 16:10:30'),
(9, 'Cluster Supervisor', '2025-07-15 16:10:30'),
(10, 'Client', '2025-07-15 16:10:30'),
(11, 'Department', '2025-07-15 16:10:30'),
(12, 'Unit', '2025-07-15 16:10:30'),
(13, 'Employee Info', '2025-07-15 16:10:30'),
(14, 'Role', '2025-07-15 16:10:30'),
(15, 'Menu', '2025-07-15 16:10:30'),
(16, 'Role-Menu Mapping', '2025-07-15 16:10:30'),
(17, 'User', '2025-07-15 16:10:30'),
(18, 'Corporate Client', '2025-07-15 16:10:30'),
(19, 'Individual Client', '2025-07-15 16:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_type_id`, `created_at`) VALUES
(1, 'Head Office User', 1, '2025-07-14 14:40:40'),
(2, 'HO Executive', 1, '2025-07-14 14:40:40'),
(3, 'Cluster Supervisor', 2, '2025-07-14 14:40:40'),
(4, 'Cluster Member', 2, '2025-07-14 14:40:40'),
(5, 'Corporate Client', 3, '2025-07-14 14:40:40'),
(6, 'Individual Client', 3, '2025-07-14 14:40:40'),
(7, 'Super Admin', 1, '2025-07-14 14:40:40'),
(8, 'IT Admin', 1, '2025-07-14 14:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_menu`
--

INSERT INTO `role_menu` (`role_id`, `menu_id`, `created_at`) VALUES
(7, 1, '2025-07-15 16:15:44'),
(7, 2, '2025-07-15 16:15:44'),
(7, 3, '2025-07-15 16:15:44'),
(7, 4, '2025-07-15 16:15:44'),
(7, 5, '2025-07-15 16:15:44'),
(7, 6, '2025-07-15 16:15:44'),
(7, 7, '2025-07-15 16:15:44'),
(7, 8, '2025-07-15 16:15:44'),
(7, 9, '2025-07-15 16:15:44'),
(7, 10, '2025-07-15 16:15:44'),
(7, 11, '2025-07-15 16:15:44'),
(7, 12, '2025-07-15 16:15:44'),
(7, 13, '2025-07-15 16:15:44'),
(7, 14, '2025-07-15 16:15:44'),
(7, 15, '2025-07-15 16:15:44'),
(7, 16, '2025-07-15 16:15:44'),
(7, 17, '2025-07-15 16:15:44'),
(7, 18, '2025-07-15 16:15:44'),
(7, 19, '2025-07-15 16:15:44'),
(8, 1, '2025-07-15 16:15:44'),
(8, 2, '2025-07-15 16:15:44'),
(8, 3, '2025-07-15 16:15:44'),
(8, 4, '2025-07-15 16:15:44'),
(8, 5, '2025-07-15 16:15:44'),
(8, 6, '2025-07-15 16:15:44'),
(8, 7, '2025-07-15 16:15:44'),
(8, 8, '2025-07-15 16:15:44'),
(8, 9, '2025-07-15 16:15:44'),
(8, 10, '2025-07-15 16:15:44'),
(8, 11, '2025-07-15 16:15:44'),
(8, 12, '2025-07-15 16:15:44'),
(8, 13, '2025-07-15 16:15:44'),
(8, 14, '2025-07-15 16:15:44'),
(8, 15, '2025-07-15 16:15:44'),
(8, 16, '2025-07-15 16:15:44'),
(8, 17, '2025-07-15 16:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `role_type`
--

CREATE TABLE `role_type` (
  `role_type_id` int(11) NOT NULL COMMENT '1=HO, 2=Cluster, 3=Client, 4=HO Admin',
  `role_type_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_type`
--

INSERT INTO `role_type` (`role_type_id`, `role_type_name`, `created_at`) VALUES
(1, 'HO', '2025-07-14 14:40:39'),
(2, 'Cluster', '2025-07-14 14:40:39'),
(3, 'Client', '2025-07-14 14:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `union_tbl`
--

CREATE TABLE `union_tbl` (
  `union_id` int(11) NOT NULL,
  `union_name` varchar(100) NOT NULL,
  `upazila_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `union_tbl`
--

INSERT INTO `union_tbl` (`union_id`, `union_name`, `upazila_id`) VALUES
(1001, 'Kushura', 111),
(1002, 'Nannar', 111),
(1003, 'Sutipara', 111),
(1004, 'Aminbazar', 112),
(1005, 'Birulia', 112),
(1006, 'Yearpur', 112),
(1007, 'Konda', 113),
(1008, 'Tegharia', 113),
(1009, 'Jinjira', 113),
(1010, 'Mirzapur', 121),
(1011, 'Tumulia', 121),
(1012, 'Basan', 121),
(1013, 'Mouchak', 122),
(1014, 'Atabaha', 122),
(1015, 'Jamirdi', 122),
(1016, 'Gazipur', 123),
(1017, 'Maona', 123),
(1018, 'Gosinga', 123),
(1019, 'Mograpara', 131),
(1020, 'Shambhupura', 131),
(1021, 'Baidyerbazar', 131),
(1022, 'Satgram', 132),
(1023, 'Brammandi', 132),
(1024, 'Duptara', 132),
(1025, 'Kanchpur', 133),
(1026, 'Madyapara', 133),
(1027, 'Kadam Rasul', 133),
(2001, 'Sholoshahar', 211),
(2002, 'Halishahar', 211),
(2003, 'Panchlaish', 211),
(2004, 'Haola', 212),
(2005, 'Dhalghat', 212),
(2006, 'Kachuai', 212),
(2007, 'Binajuri', 213),
(2008, 'Raozan', 213),
(2009, 'Noapara', 213),
(2010, 'Eidgaon', 221),
(2011, 'Jalalabad', 221),
(2012, 'Varuakhali', 221),
(2013, 'Baraitali', 222),
(2014, 'Fasiakhali', 222),
(2015, 'Kakara', 222),
(2016, 'Baharchhara', 223),
(2017, 'Sabrang', 223),
(2018, 'Hnila', 223),
(2019, 'Paduar Bazar', 231),
(2020, 'Bagmara', 231),
(2021, 'Belghar', 231),
(2022, 'Eliotganj', 232),
(2023, 'Goalmari', 232),
(2024, 'Gauripur', 232),
(2025, 'Homna', 233),
(2026, 'Achua', 233),
(2027, 'Nilokhi', 233);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`, `department_id`) VALUES
(11, 'Concept Design', 1),
(12, 'CAD/BIM', 1),
(13, 'Site Supervision', 1),
(21, 'Residential Interiors', 2),
(22, 'Commercial Interiors', 2),
(23, 'Furniture Design', 2),
(31, 'Planning', 3),
(32, 'Procurement', 3),
(33, 'Quality Assurance', 3);

-- --------------------------------------------------------

--
-- Table structure for table `upazila`
--

CREATE TABLE `upazila` (
  `upazila_id` int(11) NOT NULL,
  `upazila_name` varchar(100) NOT NULL,
  `dist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upazila`
--

INSERT INTO `upazila` (`upazila_id`, `upazila_name`, `dist_id`) VALUES
(111, 'Dhamrai', 11),
(112, 'Savar', 11),
(113, 'Keraniganj', 11),
(121, 'Gazipur Sadar', 12),
(122, 'Kaliakair', 12),
(123, 'Sreepur', 12),
(131, 'Sonargaon', 13),
(132, 'Araihazar', 13),
(133, 'Bandar', 13),
(211, 'Chattogram Sadar', 21),
(212, 'Patiya', 21),
(213, 'Raozan', 21),
(221, 'Cox\'s Bazar Sadar', 22),
(222, 'Chakaria', 22),
(223, 'Teknaf', 22),
(231, 'Cumilla Sadar', 23),
(232, 'Daudkandi', 23),
(233, 'Homna', 23);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL COMMENT 'Role id from role table',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `created_at`, `remember_token`) VALUES
(1, 'Head Office User', 'ho@trimatric.com', '$2y$10$8HbtIoFCllOo5s7eFcyj9ONmtIvdtJxmj1p/Uctg3ACxfWuxsfn2e', 1, '2025-07-14 14:40:40', NULL),
(2, 'HO Executive', 'exec@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 2, '2025-07-14 14:40:40', NULL),
(3, 'Cluster Supervisor', 'cluster_sup@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 3, '2025-07-14 14:40:40', NULL),
(4, 'Cluster Member', 'member@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 4, '2025-07-14 14:40:40', NULL),
(5, 'Corporate Client', 'corpclient@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 5, '2025-07-14 14:40:40', NULL),
(6, 'Individual Client', 'indclient@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 6, '2025-07-14 14:40:40', NULL),
(7, 'Super Admin', 'admin@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 7, '2025-07-14 14:40:40', NULL),
(8, 'IT Admin', 'itadmin@trimatric.com', '$2y$10$BeVvklqOY6rT/ABNcOcwJOgNwIFe6Hqqr2nLDqHEx6IxlkVFcHbGa', 8, '2025-07-14 14:40:40', NULL),
(9, 'Salahuddin Ahmed', 'salahuddin081402@gmail.com', '$2y$10$XY5BpNHS/U1Tit1XYHy7JuzQuZpmfQwLQaYFVdq2dN/zBFr6hk36a', 7, '2025-07-15 11:40:00', NULL),
(10, 'Tanvir', 'salahuddin2017111203@gmail.com', '$2y$10$ujcBD/5JzoxJPe/oCBOhh.GCVZkNt6eWNLDgF9TsSvI5t5plL.tJa', 8, '2025-07-15 12:07:09', NULL),
(11, 'Arif Hossain', 'arif@gmail.com', '$2y$10$McOlZTAXN3RQNEylIjzorusAiDemlaSh4bOT61hQmY1syCGfm2ICO', 8, '2025-07-20 13:43:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `village`
--

CREATE TABLE `village` (
  `village_id` int(11) NOT NULL,
  `village_name` varchar(100) NOT NULL,
  `union_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `village`
--

INSERT INTO `village` (`village_id`, `village_name`, `union_id`) VALUES
(10001, 'Kushura Para', 1001),
(10002, 'Paschim Kushura', 1001),
(10003, 'Purba Kushura', 1001),
(10004, 'Nannar North', 1002),
(10005, 'Nannar South', 1002),
(10006, 'Chandpur', 1002),
(10007, 'Sutipara Bazar', 1003),
(10008, 'West Sutipara', 1003),
(10009, 'East Sutipara', 1003),
(10010, 'Aminbazar New', 1004),
(10011, 'Aminbazar Old', 1004),
(10012, 'Aminbazar Colony', 1004),
(20001, 'Sholoshahar Block A', 2001),
(20002, 'Sholoshahar Block B', 2001),
(20003, 'Sholoshahar Block C', 2001),
(20004, 'Halishahar South', 2002),
(20005, 'Halishahar West', 2002),
(20006, 'Halishahar East', 2002),
(20101, 'Eidgaon Village 1', 2010),
(20102, 'Eidgaon Village 2', 2010),
(20103, 'Eidgaon Village 3', 2010),
(20201, 'Paduar Bazar Purba', 2019),
(20202, 'Paduar Bazar Paschim', 2019),
(20203, 'Paduar Bazar Uttar', 2019);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`dist_id`),
  ADD KEY `div_id` (`div_id`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`div_id`);

--
-- Indexes for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `idx_employee_name` (`employee_name`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_designation` (`designation`),
  ADD KEY `idx_unit_id` (`unit_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD UNIQUE KEY `menu_name` (`menu_name`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`),
  ADD KEY `fk_role_role_type` (`role_type_id`);

--
-- Indexes for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD PRIMARY KEY (`role_id`,`menu_id`),
  ADD KEY `fk_menu` (`menu_id`);

--
-- Indexes for table `role_type`
--
ALTER TABLE `role_type`
  ADD PRIMARY KEY (`role_type_id`),
  ADD UNIQUE KEY `role_type_name` (`role_type_name`);

--
-- Indexes for table `union_tbl`
--
ALTER TABLE `union_tbl`
  ADD PRIMARY KEY (`union_id`),
  ADD KEY `upazila_id` (`upazila_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `idx_department_id` (`department_id`);

--
-- Indexes for table `upazila`
--
ALTER TABLE `upazila`
  ADD PRIMARY KEY (`upazila_id`),
  ADD KEY `dist_id` (`dist_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Indexes for table `village`
--
ALTER TABLE `village`
  ADD PRIMARY KEY (`village_id`),
  ADD KEY `union_id` (`union_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `dist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `div_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employee_info`
--
ALTER TABLE `employee_info`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `union_tbl`
--
ALTER TABLE `union_tbl`
  MODIFY `union_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2028;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `upazila`
--
ALTER TABLE `upazila`
  MODIFY `upazila_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `village`
--
ALTER TABLE `village`
  MODIFY `village_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20204;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`div_id`) REFERENCES `division` (`div_id`);

--
-- Constraints for table `employee_info`
--
ALTER TABLE `employee_info`
  ADD CONSTRAINT `employee_info_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`unit_id`);

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `fk_role_role_type` FOREIGN KEY (`role_type_id`) REFERENCES `role_type` (`role_type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `role_menu`
--
ALTER TABLE `role_menu`
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `union_tbl`
--
ALTER TABLE `union_tbl`
  ADD CONSTRAINT `union_tbl_ibfk_1` FOREIGN KEY (`upazila_id`) REFERENCES `upazila` (`upazila_id`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `upazila`
--
ALTER TABLE `upazila`
  ADD CONSTRAINT `upazila_ibfk_1` FOREIGN KEY (`dist_id`) REFERENCES `district` (`dist_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;

--
-- Constraints for table `village`
--
ALTER TABLE `village`
  ADD CONSTRAINT `village_ibfk_1` FOREIGN KEY (`union_id`) REFERENCES `union_tbl` (`union_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
