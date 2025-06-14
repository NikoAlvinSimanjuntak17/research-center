-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2025 at 06:31 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `researchbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `researcher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expertise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_leader` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `key`, `title`, `value`, `image`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Email', 'Email HRD', 'HRD@gmail.com', 'contacts/684cf62226f07.jpg', 1, 1, 1, '2025-06-13 19:20:52', '2025-06-14 04:10:10'),
(2, 'phone', 'No WA TSTH', '085261591160', NULL, 1, NULL, 1, '2025-06-13 19:21:31', '2025-06-13 19:21:31'),
(3, 'Instagram', 'Instagram TSTH', 'link', NULL, 1, NULL, 1, '2025-06-13 20:23:51', '2025-06-13 20:23:51'),
(4, 'Pinterst', 'Pinterst', 'link', NULL, 1, NULL, 1, '2025-06-13 20:24:24', '2025-06-13 20:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `institution_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Dosen', '2025-06-12 07:02:05', '2025-06-12 07:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `description`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Kunjungan Indsutri', '<p>Dokumentasi kegiatan praktikum dan riset yang dilakukan di laboratorium riset teknologi dan sains.</p>', 1, 1, 1, '2025-06-12 07:11:44', '2025-06-13 04:24:57'),
(2, 'Seminar Nasional', '<p>Foto-foto suasana seminar nasional bertema \"Inovasi dan Teknologi Masa Depan\" yang diselenggarakan tahun 2025.</p>', 1, NULL, 1, '2025-06-12 07:12:00', '2025-06-12 07:12:00'),
(3, 'Area Lingkungan Industri', '<p>Dokumentasi kunjungan tim peneliti ke berbagai mitra industri dalam rangka penjajakan kerja sama penelitian.</p>', 1, 1, 1, '2025-06-12 07:12:23', '2025-06-13 04:24:46'),
(4, 'Kegiatan Laboratorium', '<p>Dokumentasi kegiatan praktikum dan riset yang dilakukan di laboratorium riset teknologi dan sains.</p>', 1, NULL, 1, '2025-06-13 04:39:25', '2025-06-13 04:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_files`
--

CREATE TABLE `gallery_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_files`
--

INSERT INTO `gallery_files` (`id`, `image`, `gallery_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'gallery_images/RW9tvDFRUNvX8nz7NMES72oXo79CzsdlkHBokOI0.jpg', 1, 1, 1, '2025-06-12 07:12:55', '2025-06-13 04:22:09'),
(2, 'gallery_images/lhjOVILAMh5FCF6hu2go6iYVe0IqIpB4z1OxAHBp.jpeg', 1, 1, 1, '2025-06-12 07:13:06', '2025-06-13 04:16:55'),
(3, 'gallery_images/Jl41QjdWMBUlB13E6XesK1NbuzzfwP6smrhcOn0M.png', 3, 1, 1, '2025-06-12 07:13:14', '2025-06-12 07:13:14'),
(4, 'gallery_images/MyyT31Py0zA8ntdWkhrWk9tMCTymRfTrxOp9x92V.jpg', 2, 1, 1, '2025-06-12 07:13:28', '2025-06-12 07:13:28'),
(5, 'gallery_images/FQOzkc6QHYcEa4bJKCTwJ2USLlzseJWPKdgpoYrr.jpeg', 1, 1, 1, '2025-06-12 07:13:41', '2025-06-13 04:22:45'),
(6, 'gallery_images/7KVPKvozVQNwGDLee4zya2VRNyc72SjOXRjiHNEp.jpg', 3, 1, 1, '2025-06-12 07:13:50', '2025-06-12 07:13:50'),
(7, 'gallery_images/EczTmLPHgGBuHUd6zRqoYDYlEJxsmEKNEWnvoEM7.jpg', 3, 1, 1, '2025-06-12 07:14:04', '2025-06-12 07:14:04'),
(8, 'gallery_images/atk6onpZYzZobEGPze3Ui4vjcB4e4axam43A5F8e.jpg', 2, 1, 1, '2025-06-12 07:14:17', '2025-06-12 07:14:17'),
(9, 'gallery_images/y84wTvoGbkyUtFEIUdQtzXLftop4jJo9wpkkPSCU.png', 2, 1, 1, '2025-06-12 07:14:30', '2025-06-12 07:14:30'),
(10, 'gallery_images/dARCusUSXyHtsl1JsvROZlBsuIotsMUUK2m7HyYS.jpg', 3, 1, 1, '2025-06-12 07:14:52', '2025-06-12 07:14:52'),
(11, 'gallery_images/1749825127_labo.jpg', 4, 1, 1, '2025-06-13 04:39:48', '2025-06-13 14:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `institutions`
--

INSERT INTO `institutions` (`id`, `name`, `address`, `website`, `created_at`, `updated_at`) VALUES
(1, 'Institut Teknologi Del', 'Institut Teknologi Del, Sitoluama, Kec. Balige, Toba, Sumatera Utara 22381', 'https://www.del.ac.id/', '2025-06-12 07:01:48', '2025-06-12 07:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_03_15_012244_create_institutions_table', 1),
(6, '2025_03_16_012309_create_departments_table', 1),
(7, '2025_03_18_153036_create_researchers_table', 1),
(8, '2025_03_19_064415_create_projects_table', 1),
(9, '2025_04_09_081447_create_publications_table', 1),
(10, '2025_04_11_132906_create_histories_table', 1),
(11, '2025_04_11_132937_create_vision_missions_table', 1),
(12, '2025_04_17_070316_laratrust_setup_tables', 1),
(13, '2025_04_18_042933_create_structure__organizations_table', 1),
(14, '2025_05_01_135610_create_collaborators_table', 1),
(15, '2025_05_01_164343_create_galleries_table', 1),
(16, '2025_05_13_015054_create_publication_researcher_table', 1),
(17, '2025_06_10_080202_create_news_categories_table', 1),
(18, '2025_06_11_131719_create_news_table', 1),
(19, '2025_06_11_205739_create_profiles_table', 1),
(20, '2025_06_12_010027_create_gallery_files_table', 1),
(22, '2025_06_12_143108_create_sliders_table', 2),
(23, '2025_06_12_145408_create_contacts_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image`, `news_category_id`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Seminar Nasional Inovasi Riset 2025', '<p>Kegiatan seminar nasional membahas hasil-hasil riset terbaru dari berbagai bidang keilmuan yang diselenggarakan oleh pusat riset.<br><strong>Tanggal:</strong> 5 Juni 2025</p>', 'news_images/XyojQYIHAibpjCMAPcxN7dN7XIQBPFB9bqtrrnuy.png', 1, NULL, NULL, 1, '2025-06-12 07:05:35', '2025-06-12 07:05:35'),
(2, 'Peluncuran Program Hibah Riset Tahun 2025', '<p>Program hibah riset resmi dibuka dengan total dana sebesar 2 miliar untuk mendorong inovasi di perguruan tinggi.<br><strong>Tanggal:</strong> 22 Mei 2025</p>', 'news_images/7X8LvF5SDpIFR907PdGkBZrNnYYhSrqV59N8wc20.png', 1, NULL, NULL, 1, '2025-06-12 07:06:06', '2025-06-12 07:06:06'),
(3, 'Workshop Penulisan Jurnal Internasional', '<p>Workshop ini ditujukan bagi dosen dan peneliti muda untuk meningkatkan publikasi di jurnal bereputasi.<br><strong>Tanggal:</strong> 12 April 2025</p>', 'news_images/be9wVmOkG7crLBb8pV8U2Dy08mP3ATUWyagrDg38.jpg', 1, NULL, NULL, 1, '2025-06-12 07:06:35', '2025-06-12 07:06:35'),
(4, 'MoU Riset Bersama dengan Universitas Tokyo', '<p>Penandatanganan kerja sama riset dalam bidang teknologi hijau dan kecerdasan buatan dengan Universitas Tokyo.<br><strong>Tanggal:</strong> 1 Maret 2025</p>', 'news_images/m5m2XiWMaR1t1BP5PgtXAmz5Yw1BkWYX3BeEofFR.png', 2, NULL, NULL, 1, '2025-06-12 07:07:19', '2025-06-12 07:07:19'),
(5, 'Kunjungan Delegasi Riset dari Jerman', '<p>Delegasi dari DAAD melakukan kunjungan kerja untuk menjajaki peluang kolaborasi penelitian bilateral.<br><strong>Tanggal:</strong> 16 Februari 2025</p>', 'news_images/fhbrtfB8vs4Se7XD8JpTuGZ5FivaFKGtVEHFPoSc.png', 2, NULL, NULL, 1, '2025-06-12 07:07:46', '2025-06-12 07:07:46'),
(6, 'Konsorsium Riset ASEAN Resmi Dibentuk', '<p>Indonesia menjadi tuan rumah pembentukan konsorsium riset se-ASEAN untuk penguatan riset regional.<br><strong>Tanggal:</strong> 25 Januari 2025</p>', 'news_images/yeogRZnwzEKLauCAJOvbSAVXfw5fWXzAsNnvO44U.jpg', 2, NULL, NULL, 1, '2025-06-12 07:08:15', '2025-06-12 07:08:15'),
(7, 'Peneliti Muda Raih Penghargaan Internasional', '<p>Dr. Ayu Larasati memenangkan penghargaan “Young Researcher of the Year” dari lembaga riset Asia.<br><strong>Tanggal:</strong> 30 Mei 2025</p>', 'news_images/1ZYklEZ1EW3b0Ld68rovVKMALfv4z4dPsAXxDzlG.png', 3, NULL, NULL, 1, '2025-06-12 07:08:43', '2025-06-12 07:08:43'),
(8, 'Artikel Penelitian Masuk Jurnal Q1 Isi: Publikasi berjudul “Smart Farming in Indonesia” berhasil diterbitkan di jurnal Q1 ScienceDirect. Tanggal: 10 April 2025', '<p>Isi: Publikasi berjudul “Smart Farming in Indonesia” berhasil diterbitkan di jurnal Q1 ScienceDirect. Tanggal: 10 April 2025</p><p>&nbsp;</p>', 'news_images/DqrKwfGLHD3AcHm8MOdcV3qSkEmcZqwFIUTv5W8b.jpg', 2, NULL, NULL, 1, '2025-06-12 07:09:48', '2025-06-12 07:09:48'),
(9, 'Lembaga Riset Terakreditasi A', '<p>Lembaga resmi mendapatkan akreditasi A dari Badan Akreditasi Nasional sebagai pengakuan atas mutu penelitian.<br><strong>Tanggal:</strong> 20 Maret 2025</p>', 'news_images/si3MdqyySmwnlIXiAVyiZvKh0hcCBiS0Ki76aLKg.jpg', 3, NULL, NULL, 1, '2025-06-12 07:10:26', '2025-06-12 07:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `news_categories`
--

CREATE TABLE `news_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Kegiatan Penelitian', 1, NULL, 1, '2025-06-12 07:03:52', '2025-06-12 07:03:52'),
(2, 'Kolaborasi dan Kerjasama', 1, NULL, 1, '2025-06-12 07:04:08', '2025-06-12 07:04:08'),
(3, 'Prestasi dan Penghargaan', 1, NULL, 1, '2025-06-12 07:04:26', '2025-06-12 07:04:26');

-- --------------------------------------------------------

--
-- Table structure for table `organization_structures`
--

CREATE TABLE `organization_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create researcher', 'Create Researcher', 'Dapat menambah akun peneliti', '2025-06-12 06:12:05', '2025-06-12 06:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_user`
--

INSERT INTO `permission_user` (`permission_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\Models\\User');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `key`, `title`, `description`, `image`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(11, 'Organisasi', 'Struktur Organisasi 1', '<p style=\"text-align:justify;\">Struktur organisasi Pusat Riset terdiri dari Kepala Pusat, Sekretaris, serta Koordinator Bidang Data dan Publikasi. Pembagian ini bertujuan untuk memastikan alur kerja yang efisien dan kolaboratif antar tim.</p>', 'profiles/SbIz1KlaCJebgnWCBZ9qMceN1uAMFMCwqsuD05tq.jpg', 1, 1, 1, '2025-06-12 06:47:51', '2025-06-12 06:50:23'),
(12, 'Organisasi', 'Struktur Organisasi 2', '<p style=\"text-align:justify;\">Organisasi terbagi menjadi empat divisi utama: Penelitian Sosial, Inovasi Teknologi, Manajemen Data, dan Humas. Masing-masing divisi dipimpin oleh seorang koordinator yang bertanggung jawab langsung kepada Kepala Pusat.</p>', 'profiles/NDy8JtD2uKtgg9U5O3tbtHWiCA8ZwOAMsTzsJbPm.jpg', 1, 1, 1, '2025-06-12 06:50:50', '2025-06-12 06:50:50'),
(13, 'Organisasi', 'Struktur Organisasi 3', '<p style=\"text-align:justify;\">Struktur terbaru menambahkan satu bidang baru yaitu Bidang Kerja Sama Internasional, guna memperluas jejaring dan peluang kolaborasi global. Pembaruan ini merupakan bagian dari strategi pengembangan lima tahunan.</p>', 'profiles/HAhia3bVoq0C1qjeK35lTe7hZgDdO8ks0Tc9madK.jpg', 1, 1, 1, '2025-06-12 06:52:18', '2025-06-12 06:52:18'),
(14, 'Sejarah', 'Sejarah Singkat Pendirian', '<p style=\"text-align:justify;\"><span style=\"background-color:rgb(255,255,255);color:rgb(0,29,53);\">Taman Sains Teknologi Herbal dan Hortikultura (TSTH2) adalah sebuah pusat riset dan inovasi pengembangan tanaman herbal dan hortikultura yang berlokasi di Kecamatan Pollung, Kabupaten Humbang Hasundutan, Sumatera Utara. Pembangunannya dimulai pada tahun 2021 oleh Kementerian Pekerjaan Umum dan Perumahan Rakyat (PUPR). TSTH2 dirancang untuk menjadi pusat penelitian dan pengembangan tanaman herbal, termasuk hilirisasi produk herbal seperti kemenyan, kunyit, dan bunga telang.</span></p><p style=\"text-align:justify;\">&nbsp;</p><p><strong>Pembangunan</strong></p><p>Pembangunan TSTH2 dimulai pada tahun 2021 dan dilakukan secara bertahap oleh Balai Prasarana Permukiman Wilayah (BPPW) Sumatera Utara, Ditjen Cipta Karya, Kementerian PUPR.&nbsp;</p><p><strong>Lokasi</strong></p><p>TSTH2 berlokasi di dalam Kawasan Hutan Dengan Tujuan Khusus (KHDTK) di Kecamatan Pollung, Humbang Hasundutan.&nbsp;</p><p><strong>Tujuan</strong></p><p>TSTH2 bertujuan untuk menjadi pusat penelitian dan pengembangan tanaman herbal dan hortikultura, termasuk pengembangan bibit unggul dan hilirisasi produk herbal.&nbsp;</p><p><strong>Fokus</strong></p><p>TSTH2 fokus pada pengembangan tanaman herbal seperti kemenyan, kunyit, dan bunga telang untuk produk fungsional.&nbsp;</p><p><strong>Infrastruktur</strong></p><p>Pembangunan TSTH2 mencakup pembangunan infrastruktur pusat penelitian, pengembangan tanaman herbal, dan pengembangan pangan nasional.&nbsp;</p><p><strong>Pengembangan</strong></p><p>Selain pengembangan tanaman herbal, TSTH2 juga mengembangkan model pabrik bibit unggul untuk memperkuat daya saing komoditas herbal dan hortikultura Indonesia.&nbsp;</p>', 'profiles/ADv2fP0xhxqcu6qQIQJt2UC5VrHhg6PD2lAnRdQB.jpg', 1, 1, 1, '2025-06-12 06:53:11', '2025-06-14 03:19:23'),
(15, 'Sejarah', 'Perkembangan Lembaga', '<p style=\"text-align:justify;\">Sejak awal berdirinya, lembaga ini telah mengalami berbagai transformasi, mulai dari restrukturisasi internal hingga perluasan fokus riset. Tahun 2015 menjadi tonggak penting dengan integrasi ke dalam jaringan riset internasional.</p>', 'profiles/Zg44WOzxJ6bCeyZa0UER4lcGGuh8kXWsY4F5SjLJ.jpg', 1, 1, 1, '2025-06-12 06:53:40', '2025-06-12 06:53:40'),
(16, 'Sejarah', 'Latar Belakang dan Tujuan Awal', '<p style=\"text-align:justify;\">Didirikan sebagai respons terhadap kebutuhan peningkatan kualitas riset di Indonesia, pusat ini bertujuan menyediakan wadah bagi peneliti dari berbagai disiplin untuk berkolaborasi dan menghasilkan solusi inovatif bagi masyarakat.</p>', 'profiles/tKbOiiRWZqHQKT12F9uWq33ToDJVcUTt9sHSahMW.png', 1, 1, 1, '2025-06-12 06:54:08', '2025-06-12 06:54:08'),
(17, 'Visi Misi', 'Visi', '<p>Menjadi pusat unggulan dalam riset dan inovasi yang berkontribusi nyata bagi pembangunan nasional dan global.</p>', 'profiles/7Dez1PA9i5cygpFGDg1L1cP93TQMNRpvLaenuZMA.png', 1, 1, 1, '2025-06-12 06:55:15', '2025-06-12 06:55:15'),
(18, 'Visi Misi', 'Misi', '<ul style=\"list-style-type:square;\"><li>Meningkatkan riset yang berkualitas dan berdampak</li><li>meningkatkan kapasitas peneliti</li><li>menyebarluaskan hasi penelitian</li><li>Menjalin kemitraan</li></ul>', 'profiles/L7MiNC5OiMgZN4M4k4XKATjF6HWXOa1iftzBc8uy.png', 1, 1, 1, '2025-06-12 06:58:17', '2025-06-13 03:20:40'),
(21, 'About', 'Agricultural Research Center', '<p>TSTH2 adalah salah satu inisiatif Pemerintah sebagai pusat riset herbal hortikultura terdepan di Indonesia yang menghasilkan inovasi dan teknologi berdaya saing global, berkelanjutan dan berdampak sosial, dibawah KEMENDIKTISAINTEK yang tata kelolanya bekerjasama dengan Institut Teknologi Del. TSTH2 dibangun sejak 2021 (15 Ha), adalah bagian dari KHDTK Penelitian dan Pengembangan Kehutanan (500 Ha) di Kabupaten Humbang Hasundutan, Sumatera Utara. &nbsp;Presentasi ini membahas komitmen untuk mendorong riset dan inovasi sebagai instrumen strategis dalam pembangunan daerah, khususnya di sektor pertanian dan tanaman obat. Taman Sains Teknologi Herbal dan Hortikultura (TSTH2) diperkenalkan sebagai model pengembangan kawasan berbasis riset yang dapat diterapkan di propinsi masing-masing Tujuan utama adalah membuka ruang kolaborasi antara Pemerintah, Swasta&nbsp; baik di dalam dan luar negeri untuk mewujudkan sistem inovasi daerah yang berkelanjutan dan berdampak langsung pada kesejahteraan masyarakat.</p>', 'profiles/tsth.jpg', 1, 1, 1, '2025-06-12 07:17:03', '2025-06-12 07:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `open_at` timestamp NULL DEFAULT NULL,
  `close_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `leader_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `progress_status` enum('not_started','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_started',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `researcher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`authors`)),
  `raw_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citation_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publication_researcher`
--

CREATE TABLE `publication_researcher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `publication_id` bigint(20) UNSIGNED NOT NULL,
  `researcher_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `researchers`
--

CREATE TABLE `researchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `orcid_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopus_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `garuda_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googlescholar_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `citation_count` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bachelor_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `master_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doctor_degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experiences` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `researchers`
--

INSERT INTO `researchers` (`id`, `name`, `email`, `user_id`, `department_id`, `orcid_id`, `scopus_id`, `garuda_id`, `googlescholar_id`, `citation_count`, `image`, `created_by`, `updated_by`, `nip`, `bachelor_degree`, `master_degree`, `doctor_degree`, `experiences`, `active`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, 0, 'photos/1749867664_rudy.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-12 06:14:04', '2025-06-14 02:30:20'),
(2, NULL, NULL, 3, 1, NULL, NULL, NULL, NULL, 0, 'photos/1749867943_goklas.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-12 06:14:19', '2025-06-14 02:30:04'),
(3, NULL, NULL, 4, 1, NULL, NULL, NULL, NULL, 0, 'photos/1749867977_Tegar_Arifin_ITDel.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-06-12 06:14:39', '2025-06-14 02:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', 'Admin yang dapat mengelola sistem', '2025-06-12 06:12:05', '2025-06-12 06:12:05'),
(2, 'researcher', 'Researcher', 'Peneliti di platform', '2025-06-12 06:12:05', '2025-06-12 06:12:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(1, 1, 'App\\Models\\User'),
(2, 2, 'App\\Models\\User'),
(2, 3, 'App\\Models\\User'),
(2, 4, 'App\\Models\\User');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `description`, `image`, `created_by`, `updated_by`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Herbal Technology Research and Testing Center', 'Taman Sains Teknologi Herbal dan Hortikultura', 'sliders/peresmian.jpg', 1, NULL, 1, '2025-06-12 07:48:25', '2025-06-12 07:48:25'),
(2, 'Herbal Technology Research and Testing Center', 'Taman Sains Teknologi Herbal dan Hortikultura', 'sliders/produk.jpg', 1, NULL, 1, '2025-06-12 07:48:38', '2025-06-12 07:48:38'),
(3, 'Herbal Technology Research and Testing Center', 'Taman Sains Teknologi Herbal dan Hortikultura', 'sliders/taman.jpg', 1, 1, 1, '2025-06-12 07:48:49', '2025-06-12 07:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', NULL, '$2y$12$D5cOWCv7t1FBalqC4/wQCuNZRwYJaExD9QVlhuZ3dgVP7PY7EvoDy', NULL, '2025-06-12 06:12:05', '2025-06-12 06:12:05'),
(2, 'Rudy Chandra', 'rudychandra@del.ac.id', NULL, '$2y$12$Jim3xu6KrbjNF2V9zPN9De7FGquLFT0vkxnTx4aGIgqdPRryr7HCq', NULL, '2025-06-12 06:14:04', '2025-06-12 06:14:04'),
(3, 'Goklas H panjaitan', 'goklas.panjaitan@del.ac.id', NULL, '$2y$12$M74p2hDVRIy/7KDOIyz29u2Twx9M4ZM8Ox7JRxEHqVQLp0WLvAeaS', NULL, '2025-06-12 06:14:19', '2025-06-12 06:14:19'),
(4, 'Tegar A Prasetyo', 'tegar.prasetyo@del.ac.id', NULL, '$2y$12$ThYACu6y2mubD4iPc/4pou2/3JkhvgeaEUOL2/hfXM.7rPIey2fFK', NULL, '2025-06-12 06:14:39', '2025-06-12 06:14:39'),
(5, 'niko', 'niko@gmail.com', NULL, '$2y$12$NHP8MaIWj.iU7j4vfp9p6uifAcAZGpVieg5A8uesYEo.DL79r9V8q', NULL, '2025-06-12 08:20:10', '2025-06-12 08:20:10'),
(6, 'eka', 'eka@gmail.com', NULL, '$2y$12$78UXeJ9Ll2xLVk6YP3Db/.BhvCiUQjYvuQMvrgr.VVFjpzqk2wn.a', NULL, '2025-06-12 08:23:33', '2025-06-12 08:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `vision_missions`
--

CREATE TABLE `vision_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('visi','misi') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `collaborators_project_id_user_id_unique` (`project_id`,`user_id`),
  ADD KEY `collaborators_user_id_foreign` (`user_id`),
  ADD KEY `collaborators_researcher_id_foreign` (`researcher_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_created_by_index` (`created_by`),
  ADD KEY `contacts_updated_by_index` (`updated_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_institution_id_foreign` (`institution_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_created_by_index` (`created_by`),
  ADD KEY `galleries_updated_by_index` (`updated_by`);

--
-- Indexes for table `gallery_files`
--
ALTER TABLE `gallery_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_files_gallery_id_index` (`gallery_id`),
  ADD KEY `gallery_files_created_by_index` (`created_by`),
  ADD KEY `gallery_files_updated_by_index` (`updated_by`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_news_category_id_foreign` (`news_category_id`),
  ADD KEY `news_created_by_foreign` (`created_by`),
  ADD KEY `news_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_categories_created_by_foreign` (`created_by`),
  ADD KEY `news_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `organization_structures`
--
ALTER TABLE `organization_structures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_created_by_index` (`created_by`),
  ADD KEY `profiles_updated_by_index` (`updated_by`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_created_by_foreign` (`created_by`),
  ADD KEY `projects_leader_id_foreign` (`leader_id`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `publications_project_id_foreign` (`project_id`),
  ADD KEY `publications_researcher_id_foreign` (`researcher_id`);

--
-- Indexes for table `publication_researcher`
--
ALTER TABLE `publication_researcher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publication_researcher_publication_id_researcher_id_unique` (`publication_id`,`researcher_id`),
  ADD KEY `publication_researcher_researcher_id_foreign` (`researcher_id`);

--
-- Indexes for table `researchers`
--
ALTER TABLE `researchers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `researchers_user_id_foreign` (`user_id`),
  ADD KEY `researchers_department_id_foreign` (`department_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_created_by_index` (`created_by`),
  ADD KEY `sliders_updated_by_index` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vision_missions`
--
ALTER TABLE `vision_missions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collaborators`
--
ALTER TABLE `collaborators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `gallery_files`
--
ALTER TABLE `gallery_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `organization_structures`
--
ALTER TABLE `organization_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publication_researcher`
--
ALTER TABLE `publication_researcher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `researchers`
--
ALTER TABLE `researchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vision_missions`
--
ALTER TABLE `vision_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD CONSTRAINT `collaborators_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `collaborators_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `collaborators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_created_by_index` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contacts_updated_by_index` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `institutions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_files`
--
ALTER TABLE `gallery_files`
  ADD CONSTRAINT `gallery_files_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gallery_files_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gallery_files_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_news_category_id_foreign` FOREIGN KEY (`news_category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news_categories`
--
ALTER TABLE `news_categories`
  ADD CONSTRAINT `news_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `profiles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `projects_leader_id_foreign` FOREIGN KEY (`leader_id`) REFERENCES `researchers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `publications_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publication_researcher`
--
ALTER TABLE `publication_researcher`
  ADD CONSTRAINT `publication_researcher_publication_id_foreign` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `publication_researcher_researcher_id_foreign` FOREIGN KEY (`researcher_id`) REFERENCES `researchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `researchers`
--
ALTER TABLE `researchers`
  ADD CONSTRAINT `researchers_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `researchers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sliders`
--
ALTER TABLE `sliders`
  ADD CONSTRAINT `sliders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sliders_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
