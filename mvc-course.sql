-- phpMyAdmin SQL Dump
-- version 5.1.4deb1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 08 2023 г., 19:53
-- Версия сервера: 8.0.32-0ubuntu0.22.10.2
-- Версия PHP: 8.1.7-1ubuntu3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc-course`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`phpadmin`@`localhost` PROCEDURE `get_arrivals` ()  BEGIN
	CREATE TEMPORARY TABLE tmp_arrivals
	SELECT
        `products`.`id`,
        IFNULL
        (
            (
            SELECT
                    SUM(`arrival_products`.`count`)
                FROM `products`
                WHERE `arrival_products`.`product_id` = `products`.`id`
            ), 0
        ) AS arrivals_count
	FROM `products`
	LEFT JOIN `arrival_products` ON `products`.`id` = `arrival_products`.`product_id`
	GROUP BY `products`.`id`;
END$$

CREATE DEFINER=`phpadmin`@`localhost` PROCEDURE `get_products_in_basket` (IN `id_user` INT)  BEGIN
	CREATE TEMPORARY TABLE tmp_in_user_basket
  	SELECT 
		`products`.`id` AS product_id,
		IF(
              (
                   SELECT COUNT(`id`) FROM `basket` WHERE `basket`.`user_id` = id_user AND `basket`.`product_id` = `products`.`id`) != 0,
                   '1',
                   '0'
              ) AS in_basket
	FROM `products`
	LEFT JOIN `basket` ON `products`.`id` = `basket`.`product_id`
	GROUP BY `products`.`id`;
END$$

CREATE DEFINER=`phpadmin`@`localhost` PROCEDURE `get_purchases` ()  BEGIN
	CREATE TEMPORARY TABLE tmp_purchases
  	SELECT
        `products`.`id`,
        IFNULL
        (
            (
            SELECT
                    SUM(`purchase_products`.`product_count`)
                FROM `products`
                WHERE `purchase_products`.`product_id` = `products`.`id`
            ), 0
        ) AS purchases_count
	FROM `products`
	LEFT JOIN `purchase_products` ON `products`.`id` = `purchase_products`.`product_id`
	GROUP BY `products`.`id`;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `arrival`
--

CREATE TABLE `arrival` (
  `id` int UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `arrival`
--

INSERT INTO `arrival` (`id`, `date`) VALUES
(3, '2023-03-07 20:43:51'),
(4, '2023-03-07 20:45:22'),
(5, '2023-03-08 07:36:00');

-- --------------------------------------------------------

--
-- Структура таблицы `arrival_products`
--

CREATE TABLE `arrival_products` (
  `id` int UNSIGNED NOT NULL,
  `arrival_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `count` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `arrival_products`
--

INSERT INTO `arrival_products` (`id`, `arrival_id`, `product_id`, `count`) VALUES
(1, 1, 1, 10),
(2, 2, 1, 7),
(3, 2, 2, 3),
(6, 3, 1, 4),
(7, 3, 3, 2),
(8, 4, 1, 6),
(9, 5, 1, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `count` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`id`, `user_id`, `product_id`, `count`) VALUES
(20, 5, 1, 1),
(19, 5, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cost` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `cost`) VALUES
(1, 'test_product_updated', 'test_description_updated', 4995),
(2, 'Тестовый_2', 'йцуйцуйцу', 1000),
(3, 'Тестовый_3', 'тест', 123),
(4, 'Тестовый_3', 'тест', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `purchase`
--

CREATE TABLE `purchase` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `total_price` int UNSIGNED NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `purchase`
--

INSERT INTO `purchase` (`id`, `user_id`, `total_price`, `surname`, `name`, `patronymic`, `address`, `email`) VALUES
(11, 6, 99900, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe@asd'),
(10, 6, 99900, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe@asd'),
(12, 6, 94905, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe@asd');

-- --------------------------------------------------------

--
-- Структура таблицы `purchase_products`
--

CREATE TABLE `purchase_products` (
  `id` int UNSIGNED NOT NULL,
  `purchase_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `product_count` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `purchase_products`
--

INSERT INTO `purchase_products` (`id`, `purchase_id`, `product_id`, `product_count`) VALUES
(4, 2, 1, 2),
(3, 1, 1, 5),
(5, 10, 1, 20),
(6, 11, 1, 1),
(7, 12, 1, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `login`, `password`, `is_admin`) VALUES
(1, 'Тестовый', 'test_123', '$2y$10$v3nYEwYJ0Fpq9KSu.E1f7OAaUCReTYOjVEyfDuah0TOqrTxPRlL5m', 1),
(5, 'user_updated', 'user_updated', '$2y$10$FYlKky8F2L2ZyeiWaohRP.8yIIjVw/2dNdv00BqaBskhEncYViJ.C', 0),
(6, 'user', 'user', '$2y$10$ZvGVXkT/ib2o9dbzZNlcpuc8LT1OCbYmSNz30/xdSbB/wERyfasma', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `arrival`
--
ALTER TABLE `arrival`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `arrival_products`
--
ALTER TABLE `arrival_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_arrival_products` (`product_id`);

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_basket_products` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_purchase_products` (`product_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `arrival`
--
ALTER TABLE `arrival`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `arrival_products`
--
ALTER TABLE `arrival_products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `purchase_products`
--
ALTER TABLE `purchase_products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
