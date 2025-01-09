-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 05:22 AM
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
-- Database: `apexsports`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_status` int(11) NOT NULL DEFAULT 0,
  `cat_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`, `cat_status`, `cat_desc`) VALUES
(1, 'Football ', 0, 'Football Sport Based Products'),
(2, 'Lifestyle', 0, 'lifestyle based Products'),
(3, 'Basketball', 0, 'Basketball Based Products'),
(6, 'Cricket', 0, 'Cricket products');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `pro_price` int(11) NOT NULL,
  `pro_discount` int(11) NOT NULL,
  `pro_desc` varchar(500) NOT NULL,
  `pro_featured` int(11) NOT NULL DEFAULT 0,
  `pro_status` int(11) NOT NULL DEFAULT 0,
  `pro_dis_status` int(11) NOT NULL DEFAULT 1,
  `pro_img` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pro_id`, `pro_name`, `cat_id`, `subcat_id`, `pro_price`, `pro_discount`, `pro_desc`, `pro_featured`, `pro_status`, `pro_dis_status`, `pro_img`) VALUES
(7, 'Nike Dunk 2021', 2, 5, 12000, 0, 'In 2021, Supreme and Nike SB teamed up once more, this time to release an SB Dunk Low influenced by one of the most coveted Supreme SBs of all time. The Nike SB Dunk Low Supreme Starts Mean Green pays homage to the exceedingly rare 2003 Nike SB Dunk High Supreme with gold stars and faux croc skin. The 2021 SB Dunk Low adds a fresh color scheme and form to the original.', 0, 0, 1, 0x2e2e2f75706c6f6164732f64756e6b2e6a706567),
(8, 'Nike Elite Championship Basketball', 3, 6, 3000, 0, ' Game-Dry composite leather construction is micro-perforated for a premium, dry grip and quicker shooting alignment. Wraparound panel design for superior alignment on each shot. NFHS approved. Indoor use. Used by over 100 top college programs. Official size (29.5\")..', 0, 0, 1, 0x2e2e2f75706c6f6164732f6e696b6520656c6974652e6a706567),
(9, 'Nike 2022-2023 England Away Shirt', 1, 4, 3000, 0, 'Nike 2022-2023 England Away Shirt', 0, 0, 1, 0x2e2e2f75706c6f6164732f656e676c616e642e706e67),
(10, 'Nike Netherlands Home Jersey 2022-23', 1, 4, 3000, 0, 'Holland\'s 2022 home kit embodies the Dutch spirit of creativity, adaptability, and boundary-pushing mentality. Nodding to Dutch tradition, the dancing swirl-covered jersey takes inspiration from the mane of a lion, a historical symbol of the Low Countries.\r\n', 0, 0, 1, 0x2e2e2f75706c6f6164732f686f6c616e642e706e67),
(11, 'Nike Vapour Cleats', 1, 1, 7000, 0, 'LOOK FAST, FEEL FASTER. The pitch is yours when you lace up in the Vapor 15 Elite FG. We added a Zoom Air unit, made specifically for football, and grippy texture up top for exceptional touch, so you can dominate in the waning minutes of a match—when it matters most.', 0, 0, 1, 0x2e2e2f75706c6f6164732f4e696b65207661706f75722e706e67),
(12, 'Nike Superfly', 1, 1, 12000, 0, 'Unique traction pattern offers super-charged traction with quick release to create separation. Flyknit wraps your ankle in soft, stretchy fabric for a secure feel. A redone design improves the fit, so that it better simulates the foot. We did this by conducting multiple wear tests on hundreds of athletes.', 0, 0, 1, 0x2e2e2f75706c6f6164732f4e696b65205375706572666c792e706e67),
(13, 'Nike Phantom', 1, 1, 8000, 0, 'It moulds to the shape of your foot and gives you equal grip in wet or dry conditions. Asymmetry in the collar and heel provides comfort. Soft elements in the heel make for an easy break-in process and help reduce irritation and pressure without compromising stability and structure.', 0, 0, 1, 0x2e2e2f75706c6f6164732f4e696b65205068616e746f6d2e706e67),
(14, 'Nike Academy', 1, 7, 4000, 0, 'The Nike Academy Football features innovative grooves designed for consistent spin when the ball is in the air. High-contrast graphics help you easily track the ball. Nike Aerowsculpt technology uses moulded grooves for more consistent flight. Textured casing gives you great touch and feel.', 0, 0, 1, 0x2e2e2f75706c6f6164732f6e696b652061636164656d792e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registration`
--

CREATE TABLE `tbl_registration` (
  `reg_id` int(11) NOT NULL,
  `reg_name` varchar(200) NOT NULL,
  `reg_email` varchar(200) NOT NULL,
  `reg_password` varchar(100) NOT NULL,
  `reg_mobile` varchar(13) NOT NULL,
  `reg_role` int(11) NOT NULL DEFAULT 0,
  `otp` int(11) NOT NULL,
  `reg_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_registration`
--

INSERT INTO `tbl_registration` (`reg_id`, `reg_name`, `reg_email`, `reg_password`, `reg_mobile`, `reg_role`, `otp`, `reg_status`) VALUES
(2, 'Alen Roy', 'jackyssparrow79@gmail.com', '$2y$10$SRlwwdagI1E64iySfy5POu.BlfywyPBqKQj3bpz1IXajOhTRJN9vi', '7510995173', 1, 359898, 0),
(3, 'Anandhu', 'anandupganesh@gmail.com', '$2y$10$r4eOlZ5k8MjaR0mfYuu.c.qrRNGVlVyPwjrXxrIiHdwrma1tiEYHS', '7665567677', 0, 181009, 0),
(4, 'Alen Roy', 'alanshajivattamala2026@mca.ajce.in', '$2y$10$vDj4udGCSvMjg/qj/yTcsOqpBC5PfudDK5h0orGGlLq91qVPXUo/G', '7510995173', 0, 724049, 0),
(5, 'Asher koshy', 'ashersunilkoshy2026@mca.ajce.in', '$2y$10$dw.y.qxESjwXt2AhswXtyO17RX2pJ40NwxaD.Dn.HBu6PxZm6zLAy', '7887878870', 0, 698513, 0),
(7, 'Alen Roy', 'justinsony2002@gmail.com', '$2y$10$Q//r1Ikb/kJAMjm/6qVqq.Hg5Kh9tNIN0W.2h.4UQGgVvdIgvc1N2', '7510995173', 0, 350107, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `size_id` int(11) NOT NULL,
  `size_value` varchar(50) NOT NULL,
  `size_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_size`
--

INSERT INTO `tbl_size` (`size_id`, `size_value`, `size_status`) VALUES
(1, 'UK 8', 0),
(4, 'UK 9', 0),
(5, 'UK 10', 0),
(22, 'Medium', 0),
(23, 'Large', 0),
(24, 'Small', 0),
(26, 'Extra Large', 0),
(27, 'One Size', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size_details`
--

CREATE TABLE `tbl_size_details` (
  `size_det_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_size_details`
--

INSERT INTO `tbl_size_details` (`size_det_id`, `pro_id`, `size_id`, `stock`) VALUES
(4, 7, 4, 20),
(5, 7, 5, 10),
(6, 8, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `subcat_id` int(11) NOT NULL,
  `subcat_name` varchar(100) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subcategory`
--

INSERT INTO `tbl_subcategory` (`subcat_id`, `subcat_name`, `cat_id`) VALUES
(1, 'Football Shoes', 1),
(3, 'Basketball Shoes', 3),
(4, 'Football Jerseys', 1),
(5, 'Sneakers', 2),
(6, 'Basketball Balls', 3),
(7, 'Football Balls', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `subcat_id` (`subcat_id`);

--
-- Indexes for table `tbl_registration`
--
ALTER TABLE `tbl_registration`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `tbl_size_details`
--
ALTER TABLE `tbl_size_details`
  ADD PRIMARY KEY (`size_det_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`subcat_id`),
  ADD KEY `parcat_id` (`cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_registration`
--
ALTER TABLE `tbl_registration`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_size`
--
ALTER TABLE `tbl_size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_size_details`
--
ALTER TABLE `tbl_size_details`
  MODIFY `size_det_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `subcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`cat_id`) REFERENCES `tbl_category` (`cat_id`),
  ADD CONSTRAINT `subcat_id` FOREIGN KEY (`subcat_id`) REFERENCES `tbl_subcategory` (`subcat_id`);

--
-- Constraints for table `tbl_size_details`
--
ALTER TABLE `tbl_size_details`
  ADD CONSTRAINT `pro_id` FOREIGN KEY (`pro_id`) REFERENCES `tbl_product` (`pro_id`),
  ADD CONSTRAINT `size_id` FOREIGN KEY (`size_id`) REFERENCES `tbl_size` (`size_id`);

--
-- Constraints for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD CONSTRAINT `parcat_id` FOREIGN KEY (`cat_id`) REFERENCES `tbl_category` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
