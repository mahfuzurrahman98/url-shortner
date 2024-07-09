-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2024 at 07:17 PM
-- Server version: 8.0.37-0ubuntu0.22.04.3
-- PHP Version: 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `url_shortner`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_03_110838_create_shortens_table', 1),
(6, '2024_07_03_113625_add_new_column_to_shortens_table', 1),
(7, '2024_07_03_144419_change_column_constraints_of_shortens_table', 1),
(8, '2024_07_05_134534_change_column_name_shortens_table', 2),
(9, '2024_07_06_120950_make_hash_column_unique_and_6_chars_on_shortens_table', 3),
(10, '2024_07_09_154657_add_folder_column_to_shortens_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shortens`
--

CREATE TABLE `shortens` (
  `id` bigint UNSIGNED NOT NULL,
  `original_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `normalized_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shortens`
--

INSERT INTO `shortens` (`id`, `original_url`, `normalized_url`, `folder`, `hash`, `created_at`, `updated_at`) VALUES
(1, 'https://www.google.com', 'google.com', NULL, 'KDZx1b', '2024-07-06 05:37:12', '2024-07-06 05:37:12'),
(2, 'https://www.wikipedia.org/', 'wikipedia.org', NULL, 'qQ3wOu', '2024-07-06 05:37:20', '2024-07-06 05:37:20'),
(3, 'http://github.com', 'github.com', NULL, 'LxubtF', '2024-07-06 05:37:30', '2024-07-06 05:37:30'),
(4, 'https://stackoverflow.com/questions/41259319/php-check-website-url-using-safe-browsing-api', 'stackoverflow.com/questions/41259319/php-check-website-url-using-safe-browsing-api', NULL, 'LGA4s2', '2024-07-06 05:37:46', '2024-07-06 05:37:46'),
(5, 'https://www.youtube.com/watch?v=nCxnzj83poQ', 'youtube.com/watch?v=nCxnzj83poQ', NULL, '80youa', '2024-07-06 05:38:21', '2024-07-06 05:38:21'),
(6, 'https://www.freecodecamp.org/news/method-overloading-in-php/#:~:text=Method%20overloading%20is%20a%20concept,different%20output%20in%20different%20situations.', 'freecodecamp.org/news/method-overloading-in-php/#:~:text=Method%20overloading%20is%20a%20concept,different%20output%20in%20different%20situations.', NULL, 'wkKkkJ', '2024-07-06 05:38:49', '2024-07-06 05:38:49'),
(7, 'https://www.espncricinfo.com/series/major-league-cricket-2024-1432722/texas-super-kings-vs-los-angeles-knight-riders-2nd-match-1432727/full-scorecard', 'espncricinfo.com/series/major-league-cricket-2024-1432722/texas-super-kings-vs-los-angeles-knight-riders-2nd-match-1432727/full-scorecard', NULL, '9q7BAq', '2024-07-06 05:39:59', '2024-07-06 05:39:59'),
(8, 'https://www.w3schools.com/php/php_oop_traits.asp', 'w3schools.com/php/php_oop_traits.asp', NULL, 'HewKEA', '2024-07-06 05:40:28', '2024-07-06 05:40:28'),
(9, 'https://goku.sx/search?keyword=anaconda', 'goku.sx/search?keyword=anaconda', NULL, 'slIlpw', '2024-07-06 05:42:52', '2024-07-06 05:42:52'),
(10, 'https://mahfuzurrahman.hashnode.dev/understanding-design-patterns-unraveling-the-factory-pattern-in-java', 'mahfuzurrahman.hashnode.dev/understanding-design-patterns-unraveling-the-factory-pattern-in-java', 'blogs', 'KVkF32', '2024-07-09 12:49:57', '2024-07-09 12:49:57'),
(11, 'https://mahfuzurrahman.hashnode.dev/understanding-design-patterns-simplifying-singleton-with-a-database-class-example', 'mahfuzurrahman.hashnode.dev/understanding-design-patterns-simplifying-singleton-with-a-database-class-example', 'blogs', 'GhIIKC', '2024-07-09 12:50:23', '2024-07-09 12:50:23'),
(12, 'https://mahfuzurrahman.hashnode.dev/understanding-design-patterns-a-beginners-guide', 'mahfuzurrahman.hashnode.dev/understanding-design-patterns-a-beginners-guide', 'blogs', 'kNh0q5', '2024-07-09 12:50:41', '2024-07-09 12:50:41'),
(13, 'https://www.youtube.com/watch?v=eUNWzJUvkCA', 'youtube.com/watch?v=eUNWzJUvkCA', 'laravel', 'wFc4q9', '2024-07-09 12:52:06', '2024-07-09 12:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `shortens`
--
ALTER TABLE `shortens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shortens_hash_unique` (`hash`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shortens`
--
ALTER TABLE `shortens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;