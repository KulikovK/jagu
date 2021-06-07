-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 07 2021 г., 11:48
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `jagu`
--
CREATE DATABASE IF NOT EXISTS `jagu` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jagu`;

-- --------------------------------------------------------

--
-- Структура таблицы `academicdegree`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `academicdegree`;
CREATE TABLE `academicdegree`
(
    `AD_id`           int(11)                         NOT NULL,
    `AD_name`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'ученая степень',
    `AD_Abbreviation` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Краткое обозначение'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Список ученых степеней';

--
-- ССЫЛКИ ТАБЛИЦЫ `academicdegree`:
--

--
-- Дамп данных таблицы `academicdegree`
--

INSERT INTO `academicdegree` (`AD_id`, `AD_name`, `AD_Abbreviation`)
VALUES (3, 'Кандидат технических наук', 'к. т. н.'),
       (4, 'Доктор физико-математических наук', 'д. ф.-м. н');

-- --------------------------------------------------------

--
-- Структура таблицы `academicgroups`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `academicgroups`;
CREATE TABLE `academicgroups`
(
    `AG_Code`        varchar(45)      NOT NULL COMMENT 'Код группы',
    `AG_specialty`   int(11)          NOT NULL COMMENT 'Специальность',
    `AG_YearOfStart` year(4)          NOT NULL COMMENT 'Год начала',
    `AG_YearOfEnd`   year(4)          NOT NULL COMMENT 'Код окончания',
    `AG_NumCuorse`   int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Курс',
    `AG_Curator`     int(11)                   DEFAULT NULL COMMENT 'Куратор',
    `AG_Headman`     int(11)                   DEFAULT NULL COMMENT 'Староста',
    `AG_FormOfStudy` int(11)          NOT NULL COMMENT 'Форма обучения'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Академические группы';

--
-- ССЫЛКИ ТАБЛИЦЫ `academicgroups`:
--   `AG_Curator`
--       `teacherprofile` -> `TP_UserID`
--   `AG_FormOfStudy`
--       `formatofstudy` -> `FOS_id`
--   `AG_Headman`
--       `studentprofile` -> `SP_id`
--   `AG_specialty`
--       `specialtylist` -> `SL_id`
--

--
-- Дамп данных таблицы `academicgroups`
--

INSERT INTO `academicgroups` (`AG_Code`, `AG_specialty`, `AG_YearOfStart`, `AG_YearOfEnd`, `AG_NumCuorse`, `AG_Curator`,
                              `AG_Headman`, `AG_FormOfStudy`)
VALUES ('120871', 1, 2017, 2021, 4, 5, 11, 1),
       ('120871-QUA', 2, 2016, 2022, 1, 8, NULL, 2),
       ('120971-FC', 1, 2020, 2024, 1, 86, NULL, 1),
       ('127987-A', 2, 2020, 2023, 1, 10, 7, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `academictitle`
--
-- Создание: Янв 14 2021 г., 17:13
--

DROP TABLE IF EXISTS `academictitle`;
CREATE TABLE `academictitle`
(
    `AT_id`           int(11)                         NOT NULL,
    `AT_name`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Должность',
    `AT_Abbreviation` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Краткое обозначение'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Должности/Ученые степени';

--
-- ССЫЛКИ ТАБЛИЦЫ `academictitle`:
--

--
-- Дамп данных таблицы `academictitle`
--

INSERT INTO `academictitle` (`AT_id`, `AT_name`, `AT_Abbreviation`)
VALUES (1, 'Доцент', ''),
       (2, 'профессор', 'Проф.'),
       (3, 'Старший преподаватель', ''),
       (4, 'Диспетчер деканата', 'дисп.');

-- --------------------------------------------------------

--
-- Структура таблицы `accauntactivation`
--
-- Создание: Апр 04 2021 г., 02:16
--

DROP TABLE IF EXISTS `accauntactivation`;
CREATE TABLE `accauntactivation`
(
    `AA_UserID`             int(11)      NOT NULL COMMENT 'ИД пользователя',
    `AA_ActivationCodeHash` varchar(255) NOT NULL COMMENT 'Хеш кода активации'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Таблица активации аккаунта';

--
-- ССЫЛКИ ТАБЛИЦЫ `accauntactivation`:
--   `AA_UserID`
--       `users` -> `User_id`
--

--
-- Дамп данных таблицы `accauntactivation`
--

INSERT INTO `accauntactivation` (`AA_UserID`, `AA_ActivationCodeHash`)
VALUES (67, '318e8c7748cada75c28d1eeea0060fbb'),
       (85, '75031a50878f17506fee4d1848e09046'),
       (87, 'c1b283692a11278870e9c2e82edac1d1'),
       (88, 'e7dfca01f394755c11f853602cb2608a'),
       (89, '80c0e8c4457441901351e4abbcf8c75c'),
       (90, '802a5fd4efb36391dfa8f1991fd0f849'),
       (91, '2cfa47a65809ea0496bbf9aa363dc5da'),
       (92, '7bec7e63a493e2d61891b1e4051ef75a'),
       (93, '56880339cfb8fe04c2d17c6160d0512f'),
       (98, 'e6343151197b18a354ecdabd0ce06134');

-- --------------------------------------------------------

--
-- Структура таблицы `attendancelesson`
--
-- Создание: Май 17 2021 г., 14:03
--

DROP TABLE IF EXISTS `attendancelesson`;
CREATE TABLE `attendancelesson`
(
    `AL_LessonInfo_id` int(11) NOT NULL COMMENT 'ИД занятия',
    `AL_Student_id`    int(11) NOT NULL COMMENT 'Студент',
    `AL_NumberHours`   int(10) UNSIGNED DEFAULT 0 COMMENT 'Количество астрономических, которые пропустил студент',
    `AL_LessonGrande`  int(11)          DEFAULT 0 COMMENT 'Заработанные баллы',
    `AL_Coments`       varchar(255)     DEFAULT NULL COMMENT 'Коментарий'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Посещаемость';

--
-- ССЫЛКИ ТАБЛИЦЫ `attendancelesson`:
--   `AL_LessonInfo_id`
--       `lessoninfo` -> `LI_id`
--   `AL_Student_id`
--       `studentprofile` -> `SP_id`
--

--
-- Дамп данных таблицы `attendancelesson`
--

INSERT INTO `attendancelesson` (`AL_LessonInfo_id`, `AL_Student_id`, `AL_NumberHours`, `AL_LessonGrande`, `AL_Coments`)
VALUES (11, 2, 0, 2, ''),
       (11, 6, 2, -2, ''),
       (11, 11, 0, 2, ''),
       (11, 89, 2, 0, ''),
       (11, 90, 0, 2, ''),
       (11, 92, 0, 2, ''),
       (12, 2, NULL, 12, NULL),
       (12, 6, NULL, 12, NULL),
       (12, 89, 1, 8, NULL),
       (13, 2, NULL, 2, NULL),
       (13, 6, 0, 2, NULL),
       (13, 11, 0, 2, NULL),
       (13, 89, 0, 2, NULL),
       (13, 90, 0, 2, NULL),
       (13, 92, 0, 2, NULL),
       (14, 11, 0, 12, NULL),
       (14, 90, 0, 6, NULL),
       (14, 92, 0, 10, NULL),
       (100, 2, 2, 7, '-2'),
       (100, 6, 0, 17, ''),
       (100, 11, 2, 8, '-2'),
       (100, 89, 0, 20, ''),
       (100, 90, 0, 15, ''),
       (100, 92, 0, 10, ''),
       (100, 98, 0, 18, ''),
       (101, 2, 0, 7, ''),
       (101, 6, 0, 13, ''),
       (101, 11, 0, 15, ''),
       (101, 89, 0, 12, ''),
       (101, 90, 2, 11, '-2'),
       (101, 92, 2, 12, '-2'),
       (101, 98, 0, 17, ''),
       (102, 2, 0, 10, ''),
       (102, 6, 0, 10, ''),
       (102, 11, 2, 3, '-2'),
       (102, 89, 2, 5, '-2'),
       (102, 90, 0, 10, ''),
       (102, 92, 0, 10, ''),
       (102, 98, 0, 10, ''),
       (105, 7, 0, 2, ''),
       (105, 85, 0, 2, ''),
       (105, 88, 0, 2, ''),
       (105, 91, 0, 2, ''),
       (105, 93, 0, 2, ''),
       (106, 7, 0, 1, ''),
       (106, 85, 0, 2, ''),
       (106, 88, 0, 4, ''),
       (106, 91, 0, 5, ''),
       (106, 93, 0, 3, ''),
       (108, 2, 2, -2, ''),
       (108, 6, 2, -2, ''),
       (108, 11, 0, 7, ''),
       (108, 89, 2, -2, ''),
       (108, 90, 0, 4, ''),
       (108, 92, 0, 6, ''),
       (108, 98, 2, -2, ''),
       (110, 2, 2, -2, ''),
       (110, 6, 0, 8, 'комент'),
       (110, 11, 2, -2, ''),
       (110, 89, 0, 5, 'комент'),
       (110, 90, 0, 4, ''),
       (110, 92, 0, 6, 'комент'),
       (110, 98, 2, -2, ''),
       (112, 7, 0, 1, ''),
       (112, 85, 0, 2, ''),
       (112, 88, 0, 4, ''),
       (112, 91, 0, 5, ''),
       (112, 93, 0, 3, ''),
       (123, 7, 0, 4, ''),
       (123, 85, 0, 4, ''),
       (123, 88, 0, 4, ''),
       (123, 91, 2, 0, ''),
       (123, 93, 2, 0, ''),
       (124, 7, 0, 4, ''),
       (124, 85, 2, 0, ''),
       (124, 88, 0, 2, ''),
       (124, 91, 0, 2, ''),
       (124, 93, 0, 4, ''),
       (125, 2, 0, 2, ''),
       (125, 6, 0, 4, ''),
       (125, 11, 0, 3, ''),
       (125, 89, 0, 4, ''),
       (125, 90, 2, 0, '-2'),
       (125, 92, 2, 1, '-2'),
       (125, 98, 0, 1, ''),
       (128, 7, 0, 4, ''),
       (128, 85, 0, 4, ''),
       (128, 88, 0, 4, ''),
       (128, 91, 0, 4, ''),
       (128, 93, 0, 4, ''),
       (129, 7, 0, 4, ''),
       (129, 85, 2, 0, '-2'),
       (129, 88, 0, 4, ''),
       (129, 91, 0, 4, ''),
       (129, 93, 0, 4, ''),
       (130, 7, 0, 4, ''),
       (130, 85, 0, 2, ''),
       (130, 88, 0, 2, ''),
       (130, 91, 0, 2, ''),
       (130, 93, 0, 2, ''),
       (131, 7, 0, 4, ''),
       (131, 85, 0, 2, ''),
       (131, 88, 1, 2, ''),
       (131, 91, 0, 2, ''),
       (131, 93, 0, 2, ''),
       (132, 7, 0, 4, ''),
       (132, 85, 0, 4, ''),
       (132, 88, 0, 4, ''),
       (132, 91, 0, 4, ''),
       (132, 93, 0, 4, ''),
       (133, 7, 0, 2, ''),
       (133, 85, 0, 2, ''),
       (133, 88, 2, -2, ''),
       (133, 91, 0, 2, ''),
       (133, 93, 0, 2, ''),
       (134, 2, 2, -2, ''),
       (134, 6, 0, 4, ''),
       (134, 11, 0, 4, ''),
       (134, 89, 0, 4, ''),
       (134, 90, 0, 4, ''),
       (134, 92, 0, 4, ''),
       (134, 98, 2, -2, ''),
       (136, 2, 0, 2, ''),
       (136, 6, 0, 3, ''),
       (136, 89, 0, 4, ''),
       (137, 11, 0, 3, ''),
       (137, 90, 2, 0, ''),
       (137, 92, 0, 3, ''),
       (137, 98, 0, 2, ''),
       (138, 2, 0, 1, ''),
       (138, 6, 0, 2, ''),
       (138, 89, 0, 3, ''),
       (140, 11, 0, 3, ''),
       (140, 90, 0, 0, ''),
       (140, 92, 0, 1, ''),
       (140, 98, 0, 1, ''),
       (141, 2, 0, 8, ''),
       (141, 6, 0, 17, ''),
       (141, 89, 0, 16, ''),
       (142, 11, 0, 19, ''),
       (142, 90, 0, 5, ''),
       (142, 92, 0, 3, ''),
       (142, 98, 0, 9, ''),
       (143, 2, 0, 4, ''),
       (143, 6, 0, 5, ''),
       (143, 89, 0, 5, ''),
       (144, 11, 0, 5, ''),
       (144, 90, 2, 0, ''),
       (144, 92, 0, 5, ''),
       (144, 98, 0, 5, ''),
       (145, 7, 0, 2, ''),
       (145, 85, 0, 2, ''),
       (145, 88, 0, 2, ''),
       (145, 91, 0, 2, ''),
       (145, 93, 0, 2, ''),
       (146, 7, 0, 2, ''),
       (146, 85, 2, 0, ''),
       (146, 88, 1, 1, ''),
       (146, 91, 0, 2, ''),
       (146, 93, 0, 2, ''),
       (147, 7, 0, 2, ''),
       (147, 85, 0, 2, ''),
       (147, 88, 0, 2, ''),
       (147, 91, 2, 0, ''),
       (147, 93, 0, 2, ''),
       (149, 7, 0, 2, ''),
       (149, 85, 0, 2, ''),
       (149, 88, 0, 2, ''),
       (149, 91, 0, 2, ''),
       (149, 93, 0, 2, ''),
       (150, 7, 0, 2, ''),
       (150, 85, 0, 2, ''),
       (150, 88, 2, 0, ''),
       (150, 91, 0, 2, ''),
       (150, 93, 0, 2, ''),
       (151, 7, 0, 4, ''),
       (151, 85, 0, 3, ''),
       (151, 88, 0, 1, ''),
       (151, 91, 0, 3, ''),
       (151, 93, 0, 4, ''),
       (152, 7, 0, 15, ''),
       (152, 85, 0, 8, ''),
       (152, 88, 0, 5, ''),
       (152, 91, 0, 13, ''),
       (152, 93, 0, 10, ''),
       (153, 2, 2, 0, ''),
       (153, 6, 2, 0, ''),
       (153, 11, 2, 0, ''),
       (153, 89, 2, 0, ''),
       (153, 90, 2, 0, ''),
       (153, 92, 2, 0, ''),
       (153, 98, 2, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--
-- Создание: Апр 07 2021 г., 23:23
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments`
(
    `DEP_id`           int(11)                         NOT NULL,
    `DEP_Name`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Название кафедры',
    `DEP_Faculty_id`   int(11)                         NOT NULL COMMENT 'Факультет',
    `DEP_Head_id`      int(11) DEFAULT NULL COMMENT 'ЗавКаферы',
    `DEP_Abbreviation` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Аббревиатура'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Кафедры';

--
-- ССЫЛКИ ТАБЛИЦЫ `departments`:
--   `DEP_Faculty_id`
--       `faculties` -> `FCT_id`
--   `DEP_Head_id`
--       `teacherprofile` -> `TP_UserID`
--

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`DEP_id`, `DEP_Name`, `DEP_Faculty_id`, `DEP_Head_id`, `DEP_Abbreviation`)
VALUES (1, 'Информатики и информационных технологий', 1, 5, 'Информатики и ИТ'),
       (2, 'Алгебры, математического анализа и геометрии', 1, 10, 'АМАиГ'),
       (3, 'Экономики и управления', 2, NULL, 'ЭиУ'),
       (4, 'Технологий и сервиса', 2, NULL, 'ТиС'),
       (5, 'Агроинженерии и техносферной безопасности', 2, NULL, 'АиТБ');

-- --------------------------------------------------------

--
-- Структура таблицы `discipline`
--
-- Создание: Дек 04 2020 г., 23:50
--

DROP TABLE IF EXISTS `discipline`;
CREATE TABLE `discipline`
(
    `DISC_id`             int(11)      NOT NULL COMMENT 'ИД дисциплины',
    `DISC_name`           varchar(255) NOT NULL COMMENT 'Название дисциплины',
    `DISC_LeadTeacher_id` int(11)      DEFAULT NULL COMMENT 'Ведущий преподаватель',
    `DISC_Description`    varchar(255) DEFAULT NULL COMMENT 'Описание дисциплины'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Таблица дисциплин';

--
-- ССЫЛКИ ТАБЛИЦЫ `discipline`:
--   `DISC_LeadTeacher_id`
--       `teacherprofile` -> `TP_UserID`
--

--
-- Дамп данных таблицы `discipline`
--

INSERT INTO `discipline` (`DISC_id`, `DISC_name`, `DISC_LeadTeacher_id`, `DISC_Description`)
VALUES (1, 'Программирование', 8, 'Программирование: парадигмы программирования и паттерны разработки ПО.'),
       (2, 'Геометрия', 10, 'Аналитическая геометрия'),
       (3, 'Дискретная математика', 10, 'Теория множеств. Теория многочленов. Булева алгебра. Дискретные величины.');

-- --------------------------------------------------------

--
-- Структура таблицы `faculties`
--
-- Создание: Ноя 28 2020 г., 17:14
--

DROP TABLE IF EXISTS `faculties`;
CREATE TABLE `faculties`
(
    `FCT_id`           int(11)                         NOT NULL,
    `FCT_name`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Название факультета',
    `FCT_Dean`         int(11) DEFAULT NULL COMMENT 'Декан',
    `FCT_Abbreviation` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Аббревиатура'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Факультеты';

--
-- ССЫЛКИ ТАБЛИЦЫ `faculties`:
--   `FCT_Dean`
--       `teacherprofile` -> `TP_UserID`
--

--
-- Дамп данных таблицы `faculties`
--

INSERT INTO `faculties` (`FCT_id`, `FCT_name`, `FCT_Dean`, `FCT_Abbreviation`)
VALUES (1, 'Математики физики и информатики', 8, 'МФиИ'),
       (2, 'Технологий и бизнеса', NULL, 'ТиБ');

-- --------------------------------------------------------

--
-- Структура таблицы `formatofstudy`
--
-- Создание: Ноя 28 2020 г., 17:14
--

DROP TABLE IF EXISTS `formatofstudy`;
CREATE TABLE `formatofstudy`
(
    `FOS_id`   int(11)                         NOT NULL,
    `FOS_Name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Форма обучения'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Форма обучения';

--
-- ССЫЛКИ ТАБЛИЦЫ `formatofstudy`:
--

--
-- Дамп данных таблицы `formatofstudy`
--

INSERT INTO `formatofstudy` (`FOS_id`, `FOS_Name`)
VALUES (2, 'Заочная'),
       (1, 'Очная'),
       (3, 'Очно-заочная');

-- --------------------------------------------------------

--
-- Структура таблицы `formofcontrol`
--
-- Создание: Ноя 28 2020 г., 17:14
--

DROP TABLE IF EXISTS `formofcontrol`;
CREATE TABLE `formofcontrol`
(
    `FOC_Abbreviation` varchar(255) NOT NULL,
    `FOC_Name`         varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Таблица форм контроля';

--
-- ССЫЛКИ ТАБЛИЦЫ `formofcontrol`:
--

--
-- Дамп данных таблицы `formofcontrol`
--

INSERT INTO `formofcontrol` (`FOC_Abbreviation`, `FOC_Name`)
VALUES ('Зч', 'Зачет'),
       ('Дифф. зч', 'Зачет с оценкой'),
       ('КР', 'Курсовая работа'),
       ('КП', 'Курсовой проект'),
       ('Эк', 'Экзамен');

-- --------------------------------------------------------

--
-- Структура таблицы `lessoninfo`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `lessoninfo`;
CREATE TABLE `lessoninfo`
(
    `LI_id`              int(11)          NOT NULL COMMENT 'ид занятия',
    `LI_date`            date             NOT NULL COMMENT 'Дата проведения занятия',
    `LI_LessonTopic`     varchar(255)     NOT NULL COMMENT 'Тема занятия',
    `LI_LessonNumber_id` int(10) UNSIGNED NOT NULL COMMENT 'Номер пары',
    `LI_StartTime`       timestamp        NULL     DEFAULT NULL COMMENT 'Время начала занятия',
    `LI_EndTime`         timestamp        NULL     DEFAULT NULL COMMENT 'Время окончания занятия',
    `StudyLoad_id`       int(11)          NOT NULL,
    `LI_CountHours`      int(10) UNSIGNED NOT NULL DEFAULT 2 COMMENT 'Количество часов'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Информация о занятии';

--
-- ССЫЛКИ ТАБЛИЦЫ `lessoninfo`:
--   `LI_LessonNumber_id`
--       `lessonnumber` -> `LN_Number`
--   `StudyLoad_id`
--       `studyload` -> `SL_Id`
--

--
-- Дамп данных таблицы `lessoninfo`
--

INSERT INTO `lessoninfo` (`LI_id`, `LI_date`, `LI_LessonTopic`, `LI_LessonNumber_id`, `LI_StartTime`, `LI_EndTime`,
                          `StudyLoad_id`, `LI_CountHours`)
VALUES (13, '2021-04-01', 'Тестовая лекция', 1, NULL, NULL, 1, 2),
       (14, '2021-04-20', 'Динамические структуры данных', 2, NULL, NULL, 3, 2),
       (11, '2021-04-27', 'ТЕСТ 120871', 1, NULL, NULL, 1, 2),
       (105, '2021-04-27', 'Кривые второго порядка', 2, NULL, NULL, 41, 2),
       (106, '2021-04-27', 'Кривые второго порядка', 3, NULL, NULL, 41, 2),
       (112, '2021-04-27', 'Кривые второго порядка', 4, NULL, NULL, 41, 2),
       (10, '2021-04-27', 'Тема занятия', 3, NULL, NULL, 53, 2),
       (12, '2021-04-28', 'Практика в программировании', 1, NULL, NULL, 3, 2),
       (145, '2021-05-01', 'Лекция по теме 1', 1, NULL, NULL, 2, 2),
       (149, '2021-05-01', 'Лабораторная работа №1', 2, NULL, NULL, 40, 2),
       (136, '2021-05-03', 'Лр 2', 1, NULL, NULL, 3, 2),
       (137, '2021-05-03', 'ЛР 2', 2, NULL, NULL, 3, 2),
       (146, '2021-05-08', 'Лекция по теме 2', 1, NULL, NULL, 2, 2),
       (150, '2021-05-08', 'Лабораторная работа №2', 2, NULL, NULL, 40, 2),
       (138, '2021-05-10', 'Лр 2', 1, NULL, NULL, 3, 2),
       (140, '2021-05-10', 'Лр 3', 2, NULL, NULL, 3, 2),
       (147, '2021-05-15', 'Лекция по теме 3', 1, NULL, NULL, 2, 2),
       (151, '2021-05-15', 'Лабораторная работа №3', 2, NULL, NULL, 40, 2),
       (141, '2021-05-17', 'Контрольная работа', 1, NULL, NULL, 3, 2),
       (142, '2021-05-17', 'Контрольная работа', 2, NULL, NULL, 3, 2),
       (101, '2021-05-20', 'Тест', 2, NULL, NULL, 1, 2),
       (133, '2021-05-20', 'введение', 3, NULL, NULL, 2, 2),
       (100, '2021-05-20', 'Тест', 1, NULL, NULL, 54, 2),
       (102, '2021-05-20', 'ЛР 10', 4, NULL, NULL, 54, 2),
       (110, '2021-05-21', 'Контрольное тестовое добавление', 4, NULL, NULL, 1, 2),
       (108, '2021-05-21', 'Контрольное тестовое добавление', 5, NULL, NULL, 1, 2),
       (130, '2021-05-21', 'лк', 1, NULL, NULL, 2, 2),
       (129, '2021-05-21', 'лр 7', 2, NULL, NULL, 40, 2),
       (128, '2021-05-21', 'Лр 6', 3, NULL, NULL, 40, 2),
       (113, '2021-05-21', 'Тема занятия', 3, NULL, NULL, 53, 2),
       (124, '2021-05-22', 'Лекция по теме 4', 1, NULL, NULL, 2, 2),
       (131, '2021-05-22', 'лк', 3, NULL, NULL, 2, 2),
       (152, '2021-05-22', 'Итоговый тест', 1, NULL, NULL, 40, 2),
       (123, '2021-05-22', 'ЛК', 2, NULL, NULL, 40, 2),
       (132, '2021-05-22', 'пз 4', 4, NULL, NULL, 40, 2),
       (125, '2021-05-22', 'ЛР 12', 3, NULL, NULL, 54, 2),
       (134, '2021-05-22', 'пз', 4, NULL, NULL, 54, 2),
       (143, '2021-05-24', 'ЛР 11', 1, NULL, NULL, 3, 2),
       (144, '2021-05-24', 'ЛР 11', 2, NULL, NULL, 3, 2),
       (153, '2021-06-03', 'авав', 1, NULL, NULL, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `lessonnumber`
--
-- Создание: Дек 04 2020 г., 16:28
--

DROP TABLE IF EXISTS `lessonnumber`;
CREATE TABLE `lessonnumber`
(
    `LN_Number`    int(10) UNSIGNED NOT NULL COMMENT 'Номер пары',
    `LN_StartTime` time             NOT NULL COMMENT 'Начало пары',
    `LN_EndTime`   time             NOT NULL COMMENT 'Окончание пары'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Рассписание пар';

--
-- ССЫЛКИ ТАБЛИЦЫ `lessonnumber`:
--

--
-- Дамп данных таблицы `lessonnumber`
--

INSERT INTO `lessonnumber` (`LN_Number`, `LN_StartTime`, `LN_EndTime`)
VALUES (1, '08:40:00', '10:15:00'),
       (2, '10:25:00', '12:00:00'),
       (3, '12:40:00', '14:15:00'),
       (4, '14:25:00', '16:00:00'),
       (5, '16:10:00', '17:45:00');

-- --------------------------------------------------------

--
-- Структура таблицы `specialtylist`
--
-- Создание: Апр 07 2021 г., 23:23
--

DROP TABLE IF EXISTS `specialtylist`;
CREATE TABLE `specialtylist`
(
    `SL_id`           int(11)                         NOT NULL,
    `SL_Code`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Код специальности',
    `SL_Name`         varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Название специальности',
    `SL_Profile_id`   int(11)                         NOT NULL COMMENT 'Профиль подготовки',
    `SL_Faculty_id`   int(11)                         NOT NULL COMMENT 'Факультет',
    `SL_Abbreviation` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Аббревиатура'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Список специальностей';

--
-- ССЫЛКИ ТАБЛИЦЫ `specialtylist`:
--   `SL_Faculty_id`
--       `faculties` -> `FCT_id`
--   `SL_Profile_id`
--       `specialtyprofile` -> `SProf_id`
--

--
-- Дамп данных таблицы `specialtylist`
--

INSERT INTO `specialtylist` (`SL_id`, `SL_Code`, `SL_Name`, `SL_Profile_id`, `SL_Faculty_id`, `SL_Abbreviation`)
VALUES (1, '02.03.03', 'Математическое обеспечение и администрирование информационных систем', 1, 1, 'МОиАИС'),
       (2, '12.13.14', 'Прикладная информатика', 2, 1, 'ПриИнф'),
       (3, '20.03.01', 'Техносферная безопасность', 3, 2, 'ТехБез');

-- --------------------------------------------------------

--
-- Структура таблицы `specialtyprofile`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `specialtyprofile`;
CREATE TABLE `specialtyprofile`
(
    `SProf_id`   int(11)      NOT NULL,
    `SProf_name` varchar(255) NOT NULL COMMENT 'Название профиля подготовки'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Таблица профилей(направленностей)';

--
-- ССЫЛКИ ТАБЛИЦЫ `specialtyprofile`:
--

--
-- Дамп данных таблицы `specialtyprofile`
--

INSERT INTO `specialtyprofile` (`SProf_id`, `SProf_name`)
VALUES (1, 'Информационные системы и базы данных'),
       (2, 'Информатика в школе'),
       (3, 'Защита в чрезвычайных ситуациях');

-- --------------------------------------------------------

--
-- Структура таблицы `studentlistinsubgroups`
--
-- Создание: Апр 08 2021 г., 08:52
--

DROP TABLE IF EXISTS `studentlistinsubgroups`;
CREATE TABLE `studentlistinsubgroups`
(
    `SLS_SubGroups_id` int(11) NOT NULL,
    `SLS_Student_id`   int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Списки студентов по подгруппам';

--
-- ССЫЛКИ ТАБЛИЦЫ `studentlistinsubgroups`:
--   `SLS_Student_id`
--       `studentprofile` -> `SP_id`
--   `SLS_SubGroups_id`
--       `subgroups` -> `SG_id`
--

--
-- Дамп данных таблицы `studentlistinsubgroups`
--

INSERT INTO `studentlistinsubgroups` (`SLS_SubGroups_id`, `SLS_Student_id`)
VALUES (1, 2),
       (1, 11),
       (1, 89),
       (107, 2),
       (107, 6),
       (107, 89),
       (108, 11),
       (108, 90),
       (108, 92),
       (108, 98);

-- --------------------------------------------------------

--
-- Структура таблицы `studentprofile`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `studentprofile`;
CREATE TABLE `studentprofile`
(
    `SP_id`             int(11)                           NOT NULL,
    `SP_Surname`        varchar(255) CHARACTER SET utf8   NOT NULL COMMENT 'Фамилия',
    `SP_Name`           varchar(255) CHARACTER SET utf8   NOT NULL COMMENT 'Имя',
    `SP_MiddleName`     varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Отчество',
    `SP_BrieflyName`    varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'ФИО инициалы',
    `SP_Gender`         enum ('М','Ж') CHARACTER SET utf8 NOT NULL COMMENT 'Пол',
    `SP_DataOfBirth`    date                              NOT NULL COMMENT 'Дата рождения',
    `SP_TypeOfStudy`    enum ('Б','К') CHARACTER SET utf8 NOT NULL COMMENT 'Тип обучения(бюджет/Коммерция)',
    `SP_NumberOfBook`   varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Номер зачетной книжки',
    `SP_AcademGroup_id` varchar(255) CHARACTER SET utf8   NOT NULL COMMENT 'Код группы'
) ENGINE = InnoDB
  DEFAULT CHARSET = armscii8 COMMENT ='Студенты';

--
-- ССЫЛКИ ТАБЛИЦЫ `studentprofile`:
--   `SP_AcademGroup_id`
--       `academicgroups` -> `AG_Code`
--   `SP_id`
--       `users` -> `User_id`
--

--
-- Дамп данных таблицы `studentprofile`
--

INSERT INTO `studentprofile` (`SP_id`, `SP_Surname`, `SP_Name`, `SP_MiddleName`, `SP_BrieflyName`, `SP_Gender`,
                              `SP_DataOfBirth`, `SP_TypeOfStudy`, `SP_NumberOfBook`, `SP_AcademGroup_id`)
VALUES (2, 'Куликов', 'Константин', 'Петрович', 'Куликов К. П.', 'М', '1998-10-13', 'Б', '16979-65', '120871'),
       (6, 'Петров', 'Петр', 'Петрович', 'Петров П. П.', 'М', '1999-11-12', 'Б', '15698-21', '120871'),
       (7, 'Макаров', 'Максим', 'Олегович', '', 'Ж', '1999-11-23', 'Б', '12345-67', '127987-A'),
       (11, 'Пупкин', 'Василий', 'Васильевич', 'Пупкин В. В.', 'М', '1999-05-21', 'Б', '25688-96', '120871'),
       (85, 'Ильин', 'Игорь', 'Андреевич', 'Ильин И. А.', 'М', '2021-01-15', 'Б', '252569', '127987-A'),
       (88, 'Савенков', 'Илья', 'Андреевич', 'Савенков И. А.', 'М', '1999-08-18', 'К', '180899-2', '127987-A'),
       (89, 'Антонов', 'Николай', 'Иванович', 'Антонов Н. И.', 'М', '2000-02-25', 'Б', '25022000', '120871'),
       (90, 'Щукин', 'Аркадий', 'Николаевич', 'Щукин А. Н.', 'М', '2021-01-07', 'К', '210107', '120871'),
       (91, 'Вай', 'Игорь', 'Михайлович', 'Вай И. М.', 'М', '1996-03-18', 'Б', '18031996', '127987-A'),
       (92, 'Рахманов', 'Илья', 'Олеговчи', 'Рахманов И. О.', 'М', '2001-01-31', 'К', '310121', '120871'),
       (93, 'Добрикова', 'Ирина', 'Андреевна', 'Добрикова И. А.', 'Ж', '1999-05-19', 'Б', '190599', '127987-A'),
       (98, 'Филонов', 'Максим', 'Андреевич', 'Филонов М. А.', 'М', '1998-04-14', 'К', '140198-К', '120871');

-- --------------------------------------------------------

--
-- Структура таблицы `studyload`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `studyload`;
CREATE TABLE `studyload`
(
    `SL_DISC_id`          int(11)          NOT NULL COMMENT 'id дисциплины',
    `SL_TypeLesson_code`  varchar(65)      NOT NULL COMMENT 'Вид занятия',
    `SL_NumberHours`      int(10) UNSIGNED NOT NULL COMMENT 'Количество часов',
    `SL_Teacher_id`       int(11)          NOT NULL COMMENT 'Преподаватель',
    `SL_AcademGroup_code` varchar(65)      NOT NULL COMMENT 'Академическая группа',
    `SL_AdditionalLoad`   tinyint(4)   DEFAULT 0 COMMENT 'Доп. Нагрузка',
    `SL_Id`               int(11)          NOT NULL COMMENT 'ИД учебной нагрузки',
    `SL_SemesrNumber`     int(10) UNSIGNED NOT NULL COMMENT 'Номер семестра',
    `SL_FormControl_id`   varchar(255) DEFAULT NULL COMMENT 'Форма контроля'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Учебная нагрузака дисциплины';

--
-- ССЫЛКИ ТАБЛИЦЫ `studyload`:
--   `SL_DISC_id`
--       `discipline` -> `DISC_id`
--   `SL_FormControl_id`
--       `formofcontrol` -> `FOC_Abbreviation`
--   `SL_AcademGroup_code`
--       `academicgroups` -> `AG_Code`
--   `SL_Teacher_id`
--       `teacherprofile` -> `TP_UserID`
--   `SL_TypeLesson_code`
--       `typelesson` -> `TL_id`
--

--
-- Дамп данных таблицы `studyload`
--

INSERT INTO `studyload` (`SL_DISC_id`, `SL_TypeLesson_code`, `SL_NumberHours`, `SL_Teacher_id`, `SL_AcademGroup_code`,
                         `SL_AdditionalLoad`, `SL_Id`, `SL_SemesrNumber`, `SL_FormControl_id`)
VALUES (1, 'ЛК', 36, 8, '120871', NULL, 1, 7, 'Эк'),
       (1, 'ЛК', 20, 8, '127987-A', NULL, 2, 7, 'Зч'),
       (1, 'ПЗ', 18, 97, '120871', NULL, 3, 7, NULL),
       (2, 'ЛК', 24, 10, '127987-A', NULL, 5, 7, 'Эк'),
       (1, 'ПЗ', 16, 8, '127987-A', NULL, 40, 7, 'Зч'),
       (2, 'ПЗ', 18, 97, '127987-A', NULL, 41, 7, NULL),
       (2, 'ЛК', 25, 97, '120971-FC', NULL, 50, 7, 'Зч'),
       (3, 'ЛК', 22, 97, '120971-FC', NULL, 51, 7, 'Эк'),
       (1, 'ЛК', 28, 97, '120971-FC', NULL, 53, 7, 'Дифф. зч'),
       (1, 'ПЗ', 18, 8, '120871', NULL, 54, 7, NULL),
       (1, 'Экз.', 2, 8, '120871', NULL, 55, 6, 'Эк');

-- --------------------------------------------------------

--
-- Структура таблицы `subgroups`
--
-- Создание: Май 23 2021 г., 14:37
--

DROP TABLE IF EXISTS `subgroups`;
CREATE TABLE `subgroups`
(
    `SG_id`           int(11)          NOT NULL COMMENT 'ID подгруппы',
    `SG_StudyLoad_id` int(11)          NOT NULL COMMENT 'Нагрузка',
    `SG_Numbers`      int(10) UNSIGNED NOT NULL COMMENT 'Номер подгруппы'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Подргуппы';

--
-- ССЫЛКИ ТАБЛИЦЫ `subgroups`:
--   `SG_StudyLoad_id`
--       `studyload` -> `SL_Id`
--

--
-- Дамп данных таблицы `subgroups`
--

INSERT INTO `subgroups` (`SG_id`, `SG_StudyLoad_id`, `SG_Numbers`)
VALUES (1, 1, 2),
       (107, 3, 1),
       (108, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `teacherprofile`
--
-- Создание: Апр 07 2021 г., 23:23
--

DROP TABLE IF EXISTS `teacherprofile`;
CREATE TABLE `teacherprofile`
(
    `TP_UserID`        int(11)        NOT NULL COMMENT 'Ссылка но провиль в таблице пользователей',
    `TP_Surname`       varchar(255)   NOT NULL COMMENT 'Фамилия',
    `TP_Name`          varchar(255)   NOT NULL COMMENT 'Имя',
    `TP_MiddleName`    varchar(255) DEFAULT NULL COMMENT 'Отчество',
    `TP_BrieflyName`   varchar(255) DEFAULT NULL COMMENT 'ФИО инициалы',
    `TP_Gender`        enum ('М','Ж') NOT NULL COMMENT 'Пол',
    `TP_DataOfBirth`   date           NOT NULL COMMENT 'Дата Рождения',
    `TP_Degree`        int(11)      DEFAULT NULL COMMENT 'Ученая степень',
    `TP_AcademicTitle` int(11)      DEFAULT NULL COMMENT 'Ученое звание',
    `TP_Department`    int(11)      DEFAULT NULL COMMENT 'Кафедра'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Профил преподавателя';

--
-- ССЫЛКИ ТАБЛИЦЫ `teacherprofile`:
--   `TP_Degree`
--       `academicdegree` -> `AD_id`
--   `TP_AcademicTitle`
--       `academictitle` -> `AT_id`
--   `TP_Department`
--       `departments` -> `DEP_id`
--   `TP_UserID`
--       `users` -> `User_id`
--

--
-- Дамп данных таблицы `teacherprofile`
--

INSERT INTO `teacherprofile` (`TP_UserID`, `TP_Surname`, `TP_Name`, `TP_MiddleName`, `TP_BrieflyName`, `TP_Gender`,
                              `TP_DataOfBirth`, `TP_Degree`, `TP_AcademicTitle`, `TP_Department`)
VALUES (5, 'Иванов', 'Иван', 'Иванович', 'Иванов И. И.', 'М', '1978-11-19', 3, 1, 1),
       (8, 'Архипов', 'Вадим', 'Олегович', 'Архипов В. О.', 'М', '1978-11-19', 4, 2, 1),
       (10, 'Фролов', 'Федор', 'Иванович', 'Фролов Ф. И.', 'М', '1985-06-21', 4, 2, 2),
       (67, 'Куликов', 'Константин', 'Петрович', 'Куликов К. П.', 'М', '1998-10-13', NULL, 4, NULL),
       (86, 'Васницова', 'Дарья', 'Сергеевна', 'Васницова Д. С.', 'Ж', '1995-10-15', NULL, 4, NULL),
       (94, 'Админов', 'Админ', 'Админович', 'Админов А. А.', 'М', '2020-12-14', 3, 1, 2),
       (97, 'Прилепин', 'Август', 'Иванович', 'Прилепин А. И.', 'М', '1985-09-01', 4, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `typelesson`
--
-- Создание: Дек 02 2020 г., 19:16
--

DROP TABLE IF EXISTS `typelesson`;
CREATE TABLE `typelesson`
(
    `TL_id`   varchar(65)  NOT NULL COMMENT 'Краткое обозначение',
    `TL_Name` varchar(255) NOT NULL COMMENT 'Полное название'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='типы занятий';

--
-- ССЫЛКИ ТАБЛИЦЫ `typelesson`:
--

--
-- Дамп данных таблицы `typelesson`
--

INSERT INTO `typelesson` (`TL_id`, `TL_Name`)
VALUES ('Зач.', 'Зачет'),
       ('Конс.', 'Консультация'),
       ('КР', 'Курсовая работа'),
       ('КП', 'Курсовой проект'),
       ('ЛР', 'Лабораторная работа'),
       ('ЛК', 'Лекция'),
       ('ПЗ', 'Практическое занаятие'),
       ('Экз.', 'Экзамен');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Янв 14 2021 г., 17:13
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `User_id`     int(11)          NOT NULL,
    `User_login`  varchar(255)     NOT NULL COMMENT 'Логин',
    `User_email`  varchar(255)     NOT NULL COMMENT 'e-mail',
    `User_Passwd` varchar(255)     NOT NULL COMMENT 'Пароль',
    `User_Role`   int(10) UNSIGNED NOT NULL COMMENT 'Роль пользователя',
    `ActivStatus` tinyint(4) DEFAULT 0 COMMENT 'Статус активности аккаунта'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Пользователи';

--
-- ССЫЛКИ ТАБЛИЦЫ `users`:
--   `User_Role`
--       `usersrole` -> `UR_id`
--

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`User_id`, `User_login`, `User_email`, `User_Passwd`, `User_Role`, `ActivStatus`)
VALUES (2, 'kilikov', 'kulikov@jagu.ru', 'f6d735d6f5457a55f4acc5f3c596395c', 4, 0),
       (5, 'ivanov666', 'ivanov99@mail.ru', '4dfe6e220d16e7b633cfdd92bcc8050b', 3, 0),
       (6, 'petrov', 'petrov@jagu.ru', 'f396c3b74762b1fee69b10abb875139b', 4, 0),
       (7, 'makarovmax1999', 'makarov-mo@jagu.ru', 'cd73502828457d15655bbd7a63fb0bc8', 4, 0),
       (8, 'teacher', 'teacher@jagu.ru', '$2y$10$VAs.Z/TkYGuqUU6Fsr0rFOgsa4Cj4Ec1cUNv38.DDukaNRXKKDoGy', 3, 1),
       (10, 'frolov', 'frolov@jagu.ru', 'bd25cebc87fa0efe93091736566ca509', 3, 0),
       (11, 'pupkinVasily', 'vasy_pupkin@jagu.ru', '0695f01906298b5cbe81431d5627fa9e', 4, 0),
       (67, 'KKulikov', 'kostj1998.10.13@yandex.ru', '$2y$10$SQ4AmaIdAReZWvQYQX8JA.wBMi.LUmLsBI/OJc2eDH5F6VncvuXJq', 2,
        1),
       (85, 'testemail', 'testemail@jagu.ru', '$2y$10$SX3/84YD3jUSRGqmNqO.C.R0ft9zvsovdBk8EFlddhtZxZlIhKnum', 4, 1),
       (86, 'admin', 'admin@jagu.ru', '$2y$10$uMw2b57ifi3xXacHaUOLjO.rAEDvwlXRV35J.ov7.P/yp.FkeE.py', 2, 1),
       (87, 'ribkin', 'ribkin@mail.ru', '$2y$10$Qgf20iCsHNuYqNq14bV0veF5k3CFHIbc/S4Okb8PP4WzsK.cm.Z2y', 4, 0),
       (88, 'savankov', 'savenkov@mail.ru', '$2y$10$2UxLixjs.OVkOlZI7Us/lu0vHnA02G6QF5Lxz7cPYc4ujiQ1/PuP6', 4, 0),
       (89, 'antonov', 'antonov@mail.ru', '$2y$10$8iD7QF5WNZwdwYurHX1wWuaxfKdQY8Ih2WxEQM/Ru4vVUe72O99xS', 4, 0),
       (90, 'shukin', 'shukin@jagu.ru', '$2y$10$Pp8CFJHyu8IqNb9QhCrH4emVY/O6BjHM.9iPSfT.qtpXDJoNWhkVS', 4, 0),
       (91, 'vayim', 'vayim@mail.ru', '$2y$10$H73UpXUYSZWV0.DrV4QUaeo2IvSjGVEqKJIjSqFco3p4QigRV.knu', 4, 0),
       (92, 'reachman', 'rachmanov@mail.ru', '$2y$10$sern78Pnb5dXORwzXVcgVOyOZDQ/swSTFVSZo4zPgFWwHVIP/38e.', 4, 0),
       (93, 'irinadobrekova', 'dobririna99@jagu.ru', '$2y$10$lAbLcpgXixGkHrQmR/PvF.iD2cTQNFoGpxJ2HJ3YJ9pig3qkQRGi6', 4,
        0),
       (94, 'adminov', 'adminnov@jagu.ru', '$2y$10$YUkRmDdhUL6mjl4/5ZzZLOmIWI4uWZNcpzFsKqmJhNPyQ67vk3jR.', 2, 1),
       (97, 'avgust', 'avgust@jagu.ru', '$2y$10$oprzUVLOaVJBEtdBXgjLS.YX0WlWNX3AFZbAtNqDbRQBGYLdKQ2By', 3, 1),
       (98, 'filonov', 'filonov@mail.ru', '$2y$10$RgRWO/CGznWYVgcw91sqR.ENip/crGbbLqHdvFUcA0IH76ElWPBoa', 4, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `usersrole`
--
-- Создание: Янв 14 2021 г., 17:13
--

DROP TABLE IF EXISTS `usersrole`;
CREATE TABLE `usersrole`
(
    `UR_id`    int(10) UNSIGNED NOT NULL COMMENT 'ИД Роли',
    `UR_name`  varchar(255) DEFAULT NULL COMMENT 'Название Роли',
    `UR_modul` varchar(255) DEFAULT NULL COMMENT 'Модуль доступа'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8 COMMENT ='Таблица ролей пользователей';

--
-- ССЫЛКИ ТАБЛИЦЫ `usersrole`:
--

--
-- Дамп данных таблицы `usersrole`
--

INSERT INTO `usersrole` (`UR_id`, `UR_name`, `UR_modul`)
VALUES (2, 'Администратор', 'admin'),
       (3, 'Преподаватель', 'teacher'),
       (4, 'Студент', 'student');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `academicdegree`
--
ALTER TABLE `academicdegree`
    ADD PRIMARY KEY (`AD_id`),
    ADD UNIQUE KEY `AD_name_UNIQUE` (`AD_name`);

--
-- Индексы таблицы `academicgroups`
--
ALTER TABLE `academicgroups`
    ADD PRIMARY KEY (`AG_Code`),
    ADD UNIQUE KEY `groupsCode_UNIQUE` (`AG_Code`),
    ADD UNIQUE KEY `AG_Headman_UNIQUE` (`AG_Headman`),
    ADD KEY `SpectialtyID_idx` (`AG_specialty`),
    ADD KEY `CuratorID_idx` (`AG_Curator`),
    ADD KEY `Headman_idx` (`AG_Headman`),
    ADD KEY `FormatOfStudy_idx` (`AG_FormOfStudy`);

--
-- Индексы таблицы `academictitle`
--
ALTER TABLE `academictitle`
    ADD PRIMARY KEY (`AT_id`),
    ADD UNIQUE KEY `AT_name_UNIQUE` (`AT_name`);

--
-- Индексы таблицы `accauntactivation`
--
ALTER TABLE `accauntactivation`
    ADD PRIMARY KEY (`AA_UserID`, `AA_ActivationCodeHash`),
    ADD UNIQUE KEY `AA_UserID_UNIQUE` (`AA_UserID`),
    ADD UNIQUE KEY `AA_ActivationCodeHash_UNIQUE` (`AA_ActivationCodeHash`);

--
-- Индексы таблицы `attendancelesson`
--
ALTER TABLE `attendancelesson`
    ADD PRIMARY KEY (`AL_LessonInfo_id`, `AL_Student_id`),
    ADD KEY `FK_Student_id_idx` (`AL_Student_id`);

--
-- Индексы таблицы `departments`
--
ALTER TABLE `departments`
    ADD PRIMARY KEY (`DEP_id`),
    ADD UNIQUE KEY `DEP_Name_UNIQUE` (`DEP_Name`),
    ADD KEY `Faculty_idx` (`DEP_Faculty_id`),
    ADD KEY `HeadTeacher_idx` (`DEP_Head_id`);

--
-- Индексы таблицы `discipline`
--
ALTER TABLE `discipline`
    ADD PRIMARY KEY (`DISC_id`),
    ADD UNIQUE KEY `DISC_name_UNIQUE` (`DISC_name`),
    ADD KEY `LeadTeacher_idx` (`DISC_LeadTeacher_id`);

--
-- Индексы таблицы `faculties`
--
ALTER TABLE `faculties`
    ADD PRIMARY KEY (`FCT_id`),
    ADD UNIQUE KEY `FCT_name_UNIQUE` (`FCT_name`),
    ADD KEY `TeacherDean_idx` (`FCT_Dean`);

--
-- Индексы таблицы `formatofstudy`
--
ALTER TABLE `formatofstudy`
    ADD PRIMARY KEY (`FOS_id`),
    ADD UNIQUE KEY `FOS_Name_UNIQUE` (`FOS_Name`);

--
-- Индексы таблицы `formofcontrol`
--
ALTER TABLE `formofcontrol`
    ADD PRIMARY KEY (`FOC_Abbreviation`),
    ADD UNIQUE KEY `FOC_Abbreviation_UNIQUE` (`FOC_Abbreviation`),
    ADD UNIQUE KEY `FOC_Name_UNIQUE` (`FOC_Name`);

--
-- Индексы таблицы `lessoninfo`
--
ALTER TABLE `lessoninfo`
    ADD PRIMARY KEY (`LI_date`, `StudyLoad_id`, `LI_LessonNumber_id`),
    ADD UNIQUE KEY `LI_id_UNIQUE` (`LI_id`),
    ADD KEY `FK_LessonNumer_idx` (`LI_LessonNumber_id`),
    ADD KEY `FK_StudyLoad_idx` (`StudyLoad_id`);

--
-- Индексы таблицы `lessonnumber`
--
ALTER TABLE `lessonnumber`
    ADD PRIMARY KEY (`LN_Number`, `LN_StartTime`, `LN_EndTime`),
    ADD UNIQUE KEY `LN_Number_UNIQUE` (`LN_Number`),
    ADD UNIQUE KEY `LN_StartTime_UNIQUE` (`LN_StartTime`),
    ADD UNIQUE KEY `LN_EndTime_UNIQUE` (`LN_EndTime`);

--
-- Индексы таблицы `specialtylist`
--
ALTER TABLE `specialtylist`
    ADD PRIMARY KEY (`SL_id`),
    ADD UNIQUE KEY `SP_Code_UNIQUE` (`SL_Code`),
    ADD KEY `SpecialtyProfiles_idx` (`SL_Profile_id`),
    ADD KEY `FacultyID_idx` (`SL_Faculty_id`);

--
-- Индексы таблицы `specialtyprofile`
--
ALTER TABLE `specialtyprofile`
    ADD PRIMARY KEY (`SProf_id`);

--
-- Индексы таблицы `studentlistinsubgroups`
--
ALTER TABLE `studentlistinsubgroups`
    ADD PRIMARY KEY (`SLS_SubGroups_id`, `SLS_Student_id`),
    ADD KEY `SP_id_idx` (`SLS_Student_id`);

--
-- Индексы таблицы `studentprofile`
--
ALTER TABLE `studentprofile`
    ADD PRIMARY KEY (`SP_id`),
    ADD UNIQUE KEY `SP_NumberOfBook_UNIQUE` (`SP_NumberOfBook`),
    ADD KEY `AcademGroup_id_idx` (`SP_AcademGroup_id`);

--
-- Индексы таблицы `studyload`
--
ALTER TABLE `studyload`
    ADD PRIMARY KEY (`SL_Id`, `SL_DISC_id`, `SL_TypeLesson_code`, `SL_Teacher_id`, `SL_AcademGroup_code`),
    ADD UNIQUE KEY `SL_Id_UNIQUE` (`SL_Id`),
    ADD KEY `DISC_id_idx` (`SL_DISC_id`),
    ADD KEY `SL_AcademGroup_idx` (`SL_AcademGroup_code`),
    ADD KEY `Teacher_idx` (`SL_Teacher_id`),
    ADD KEY `TypeLesson_idx` (`SL_TypeLesson_code`),
    ADD KEY `FOC_ID_idx` (`SL_FormControl_id`);

--
-- Индексы таблицы `subgroups`
--
ALTER TABLE `subgroups`
    ADD PRIMARY KEY (`SG_StudyLoad_id`, `SG_Numbers`),
    ADD UNIQUE KEY `SG_id_UNIQUE` (`SG_id`);

--
-- Индексы таблицы `teacherprofile`
--
ALTER TABLE `teacherprofile`
    ADD PRIMARY KEY (`TP_UserID`),
    ADD UNIQUE KEY `TP_login_UNIQUE` (`TP_UserID`),
    ADD KEY `AcademicDegree_idx` (`TP_Degree`),
    ADD KEY `AcademicTitle_idx` (`TP_AcademicTitle`),
    ADD KEY `Departament_idx` (`TP_Department`);

--
-- Индексы таблицы `typelesson`
--
ALTER TABLE `typelesson`
    ADD PRIMARY KEY (`TL_id`),
    ADD UNIQUE KEY `TL_id_UNIQUE` (`TL_id`),
    ADD UNIQUE KEY `TL_Name_UNIQUE` (`TL_Name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`User_id`),
    ADD UNIQUE KEY `User_email_UNIQUE` (`User_email`),
    ADD UNIQUE KEY `User_login_UNIQUE` (`User_login`),
    ADD KEY `Role_idx` (`User_Role`);

--
-- Индексы таблицы `usersrole`
--
ALTER TABLE `usersrole`
    ADD PRIMARY KEY (`UR_id`),
    ADD UNIQUE KEY `UR_name_UNIQUE` (`UR_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `academicdegree`
--
ALTER TABLE `academicdegree`
    MODIFY `AD_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT для таблицы `academictitle`
--
ALTER TABLE `academictitle`
    MODIFY `AT_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT для таблицы `departments`
--
ALTER TABLE `departments`
    MODIFY `DEP_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT для таблицы `discipline`
--
ALTER TABLE `discipline`
    MODIFY `DISC_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ИД дисциплины',
    AUTO_INCREMENT = 66;

--
-- AUTO_INCREMENT для таблицы `faculties`
--
ALTER TABLE `faculties`
    MODIFY `FCT_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT для таблицы `formatofstudy`
--
ALTER TABLE `formatofstudy`
    MODIFY `FOS_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT для таблицы `lessoninfo`
--
ALTER TABLE `lessoninfo`
    MODIFY `LI_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид занятия',
    AUTO_INCREMENT = 154;

--
-- AUTO_INCREMENT для таблицы `specialtylist`
--
ALTER TABLE `specialtylist`
    MODIFY `SL_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT для таблицы `specialtyprofile`
--
ALTER TABLE `specialtyprofile`
    MODIFY `SProf_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT для таблицы `studyload`
--
ALTER TABLE `studyload`
    MODIFY `SL_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ИД учебной нагрузки',
    AUTO_INCREMENT = 57;

--
-- AUTO_INCREMENT для таблицы `subgroups`
--
ALTER TABLE `subgroups`
    MODIFY `SG_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID подгруппы',
    AUTO_INCREMENT = 111;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
    MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 100;

--
-- AUTO_INCREMENT для таблицы `usersrole`
--
ALTER TABLE `usersrole`
    MODIFY `UR_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ИД Роли',
    AUTO_INCREMENT = 5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `academicgroups`
--
ALTER TABLE `academicgroups`
    ADD CONSTRAINT `CuratorID` FOREIGN KEY (`AG_Curator`) REFERENCES `teacherprofile` (`TP_UserID`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `FormatOfStudy` FOREIGN KEY (`AG_FormOfStudy`) REFERENCES `formatofstudy` (`FOS_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `Headman` FOREIGN KEY (`AG_Headman`) REFERENCES `studentprofile` (`SP_id`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `SpectialtyID` FOREIGN KEY (`AG_specialty`) REFERENCES `specialtylist` (`SL_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `accauntactivation`
--
ALTER TABLE `accauntactivation`
    ADD CONSTRAINT `uID` FOREIGN KEY (`AA_UserID`) REFERENCES `users` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `attendancelesson`
--
ALTER TABLE `attendancelesson`
    ADD CONSTRAINT `FK_LessonInfo_id` FOREIGN KEY (`AL_LessonInfo_id`) REFERENCES `lessoninfo` (`LI_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_Student_id` FOREIGN KEY (`AL_Student_id`) REFERENCES `studentprofile` (`SP_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `departments`
--
ALTER TABLE `departments`
    ADD CONSTRAINT `Faculty` FOREIGN KEY (`DEP_Faculty_id`) REFERENCES `faculties` (`FCT_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `HeadTeacher` FOREIGN KEY (`DEP_Head_id`) REFERENCES `teacherprofile` (`TP_UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `discipline`
--
ALTER TABLE `discipline`
    ADD CONSTRAINT `LeadTeacher` FOREIGN KEY (`DISC_LeadTeacher_id`) REFERENCES `teacherprofile` (`TP_UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `faculties`
--
ALTER TABLE `faculties`
    ADD CONSTRAINT `TeacherDean` FOREIGN KEY (`FCT_Dean`) REFERENCES `teacherprofile` (`TP_UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `lessoninfo`
--
ALTER TABLE `lessoninfo`
    ADD CONSTRAINT `FK_LessonNumer` FOREIGN KEY (`LI_LessonNumber_id`) REFERENCES `lessonnumber` (`LN_Number`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_StudyLoad` FOREIGN KEY (`StudyLoad_id`) REFERENCES `studyload` (`SL_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `specialtylist`
--
ALTER TABLE `specialtylist`
    ADD CONSTRAINT `FacultyID` FOREIGN KEY (`SL_Faculty_id`) REFERENCES `faculties` (`FCT_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `SpecialtyProfiles` FOREIGN KEY (`SL_Profile_id`) REFERENCES `specialtyprofile` (`SProf_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `studentlistinsubgroups`
--
ALTER TABLE `studentlistinsubgroups`
    ADD CONSTRAINT `StudentP_id` FOREIGN KEY (`SLS_Student_id`) REFERENCES `studentprofile` (`SP_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `SubG_id` FOREIGN KEY (`SLS_SubGroups_id`) REFERENCES `subgroups` (`SG_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `studentprofile`
--
ALTER TABLE `studentprofile`
    ADD CONSTRAINT `AcademGroup_id` FOREIGN KEY (`SP_AcademGroup_id`) REFERENCES `academicgroups` (`AG_Code`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `UserID` FOREIGN KEY (`SP_id`) REFERENCES `users` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `studyload`
--
ALTER TABLE `studyload`
    ADD CONSTRAINT `DISC_id` FOREIGN KEY (`SL_DISC_id`) REFERENCES `discipline` (`DISC_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FOC_ID` FOREIGN KEY (`SL_FormControl_id`) REFERENCES `formofcontrol` (`FOC_Abbreviation`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `SL_AcademGroup` FOREIGN KEY (`SL_AcademGroup_code`) REFERENCES `academicgroups` (`AG_Code`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Teacher` FOREIGN KEY (`SL_Teacher_id`) REFERENCES `teacherprofile` (`TP_UserID`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `TypeLesson` FOREIGN KEY (`SL_TypeLesson_code`) REFERENCES `typelesson` (`TL_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subgroups`
--
ALTER TABLE `subgroups`
    ADD CONSTRAINT `StudyLoad_id` FOREIGN KEY (`SG_StudyLoad_id`) REFERENCES `studyload` (`SL_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teacherprofile`
--
ALTER TABLE `teacherprofile`
    ADD CONSTRAINT `AcademicDegree` FOREIGN KEY (`TP_Degree`) REFERENCES `academicdegree` (`AD_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `AcademicTitle` FOREIGN KEY (`TP_AcademicTitle`) REFERENCES `academictitle` (`AT_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
    ADD CONSTRAINT `Departament` FOREIGN KEY (`TP_Department`) REFERENCES `departments` (`DEP_id`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `Login` FOREIGN KEY (`TP_UserID`) REFERENCES `users` (`User_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `Role` FOREIGN KEY (`User_Role`) REFERENCES `usersrole` (`UR_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;


--
-- Метаданные
--
USE `phpmyadmin`;

--
-- Метаданные для таблицы academicdegree
--

--
-- Метаданные для таблицы academicgroups
--

--
-- Метаданные для таблицы academictitle
--

--
-- Метаданные для таблицы accauntactivation
--

--
-- Метаданные для таблицы attendancelesson
--

--
-- Метаданные для таблицы departments
--

--
-- Метаданные для таблицы discipline
--

--
-- Метаданные для таблицы faculties
--

--
-- Метаданные для таблицы formatofstudy
--

--
-- Метаданные для таблицы formofcontrol
--

--
-- Метаданные для таблицы lessoninfo
--

--
-- Дамп данных таблицы `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`)
VALUES ('Admin', 'jagu', 'lessoninfo', '{\"sorted_col\":\"`lessoninfo`.`LI_id` ASC\"}', '2021-05-17 17:17:01');

--
-- Метаданные для таблицы lessonnumber
--

--
-- Метаданные для таблицы specialtylist
--

--
-- Метаданные для таблицы specialtyprofile
--

--
-- Метаданные для таблицы studentlistinsubgroups
--

--
-- Дамп данных таблицы `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`)
VALUES ('Admin', 'jagu', 'studentlistinsubgroups',
        '{\"sorted_col\":\"`studentlistinsubgroups`.`SLS_SubGroups_id` ASC\"}', '2021-04-13 16:47:57');

--
-- Метаданные для таблицы studentprofile
--

--
-- Метаданные для таблицы studyload
--

--
-- Дамп данных таблицы `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`)
VALUES ('Admin', 'jagu', 'studyload',
        '{\"sorted_col\":\"`SL_AcademGroup_code` ASC\",\"CREATE_TIME\":\"2021-04-25 00:34:26\"}',
        '2021-05-17 14:07:50');

--
-- Метаданные для таблицы subgroups
--

--
-- Метаданные для таблицы teacherprofile
--

--
-- Дамп данных таблицы `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`)
VALUES ('Admin', 'jagu', 'teacherprofile',
        '{\"CREATE_TIME\":\"2021-04-08 02:23:34\",\"col_order\":[0,1,2,3,4,5,6,7,9,8],\"col_visib\":[1,1,1,1,1,1,1,1,1,1]}',
        '2021-04-13 17:18:20');

/*
 * Copyright (c) 2021. Kulikov K. P. [kostj1998.10.13@yandex.ru]
 */

--
-- Метаданные для таблицы typelesson
--

--
-- Метаданные для таблицы users
--

--
-- Метаданные для таблицы usersrole
--

--
-- Метаданные для базы данных jagu
--

--
-- Дамп данных таблицы `pma__bookmark`
--

INSERT INTO `pma__bookmark` (`dbase`, `user`, `label`, `query`)
VALUES ('jagu', 'Admin', 'Тест',
        'SELECT\r\n       DATE_FORMAT(li.LI_date, \'%d.%m.%y\') as \'Дата\',\r\n      CONCAT(DATE_FORMAT(l.LN_StartTime, \'%H:%i\'), \'-\',\r\n        DATE_FORMAT(l.LN_EndTime, \'%H:%i\')) AS \'Часы занятий\',\r\n       f.FCT_Abbreviation As \'Факультет\',\r\n       a.AG_NumCuorse as \'Курс\', li.LI_AcademGroup_code as \'Группа\',\r\n       li.LI_LessonTopic as \'Содержание занятий\', li.LI_TypeLesson_id\r\n\r\nfrom lessoninfo li\r\njoin lessonnumber l on li.LI_LessonNumber_id = l.LN_Number\r\njoin academicgroups a on li.LI_AcademGroup_code = a.AG_Code\r\njoin specialtylist s on a.AG_specialty = s.SL_id\r\njoin faculties f on s.SL_Faculty_id = f.FCT_id\r\njoin teacherprofile t on li.LI_Teacher = t.TP_UserID\r\nwhere t.TP_Surname=\'Архипов\';');

--
-- Дамп данных таблицы `pma__pdf_pages`
--

INSERT INTO `pma__pdf_pages` (`db_name`, `page_descr`)
VALUES ('jagu', 'jagu');

SET @LAST_PAGE = LAST_INSERT_ID();

--
-- Дамп данных таблицы `pma__table_coords`
--

INSERT INTO `pma__table_coords` (`db_name`, `table_name`, `pdf_page_number`, `x`, `y`)
VALUES ('jagu', 'academicdegree', @LAST_PAGE, 110, 722),
       ('jagu', 'academicgroups', @LAST_PAGE, 322, 586),
       ('jagu', 'academictitle', @LAST_PAGE, 47, 25),
       ('jagu', 'accauntactivation', @LAST_PAGE, 1238, 160),
       ('jagu', 'attendancelesson', @LAST_PAGE, 536, 370),
       ('jagu', 'departments', @LAST_PAGE, 280, 360),
       ('jagu', 'discipline', @LAST_PAGE, 1015, 261),
       ('jagu', 'disciplineformcontrol', @LAST_PAGE, 1114, 598),
       ('jagu', 'faculties', @LAST_PAGE, 262, 8),
       ('jagu', 'formatofstudy', @LAST_PAGE, 1049, 449),
       ('jagu', 'formofcontrol', @LAST_PAGE, 780, 251),
       ('jagu', 'lessoninfo', @LAST_PAGE, 509, 14),
       ('jagu', 'lessonnumber', @LAST_PAGE, 283, 192),
       ('jagu', 'specialtylist', @LAST_PAGE, 783, 367),
       ('jagu', 'specialtyprofile', @LAST_PAGE, 799, 8),
       ('jagu', 'studentlistinsubgroups', @LAST_PAGE, 1155, 746),
       ('jagu', 'studentprofile', @LAST_PAGE, 569, 584),
       ('jagu', 'studyload', @LAST_PAGE, 862, 606),
       ('jagu', 'subgroups', @LAST_PAGE, 48, 195),
       ('jagu', 'teacherprofile', @LAST_PAGE, 58, 373),
       ('jagu', 'typelesson', @LAST_PAGE, 806, 130),
       ('jagu', 'users', @LAST_PAGE, 991, 9),
       ('jagu', 'usersrole', @LAST_PAGE, 1209, 13);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
