/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100406
 Source Host           : localhost:3306
 Source Schema         : rpaneldb

 Target Server Type    : MySQL
 Target Server Version : 100406
 File Encoding         : 65001

 Date: 11/05/2021 00:04:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for 02a44217c318ec10b6c53e516b89b1f4
-- ----------------------------
DROP TABLE IF EXISTS `02a44217c318ec10b6c53e516b89b1f4`;
CREATE TABLE `02a44217c318ec10b6c53e516b89b1f4`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from` bigint(20) NOT NULL,
  `message` varchar(3000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `send_date` timestamp(0) NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `status` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of 02a44217c318ec10b6c53e516b89b1f4
-- ----------------------------
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (1, -1, 'Hi', '2020-11-21 12:03:48', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (2, 1, 'Hi', '2020-11-21 12:03:52', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (3, -1, 'How are you?', '2020-11-21 12:03:59', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (4, -1, 'Are you here?', '2020-11-21 12:09:29', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (5, -1, 'I~bm lon', '2020-11-21 12:13:33', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (6, 1, 'I know What happend?', '2020-11-21 12:16:15', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (7, 1, 'Are you sure?', '2020-11-21 12:16:18', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (8, 1, 'I don~bt know', '2020-11-21 12:16:20', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (9, 1, 'What you are saying', '2020-11-21 12:16:24', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (10, 1, 'hi', '2020-11-21 12:16:25', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (11, 1, 'are you still there?', '2020-11-21 12:16:28', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (12, -1, 'no problem', '2020-11-21 12:16:34', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (13, -1, 'I~bve got a problem', '2020-11-21 12:16:39', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (14, -1, 'on my pc', '2020-11-21 12:16:41', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (15, -1, 'hacked', '2020-11-21 12:16:44', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (16, -1, 'Can you see me?', '2020-11-21 12:38:29', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (17, -1, 'I~bve done', '2020-11-21 12:38:32', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (18, -1, 'the project', '2020-11-21 12:38:34', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (19, -1, 'hi', '2020-11-21 12:38:37', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (20, -1, 'Anytime?', '2020-11-21 12:42:39', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (21, 1, 'Yeah', '2020-11-21 12:42:46', 0);
INSERT INTO `02a44217c318ec10b6c53e516b89b1f4` VALUES (22, -1, 'Hi', '2020-11-21 13:05:09', 0);

-- ----------------------------
-- Table structure for a89e8e2526899264d219a63bcf9e0f
-- ----------------------------
DROP TABLE IF EXISTS `a89e8e2526899264d219a63bcf9e0f`;
CREATE TABLE `a89e8e2526899264d219a63bcf9e0f`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from` bigint(20) NOT NULL,
  `message` varchar(3000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `send_date` timestamp(0) NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `status` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of a89e8e2526899264d219a63bcf9e0f
-- ----------------------------
INSERT INTO `a89e8e2526899264d219a63bcf9e0f` VALUES (1, -1, 'hi', '2021-05-08 00:48:56', -1);

-- ----------------------------
-- Table structure for a89e8e2526899264d219a63bcf9e0f6
-- ----------------------------
DROP TABLE IF EXISTS `a89e8e2526899264d219a63bcf9e0f6`;
CREATE TABLE `a89e8e2526899264d219a63bcf9e0f6`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `from` bigint(20) NOT NULL,
  `message` varchar(3000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `send_date` timestamp(0) NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `status` bigint(20) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 51 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of a89e8e2526899264d219a63bcf9e0f6
-- ----------------------------
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (1, -1, 'hi', '2021-05-03 14:35:45', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (2, 1, 'hi', '2021-05-03 14:35:49', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (3, 1, 'how are you?', '2021-05-03 14:35:55', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (4, -1, 'bad', '2021-05-03 14:38:59', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (5, 1, 'hmmm', '2021-05-03 14:39:13', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (6, 1, 'hi', '2021-05-03 14:39:25', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (20, 1, '????????', '2021-05-03 14:39:59', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (43, -1, 'hi', '2021-05-09 18:17:03', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (47, -1, 'hi', '2021-05-09 18:17:03', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (48, -1, 'hi', '2021-05-09 18:17:03', 0);
INSERT INTO `a89e8e2526899264d219a63bcf9e0f6` VALUES (50, -1, '    d', '2021-05-09 18:17:03', 0);

-- ----------------------------
-- Table structure for content_tb
-- ----------------------------
DROP TABLE IF EXISTS `content_tb`;
CREATE TABLE `content_tb`  (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_number` int(11) NULL DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `category_number` int(11) NULL DEFAULT NULL,
  `section` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`content_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for crypto_payments
-- ----------------------------
DROP TABLE IF EXISTS `crypto_payments`;
CREATE TABLE `crypto_payments`  (
  `paymentID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `boxID` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `boxType` enum('paymentbox','captchabox') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `orderID` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `userID` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `countryID` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `coinLabel` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `amount` double(20, 8) NOT NULL DEFAULT 0,
  `amountUSD` double(20, 8) NOT NULL DEFAULT 0,
  `unrecognised` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `addr` varchar(34) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `txID` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `txDate` datetime(0) NULL DEFAULT NULL,
  `txConfirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `txCheckDate` datetime(0) NULL DEFAULT NULL,
  `processed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `processedDate` datetime(0) NULL DEFAULT NULL,
  `recordCreated` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`paymentID`) USING BTREE,
  UNIQUE INDEX `key3`(`boxID`, `orderID`, `userID`, `txID`, `amount`, `addr`) USING BTREE,
  INDEX `boxID`(`boxID`) USING BTREE,
  INDEX `boxType`(`boxType`) USING BTREE,
  INDEX `userID`(`userID`) USING BTREE,
  INDEX `countryID`(`countryID`) USING BTREE,
  INDEX `orderID`(`orderID`) USING BTREE,
  INDEX `amount`(`amount`) USING BTREE,
  INDEX `amountUSD`(`amountUSD`) USING BTREE,
  INDEX `coinLabel`(`coinLabel`) USING BTREE,
  INDEX `unrecognised`(`unrecognised`) USING BTREE,
  INDEX `addr`(`addr`) USING BTREE,
  INDEX `txID`(`txID`) USING BTREE,
  INDEX `txDate`(`txDate`) USING BTREE,
  INDEX `txConfirmed`(`txConfirmed`) USING BTREE,
  INDEX `txCheckDate`(`txCheckDate`) USING BTREE,
  INDEX `processed`(`processed`) USING BTREE,
  INDEX `processedDate`(`processedDate`) USING BTREE,
  INDEX `recordCreated`(`recordCreated`) USING BTREE,
  INDEX `key1`(`boxID`, `orderID`) USING BTREE,
  INDEX `key2`(`boxID`, `orderID`, `userID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for device_tb
-- ----------------------------
DROP TABLE IF EXISTS `device_tb`;
CREATE TABLE `device_tb`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ipaddress` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `owner` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hwid` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` bigint(20) NULL DEFAULT 700,
  `discount` bigint(20) NULL DEFAULT 700,
  `os` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `av` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `hdd` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_group` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pc_lang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Encrypted',
  `crc32` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `decryptedfile` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `decryptor` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `file_count` int(255) NULL DEFAULT 0,
  `file_volumn` bigint(255) NULL DEFAULT NULL,
  `createdAt` int(11) NULL DEFAULT NULL,
  `updatedAt` int(10) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `hwid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of device_tb
-- ----------------------------
INSERT INTO `device_tb` VALUES (1, 'Unk', '192.168.6.243', 'Avw2b666Zd33z2Kj', 'a89e8e2526899264d219a63bcf9e0f', 700, 700, 'Windows 10', '', 'C,D', 'Hong-Laptop', 'SCM1', NULL, NULL, 'Encrypted', '471AD930', 'log.txt', NULL, 2456, 1360595541, 1620394289, 1620401337);

-- ----------------------------
-- Table structure for member_tb
-- ----------------------------
DROP TABLE IF EXISTS `member_tb`;
CREATE TABLE `member_tb`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `member_first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Avatar.png',
  `member_role` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'User',
  `member_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `iphone_device_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `android_device_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_sex` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member_years` int(11) NULL DEFAULT NULL,
  `dash_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `budget` double NULL DEFAULT 0,
  `request_dash` int(11) NULL DEFAULT 0,
  `membership_id` int(11) NULL DEFAULT NULL,
  `register_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `login_date` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`member_id`) USING BTREE,
  UNIQUE INDEX `member_email`(`member_email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_tb
-- ----------------------------
INSERT INTO `member_tb` VALUES (1, 'admin@email.com', '$P$BOVKPoU3ZUkVtziGk8ErAvuQ/XzT521', 'admin', 'adminfir1', 'adminlast', 'phpC7D9.tmp.jpg', 'Admin', 'Avw2b666Zd33z2Kj', '1234557887', '', '', '', '', NULL, 'XCENWF!ef235234', 4502, 1, NULL, '2020-02-03 03:23:08', '2020-02-03 03:23:08');
INSERT INTO `member_tb` VALUES (12, 'adam@gmail.com', '$P$BzQGAp88fY2XSjtEEY70a/zRfy7DUx1', 'adam@gmail.com', NULL, NULL, 'phpF0DC.tmp.jpg', 'User', 'Bvw2b666Zd33z2Kj', '', '', '', '', NULL, NULL, NULL, 0, 0, NULL, '2020-11-18 12:12:19', NULL);
INSERT INTO `member_tb` VALUES (13, 'halford@vqargiqlf.cf', '$P$BQoQ67kOoxtL.lUcLxHt/DrlBnODqV.', 'Halford', 'Halford', 'Sherdder', 'Avatar.png', 'User', 'Cvw2b666Zd33z2Kj', '', '', '', '', NULL, NULL, NULL, 0, 0, NULL, '2020-11-18 12:32:34', NULL);
INSERT INTO `member_tb` VALUES (14, 'test1@gmail.com', '$P$B5gE1YgnGBsYwJelMxErf9WF3kxfhG.', 'test1@gmail.com', NULL, NULL, 'Avatar.png', 'User', 'Hvw2b666Zd33z2Kj', '', '', '', '', NULL, NULL, NULL, 0, 0, NULL, '2020-11-20 09:59:14', NULL);

-- ----------------------------
-- Table structure for membership_tb
-- ----------------------------
DROP TABLE IF EXISTS `membership_tb`;
CREATE TABLE `membership_tb`  (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`membership_id`) USING BTREE,
  UNIQUE INDEX `membership_name`(`membership_name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for setting_tb
-- ----------------------------
DROP TABLE IF EXISTS `setting_tb`;
CREATE TABLE `setting_tb`  (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NULL DEFAULT NULL,
  `type_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type_max_count` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`setting_id`) USING BTREE,
  UNIQUE INDEX `membership_id`(`membership_id`, `type_name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
