-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2025 lúc 09:11 AM
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
(7, 1, '04.Trịnh Văn Bảo_11A2', '12345678908', 'Hà Huy Tập', 'Đắk Lắk', 'Thành phố Buôn Ma Thuột', 'Phường Tân An', 0, '2025-04-23 04:57:17', '2025-04-23 05:01:30');

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
(6, 'Suất xứ', '2025-04-05 09:24:09', '2025-04-05 09:24:09');

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
(2, 1, 'Xanh', '2025-04-05 09:28:41', '2025-04-05 09:28:41'),
(3, 1, 'Tím', '2025-04-05 09:28:45', '2025-04-05 09:28:45'),
(4, 1, 'Cam', '2025-04-05 09:28:48', '2025-04-05 09:28:48'),
(5, 1, 'Nâu', '2025-04-05 09:28:54', '2025-04-05 09:28:54'),
(6, 1, 'Xanh lá', '2025-04-05 09:28:58', '2025-04-05 09:28:58'),
(7, 1, 'Hồng', '2025-04-05 09:29:06', '2025-04-05 09:29:06'),
(8, 2, '37', '2025-04-05 09:29:23', '2025-04-05 09:29:23'),
(9, 2, '38', '2025-04-05 09:29:27', '2025-04-05 09:29:27'),
(10, 2, '39', '2025-04-05 09:29:30', '2025-04-05 09:29:30'),
(11, 2, '40', '2025-04-05 09:29:33', '2025-04-05 09:29:33'),
(12, 2, '41', '2025-04-05 09:29:36', '2025-04-05 09:29:36'),
(13, 2, '42', '2025-04-05 09:29:40', '2025-04-05 09:29:40'),
(14, 6, 'Việt Nam', '2025-04-05 09:38:34', '2025-04-05 09:38:34'),
(15, 6, 'Hàn', '2025-04-05 09:38:42', '2025-04-05 09:38:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'NIKE', 'nike', 1, '2025-04-05 05:02:54', '2025-04-05 05:02:54'),
(2, 'Adidas', 'adidas', 1, '2025-04-15 22:51:14', '2025-04-15 22:51:14');

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
('laravel_cache_ghn_ward_name_210110_d1598', 's:21:\"Phường Quang Trung\";', 1744939052),
('laravel_cache_ghn_ward_name_400103_d1552', 's:17:\"Phường Tân An\";', 1745495837),
('laravel_cache_ghn_ward_name_400406_d1787', 's:10:\"Xã Ea Puk\";', 1744907039),
('laravel_cache_ghn_ward_name_400507_d2131', 's:12:\"Xã Ia JLơi\";', 1744905505),
('laravel_cache_ghn_ward_name_401302_d1784', 's:10:\"Xã Ea Bar\";', 1745504630),
('laravel_cache_ghn_ward_name_401305_d1784', 's:10:\"Xã Ea Wer\";', 1744904626),
('laravel_cache_ghn_ward_name_401307_d1784', 's:13:\"Xã Tân Hoà\";', 1745504797),
('laravel_cache_ghn_ward_name_401507_d1788', 's:24:\"Phường Thống Nhất\";', 1744906160),
('laravel_cache_ghn_ward_name_450601_d3301', 's:15:\"Xã Bắc Phong\";', 1745504967),
('laravel_cache_ghn_ward_name_450606_d3301', 's:19:\"Xã Phước Kháng\";', 1745505329),
('laravel_cache_ghn_ward_name_61201_d1890', 's:24:\"Thị trấn Pác Miầu\";', 1745496740);

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
(66, 7, 'bot', 'Chào bạn! Mình sẽ gợi ý các mẫu giày phù hợp với mức giá dưới 500 nghìn nhé!', NULL, '2025-04-24 01:38:28', '2025-04-24 01:38:28');

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
(8, NULL, '583e72d2-7928-41f5-aeb7-e368a65841b2', '2025-04-22 23:30:26', '2025-04-22 23:30:26');

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
(8, 'F1SHOES', 'percent', 20.00, 200000.00, '2025-04-04', '2025-04-30', 20, 0, 'coupons/1744362682.png', '- Mã giảm 10% khi mua 1 sản phẩm.\r\n - Mỗi khách hàng được sử dụng tối đa 1 lần.\r\n - Số lượng voucher có hạn', '2025-04-11 02:11:22', '2025-04-15 22:53:18'),
(9, 'F1SHOES01', 'fixed', 200000.00, 2000000.00, '2025-04-04', '2025-04-30', 20, 0, 'coupons/1744365705.png', 'Giảm 200k cho đơn hàng trên 2 triệu', '2025-04-11 03:01:45', '2025-04-11 03:01:45'),
(10, 'F1SHOES02', 'percent', 10.00, 200000.00, '2025-04-04', '2025-04-30', 20, 5, 'coupons/1744430880.webp', 'Giảm giá 10% cho đơn hàng từ 200k', '2025-04-11 21:08:00', '2025-04-13 20:25:56'),
(11, 'F1SHOES03', 'percent', 13.00, 300000.00, '2025-04-04', '2025-04-30', 20, 1, 'coupons/1744430967.webp', 'Giảm giá 13% cho đơn hàng từ 300k', '2025-04-11 21:09:27', '2025-04-23 07:31:00'),
(12, 'F1SHOES04', 'fixed', 300000.00, 1000000.00, '2025-04-04', '2025-04-30', 20, 0, 'coupons/1744431010.webp', 'Giảm 300000 cho đơn hàng từ 1000000', '2025-04-11 21:10:10', '2025-04-11 21:10:10'),
(13, 'F1SHOES05', 'fixed', 500000.00, 3000000.00, '2025-04-04', '2025-04-30', 20, 0, 'coupons/1744431118.webp', 'Giảm giá 500k cho đơn hàng 3 triệu', '2025-04-11 21:11:58', '2025-04-11 21:11:58');

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
(9, 'uploads/products/1743856154_Screenshot (3).png', NULL, '2025-04-05 05:29:14', '2025-04-05 05:29:14', 'App\\Models\\Product', 5),
(10, 'uploads/products/1743856154_Screenshot (4).png', NULL, '2025-04-05 05:29:14', '2025-04-05 05:29:14', 'App\\Models\\Product', 5),
(11, 'uploads/products/1743856154_Screenshot (5).png', NULL, '2025-04-05 05:29:14', '2025-04-05 05:29:14', 'App\\Models\\Product', 5),
(12, 'uploads/products/1743856154_Screenshot (6).png', NULL, '2025-04-05 05:29:14', '2025-04-05 05:29:14', 'App\\Models\\Product', 5),
(13, 'uploads/products/1743856154_Screenshot (7).png', NULL, '2025-04-05 05:29:14', '2025-04-05 05:29:14', 'App\\Models\\Product', 5),
(14, 'uploads/products/1743856185_Screenshot 2024-01-26 000547.png', NULL, '2025-04-05 05:29:45', '2025-04-05 05:29:45', 'App\\Models\\Product', 6),
(15, 'uploads/products/1743856185_Screenshot 2024-01-26 152217.png', NULL, '2025-04-05 05:29:45', '2025-04-05 05:29:45', 'App\\Models\\Product', 6),
(16, 'uploads/products/1743856355_vn-11134207-7ra0g-m6s4md49iwyg3d.webp', NULL, '2025-04-05 05:32:35', '2025-04-05 05:32:35', 'App\\Models\\Product', 7),
(17, 'uploads/products/1743856367_vn-11134207-7ra0g-m835dm5pu5c76d.webp', NULL, '2025-04-05 05:32:47', '2025-04-05 05:32:47', 'App\\Models\\Product', 7),
(25, 'uploads/products/1743861999_vn-11134207-7ra0g-m67porj3a94o9e.webp', NULL, '2025-04-05 07:06:39', '2025-04-05 07:06:39', 'App\\Models\\Product', 8),
(26, 'uploads/products/1743862513_vn-11134207-7ras8-m21tpy39s6am2b.webp', NULL, '2025-04-05 07:15:13', '2025-04-05 07:15:13', 'App\\Models\\Product', 8),
(27, 'uploads/products/1743862732_vn-11134207-7ra0g-m835dm5psqr233.webp', NULL, '2025-04-05 07:18:52', '2025-04-05 07:18:52', 'App\\Models\\Product', 9),
(29, 'uploads/products/1743862732_vn-11134207-7ras8-m21tpy39s6am2b.webp', NULL, '2025-04-05 07:18:52', '2025-04-05 07:18:52', 'App\\Models\\Product', 9),
(30, 'uploads/products/1743862732_vn-11134207-7ras8-m29mtw4agptga3.webp', NULL, '2025-04-05 07:18:52', '2025-04-05 07:18:52', 'App\\Models\\Product', 9),
(31, 'uploads/products/1743863358_vn-11134207-7ra0g-m6s4md49iwyg3d.webp', NULL, '2025-04-05 07:29:18', '2025-04-05 07:29:18', 'App\\Models\\Product', 9),
(32, 'uploads/products/1743863358_vn-11134207-7ra0g-m67porj3a94o9e.webp', NULL, '2025-04-05 07:29:18', '2025-04-05 07:29:18', 'App\\Models\\Product', 9),
(35, 'uploads/products/1744203102_vn-11134207-7ras8-m21tpy39s6am2b.webp', NULL, '2025-04-09 05:51:42', '2025-04-09 05:51:42', 'App\\Models\\Product', 7),
(36, 'uploads/products/1744203102_vn-11134207-7ras8-m29mtw4agptga3.webp', NULL, '2025-04-09 05:51:42', '2025-04-09 05:51:42', 'App\\Models\\Product', 7),
(37, 'uploads/products/1744626609_vn-11134207-7ra0g-m835dm5pu5c76d.webp', NULL, '2025-04-14 03:30:09', '2025-04-14 03:30:09', 'App\\Models\\Product', 10),
(38, 'uploads/products/1744626624_vn-11134207-7ra0g-m67porj3a94o9e.webp', NULL, '2025-04-14 03:30:24', '2025-04-14 03:30:24', 'App\\Models\\Product', 11),
(39, 'uploads/products/1744626641_vn-11134207-7ras8-m21tpy39s6am2b.webp', NULL, '2025-04-14 03:30:41', '2025-04-14 03:30:41', 'App\\Models\\Product', 12),
(40, 'uploads/products/1744626660_vn-11134207-7ra0g-m835dm5pu5c76d.webp', NULL, '2025-04-14 03:31:00', '2025-04-14 03:31:00', 'App\\Models\\Product', 13),
(41, 'uploads/products/1744780118_vn-11134207-7ra0g-m6s4md49iwyg3d.webp', NULL, '2025-04-15 22:08:38', '2025-04-15 22:08:38', 'App\\Models\\Product', 18),
(42, 'uploads/products/1744780118_vn-11134207-7ra0g-m67porj3a94o9e.webp', NULL, '2025-04-15 22:08:38', '2025-04-15 22:08:38', 'App\\Models\\Product', 18),
(43, 'uploads/products/1744780118_vn-11134207-7ras8-m4pghzgv889b96.webp', NULL, '2025-04-15 22:08:38', '2025-04-15 22:08:38', 'App\\Models\\Product', 18),
(44, 'uploads/products/1744780118_vn-11134207-7ras8-m21tpy39s6am2b.webp', NULL, '2025-04-15 22:08:38', '2025-04-15 22:08:38', 'App\\Models\\Product', 18),
(45, 'img3.webp', NULL, '2025-04-15 22:31:48', '2025-04-15 22:31:48', 'App\\Models\\Product', 23),
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
(77, 'uploads/products/img6.webp', NULL, '2025-05-16 00:08:42', '2025-05-16 00:08:42', 'App\\Models\\Product', 36);

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
(39, '2025_04_23_143422_add_shipping_fee_to_orders_table', 18);

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
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Phí vận chuyển',
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `partner_code`, `user_id`, `email`, `name`, `phone`, `address`, `province`, `district`, `ward`, `note`, `subtotal`, `discount`, `shipping_fee`, `total`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(7, 'ORDER-67F90D7BC5874', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', '302 Hà Huy Tập', '269', '2264', '80213', 'Test order code', 500000.00, 0.00, 0, 500000.00, 'cod', 'processing', '2025-04-11 05:39:23', '2025-04-11 09:48:33'),
(10, 'ORDER-67F948861D702', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1785', '400602', 'Đơn 02', 2500000.00, 500000.00, 0, 2000000.00, 'bank_transfer', 'processing', '2025-04-11 09:51:18', '2025-04-11 17:31:04'),
(14, 'ORDER-67F9C248920CA', NULL, 1, 'admin@example.comfa', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1552', '400104', 'VNPAY', 500000.00, 0.00, 0, 500000.00, 'vnpay', 'cancelled', '2025-04-11 18:31:18', '2025-04-14 18:03:39'),
(15, 'ORDER-67F9C2DD391E1', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '3418', '400913', 'adf', 2500000.00, 200000.00, 0, 2300000.00, 'vnpay', 'processing', '2025-04-11 18:33:57', '2025-04-14 05:44:10'),
(17, 'ORDER-67F9CD4936C6A', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1784', '401306', NULL, 500000.00, 0.00, 0, 500000.00, 'cod', 'ordered', '2025-04-11 19:17:45', '2025-04-14 18:32:15'),
(18, 'ORDER-67FA8A00777F0', NULL, NULL, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1786', '400206', NULL, 500000.00, 0.00, 0, 500000.00, 'bank_transfer', 'ordered', '2025-04-12 08:42:56', '2025-04-14 18:32:11'),
(19, 'ORDER-67FA92895F44D', NULL, NULL, 'admin@example.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1788', '401506', NULL, 500000.00, 0.00, 0, 500000.00, 'momo', 'processing', '2025-04-12 09:23:57', '2025-04-12 09:23:57'),
(20, 'ORDER-67FA93DBDD431', NULL, NULL, 'heilpmtu@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1787', '400405', NULL, 23112.00, 0.00, 0, 23112.00, 'momo', 'processing', '2025-04-12 09:25:43', '2025-04-12 09:25:43'),
(21, 'ORDER-67FA94CCA4233', NULL, NULL, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '212', '1900', '530309', '1231', 23112.00, 0.00, 0, 23112.00, 'momo', 'processing', '2025-04-12 09:29:42', '2025-04-12 09:29:42'),
(22, 'ORDER-67FA9589817E4', NULL, NULL, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1785', '400604', NULL, 23112.00, 0.00, 0, 23112.00, 'momo', 'processing', '2025-04-12 09:32:51', '2025-04-12 09:32:51'),
(23, 'ORDER-67FA960171EC2', NULL, NULL, 'admin@example.com', 'baafd', '+84345357248', 'Hà Huy Tập', '210', '1785', '400604', 'test momo faild', 23112.00, 0.00, 0, 23112.00, 'momo', 'processing', '2025-04-12 09:36:07', '2025-04-12 09:36:07'),
(24, 'ORDER-67FC7842403BC', NULL, NULL, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1784', '401301', NULL, 3000000.00, 300000.00, 0, 2700000.00, 'cod', 'ordered', '2025-04-13 19:51:46', '2025-04-14 18:32:02'),
(25, 'ORDER-67FC7CEA29E0E', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1552', '400104', NULL, 500000.00, 50000.00, 0, 450000.00, 'cod', 'ordered', '2025-04-13 20:11:38', '2025-04-14 18:31:58'),
(26, 'ORDER-67FC7D1D295AB', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1786', '400203', NULL, 500000.00, 0.00, 0, 500000.00, 'cod', 'ordered', '2025-04-13 20:12:29', '2025-04-14 18:31:53'),
(27, 'ORDER-67FC7D964DB48', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1784', '401302', NULL, 500000.00, 50000.00, 0, 450000.00, 'cod', 'ordered', '2025-04-13 20:14:30', '2025-04-14 18:31:50'),
(28, 'ORDER-67FC7F142D6DF', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1785', '400603', 'Test mã giảm giá', 500000.00, 50000.00, 0, 450000.00, 'vnpay', 'processing', '2025-04-13 20:21:59', '2025-04-13 20:21:59'),
(29, 'ORDER-67FC7F88671A5', NULL, 4, 'admin@example.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1552', '400104', NULL, 500000.00, 50000.00, 0, 450000.00, 'momo', 'processing', '2025-04-13 20:24:09', '2025-04-13 20:24:09'),
(30, 'ORDER-67FC801217934', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1552', '400104', NULL, 500000.00, 50000.00, 0, 450000.00, 'vnpay', 'processing', '2025-04-13 20:25:56', '2025-04-13 20:25:56'),
(31, 'ORDER-67FC8923DB455', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1785', '400605', NULL, 500000.00, 0.00, 0, 500000.00, 'cod', 'ordered', '2025-04-13 21:03:47', '2025-04-14 02:03:18'),
(32, 'ORDER-67FC8B256E1F5', NULL, 4, 'admin@example.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '245', '1887', '110601', NULL, 23112.00, 0.00, 0, 23112.00, 'cod', 'delivered', '2025-04-13 21:12:21', '2025-04-14 20:34:32'),
(33, 'ORDER-67FC8B7E58630', NULL, 4, 'admin@example.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '269', '2264', '80213', NULL, 23112.00, 0.00, 0, 23112.00, 'cod', 'processing', '2025-04-13 21:13:50', '2025-04-13 21:21:58'),
(34, 'ORDER-67FC8C935E78D', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '210', '1784', '401302', NULL, 500000.00, 0.00, 0, 500000.00, 'vnpay', 'shipping', '2025-04-13 21:19:23', '2025-04-14 20:29:43'),
(35, 'ORDER-67FC8DD67E407', NULL, 4, 'admin@example.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Ea Wer', NULL, 23112.00, 0.00, 0, 23112.00, 'vnpay', 'confirmed', '2025-04-13 21:24:20', '2025-04-14 20:29:38'),
(36, 'ORDER-67FC8E48159C0', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Ea Bar', NULL, 23112.00, 0.00, 0, 23112.00, 'momo', 'returned', '2025-04-13 21:26:40', '2025-04-14 20:02:57'),
(37, 'ORDER-67FC8ED1681B8', NULL, 4, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', '10/3', 'Hồ Chí Minh', 'Quận 8', 'Phường 10', NULL, 23112.00, 0.00, 0, 23112.00, 'momo', 'processing', '2025-04-13 21:28:39', '2025-04-13 21:28:39'),
(38, 'ORDER-67FDB66444C9D', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Hải Phòng', 'Quận Lê Chân', 'Phường An Dương', NULL, 23112.00, 0.00, 0, 23112.00, 'cod', 'delivered', '2025-04-14 18:29:08', '2025-04-14 19:07:22'),
(39, 'ORDER-67FFC58437C59', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Krông Năng', 'Xã Ea Tam', 'Test Syns trang thái', 233731.00, 0.00, 0, 233731.00, 'cod', 'ordered', '2025-04-16 07:58:12', '2025-04-16 07:58:12'),
(40, 'ORDER-67FFC660146B6', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Bến Tre', 'Huyện Bình Đại', 'Xã Định Trung', NULL, 231354.00, 0.00, 0, 231354.00, 'momo', 'processing', '2025-04-16 08:03:11', '2025-04-16 08:03:11'),
(41, 'ORDER-67FFC7CFD0FEB', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Krông Năng', 'Xã Ea Tân', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:07:59', '2025-04-16 08:07:59'),
(42, 'ORDER-67FFC8EB296F1', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Krông Năng', 'Xã Ea Hồ', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:12:43', '2025-04-16 08:12:43'),
(43, 'ORDER-67FFC9F0E9BFA', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Cư Kuin', 'Xã Ea Ktur', 'Test Trạng thái', 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:17:04', '2025-04-16 08:17:04'),
(44, 'ORDER-67FFCBED6B030', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Sóc Trăng', 'Huyện Mỹ Tú', 'Xã Mỹ Thuận', NULL, 462462.00, 0.00, 0, 462462.00, 'cod', 'ordered', '2025-04-16 08:25:33', '2025-04-16 08:25:33'),
(45, 'ORDER-67FFCC7D76AD2', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Bến Tre', 'Huyện Bình Đại', 'Xã Long Định', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:27:59', '2025-04-16 08:27:59'),
(46, 'ORDER-67FFCE6F86796', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Thừa Thiên Huế', 'Thị xã Hương Trà', 'Phường Hương Xuân', NULL, 693693.00, 0.00, 0, 693693.00, 'cod', 'ordered', '2025-04-16 08:36:15', '2025-04-16 08:36:15'),
(47, 'ORDER-67FFCFB8D92B2', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Krông Năng', 'Xã Ea Tân', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:41:46', '2025-04-16 08:41:46'),
(48, 'ORDER-67FFD032217E0', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Ea Wer', NULL, 231354.00, 0.00, 0, 231354.00, 'cod', 'ordered', '2025-04-16 08:43:46', '2025-04-16 08:43:46'),
(49, 'ORDER-67FFD16BB379B', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Thành phố Buôn Ma Thuột', 'Phường Tân An', NULL, 123.00, 0.00, 0, 123.00, 'cod', 'ordered', '2025-04-16 08:48:59', '2025-04-16 08:48:59'),
(50, 'ORDER-67FFD3A101257', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Ea Súp', 'Xã Ia JLơi', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 08:58:25', '2025-04-16 08:58:25'),
(51, 'ORDER-67FFD525C8EC7', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Tiên Du', 'Xã Cảnh Hưng', NULL, 123.00, 0.00, 0, 123.00, 'cod', 'ordered', '2025-04-16 09:04:53', '2025-04-16 09:04:53'),
(52, 'ORDER-67FFD6305B01F', 'GYLLTUVL', 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Thị xã Buôn Hồ', 'Phường Thống Nhất', NULL, 123123.00, 0.00, 0, 123123.00, 'cod', 'confirmed', '2025-04-16 09:09:20', '2025-04-16 09:35:25'),
(53, 'ORDER-67FFD7BADD1D6', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Ea H leo', 'Xã Cư Mốt', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'ordered', '2025-04-16 09:15:54', '2025-04-16 09:15:54'),
(54, 'ORDER-67FFD99FC76B6', 'GYLLTN7U', 1, 'admin@example.comfa', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Krông Năng', 'Xã Ea Puk', NULL, 231231.00, 0.00, 0, 231231.00, 'cod', 'delivered', '2025-04-16 09:23:59', '2025-04-16 17:38:57'),
(55, 'ORDER-680056AC1A432', NULL, 1, 'admin@example.comfa', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', 'Hải Dương', 'Thành phố Hải Dương', 'Phường Quang Trung', NULL, 323112.00, 0.00, 0, 323112.00, 'cod', 'ordered', '2025-04-16 18:17:32', '2025-04-16 18:17:32'),
(56, 'ORDER-68006CC7317C4', NULL, 1, 'hungtrinhvan54@gmail.com', 'Trịnh Văn Bảo', '0345357248', 'Hà Huy Tập', '269', '2264', '80211', NULL, 625612.00, 0.00, 0, 625612.00, 'momo', 'processing', '2025-04-16 19:53:18', '2025-04-23 03:06:31'),
(57, 'ORDER-6808F7F623956', NULL, 1, 'baotrinhvan54@gmail.com', '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Ea Bar', NULL, 1000000.00, 0.00, 0, 1000000.00, 'bank_transfer', 'ordered', '2025-04-23 07:23:50', '2025-04-23 07:23:50'),
(58, 'ORDER-6808F89D81D79', NULL, 1, 'baotrinhvan54@gmail.com', '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Đắk Lắk', 'Huyện Buôn Ðôn', 'Xã Tân Hoà', NULL, 23112.00, 0.00, 0, 23112.00, 'cod', 'ordered', '2025-04-23 07:26:37', '2025-04-23 07:26:37'),
(59, 'ORDER-6808F94701AEC', NULL, 1, 'baotrinhvan54@gmail.com', '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Ninh Thuận', 'Huyện Thuận Bắc', 'Xã Bắc Phong', NULL, 500000.00, 0.00, 0, 500000.00, 'bank_transfer', 'ordered', '2025-04-23 07:29:27', '2025-04-23 07:29:27'),
(60, 'ORDER-6808F9A441F9E', NULL, 1, 'baotrinhvan54@gmail.com', 'Bảo', '0359166437', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Quế Võ', 'Xã Cách Bi', NULL, 1000000.00, 130000.00, 0, 870000.00, 'cod', 'ordered', '2025-04-23 07:31:00', '2025-04-23 07:31:00'),
(61, 'ORDER-6808FA325E55D', NULL, 1, 'baotrinhvan54@gmail.com', '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Ninh Thuận', 'Huyện Thuận Bắc', 'Xã Bắc Phong', NULL, 500000.00, 0.00, 0, 531501.00, 'cod', 'ordered', '2025-04-23 07:33:22', '2025-04-23 07:33:22'),
(62, 'ORDER-6808FAB11EDA7', NULL, 1, 'baotrinhvan54@gmail.com', '04.Trịnh Văn Bảo_11A2', '0359166437', 'Hà Huy Tập', 'Ninh Thuận', 'Huyện Thuận Bắc', 'Xã Phước Kháng', NULL, 500000.00, 0.00, 0, 531501.00, 'bank_transfer', 'ordered', '2025-04-23 07:35:29', '2025-04-23 07:35:29'),
(63, 'ORDER-6808FAE2AC036', NULL, 1, 'baotrinhvan54@gmail.com', 'Bảo', '0359166437', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Quế Võ', 'Xã Chi Lăng', NULL, 500000.00, 0.00, 34000, 534000.00, 'cod', 'cancelled', '2025-04-23 07:36:18', '2025-04-24 01:01:33'),
(66, 'ORDER-6808FE4FC991C', NULL, 1, 'baotrinhvan54@gmail.com', 'Bảo', '0359166437', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Quế Võ', 'Xã Đào Viên', NULL, 23112.00, 0.00, 34000, 57112.00, 'vnpay', 'processing', '2025-04-23 07:51:29', '2025-04-23 07:51:29'),
(67, 'ORDER-6809F7BDCAF53', NULL, 1, 'baotrinhvan54@gmail.com', 'Bảo', '0359166437', 'Hà Huy Tập', 'Bắc Ninh', 'Huyện Quế Võ', 'Xã Phù Lương', NULL, 1000000.00, 0.00, 34000, 1034000.00, 'vnpay', 'cancelled', '2025-04-24 01:35:35', '2025-04-24 01:36:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(5, 7, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-11 05:39:23', '2025-04-11 05:39:23'),
(8, 10, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 5, 500000.00, '2025-04-11 09:51:18', '2025-04-11 09:51:18'),
(13, 14, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-11 18:31:18', '2025-04-11 18:31:18'),
(14, 15, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 5, 500000.00, '2025-04-11 18:33:57', '2025-04-11 18:33:57'),
(16, 17, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-11 19:17:45', '2025-04-11 19:17:45'),
(17, 18, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-12 08:42:56', '2025-04-12 08:42:56'),
(18, 19, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-12 09:23:57', '2025-04-12 09:23:57'),
(19, 20, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-12 09:25:43', '2025-04-12 09:25:43'),
(20, 21, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-12 09:29:42', '2025-04-12 09:29:42'),
(21, 22, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-12 09:32:51', '2025-04-12 09:32:51'),
(22, 23, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-12 09:36:07', '2025-04-12 09:36:07'),
(23, 24, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 6, 500000.00, '2025-04-13 19:51:46', '2025-04-13 19:51:46'),
(24, 25, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:11:38', '2025-04-13 20:11:38'),
(25, 26, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:12:29', '2025-04-13 20:12:29'),
(26, 27, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:14:30', '2025-04-13 20:14:30'),
(27, 28, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:21:59', '2025-04-13 20:21:59'),
(28, 29, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:24:09', '2025-04-13 20:24:09'),
(29, 30, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 20:25:56', '2025-04-13 20:25:56'),
(30, 31, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 21:03:47', '2025-04-13 21:03:47'),
(31, 32, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-13 21:12:21', '2025-04-13 21:12:21'),
(32, 33, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-13 21:13:50', '2025-04-13 21:13:50'),
(33, 34, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-13 21:19:23', '2025-04-13 21:19:23'),
(34, 35, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-13 21:24:20', '2025-04-13 21:24:20'),
(35, 36, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-13 21:26:40', '2025-04-13 21:26:40'),
(36, 37, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-13 21:28:39', '2025-04-13 21:28:39'),
(37, 38, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-14 18:29:08', '2025-04-14 18:29:08'),
(38, 39, 27, 'Nike Air Max', 1, 2500.00, '2025-04-16 07:58:12', '2025-04-16 07:58:12'),
(39, 39, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 07:58:12', '2025-04-16 07:58:12'),
(40, 40, 10, 'admin', 1, 123.00, '2025-04-16 08:03:12', '2025-04-16 08:03:12'),
(41, 40, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:03:12', '2025-04-16 08:03:12'),
(42, 41, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:08:00', '2025-04-16 08:08:00'),
(43, 42, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:12:43', '2025-04-16 08:12:43'),
(44, 43, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:17:05', '2025-04-16 08:17:05'),
(45, 44, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 2, 231231.00, '2025-04-16 08:25:33', '2025-04-16 08:25:33'),
(46, 45, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:27:59', '2025-04-16 08:27:59'),
(47, 46, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 3, 231231.00, '2025-04-16 08:36:15', '2025-04-16 08:36:15'),
(48, 47, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:41:47', '2025-04-16 08:41:47'),
(49, 48, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:43:46', '2025-04-16 08:43:46'),
(50, 48, 10, 'admin', 1, 123.00, '2025-04-16 08:43:46', '2025-04-16 08:43:46'),
(51, 49, 10, 'admin', 1, 123.00, '2025-04-16 08:49:00', '2025-04-16 08:49:00'),
(52, 50, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 08:58:26', '2025-04-16 08:58:26'),
(53, 51, 10, 'admin', 1, 123.00, '2025-04-16 09:04:55', '2025-04-16 09:04:55'),
(54, 52, 11, '1231231', 1, 123123.00, '2025-04-16 09:09:22', '2025-04-16 09:09:22'),
(55, 53, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 09:15:55', '2025-04-16 09:15:55'),
(56, 54, 9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 231231.00, '2025-04-16 09:24:01', '2025-04-16 09:24:01'),
(57, 55, 13, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 300000.00, '2025-04-16 18:17:34', '2025-04-16 18:17:34'),
(58, 55, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-16 18:17:34', '2025-04-16 18:17:34'),
(59, 56, 13, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 2, 300000.00, '2025-04-16 19:53:25', '2025-04-16 19:53:25'),
(60, 56, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-16 19:53:25', '2025-04-16 19:53:25'),
(61, 56, 27, 'Nike Air Max', 1, 2500.00, '2025-04-16 19:53:25', '2025-04-16 19:53:25'),
(62, 57, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 2, 500000.00, '2025-04-23 07:23:50', '2025-04-23 07:23:50'),
(63, 58, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-23 07:26:37', '2025-04-23 07:26:37'),
(64, 59, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-23 07:29:27', '2025-04-23 07:29:27'),
(65, 60, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 2, 500000.00, '2025-04-23 07:31:00', '2025-04-23 07:31:00'),
(66, 61, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-23 07:33:22', '2025-04-23 07:33:22'),
(67, 62, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-23 07:35:29', '2025-04-23 07:35:29'),
(68, 63, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 1, 500000.00, '2025-04-23 07:36:18', '2025-04-23 07:36:18'),
(71, 66, 8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 1, 23112.00, '2025-04-23 07:51:29', '2025-04-23 07:51:29'),
(72, 67, 7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 2, 500000.00, '2025-04-24 01:35:35', '2025-04-24 01:35:35');

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
('hungtrinhvan54@gmail.com', '$2y$12$7SnlPfhl5ttioTYttYR7x.rPnp6Pwud9W8OWkCyVn1jCUwFXThRee', '2025-04-13 08:54:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `brand_id`, `category_id`, `price`, `discount_price`, `description`, `image`, `status`, `has_variants`, `created_at`, `updated_at`) VALUES
(7, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', 'giaydep', 1, 1, 500000.00, NULL, 'Chào mừng bạn đến với Trung tâm mua sắm chính thức của SOCCER BECK, chúng tôi cam kết mang đến cho khách hàng những sản phẩm tốt và dịch vụ chất lượng cao.\r\n\r\nHãy mua sản phẩm của chúng tôi từ Shopee mà không cần lo lắng vì chúng tôi đảm bảo là hàng đáp ứng đủ chất lượng nhu cầu của người dùng\r\n\r\nThỏa sức mua sắm của bạn trong cửa hàng của chúng tôi và có một ngày tốt lành.                                 \r\n\r\n                \r\n\r\n- Chế Độ Hậu Mãi:\r\n\r\n+ 1 Đổi 1 (Nếu Đá Bóng Trận Tiên Bị Bung Keo, Đế)\r\n\r\n+ Trả Hàng (Thoải Mái)\r\n\r\n+ Đổi Hàng (Thoải Mái)\r\n\r\n+ Bảo Hành Keo Đế (Xuyên Suốt Thời Gian Sử Dụng)                                  \r\n\r\n\r\n\r\nCÁC KHÁCH HÀNG CẦN NẮM RÕ QUYỀN LỢI CỦA MÌNH, NẾU THIẾU CÁC PHẦN QUÀ QUÝ KHÁCH VUI LÒNG IB CHO KÊNH SHOPEE CỦA SHOP ĐỂ BÊN MÌNH KHÁCH PHỤC NGAY LẬP TỨC\r\n\r\n------------------------------------------------\r\n\r\nLưu ý: - Do màn hình và điều kiện ánh sáng khác nhau, màu sắc thực tế của sản phẩm có thể chênh lệch khoảng 3-5% so với màu thật của sản phẩm, khách iu vui lòng thông cảm giúp SOCCER BECK nha! - Bảng Size mang tính chất tham khảo, có thể chênh lệch so với thực tế, quý khách vui lòng chat cho shop để được tư vấn kỹ hơn. SOCCER BECK xin cảm ơn.\r\n\r\n\r\n\r\n- Bảng Size mang tính chất tham khảo, có thể chênh lệch so với thực tế, quý khách vui lòng chat cho shop để được tư vấn kỹ hơn. SOCCER BECK xin cảm ơn.\r\n\r\n------------------------------------------------\r\n\r\nLưu ý: Khi quý khách có gặp bất cứ vấn đề phát sinh về sản phẩm hay quá trình vận chuyển thì đừng vội đánh giá mà hãy liên hệ Kênh Shopee của Shop để được hỗ trợ tốt nhất. Nếu hài lòng về sản phẩm thì bạn tặng shop đánh giá 5* nhé. SOCCER BECK xin cảm ơn.', 'uploads/products/1743863060_vn-11134207-7ra0g-m67porj3a94o9e.webp', 1, 0, '2025-04-05 05:32:35', '2025-04-05 07:24:20'),
(8, 'Giày Bóng Đá Mer Vapor 16 Academy Loại Đẹp Upper Vải Dệt Nhẹ Mềm Êm Đinh TF Cỏ Nhân Tạo', 'fđâ', 1, 1, 23112.00, NULL, '313123', 'uploads/products/1743863728_vn-11134207-7ras8-m4pghzgv889b96.webp', 1, 0, '2025-04-05 05:41:51', '2025-04-05 07:35:28'),
(9, 'Giày Bóng Đá Mơ Cua Ri Ồ Vapor 16 ELít Cổ Lửng SOCCER BECK, Đế Đinh TF, Bám Sân, Các Màu Sắc, Sân Cỏ Nhân Tạo', '1231231', 1, 1, 231231.00, NULL, '23123123', 'uploads/products/1743863358_vn-11134207-7ra0g-m67porj3a94o9e.webp', 1, 0, '2025-04-05 07:18:52', '2025-04-05 07:29:18'),
(10, 'admin', '123213', 1, 1, 123.00, NULL, '123', 'uploads/products/1744626609_vn-11134207-7ra0g-m835dm5psqr233.webp', 1, 0, '2025-04-14 03:30:09', '2025-04-14 03:30:09'),
(11, '1231231', '12313213123', 1, 1, 123123.00, NULL, '13213', 'uploads/products/1744626624_vn-11134207-7ra0g-m6s4md49iwyg3d.webp', 1, 0, '2025-04-14 03:30:24', '2025-04-14 03:30:24'),
(12, '1231231231', '123123', 1, 1, 13213.00, NULL, '123132', 'uploads/products/1744626641_vn-11134207-7ras8-m4d0036fkf7r12.webp', 1, 0, '2025-04-14 03:30:41', '2025-04-14 03:30:41'),
(13, 'admin', '123', 1, 1, 12312.00, NULL, '3123', 'uploads/products/1744626660_vn-11134207-7ra0g-m835dm5psqr233.webp', 1, 0, '2025-04-14 03:31:00', '2025-04-14 03:31:00'),
(18, 'Nike Air Max', 'nike-air-max', 1, 1, 2500000.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/1744780118_vn-11134207-7ra0g-m6s4md49iwyg3d.webp', 1, 0, '2025-04-15 22:08:08', '2025-04-16 01:39:26'),
(25, 'Nike Air Max', 'nike-air-max-1', 1, 1, 2500.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/1744781853_vn-11134207-7ras8-m4d0036fkf7r12.webp', 1, 0, '2025-04-15 22:36:12', '2025-04-15 22:37:33'),
(26, 'Adidas Ultraboost', 'adidas-ultraboost', 1, 2, 2800.00, NULL, 'Êm ái, năng động', 'uploads/products/img2.webp', 1, 0, '2025-04-15 22:36:12', '2025-04-15 22:36:12'),
(27, 'Nike Air Max', 'nike-air-max-2', 2, 1, 2500.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/img1.webp', 1, 0, '2025-04-15 22:51:40', '2025-04-16 01:05:16'),
(29, 'Nike Air Max', 'nike-air-max-3', 1, 2, 2500.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/img1.webp', 1, 0, '2025-04-16 19:01:37', '2025-04-16 19:01:37'),
(30, 'Adidas Ultraboost', 'adidas-ultraboost-1', 1, 2, 2800.00, NULL, 'Êm ái, năng động', 'uploads/products/img2.webp', 1, 0, '2025-04-16 19:01:37', '2025-04-16 19:01:37'),
(31, 'Nike Air Max', 'nike-air-max-4', 1, 2, 2500.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/img1.webp', 1, 0, '2025-04-16 19:49:42', '2025-04-16 19:49:42'),
(32, 'Adidas Ultraboost', 'adidas-ultraboost-2', 1, 2, 2800.00, NULL, 'Êm ái, năng động', 'uploads/products/img2.webp', 1, 0, '2025-04-16 19:49:43', '2025-04-16 19:49:43'),
(35, 'Nike Air Max', 'nike-air-max-5', 1, 2, 2500.00, NULL, 'Giày chạy bộ thể thao', 'uploads/products/img1.webp', 1, 0, '2025-05-16 00:08:42', '2025-05-16 00:08:42'),
(36, 'Adidas Ultraboost', 'adidas-ultraboost-3', 1, 2, 2800.00, NULL, 'Êm ái, năng động', 'uploads/products/img2.webp', 1, 0, '2025-05-16 00:08:42', '2025-05-16 00:08:42');

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

--
-- Đang đổ dữ liệu cho bảng `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(16, 7, 1, 3, 'Rất đẹp', 1, '2025-04-23 01:11:45', '2025-04-23 01:57:14'),
(17, 10, 1, 1, 'Xấu', 1, '2025-04-23 02:31:06', '2025-04-23 02:31:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(10, 7, 3121.00, 213123, 'variants/1744031265.webp', '2025-04-07 06:07:45', '2025-04-07 06:07:45'),
(11, 7, 650000.00, 200, 'variants/1744191346.webp', '2025-04-09 02:35:46', '2025-04-09 02:35:46'),
(12, 7, 650000.00, 500, 'variants/1744191675.webp', '2025-04-09 02:41:15', '2025-04-09 02:41:15'),
(13, 8, 300000.00, 10, 'variants/1744622315.webp', '2025-04-14 02:18:35', '2025-04-14 02:18:35');

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
('66VkoJaCeHTQhsDu1wEO0vGya5IPubr9HfhBnirm', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRzJuQ1ozUGhEZXJkWWx5ZllpendCTmlhMlBLZm1jSnBRbnhNYTVPOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGF0aXN0aWNzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJzdGF0ZSI7czo0MDoiS1VmaGw5RnBuTDFZQ2lCV1JJMEdkUzU3TzU0MFZpbDN1bEphZ25vMiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1747379462);

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
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `facebook_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, '04.Trịnh Văn Bảo_11A2', 'baotrinhvan54@gmail.com', '102223758465099514925', NULL, NULL, '$2y$12$7D0qCZauYcQdYkwsHQ1qZuaFk11riJILbozd/DltFVS4SlgXKFo5q', NULL, '2025-04-05 05:00:31', '2025-04-05 05:00:31', 'admin'),
(2, 'Trịnh Văn Bảo', 'hungtrinhvan54@gmail.com', NULL, NULL, NULL, '$2y$12$hcsryGuUKHakKMkGts1u0OAVxmeqAaHsRwXBe6/U1ZjVUap99Icze', 'PWmYkHE4bvZAe5aIsOlsJCQB4pei7uYhha8rppsmaOEUIsWvcJ6SYvlcH9B0', '2025-04-05 09:37:24', '2025-04-23 05:05:31', 'admin'),
(3, 'NGUYEN VAN A', 'nguyenvana@gmail.com', NULL, NULL, NULL, '$2y$12$VHLJ6fYK2CHzGJUqPxTDjudIvXWodpslv1Zbj8vUyShae3ZbdjlGG', NULL, '2025-04-13 09:12:21', '2025-04-13 09:12:21', 'user'),
(4, 'NGUYEN VAN A', 'nguyenvanb@gmail.com', NULL, NULL, NULL, '$2y$12$.NU2qY1s2a8pIQyXouJL6OXWto3PzkFggKrnvn3vy.0DCcmuVBSWG', NULL, '2025-04-13 20:05:14', '2025-04-13 20:05:14', 'user'),
(6, 'Trịnh Văn Bảo', 'baoviet@baoviet.xyz', NULL, NULL, NULL, '$2y$12$3zOYeekog.goqvEvACwyuOPGa9/G00vZxz6rD.kUxOrsma/GR9x.S', NULL, '2025-04-23 05:07:55', '2025-04-23 05:11:47', 'user');

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
(10, 1, '2025-04-07 06:07:45', '2025-04-07 06:07:45'),
(10, 8, '2025-04-07 06:07:45', '2025-04-07 06:07:45'),
(10, 14, '2025-04-07 06:07:45', '2025-04-07 06:07:45'),
(11, 3, '2025-04-09 02:35:46', '2025-04-09 02:35:46'),
(11, 9, '2025-04-09 02:35:46', '2025-04-09 02:35:46'),
(11, 15, '2025-04-09 02:35:46', '2025-04-09 02:35:46'),
(12, 2, '2025-04-09 02:41:15', '2025-04-09 02:41:15'),
(12, 13, '2025-04-09 02:41:15', '2025-04-09 02:41:15'),
(12, 14, '2025-04-09 02:41:15', '2025-04-09 02:41:15'),
(13, 1, '2025-04-14 02:18:35', '2025-04-14 02:18:35'),
(13, 9, '2025-04-14 02:18:35', '2025-04-14 02:18:35'),
(13, 14, '2025-04-14 02:18:35', '2025-04-14 02:18:35');

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
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_imageable_type_imageable_id_index` (`imageable_type`,`imageable_id`);

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
  ADD KEY `order_details_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_name_unique` (`name`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT cho bảng `chat_sessions`
--
ALTER TABLE `chat_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

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
