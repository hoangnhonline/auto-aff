-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2016 at 02:41 PM
-- Server version: 5.6.30-1+deb.sury.org~wily+2
-- PHP Version: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auto_aff`
--

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int(11) NOT NULL,
  `ma_sp` char(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `thumbnail_id` bigint(20) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `is_hot` tinyint(1) NOT NULL,
  `is_sale` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `price_sale` int(11) DEFAULT NULL,
  `loai_id` tinyint(4) NOT NULL,
  `cate_id` tinyint(4) NOT NULL,
  `mo_ta` text,
  `xuat_xu` varchar(255) DEFAULT NULL,
  `chi_tiet` text,
  `bao_hanh` varchar(500) DEFAULT NULL,
  `con_hang` tinyint(1) NOT NULL DEFAULT '1',
  `so_luong_ton` int(11) NOT NULL DEFAULT '0',
  `so_luong_tam` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `display_order` tinyint(4) NOT NULL COMMENT 'danh cho sp hot',
  `so_lan_mua` int(11) NOT NULL DEFAULT '0',
  `sale_percent` tinyint(1) DEFAULT NULL,
  `color_id` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `meta_id` bigint(20) DEFAULT NULL,
  `site_id` tinyint(4) NOT NULL COMMENT '1-lazada 2-tiki 3-adayroi',
  `type` tinyint(1) NOT NULL COMMENT '1-ban chay 2-khuyen mai',
  `is_aff` tinyint(1) NOT NULL COMMENT '1 : aff 0 : sp ',
  `created_user` tinyint(4) NOT NULL,
  `updated_user` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
