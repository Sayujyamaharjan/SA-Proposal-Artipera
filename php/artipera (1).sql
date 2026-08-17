-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 14, 2026 at 02:36 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artipera`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Booking_id` int NOT NULL,
  `address` varchar(100) NOT NULL,
  `pricing` int NOT NULL,
  `Booking_date` datetime DEFAULT NULL,
  `Booking_detail` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `Worker_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`Booking_id`, `address`, `pricing`, `Booking_date`, `Booking_detail`, `status`, `Worker_id`, `user_id`) VALUES
(1, 'Kathmandu', 1350, '2026-08-07 09:30:00', 'Furniture Assembly', 'completed', 4, 2),
(3, 'Kathmandu', 1350, '2026-08-16 10:30:00', 'Light Fixture Installation', 'pending', 4, 2),
(5, 'Kathmandu', 1350, '2026-08-18 13:00:00', 'Basic House Cleaning', 'rejected', 4, 2),
(6, 'Kathmandu', 1400, '2026-08-19 14:30:00', 'Fan Repair', 'approved', 5, 2),
(7, 'Kathmandu', 2200, '2026-08-20 11:00:00', 'Pipe Installation', 'approved', 6, 2),
(8, 'Kathmandu', 1700, '2026-08-21 15:00:00', 'Water Tank Cleaning', 'pending', 7, 2),
(9, 'Lalitpur', 1350, '2026-08-22 08:30:00', 'Switch Replacement', 'approved', 4, 3),
(10, 'Lalitpur', 1350, '2026-08-23 12:00:00', 'Curtain Rod Installation', 'pending', 4, 3),
(11, 'Lalitpur', 1400, '2026-08-24 16:00:00', 'Kitchen Sink Repair', 'completed', 5, 3),
(12, 'Lalitpur', 1050, '2026-08-25 09:30:00', 'Electrical Wiring Check', 'rejected', 8, 3),
(19, 'Kathmandu', 1350, '2026-08-10 09:00:00', 'Ceiling Fan Installation', 'completed', 4, 17),
(20, 'Lalitpur', 1350, '2026-08-30 12:00:00', 'Light Fixture Installation', 'approved', 4, 19);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(5, 'Carpenter'),
(1, 'Electrician'),
(4, 'Mechanic'),
(3, 'Painter'),
(2, 'Plumber');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Review_id` int NOT NULL,
  `Rating` int NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `Booking_id` int NOT NULL,
  `Worker_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Review_id`, `Rating`, `Comment`, `Booking_id`, `Worker_id`) VALUES
(4, 5, 'Excellent service. The work was completed professionally and on time.', 11, 5),
(5, 4, 'Good quality work and friendly communication throughout the service.', 19, 4),
(6, 5, 'Highly recommended. Arrived on time and delivered great results.', 1, 4),
(7, 4, 'Satisfied with the service. Everything was handled efficiently.', 11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `saved_workers`
--

CREATE TABLE `saved_workers` (
  `saved_id` int NOT NULL,
  `user_id` int NOT NULL,
  `worker_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saved_workers`
--

INSERT INTO `saved_workers` (`saved_id`, `user_id`, `worker_id`) VALUES
(3, 3, 6),
(8, 2, 4),
(9, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `phone` bigint NOT NULL,
  `profile_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `address`, `role`, `phone`, `profile_image`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$fRQOGZVjARRfetwzNhMfVui5oGQe.jAv3GWT/xAnUxBKeyR7WIJxK', 'Kathmandu', 'admin', 9841286400, 'assets/profiles/admin.png'),
(2, 'Prasish Maharjan', 'prasish@gmail.com', '$2y$10$duP3Y/6DzMp5KAD1DaDUuOMm.O2Iymb8.mw/Tn9DFuN7A/SxEFujK', 'Kathmandu', 'customer', 9810101010, 'michael.jpg'),
(3, 'Olivia Martin', 'olivia@gmail.com', '$2y$10$ZwY664.PAN3HKcp4ql4O5OMsQ68AOFRvRGE.7EfsPybcGdkUqua26', 'Lalitpur', 'customer', 9800000102, 'olivia.jpg'),
(4, 'Sarah Johnson', 'sarah@gmail.com', '$2y$10$BbtkE4zD7xdq6dbaOD9LY.sZ0P5wcTbkxnjZ6Ui4xyO3OgxryA7XO', 'Kathmandu', 'worker', 9800000001, 'sarah.jpg'),
(5, 'Emily Davis', 'emily@gmail.com', '$2y$10$aTGwkYYEZso.tO146ciWgeCusLlMYREVZ8Pqn3r7kmBn3jTOAfMvO', 'Lalitpur', 'worker', 9800000002, 'emily.jpg'),
(6, 'Robert Taylor', 'robert@gmail.com', '$2y$10$raBjLE91HfZeYzVMhRw5D.vKYb2JNs/RssWFeI.M7ACF.WEsWyb1i', 'Bhaktapur', 'worker', 9800000003, 'robert.jpg'),
(7, 'Avash Khadka', 'avash@gmail.com', '$2y$10$UCFIu.aG90I8vAgXoNbuEu9xDlPNl4flOdQlhS.oo.Jy9vRi9fo62', 'Lalitpur', 'worker', 9840404040, 'james.jpg'),
(8, 'Sophia Miller', 'sophia@gmail.com', '$2y$10$B5bkNXFtqFYf338fwosySOjLlEKIihkRHdzcWv8Kgy/rtdeEsdJ6u', 'Pokhara', 'worker', 9800000005, 'sophia.jpg'),
(9, 'David Anderson', 'david@gmail.com', '$2y$10$h3IYHeiWIdpWCM3Z4KvShuMGGtClaz9gylnwmyUTFS27.WxYdyleC', 'Kathmandu', 'worker', 9800000011, 'david.jpg'),
(10, 'Jessica White', 'jessica@gmail.com', '$2y$10$K9mwjrEqd2ZbUJbrI3oB7uSGNpRb3THMXOjE4r/P9.gs/nLepxXJi', 'Lalitpur', 'worker', 9800000012, 'jessica.jpg'),
(11, 'Kevin Harris', 'kevin@gmail.com', '$2y$10$tVtYABqQMSuf2ru26Fe2LOFkBUdmrRLjp2B5BGRH2Yn.jBTcwbmDK', 'Bhaktapur', 'worker', 9800000013, 'kevin.jpg'),
(12, 'Linda Thompson', 'linda@gmail.com', '$2y$10$9ry1R8zSr.B6.HZgn1zL5OMPQTFTEFknSXn8dN.3fGk9OY/03Q0gu', 'Pokhara', 'worker', 9800000014, 'linda.jpg'),
(13, 'Christopher Walker', 'chris@gmail.com', '$2y$10$Xiok6A8c679TvfBmofJmse7HmU16FHjROOKKM8988QsAZyjxRVkd2', 'Chitwan', 'worker', 9800000015, 'chris.jpg'),
(14, 'Daniel Scott', 'daniel@gmail.com', '$2y$10$LzhOwkjaT9ETseMJbjcBzuJqc.uv4o2sEEEW2CbpfDEXBQDPrnvby', 'Kathmandu', 'worker', 9800000016, 'daniel.jpg'),
(17, 'Sayujya Maharjan', 'sayujyamaharjan7@yahoo.com', '$2y$10$mOP14LI7JEiu6tL51obnFOSRdo5Zk4FUeQlR1IAJBy/LzifdOaY1a', 'Lalitpur', 'customer', 9840032929, 'default.jpg'),
(19, 'arnav maharjan', 'arnav@gmail.com', '$2y$10$iYrlRrXC3S6i/r2elWQGheza16H7K5NHUPkwmAj5yN1829xyl5XDK', 'Kathmandu', 'customer', 9810098276, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

CREATE TABLE `worker` (
  `Worker_id` int NOT NULL,
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  `bio` text,
  `year_of_experience` int NOT NULL,
  `base_rate` int NOT NULL,
  `id_front_photo` varchar(255) NOT NULL,
  `id_back_photo` varchar(255) NOT NULL,
  `id_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `past_work_photo` varchar(255) NOT NULL,
  `work_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `degree` varchar(255) NOT NULL,
  `degree_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `validation_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`Worker_id`, `category_id`, `user_id`, `bio`, `year_of_experience`, `base_rate`, `id_front_photo`, `id_back_photo`, `id_status`, `past_work_photo`, `work_status`, `degree`, `degree_status`, `validation_status`) VALUES
(1, 1, 4, 'Experienced electrician with over 5 years of hands-on experience in residential and commercial electrical systems. Specializes in house wiring, switch installation, fan installation, circuit repair, electrical maintenance, fault diagnosis, power distribution systems, and safety inspections. Known for delivering reliable, safe, and efficient electrical solutions while strictly following industry standards and safety regulations. Dedicated to ensuring customer satisfaction through high-quality workmanship, timely project completion, and professional communication.', 5, 1500, 'sarah_front.jpg', 'sarah_back.jpg', 'pending', 'sarah_work.jpg', 'pending', 'Diploma in Electrical Engineering', 'pending', 'pending'),
(2, 2, 5, 'Professional plumber with extensive experience in pipe installation, leak repair, drain cleaning, water tank connections, bathroom fittings, and general plumbing maintenance. Skilled in diagnosing complex plumbing issues and providing durable, cost-effective solutions for residential and commercial properties. Committed to maintaining high standards of workmanship, ensuring water efficiency, and delivering excellent customer service on every project.', 4, 1200, 'emily_front.jpg', 'emily_back.jpg', 'pending', 'emily_work.jpg', 'pending', 'Plumbing Technician Certificate', 'pending', 'pending'),
(3, 3, 6, 'Skilled painter specializing in interior painting, exterior painting, wall putty application, door painting, surface preparation, color consultation, and finishing works. Experienced in transforming residential and commercial spaces with high-quality paint applications and attention to detail. Dedicated to achieving smooth finishes, long-lasting durability, and customer satisfaction through professional craftsmanship and timely service delivery.', 6, 1300, 'robert_front.jpg', 'robert_back.jpg', 'pending', 'robert_work.jpg', 'pending', 'Painting Certification', 'pending', 'pending'),
(4, 4, 7, 'Experienced automotive mechanic with expertise in engine repair, brake repair, oil changes, bike servicing, vehicle diagnostics, preventive maintenance, and general vehicle repair services. Possesses strong technical knowledge of motorcycles and automobiles, ensuring accurate problem diagnosis and efficient repairs. ', 4, 1350, 'james_front.jpg', 'james_back.jpg', 'approved', 'james_work.jpg', 'approved', 'Mechanical Technician Diploma', 'approved', 'approved'),
(5, 5, 8, 'Professional carpenter with expertise in furniture making, door repair, window frame construction, cabinet installation, custom woodwork, furniture restoration, and interior wood finishing. Skilled in creating durable and aesthetically pleasing wooden structures tailored to client requirements. Dedicated to precision craftsmanship, quality materials, and delivering customized woodworking solutions that enhance functionality and appearance.', 3, 1400, 'sophia_front.jpg', 'sophia_back.jpg', 'pending', 'sophia_work.jpg', 'pending', 'Carpentry Trade Certificate', 'pending', 'pending'),
(6, 1, 9, 'Highly experienced industrial and residential electrician with advanced expertise in electrical maintenance, house wiring, electrical troubleshooting, power system installations, circuit repairs, lighting solutions, and preventive maintenance. Known for handling complex electrical projects with professionalism, ensuring compliance with safety standards while delivering efficient and dependable electrical services to residential and commercial clients.', 8, 2200, 'david_front.jpg', 'david_back.jpg', 'pending', 'david_work.jpg', 'pending', 'Electrical Engineering Diploma', 'pending', 'pending'),
(7, 2, 10, 'Certified plumbing professional specializing in pipe repair, leak detection, water supply systems, drainage maintenance, plumbing installations, and emergency plumbing services. Experienced in handling residential and commercial plumbing projects with a focus on efficiency, reliability, and long-term performance. Dedicated to delivering high-quality workmanship and exceptional customer service.', 5, 1700, 'jessica_front.jpg', 'jessica_back.jpg', 'pending', 'jessica_work.jpg', 'pending', 'Advanced Plumbing Certification', 'pending', 'pending'),
(8, 3, 11, 'Professional painter with extensive experience in wall painting, decorative finishes, interior and exterior coatings, surface preparation, texture application, and renovation projects. Skilled in selecting appropriate materials and techniques to achieve attractive and long-lasting results. Focused on delivering clean, precise, and visually appealing finishes that exceed client expectations.', 6, 1600, 'kevin_front.jpg', 'kevin_back.jpg', 'pending', 'kevin_work.jpg', 'rejected', 'Professional Painter Certificate', 'rejected', 'rejected'),
(9, 4, 12, 'Expert vehicle mechanic specializing in vehicle diagnostics, engine maintenance, brake systems, suspension repairs, preventive servicing, and overall automotive care. Experienced in identifying and resolving mechanical issues efficiently while ensuring optimal vehicle performance and safety. Dedicated to providing trustworthy automotive solutions backed by technical expertise and professional service.', 9, 2500, 'linda_front.jpg', 'linda_back.jpg', 'pending', 'linda_work.jpg', 'pending', 'Automobile Mechanics Diploma', 'pending', 'pending'),
(10, 5, 13, 'Experienced carpenter and furniture specialist with expertise in furniture repair, custom furniture construction, cabinet installation, wooden fixtures, interior woodworking, and restoration projects. Known for attention to detail, precision craftsmanship, and the ability to create practical and visually appealing woodwork solutions tailored to client preferences and project requirements.', 10, 2100, 'chris_front.jpg', 'chris_back.jpg', 'pending', 'chris_work.jpg', 'pending', 'Advanced Carpentry Certificate', 'pending', 'pending'),
(11, 1, 14, 'Licensed electrician with strong expertise in house wiring, electrical installations, switchboards, lighting systems, circuit maintenance, troubleshooting, and electrical safety inspections. Experienced in serving residential and office environments with reliable electrical solutions that prioritize safety, efficiency, and customer satisfaction. Committed to maintaining high-quality standards and delivering professional service on every project.', 4, 1400, 'daniel_front.jpg', 'daniel_back.jpg', 'pending', 'daniel_work.jpg', 'pending', 'Electrical Technician Certificate', 'pending', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `worker_service`
--

CREATE TABLE `worker_service` (
  `service_id` int NOT NULL,
  `worker_id` int NOT NULL,
  `service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `worker_service`
--

INSERT INTO `worker_service` (`service_id`, `worker_id`, `service_name`) VALUES
(1, 1, 'House Wiring'),
(2, 1, 'Switch Installation'),
(3, 1, 'Fan Installation'),
(4, 1, 'Circuit Repair'),
(5, 2, 'Pipe Installation'),
(6, 2, 'Leak Repair'),
(7, 2, 'Drain Cleaning'),
(8, 2, 'Water Tank Connection'),
(9, 3, 'Interior Painting'),
(10, 3, 'Exterior Painting'),
(11, 3, 'Wall Putty'),
(12, 3, 'Door Painting'),
(14, 4, 'Engine Repair'),
(15, 4, 'Brake Repair'),
(16, 4, 'Oil Change'),
(17, 5, 'Furniture Making'),
(18, 5, 'Door Repair'),
(19, 5, 'Window Frame Work'),
(20, 5, 'Cabinet Installation'),
(22, 4, 'Bike Servicing'),
(24, 6, 'Electrical Maintenance'),
(25, 7, 'Pipe Repair'),
(26, 8, 'Wall Painting'),
(27, 9, 'Vehicle Diagnostics'),
(28, 10, 'Furniture Repair'),
(29, 11, 'House Wiring'),
(35, 6, 'Circuit Repair'),
(36, 6, 'Switch Installation'),
(37, 6, 'Lighting Setup'),
(38, 7, 'Leak Detection'),
(39, 7, 'Drain Cleaning'),
(40, 7, 'Water Tank Setup'),
(41, 8, 'Interior Painting'),
(42, 8, 'Exterior Painting'),
(43, 8, 'Texture Finishing'),
(44, 9, 'Brake Repair'),
(45, 9, 'Oil Change'),
(46, 9, 'Engine Tuning'),
(47, 10, 'Cabinet Installation'),
(48, 10, 'Wood Polishing'),
(49, 10, 'Door Repair'),
(50, 11, 'Fan Installation'),
(51, 11, 'Power Backup Setup'),
(52, 11, 'Electrical Inspection');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`Booking_id`),
  ADD KEY `Worker_id` (`Worker_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_id`),
  ADD KEY `Booking_id` (`Booking_id`),
  ADD KEY `Worker_id` (`Worker_id`);

--
-- Indexes for table `saved_workers`
--
ALTER TABLE `saved_workers`
  ADD PRIMARY KEY (`saved_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`Worker_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `worker_service`
--
ALTER TABLE `worker_service`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `Booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `saved_workers`
--
ALTER TABLE `saved_workers`
  MODIFY `saved_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
  MODIFY `Worker_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `worker_service`
--
ALTER TABLE `worker_service`
  MODIFY `service_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Worker_id`) REFERENCES `worker` (`Worker_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Booking_id`) REFERENCES `booking` (`Booking_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Worker_id`) REFERENCES `worker` (`Worker_id`);

--
-- Constraints for table `saved_workers`
--
ALTER TABLE `saved_workers`
  ADD CONSTRAINT `saved_workers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `saved_workers_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`Worker_id`);

--
-- Constraints for table `worker`
--
ALTER TABLE `worker`
  ADD CONSTRAINT `worker_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `worker_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `worker_service`
--
ALTER TABLE `worker_service`
  ADD CONSTRAINT `worker_service_ibfk_1` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`Worker_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
