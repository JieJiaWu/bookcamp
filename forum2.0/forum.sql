-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-06-28 16:52:22
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `forum`
--

-- --------------------------------------------------------

--
-- 資料表結構 `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, '國文'),
(2, '英文'),
(3, '數學'),
(4, '電子'),
(5, '軟體');

-- --------------------------------------------------------

--
-- 資料表結構 `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `client`
--

INSERT INTO `client` (`client_id`, `username`, `email`, `password`, `bio`) VALUES
(1, '林小明123', 'linxiaoming@example.com', '123456', '我是林小明，喜欢旅行和摄影。4456456'),
(2, '陳美玲', 'chenmeiling@example.com', '234567', '大家好，我是陳美玲。喜歡閱讀和寫作。'),
(3, '張大偉', 'zhangdawei@example.com', '345678', '大家好，我是張大偉。喜歡運動和戶外活動。'),
(4, '王小琳', 'wangxiaolin@example.com', '456789', '我叫王小琳，熱愛音樂和唱歌。'),
(5, '李明志', 'limingzhi@example.com', '567890', '大家好，我是李明志，喜歡烹飪和美食。'),
(6, 'user123', 'wujia@example.com', '$2y$10$WqKntkdzkb2VMSHRDr/qDOITE5qPfxtGETxhU4Yso8Zik1Y5dUqaG', '中文'),
(7, 'test123', 'ex@example.com', '$2y$10$RFkxuo6B/8nPReJbKRGuu.sdRX7UkSn5FIIRtbpQrR4L0RGK63Cqu', 'helloworld'),
(8, 'user123456', 'ex@5', '$2y$10$L5U6B0wkHP0kXeGFlKVxverqUrvVsnu.w9VuSqQXt5eaf39Hh2hbK', '5'),
(9, 'root', 'root@example.com', '$2y$10$sUvj64p8NVyddzr9E7rEt.pEh.OCRzNqsBNXHTHkZMZqTwYX0fcPe', '我是管理員');

-- --------------------------------------------------------

--
-- 資料表結構 `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `publish_time` datetime DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0,
  `replies` int(11) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `publish_time`, `views`, `replies`, `user_id`, `category_id`) VALUES
(17, '在什麼樣的花園裡～挖阿挖阿挖', '123', '2023-06-23 19:12:12', 0, 0, 9, 1),
(18, '【錯誤】美國突將中國駐美大使永久驅逐出境？不實標題影片！僅提及新大使上任', '123', '2023-06-23 19:12:42', 0, 0, 9, 3),
(19, '止不住的癢？異位性皮膚炎好不了，體內缺乏「這個」關鍵成分', '123', '2023-06-23 19:12:55', 0, 0, 9, 4),
(20, '123123', '123', '2023-06-23 21:59:19', 0, 0, 9, 4);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- 資料表索引 `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`);

--
-- 資料表索引 `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
