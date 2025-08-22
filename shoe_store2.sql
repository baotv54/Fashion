-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 18, 2025 lúc 02:34 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoe_store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `address`, `province`, `district`, `ward`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bảo', '0359166437', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Quế Võ', 'Xã Châu Phong', 0, '2025-04-11 10:40:16', '2025-04-23 05:01:30'),
(2, 1, '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Ninh Thuận', 'Huyện Thuận Bắc', 'Xã Phước Chiến', 1, '2025-04-14 05:33:27', '2025-04-23 05:01:30'),
(3, 1, '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Hòa Bình', 'Huyện Lạc Thủy', 'Xã An Bình', 0, '2025-04-14 05:33:41', '2025-04-23 05:01:30'),
(4, 1, '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Tân Hoà', 0, '2025-04-14 05:33:52', '2025-04-23 05:01:30'),
(7, 1, '04.Trịnh Văn Bảo_11A2', '12345678908', 'Hà Huy Tập', 'Đắk Lắk', 'Thành phố Buôn Ma Thuột', 'Phường Tân An', 0, '2025-04-23 04:57:17', '2025-04-23 05:01:30'),
(11, 2, 'YTHANH ÊBAN', '0337937493', 'y wang', 'Vĩnh Long', 'Huyện Vũng Liêm', 'Xã Quới Thiện', 1, '2025-06-14 20:41:15', '2025-07-02 06:16:42'),
(13, 2, 'Văn Vịnh Huỳnh', '0337937493', 'BMT', 'Điện Biên', 'Huyện Mường Chà', 'Thị Trấn Mường Chà', 0, '2025-06-28 16:24:56', '2025-07-02 06:16:42'),
(14, 2, 'YTHANH ÊBAN', '0337937493', 'buôn cuôr đăng b', 'Đắk Lắk', 'Huyện Cư M gar', 'Xã Cuor Đăng', 0, '2025-07-02 06:16:32', '2025-07-02 06:16:42'),
(15, 2, 'YTHANH ÊBAN', '0337937493', 'buôn cuôr đăng b', 'Đắk Lắk', 'Huyện Cư M gar', 'Xã Cuor Đăng', 0, '2025-07-02 06:16:34', '2025-07-02 06:16:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Màu', '2025-04-05 08:31:02', '2025-04-05 08:31:02'),
(2, 'Kích Thước', '2025-04-05 08:31:19', '2025-04-05 08:31:19'),
(6, 'Suất xứ', '2025-04-05 09:24:09', '2025-04-05 09:24:09'),
(9, 'Hãng', '2025-05-29 04:58:23', '2025-05-29 04:58:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `attribute_values`
--

INSERT INTO `attribute_values` (`id`, `attribute_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'Đỏ', '2025-04-05 09:28:36', '2025-04-05 09:28:36'),
(3, 1, 'Tím', '2025-04-05 09:28:45', '2025-04-05 09:28:45'),
(5, 1, 'Nâu', '2025-04-05 09:28:54', '2025-04-05 09:28:54'),
(6, 1, 'Xanh lá', '2025-04-05 09:28:58', '2025-04-05 09:28:58'),
(7, 1, 'Hồng', '2025-04-05 09:29:06', '2025-04-05 09:29:06'),
(8, 2, '37', '2025-04-05 09:29:23', '2025-04-05 09:29:23'),
(10, 2, '39', '2025-04-05 09:29:30', '2025-04-05 09:29:30'),
(12, 2, '41', '2025-04-05 09:29:36', '2025-04-05 09:29:36'),
(17, 9, 'YTHANH', '2025-06-18 02:58:23', '2025-06-18 02:58:23'),
(18, 6, 'Hàn', '2025-06-18 22:22:22', '2025-06-18 22:22:22'),
(19, 6, 'Việt Nam', '2025-06-18 22:22:38', '2025-06-18 22:22:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `link`, `target`, `created_at`, `updated_at`) VALUES
(4, 'Giáo Sư', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '1754530983.jpg', 'https://youtu.be/Lu5NHQbMP9k?si=v83xuGTiFzeNjDRS', '_self', '2025-08-06 18:43:03', '2025-08-06 18:43:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'NIKE', NULL, 'nike', 1, '2025-04-05 05:02:54', '2025-04-05 05:02:54'),
(2, 'Adidas', NULL, 'adidas', 1, '2025-04-15 22:51:14', '2025-04-15 22:51:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_admin@example.com|127.0.0.1', 'i:1;', 1745410078),
('laravel_cache_admin@example.com|127.0.0.1:timer', 'i:1745410078;', 1745410078),
('laravel_cache_ebanythanh1@gmail.com|127.0.0.1', 'i:1;', 1754905467),
('laravel_cache_ebanythanh1@gmail.com|127.0.0.1:timer', 'i:1754905467;', 1754905467),
('laravel_cache_ghn_district_id_4c7278bf034ecd73f22f3479ea29ac14', 'i:1598;', 1744939053),
('laravel_cache_ghn_district_id_6f8375f4e99f80b6eab7cfc997373afd', 'i:1729;', 1744905894),
('laravel_cache_ghn_district_id_9553ab518cb12001ac7022e9ec29f3a4', 'i:1788;', 1744906161),
('laravel_cache_ghn_district_id_c43ff36b9e90b1ff537d3d9723f1378f', 'i:1787;', 1744907040),
('laravel_cache_ghn_district_id_d41d8cd98f00b204e9800998ecf8427e', 'i:1442;', 1744944802),
('laravel_cache_ghn_district_name_1552', 's:29:\"Thành phố Buôn Ma Thuột\";', 1744904939),
('laravel_cache_ghn_district_name_1729', 's:16:\"Huyện Tiên Du\";', 1744905893),
('laravel_cache_ghn_district_name_1784', 's:19:\"Huyện Buôn Ðôn\";', 1744904625),
('laravel_cache_ghn_district_name_1785', 's:17:\"Huyện Cư M gar\";', 1744905866),
('laravel_cache_ghn_district_name_1788', 's:20:\"Thị xã Buôn Hồ\";', 1744906160),
('laravel_cache_ghn_district_name_2131', 's:15:\"Huyện Ea Súp\";', 1744905504),
('laravel_cache_ghn_province_id_651f953eb2315f6f7e35fa992ab98cd9', 'i:225;', 1744939052),
('laravel_cache_ghn_province_id_c4d85b1be115ded42d69a6ff88b0bd47', 'i:249;', 1744905894),
('laravel_cache_ghn_province_id_d32c641d1c42b6e5fd924e4570d69f6c', 'i:210;', 1744906160),
('laravel_cache_ghn_province_id_d41d8cd98f00b204e9800998ecf8427e', 'i:202;', 1744944801),
('laravel_cache_ghn_province_name_210', 's:12:\"Đắk Lắk\";', 1744904625),
('laravel_cache_ghn_province_name_249', 's:10:\"Bắc Ninh\";', 1744905892),
('laravel_cache_ghn_ward_code_1a23c49f0dd2d447e984c9fae020bc50', 's:6:\"190402\";', 1744905894),
('laravel_cache_ghn_ward_code_44f20432242d69a016a97b5b4ab21f77', 's:6:\"401507\";', 1744906161),
('laravel_cache_ghn_ward_code_7f8782ee0420149fce92aa03982a8cd2', 's:6:\"400406\";', 1744907040),
('laravel_cache_ghn_ward_code_bdbf851ec4af4b78abbcbd357a9bdba5', 's:6:\"210110\";', 1744939053),
('laravel_cache_ghn_ward_code_f69e505b08403ad2298b9f262659929a', 's:5:\"20110\";', 1744944803),
('laravel_cache_ghn_ward_name_190304_d1728', 's:12:\"Xã Cách Bi\";', 1745505060),
('laravel_cache_ghn_ward_name_190306_d1728', 's:13:\"Xã Chi Lăng\";', 1745505378),
('laravel_cache_ghn_ward_name_190308_d1728', 's:15:\"Xã Đào Viên\";', 1745506257),
('laravel_cache_ghn_ward_name_190315_d1728', 's:16:\"Xã Phù Lương\";', 1745570113),
('laravel_cache_ghn_ward_name_190402_d1729', 's:16:\"Xã Cảnh Hưng\";', 1744905893),
('laravel_cache_ghn_ward_name_190803_d1969', 's:17:\"Xã Bình Định\";', 1750045604),
('laravel_cache_ghn_ward_name_210110_d1598', 's:21:\"Phường Quang Trung\";', 1744939052),
('laravel_cache_ghn_ward_name_220307_d1825', 's:17:\"Xã Đào Dương\";', 1750045255),
('laravel_cache_ghn_ward_name_360402_d2121', 's:18:\"Xã Đắk Rơ Nga\";', 1751551866),
('laravel_cache_ghn_ward_name_360704_d1835', 's:14:\"Xã Đăk Long\";', 1751548860),
('laravel_cache_ghn_ward_name_360805_d2148', 's:19:\"Xã Đắk Tơ Lung\";', 1751631427),
('laravel_cache_ghn_ward_name_400103_d1552', 's:17:\"Phường Tân An\";', 1745495837),
('laravel_cache_ghn_ward_name_400403_d1787', 's:13:\"Xã ĐLiê Ya\";', 1754305545),
('laravel_cache_ghn_ward_name_400406_d1787', 's:10:\"Xã Ea Puk\";', 1744907039),
('laravel_cache_ghn_ward_name_400407_d1787', 's:10:\"Xã Ea Tam\";', 1754306761),
('laravel_cache_ghn_ward_name_400507_d2131', 's:12:\"Xã Ia JLơi\";', 1744905505),
('laravel_cache_ghn_ward_name_400604_d1785', 's:13:\"Xã Cư M\'gar\";', 1751466050),
('laravel_cache_ghn_ward_name_400606_d1785', 's:15:\"Xã Cuor Đăng\";', 1754955399),
('laravel_cache_ghn_ward_name_400609_d1785', 's:13:\"Xã Ea Kiết\";', 1750045225),
('laravel_cache_ghn_ward_name_400616_d1785', 's:18:\"Xã Quảng Hiệp\";', 1752581276),
('laravel_cache_ghn_ward_name_400903_d3418', 's:12:\"Xã Cư M\'ta\";', 1754306428),
('laravel_cache_ghn_ward_name_401209_d3217', 's:14:\"Xã Krông Nô\";', 1754955846),
('laravel_cache_ghn_ward_name_401302_d1784', 's:10:\"Xã Ea Bar\";', 1745504630),
('laravel_cache_ghn_ward_name_401305_d1784', 's:10:\"Xã Ea Wer\";', 1744904626),
('laravel_cache_ghn_ward_name_401307_d1784', 's:13:\"Xã Tân Hoà\";', 1750045572),
('laravel_cache_ghn_ward_name_401507_d1788', 's:24:\"Phường Thống Nhất\";', 1744906160),
('laravel_cache_ghn_ward_name_450601_d3301', 's:15:\"Xã Bắc Phong\";', 1745504967),
('laravel_cache_ghn_ward_name_450606_d3301', 's:19:\"Xã Phước Kháng\";', 1745505329),
('laravel_cache_ghn_ward_name_470503_d1776', 's:17:\"Xã Hàm Cường\";', 1754301085),
('laravel_cache_ghn_ward_name_471004_d1778', 's:17:\"Phường Tân An\";', 1754297161),
('laravel_cache_ghn_ward_name_550204_d1573', 's:19:\"Phường Long Hòa\";', 1751198903),
('laravel_cache_ghn_ward_name_570708_d2263', 's:18:\"Xã Quới Thiện\";', 1751548746),
('laravel_cache_ghn_ward_name_590507_d2238', 's:17:\"Xã Thạnh Trị\";', 1755605545),
('laravel_cache_ghn_ward_name_590907_d2062', 's:13:\"Xã Tân Long\";', 1755605704),
('laravel_cache_ghn_ward_name_59103_d1910', 's:11:\"Xã An Ninh\";', 1755581828),
('laravel_cache_ghn_ward_name_61201_d1890', 's:24:\"Thị trấn Pác Miầu\";', 1745496740),
('laravel_cache_ghn_ward_name_620501_d1978', 's:26:\"Thị Trấn Mường Chà\";', 1751239496),
('laravel_cache_ghn_ward_name_620502_d1978', 's:15:\"Xã Hừa Ngài\";', 1750043953),
('laravel_cache_ghn_ward_name_620503_d1978', 's:16:\"Xã Huổi Lèng\";', 1754480343),
('laravel_cache_ghn_ward_name_620702_d2123', 's:16:\"Xã Chiềng Sơ\";', 1755581552),
('laravel_cache_ghn_ward_name_621003_d2179', 's:13:\"Xã Chà Tở\";', 1755484535),
('laravel_cache_hovanvinh@gmail.com|127.0.0.1', 'i:1;', 1749124613),
('laravel_cache_hovanvinh@gmail.com|127.0.0.1:timer', 'i:1749124613;', 1749124613);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Giày thể thao', 'giay-the-thao', NULL, 1, '2025-04-05 05:02:49', '2025-04-14 02:19:47'),
(2, 'Giày đẹp', 'giay-dep', 1, 1, '2025-04-14 02:20:48', '2025-04-14 02:20:48'),
(3, 'Giày đi học', 'giay-di-hoc', NULL, 1, '2025-04-15 22:52:22', '2025-04-15 22:52:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chat_session_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('user','bot') NOT NULL,
  `message` text NOT NULL,
  `product_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_ids`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `chat_session_id`, `role`, `message`, `product_ids`, `created_at`, `updated_at`) VALUES
(41, 7, 'user', 'Xin chào', NULL, '2025-04-16 05:13:07', '2025-04-16 05:13:07'),
(42, 7, 'bot', 'Xin chào! Tôi có thể giúp gì cho bạn hôm nay?', NULL, '2025-04-16 05:13:07', '2025-04-16 05:13:07'),
(43, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-16 05:13:25', '2025-04-16 05:13:25'),
(44, 7, 'bot', 'Chào bạn! Mình sẽ tìm các sản phẩm với thương hiệu Adidas cho bạn nhé. Bạn có muốn tìm theo danh mục nào cụ thể không ạ?', NULL, '2025-04-16 05:13:25', '2025-04-16 05:13:25'),
(45, 7, 'user', 'Adidas', NULL, '2025-04-16 07:33:02', '2025-04-16 07:33:02'),
(46, 7, 'bot', 'Chào bạn! Bạn đang tìm kiếm sản phẩm từ thương hiệu Adidas đúng không ạ? Bạn có muốn tìm sản phẩm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, phụ kiện,... để mình tìm kiếm chính xác hơn ạ?', NULL, '2025-04-16 07:33:02', '2025-04-16 07:33:02'),
(47, 7, 'user', 'fdasfasfds', NULL, '2025-04-16 17:42:49', '2025-04-16 17:42:49'),
(48, 7, 'bot', 'Chào bạn! Rất tiếc, mình chưa hiểu ý bạn. Bạn có thể nói rõ hơn được không ạ?', NULL, '2025-04-16 17:42:49', '2025-04-16 17:42:49'),
(49, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-16 17:43:06', '2025-04-16 17:43:06'),
(50, 7, 'bot', 'Chào bạn! Mình sẽ giúp bạn tìm các sản phẩm từ thương hiệu Adidas nhé. Bạn có muốn tìm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, hay phụ kiện?', NULL, '2025-04-16 17:43:06', '2025-04-16 17:43:06'),
(51, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-16 19:44:59', '2025-04-16 19:44:59'),
(52, 7, 'bot', 'Chào bạn! Mình sẽ giúp bạn tìm các sản phẩm từ thương hiệu Adidas nhé. Bạn có muốn tìm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, hay phụ kiện?', NULL, '2025-04-16 19:44:59', '2025-04-16 19:44:59'),
(53, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-16 19:50:18', '2025-04-16 19:50:18'),
(54, 7, 'bot', 'Chào bạn! Mình sẽ giúp bạn tìm các sản phẩm từ thương hiệu Adidas nhé. Bạn có muốn tìm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, hay phụ kiện?', NULL, '2025-04-16 19:50:18', '2025-04-16 19:50:18'),
(55, 8, 'user', 'Xin chao', NULL, '2025-04-22 23:30:29', '2025-04-22 23:30:29'),
(56, 8, 'bot', 'Xin chào! Tôi có thể giúp gì cho bạn?', NULL, '2025-04-22 23:30:29', '2025-04-22 23:30:29'),
(57, 8, 'user', 'adidas', NULL, '2025-04-22 23:30:45', '2025-04-22 23:30:45'),
(58, 8, 'bot', 'Chào bạn! Bạn quan tâm đến sản phẩm của Adidas phải không ạ? Bên mình có rất nhiều sản phẩm chính hãng của Adidas, từ quần áo, giày dép đến phụ kiện. Bạn có thể cho mình biết thêm thông tin chi tiết về loại sản phẩm bạn đang tìm kiếm, ví dụ như loại sản phẩm (giày, áo...), màu sắc, size, hoặc mức giá bạn mong muốn để mình có thể tìm kiếm chính xác hơn không?', NULL, '2025-04-22 23:30:46', '2025-04-22 23:30:46'),
(59, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-23 22:42:07', '2025-04-23 22:42:07'),
(60, 7, 'bot', 'Chào bạn! Mình sẽ giúp bạn tìm các sản phẩm từ thương hiệu Adidas nhé. Bạn có muốn tìm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, hay phụ kiện?', NULL, '2025-04-23 22:42:07', '2025-04-23 22:42:07'),
(61, 7, 'user', 'Tìm sản phẩm với thương hiệu adidas', NULL, '2025-04-24 00:48:44', '2025-04-24 00:48:44'),
(62, 7, 'bot', 'Chào bạn! Mình sẽ giúp bạn tìm các sản phẩm từ thương hiệu Adidas nhé. Bạn có muốn tìm theo danh mục cụ thể nào không, ví dụ như giày dép, quần áo, hay phụ kiện?', NULL, '2025-04-24 00:48:44', '2025-04-24 00:48:44'),
(63, 7, 'user', 'gợi ý sản phẩm', NULL, '2025-04-24 01:38:00', '2025-04-24 01:38:00'),
(64, 7, 'bot', 'Chào bạn! Để mình gợi ý sản phẩm cho bạn nhé. Bạn có muốn tìm theo danh mục sản phẩm cụ thể nào không ạ?', NULL, '2025-04-24 01:38:00', '2025-04-24 01:38:00'),
(65, 7, 'user', 'Gợi ý giày dưới 500 nghìn', NULL, '2025-04-24 01:38:27', '2025-04-24 01:38:27'),
(66, 7, 'bot', 'Chào bạn! Mình sẽ gợi ý các mẫu giày phù hợp với mức giá dưới 500 nghìn nhé!', NULL, '2025-04-24 01:38:28', '2025-04-24 01:38:28'),
(67, 10, 'user', 'gợi ý sản phẩm', NULL, '2025-08-03 05:21:26', '2025-08-03 05:21:26'),
(68, 10, 'bot', 'Chào bạn! Dựa trên sở thích và lịch sử mua hàng của bạn, cộng với thời tiết mùa hè hiện tại, mình gợi ý một số mẫu giày Nike thể thao phù hợp với bạn nhé. Bạn thích những mẫu giày có đặc điểm gì hơn ạ? Ví dụ như: dùng cho mục đích gì (chạy bộ, đi chơi, tập gym...), màu sắc yêu thích, hoặc có công nghệ đặc biệt nào không ạ? Mình sẽ dựa vào đó để đưa ra gợi ý chi tiết hơn nhé! \n\nTuy nhiên, để bắt đầu, mình xin đưa ra một vài gợi ý chung dựa trên những thông tin mình đang có:\n\n* **Nếu bạn thích sự thoải mái và thoáng khí cho các hoạt động hàng ngày hoặc tập luyện nhẹ:**\n    * **Nike Revolution 6:** Mẫu giày running phổ biến, giá cả phải chăng, với chất liệu thoáng khí và đế êm ái.\n    * **Nike Tanjun:** Thiết kế tối giản, nhẹ nhàng và thoải mái, phù hợp với nhiều outfit khác nhau.\n\n* **Nếu bạn tìm kiếm một đôi giày thể thao phong cách và có hiệu năng tốt:**\n    * **Nike Air Max 90:** Một biểu tượng của Nike với thiết kế cổ điển và đệm Air Max êm ái, phù hợp với nhiều hoạt động.\n    * **Nike Air Force 1:** Một mẫu giày sneaker huyền thoại với nhiều phiên bản và màu sắc khác nhau, dễ dàng phối đồ.\n\n* **Nếu bạn muốn một đôi giày chuyên dụng cho chạy bộ:**\n    * **Nike React Miler:** Đệm React êm ái và bền bỉ, hỗ trợ tốt cho các buổi chạy dài.\n    * **Nike ZoomX Invincible Run Flyknit:** Đệm ZoomX siêu êm và đàn hồi, giúp giảm chấn và tăng hiệu suất chạy.\n\nBạn cho mình thêm thông tin để mình tư vấn kỹ hơn nha!', NULL, '2025-08-03 05:21:26', '2025-08-03 05:21:26'),
(69, 11, 'user', 'các sản phẩm có giá 10000', NULL, '2025-08-03 16:38:03', '2025-08-03 16:38:03'),
(70, 11, 'bot', 'Chào bạn! F1GENZ Shoes rất vui được hỗ trợ bạn. Bạn đang tìm kiếm sản phẩm có mức giá khoảng 10.000 VNĐ phải không ạ? Hiện tại, với mức giá này, rất khó để tìm được một đôi giày hoàn chỉnh. Tuy nhiên, F1GENZ Shoes có rất nhiều phụ kiện giày như dây giày, lót giày, tất,... với mức giá phù hợp. Bạn có muốn xem các sản phẩm này không?', NULL, '2025-08-03 16:38:03', '2025-08-03 16:38:03'),
(71, 11, 'user', 'cho tôi các sản phẩm có biến thể', NULL, '2025-08-03 16:38:45', '2025-08-03 16:38:45'),
(72, 11, 'bot', 'Chào bạn! Hiện tại, câu hỏi của bạn chưa đủ thông tin để F1GENZ Shoes có thể đưa ra gợi ý sản phẩm phù hợp. Bạn có thể cho mình biết thêm về loại sản phẩm bạn quan tâm, ví dụ như giày thể thao, giày da, sandals,... không? Hoặc bạn có thể cho mình biết bạn muốn tìm sản phẩm có biến thể về màu sắc, kích cỡ, hay chất liệu không? Mình sẽ cố gắng hết sức để giúp bạn tìm được sản phẩm ưng ý!', NULL, '2025-08-03 16:38:46', '2025-08-03 16:38:46'),
(73, 10, 'user', 'cho tôi các sản phẩm có giá 25000', NULL, '2025-08-06 18:45:11', '2025-08-06 18:45:11'),
(74, 10, 'bot', 'Chào bạn! Với ngân sách 25.000 VNĐ, mình sẽ tìm những sản phẩm phù hợp nhất từ Nike nhé. Tuy nhiên, với mức giá này, có thể các sản phẩm sẽ là phụ kiện như tất, dây giày, hoặc các sản phẩm đang được giảm giá sâu. Bạn có muốn mình mở rộng phạm vi tìm kiếm lên một chút để có nhiều lựa chọn giày thể thao hơn không?', NULL, '2025-08-06 18:45:11', '2025-08-06 18:45:11'),
(75, 10, 'user', 'cho tôi các sản phẩm có giá khoảng 10.000', NULL, '2025-08-06 18:46:04', '2025-08-06 18:46:04'),
(76, 10, 'bot', 'Chào bạn! Với ngân sách 10.000 VNĐ, rất tiếc hiện tại F1GENZ Shoes không có sản phẩm giày Nike nào ở mức giá này. Các sản phẩm Nike thường có giá cao hơn. Tuy nhiên, bạn có thể tìm thấy một số phụ kiện như dây giày, tất Nike hoặc các sản phẩm đang được giảm giá sâu trong các chương trình khuyến mãi. Bạn có muốn mình tìm kiếm các phụ kiện Nike với mức giá này không, hoặc bạn có thể nâng ngân sách lên một chút để có nhiều lựa chọn giày thể thao hơn không?', NULL, '2025-08-06 18:46:04', '2025-08-06 18:46:04'),
(77, 10, 'user', 'giới thiệu sơ qua các sản phẩm', NULL, '2025-08-06 18:46:46', '2025-08-06 18:46:46'),
(78, 10, 'bot', 'Chào bạn! Với sở thích về giày thể thao Nike và ngân sách rộng của bạn, cùng với xu hướng thời tiết mùa hè, mình xin giới thiệu sơ qua một số dòng sản phẩm nổi bật của Nike đang rất được ưa chuộng tại F1GENZ Shoes nhé:\n\n*   **Cho các hoạt động thể thao:**\n    *   **Nike Revolution 6/7:** Dòng giày chạy bộ phổ biến, giá cả phải chăng, thiết kế thoáng khí và đế êm ái, phù hợp cho cả nam và nữ.\n    *   **Nike Air Zoom Pegasus:** Dòng giày chạy bộ lâu đời của Nike, nổi tiếng với độ bền và khả năng hỗ trợ tốt. Có nhiều phiên bản và màu sắc để bạn lựa chọn.\n    *   **Nike Metcon:** Dòng giày tập luyện chuyên dụng, phù hợp cho các bài tập cardio, nâng tạ và crossfit.\n\n*   **Cho phong cách hàng ngày:**\n    *   **Nike Air Force 1:** Mẫu giày sneaker huyền thoại, biểu tượng của văn hóa đường phố. Có vô vàn phiên bản và phối màu để bạn thể hiện cá tính.\n    *   **Nike Air Max:** Dòng giày với đệm Air Max êm ái và thiết kế độc đáo. Các mẫu Air Max 90, Air Max 97 và Air Max 270 là những lựa chọn phổ biến.\n    *   **Nike Blazer:** Mẫu giày bóng rổ cổ điển, nay đã trở thành một item thời trang được yêu thích. Thiết kế đơn giản, dễ phối đồ.\n    *   **Nike Dunk:** Một mẫu giày sneaker đình đám khác của Nike, thường xuyên được ra mắt với các phiên bản collab độc đáo.\n\n*   **Các dòng giày khác:**\n    *   **Nike SB:** Dòng giày chuyên dụng cho trượt ván.\n    *   **Nike Jordan:** Dòng giày bóng rổ huyền thoại gắn liền với tên tuổi Michael Jordan.\n\nBạn có thể cho mình biết thêm về mục đích sử dụng, màu sắc yêu thích hoặc bất kỳ yêu cầu nào khác để mình tư vấn chi tiết hơn không ạ?', NULL, '2025-08-06 18:46:46', '2025-08-06 18:46:46'),
(79, 10, 'user', 'cho tôi các sản phẩm có giá trên 100000', NULL, '2025-08-16 00:07:51', '2025-08-16 00:07:51'),
(80, 10, 'bot', 'Chào bạn! Dựa trên sở thích giày Nike của bạn và ngân sách từ 100.000 VNĐ trở lên, cộng với thời tiết mùa hè hiện tại, mình xin gợi ý một số dòng sản phẩm đang được ưa chuộng tại F1GENZ Shoes, đáp ứng tiêu chí thoáng khí, mát mẻ và nhẹ nhàng nhé:\n\n*   **Cho các hoạt động thể thao:**\n    *   **Nike Revolution 6/7:** Dòng giày chạy bộ phổ biến, giá cả phải chăng, thiết kế thoáng khí và đế êm ái, phù hợp cho cả nam và nữ. Đây là lựa chọn kinh tế mà vẫn đảm bảo trải nghiệm tốt.\n    *   **Nike Air Zoom Pegasus:** Dòng giày chạy bộ lâu đời của Nike, nổi tiếng với độ bền và khả năng hỗ trợ tốt. Nhiều phiên bản có thiết kế thoáng khí phù hợp cho mùa hè.\n\n*   **Cho phong cách hàng ngày:**\n    *   **Nike Air Force 1:** Mẫu giày sneaker huyền thoại, biểu tượng của văn hóa đường phố. Chọn các phiên bản có chất liệu thoáng khí như vải canvas hoặc các lỗ thông khí.\n    *   **Nike Air Max:** Dòng giày với đệm Air Max êm ái và thiết kế độc đáo. Các mẫu Air Max 90, Air Max 97 và Air Max 270 có nhiều phiên bản với chất liệu thoáng khí.\n    *   **Nike Blazer:** Mẫu giày bóng rổ cổ điển, nay đã trở thành một item thời trang được yêu thích. Thiết kế đơn giản, dễ phối đồ. Ưu tiên các phiên bản làm từ vải canvas.\n    *   **Nike Dunk:** Một mẫu giày sneaker đình đám khác của Nike, thường xuyên được ra mắt với các phiên bản collab độc đáo. Tìm kiếm các phiên bản với chất liệu thoáng khí.\n\nVì bạn đã có 12 đơn hàng tại F1GENZ Shoes, mình tin bạn cũng quen thuộc với chất lượng sản phẩm ở đây rồi. Bạn có muốn mình lọc các sản phẩm theo một số tiêu chí cụ thể hơn như màu sắc, chất liệu, hoặc mục đích sử dụng (chạy bộ, đi chơi...) để mình đưa ra gợi ý phù hợp hơn không?', NULL, '2025-08-16 00:07:51', '2025-08-16 00:07:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_sessions`
--

CREATE TABLE `chat_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_sessions`
--

INSERT INTO `chat_sessions` (`id`, `user_id`, `session_token`, `created_at`, `updated_at`) VALUES
(7, 1, 'e76685d1-9001-45f8-91ec-e174ca7d42c7', '2025-04-16 05:08:03', '2025-04-16 05:08:03'),
(8, NULL, '583e72d2-7928-41f5-aeb7-e368a65841b2', '2025-04-22 23:30:26', '2025-04-22 23:30:26'),
(9, NULL, 'f1961b66-7f62-4b03-9100-98d24d892254', '2025-08-03 01:05:40', '2025-08-03 01:05:40'),
(10, 2, '0d0ae7ff-d1cf-4e04-9eba-01c0aa2e9fbe', '2025-08-03 01:15:15', '2025-08-03 01:15:15'),
(11, NULL, '927dc168-aa4a-4b0a-b838-51e3f96432ed', '2025-08-03 16:38:00', '2025-08-03 16:38:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comparisons`
--

CREATE TABLE `comparisons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL COMMENT 'Chủ đề liên hệ',
  `message` text NOT NULL,
  `status` enum('pending','processing','replied','closed') NOT NULL DEFAULT 'pending',
  `admin_reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `replied_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `admin_reply`, `replied_at`, `replied_by`, `created_at`, `updated_at`) VALUES
(1, 'Văn Vịnh Huỳnh', 'hungtrinhvan54@gmail.com', '0337937493', 'dep trai', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'processing', NULL, NULL, NULL, '2025-06-28 16:16:35', '2025-06-28 16:16:46'),
(2, 'Văn Vịnh Huỳnh', 'ebanythanh1@gmail.com', '0337937493', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'replied', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-06-28 16:31:59', 2, '2025-06-28 16:31:35', '2025-06-28 16:31:59'),
(3, 'Văn Vịnh Huỳnh', 'ebanythanh1@gmail.com', '0337937493', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'replied', 'admin helo', '2025-08-05 04:57:56', 2, '2025-07-01 04:33:21', '2025-08-05 04:57:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `min_cart_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_cart_value`, `start_date`, `end_date`, `usage_limit`, `used`, `image`, `description`, `created_at`, `updated_at`) VALUES
(10, 'F1SHOES02', 'percent', 10.00, 200000.00, '2025-04-04', '2025-04-30', 20, 5, 'coupons/1744430880.webp', 'Giảm giá 10% cho đơn hàng từ 200k', '2025-04-11 21:08:00', '2025-04-13 20:25:56'),
(11, 'F1SHOES03', 'percent', 13.00, 300000.00, '2025-04-04', '2025-04-30', 20, 1, 'coupons/1744430967.webp', 'Giảm giá 13% cho đơn hàng từ 300k', '2025-04-11 21:09:27', '2025-04-23 07:31:00'),
(12, 'F1SHOES04', 'fixed', 300000.00, 1000000.00, '2025-08-18', '2025-08-30', 20, 0, 'coupons/1744431010.webp', 'Giảm 300000 cho đơn hàng từ 1000000', '2025-04-11 21:10:10', '2025-08-18 05:11:37'),
(13, 'F1SHOES05', 'fixed', 50000.00, 1000000.00, '2025-07-01', '2025-07-30', 1000, 0, 'coupons/1744431118.webp', 'Giảm giá 500k cho đơn hàng 3 triệu', '2025-04-11 21:11:58', '2025-07-01 07:02:52'),
(15, 'F1SHOES098', 'fixed', 300000.00, 1000000.00, '2025-08-18', '2025-08-30', 20, 2, 'coupons/1755519210.png', NULL, '2025-08-18 05:13:30', '2025-08-18 05:15:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_user`
--

CREATE TABLE `coupon_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_user`
--

INSERT INTO `coupon_user` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`, `used`) VALUES
(1, 2, 13, '2025-08-18 05:08:17', '2025-08-18 05:08:17', 0),
(2, 2, 15, '2025-08-18 05:13:41', '2025-08-18 05:15:04', 1),
(3, 2, 12, '2025-08-18 05:13:49', '2025-08-18 05:13:49', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(24, 2, 69, '2025-08-17 20:02:18', '2025-08-17 20:02:18'),
(26, 2, 70, '2025-08-17 22:25:20', '2025-08-17 22:25:20'),
(27, 2, 71, '2025-08-18 00:53:17', '2025-08-18 00:53:17'),
(28, 2, 72, '2025-08-18 00:53:18', '2025-08-18 00:53:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `imageable_type` varchar(255) NOT NULL,
  `imageable_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `image_path`, `sort_order`, `created_at`, `updated_at`, `imageable_type`, `imageable_id`) VALUES
(46, 'img4.webp', NULL, '2025-04-15 22:31:48', '2025-04-15 22:31:48', 'App\\Models\\Product', 23),
(47, 'img7.webp', NULL, '2025-04-15 22:31:48', '2025-04-15 22:31:48', 'App\\Models\\Product', 23),
(48, 'img5.webp', NULL, '2025-04-15 22:31:48', '2025-04-15 22:31:48', 'App\\Models\\Product', 24),
(49, 'img6.webp', NULL, '2025-04-15 22:31:48', '2025-04-15 22:31:48', 'App\\Models\\Product', 24),
(50, 'uploads/products/img3.webp', NULL, '2025-04-15 22:36:12', '2025-04-15 22:36:12', 'App\\Models\\Product', 25),
(52, 'uploads/products/img7.webp', NULL, '2025-04-15 22:36:12', '2025-04-15 22:36:12', 'App\\Models\\Product', 25),
(53, 'uploads/products/img5.webp', NULL, '2025-04-15 22:36:12', '2025-04-15 22:36:12', 'App\\Models\\Product', 26),
(54, 'uploads/products/img6.webp', NULL, '2025-04-15 22:36:12', '2025-04-15 22:36:12', 'App\\Models\\Product', 26),
(55, 'uploads/products/img3.webp', NULL, '2025-04-15 22:51:40', '2025-04-15 22:51:40', 'App\\Models\\Product', 27),
(56, 'uploads/products/img4.webp', NULL, '2025-04-15 22:51:40', '2025-04-15 22:51:40', 'App\\Models\\Product', 27),
(57, 'uploads/products/img7.webp', NULL, '2025-04-15 22:51:40', '2025-04-15 22:51:40', 'App\\Models\\Product', 27),
(58, 'uploads/products/img5.webp', NULL, '2025-04-15 22:51:40', '2025-04-15 22:51:40', 'App\\Models\\Product', 28),
(59, 'uploads/products/img6.webp', NULL, '2025-04-15 22:51:40', '2025-04-15 22:51:40', 'App\\Models\\Product', 28),
(60, 'uploads/products/img3.webp', NULL, '2025-04-16 19:01:37', '2025-04-16 19:01:37', 'App\\Models\\Product', 29),
(61, 'uploads/products/img4.webp', NULL, '2025-04-16 19:01:37', '2025-04-16 19:01:37', 'App\\Models\\Product', 29),
(62, 'uploads/products/img7.webp', NULL, '2025-04-16 19:01:37', '2025-04-16 19:01:37', 'App\\Models\\Product', 29),
(63, 'uploads/products/img5.webp', NULL, '2025-04-16 19:01:37', '2025-04-16 19:01:37', 'App\\Models\\Product', 30),
(64, 'uploads/products/img6.webp', NULL, '2025-04-16 19:01:37', '2025-04-16 19:01:37', 'App\\Models\\Product', 30),
(65, 'uploads/products/img3.webp', NULL, '2025-04-16 19:49:42', '2025-04-16 19:49:42', 'App\\Models\\Product', 31),
(66, 'uploads/products/img4.webp', NULL, '2025-04-16 19:49:43', '2025-04-16 19:49:43', 'App\\Models\\Product', 31),
(67, 'uploads/products/img7.webp', NULL, '2025-04-16 19:49:43', '2025-04-16 19:49:43', 'App\\Models\\Product', 31),
(68, 'uploads/products/img5.webp', NULL, '2025-04-16 19:49:43', '2025-04-16 19:49:43', 'App\\Models\\Product', 32),
(69, 'uploads/products/img6.webp', NULL, '2025-04-16 19:49:43', '2025-04-16 19:49:43', 'App\\Models\\Product', 32),
(70, 'uploads/products/1745473541_vn-11134207-7ra0g-m835dm5psqr233.webp', NULL, '2025-04-23 22:45:41', '2025-04-23 22:45:41', 'App\\Models\\Product', 33),
(71, 'uploads/products/1745473541_vn-11134207-7ra0g-m835dm5pu5c76d.webp', NULL, '2025-04-23 22:45:41', '2025-04-23 22:45:41', 'App\\Models\\Product', 33),
(72, 'uploads/products/1745473541_vn-11134207-7ras8-m4d0036fkf7r12.webp', NULL, '2025-04-23 22:45:41', '2025-04-23 22:45:41', 'App\\Models\\Product', 33),
(73, 'uploads/products/img3.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 35),
(74, 'uploads/products/img4.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 35),
(75, 'uploads/products/img7.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 35),
(76, 'uploads/products/img5.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 36),
(77, 'uploads/products/img6.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 36),
(94, 'uploads/products/1751420944_9e6234a353f902a278202d902fe6cdc2.webp', NULL, '2025-07-01 18:49:04', '2025-07-01 18:49:04', 'App\\Models\\Product', 48),
(112, 'uploads/products/1751530686_46ae1e959d8fbbb4e735fe4a4fa19c17 - Copy.webp', NULL, '2025-07-03 01:18:06', '2025-07-03 01:18:06', 'App\\Models\\Product', 7),
(113, 'uploads/products/1751530686_46ae1e959d8fbbb4e735fe4a4fa19c17.webp', NULL, '2025-07-03 01:18:06', '2025-07-03 01:18:06', 'App\\Models\\Product', 7),
(114, 'uploads/products/1751530686_98c357b90681f99d05ce605e8283a4d0 - Copy - Copy.webp', NULL, '2025-07-03 01:18:06', '2025-07-03 01:18:06', 'App\\Models\\Product', 7),
(121, 'uploads/products/1751854928_98c357b90681f99d05ce605e8283a4d0 - Copy - Copy.webp', NULL, '2025-07-06 19:22:08', '2025-07-06 19:22:08', 'App\\Models\\Product', 58),
(122, 'uploads/products/1752918132_z6701599183477_2e0ad124882ac206d02bf6d8d69d5ee3.jpg', NULL, '2025-07-19 02:42:12', '2025-07-19 02:42:12', 'App\\Models\\Product', 59),
(123, 'uploads/products/1754268541_ao-thun-dui-nam-coc-tay-trang-3.png', NULL, '2025-08-03 17:49:01', '2025-08-03 17:49:01', 'App\\Models\\Product', 60),
(124, 'uploads/products/1754268541_ao-thun-nu-han-quoc-s7171.webp', NULL, '2025-08-03 17:49:01', '2025-08-03 17:49:01', 'App\\Models\\Product', 60),
(125, 'uploads/products/1754567899_ao-thun-dui-nam-coc-tay-trang-3.png', NULL, '2025-08-07 04:58:19', '2025-08-07 04:58:19', 'App\\Models\\Product', 61),
(126, 'uploads/products/1755252492_ao-thun-dui-nam-coc-tay-trang-3.png', NULL, '2025-08-15 03:08:12', '2025-08-15 03:08:12', 'App\\Models\\Product', 62),
(127, 'uploads/products/1755252765_ao-thun-dui-nam-coc-tay-trang-3.png', NULL, '2025-08-15 03:12:45', '2025-08-15 03:12:45', 'App\\Models\\Product', 63),
(128, 'uploads/products/1755253337_46ae1e959d8fbbb4e735fe4a4fa19c17 - Copy.webp', NULL, '2025-08-15 03:22:17', '2025-08-15 03:22:17', 'App\\Models\\Product', 64),
(129, 'uploads/products/1755253834_46ae1e959d8fbbb4e735fe4a4fa19c17.webp', NULL, '2025-08-15 03:30:34', '2025-08-15 03:30:34', 'App\\Models\\Product', 65),
(130, 'uploads/products/1755254338_9e6234a353f902a278202d902fe6cdc2.webp', NULL, '2025-08-15 03:38:58', '2025-08-15 03:38:58', 'App\\Models\\Product', 66),
(131, 'uploads/products/1755254504_98c357b90681f99d05ce605e8283a4d0 - Copy - Copy.webp', NULL, '2025-08-15 03:41:44', '2025-08-15 03:41:44', 'App\\Models\\Product', 67),
(132, 'uploads/products/1755255007_9c0b0008e07845caa18e89c288f1ef92.webp', NULL, '2025-08-15 03:50:07', '2025-08-15 03:50:07', 'App\\Models\\Product', 68),
(133, 'uploads/products/1755396667_46ae1e959d8fbbb4e735fe4a4fa19c17.webp', NULL, '2025-08-16 19:11:07', '2025-08-16 19:11:07', 'App\\Models\\Product', 69),
(134, 'uploads/products/1755396922_cn-11134301-7qukw-lkbs96nrezt210@resize_w900_nl.webp', NULL, '2025-08-16 19:15:22', '2025-08-16 19:15:22', 'App\\Models\\Product', 70),
(135, 'uploads/products/1755503122_OIP.webp', NULL, '2025-08-18 00:45:22', '2025-08-18 00:45:22', 'App\\Models\\Product', 71),
(136, 'uploads/products/1755503147_OIP.webp', NULL, '2025-08-18 00:45:47', '2025-08-18 00:45:47', 'App\\Models\\Product', 72);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image_search_logs`
--

CREATE TABLE `image_search_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_image` varchar(255) NOT NULL,
  `ai_description` text NOT NULL,
  `search_filters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`search_filters`)),
  `search_results` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`search_results`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image_vectors`
--

CREATE TABLE `image_vectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  `vector` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`vector`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_warehouse`
--

CREATE TABLE `import_warehouse` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_warehouse_details`
--

CREATE TABLE `import_warehouse_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `import_warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `import_warehouse_details`
--

INSERT INTO `import_warehouse_details` (`id`, `import_warehouse_id`, `product_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(45, 24, 69, 97, 500, 120000.00, '2025-08-16 19:31:20', '2025-08-16 19:31:20'),
(46, 24, 70, 98, 500, 120000.00, '2025-08-16 19:31:20', '2025-08-16 19:31:20'),
(47, 24, 70, 99, 500, 120000.00, '2025-08-16 19:31:20', '2025-08-16 19:31:20'),
(48, 24, 70, 100, 500, 120000.00, '2025-08-16 19:31:20', '2025-08-16 19:31:20'),
(49, 25, 69, 97, 100, 120000.00, '2025-08-17 18:53:17', '2025-08-17 18:53:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `live_chat_sessions`
--

CREATE TABLE `live_chat_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('waiting','active','closed') NOT NULL DEFAULT 'waiting',
  `session_id` varchar(255) NOT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ended_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logos`
--

CREATE TABLE `logos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_18_140149_add_parent_id_to_categories_table', 1),
(5, '2025_03_18_142235_add_status_to_categories_table', 1),
(6, '2025_03_19_141148_create_brands_table', 1),
(7, '2025_03_19_142803_create_products_table', 1),
(8, '2025_03_20_135412_create_colors_table', 1),
(9, '2025_03_20_135450_create_sizes_table', 1),
(10, '2025_03_20_144318_update_products_table_for_variants', 1),
(11, '2025_03_20_144503_create_product_images_table', 1),
(12, '2025_03_27_012421_add_role_to_user_tableç', 1),
(13, '2025_03_29_015123_add_google_id_to_user_tableç', 1),
(14, '2025_03_29_120053_add_facebook_id_to_user_tableç', 1),
(15, '2025_04_05_114926_rename_product_images_to_images', 1),
(16, '2025_04_05_120752_add_imageable_to_images_table', 2),
(17, '2025_04_05_150518_create_attributes_table', 3),
(18, '2025_04_05_150536_create_attribute_values_table', 3),
(19, '2025_04_05_150549_create_product_variants_table', 3),
(20, '2025_04_05_150600_create_variant_attribute_values_table', 3),
(21, '2025_04_07_122602_add_timestamps_to_variant_attribute_values_table', 4),
(22, '2025_04_09_005240_create_shoppingcart_table', 5),
(23, '2025_04_11_072009_create_coupons_table', 6),
(24, '2025_04_11_083623_add_image_and_description_to_coupons_table', 7),
(27, '2025_04_11_101149_create_orders_table', 8),
(29, '2025_04_11_101527_create_order_details_table', 9),
(30, '2025_04_11_123526_add_order_code_to_orders_table', 10),
(31, '2025_04_11_171953_create_addresses_table', 11),
(32, '2025_04_11_173754_add_name_to_addresses_table', 12),
(33, '2025_04_11_173845_add_phone_to_addresses_table', 13),
(34, '2025_04_14_130359_create_product_reviews_table', 14),
(35, '2025_04_16_090150_create_chat_sessions_table', 15),
(36, '2025_04_16_090151_create_chat_messages_table', 15),
(37, '2025_04_16_120451_add_product_ids_to_chat_messages_table', 16),
(38, '2025_04_16_144927_add_partner_code_to_orders_table', 17),
(39, '2025_04_23_143422_add_shipping_fee_to_orders_table', 18),
(40, '2025_06_07_070310_create_post_categories_table', 19),
(41, '2025_06_07_070643_create_posts_table', 19),
(42, '2025_06_06_025027_create_otp_codes_table', 20),
(43, '2025_06_11_032711_create_banners_table', 20),
(44, '2025_06_13_031429_create_favorites_table', 21),
(45, '2025_06_25_110342_create_contacts_table', 22),
(46, '2025_06_26_000001_add_subject_to_contacts_table', 22),
(47, '2025_07_02_012526_add_import_price_to_products_table', 23),
(48, '2025_07_02_015157_add_quantity_to_products_table', 24),
(49, '2025_07_11_032706_create_suppliers_table', 25),
(50, '2025_07_11_082453_add_website_to_suppliers_table', 26),
(51, '2025_07_14_092427_create_import_warehouse_table', 27),
(52, '2025_07_15_232725_create_order__warehouses_table', 28),
(53, '2025_07_15_232748_create_import_warehouse_details_table', 28),
(54, '2025_07_16_013459_add_quantity_to_import_warehouse_table', 29),
(55, '2025_07_26_010127_add_total_price_to_order_warehouses_table', 30),
(56, '2025_07_28_003549_add_payment_fields_to_order_warehouses_table', 31),
(57, '2025_07_28_005520_update_payment_fields_in_order_warehouses_table', 32),
(58, '2025_01_15_000000_create_live_chat_sessions_table', 33),
(59, '2025_07_04_014451_create_image_search_logs_table', 33),
(60, '2025_07_07_082833_create_sizes_table', 34),
(61, '2025_07_11_101501_create_comparisons_table', 34),
(62, '2025_07_16_044117_add_cancel_reason_to_orders_table', 34),
(63, '2025_07_11_021835_update_product_reviews_and_create_product_review_media_table', 35),
(64, '2025_08_02_091100_add_fields_to_order_details_table', 35),
(65, '2025_08_03_234807_add_import_and_discount_price_to_product_variants_table', 36),
(66, '2025_08_04_065928_add_quantity_to_product_variants_table', 37),
(67, '2025_08_15_103631_update_slug_nullable_in_product_variants_table', 38),
(68, '2025_08_15_103935_update_stock_default_in_product_variants_table', 39),
(69, '2025_08_13_000001_create_product_live_chat_threads_table', 40),
(70, '2025_08_13_000002_create_product_live_chat_messages_table', 40),
(71, '2025_08_13_000003_create_product_live_chat_attachments_table', 40),
(72, '2025_08_13_000004_alter_product_live_chat_messages_message_nullable', 40),
(73, '2025_08_17_013144_add_deleted_at_to_products_and_variants', 41),
(74, '2025_08_18_023052_add_deleted_at_to_order_warehouses_table', 42),
(75, '2025_08_18_053453_update_orders_price_columns', 43),
(76, '2025_07_04_040915_add_image_to_brands_table', 44),
(77, '2025_07_11_032337_create_coupon_user_table', 44),
(78, '2025_07_16_010604_add_phone_and_image_to_users_table', 44),
(79, '2025_07_28_180428_create_logos_table', 44),
(80, '2025_08_13_085823_create_popups_table', 44);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) NOT NULL,
  `partner_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `cancel_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `partner_code`, `user_id`, `email`, `name`, `phone`, `address`, `province`, `district`, `ward`, `note`, `subtotal`, `discount`, `shipping_fee`, `total`, `payment_method`, `status`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(88, 'ORDER-68A13FF517407', NULL, 2, 'hungtrinhvan54@gmail.com', 'YTHIP ÊBANeee', '0337937493', 'BMT', 'Điện Biên', 'Huyện Nậm Pồ', 'Xã Chà Tở', 'aaaaaaaaaaaaaaaaaaaaaaa', 12000000.00, 0.00, 34000.00, 12034000.00, 'cod', 'delivered', NULL, '2025-08-16 19:35:35', '2025-08-17 16:47:13'),
(89, 'ORDER-68A2BC01AFCDC', NULL, 2, 'hungtrinhvan54@gmail.com', 'YTHANH ÊBAN', '0337937493', 'y wang', 'Sóc Trăng', 'Huyện Châu Thành', 'Xã An Ninh', NULL, 120000000.00, 0.00, 31501.00, 120031501.00, 'cod', 'ordered', NULL, '2025-08-17 22:37:08', '2025-08-17 22:37:08'),
(90, 'ORDER-68A318A754A1B', NULL, 2, 'hungtrinhvan54@gmail.com', 'YTHIP ÊBANeee', '0337937493', 'y wang', 'Sóc Trăng', 'Huyện Thạnh Trị', 'Xã Thạnh Trị', NULL, 12000000.00, 0.00, 36501.00, 12036501.00, 'cod', 'ordered', NULL, '2025-08-18 05:12:25', '2025-08-18 05:12:25'),
(91, 'ORDER-68A31945CC2C0', NULL, 2, 'hungtrinhvan54@gmail.com', 'YTHIP ÊBANeee', '0337937493', 'y wang', 'Sóc Trăng', 'Thị xã Ngã Năm', 'Xã Tân Long', NULL, 12000000.00, 300000.00, 36501.00, 11736501.00, 'cod', 'ordered', NULL, '2025-08-18 05:15:04', '2025-08-18 05:15:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `variant_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variant_details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `quantity`, `price`, `variant_details`, `created_at`, `updated_at`) VALUES
(95, 88, 70, 98, 'Mũ Vành Tròn', 10000, 120000.00, '{\"M\\u00e0u\":\"H\\u1ed3ng\",\"K\\u00edch Th\\u01b0\\u1edbc\":\"37\"}', '2025-08-16 19:35:35', '2025-08-16 19:35:35'),
(96, 89, 69, 97, 'Áo Thể Thao', 1000, 120000.00, '{\"M\\u00e0u\":\"\\u0110\\u1ecf\"}', '2025-08-17 22:37:08', '2025-08-17 22:37:08'),
(97, 90, 69, 97, 'Áo Thể Thao', 100, 120000.00, '{\"M\\u00e0u\":\"\\u0110\\u1ecf\"}', '2025-08-18 05:12:25', '2025-08-18 05:12:25'),
(98, 91, 70, 98, 'Mũ Vành Tròn', 100, 120000.00, '{\"M\\u00e0u\":\"H\\u1ed3ng\",\"K\\u00edch Th\\u01b0\\u1edbc\":\"37\"}', '2025-08-18 05:15:04', '2025-08-18 05:15:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_warehouses`
--

CREATE TABLE `order_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `import_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Chờ Xử Lý',
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_amount` decimal(15,2) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `import_type` varchar(255) NOT NULL DEFAULT 'Chưa Nhập',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_warehouses`
--

INSERT INTO `order_warehouses` (`id`, `code`, `supplier_id`, `user_id`, `note`, `total_price`, `import_date`, `status`, `payment_status`, `payment_method`, `payment_amount`, `payment_date`, `payment_reference`, `import_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(24, '123456', 1, 1, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 240000000.00, '2025-08-17', 'Hoàn Thành', 'Đã thanh toán', 'Chuyển khoản', 240000000.00, '2025-08-17', 'aaaaaaaaaaaaaaaaaaaaaa', 'Đã Nhập Kho', '2025-08-16 19:31:20', '2025-08-16 19:33:43', NULL),
(25, 'aaaaaaaaaaaaaaarraaaaaaaaaaaa', 1, 1, 'aaaaaaaaaaaa', 12000000.00, '2025-08-18', 'Chờ Xử Lý', 'Đã thanh toán', 'Chuyển khoản', 12000000.00, '2025-08-18', 'aaaaaaaaaaaaaaaaaaaaaaaaaa', 'Chưa Nhập', '2025-08-17 18:53:17', '2025-08-17 19:11:50', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ebanythanh1@gmail.com', '$2y$12$4JMtBgYUiYLRJdq9r.6LkeZN3iQmuPBNNK.agjbtsz9pDGk/f6Jk.', '2025-08-13 05:10:33'),
('hungtrinhvan54@gmail.com', '$2y$12$7SnlPfhl5ttioTYttYR7x.rPnp6Pwud9W8OWkCyVn1jCUwFXThRee', '2025-04-13 08:54:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `popups`
--

CREATE TABLE `popups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `media_type` varchar(255) NOT NULL DEFAULT 'image',
  `media_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` varchar(11) NOT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `post_category_id`, `title`, `content`, `image`, `created_at`, `author`, `is_visible`) VALUES
(1, 2, 'Bài Viết Về Giày', '<h2 id=\"toc-i-y-tuong-content-hay-ve-giay-dep\" class=\"ftwp-heading\">I. &Yacute; tưởng content hay về gi&agrave;y d&eacute;p</h2>\r\n<p>Hướng dẫn chọn gi&agrave;y ph&ugrave; hợp: Tạo ra c&aacute;c b&agrave;i viết, video hoặc infographics giải th&iacute;ch c&aacute;ch chọn gi&agrave;y ph&ugrave; hợp với từng hoạt động, kiểu d&aacute;ng ch&acirc;n v&agrave; phong c&aacute;ch c&aacute; nh&acirc;n. Bạn c&oacute; thể đề cập đến c&aacute;c yếu tố như chất liệu, kiểu d&aacute;ng, k&iacute;ch cỡ, v&agrave; c&aacute;ch phối gi&agrave;y với trang&nbsp;phục.</p>\r\n<ul>\r\n<li><strong>Xu hướng gi&agrave;y mới:</strong>&nbsp;Cập nhật v&agrave; chia sẻ th&ocirc;ng tin về c&aacute;c xu hướng gi&agrave;y mới nhất. Viết b&agrave;i viết hoặc tổ chức cuộc thăm d&ograve; &yacute; kiến ​​kh&aacute;ch h&agrave;ng về c&aacute;c xu hướng phổ biến hoặc tạo ra c&aacute;c bản đ&aacute;nh gi&aacute; về những mẫu gi&agrave;y nổi bật.</li>\r\n<li><strong>Content quảng c&aacute;o:</strong>&nbsp;Đăng tải b&agrave;i viết giới thiệu c&aacute;c sản phẩm mới, theo m&ugrave;a, c&aacute;c đợt giảm gi&aacute;, flashsale để người theo d&otilde;i cập nhật nhanh ch&oacute;ng.</li>\r\n</ul>\r\n<p><span style=\"box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 19px; text-size-adjust: 100%; vertical-align: baseline; background: transparent;\" data-sheets-root=\"1\" data-sheets-value=\"{&quot;1&quot;:2,&quot;2&quot;:&quot;&lt;a href=&quot;https://abcdigi.marketing/elearning/khoa-hoc-abc-content-marketing-mien-phi/&quot; target=&quot;_blank&quot; rel=&quot;noopener&quot;&gt;&lt;img class=&quot;aligncenter wp-image-74799 size-full&quot; src=&quot;https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/04/Khoa-hoc-mien-phi-abcdigi-abc-content-2.gif&quot; alt=&quot;Kh&oacute;a học miễn ph&iacute; content marketing cho người mới bắt đầu&quot; width=&quot;600&quot; height=&quot;450&quot; /&gt;&lt;/a&gt;&quot;}\" data-sheets-userformat=\"{&quot;2&quot;:765,&quot;3&quot;:{&quot;1&quot;:0},&quot;5&quot;:{&quot;1&quot;:[{&quot;1&quot;:2,&quot;2&quot;:0,&quot;5&quot;:{&quot;1&quot;:2,&quot;2&quot;:0}},{&quot;1&quot;:0,&quot;2&quot;:0,&quot;3&quot;:3},{&quot;1&quot;:1,&quot;2&quot;:0,&quot;4&quot;:1}]},&quot;6&quot;:{&quot;1&quot;:[{&quot;1&quot;:2,&quot;2&quot;:0,&quot;5&quot;:{&quot;1&quot;:2,&quot;2&quot;:0}},{&quot;1&quot;:0,&quot;2&quot;:0,&quot;3&quot;:3},{&quot;1&quot;:1,&quot;2&quot;:0,&quot;4&quot;:1}]},&quot;7&quot;:{&quot;1&quot;:[{&quot;1&quot;:2,&quot;2&quot;:0,&quot;5&quot;:{&quot;1&quot;:2,&quot;2&quot;:0}},{&quot;1&quot;:0,&quot;2&quot;:0,&quot;3&quot;:3},{&quot;1&quot;:1,&quot;2&quot;:0,&quot;4&quot;:1}]},&quot;8&quot;:{&quot;1&quot;:[{&quot;1&quot;:2,&quot;2&quot;:0,&quot;5&quot;:{&quot;1&quot;:2,&quot;2&quot;:0}},{&quot;1&quot;:0,&quot;2&quot;:0,&quot;3&quot;:3},{&quot;1&quot;:1,&quot;2&quot;:0,&quot;4&quot;:1}]},&quot;9&quot;:1,&quot;10&quot;:1,&quot;12&quot;:0}\"><a href=\"https://abcdigi.marketing/elearning/khoa-hoc-abc-content-marketing-mien-phi/\" target=\"_blank\" rel=\"noopener\"><img class=\"aligncenter wp-image-74799 size-full lazyloaded\" title=\"H&igrave;nh ảnh 10+ Mẫu Content Hay Về Gi&agrave;y D&eacute;p Thu H&uacute;t Kh&aacute;ch H&agrave;ng 17\" src=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/04/Khoa-hoc-mien-phi-abcdigi-abc-content-2.gif?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;resize=600%2C450&amp;ssl=1\" alt=\"Kh&oacute;a học miễn ph&iacute; content marketing cho người mới bắt đầu\" width=\"600\" height=\"450\" loading=\"lazy\" data-src=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/04/Khoa-hoc-mien-phi-abcdigi-abc-content-2.gif?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;resize=600%2C450&amp;ssl=1\" data-eio-rwidth=\"600\" data-eio-rheight=\"450\"></a></span></p>\r\n<ul>\r\n<li><strong>C&acirc;u chuyện thương hiệu:</strong>&nbsp;Kể c&acirc;u chuyện về thương hiệu gi&agrave;y của bạn, bao gồm lịch sử, gi&aacute; trị cốt l&otilde;i, v&agrave; sứ mệnh của c&ocirc;ng ty. Điều n&agrave;y gi&uacute;p x&acirc;y dựng sự kết nối v&agrave; l&ograve;ng tin tưởng với kh&aacute;ch h&agrave;ng.</li>\r\n<li><strong>Hướng dẫn bảo quản gi&agrave;y:</strong>&nbsp;Tạo ra nội dung về c&aacute;ch bảo quản v&agrave; chăm s&oacute;c gi&agrave;y để gi&uacute;p kh&aacute;ch h&agrave;ng duy tr&igrave; sự mới mẻ v&agrave; độ bền của đ&ocirc;i gi&agrave;y. Bạn c&oacute; thể chia sẻ c&aacute;c b&iacute; quyết l&agrave;m sạch, chống nước, v&agrave; bảo quản gi&agrave;y theo đ&uacute;ng c&aacute;ch.</li>\r\n<li><strong>Sự kiện v&agrave; hợp t&aacute;c:</strong>&nbsp;Tạo ra nội dung li&ecirc;n quan đến sự kiện, triển l&atilde;m, hoặc hợp t&aacute;c đặc biệt m&agrave; thương hiệu gi&agrave;y của bạn tham gia. Chia sẻ th&ocirc;ng tin về những hoạt động n&agrave;y, hậu trường, v&agrave; những lợi &iacute;ch m&agrave; kh&aacute;ch h&agrave;ng c&oacute; thể nhận được từ việc tham gia.</li>\r\n<li><strong>C&aacute;c b&agrave;i viết về phong c&aacute;ch:</strong>&nbsp;Tạo ra nội dung về c&aacute;ch phối gi&agrave;y với c&aacute;c trang phục kh&aacute;c nhau, từ phong c&aacute;ch c&ocirc;ng sở đến phong c&aacute;ch thể thao hay dạo phố. Bạn c&oacute; thể chia sẻ gợi &yacute; về c&aacute;ch tạo n&ecirc;n c&aacute;c bộ trang phục phong c&aacute;ch v&agrave; thời trang.</li>\r\n</ul>\r\n<blockquote>\r\n<p><strong>Xem th&ecirc;m: 2 c&ocirc;ng thức viết b&agrave;i b&aacute;n h&agrave;ng&nbsp;<a href=\"https://abcdigi.marketing/blog/cong-thuc-viet-quang-cao-pas-va-pbs/\" target=\"_blank\" rel=\"noopener\">PAS v&agrave; PBS</a></strong></p>\r\n</blockquote>\r\n<ul>\r\n<li><strong>Đ&aacute;nh gi&aacute; sản phẩm:</strong>&nbsp;Tạo ra c&aacute;c b&agrave;i viết hoặc video đ&aacute;nh gi&aacute; chi tiết về những mẫu gi&agrave;y cụ thể. Bạn c&oacute; thể chia sẻ nhận x&eacute;t về chất lượng, độ thoải m&aacute;i, v&agrave; phong c&aacute;ch của từng sản phẩm để gi&uacute;p kh&aacute;ch h&agrave;ng c&oacute; quyết định mua h&agrave;ng tốt hơn.</li>\r\n<li><strong>Cộng đồng người sử dụng:</strong>&nbsp;Tạo ra nội dung li&ecirc;n quan đến cộng đồng người sử dụng gi&agrave;y của bạn. C&oacute; thể l&agrave; chia sẻ h&igrave;nh ảnh, c&acirc;u chuyện, hoặc trải nghiệm của kh&aacute;ch h&agrave;ng với sản phẩm của bạn.</li>\r\n<li><strong>Tư vấn thời trang:</strong>&nbsp;Tạo ra nội dung về c&aacute;ch phối gi&agrave;y với c&aacute;c xu hướng thời trang hiện tại. Cung cấp gợi &yacute; về c&aacute;ch tạo n&ecirc;n c&aacute;c bộ trang phục thời trang v&agrave; trẻ trung.</li>\r\n<li><strong>Video hướng dẫn:</strong>&nbsp;Tạo ra c&aacute;c video hướng dẫn về c&aacute;ch l&agrave;m mới gi&agrave;y, c&aacute;ch phối gi&agrave;y với trang phục kh&aacute;c nhau, hoặc c&aacute;ch tạo kiểu t&oacute;c ph&ugrave; hợp với đ&ocirc;i gi&agrave;y.</li>\r\n</ul>\r\n<p><img class=\" lazyloaded\" title=\"H&igrave;nh ảnh 10+ Mẫu Content Hay Về Gi&agrave;y D&eacute;p Thu H&uacute;t Kh&aacute;ch H&agrave;ng 18\" src=\"https://afamilycdn.com/2018/8/15/1-1534324759397846923948.jpg\" alt=\"8 kiểu gi&agrave;y d&eacute;p nhiều chị em cứ tưởng l&agrave; đẹp nhưng c&oacute; thể khiến họ mất điểm ho&agrave;n to&agrave;n\" data-src=\"https://afamilycdn.com/2018/8/15/1-1534324759397846923948.jpg\"></p>\r\n<p><em>&Yacute; tưởng content gi&agrave;y d&eacute;p&nbsp;hay</em></p>\r\n<h2 id=\"toc-ii-10-mau-content-giay-dep-hay\" class=\"ftwp-heading\">II. 10+ mẫu content gi&agrave;y d&eacute;p hay</h2>\r\n<h3 id=\"toc-mau-content-hay-ve-giay-dep-ban-hang\" class=\"ftwp-heading\">Mẫu content hay về gi&agrave;y d&eacute;p (b&aacute;n h&agrave;ng)</h3>\r\n<p>L&agrave; c&aacute;c content b&aacute;n h&agrave;ng trực tiếp, ngắn gọn, đầy đủ th&ocirc;ng tin, c&oacute; thể sử dụng để chạy quảng c&aacute;o.<br>Bố cục 1 content b&aacute;n h&agrave;ng&nbsp;hay</p>\r\n<h4 id=\"toc-1-tieu-de-hap-dan\" class=\"ftwp-heading\">1. Ti&ecirc;u đề hấp dẫn</h4>\r\n<p>3 d&ograve;ng đầu tr&ecirc;n Facebook v&ocirc; c&ugrave;ng quan trọng, n&oacute; l&agrave; phần th&ocirc;ng tin &iacute;t ỏi Facebook cho hiện trước chữ &ldquo;Xem th&ecirc;m&hellip;&ldquo;, v&igrave; thế nếu 3 d&ograve;ng n&agrave;y kh&ocirc;ng đủ hấp dẫn, thu h&uacute;t sự ch&uacute; &yacute; của kh&aacute;ch h&agrave;ng để họ phải t&ograve; m&ograve; xem tiếp, th&igrave; coi như b&agrave;i viết thất&nbsp;bại.</p>\r\n<blockquote>\r\n<p><strong>Xem th&ecirc;m: C&aacute;ch viết b&agrave;i b&aacute;n h&agrave;ng bằng&nbsp;<a href=\"https://abcdigi.marketing/elearning/khoa-hoc-mo-hinh-aida/\" target=\"_blank\" rel=\"noopener\">m&ocirc; h&igrave;nh AIDA</a></strong></p>\r\n</blockquote>\r\n<p>3 d&ograve;ng đầu n&agrave;y&nbsp;cần:</p>\r\n<p>&ndash; n&ecirc;u ra được vấn đề m&agrave; kh&aacute;ch h&agrave;ng quan t&acirc;m nhất, hoặc nỗi đau lớn nhất của&nbsp;họ.</p>\r\n<p>&ndash; đưa ra l&yacute; do đủ mạnh tại sao kh&aacute;ch h&agrave;ng n&ecirc;n đọc tiếp để tạo sự t&ograve; m&ograve;, từ đ&oacute; kh&aacute;ch h&agrave;ng c&oacute; động lực để xem th&ecirc;m nội&nbsp;dung.</p>\r\n<h4 id=\"toc-2-noi-dung-quang-cao\" class=\"ftwp-heading\">2. Nội dung quảng c&aacute;o</h4>\r\n<p>Ở phần n&agrave;y, bạn cần n&ecirc;u r&otilde;:<br>+ T&iacute;nh năng của sản phẩm gi&uacute;p giải quyết nhu cầu của kh&aacute;ch h&agrave;ng<br>+ C&aacute;c th&ocirc;ng tin chi tiết hơn về sản phẩm<br>+ C&aacute;ch sử dụng, ai n&ecirc;n sử dụng, hiệu quả như thế n&agrave;o<br>+ C&aacute;c bằng chứng, giấy chứng nhận về chất lượng của sản phẩm<br>+ Gi&aacute;&nbsp;b&aacute;n</p>\r\n<blockquote>\r\n<p><strong>Xem th&ecirc;m: 5 bước x&acirc;y dựng&nbsp;<a href=\"https://abcdigi.marketing/blog/ke-hoach-noi-dung-facebook-co-ban/\" target=\"_blank\" rel=\"noopener\">Kế Hoạch Nội Dung Facebook</a>&nbsp;cơ bản</strong></p>\r\n</blockquote>\r\n<h4 id=\"toc-3-uu-dai-dac-biet\" class=\"ftwp-heading\">3. Ưu đ&atilde;i đặc biệt</h4>\r\n<p>Nếu như bạn c&oacute; ưu đ&atilde;i, khuyến m&atilde;i g&igrave; đặc biệt th&igrave; bạn h&atilde;y n&ecirc;u r&otilde; ở đ&acirc;y, k&egrave;m với điều kiện v&agrave; thời gian &aacute;p dụng r&otilde;&nbsp;r&agrave;ng.</p>\r\n<h4 id=\"toc-4-chinh-sach-ban-hang\" class=\"ftwp-heading\">4. Ch&iacute;nh s&aacute;ch b&aacute;n h&agrave;ng</h4>\r\n<p>Phần n&agrave;y bạn cần ghi r&otilde; c&aacute;c ch&iacute;nh s&aacute;ch b&aacute;n h&agrave;ng gồm phương thức thanh to&aacute;n, h&igrave;nh thức giao h&agrave;ng, đổi trả h&agrave;ng, bảo h&agrave;nh. Kh&aacute;ch h&agrave;ng sẽ rất quan t&acirc;m phần n&agrave;y nếu như họ muốn mua sản phẩm của bạn. Phần n&agrave;y nếu bạn kh&ocirc;ng n&ecirc;u r&otilde; r&agrave;ng c&aacute;c th&ocirc;ng tin, th&igrave; kh&aacute;ch h&agrave;ng sẽ nghi ngờ về chất lượng dịch vụ của&nbsp;bạn.</p>\r\n<blockquote>\r\n<p><strong>Xem th&ecirc;m: Top 12&nbsp;<a href=\"https://abcdigi.marketing/blog/khoa-hoc-content-marketing/\" target=\"_blank\" rel=\"noopener\">Kh&oacute;a Học Content Marketing</a>&nbsp;Miễn Ph&iacute; V&agrave; C&oacute; Ph&iacute;</strong></p>\r\n</blockquote>\r\n<h4 id=\"toc-5-keu-goi-hanh-dong-cta\" class=\"ftwp-heading\">5. K&ecirc;u gọi h&agrave;nh động (CTA)</h4>\r\n<p>Sau khi đ&atilde; n&ecirc;u ra đầy đủ những th&ocirc;ng tin ở ph&iacute;a tr&ecirc;n, bạn cần k&ecirc;u gọi h&agrave;nh động cho r&otilde; r&agrave;ng. Bạn muốn kh&aacute;ch h&agrave;ng l&agrave;m g&igrave; th&igrave; h&atilde;y k&ecirc;u gọi r&otilde; r&agrave;ng điều&nbsp;ấy.</p>\r\n<p>Bạn kh&ocirc;ng n&ecirc;n k&ecirc;u gọi một c&aacute;ch chung chung như &ldquo;H&atilde;y li&ecirc;n hệ ch&uacute;ng t&ocirc;i để đặt h&agrave;ng&rdquo;. Thay v&agrave;o đ&oacute;, bạn h&atilde;y n&oacute;i r&otilde; r&agrave;ng:<br>h&atilde;y inbox cho ch&uacute;ng t&ocirc;i để đặt h&agrave;ng ngay<br>h&atilde;y gọi hotline 09332223xxx để đặt h&agrave;ng<br>h&atilde;y gọi comment &ldquo;yes&rdquo; để đặt h&agrave;ng<br>Lời k&ecirc;u gọi c&agrave;ng r&otilde; r&agrave;ng th&igrave; khả năng h&agrave;nh động của kh&aacute;ch h&agrave;ng c&agrave;ng tăng&nbsp;cao.</p>\r\n<h4 id=\"toc-6-footer-signature-chu-ky\" class=\"ftwp-heading\">6. Footer / Signature (Chữ k&yacute;)</h4>\r\n<p>Phần n&agrave;y l&agrave; nơi bạn để m&ocirc; tả ngắn gọn về c&ocirc;ng ty / shop của bạn, gồm m&ocirc; tả ngắn, slogan, hotline, website, địa&nbsp;chỉ.</p>\r\n<p>Phần n&agrave;y n&ecirc;n được d&ugrave;ng chung cho tất cả c&aacute;c b&agrave;i post, cả b&agrave;i quảng c&aacute;o lẫn b&agrave;i cung cấp gi&aacute;&nbsp;trị.</p>\r\n<blockquote>\r\n<p><strong>Xem th&ecirc;m: 9 C&acirc;u Hỏi Để X&acirc;y Dựng&nbsp;<a href=\"https://abcdigi.marketing/blog/ke-hoach-content-social-media/\" target=\"_blank\" rel=\"noopener\">Kế Hoạch Content Cho C&aacute;c K&ecirc;nh Social</a></strong></p>\r\n</blockquote>\r\n<p><strong>T&oacute;m lại bao gồm:</strong><br>1. Ti&ecirc;u đề hấp dẫn<br>2. Phần nội dung quảng c&aacute;o<br>3. Ưu đ&atilde;i đặc biệt<br>4. Ch&iacute;nh s&aacute;ch b&aacute;n h&agrave;ng<br>5. Th&ocirc;ng tin li&ecirc;n hệ<br>6. Chữ&nbsp;k&yacute;</p>\r\n<p><img class=\"size-medium wp-image-59149 aligncenter lazyautosizes lazyloaded\" title=\"H&igrave;nh ảnh 10+ Mẫu Content Hay Về Gi&agrave;y D&eacute;p Thu H&uacute;t Kh&aacute;ch H&agrave;ng 19\" src=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-500x300.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1\" sizes=\"500px\" srcset=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-500x300.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1 500w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-480x288.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1 480w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=102&amp;ssl=1 102w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=204&amp;ssl=1 204w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=307&amp;ssl=1 307w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=409&amp;ssl=1 409w\" alt=\" content-hay-ve-giay-dep-11\" width=\"500\" height=\"300\" loading=\"lazy\" data-src=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-500x300.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1\" data-srcset=\"https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-500x300.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1 500w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11-480x288.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;ssl=1 480w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=102&amp;ssl=1 102w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=204&amp;ssl=1 204w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=307&amp;ssl=1 307w, https://e83rrxtpkpf.exactdn.com/wp-content/uploads/2024/02/content-hay-ve-giay-dep-11.jpg?strip=all&amp;lossy=1&amp;quality=90&amp;webp=85&amp;avif=70&amp;sharp=1&amp;w=409&amp;ssl=1 409w\" data-sizes=\"auto\" data-eio-rwidth=\"500\" data-eio-rheight=\"300\"></p>\r\n<p><em>Bố cục content quảng&nbsp;c&aacute;o</em></p>\r\n<p>B&ecirc;n dưới l&agrave; 3 mẫu content gi&agrave;y d&eacute;p hay, bạn c&oacute; thể tham khảo v&agrave; t&ugrave;y chỉnh sao cho ph&ugrave; hợp với thương hiệu của m&igrave;nh.</p>', 'uploads/posts/1749293694.jpg', '2025-06-07 03:54:54', 'ythanh', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_categories`
--

INSERT INTO `post_categories` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bài Viết Mới', 'bai-viet-moi', 1, '2025-06-07 03:52:51', '2025-06-07 03:52:51'),
(2, 'Bài Viết Mới 2', 'bai-viet-moi-2', 1, '2025-06-07 04:45:05', '2025-06-07 04:45:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `import_price` decimal(15,2) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `has_variants` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int(50) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `import_price`, `name`, `slug`, `brand_id`, `category_id`, `price`, `discount_price`, `description`, `image`, `status`, `has_variants`, `created_at`, `updated_at`, `quantity`, `deleted_at`) VALUES
(69, 100000.00, 'Áo Thể Thao', 'ao-the-thao', 1, 1, 120000.00, NULL, '<p>&aacute;o rất đẹp</p>', 'uploads/products/1755396667_46ae1e959d8fbbb4e735fe4a4fa19c17 - Copy (2).webp', 1, 0, '2025-08-16 19:11:07', '2025-08-17 17:38:07', 1000, NULL),
(70, 100000.00, 'Mũ Vành Tròn', 'Mu-Vanh-Tron', 2, 1, 120000.00, NULL, '<p>rất l&agrave; đẹp&nbsp;</p>', 'uploads/products/1755396922_cn-11134301-7qukw-lkbs96nrezt210@resize_w900_nl.webp', 1, 0, '2025-08-16 19:15:22', '2025-08-17 17:05:46', 1000, NULL),
(71, 100000.00, 'Xe Cày Max Công Xuất', 'xe-cay', 1, 1, 120000.00, NULL, '<p>SI&Ecirc;U MẠNH&nbsp;</p>', 'uploads/products/1755503122_OIP.webp', 1, 0, '2025-08-18 00:45:22', '2025-08-18 00:45:22', 0, NULL),
(72, 100000.00, 'Xe Cày Max Công Xuất', 'xe-cay-rat-manh', 1, 1, 120000.00, NULL, '<p>SI&Ecirc;U MẠNH&nbsp;</p>', 'uploads/products/1755503147_OIP.webp', 1, 0, '2025-08-18 00:45:47', '2025-08-18 00:45:47', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_live_chat_attachments`
--

CREATE TABLE `product_live_chat_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` enum('image','video') NOT NULL,
  `mime` varchar(100) DEFAULT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_live_chat_messages`
--

CREATE TABLE `product_live_chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thread_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender` enum('user','staff') NOT NULL DEFAULT 'user',
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_live_chat_messages`
--

INSERT INTO `product_live_chat_messages` (`id`, `thread_id`, `user_id`, `sender`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'user', 'helo', '2025-08-16 00:05:17', '2025-08-16 00:05:17'),
(2, 1, 2, 'staff', 'ccc', '2025-08-16 00:06:05', '2025-08-16 00:06:05'),
(3, 1, 2, 'staff', 'mom you', '2025-08-16 00:06:13', '2025-08-16 00:06:13'),
(4, 1, 2, 'user', 'what the fuck', '2025-08-16 00:06:40', '2025-08-16 00:06:40'),
(5, 2, 2, 'user', 'mom you', '2025-08-17 17:46:17', '2025-08-17 17:46:17'),
(6, 2, 2, 'staff', 'địt mẹ mày', '2025-08-17 17:46:42', '2025-08-17 17:46:42'),
(7, 2, 2, 'user', 'cc', '2025-08-17 18:43:19', '2025-08-17 18:43:19'),
(8, 2, 2, 'staff', 'yanng y loh', '2025-08-17 18:43:43', '2025-08-17 18:43:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_live_chat_threads`
--

CREATE TABLE `product_live_chat_threads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_token` varchar(64) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_live_chat_threads`
--

INSERT INTO `product_live_chat_threads` (`id`, `product_id`, `user_id`, `session_token`, `status`, `created_at`, `updated_at`) VALUES
(1, 60, NULL, 'YrwBLAXxignqifSeFHxAv8OYKm8WWb7Wg3MeaNF8', 'closed', '2025-08-16 00:05:10', '2025-08-16 00:06:51'),
(2, 70, 2, 'r9eM6JzAkwzEnpyAMhkUhIXJL9xut9TT5boXyzDF', 'open', '2025-08-17 17:46:06', '2025-08-17 17:46:06'),
(3, 69, 2, 'r9eM6JzAkwzEnpyAMhkUhIXJL9xut9TT5boXyzDF', 'open', '2025-08-18 02:25:07', '2025-08-18 02:25:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL COMMENT 'Số sao đánh giá, từ 1 đến 5',
  `comment` text DEFAULT NULL COMMENT 'Nội dung đánh giá',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Chỉ hiển thị khi được duyệt',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_review_media`
--

CREATE TABLE `product_review_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_review_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `type` enum('image','video') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `import_price` decimal(15,2) DEFAULT NULL,
  `discount_price` decimal(15,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `slug`, `product_id`, `price`, `import_price`, `discount_price`, `stock`, `image`, `created_at`, `updated_at`, `quantity`, `deleted_at`) VALUES
(97, NULL, 69, 120000.00, 120000.00, 120000.00, 1500, 'variants/1755396667_68a13a3b35a53.webp', '2025-08-16 19:11:07', '2025-08-17 17:38:07', 1500, NULL),
(98, NULL, 70, 120000.00, 120000.00, 120000.00, 1500, 'variants/1755396922_68a13b3a269b1.webp', '2025-08-16 19:15:22', '2025-08-17 17:05:46', 1500, NULL),
(99, NULL, 70, 120000.00, 120000.00, 120000.00, 1500, 'variants/1755396922_68a13b3a28265.webp', '2025-08-16 19:15:22', '2025-08-17 17:05:46', 1500, NULL),
(100, NULL, 70, 120000.00, 120000.00, 120000.00, 1500, 'variants/1755396922_68a13b3a2943d.webp', '2025-08-16 19:15:22', '2025-08-17 17:05:46', 1500, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Blhbmb0NLKAWYOJ32Akt6m7QeWAitLICRSmt8yuL', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36 Edg/139.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS2h4b2MzY2VyREhNQnBuN1hHejhGZ0I4RVhJUzNrcmJRb3ZnZTZiMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi93YXJlaG91c2UvaW5kZXg/cmV2aWV3PTEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6NDoiY2FydCI7YTowOnt9fQ==', 1755519877);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(255) NOT NULL,
  `instance` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(50) NOT NULL,
  `height_range` varchar(50) DEFAULT NULL,
  `weight_range` varchar(50) DEFAULT NULL,
  `chest_range` varchar(50) DEFAULT NULL,
  `hip_range` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`id`, `size`, `height_range`, `weight_range`, `chest_range`, `hip_range`, `created_at`, `updated_at`) VALUES
(1, '23', '24', '343', '3434', '343', '2025-08-11 03:11:40', '2025-08-11 03:11:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `tax_code` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `ward` varchar(255) DEFAULT NULL,
  `address_detail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_code`, `name`, `phone`, `tax_code`, `fax`, `website`, `email`, `user_id`, `province`, `district`, `ward`, `address_detail`, `created_at`, `updated_at`) VALUES
(1, 'aaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa', '0337937493', '1235466', '124455666', 'https://shopee.vn/user/purchase?type=4', 'ebanythanh1@gmail.com', 1, '249', '1729', '190404', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', '2025-07-14 05:19:12', '2025-07-14 05:19:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `facebook_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `image`) VALUES
(1, '04.Trịnh Văn Bảo_11A2', 'baotrinhvan54@gmail.com', '102223758465099514925', NULL, NULL, '$2y$12$7D0qCZauYcQdYkwsHQ1qZuaFk11riJILbozd/DltFVS4SlgXKFo5q', NULL, '2025-04-05 05:00:31', '2025-04-05 05:00:31', 'admin', NULL, NULL),
(2, 'YTHIP ÊBANeee', 'hungtrinhvan54@gmail.com', NULL, NULL, NULL, '$2y$12$j0cwvD9S2KjuTLuA01vqzeSo2Ry4rHN6OBfR3KeLspla0noCIYxGC', 'AghwyaXCzOMTvmlmvZ0g473Twbf5LwgeGbeIwNXB8XP4ywBmDHuvWtg6YPxY', '2025-04-05 09:37:24', '2025-07-02 06:17:33', 'admin', NULL, NULL),
(3, 'NGUYEN VAN A', 'nguyenvana@gmail.com', NULL, NULL, NULL, '$2y$12$VHLJ6fYK2CHzGJUqPxTDjudIvXWodpslv1Zbj8vUyShae3ZbdjlGG', NULL, '2025-04-13 09:12:21', '2025-04-13 09:12:21', 'user', NULL, NULL),
(4, 'NGUYEN VAN A', 'nguyenvanb@gmail.com', NULL, NULL, NULL, '$2y$12$.NU2qY1s2a8pIQyXouJL6OXWto3PzkFggKrnvn3vy.0DCcmuVBSWG', NULL, '2025-04-13 20:05:14', '2025-04-13 20:05:14', 'user', NULL, NULL),
(6, 'Trịnh Văn Bảo', 'baoviet@baoviet.xyz', NULL, NULL, NULL, '$2y$12$3zOYeekog.goqvEvACwyuOPGa9/G00vZxz6rD.kUxOrsma/GR9x.S', NULL, '2025-04-23 05:07:55', '2025-04-23 05:11:47', 'user', NULL, NULL),
(7, 'YTHANH ÊBAN', 'ebanythanh1@gmail.com', '101017578632024898091', NULL, NULL, '$2y$12$IGuAcbdUP.L1ck5u8x8TV.jMHSQMdbnXjndqRvtjn68o0gPfCNVoy', NULL, '2025-05-24 04:44:35', '2025-08-10 16:33:43', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variant_attribute_values`
--

CREATE TABLE `variant_attribute_values` (
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_value_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `variant_attribute_values`
--

INSERT INTO `variant_attribute_values` (`variant_id`, `attribute_value_id`, `created_at`, `updated_at`) VALUES
(97, 1, '2025-08-16 19:11:07', '2025-08-16 19:11:07'),
(98, 7, '2025-08-16 19:15:22', '2025-08-16 19:15:22'),
(98, 8, '2025-08-16 19:15:22', '2025-08-16 19:15:22'),
(99, 7, '2025-08-16 19:15:22', '2025-08-16 19:15:22'),
(99, 10, '2025-08-16 19:15:22', '2025-08-16 19:15:22'),
(100, 7, '2025-08-16 19:15:22', '2025-08-16 19:15:22'),
(100, 12, '2025-08-16 19:15:22', '2025-08-16 19:15:22');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_values_attribute_id_foreign` (`attribute_id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Chỉ mục cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_chat_session_id_foreign` (`chat_session_id`);

--
-- Chỉ mục cho bảng `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chat_sessions_session_token_unique` (`session_token`),
  ADD KEY `chat_sessions_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`);

--
-- Chỉ mục cho bảng `comparisons`
--
ALTER TABLE `comparisons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comparisons_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD UNIQUE KEY `comparisons_session_id_product_id_unique` (`session_id`,`product_id`),
  ADD KEY `comparisons_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_replied_by_foreign` (`replied_by`),
  ADD KEY `contacts_status_created_at_index` (`status`,`created_at`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupon_user_user_id_coupon_id_unique` (`user_id`,`coupon_id`),
  ADD KEY `coupon_user_coupon_id_foreign` (`coupon_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_imageable_type_imageable_id_index` (`imageable_type`,`imageable_id`);

--
-- Chỉ mục cho bảng `image_search_logs`
--
ALTER TABLE `image_search_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_search_logs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Chỉ mục cho bảng `image_vectors`
--
ALTER TABLE `image_vectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image_vectors_product_id_image_path_unique` (`product_id`,`image_path`);

--
-- Chỉ mục cho bảng `import_warehouse`
--
ALTER TABLE `import_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_warehouse_product_id_index` (`product_id`),
  ADD KEY `import_warehouse_variant_id_index` (`variant_id`);

--
-- Chỉ mục cho bảng `import_warehouse_details`
--
ALTER TABLE `import_warehouse_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_warehouse_details_import_warehouse_id_foreign` (`import_warehouse_id`),
  ADD KEY `import_warehouse_details_product_id_foreign` (`product_id`),
  ADD KEY `import_warehouse_details_variant_id_foreign` (`variant_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `live_chat_sessions`
--
ALTER TABLE `live_chat_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `live_chat_sessions_session_id_unique` (`session_id`),
  ADD KEY `live_chat_sessions_user_id_foreign` (`user_id`),
  ADD KEY `live_chat_sessions_admin_id_foreign` (`admin_id`);

--
-- Chỉ mục cho bảng `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_code_unique` (`order_code`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_index` (`product_id`),
  ADD KEY `order_details_variant_id_index` (`variant_id`);

--
-- Chỉ mục cho bảng `order_warehouses`
--
ALTER TABLE `order_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_warehouses_code_unique` (`code`),
  ADD KEY `order_warehouses_supplier_id_foreign` (`supplier_id`),
  ADD KEY `order_warehouses_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_codes_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_post_category_id_foreign` (`post_category_id`);

--
-- Chỉ mục cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_live_chat_attachments`
--
ALTER TABLE `product_live_chat_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_live_chat_attachments_message_id_index` (`message_id`);

--
-- Chỉ mục cho bảng `product_live_chat_messages`
--
ALTER TABLE `product_live_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_live_chat_messages_thread_id_created_at_index` (`thread_id`,`created_at`);

--
-- Chỉ mục cho bảng `product_live_chat_threads`
--
ALTER TABLE `product_live_chat_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_live_chat_threads_product_id_session_token_index` (`product_id`,`session_token`),
  ADD KEY `product_live_chat_threads_session_token_index` (`session_token`);

--
-- Chỉ mục cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `product_review_media`
--
ALTER TABLE `product_review_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_review_media_product_review_id_foreign` (`product_review_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_supplier_code_unique` (`supplier_code`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  ADD PRIMARY KEY (`variant_id`,`attribute_value_id`),
  ADD KEY `variant_attribute_values_attribute_value_id_foreign` (`attribute_value_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT cho bảng `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `comparisons`
--
ALTER TABLE `comparisons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `coupon_user`
--
ALTER TABLE `coupon_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT cho bảng `image_search_logs`
--
ALTER TABLE `image_search_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `image_vectors`
--
ALTER TABLE `image_vectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `import_warehouse`
--
ALTER TABLE `import_warehouse`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `import_warehouse_details`
--
ALTER TABLE `import_warehouse_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `live_chat_sessions`
--
ALTER TABLE `live_chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `logos`
--
ALTER TABLE `logos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT cho bảng `order_warehouses`
--
ALTER TABLE `order_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `product_live_chat_attachments`
--
ALTER TABLE `product_live_chat_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_live_chat_messages`
--
ALTER TABLE `product_live_chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `product_live_chat_threads`
--
ALTER TABLE `product_live_chat_threads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `product_review_media`
--
ALTER TABLE `product_review_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_chat_session_id_foreign` FOREIGN KEY (`chat_session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chat_sessions`
--
ALTER TABLE `chat_sessions`
  ADD CONSTRAINT `chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `comparisons`
--
ALTER TABLE `comparisons`
  ADD CONSTRAINT `comparisons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comparisons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_replied_by_foreign` FOREIGN KEY (`replied_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `coupon_user`
--
ALTER TABLE `coupon_user`
  ADD CONSTRAINT `coupon_user_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `image_search_logs`
--
ALTER TABLE `image_search_logs`
  ADD CONSTRAINT `image_search_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `import_warehouse`
--
ALTER TABLE `import_warehouse`
  ADD CONSTRAINT `import_warehouse_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `import_warehouse_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `import_warehouse_details`
--
ALTER TABLE `import_warehouse_details`
  ADD CONSTRAINT `import_warehouse_details_import_warehouse_id_foreign` FOREIGN KEY (`import_warehouse_id`) REFERENCES `order_warehouses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `import_warehouse_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `import_warehouse_details_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `live_chat_sessions`
--
ALTER TABLE `live_chat_sessions`
  ADD CONSTRAINT `live_chat_sessions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `live_chat_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_warehouses`
--
ALTER TABLE `order_warehouses`
  ADD CONSTRAINT `order_warehouses_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_warehouses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD CONSTRAINT `otp_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_review_media`
--
ALTER TABLE `product_review_media`
  ADD CONSTRAINT `product_review_media_product_review_id_foreign` FOREIGN KEY (`product_review_id`) REFERENCES `product_reviews` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `variant_attribute_values`
--
ALTER TABLE `variant_attribute_values`
  ADD CONSTRAINT `variant_attribute_values_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attribute_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variant_attribute_values_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
