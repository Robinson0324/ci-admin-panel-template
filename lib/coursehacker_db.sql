

CREATE TABLE `content_tb` (
  `content_id` int(11) NOT NULL,
  `class_number` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `category_number` int(11) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `membership_tb`
--

CREATE TABLE `membership_tb` (
  `membership_id` int(11) NOT NULL,
  `membership_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member_tb`
--

CREATE TABLE `member_tb` (
  `member_id` int(11) NOT NULL,
  `member_email` varchar(255) DEFAULT NULL,
  `member_password` varchar(50) NOT NULL,
  `member_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `member_first_name` varchar(255) DEFAULT NULL,
  `member_last_name` varchar(255) DEFAULT NULL,
  `iphone_device_id` varchar(100) NOT NULL,
  `android_device_id` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `member_sex` varchar(50) DEFAULT NULL,
  `member_years` int(11) DEFAULT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `register_date` text DEFAULT NULL,
  `login_date` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member_tb`
--

INSERT INTO `member_tb` (`member_id`, `member_email`, `member_password`, `member_name`, `member_first_name`, `member_last_name`, `iphone_device_id`, `android_device_id`, `country`, `phone`, `member_sex`, `member_years`, `membership_id`, `register_date`, `login_date`) VALUES
(1, 'admin@email.com', '$P$BDwp9Pb9a/NpfXsb.FKn.zEVjQji4t.', 'admin', 'admin fir', 'admin last', '1234557887', '', '', '', NULL, NULL, NULL, '2020-02-03 03:23:08', '2020-02-03 03:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `setting_tb`
--

CREATE TABLE `setting_tb` (
  `setting_id` int(11) NOT NULL,
  `membership_id` int(11) DEFAULT NULL,
  `type_name` varchar(255) DEFAULT NULL,
  `type_max_count` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_tb`
--
ALTER TABLE `content_tb`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `membership_tb`
--
ALTER TABLE `membership_tb`
  ADD PRIMARY KEY (`membership_id`),
  ADD UNIQUE KEY `membership_name` (`membership_name`);

--
-- Indexes for table `member_tb`
--
ALTER TABLE `member_tb`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `member_email` (`member_email`);

--
-- Indexes for table `setting_tb`
--
ALTER TABLE `setting_tb`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `membership_id` (`membership_id`,`type_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_tb`
--
ALTER TABLE `content_tb`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membership_tb`
--
ALTER TABLE `membership_tb`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_tb`
--
ALTER TABLE `member_tb`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_tb`
--
ALTER TABLE `setting_tb`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

