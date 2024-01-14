-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mariadb
-- Время создания: Янв 14 2024 г., 18:52
-- Версия сервера: 10.11.6-MariaDB-1:10.11.6+maria~ubu2204
-- Версия PHP: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(45, '2014_10_12_000000_create_users_table', 1),
(46, '2014_10_12_100000_create_password_resets_table', 1),
(47, '2019_08_19_000000_create_failed_jobs_table', 1),
(48, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(49, '2024_01_13_195559_create_projects_table', 1),
(50, '2024_01_13_195611_create_tasks_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `description` text DEFAULT NULL COMMENT 'Описание',
  `create_user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Создавший пользователь',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `create_user_id`, `created_at`, `updated_at`) VALUES
(1, 'Проекты/Задачи', 'Реализация пользовательского интерфейса. В рамках задачи реализуется процесс авторизации и регистрации, а также административная панель сервиса.', 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(2, 'Статистика', 'Реализация раздела статистика. В рамках задачи реализуется процесс подсчета данных по выполненным задачам', 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(3, 'Тест', 'Тестирования сервиса', 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(4, 'Наполнение сервиса', 'Наполнения тестовых данных сервиса ', 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `description` text DEFAULT NULL COMMENT 'Описание',
  `start` datetime DEFAULT NULL COMMENT 'Время начала выполнения',
  `end` datetime DEFAULT NULL COMMENT 'Время конца выполнения',
  `state` int(11) NOT NULL DEFAULT 1 COMMENT 'Состояние',
  `create_user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Создавший пользователь',
  `make_user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Выполняет пользователь',
  `project_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Относится к проекту',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `start`, `end`, `state`, `create_user_id`, `make_user_id`, `project_id`, `created_at`, `updated_at`) VALUES
(1, 'Авторизация/Регистрация', 'В рамках задачи реализуется процес авторизации и регистрации', '2024-01-13 12:01:36', '2024-01-13 15:01:36', 4, 1, 1, 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(2, 'Верстка и реализация административной панели сервиса', 'В рамках задачи реализуется верстка и основная работа компонентов административной панели', '2024-01-13 15:01:36', '2024-01-13 19:01:36', 4, 1, 1, 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(3, 'Реализация мобильного меню сервиса', 'В рамках задачи реализуется верстка мобильного меню сервиса', NULL, NULL, 1, 1, 1, 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(4, 'Реализация инкапсуляции vue компонентов для модальных окон ', 'В рамках задачи реализуется верстка мобильного меню сервиса', '2024-01-13 20:10:10', '2024-01-13 22:05:01', 4, 1, 1, 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(5, 'Мобильная адаптация Дашборда задач в разделе проектов', 'В рамках задачи необходимо реализовать мобильную адаптацию процесса переноса состояний задач', NULL, NULL, 1, 1, 1, 1, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(6, 'Базовая установка библиотеки для работы с графиком', 'В рамках задачи мы установили библиотеку для работы с графиком', '2024-01-14 12:01:36', '2024-01-14 13:02:36', 4, 1, 1, 2, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(7, 'Реализация сбора данных', 'В рамках задачи реализуется сбор данных для отрисовки графика', '2024-01-14 13:03:40', '2024-01-14 15:01:36', 4, 1, 1, 2, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(8, 'Проверка работы разделов сервиса', 'В рамках задачи мы проверяем Front and Back части сайта', '2024-01-14 12:01:36', '2024-01-14 13:02:36', 4, 1, 1, 3, '2024-01-14 18:45:49', '2024-01-14 18:45:49'),
(9, 'Написание команды для наполнения тестовыми данными сервиса', 'В рамках задачи необходимо написать seed файл для наполнения сервиса тестовыми данными', '2024-01-14 14:01:36', '2024-01-14 16:02:36', 4, 1, 1, 4, '2024-01-14 18:45:49', '2024-01-14 18:45:49');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@admin.ru', NULL, '$2y$10$nC/V1rkTIpsmeJmzcmlczusfCcS7QgzivDyiEUETPX36V9SGTIOQm', NULL, '2024-01-14 18:45:49', '2024-01-14 18:45:49');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_create_user_id_foreign` (`create_user_id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_create_user_id_foreign` (`create_user_id`),
  ADD KEY `tasks_make_user_id_foreign` (`make_user_id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_create_user_id_foreign` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_create_user_id_foreign` FOREIGN KEY (`create_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_make_user_id_foreign` FOREIGN KEY (`make_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
