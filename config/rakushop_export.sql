-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2023 at 01:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rakushop`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`) VALUES
(1, 'hsr.jpg'),
(2, 'valorant.jpg'),
(3, 'hi3.jpg'),
(4, 'genshin.jpg'),
(7, 'banner_658b702f316b27.61571100.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ewallets`
--

CREATE TABLE `ewallets` (
  `id` int NOT NULL,
  `mitra_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ewallets`
--

INSERT INTO `ewallets` (`id`, `mitra_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 4, 'OVO', 'ovo.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(2, 5, 'DANA', 'dana.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(3, 6, 'LinkAja', 'linkaja.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(4, 7, 'GoPay', 'gopay.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(5, 8, 'QRIS', 'qris.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(1, 'Apa itu RakuShop?', 'RakuShop adalah sebuah website yang menyediakan layanan top up untuk game-game mobile.'),
(2, 'Apa saja game yang tersedia?', 'Saat ini, RakuShop menyediakan layanan top up untuk game Honkai Impact 3rd, Honkai: Star Rail, Genshin Impact, Arknights, dan Azur Lane.'),
(3, 'Apa saja metode pembayaran yang tersedia?', 'RakuShop menyediakan metode pembayaran melalui OVO, DANA, LinkAja, GoPay, dan QRIS.'),
(4, 'Bagaimana cara melakukan top up?', 'Pilih game yang ingin kamu top up, pilih jumlah kredit yang kamu inginkan, pilih metode pembayaran, lalu masukkan nomor telepon yang kamu gunakan untuk akun game kamu.'),
(5, 'Berapa lama waktu yang dibutuhkan untuk top up?', 'Top up akan diproses dalam waktu 1x24 jam.'),
(6, 'Apakah ada biaya tambahan?', 'Tidak ada biaya tambahan.'),
(7, 'Apakah ada refund?', 'Tidak ada refund.'),
(8, 'Apakah ada garansi?', 'Tidak ada garansi.'),
(9, 'Apakah ada batasan jumlah top up?', 'Tidak ada batasan jumlah top up.');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `mitra_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `mitra_id`, `name`, `cover`, `image`, `credit_name`, `credit_icon`, `created_at`, `updated_at`) VALUES
(1, 1, 'Honkai: Star Rail', 'hsr-cover.jpg', 'hsr.jpg', 'Oneiric Shards', 'shards.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(2, 1, 'Genshin Impact', 'genshin-cover.jpg', 'genshin.jpg', 'Genesis Crystals', 'genesis.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(3, 2, 'Valorant', 'valorant-cover.jpg', 'valorant.jpg', 'Points', 'points.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(4, 3, 'Azur Lane', 'azur-cover.jpg', 'azur.jpg', 'Gems', 'gems.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(5, 1, 'Honkai Impact 3rd', 'hi3-cover.jpg', 'hi3.jpg', 'Crystals', 'crystals.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `game_credits`
--

CREATE TABLE `game_credits` (
  `id` int NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_credits`
--

INSERT INTO `game_credits` (`id`, `amount`, `price`) VALUES
(1, '60', 16000),
(2, '300+30', 72000),
(3, '980+110', 240000),
(4, '1980+260', 450000),
(5, '6480+1600', 1500000);

-- --------------------------------------------------------

--
-- Table structure for table `mitras`
--

CREATE TABLE `mitras` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mitras`
--

INSERT INTO `mitras` (`id`, `name`, `country`, `image`, `created_at`, `updated_at`) VALUES
(1, 'miHoYo', 'China', 'mihoyo.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(2, 'Riot Games', 'United States', 'riot.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(3, 'Manjuu', 'China', 'manjuu.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(4, 'Lippo Group', 'Indonesia', 'lippo.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(5, 'Sinarmas Multiartha', 'Indonesia', 'sinarmas.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(6, 'Telkomsel', 'Indonesia', 'telkomsel.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(7, 'Gojek', 'Indonesia', 'gojek.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(8, 'Bank Indonesia', 'Indonesia', 'bi.png', '2023-12-26 08:20:29', '2023-12-26 08:20:29'),
(10, 'test1', 'Malaysia', 'mitra_658cd13d850e34.95282603.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `game_id` int DEFAULT NULL,
  `game_credits_id` int DEFAULT NULL,
  `ewallet_id` int DEFAULT NULL,
  `userid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `server` enum('Asia','America','Europe','China') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `game_id`, `game_credits_id`, `ewallet_id`, `userid`, `server`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '808897256', 'Asia', 'bagus@gmail.com', '2023-12-26 08:20:30', '2023-12-26 08:20:30'),
(2, 1, 4, 5, '800143198', 'Asia', 'bagusws@gmail.com', '2023-12-26 09:34:44', '2023-12-26 09:34:44'),
(3, 3, 3, 4, 'Retz#007', 'Asia', 'retz@gmail.com', '2023-12-26 09:39:20', '2023-12-26 09:39:20'),
(4, 3, 3, 3, 'Cobalagi', 'America', 'coba@gmail.com', '2023-12-26 09:41:57', '2023-12-26 09:41:57'),
(5, 4, 2, 2, 'azurgw', 'America', 'azurgw@gmail.com', '2023-12-26 09:50:03', '2023-12-26 09:50:03'),
(6, 4, 1, 1, 'cobaazur', 'China', 'cobaazur@gmail.com', '2023-12-26 09:53:03', '2023-12-26 09:53:03'),
(7, 4, 2, 3, 'azurkonfirm', 'Europe', 'azurkonfirm@gmail.com', '2023-12-26 09:55:25', '2023-12-26 09:55:25'),
(8, 4, 3, 4, 'azurbatal', 'Europe', 'azurbatal@gmail.com', '2023-12-26 09:58:30', '2023-12-26 09:58:30'),
(10, 1, 1, 1, 'jehian', 'Asia', 'jehian@gmail.com', '2023-12-26 17:09:43', '2023-12-26 17:09:43'),
(11, 1, 5, 5, 'hariini', 'Asia', 'hariini@gmail.com', '2023-12-27 03:03:28', '2023-12-27 03:03:28'),
(12, 3, 2, 3, 'valojir', 'America', 'valojir@gmail.com', '2023-12-27 04:38:42', '2023-12-27 04:38:42'),
(13, 3, 5, 4, 'retz#abangnyarapi', 'Asia', 'rafi@gmail.com', '2023-12-27 05:03:58', '2023-12-27 05:03:58'),
(14, 3, 5, 3, 'Retz#rafi', 'China', 'rafi@yahoo.com', '2023-12-27 05:08:03', '2023-12-27 05:08:03'),
(15, 1, 5, 5, 'user1', 'Asia', 'user1@gmail.com', '2023-12-27 08:33:02', '2023-12-27 08:33:02'),
(16, 2, 4, 3, 'user2', 'China', 'user2@gmail.com', '2023-12-27 09:41:12', '2023-12-27 09:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','success','failed') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '08123456789', 'success', '2023-12-26 08:20:30', '2023-12-26 08:20:30'),
(2, 4, NULL, 'pending', '2023-12-26 09:41:57', '2023-12-26 09:41:57'),
(3, 5, NULL, 'pending', '2023-12-26 09:50:03', '2023-12-26 09:50:03'),
(4, 6, NULL, 'pending', '2023-12-26 09:53:03', '2023-12-26 09:53:03'),
(5, 7, NULL, 'pending', '2023-12-26 09:55:25', '2023-12-26 09:55:25'),
(6, 8, NULL, 'pending', '2023-12-26 09:58:30', '2023-12-26 09:58:30'),
(8, 10, NULL, 'pending', '2023-12-26 17:09:43', '2023-12-26 17:09:43'),
(9, 11, '85155433460', 'success', '2023-12-27 03:03:28', '2023-12-27 03:03:28'),
(10, 12, '85155432840', 'success', '2023-12-27 04:38:42', '2023-12-27 04:38:42'),
(11, 13, '85155436666', 'success', '2023-12-27 05:03:58', '2023-12-27 05:03:58'),
(12, 14, '85155435555', 'success', '2023-12-27 05:08:03', '2023-12-27 05:08:03'),
(13, 15, '85155433461', 'success', '2023-12-27 08:33:02', '2023-12-27 08:33:02'),
(14, 16, '85155433423', 'success', '2023-12-27 09:41:12', '2023-12-27 09:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('owner','admin') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Zaki Jamalinux', 'jamalinux@gmail.com', '123', 'owner', '2023-12-27 07:59:33', '2023-12-27 07:59:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ewallets`
--
ALTER TABLE `ewallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitra_id` (`mitra_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mitra_id` (`mitra_id`);

--
-- Indexes for table `game_credits`
--
ALTER TABLE `game_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitras`
--
ALTER TABLE `mitras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `game_credits_id` (`game_credits_id`),
  ADD KEY `ewallet_id` (`ewallet_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_ibfk_1` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ewallets`
--
ALTER TABLE `ewallets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `game_credits`
--
ALTER TABLE `game_credits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mitras`
--
ALTER TABLE `mitras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ewallets`
--
ALTER TABLE `ewallets`
  ADD CONSTRAINT `ewallets_ibfk_1` FOREIGN KEY (`mitra_id`) REFERENCES `mitras` (`id`);

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`mitra_id`) REFERENCES `mitras` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`game_credits_id`) REFERENCES `game_credits` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ewallet_id`) REFERENCES `ewallets` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
