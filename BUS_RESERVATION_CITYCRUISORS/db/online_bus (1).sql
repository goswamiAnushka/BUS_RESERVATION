-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 12:26 PM
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
-- Database: `online_bus`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`` PROCEDURE `GetAllBookingDetails` ()   BEGIN
    SELECT 
        user_id, name, email, contact_number,
        ticket_id, bus_name, num_passengers, total_fare, travel_date,
        cancellation_id, refund_amount, cancellation_time
    FROM 
        admin_view_all_details;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`admin_id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin1', 'securepassword123', 'admin1@example.com', '2024-05-10 07:22:25'),
(2, 'admin2', 'securepassword123', 'admin2@example.com', '2024-05-10 07:22:25');

-- --------------------------------------------------------

--
-- Stand-in structure for view `admin_view_all_details`
-- (See below for the actual view)
--
CREATE TABLE `admin_view_all_details` (
`user_id` int(11)
,`name` varchar(255)
,`email` varchar(255)
,`contact_number` varchar(12)
,`ticket_id` int(11)
,`bus_name` varchar(255)
,`num_passengers` int(11)
,`total_fare` decimal(10,2)
,`travel_date` date
,`cancellation_id` int(11)
,`refund_amount` decimal(10,2)
,`cancellation_time` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `bus_details`
--

CREATE TABLE `bus_details` (
  `bus_id` int(11) NOT NULL,
  `bus_name` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `fare` int(11) NOT NULL,
  `seats_available` int(10) NOT NULL,
  `bus_type` enum('Standard','Economy','Premium') NOT NULL DEFAULT 'Standard',
  `driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_details`
--

INSERT INTO `bus_details` (`bus_id`, `bus_name`, `source`, `destination`, `fare`, `seats_available`, `bus_type`, `driver_id`) VALUES
(1, 'Kolkata-Delhi 10:00pm Volvo AC', 'Kolkata', 'Delhi', 1999, 50, 'Premium', NULL),
(2, 'Kolkata-Delhi 6:00am Semi-Sleeper', 'Kolkata', 'Delhi', 1599, 40, 'Economy', NULL),
(3, 'Kolkata-Delhi 2:00pm Standard', 'Kolkata', 'Delhi', 999, 60, 'Standard', NULL),
(4, 'Kolkata-Bhubaneswar 7:00am Premium', 'Kolkata', 'Bhubaneswar', 1199, 50, 'Premium', NULL),
(5, 'Kolkata-Bhubaneswar 1:00pm Economy', 'Kolkata', 'Bhubaneswar', 799, 45, 'Economy', NULL),
(6, 'Kolkata-Bhubaneswar 6:00pm Standard', 'Kolkata', 'Bhubaneswar', 699, 50, 'Standard', NULL),
(7, 'Mumbai-Goa 8:30am Luxury Sleeper', 'Mumbai', 'Goa', 1999, 30, 'Premium', NULL),
(8, 'Mumbai-Goa 3:00pm Semi-Sleeper', 'Mumbai', 'Goa', 999, 40, 'Economy', NULL),
(9, 'Mumbai-Goa 9:45pm Standard', 'Mumbai', 'Goa', 899, 40, 'Standard', NULL),
(10, 'Mumbai-Pune 6:00am Deluxe', 'Mumbai', 'Pune', 1399, 40, 'Premium', NULL),
(11, 'Mumbai-Pune 12:00pm Economy', 'Mumbai', 'Pune', 499, 60, 'Economy', NULL),
(12, 'Mumbai-Pune 8:00pm Standard', 'Mumbai', 'Pune', 599, 50, 'Standard', NULL),
(13, 'Chennai-Bangalore 6:00am Semi-Sleeper', 'Chennai', 'Bangalore', 799, 60, 'Economy', NULL),
(14, 'Chennai-Bangalore 11:00pm Standard', 'Chennai', 'Bangalore', 499, 50, 'Standard', NULL),
(15, 'Chennai-Bangalore 3:00pm Luxury', 'Chennai', 'Bangalore', 1199, 45, 'Premium', NULL),
(16, 'Chennai-Hyderabad 9:00pm Standard', 'Chennai', 'Hyderabad', 899, 70, 'Standard', NULL),
(17, 'Chennai-Hyderabad 6:00am Economy', 'Chennai', 'Hyderabad', 699, 55, 'Economy', NULL),
(18, 'Chennai-Hyderabad 2:00pm Premium', 'Chennai', 'Hyderabad', 1299, 50, 'Premium', NULL),
(19, 'Hyderabad-Pune 9:00pm Seater', 'Hyderabad', 'Pune', 699, 80, 'Standard', NULL),
(20, 'Hyderabad-Pune 4:00pm Economy', 'Hyderabad', 'Pune', 599, 60, 'Economy', NULL),
(21, 'Hyderabad-Pune 10:00am Premium', 'Hyderabad', 'Pune', 1199, 50, 'Premium', NULL),
(22, 'Hyderabad-Bangalore 5:00am Deluxe', 'Hyderabad', 'Bangalore', 1199, 45, 'Premium', NULL),
(23, 'Hyderabad-Bangalore 1:00pm Standard', 'Hyderabad', 'Bangalore', 899, 60, 'Standard', NULL),
(24, 'Hyderabad-Bangalore 8:00pm Semi-Sleeper', 'Hyderabad', 'Bangalore', 699, 50, 'Economy', NULL),
(25, 'Delhi-Jaipur 7:00am Deluxe AC', 'Delhi', 'Jaipur', 1299, 50, 'Premium', NULL),
(26, 'Delhi-Jaipur 8:30am Semi-Sleeper', 'Delhi', 'Jaipur', 799, 60, 'Economy', NULL),
(27, 'Delhi-Jaipur 10:00am Standard', 'Delhi', 'Jaipur', 499, 70, 'Standard', NULL),
(28, 'Delhi-Agra 9:00am Luxury AC', 'Delhi', 'Agra', 1499, 30, 'Premium', NULL),
(29, 'Delhi-Agra 2:00pm Economy', 'Delhi', 'Agra', 599, 50, 'Economy', NULL),
(30, 'Delhi-Agra 6:00pm Standard', 'Delhi', 'Agra', 699, 60, 'Standard', NULL),
(31, 'Bangalore-Mumbai 9:00am Luxury Sleeper', 'Bangalore', 'Mumbai', 1999, 30, 'Premium', NULL),
(32, 'Bangalore-Mumbai 11:30am Deluxe Non-AC', 'Bangalore', 'Mumbai', 1299, 40, 'Standard', NULL),
(33, 'Bangalore-Mumbai 1:00pm Semi-Sleeper', 'Bangalore', 'Mumbai', 999, 50, 'Economy', NULL),
(34, 'Bangalore-Chennai 6:30am Deluxe AC', 'Bangalore', 'Chennai', 1300, 40, 'Premium', NULL),
(35, 'Bangalore-Chennai 12:00pm Semi-Sleeper', 'Bangalore', 'Chennai', 800, 60, 'Economy', NULL),
(36, 'Bangalore-Chennai 8:00pm Standard', 'Bangalore', 'Chennai', 600, 70, 'Standard', NULL),
(37, 'Pune-Hyderabad 8:00am Seater', 'Pune', 'Hyderabad', 699, 80, 'Standard', NULL),
(38, 'Pune-Hyderabad 10:30am Semi-Sleeper', 'Pune', 'Hyderabad', 899, 60, 'Economy', NULL),
(39, 'Pune-Hyderabad 1:00pm Deluxe AC', 'Pune', 'Hyderabad', 1299, 50, 'Premium', NULL),
(40, 'Pune-Nagpur 5:00am Premium', 'Pune', 'Nagpur', 1600, 40, 'Premium', NULL),
(41, 'Pune-Nagpur 11:00am Economy', 'Pune', 'Nagpur', 1000, 60, 'Economy', NULL),
(42, 'Pune-Nagpur 9:00pm Standard', 'Pune', 'Nagpur', 800, 70, 'Standard', NULL),
(43, 'Jaipur-Chandigarh 8:00am Deluxe', 'Jaipur', 'Chandigarh', 1200, 40, 'Premium', NULL),
(44, 'Jaipur-Chandigarh 2:00pm Semi-Sleeper', 'Jaipur', 'Chandigarh', 900, 60, 'Economy', NULL),
(45, 'Jaipur-Chandigarh 10:00pm Standard', 'Jaipur', 'Chandigarh', 700, 70, 'Standard', NULL),
(46, 'Jaipur-Udaipur 7:30am Luxury Sleeper', 'Jaipur', 'Udaipur', 1400, 30, 'Premium', NULL),
(47, 'Jaipur-Udaipur 12:00pm Economy', 'Jaipur', 'Udaipur', 850, 50, 'Economy', NULL),
(48, 'Jaipur-Udaipur 5:00pm Standard', 'Jaipur', 'Udaipur', 650, 60, 'Standard', NULL),
(49, 'Guwahati-Shimla 6:00am Deluxe AC', 'Guwahati', 'Shimla', 2200, 40, 'Premium', NULL),
(50, 'Guwahati-Shimla 12:00pm Semi-Sleeper', 'Guwahati', 'Shimla', 1800, 50, 'Economy', NULL),
(51, 'Guwahati-Shimla 8:00pm Standard', 'Guwahati', 'Shimla', 1500, 55, 'Standard', NULL),
(52, 'Guwahati-Manali 7:00am Premium Sleeper', 'Guwahati', 'Manali', 2500, 35, 'Premium', NULL),
(53, 'Guwahati-Manali 1:00pm Deluxe AC', 'Guwahati', 'Manali', 2300, 45, 'Premium', NULL),
(54, 'Guwahati-Manali 9:00pm Economy', 'Guwahati', 'Manali', 1900, 50, 'Economy', NULL),
(55, 'Guwahati-Dharamshala 5:00am Deluxe', 'Guwahati', 'Dharamshala', 2400, 40, 'Premium', NULL),
(56, 'Guwahati-Dharamshala 11:00am Semi-Sleeper', 'Guwahati', 'Dharamshala', 2000, 50, 'Economy', NULL),
(57, 'Guwahati-Dharamshala 7:00pm Standard', 'Guwahati', 'Dharamshala', 1600, 55, 'Standard', NULL),
(58, 'Guwahati-Dalhousie 8:00am Luxury Sleeper', 'Guwahati', 'Dalhousie', 2600, 30, 'Premium', NULL),
(59, 'Guwahati-Dalhousie 2:00pm Semi-Sleeper', 'Guwahati', 'Dalhousie', 2100, 50, 'Economy', NULL),
(60, 'Guwahati-Dalhousie 10:00pm Standard', 'Guwahati', 'Dalhousie', 1800, 45, 'Standard', NULL),
(61, 'Kolkata-Darjeeling 7:00am Deluxe AC', 'Kolkata', 'Darjeeling', 1700, 40, 'Premium', NULL),
(62, 'Kolkata-Darjeeling 1:00pm Semi-Sleeper', 'Kolkata', 'Darjeeling', 1300, 50, 'Economy', NULL),
(63, 'Kolkata-Darjeeling 9:00pm Standard', 'Kolkata', 'Darjeeling', 1100, 55, 'Standard', NULL),
(64, 'Kolkata-Siliguri 6:00am Luxury Sleeper', 'Kolkata', 'Siliguri', 1800, 30, 'Premium', NULL),
(65, 'Kolkata-Siliguri 2:00pm Deluxe AC', 'Kolkata', 'Siliguri', 1500, 45, 'Premium', NULL),
(66, 'Kolkata-Siliguri 10:00pm Economy', 'Kolkata', 'Siliguri', 1200, 50, 'Economy', NULL),
(67, 'Kolkata-Digha 5:00am Premium AC', 'Kolkata', 'Digha', 900, 40, 'Premium', NULL),
(68, 'Kolkata-Digha 11:00am Semi-Sleeper', 'Kolkata', 'Digha', 700, 50, 'Economy', NULL),
(69, 'Kolkata-Digha 6:00pm Standard', 'Kolkata', 'Digha', 500, 60, 'Standard', NULL),
(70, 'Siliguri-Gangtok 8:00am Luxury Sleeper', 'Siliguri', 'Gangtok', 1300, 30, 'Premium', NULL),
(71, 'Siliguri-Gangtok 2:00pm Semi-Sleeper', 'Siliguri', 'Gangtok', 1000, 50, 'Economy', NULL),
(72, 'Siliguri-Gangtok 7:00pm Standard', 'Siliguri', 'Gangtok', 800, 60, 'Standard', NULL),
(73, 'Darjeeling-Kalimpong 9:00am Deluxe AC', 'Darjeeling', 'Kalimpong', 700, 40, 'Premium', NULL),
(74, 'Darjeeling-Kalimpong 1:00pm Standard', 'Darjeeling', 'Kalimpong', 500, 50, 'Standard', NULL),
(75, 'Darjeeling-Kalimpong 4:00pm Economy', 'Darjeeling', 'Kalimpong', 400, 60, 'Economy', NULL),
(76, 'Asansol-Kolkata 7:00am Deluxe AC', 'Asansol', 'Kolkata', 800, 40, 'Premium', NULL),
(77, 'Asansol-Kolkata 1:00pm Semi-Sleeper', 'Asansol', 'Kolkata', 600, 50, 'Economy', NULL),
(78, 'Asansol-Kolkata 8:00pm Standard', 'Asansol', 'Kolkata', 450, 60, 'Standard', NULL),
(79, 'Shimla-Manali 8:00am Luxury AC', 'Shimla', 'Manali', 1200, 30, 'Premium', NULL),
(80, 'Shimla-Manali 12:00pm Semi-Sleeper', 'Shimla', 'Manali', 900, 50, 'Economy', NULL),
(81, 'Shimla-Manali 5:00pm Standard', 'Shimla', 'Manali', 700, 60, 'Standard', NULL),
(82, 'Dharamshala-Chandigarh 7:00am Deluxe AC', 'Dharamshala', 'Chandigarh', 1000, 40, 'Premium', NULL),
(83, 'Dharamshala-Chandigarh 1:00pm Economy', 'Dharamshala', 'Chandigarh', 800, 50, 'Economy', NULL),
(84, 'Dharamshala-Chandigarh 6:00pm Standard', 'Dharamshala', 'Chandigarh', 600, 70, 'Standard', NULL),
(85, 'Manali-Leh 4:00am Luxury Sleeper', 'Manali', 'Leh', 2500, 20, 'Premium', NULL),
(86, 'Manali-Leh 9:00am Deluxe', 'Manali', 'Leh', 2200, 30, 'Premium', NULL),
(87, 'Manali-Leh 3:00pm Standard', 'Manali', 'Leh', 1800, 40, 'Standard', NULL),
(88, 'Shimla-Delhi 6:00am Semi-Sleeper', 'Shimla', 'Delhi', 1500, 45, 'Premium', NULL),
(89, 'Shimla-Delhi 2:00pm Deluxe Non-AC', 'Shimla', 'Delhi', 1200, 50, 'Economy', NULL),
(90, 'Shimla-Delhi 8:00pm Standard', 'Shimla', 'Delhi', 1000, 60, 'Standard', NULL),
(91, 'Solan-Amritsar 5:00am Premium AC', 'Solan', 'Amritsar', 1400, 35, 'Premium', NULL),
(92, 'Solan-Amritsar 11:00am Semi-Sleeper', 'Solan', 'Amritsar', 1100, 45, 'Economy', NULL),
(93, 'Solan-Amritsar 7:00pm Standard', 'Solan', 'Amritsar', 900, 55, 'Standard', NULL),
(94, 'Kullu-Jaipur 7:00am Deluxe Sleeper', 'Kullu', 'Jaipur', 1800, 30, 'Premium', NULL),
(95, 'Kullu-Jaipur 12:00pm Standard', 'Kullu', 'Jaipur', 1500, 50, 'Economy', NULL),
(96, 'Kullu-Jaipur 8:00pm Economy', 'Kullu', 'Jaipur', 1300, 60, 'Economy', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `percentage_off` decimal(5,2) NOT NULL CHECK (`percentage_off` > 0 and `percentage_off` <= 100),
  `valid_from` date NOT NULL,
  `valid_until` date NOT NULL,
  `min_fare` decimal(10,2) DEFAULT NULL,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `code`, `description`, `percentage_off`, `valid_from`, `valid_until`, `min_fare`, `max_discount_amount`, `active`) VALUES
(1, 'WEEKEND50', '50% off for weekend bookings', 50.00, '2024-05-01', '2024-12-31', 0.00, NULL, 1),
(2, 'WINTER25', '25% off for winter travel bookings', 25.00, '2024-12-01', '2025-02-28', 0.00, 200.00, 1),
(3, 'FAMILY10', '10% off for family bookings (min. 4 passengers)', 10.00, '2024-01-01', '2024-12-31', 0.00, NULL, 1),
(4, 'RETURN20', '20% off for return trips', 20.00, '2024-01-01', '2024-12-31', 0.00, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `driver_bus_assignment`
--

CREATE TABLE `driver_bus_assignment` (
  `assignment_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_bus_assignment`
--

INSERT INTO `driver_bus_assignment` (`assignment_id`, `driver_id`, `bus_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 1, 4),
(5, 2, 5),
(6, 3, 6),
(7, 1, 7),
(8, 2, 8),
(9, 3, 9),
(10, 4, 10),
(11, 5, 11),
(12, 6, 12),
(13, 4, 13),
(14, 5, 14),
(15, 6, 15),
(16, 1, 16),
(17, 1, 18),
(18, 2, 19),
(19, 3, 20),
(20, 4, 17),
(21, 5, 21),
(22, 6, 22),
(23, 1, 23),
(24, 2, 24),
(25, 3, 25),
(26, 1, 1),
(27, 2, 2),
(28, 3, 3),
(29, 1, 4),
(30, 2, 5),
(31, 1, 7),
(32, 2, 8),
(33, 3, 9),
(34, 4, 10),
(35, 5, 11),
(36, 6, 12),
(37, 4, 13),
(38, 5, 14),
(39, 6, 15),
(40, 1, 16),
(41, 1, 18),
(42, 2, 19),
(43, 3, 20),
(44, 4, 17),
(45, 5, 21),
(46, 6, 22),
(47, 1, 23),
(48, 2, 24),
(49, 3, 25),
(50, 1, 26),
(51, 2, 27),
(52, 3, 28),
(53, 1, 29),
(54, 2, 30),
(55, 3, 31),
(56, 4, 32),
(57, 5, 33),
(58, 6, 34),
(59, 1, 35),
(60, 2, 36),
(61, 3, 37),
(62, 1, 38),
(63, 2, 39),
(64, 3, 40),
(65, 1, 41),
(66, 2, 42),
(67, 3, 43),
(68, 4, 44),
(69, 5, 45),
(70, 6, 46),
(71, 1, 47),
(72, 2, 48),
(73, 3, 49),
(74, 4, 50),
(75, 5, 51),
(76, 6, 52),
(77, 1, 53),
(78, 2, 54),
(79, 3, 55),
(80, 4, 56),
(81, 5, 57),
(82, 6, 58),
(83, 1, 59),
(84, 2, 60),
(85, 3, 61),
(86, 4, 62),
(87, 5, 63),
(88, 6, 64),
(89, 1, 65),
(90, 2, 66),
(91, 3, 67),
(92, 4, 68),
(93, 5, 69),
(94, 6, 70),
(95, 1, 71),
(96, 2, 72),
(97, 3, 73),
(98, 4, 74),
(99, 5, 75),
(100, 6, 76),
(101, 1, 77),
(102, 2, 78),
(103, 3, 79),
(104, 4, 80),
(105, 5, 81),
(106, 6, 82),
(107, 1, 83),
(108, 2, 84),
(109, 3, 85),
(110, 4, 86),
(111, 5, 87),
(112, 6, 88),
(113, 1, 89),
(114, 2, 90),
(115, 3, 91),
(116, 4, 92),
(117, 5, 93),
(118, 6, 94),
(119, 1, 95),
(120, 2, 96);

-- --------------------------------------------------------

--
-- Table structure for table `driver_details`
--

CREATE TABLE `driver_details` (
  `driver_id` int(11) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `contact_number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_details`
--

INSERT INTO `driver_details` (`driver_id`, `driver_name`, `license_number`, `contact_number`) VALUES
(1, 'Manish Raj', 'AB123456', '1234567890'),
(2, 'Anand Sharma', 'CD789012', '9876543210'),
(3, 'Shivam Sharma', 'EF345678', '5678901234'),
(4, 'Dev Laal', 'AB123656', '1234567880'),
(5, 'Ramsingh Chadda', 'CM789012', '9875543210'),
(6, 'Rangeela Yadav', 'EP345678', '5678901234');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `bus_name` varchar(255) NOT NULL,
  `num_passengers` int(11) NOT NULL,
  `total_fare` decimal(10,2) NOT NULL,
  `ticket_name` varchar(255) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `travel_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('active','cancelled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `bus_name`, `num_passengers`, `total_fare`, `ticket_name`, `booking_time`, `travel_date`, `user_id`, `status`) VALUES
(3, 'Bangalore-Chennai 12:00pm Semi-Sleeper', 1, 800.00, 'Bangalore-Chennai 12:00pm Semi-Sleeper', '2024-05-09 13:49:12', '2024-06-30', 2, 'cancelled'),
(4, 'Kolkata-Bhubaneswar 7:00am Premium', 1, 1199.00, '', '2024-05-09 15:11:18', '2024-06-23', 2, 'cancelled'),
(5, 'Kolkata-Delhi 2:00pm Standard', 1, 999.00, '', '2024-05-09 15:18:41', '2025-05-10', 2, 'cancelled'),
(6, 'Kolkata-Delhi 6:00am Semi-Sleeper', 1, 1599.00, '', '2024-05-09 15:55:36', '2024-06-11', 3, 'active'),
(7, 'Kolkata-Bhubaneswar 1:00pm Economy', 1, 799.00, '', '2024-05-10 06:24:27', '2024-05-30', 2, 'active'),
(9, 'Kolkata-Bhubaneswar 7:00am Premium', 1, 1199.00, '', '2024-05-10 07:43:05', '2025-06-23', 1, 'cancelled'),
(10, 'Kolkata-Bhubaneswar 7:00am Premium', 2, 2398.00, '', '2024-05-11 04:38:50', '2028-06-23', 1, 'cancelled'),
(11, 'Guwahati-Shimla 6:00am Deluxe AC', 1, 2200.00, '', '2024-05-11 05:27:54', '2025-05-23', 6, 'active'),
(12, 'Kolkata-Siliguri 2:00pm Deluxe AC', 1, 1500.00, '', '2024-05-11 05:34:08', '2028-05-23', 6, 'active'),
(13, 'Shimla-Manali 8:00am Luxury AC', 2, 2400.00, '', '2024-05-11 05:38:06', '2028-06-20', 1, 'cancelled'),
(14, 'Kolkata-Siliguri 10:00pm Economy', 1, 1200.00, '', '2024-05-11 05:41:19', '2025-05-23', 7, 'cancelled'),
(15, 'Manali-Leh 4:00am Luxury Sleeper', 2, 5000.00, '', '2024-05-13 05:32:25', '2026-05-23', 2, 'active'),
(16, 'Kolkata-Darjeeling 9:00pm Standard', 3, 3300.00, '', '2024-05-14 07:10:04', '2024-05-25', 1, 'cancelled'),
(17, 'Chennai-Hyderabad 6:00am Economy', 2, 1398.00, '', '2024-05-15 09:44:06', '2028-05-23', 1, 'cancelled'),
(18, 'Chennai-Hyderabad 6:00am Economy', 2, 1398.00, '', '2024-05-15 10:31:15', '2024-05-23', 1, 'active'),
(19, 'Guwahati-Shimla 12:00pm Semi-Sleeper', 1, 1800.00, '', '2024-05-16 18:50:00', '0204-05-23', 1, 'active'),
(20, 'Kolkata-Siliguri 2:00pm Deluxe AC', 1, 1500.00, '', '2024-05-17 11:18:09', '2025-05-23', 1, 'cancelled'),
(21, 'Kolkata-Siliguri 10:00pm Economy', 2, 2400.00, '', '2024-06-06 11:06:31', '2028-05-23', 9, 'cancelled'),
(22, 'Kolkata-Digha 5:00am Premium AC', 1, 900.00, '', '2024-06-06 13:49:50', '2024-05-23', 9, 'active'),
(23, 'Kolkata-Darjeeling 7:00am Deluxe AC', 1, 1700.00, '', '2024-06-15 16:12:51', '2024-06-16', 10, 'cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_cancellations`
--

CREATE TABLE `ticket_cancellations` (
  `cancellation_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `cancellation_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `refund_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_cancellations`
--

INSERT INTO `ticket_cancellations` (`cancellation_id`, `ticket_id`, `cancellation_time`, `refund_amount`) VALUES
(5, 3, '2024-05-10 09:31:05', 560.00),
(6, 4, '2024-05-10 09:36:24', 839.30),
(7, 9, '2024-05-11 04:37:25', 839.30),
(8, 10, '2024-05-11 05:38:44', 1678.60),
(9, 14, '2024-05-11 05:42:25', 840.00),
(10, 5, '2024-05-13 05:34:13', 699.30),
(11, 13, '2024-05-15 09:46:32', 1680.00),
(12, 16, '2024-05-15 10:32:26', 2310.00),
(13, 17, '2024-05-16 18:49:22', 978.60),
(14, 20, '2024-05-17 11:19:22', 1050.00),
(15, 21, '2024-06-06 11:07:42', 1680.00),
(16, 23, '2024-06-15 16:15:29', 1190.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(12) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`user_id`, `name`, `email`, `password`, `contact_number`, `reset_token`, `token_expiry`) VALUES
(1, 'Anushka', 'CSM22020@tezu.ac.in', '$2y$10$g0UkMZniG6xnTgxdp39uReTZ7ureRxEJUF6CzZnq1R0Q.758nlu7W', '', NULL, NULL),
(2, 'ANCHAL', 'csm22006@tezu.ac.in', '$2y$10$1OGUa4Pqu7yPLq7mPvqKBOXi7oPFjn58smOF0wKBXslv/Q5ZEK5RO', '', NULL, NULL),
(3, 'ALOK SHANDILYA', 'alok.shandilya10@gmail.com', '$2y$10$95Lw8pCzP3UkRosVDjVwz.Yx3HocK4GiNxa0uYN9vAuoQXSOg9Yn6', '', NULL, NULL),
(4, 'SHILPA', 'shilpa@gmail.com', '$2y$10$OPMrqwwg9FInewnuMUQH9ec0RnwaQ7NogmQ5CCXyHghdYgJarn0oK', '', NULL, NULL),
(6, 'nishi', 'n@gmail.com', '$2y$10$s63Q3CP7yeGAkxVAIcMqK.xrE/e0HGaOO72AJclbGdiCBJ/ex73ra', '', NULL, NULL),
(7, 'mia', 'mia@gmail.com', '$2y$10$MT2Wl46KHrMGyU1X5RBB9e1pUW5HEfq1p.5dvxuwDoqlz2k7MHmUy', '', NULL, NULL),
(8, 'sunu', 'sunu@gmail.com', '$2y$10$P035Q9O5W.PFEnC0FLqRVeSJ5lURWru6MSy0WdQ4fF2xAWvPG5yQK', '', NULL, NULL),
(9, 'anushka goswami', 'anushka.siliguri25@gmail.com', '$2y$10$8JwWv3GxxllFM7PaXVwDIOCbWRe7/LyufXi0H2BpJt1HRVc28kAni', '', NULL, NULL),
(10, 'adrija sarkar', 'adrijas@gmail.com', '$2y$10$IfV2QWSHMIUwytBYmJ/wpeLwSN7j17Lh1LelcyKs5Bty3ziGAAg8G', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure for view `admin_view_all_details`
--
DROP TABLE IF EXISTS `admin_view_all_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `admin_view_all_details`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`name` AS `name`, `u`.`email` AS `email`, `u`.`contact_number` AS `contact_number`, `t`.`ticket_id` AS `ticket_id`, `t`.`bus_name` AS `bus_name`, `t`.`num_passengers` AS `num_passengers`, `t`.`total_fare` AS `total_fare`, `t`.`travel_date` AS `travel_date`, `c`.`cancellation_id` AS `cancellation_id`, `c`.`refund_amount` AS `refund_amount`, `c`.`cancellation_time` AS `cancellation_time` FROM ((`user_details` `u` join `tickets` `t` on(`u`.`user_id` = `t`.`user_id`)) left join `ticket_cancellations` `c` on(`t`.`ticket_id` = `c`.`ticket_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bus_details`
--
ALTER TABLE `bus_details`
  ADD PRIMARY KEY (`bus_id`),
  ADD KEY `fk_driver_id` (`driver_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `driver_bus_assignment`
--
ALTER TABLE `driver_bus_assignment`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `driver_details`
--
ALTER TABLE `driver_details`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `ticket_cancellations`
--
ALTER TABLE `ticket_cancellations`
  ADD PRIMARY KEY (`cancellation_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bus_details`
--
ALTER TABLE `bus_details`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `driver_bus_assignment`
--
ALTER TABLE `driver_bus_assignment`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `driver_details`
--
ALTER TABLE `driver_details`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ticket_cancellations`
--
ALTER TABLE `ticket_cancellations`
  MODIFY `cancellation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driver_bus_assignment`
--
ALTER TABLE `driver_bus_assignment`
  ADD CONSTRAINT `driver_bus_assignment_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver_details` (`driver_id`),
  ADD CONSTRAINT `driver_bus_assignment_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `bus_details` (`bus_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`user_id`);

--
-- Constraints for table `ticket_cancellations`
--
ALTER TABLE `ticket_cancellations`
  ADD CONSTRAINT `ticket_cancellations_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
