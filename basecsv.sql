-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 09 2018 г., 21:38
-- Версия сервера: 5.7.21-0ubuntu0.16.04.1
-- Версия PHP: 5.6.32-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `basecsv`
--

-- --------------------------------------------------------

--
-- Структура таблицы `area`
--

CREATE TABLE `area` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `area`
--

INSERT INTO `area` (`id`, `name`) VALUES
(2, 'Гибка'),
(6, 'Корпусная сборка'),
(4, 'Малярка'),
(1, 'Пробивка'),
(3, 'Сварка'),
(5, 'Шкафная сборка');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1498403673);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1498402643, 1498402643);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название категории',
  `parent_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Родительская категория',
  `has_childs` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `has_childs`) VALUES
(0, 'root', NULL, 1),
(1, 'solid', 0, 1),
(2, 'jetcam', 0, 1),
(3, 'CSV', 1, 1),
(4, 'Сторонние заказы', 1, 1),
(5, 'Напольные шкафы CSV', 3, 1),
(6, 'Напольные шкафы', 4, NULL),
(7, 'Настенные шкафы CSV', 3, 1),
(8, 'Rackmount', 5, NULL),
(9, 'Lite', 5, NULL),
(10, 'Wallmount', 7, NULL),
(14, 'shkafy_napolny', 2, 1),
(15, 'rm', 14, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `color`
--

CREATE TABLE `color` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Краска'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `color`
--

INSERT INTO `color` (`id`, `name`) VALUES
(1, 'Серая шагрень'),
(3, 'Серый бархат'),
(2, 'Черная шагрень');

-- --------------------------------------------------------

--
-- Структура таблицы `entity`
--

CREATE TABLE `entity` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `type` enum('part','assembly','product') NOT NULL COMMENT 'Тип',
  `sku` varchar(255) DEFAULT NULL COMMENT 'Артикул',
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Категория'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `entity`
--

INSERT INTO `entity` (`id`, `name`, `type`, `sku`, `category_id`) VALUES
(5, 'StrRack42U', 'part', '', 6),
(6, 'Test', 'part', '', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `entity_has_color`
--

CREATE TABLE `entity_has_color` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `color_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `entity_has_entity`
--

CREATE TABLE `entity_has_entity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL,
  `child_id` int(10) UNSIGNED NOT NULL,
  `count` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Количество'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `entity_has_operation`
--

CREATE TABLE `entity_has_operation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `operation_id` mediumint(8) UNSIGNED NOT NULL,
  `comment` text,
  `order` tinyint(3) UNSIGNED ZEROFILL NOT NULL DEFAULT '000',
  `value` decimal(6,2) DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `entity_in_work`
--

CREATE TABLE `entity_in_work` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `status` enum('inwork','ready','done') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `entity_in_work_aggregate`
--

CREATE TABLE `entity_in_work_aggregate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entity_in_work_id` bigint(20) UNSIGNED NOT NULL,
  `entity_has_operation_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('current','done','break') NOT NULL COMMENT 'Статус',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `geo`
--

CREATE TABLE `geo` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `count` tinyint(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Количество',
  `x` decimal(6,2) DEFAULT NULL COMMENT 'Длина',
  `y` decimal(6,2) DEFAULT NULL COMMENT 'Ширина',
  `s` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'Толщина',
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `geo`
--

INSERT INTO `geo` (`id`, `entity_id`, `name`, `count`, `x`, `y`, `s`, `category_id`) VALUES
(1, 5, 'strRack42U-10', 1, '1300.54', '300.48', 1, 2),
(2, 6, 'test3-10', 2, '200.00', '100.00', 1, 2),
(3, 6, 'test2-10', 1, '300.00', '100.00', 1, 2),
(4, NULL, 'Cms-15u-Re-15', 1, '691.00', '116.40', 10, 2),
(5, NULL, 'Cms-12u-Re-15', 1, '558.00', '116.40', 10, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1497978172),
('m140506_102106_rbac_init', 1497978298),
('m170624_083808_create_admin', 1498403673);

-- --------------------------------------------------------

--
-- Структура таблицы `nesting`
--

CREATE TABLE `nesting` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `x` smallint(4) UNSIGNED NOT NULL COMMENT 'Длина',
  `y` smallint(4) UNSIGNED NOT NULL COMMENT 'Ширина',
  `s` tinyint(3) UNSIGNED NOT NULL COMMENT 'Толщина',
  `material` varchar(255) NOT NULL DEFAULT 'Х/К' COMMENT 'Материал',
  `time` time DEFAULT NULL COMMENT 'Время',
  `tools` text COMMENT 'Инструмент',
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nesting`
--

INSERT INTO `nesting` (`id`, `name`, `x`, `y`, `s`, `material`, `time`, `tools`, `category_id`) VALUES
(1, 'Nest1', 2000, 1000, 15, 'Х/К', '00:01:00', 'Round 9.0\r\nSquare 9x9', 2),
(3, 'Test5', 2500, 1250, 10, 'Х/К', '00:04:00', '', 14),
(4, 'Cms-15u-Re-15', 2000, 1000, 10, 'Х/К', '00:23:48', ' No. 78:RADIUS 5mm TOOL                  0.00       0.3        1 W\r\n No. 80:Klaster9.2-3                     INDEX (0)  0.3        2 W\r\n OBROUND    : 35.0 x 6.5                 INDEX (0)  0.3        3 W\r\n OBROUND    : 56.0 x 5.0                 INDEX (0)  0.3        4 W\r\n OBROUND    : 57.0 x 20.0                INDEX (0)  0.3        5 W\r\n', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `nesting_has_geo`
--

CREATE TABLE `nesting_has_geo` (
  `id` int(10) UNSIGNED NOT NULL,
  `nesting_id` int(10) UNSIGNED NOT NULL,
  `geo_id` int(10) UNSIGNED NOT NULL,
  `count` smallint(5) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `nesting_has_geo`
--

INSERT INTO `nesting_has_geo` (`id`, `nesting_id`, `geo_id`, `count`) VALUES
(1, 1, 1, 2),
(5, 1, 3, 16),
(7, 3, 2, 3),
(8, 3, 1, 1),
(9, 4, 4, 20),
(10, 4, 5, 2),
(11, 4, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `nesting_in_work`
--

CREATE TABLE `nesting_in_work` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nesting_id` int(10) UNSIGNED NOT NULL COMMENT 'Раскладка',
  `is_done` tinyint(1) DEFAULT NULL COMMENT 'Готово',
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Порядок',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `operation`
--

CREATE TABLE `operation` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `unit` varchar(255) DEFAULT NULL COMMENT 'Ед. измерения'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `operation`
--

INSERT INTO `operation` (`id`, `name`, `unit`) VALUES
(1, 'Сварка', 'Точки');

-- --------------------------------------------------------

--
-- Структура таблицы `operation_has_area`
--

CREATE TABLE `operation_has_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `operation_id` mediumint(8) UNSIGNED NOT NULL,
  `area_id` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `operation_has_area`
--

INSERT INTO `operation_has_area` (`id`, `operation_id`, `area_id`) VALUES
(17, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL COMMENT 'Имя',
  `login` varchar(64) NOT NULL COMMENT 'Логин',
  `password` varchar(255) NOT NULL COMMENT 'Пароль',
  `email` varchar(255) DEFAULT NULL COMMENT 'E-mail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `login`, `password`, `email`) VALUES
(1, 'admin', 'admin', '$2y$13$fEZHSPfFWBs4T4CeW4cM.ORcwnTF4Z4ocSrBE2.JBD2Y8wh5jaIYi', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Индексы таблицы `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Индексы таблицы `entity`
--
ALTER TABLE `entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_category1_idx` (`category_id`);

--
-- Индексы таблицы `entity_has_color`
--
ALTER TABLE `entity_has_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_has_color_color1_idx` (`color_id`),
  ADD KEY `fk_entity_has_color_entity1_idx` (`entity_id`);

--
-- Индексы таблицы `entity_has_entity`
--
ALTER TABLE `entity_has_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_has_entity_entity1_idx` (`parent_id`),
  ADD KEY `fk_entity_has_entity_entity2_idx` (`child_id`);

--
-- Индексы таблицы `entity_has_operation`
--
ALTER TABLE `entity_has_operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_has_operation_operation1_idx` (`operation_id`),
  ADD KEY `fk_entity_has_operation_entity1_idx` (`entity_id`);

--
-- Индексы таблицы `entity_in_work`
--
ALTER TABLE `entity_in_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_in_work_entity1_idx` (`entity_id`);

--
-- Индексы таблицы `entity_in_work_aggregate`
--
ALTER TABLE `entity_in_work_aggregate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entity_in_work_aggregate_entity_in_work1_idx` (`entity_in_work_id`),
  ADD KEY `fk_entity_in_work_aggregate_entity_has_operation1_idx` (`entity_has_operation_id`),
  ADD KEY `fk_entity_in_work_aggregate_user1_idx` (`user_id`);

--
-- Индексы таблицы `geo`
--
ALTER TABLE `geo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `fk_geo_entity1_idx` (`entity_id`),
  ADD KEY `fk_geo_category1_idx` (`category_id`) USING BTREE;

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `nesting`
--
ALTER TABLE `nesting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nesting_category1_idx` (`category_id`);

--
-- Индексы таблицы `nesting_has_geo`
--
ALTER TABLE `nesting_has_geo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nesting_has_geo_geo1_idx` (`geo_id`),
  ADD KEY `fk_nesting_has_geo_nesting1_idx` (`nesting_id`);

--
-- Индексы таблицы `nesting_in_work`
--
ALTER TABLE `nesting_in_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nesting_in_work_nesting1_idx` (`nesting_id`),
  ADD KEY `fk_nesting_in_work_user1_idx` (`user_id`);

--
-- Индексы таблицы `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `operation_has_area`
--
ALTER TABLE `operation_has_area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_operation_has_area_area1_idx` (`area_id`),
  ADD KEY `fk_operation_has_area_operation1_idx` (`operation_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `color`
--
ALTER TABLE `color`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `entity`
--
ALTER TABLE `entity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `entity_has_color`
--
ALTER TABLE `entity_has_color`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `entity_has_entity`
--
ALTER TABLE `entity_has_entity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `entity_has_operation`
--
ALTER TABLE `entity_has_operation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `entity_in_work`
--
ALTER TABLE `entity_in_work`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `entity_in_work_aggregate`
--
ALTER TABLE `entity_in_work_aggregate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `geo`
--
ALTER TABLE `geo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `nesting`
--
ALTER TABLE `nesting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `nesting_has_geo`
--
ALTER TABLE `nesting_has_geo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `nesting_in_work`
--
ALTER TABLE `nesting_in_work`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `operation`
--
ALTER TABLE `operation`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `operation_has_area`
--
ALTER TABLE `operation_has_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `entity`
--
ALTER TABLE `entity`
  ADD CONSTRAINT `fk_entity_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `entity_has_color`
--
ALTER TABLE `entity_has_color`
  ADD CONSTRAINT `fk_entity_has_color_color1` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entity_has_color_entity1` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `entity_has_entity`
--
ALTER TABLE `entity_has_entity`
  ADD CONSTRAINT `fk_entity_has_entity_entity1` FOREIGN KEY (`parent_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entity_has_entity_entity2` FOREIGN KEY (`child_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `entity_has_operation`
--
ALTER TABLE `entity_has_operation`
  ADD CONSTRAINT `fk_entity_has_operation_entity1` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entity_has_operation_operation1` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `entity_in_work`
--
ALTER TABLE `entity_in_work`
  ADD CONSTRAINT `fk_entity_in_work_entity1` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `entity_in_work_aggregate`
--
ALTER TABLE `entity_in_work_aggregate`
  ADD CONSTRAINT `fk_entity_in_work_aggregate_entity_has_operation1` FOREIGN KEY (`entity_has_operation_id`) REFERENCES `entity_has_operation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entity_in_work_aggregate_entity_in_work1` FOREIGN KEY (`entity_in_work_id`) REFERENCES `entity_in_work` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entity_in_work_aggregate_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `geo`
--
ALTER TABLE `geo`
  ADD CONSTRAINT `fk_geo_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_geo_entity1` FOREIGN KEY (`entity_id`) REFERENCES `entity` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `nesting`
--
ALTER TABLE `nesting`
  ADD CONSTRAINT `fk_nesting_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `nesting_has_geo`
--
ALTER TABLE `nesting_has_geo`
  ADD CONSTRAINT `fk_nesting_has_geo_geo1` FOREIGN KEY (`geo_id`) REFERENCES `geo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nesting_has_geo_nesting1` FOREIGN KEY (`nesting_id`) REFERENCES `nesting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `nesting_in_work`
--
ALTER TABLE `nesting_in_work`
  ADD CONSTRAINT `fk_nesting_in_work_nesting1` FOREIGN KEY (`nesting_id`) REFERENCES `nesting` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nesting_in_work_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `operation_has_area`
--
ALTER TABLE `operation_has_area`
  ADD CONSTRAINT `fk_operation_has_area_area1` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_operation_has_area_operation1` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
