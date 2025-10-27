-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 27, 2025 at 06:31 AM
-- Server version: 8.4.5-5
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consolidation`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `action`, `model`, `model_id`, `user_id`, `old_values`, `new_values`, `details`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'test', 'Member', 1, NULL, '{\"test\": \"old_value\"}', '{\"test\": \"new_value\"}', 'Testing audit log functionality', '127.0.0.1', 'Symfony', '2025-09-21 17:00:46', '2025-09-21 17:00:46'),
(2, 'delete', 'Member', 45, 11, '{\"id\": 45, \"email\": \"sample@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"sample\", \"status_id\": 13, \"created_at\": \"2025-09-28T11:47:07.000000Z\", \"first_name\": \"saample\", \"g12_leader\": {\"id\": 79, \"name\": \"John Ramil Rabe\"}, \"vip_status\": null, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": {\"id\": 46, \"last_name\": \"Rabe\", \"first_name\": \"John Ramil\"}, \"g12_leader_id\": 79, \"vip_status_id\": null, \"member_type_id\": 7, \"consolidator_id\": 46}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '110.54.148.37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-28 12:06:47', '2025-09-28 12:06:47'),
(3, 'delete', 'Member', 40, 11, '{\"id\": 40, \"email\": \"jaylord@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Ramos\", \"status_id\": 13, \"created_at\": \"2025-09-26T23:18:40.000000Z\", \"first_name\": \"Jaylord\", \"g12_leader\": {\"id\": 77, \"name\": \"Jhoemar Alcantara\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": {\"id\": 41, \"last_name\": \"Angeles\", \"first_name\": \"John Dave\"}, \"g12_leader_id\": 77, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": 41, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '122.3.86.176', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-02 13:23:01', '2025-10-02 13:23:01'),
(4, 'delete', 'Member', 70, 19, '{\"id\": 70, \"email\": \"pedro@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Penduko\", \"status_id\": 13, \"created_at\": \"2025-10-08T09:57:46.000000Z\", \"first_name\": \"Pedro\", \"g12_leader\": {\"id\": 88, \"name\": \"John Dave Angeles\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": {\"id\": 41, \"last_name\": \"Angeles\", \"first_name\": \"John Dave\"}, \"g12_leader_id\": 88, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": 41, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '136.158.48.174', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-08 10:02:05', '2025-10-08 10:02:05'),
(5, 'delete', 'Member', 86, 45, '{\"id\": 86, \"email\": \"cyd@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Jamarowon\", \"status_id\": 13, \"created_at\": \"2025-10-09T08:43:05.000000Z\", \"first_name\": \"Chris Dhaniel\", \"g12_leader\": {\"id\": 107, \"name\": \"Mark Joseph Sedilla\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": null, \"g12_leader_id\": 107, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": null, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '122.3.86.176', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-09 08:44:12', '2025-10-09 08:44:12'),
(6, 'delete', 'Member', 53, 17, '{\"id\": 53, \"email\": \"sean@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Doroja\", \"status_id\": 13, \"created_at\": \"2025-10-05T09:08:07.000000Z\", \"first_name\": \"Sean \", \"g12_leader\": {\"id\": 74, \"name\": \"Dareen Roy Rufo\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": null, \"g12_leader_id\": 74, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": null, \"consolidation_date\": \"2025-03-01T00:00:00.000000Z\"}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '111.90.208.95', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 07:18:26', '2025-10-11 07:18:26'),
(7, 'delete', 'Member', 231, 23, '{\"id\": 231, \"email\": \"ellamacaraig@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Macaraig\", \"status_id\": 13, \"created_at\": \"2025-10-19T19:08:18.000000Z\", \"first_name\": \"Ella\", \"g12_leader\": {\"id\": 100, \"name\": \"Jade Ann Dulin\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": {\"id\": 64, \"last_name\": \"Dulin\", \"first_name\": \"Jade Ann\"}, \"g12_leader_id\": 100, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": 64, \"consolidation_date\": \"2025-10-20T00:00:00.000000Z\"}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '123.253.51.156', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-19 22:21:09', '2025-10-19 22:21:09'),
(8, 'delete', 'Member', 251, 23, '{\"id\": 251, \"email\": \"jenine@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Jamero\", \"status_id\": 13, \"created_at\": \"2025-10-20T13:24:24.000000Z\", \"first_name\": \"Jenine\", \"g12_leader\": {\"id\": 89, \"name\": \"Ranee Nicole Sedilla\"}, \"vip_status\": null, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": null, \"g12_leader_id\": 89, \"vip_status_id\": null, \"member_type_id\": 7, \"consolidator_id\": null, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '123.253.51.156', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-20 13:25:14', '2025-10-20 13:25:14'),
(9, 'delete', 'Member', 261, 23, '{\"id\": 261, \"email\": \"april@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Mendoza\", \"status_id\": 13, \"created_at\": \"2025-10-20T13:31:42.000000Z\", \"first_name\": \"April\", \"g12_leader\": {\"id\": 89, \"name\": \"Ranee Nicole Sedilla\"}, \"vip_status\": null, \"member_type\": {\"id\": 8, \"name\": \"Consolidator\"}, \"consolidator\": null, \"g12_leader_id\": 89, \"vip_status_id\": null, \"member_type_id\": 8, \"consolidator_id\": null, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '123.253.51.156', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', '2025-10-20 13:35:36', '2025-10-20 13:35:36'),
(10, 'delete', 'Member', 263, 11, '{\"id\": 263, \"email\": \"justinepio@gmail.com\", \"phone\": null, \"status\": {\"id\": 13, \"name\": \"single\"}, \"last_name\": \"Pio\", \"status_id\": 13, \"created_at\": \"2025-10-26T06:26:21.000000Z\", \"first_name\": \"Justine\", \"g12_leader\": {\"id\": 109, \"name\": \"Dondi Torre\"}, \"vip_status\": {\"id\": 1, \"name\": \"New Believer\"}, \"member_type\": {\"id\": 7, \"name\": \"VIP\"}, \"consolidator\": null, \"g12_leader_id\": 109, \"vip_status_id\": 1, \"member_type_id\": 7, \"consolidator_id\": null, \"consolidation_date\": null}', NULL, 'Member permanently deleted with 0 consolidator dependents and 0 G12 dependents reassigned.', '180.232.13.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-26 09:07:45', '2025-10-26 09:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-all_consolidators', 'a:36:{i:42;s:15:\"Alexander Frias\";i:47;s:16:\"Alexis  Genotiva\";i:262;s:13:\"April Mendoza\";i:34;s:13:\"Bon Ryan Fran\";i:259;s:7:\"CJ Gapi\";i:87;s:11:\"Dareen Rufo\";i:253;s:13:\"Dia  Enguerra\";i:254;s:10:\"Eezy Escol\";i:65;s:10:\"Elis Umali\";i:36;s:18:\"Gene Samuel Javier\";i:64;s:14:\"Jade Ann Dulin\";i:252;s:13:\"Jenine Jamero\";i:67;s:17:\"Jhoemar Alcantara\";i:41;s:17:\"John Dave Angeles\";i:6;s:18:\"John Louie  Arenal\";i:46;s:15:\"John Ramil Rabe\";i:66;s:17:\"Justin John Flora\";i:52;s:12:\"Justine Rufo\";i:249;s:14:\"Katrina Lantin\";i:258;s:15:\"Kayzee Arquines\";i:49;s:14:\"Kevin Imperial\";i:256;s:12:\"Kim Baraquel\";i:257;s:16:\"Kimberly Paragas\";i:57;s:13:\"Maica Villena\";i:59;s:14:\"Maricar Idanan\";i:72;s:19:\"Mark Joseph Sedilla\";i:247;s:14:\"Maryann  Roque\";i:250;s:12:\"Mutya Manalo\";i:89;s:14:\"Mycole Aguilar\";i:44;s:21:\"Phillip WIlson Grande\";i:237;s:15:\"Regine Catapang\";i:60;s:16:\"Rikah Ann Lozano\";i:255;s:14:\"Sheila Ballano\";i:260;s:17:\"Stephanie Collado\";i:37;s:17:\"Vincent De Guzman\";i:248;s:13:\"Vivian  Totto\";}', 1761472785),
('laravel-cache-all_g12_leaders', 'a:36:{i:102;s:13:\"Alex Genotiva\";i:92;s:13:\"April Mendoza\";i:71;s:14:\"Ariel Katigbak\";i:72;s:13:\"Bon Ryan Fran\";i:73;s:15:\"Carlito Ballano\";i:93;s:7:\"CJ Gapi\";i:106;s:20:\"Daniel Oriel Ballano\";i:74;s:15:\"Dareen Roy Rufo\";i:94;s:12:\"Dia Enguerra\";i:109;s:11:\"Dondi Torre\";i:101;s:10:\"Eezy Escol\";i:90;s:10:\"Elis Umali\";i:75;s:18:\"Francisco Hornilla\";i:100;s:14:\"Jade Ann Dulin\";i:76;s:17:\"Jayson Din Marmol\";i:77;s:17:\"Jhoemar Alcantara\";i:88;s:17:\"John Dave Angeles\";i:78;s:17:\"John Louie Arenal\";i:103;s:18:\"John Paul De Jesus\";i:79;s:15:\"John Ramil Rabe\";i:80;s:17:\"Justin John Flora\";i:95;s:12:\"Kim Baraquel\";i:96;s:16:\"Kimberly Paragas\";i:81;s:14:\"Lester De Vera\";i:82;s:14:\"Manuel Domingo\";i:83;s:19:\"Mark Filbert Valdez\";i:108;s:11:\"Mark Irinco\";i:107;s:19:\"Mark Joseph Sedilla\";i:91;s:14:\"Matias Cancino\";i:97;s:12:\"Mutya Manalo\";i:104;s:13:\"Oriel Ballano\";i:84;s:21:\"Phillip Wilson Grande\";i:89;s:20:\"Ranee Nicole Sedilla\";i:85;s:15:\"Raymond Sedilla\";i:98;s:14:\"Sheila Ballano\";i:99;s:17:\"Stephanie Collado\";}', 1761472785),
('laravel-cache-dashboard_stats_admin', 'a:2:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:38;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:22:\"All active VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:10:\"Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:16:\"heroicon-o-users\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:36;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:4:\"info\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:24:\"All active Consolidators\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:19:\"Total Consolidators\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761540512),
('laravel-cache-dashboard_stats_leader_14', 'a:3:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:2;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:11:\"Dondi Torre\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761473538);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dashboard_stats_leader_17', 'a:14:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:12;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:2;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:14:\"Ariel Katigbak\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:3;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:2;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"Bon Ryan Fran\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:4;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:6:\"danger\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:15:\"Dareen Roy Rufo\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:5;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:18:\"Francisco Hornilla\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:6;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:3;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:4:\"info\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:18:\"Jhoe Mar Alcantara\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:7;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:17:\"John Louie Arenal\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:8;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:15:\"John Ramil Rabe\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:9;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:3;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:6:\"danger\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:17:\"Justin John Flora\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:10;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:14:\"Lester De Vera\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:11;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:4:\"info\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:14:\"Manuel Domingo\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:12;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:19:\"Mark Filbert Valdez\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:13;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:21:\"Phillip Wilson Grande\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761543262);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dashboard_stats_leader_20', 'a:2:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761476281),
('laravel-cache-dashboard_stats_leader_21', 'a:2:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761473560);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dashboard_stats_leader_23', 'a:13:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:19;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:2;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:2;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"April Mendoza\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:3;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:6:\"danger\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:7:\"CJ Gapi\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:4;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:1;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:12:\"Dia Enguerra\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:5;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:10:\"Eezy Escol\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:6;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:2;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:10:\"Elis Umali\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:7;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:4;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:4:\"info\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:14:\"Jade Ann Dulin\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:8;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:4:\"info\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:12:\"Kim Baraquel\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:9;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:16:\"Kimberly Paragas\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:10;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:2;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:12:\"Mutya Manalo\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:11;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:8;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:6:\"danger\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:14:\"Sheila Ballano\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:12;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:17:\"Stephanie Collado\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761538622);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-dashboard_stats_leader_43', 'a:5:{i:0;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:21:\"heroicon-o-user-group\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:38;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"success\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:31:\"VIP members under my leadership\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:13:\"My Total VIPs\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:1;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-star\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:0;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:36:\"Qualified candidates from my members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:23:\"My Lifeclass Candidates\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:2;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:7;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:6:\"danger\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:20:\"Daniel Oriel Ballano\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:3;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:19;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"warning\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:20:\"Ranee Nicole Sedilla\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}i:4;O:41:\"Filament\\Widgets\\StatsOverviewWidget\\Stat\":90:{s:23:\"\0*\0evaluationIdentifier\";s:9:\"component\";s:7:\"\0*\0view\";s:44:\"filament-widgets::stats-overview-widget.stat\";s:14:\"\0*\0defaultView\";N;s:11:\"\0*\0viewData\";a:0:{}s:17:\"\0*\0viewIdentifier\";s:15:\"schemaComponent\";s:8:\"\0*\0model\";N;s:34:\"\0*\0loadStateFromRelationshipsUsing\";N;s:25:\"\0*\0saveRelationshipsUsing\";N;s:39:\"\0*\0saveRelationshipsBeforeChildrenUsing\";N;s:38:\"\0*\0shouldSaveRelationshipsWhenDisabled\";b:0;s:36:\"\0*\0shouldSaveRelationshipsWhenHidden\";b:0;s:28:\"\0*\0cachedConcealingComponent\";N;s:13:\"\0*\0isDisabled\";b:0;s:18:\"\0*\0isGridContainer\";b:0;s:11:\"\0*\0isHidden\";b:0;s:12:\"\0*\0isVisible\";b:1;s:12:\"\0*\0visibleJs\";N;s:11:\"\0*\0hiddenJs\";N;s:31:\"\0*\0isLiberatedFromContainerGrid\";b:0;s:23:\"\0*\0cachedParentRepeater\";N;s:10:\"\0*\0canGrow\";N;s:14:\"\0*\0columnOrder\";N;s:47:\"\0*\0componentsToPartiallyRenderAfterStateUpdated\";a:0:{}s:32:\"\0*\0isRenderlessAfterStateUpdated\";b:0;s:39:\"\0*\0isPartiallyRenderedAfterStateUpdated\";b:0;s:18:\"\0*\0pollingInterval\";N;s:13:\"\0*\0columnSpan\";N;s:14:\"\0*\0columnStart\";N;s:14:\"\0*\0afterCloned\";a:0:{}s:16:\"\0*\0cachedActions\";N;s:10:\"\0*\0actions\";a:0:{}s:20:\"\0*\0actionSchemaModel\";N;s:9:\"\0*\0action\";N;s:18:\"\0*\0childComponents\";a:0:{}s:10:\"\0*\0columns\";N;s:19:\"\0*\0entryWrapperView\";N;s:18:\"\0*\0extraAttributes\";a:0:{}s:19:\"\0*\0fieldWrapperView\";N;s:9:\"\0*\0hasGap\";N;s:10:\"\0*\0isDense\";N;s:5:\"\0*\0id\";N;s:17:\"\0*\0hasInlineLabel\";N;s:6:\"\0*\0key\";N;s:19:\"\0*\0isKeyInheritable\";b:1;s:20:\"\0*\0cachedAbsoluteKey\";N;s:23:\"\0*\0hasCachedAbsoluteKey\";b:0;s:31:\"\0*\0cachedAbsoluteInheritanceKey\";N;s:34:\"\0*\0hasCachedAbsoluteInheritanceKey\";b:0;s:11:\"\0*\0maxWidth\";N;s:7:\"\0*\0meta\";a:0:{}s:21:\"\0*\0afterStateHydrated\";N;s:20:\"\0*\0afterStateUpdated\";a:0:{}s:22:\"\0*\0afterStateUpdatedJs\";a:0:{}s:24:\"\0*\0beforeStateDehydrated\";N;s:59:\"\0*\0shouldUpdateValidatedStateAfterBeforeStateDehydratedRuns\";b:0;s:15:\"\0*\0defaultState\";N;s:22:\"\0*\0dehydrateStateUsing\";N;s:29:\"\0*\0mutateDehydratedStateUsing\";N;s:32:\"\0*\0mutateStateForValidationUsing\";N;s:18:\"\0*\0hasDefaultState\";b:0;s:15:\"\0*\0isDehydrated\";b:1;s:25:\"\0*\0isDehydratedWhenHidden\";b:0;s:31:\"\0*\0isValidatedWhenNotDehydrated\";b:1;s:12:\"\0*\0statePath\";N;s:24:\"\0*\0getConstantStateUsing\";N;s:19:\"\0*\0hasConstantState\";b:0;s:12:\"\0*\0separator\";N;s:17:\"\0*\0isDistinctList\";b:0;s:13:\"\0*\0stateCasts\";a:0:{}s:36:\"\0*\0hasMultipleStateRelationshipCache\";N;s:25:\"\0*\0stateRelationshipCache\";N;s:24:\"\0*\0stateBindingModifiers\";N;s:15:\"\0*\0liveDebounce\";N;s:9:\"\0*\0isLive\";N;s:15:\"\0*\0isLiveOnBlur\";b:0;s:8:\"\0*\0chart\";N;s:13:\"\0*\0chartColor\";N;s:7:\"\0*\0icon\";N;s:18:\"\0*\0descriptionIcon\";s:15:\"heroicon-o-user\";s:26:\"\0*\0descriptionIconPosition\";N;s:19:\"\0*\0descriptionColor\";N;s:8:\"\0*\0value\";i:12;s:24:\"\0*\0shouldOpenUrlInNewTab\";b:0;s:6:\"\0*\0url\";N;s:8:\"\0*\0color\";s:7:\"primary\";s:15:\"\0*\0defaultColor\";N;s:14:\"\0*\0description\";s:11:\"VIP members\";s:16:\"\0*\0isLabelHidden\";b:0;s:8:\"\0*\0label\";s:15:\"Raymond Sedilla\";s:23:\"\0*\0shouldTranslateLabel\";b:0;}}', 1761471727),
('laravel-cache-g12_descendants_100', 'a:1:{i:0;i:100;}', 1761541922),
('laravel-cache-g12_descendants_101', 'a:1:{i:0;i:101;}', 1761541922),
('laravel-cache-g12_descendants_104', 'a:35:{i:0;i:104;i:1;i:85;i:2;i:89;i:3;i:106;i:4;i:71;i:5;i:72;i:6;i:73;i:7;i:74;i:8;i:75;i:9;i:76;i:10;i:77;i:11;i:78;i:12;i:79;i:13;i:80;i:14;i:81;i:15;i:82;i:16;i:83;i:17;i:84;i:18;i:90;i:19;i:92;i:20;i:93;i:21;i:94;i:22;i:95;i:23;i:96;i:24;i:97;i:25;i:98;i:26;i:99;i:27;i:100;i:28;i:101;i:29;i:107;i:30;i:91;i:31;i:88;i:32;i:109;i:33;i:102;i:34;i:108;}', 1761475027),
('laravel-cache-g12_descendants_106', 'a:2:{i:0;i:106;i:1;i:107;}', 1761475027),
('laravel-cache-g12_descendants_109', 'a:1:{i:0;i:109;}', 1761475320),
('laravel-cache-g12_descendants_71', 'a:1:{i:0;i:71;}', 1761546116),
('laravel-cache-g12_descendants_72', 'a:1:{i:0;i:72;}', 1761546116),
('laravel-cache-g12_descendants_74', 'a:2:{i:0;i:74;i:1;i:91;}', 1761546116),
('laravel-cache-g12_descendants_75', 'a:1:{i:0;i:75;}', 1761546116),
('laravel-cache-g12_descendants_77', 'a:2:{i:0;i:77;i:1;i:88;}', 1761546116),
('laravel-cache-g12_descendants_78', 'a:2:{i:0;i:78;i:1;i:109;}', 1761546116),
('laravel-cache-g12_descendants_79', 'a:1:{i:0;i:79;}', 1761546116),
('laravel-cache-g12_descendants_80', 'a:1:{i:0;i:80;}', 1761546116),
('laravel-cache-g12_descendants_81', 'a:1:{i:0;i:81;}', 1761546116),
('laravel-cache-g12_descendants_82', 'a:3:{i:0;i:82;i:1;i:102;i:2;i:108;}', 1761546116),
('laravel-cache-g12_descendants_83', 'a:1:{i:0;i:83;}', 1761546116),
('laravel-cache-g12_descendants_84', 'a:1:{i:0;i:84;}', 1761546116),
('laravel-cache-g12_descendants_85', 'a:20:{i:0;i:85;i:1;i:71;i:2;i:72;i:3;i:73;i:4;i:74;i:5;i:75;i:6;i:76;i:7;i:77;i:8;i:78;i:9;i:79;i:10;i:80;i:11;i:81;i:12;i:82;i:13;i:83;i:14;i:84;i:15;i:91;i:16;i:88;i:17;i:109;i:18;i:102;i:19;i:108;}', 1761546116),
('laravel-cache-g12_descendants_89', 'a:12:{i:0;i:89;i:1;i:90;i:2;i:92;i:3;i:93;i:4;i:94;i:5;i:95;i:6;i:96;i:7;i:97;i:8;i:98;i:9;i:99;i:10;i:100;i:11;i:101;}', 1761541922),
('laravel-cache-g12_descendants_90', 'a:1:{i:0;i:90;}', 1761541922),
('laravel-cache-g12_descendants_92', 'a:1:{i:0;i:92;}', 1761541922),
('laravel-cache-g12_descendants_93', 'a:1:{i:0;i:93;}', 1761541922),
('laravel-cache-g12_descendants_94', 'a:1:{i:0;i:94;}', 1761541922),
('laravel-cache-g12_descendants_95', 'a:1:{i:0;i:95;}', 1761541922),
('laravel-cache-g12_descendants_96', 'a:1:{i:0;i:96;}', 1761541922),
('laravel-cache-g12_descendants_97', 'a:1:{i:0;i:97;}', 1761541922),
('laravel-cache-g12_descendants_98', 'a:1:{i:0;i:98;}', 1761541922),
('laravel-cache-g12_descendants_99', 'a:1:{i:0;i:99;}', 1761541922),
('laravel-cache-livewire-rate-limiter:1f7a645f82bbae08d2202e3897346fbf55daa3df', 'i:1;', 1761476267),
('laravel-cache-livewire-rate-limiter:1f7a645f82bbae08d2202e3897346fbf55daa3df:timer', 'i:1761476267;', 1761476267),
('laravel-cache-livewire-rate-limiter:ade5c678db4f77fac9146217944b2d87612a4b75', 'i:1;', 1761542575),
('laravel-cache-livewire-rate-limiter:ade5c678db4f77fac9146217944b2d87612a4b75:timer', 'i:1761542575;', 1761542575),
('laravel-cache-member_type_consolidator_id', 'i:8;', 1761546116),
('laravel-cache-member_type_vip_id', 'i:7;', 1761546116),
('laravel-cache-member_types_options', 'a:2:{i:8;s:12:\"Consolidator\";i:7;s:3:\"VIP\";}', 1761474585),
('laravel-cache-nav_badge_cellgroup_admin', 'i:31;', 1761541915),
('laravel-cache-nav_badge_cellgroup_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_cellgroup_leader_17', 'i:12;', 1761542816),
('laravel-cache-nav_badge_cellgroup_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_cellgroup_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_cellgroup_leader_23', 'i:12;', 1761539110),
('laravel-cache-nav_badge_cellgroup_leader_43', 'i:26;', 1761471727),
('laravel-cache-nav_badge_consolidator_admin', 'i:36;', 1761541915),
('laravel-cache-nav_badge_consolidator_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_consolidator_leader_17', 'i:13;', 1761542816),
('laravel-cache-nav_badge_consolidator_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_consolidator_leader_21', 'i:1;', 1761473559),
('laravel-cache-nav_badge_consolidator_leader_23', 'i:22;', 1761539110),
('laravel-cache-nav_badge_consolidator_leader_43', 'i:36;', 1761471727),
('laravel-cache-nav_badge_lifeclass_admin', 'i:0;', 1761541915),
('laravel-cache-nav_badge_lifeclass_leader_14', 'i:0;', 1761473537),
('laravel-cache-nav_badge_lifeclass_leader_17', 'i:0;', 1761542816),
('laravel-cache-nav_badge_lifeclass_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_lifeclass_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_lifeclass_leader_23', 'i:0;', 1761539110),
('laravel-cache-nav_badge_lifeclass_leader_43', 'i:0;', 1761471727),
('laravel-cache-nav_badge_newlife_admin', 'i:38;', 1761541915),
('laravel-cache-nav_badge_newlife_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_newlife_leader_17', 'i:12;', 1761542816),
('laravel-cache-nav_badge_newlife_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_newlife_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_newlife_leader_23', 'i:19;', 1761539110),
('laravel-cache-nav_badge_newlife_leader_43', 'i:38;', 1761471727),
('laravel-cache-nav_badge_sol_3_candidates_admin', 'i:7;', 1761541915),
('laravel-cache-nav_badge_sol_3_candidates_leader_14', 'i:2;', 1761473537),
('laravel-cache-nav_badge_sol_3_candidates_leader_17', 'i:7;', 1761542816),
('laravel-cache-nav_badge_sol_3_candidates_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_sol_3_candidates_leader_21', 'i:1;', 1761473559),
('laravel-cache-nav_badge_sol_3_candidates_leader_23', 'i:0;', 1761539110),
('laravel-cache-nav_badge_sol_3_candidates_leader_43', 'i:6;', 1761471727),
('laravel-cache-nav_badge_sol_profiles_admin', 'i:10;', 1761541915),
('laravel-cache-nav_badge_sol_profiles_leader_14', 'i:3;', 1761473537),
('laravel-cache-nav_badge_sol_profiles_leader_17', 'i:10;', 1761542816),
('laravel-cache-nav_badge_sol_profiles_leader_20', 'i:1;', 1761476335),
('laravel-cache-nav_badge_sol_profiles_leader_21', 'i:1;', 1761473559),
('laravel-cache-nav_badge_sol_profiles_leader_23', 'i:0;', 1761539110),
('laravel-cache-nav_badge_sol_profiles_leader_43', 'i:7;', 1761471727),
('laravel-cache-nav_badge_sol1_candidates_admin', 'i:2;', 1761541915),
('laravel-cache-nav_badge_sol1_candidates_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_sol1_candidates_leader_17', 'i:2;', 1761542816),
('laravel-cache-nav_badge_sol1_candidates_leader_20', 'i:1;', 1761476343),
('laravel-cache-nav_badge_sol1_candidates_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_sol1_candidates_leader_23', 'i:0;', 1761539110),
('laravel-cache-nav_badge_sol1_candidates_leader_43', 'i:1;', 1761471727),
('laravel-cache-nav_badge_sol2_candidates_admin', 'i:0;', 1761541915),
('laravel-cache-nav_badge_sol2_candidates_leader_14', 'i:0;', 1761473537),
('laravel-cache-nav_badge_sol2_candidates_leader_17', 'i:0;', 1761542816),
('laravel-cache-nav_badge_sol2_candidates_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_sol2_candidates_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_sol2_candidates_leader_23', 'i:0;', 1761539110),
('laravel-cache-nav_badge_sol2_candidates_leader_43', 'i:0;', 1761471727),
('laravel-cache-nav_badge_sunday_admin', 'i:37;', 1761541915),
('laravel-cache-nav_badge_sunday_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_sunday_leader_17', 'i:12;', 1761542816),
('laravel-cache-nav_badge_sunday_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_sunday_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_sunday_leader_23', 'i:18;', 1761539110),
('laravel-cache-nav_badge_sunday_leader_43', 'i:34;', 1761471727),
('laravel-cache-nav_badge_vip_admin', 'i:38;', 1761541915),
('laravel-cache-nav_badge_vip_leader_14', 'i:1;', 1761473537),
('laravel-cache-nav_badge_vip_leader_17', 'i:12;', 1761542816),
('laravel-cache-nav_badge_vip_leader_20', 'i:0;', 1761476281),
('laravel-cache-nav_badge_vip_leader_21', 'i:0;', 1761473559),
('laravel-cache-nav_badge_vip_leader_23', 'i:19;', 1761539110),
('laravel-cache-nav_badge_vip_leader_43', 'i:38;', 1761471727),
('laravel-cache-statuses_options', 'a:3:{i:14;s:7:\"married\";i:13;s:6:\"single\";i:15;s:7:\"widowed\";}', 1761474585),
('laravel-cache-user_14_available_consolidators', 'a:1:{i:36;s:18:\"Gene Samuel Javier\";}', 1761473646),
('laravel-cache-user_14_available_leaders', 'a:2:{i:109;s:11:\"Dondi Torre\";i:78;s:17:\"John Louie Arenal\";}', 1761473646),
('laravel-cache-vip_statuses_options', 'a:3:{i:1;s:12:\"New Believer\";i:3;s:12:\"Other Church\";i:2;s:12:\"Recommitment\";}', 1761474585);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cell_groups`
--

CREATE TABLE `cell_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `cell_group_1_date` date DEFAULT NULL,
  `cell_group_2_date` date DEFAULT NULL,
  `cell_group_3_date` date DEFAULT NULL,
  `cell_group_4_date` date DEFAULT NULL,
  `attendance_date` date DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cell_groups`
--

INSERT INTO `cell_groups` (`id`, `member_id`, `cell_group_1_date`, `cell_group_2_date`, `cell_group_3_date`, `cell_group_4_date`, `attendance_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-09-21', '2025-09-15', '2025-09-27', '2025-09-27', NULL, NULL, '2025-09-20 09:40:58', '2025-09-27 03:19:40'),
(2, 7, '2025-09-22', '2025-09-12', '2025-09-16', '2025-09-27', NULL, NULL, '2025-09-21 23:59:48', '2025-09-27 03:20:23'),
(7, 48, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 10:59:16', '2025-10-01 10:59:16'),
(8, 51, '2025-09-18', '2025-09-26', NULL, NULL, NULL, NULL, '2025-10-04 13:24:02', '2025-10-04 13:24:02'),
(9, 50, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 03:42:01', '2025-10-05 03:42:01'),
(10, 58, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-06 09:32:07', '2025-10-06 09:32:07'),
(11, 62, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:55:38', '2025-10-09 03:55:38'),
(12, 68, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:55:42', '2025-10-09 03:55:42'),
(13, 63, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:55:50', '2025-10-09 03:55:50'),
(14, 56, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:56:30', '2025-10-09 03:56:30'),
(15, 55, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:56:36', '2025-10-09 03:56:36'),
(16, 54, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:56:41', '2025-10-09 03:56:41'),
(18, 71, '2025-09-14', '2025-09-22', '2025-10-06', '2025-09-29', NULL, NULL, '2025-10-09 08:17:36', '2025-10-09 08:17:36'),
(19, 73, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:27:54', '2025-10-09 08:27:54'),
(20, 74, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:28:00', '2025-10-09 08:28:00'),
(21, 83, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:46:36', '2025-10-09 08:46:36'),
(22, 82, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 09:24:21', '2025-10-09 09:24:21'),
(23, 84, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 09:24:26', '2025-10-09 09:24:26'),
(24, 85, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 09:24:29', '2025-10-09 09:24:29'),
(25, 234, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:08:58', '2025-10-20 00:08:58'),
(26, 239, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:09:04', '2025-10-20 00:09:04'),
(27, 91, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:09:09', '2025-10-20 00:09:09'),
(28, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:51', '2025-10-20 00:43:51'),
(29, 93, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:44:08', '2025-10-20 00:44:08'),
(30, 88, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 03:24:11', '2025-10-20 03:24:11'),
(32, 264, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:35:14', '2025-10-26 09:35:14'),
(33, 238, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:39:53', '2025-10-26 09:39:53'),
(34, 240, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:39:56', '2025-10-26 09:39:56'),
(35, 244, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:40:01', '2025-10-26 09:40:01'),
(36, 245, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:40:05', '2025-10-26 09:40:05'),
(37, 243, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:40:13', '2025-10-26 09:40:13');

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
-- Table structure for table `g12_leaders`
--

CREATE TABLE `g12_leaders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `g12_leaders`
--

INSERT INTO `g12_leaders` (`id`, `name`, `user_id`, `parent_id`, `created_at`, `updated_at`) VALUES
(71, 'Ariel Katigbak', 29, 85, '2025-09-20 15:50:31', '2025-10-05 09:04:59'),
(72, 'Bon Ryan Fran', 13, 85, '2025-09-20 15:50:31', '2025-10-02 13:26:30'),
(73, 'Carlito Ballano', NULL, 85, '2025-09-20 15:50:31', '2025-10-06 11:24:06'),
(74, 'Dareen Roy Rufo', 28, 85, '2025-09-20 15:50:31', '2025-10-05 09:03:09'),
(75, 'Francisco Hornilla', 25, 85, '2025-09-20 15:50:31', '2025-10-04 14:06:13'),
(76, 'Jayson Din Marmol', NULL, 85, '2025-09-20 15:50:31', '2025-10-06 11:24:47'),
(77, 'Jhoemar Alcantara', 19, 85, '2025-09-20 15:50:31', '2025-10-06 11:24:24'),
(78, 'John Louie Arenal', 14, 85, '2025-09-20 15:50:31', '2025-10-06 11:25:00'),
(79, 'John Ramil Rabe', 21, 85, '2025-09-20 15:50:31', '2025-10-06 11:25:16'),
(80, 'Justin John Flora', 27, 85, '2025-09-20 15:50:31', '2025-10-05 09:00:35'),
(81, 'Lester De Vera', 16, 85, '2025-09-20 15:50:31', '2025-10-03 02:22:09'),
(82, 'Manuel Domingo', 12, 85, '2025-09-20 15:50:31', '2025-09-29 09:26:55'),
(83, 'Mark Filbert Valdez', 26, 85, '2025-09-20 15:50:31', '2025-10-05 08:58:55'),
(84, 'Phillip Wilson Grande', 20, 85, '2025-09-20 15:50:31', '2025-10-05 12:50:41'),
(85, 'Raymond Sedilla', 17, 104, '2025-09-20 15:50:31', '2025-10-08 07:25:35'),
(88, 'John Dave Angeles', 22, 77, '2025-10-02 13:22:21', '2025-10-02 13:22:21'),
(89, 'Ranee Nicole Sedilla', 23, 104, '2025-10-04 12:44:01', '2025-10-08 07:26:38'),
(90, 'Elis Umali', 24, 89, '2025-10-04 13:18:43', '2025-10-04 13:18:43'),
(91, 'Matias Cancino', 30, 74, '2025-10-05 09:06:26', '2025-10-05 09:06:26'),
(92, 'April Mendoza', 31, 89, '2025-10-05 10:56:07', '2025-10-05 10:56:07'),
(93, 'CJ Gapi', 32, 89, '2025-10-05 10:57:06', '2025-10-05 10:57:06'),
(94, 'Dia Enguerra', 33, 89, '2025-10-05 10:58:03', '2025-10-05 10:58:03'),
(95, 'Kim Baraquel', 34, 89, '2025-10-05 11:00:58', '2025-10-05 11:00:58'),
(96, 'Kimberly Paragas', 35, 89, '2025-10-05 11:01:37', '2025-10-05 11:01:37'),
(97, 'Mutya Manalo', 36, 89, '2025-10-05 11:02:12', '2025-10-05 11:02:12'),
(98, 'Sheila Ballano', 37, 89, '2025-10-05 11:03:26', '2025-10-05 11:03:26'),
(99, 'Stephanie Collado', 38, 89, '2025-10-05 11:04:34', '2025-10-05 11:04:34'),
(100, 'Jade Ann Dulin', 39, 89, '2025-10-05 11:05:21', '2025-10-05 11:05:21'),
(101, 'Eezy Escol', 40, 89, '2025-10-05 12:14:10', '2025-10-05 12:14:10'),
(102, 'Alex Genotiva', 41, 82, '2025-10-05 12:47:13', '2025-10-05 12:47:13'),
(103, 'John Paul De Jesus', 42, NULL, '2025-10-06 09:35:54', '2025-10-06 09:35:54'),
(104, 'Oriel Ballano', 43, NULL, '2025-10-08 07:24:59', '2025-10-09 02:13:25'),
(106, 'Daniel Oriel Ballano', 46, 104, '2025-10-09 08:11:22', '2025-10-09 08:11:22'),
(107, 'Mark Joseph Sedilla', 45, 106, '2025-10-09 08:12:03', '2025-10-09 08:12:03'),
(108, 'Mark Irinco', NULL, 82, '2025-10-23 14:21:38', '2025-10-23 14:21:38'),
(109, 'Dondi Torre', 47, 78, '2025-10-26 05:56:44', '2025-10-26 05:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"ada236da-786b-4997-93c2-c4c7fbad934d\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:45;s:4:\\\"name\\\";s:14:\\\"saample sample\\\";s:5:\\\"email\\\";s:16:\\\"sample@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:45;s:4:\\\"name\\\";s:14:\\\"saample sample\\\";s:5:\\\"email\\\";s:16:\\\"sample@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:5:\\\"Admin\\\";s:2:\\\"id\\\";s:36:\\\"6d517d94-3dde-430f-81f3-0edb9cc1dc82\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1759061207,\"delay\":null}', 0, NULL, 1759061207, 1759061207),
(2, 'default', '{\"uuid\":\"ae8ca6ac-a045-4466-8a92-7b6f6daeed7a\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:40;s:4:\\\"name\\\";s:13:\\\"Jaylord Ramos\\\";s:5:\\\"email\\\";s:17:\\\"jaylord@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:40;s:4:\\\"name\\\";s:13:\\\"Jaylord Ramos\\\";s:5:\\\"email\\\";s:17:\\\"jaylord@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:5:\\\"Admin\\\";s:2:\\\"id\\\";s:36:\\\"20d59f75-519c-492e-a9f3-ebc2d9c4e087\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1759411381,\"delay\":null}', 0, NULL, 1759411381, 1759411381),
(3, 'default', '{\"uuid\":\"aed27fb5-6007-4534-b661-d1dc0a154243\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:70;s:4:\\\"name\\\";s:13:\\\"Pedro Penduko\\\";s:5:\\\"email\\\";s:15:\\\"pedro@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:70;s:4:\\\"name\\\";s:13:\\\"Pedro Penduko\\\";s:5:\\\"email\\\";s:15:\\\"pedro@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:18:\\\"Jhoe Mar Alcantara\\\";s:2:\\\"id\\\";s:36:\\\"cbe23998-0be2-4b28-8e8c-3c3a25e54573\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1759917725,\"delay\":null}', 0, NULL, 1759917725, 1759917725),
(4, 'default', '{\"uuid\":\"e88d8a2f-b336-4cd2-96b3-77723401f1e3\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:43;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:70;s:4:\\\"name\\\";s:13:\\\"Pedro Penduko\\\";s:5:\\\"email\\\";s:15:\\\"pedro@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:70;s:4:\\\"name\\\";s:13:\\\"Pedro Penduko\\\";s:5:\\\"email\\\";s:15:\\\"pedro@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:18:\\\"Jhoe Mar Alcantara\\\";s:2:\\\"id\\\";s:36:\\\"89efce1c-88b6-476a-815e-b868e2e7f632\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1759917725,\"delay\":null}', 0, NULL, 1759917725, 1759917725),
(5, 'default', '{\"uuid\":\"df0ada02-a515-46cf-a6ab-d0fb14f26f46\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:86;s:4:\\\"name\\\";s:23:\\\"Chris Dhaniel Jamarowon\\\";s:5:\\\"email\\\";s:13:\\\"cyd@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:86;s:4:\\\"name\\\";s:23:\\\"Chris Dhaniel Jamarowon\\\";s:5:\\\"email\\\";s:13:\\\"cyd@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:19:\\\"Mark Joseph Sedilla\\\";s:2:\\\"id\\\";s:36:\\\"e18dc147-2c55-43e1-9541-d65474d35d5f\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1759999452,\"delay\":null}', 0, NULL, 1759999452, 1759999452),
(6, 'default', '{\"uuid\":\"3d9d8d72-afaa-4da4-847d-f98ecd26205a\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:53;s:4:\\\"name\\\";s:12:\\\"Sean  Doroja\\\";s:5:\\\"email\\\";s:14:\\\"sean@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:53;s:4:\\\"name\\\";s:12:\\\"Sean  Doroja\\\";s:5:\\\"email\\\";s:14:\\\"sean@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:15:\\\"Raymond Sedilla\\\";s:2:\\\"id\\\";s:36:\\\"f0dc8b42-9442-4355-9f57-eee8d0852630\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1760167106,\"delay\":null}', 0, NULL, 1760167106, 1760167106),
(7, 'default', '{\"uuid\":\"026e581f-29e0-476b-9c77-d63b6f3ef91c\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:231;s:4:\\\"name\\\";s:13:\\\"Ella Macaraig\\\";s:5:\\\"email\\\";s:22:\\\"ellamacaraig@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:231;s:4:\\\"name\\\";s:13:\\\"Ella Macaraig\\\";s:5:\\\"email\\\";s:22:\\\"ellamacaraig@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:20:\\\"Ranee Nicole Sedilla\\\";s:2:\\\"id\\\";s:36:\\\"082dc292-b784-41d1-92ae-a82f155380b2\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1760912469,\"delay\":null}', 0, NULL, 1760912469, 1760912469),
(8, 'default', '{\"uuid\":\"d846b02d-c188-4cfb-bbd2-cf25b3ad5ecb\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:251;s:4:\\\"name\\\";s:13:\\\"Jenine Jamero\\\";s:5:\\\"email\\\";s:16:\\\"jenine@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:251;s:4:\\\"name\\\";s:13:\\\"Jenine Jamero\\\";s:5:\\\"email\\\";s:16:\\\"jenine@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:20:\\\"Ranee Nicole Sedilla\\\";s:2:\\\"id\\\";s:36:\\\"85a50585-0ea3-4f7d-816d-23eecd7ca873\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1760966714,\"delay\":null}', 0, NULL, 1760966714, 1760966714),
(9, 'default', '{\"uuid\":\"1a60839b-d4bd-4e8e-9d30-040b01356e47\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:261;s:4:\\\"name\\\";s:13:\\\"April Mendoza\\\";s:5:\\\"email\\\";s:15:\\\"april@gmail.com\\\";s:11:\\\"member_type\\\";s:12:\\\"Consolidator\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:261;s:4:\\\"name\\\";s:13:\\\"April Mendoza\\\";s:5:\\\"email\\\";s:15:\\\"april@gmail.com\\\";s:11:\\\"member_type\\\";s:12:\\\"Consolidator\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:20:\\\"Ranee Nicole Sedilla\\\";s:2:\\\"id\\\";s:36:\\\"884e444e-bc49-451b-b9fa-dde1b15549f1\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1760967336,\"delay\":null}', 0, NULL, 1760967336, 1760967336),
(10, 'default', '{\"uuid\":\"0e60f484-48cd-4c99-bd35-ae802d36e008\",\"displayName\":\"App\\\\Notifications\\\\MemberDeletedNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:11;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:43:\\\"App\\\\Notifications\\\\MemberDeletedNotification\\\":4:{s:13:\\\"\\u0000*\\u0000memberData\\\";a:4:{s:2:\\\"id\\\";i:263;s:4:\\\"name\\\";s:11:\\\"Justine Pio\\\";s:5:\\\"email\\\";s:20:\\\"justinepio@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}s:17:\\\"\\u0000*\\u0000deletionResult\\\";a:5:{s:7:\\\"success\\\";b:0;s:7:\\\"message\\\";s:0:\\\"\\\";s:34:\\\"reassigned_consolidator_dependents\\\";i:0;s:25:\\\"reassigned_g12_dependents\\\";i:0;s:14:\\\"deleted_member\\\";a:4:{s:2:\\\"id\\\";i:263;s:4:\\\"name\\\";s:11:\\\"Justine Pio\\\";s:5:\\\"email\\\";s:20:\\\"justinepio@gmail.com\\\";s:11:\\\"member_type\\\";s:3:\\\"VIP\\\";}}s:12:\\\"\\u0000*\\u0000deletedBy\\\";s:5:\\\"Admin\\\";s:2:\\\"id\\\";s:36:\\\"6a33b763-6404-4957-9878-783f3350c6be\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1761469665,\"delay\":null}', 0, NULL, 1761469665, 1761469665);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lifeclass_candidates`
--

CREATE TABLE `lifeclass_candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `sol_profile_id` bigint UNSIGNED DEFAULT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `life_class_party_date` date DEFAULT NULL,
  `lesson_1_completion_date` date DEFAULT NULL,
  `lesson_2_completion_date` date DEFAULT NULL,
  `lesson_3_completion_date` date DEFAULT NULL,
  `lesson_4_completion_date` date DEFAULT NULL,
  `encounter_completion_date` date DEFAULT NULL COMMENT 'Lesson 5 - Encounter',
  `lesson_6_completion_date` date DEFAULT NULL,
  `lesson_7_completion_date` date DEFAULT NULL,
  `lesson_8_completion_date` date DEFAULT NULL,
  `lesson_9_completion_date` date DEFAULT NULL,
  `graduation_date` date DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `wedding_anniversary_date` date DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `member_type_id` bigint UNSIGNED NOT NULL,
  `vip_status_id` bigint UNSIGNED DEFAULT NULL,
  `consolidation_date` date DEFAULT NULL,
  `g12_leader_id` bigint UNSIGNED DEFAULT NULL,
  `consolidator_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `active_name_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `first_name`, `middle_name`, `last_name`, `birthday`, `wedding_anniversary_date`, `email`, `phone`, `address`, `status_id`, `member_type_id`, `vip_status_id`, `consolidation_date`, `g12_leader_id`, `consolidator_id`, `created_at`, `updated_at`, `deleted_at`, `active_name_key`) VALUES
(1, 'Julian', NULL, 'Jugo', '2016-03-15', NULL, 'admin@example.com', NULL, NULL, 13, 7, 1, NULL, 72, 34, '2025-09-20 04:48:07', '2025-09-22 00:55:19', NULL, NULL),
(6, 'John Louie ', NULL, 'Arenal', NULL, NULL, 'arenal@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 85, NULL, '2025-09-20 17:49:48', '2025-10-08 07:55:15', NULL, NULL),
(7, 'Anton Benj', NULL, 'Quitoriano', NULL, NULL, 'thelma@gmail.com', NULL, NULL, 13, 7, 1, NULL, 72, 34, '2025-09-20 19:06:26', '2025-09-22 00:00:09', NULL, NULL),
(34, 'Bon Ryan', NULL, 'Fran', NULL, NULL, 'bonryan@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 72, NULL, '2025-09-21 21:33:05', '2025-09-21 22:42:39', NULL, NULL),
(36, 'Gene Samuel', NULL, 'Javier', NULL, NULL, 'gene@example.com', NULL, NULL, 13, 8, NULL, NULL, 78, NULL, '2025-09-21 21:35:24', '2025-09-21 21:35:24', NULL, NULL),
(37, 'Vincent', NULL, 'De Guzman', NULL, NULL, 'vince@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 72, NULL, '2025-09-21 22:48:02', '2025-09-21 22:48:02', NULL, NULL),
(41, 'John Dave', NULL, 'Angeles', NULL, NULL, 'jd@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 77, NULL, '2025-09-26 23:19:17', '2025-09-26 23:19:17', NULL, NULL),
(42, 'Alexander', NULL, 'Frias', NULL, NULL, 'alexfrias@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 77, NULL, '2025-09-27 12:45:21', '2025-09-27 12:45:21', NULL, NULL),
(44, 'Phillip WIlson', NULL, 'Grande', NULL, NULL, 'phillipwilson.grande@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 85, NULL, '2025-09-27 13:26:34', '2025-09-27 13:26:34', NULL, NULL),
(46, 'John Ramil', NULL, 'Rabe', NULL, NULL, 'johnramilrabe@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 79, NULL, '2025-09-28 11:50:08', '2025-09-28 11:50:08', NULL, NULL),
(47, 'Alexis ', NULL, 'Genotiva', NULL, NULL, 'alex@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 82, NULL, '2025-09-28 12:09:56', '2025-09-28 12:09:56', NULL, NULL),
(48, 'Brylle', NULL, 'Garcia', NULL, NULL, 'brylle@gmail.com', NULL, NULL, 13, 7, 1, NULL, 82, 47, '2025-09-28 12:11:13', '2025-09-28 12:12:49', NULL, NULL),
(49, 'Kevin', NULL, 'Imperial', NULL, NULL, 'kevinimperial@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 81, NULL, '2025-10-01 12:20:44', '2025-10-01 12:20:44', NULL, NULL),
(50, 'Dags', NULL, 'Sampaloc', NULL, NULL, 'Dags@gmail.com', NULL, NULL, 13, 7, 1, NULL, 81, 49, '2025-10-01 12:21:54', '2025-10-01 12:21:54', NULL, NULL),
(51, 'Krenza', NULL, 'Carrullo', NULL, NULL, 'krenza@gmail.com', NULL, NULL, 13, 7, 1, '2025-09-20', 90, 52, '2025-10-04 13:21:00', '2025-10-04 13:22:09', NULL, NULL),
(52, 'Justine', NULL, 'Rufo', NULL, NULL, 'justine@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 90, NULL, '2025-10-04 13:21:55', '2025-10-04 13:21:55', NULL, NULL),
(54, 'Rahsel', NULL, 'Morata', NULL, NULL, 'Rahselmorata@gmail.com', NULL, NULL, 13, 7, 1, '2025-09-14', 80, 66, '2025-10-05 09:13:16', '2025-10-08 07:37:45', NULL, NULL),
(55, 'Kyle Icko', NULL, 'Encallado', NULL, NULL, 'kyleencallado@gmail.com', NULL, NULL, 13, 7, 1, '2025-09-14', 80, 66, '2025-10-05 09:15:20', '2025-10-08 07:37:22', NULL, NULL),
(56, 'Don Rexon', NULL, 'Mañebo', NULL, NULL, 'Donmanebo@gmail.com', NULL, NULL, 13, 7, 1, '2025-06-01', 80, 66, '2025-10-05 09:19:08', '2025-10-08 07:37:35', NULL, NULL),
(57, 'Maica', NULL, 'Villena', NULL, NULL, 'maica@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 94, NULL, '2025-10-05 11:30:07', '2025-10-05 11:30:07', NULL, NULL),
(58, 'Kylie Eunice', NULL, 'Gudes', NULL, NULL, 'eunice@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-05', 94, 57, '2025-10-05 11:30:56', '2025-10-19 22:14:48', NULL, NULL),
(59, 'Maricar', NULL, 'Idanan', NULL, NULL, 'maricar@gmail.com', NULL, 'Tondo', 13, 8, NULL, NULL, 100, NULL, '2025-10-05 11:53:24', '2025-10-05 11:53:24', NULL, NULL),
(60, 'Rikah Ann', NULL, 'Lozano', NULL, NULL, 'rikah@gmail.com', NULL, 'Sta. Ana, Manila', 13, 8, NULL, NULL, 100, NULL, '2025-10-05 11:54:51', '2025-10-05 11:54:51', NULL, NULL),
(62, 'Dranreb', NULL, 'Pagulong', NULL, NULL, 'dranreb.pagulong@gmail.com', NULL, NULL, 13, 7, 1, '2025-09-28', 77, 67, '2025-10-05 12:56:22', '2025-10-08 09:38:59', NULL, NULL),
(63, 'Zeus', NULL, 'Mendoza', NULL, NULL, 'zeusmendoza@gmail.com', NULL, NULL, 13, 7, 1, '2025-09-28', 77, 67, '2025-10-05 12:57:04', '2025-10-08 09:38:50', NULL, NULL),
(64, 'Jade Ann', NULL, 'Dulin', NULL, NULL, 'jade@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-05 16:10:19', '2025-10-05 16:10:19', NULL, NULL),
(65, 'Elis', NULL, 'Umali', NULL, NULL, 'elis@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-05 22:44:10', '2025-10-05 22:44:10', NULL, NULL),
(66, 'Justin John', NULL, 'Flora', NULL, NULL, 'justin@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 85, NULL, '2025-10-08 07:36:59', '2025-10-08 07:36:59', NULL, NULL),
(67, 'Jhoemar', NULL, 'Alcantara', NULL, NULL, 'ramoejh@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 85, NULL, '2025-10-08 09:38:33', '2025-10-08 09:38:33', NULL, NULL),
(68, 'Jaylord', NULL, 'Ramos', NULL, NULL, 'jaylord@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-05', 88, 41, '2025-10-08 09:40:14', '2025-10-08 09:40:41', NULL, NULL),
(71, 'Prince', NULL, 'Jimenez', NULL, NULL, 'prince@gmail.com', NULL, NULL, 13, 7, 1, NULL, 107, 72, '2025-10-09 08:15:11', '2025-10-09 08:20:10', NULL, NULL),
(72, 'Mark Joseph', NULL, 'Sedilla', NULL, NULL, 'mj@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 106, NULL, '2025-10-09 08:20:03', '2025-10-09 08:20:03', NULL, NULL),
(73, 'Christian', NULL, 'Tanigers', NULL, NULL, 'Chris@gmail.com', NULL, NULL, 13, 7, 1, NULL, 107, 72, '2025-10-09 08:22:37', '2025-10-09 08:38:39', NULL, NULL),
(74, 'Cyrus', NULL, 'Delgado', NULL, NULL, 'cyrus@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-09', 107, 72, '2025-10-09 08:27:14', '2025-10-09 08:38:34', NULL, NULL),
(82, 'Jared', NULL, 'Cambiado', NULL, NULL, 'jared@gmail.com', NULL, NULL, 13, 7, 1, NULL, 107, 72, '2025-10-09 08:37:28', '2025-10-09 08:38:29', NULL, NULL),
(83, 'Dante', NULL, 'Baraca', NULL, NULL, 'baraca@gmail.com', NULL, NULL, 13, 7, 1, NULL, 107, 72, '2025-10-09 08:38:02', '2025-10-09 08:38:24', NULL, NULL),
(84, 'Jhanharroshin', NULL, 'Moran-Glabo', NULL, NULL, 'jhab@gmail.con', NULL, NULL, 13, 7, 1, NULL, 107, 72, '2025-10-09 08:40:21', '2025-10-16 10:02:19', NULL, NULL),
(85, 'John Michael', NULL, 'Naluis', NULL, NULL, 'jm@gmail.com', NULL, NULL, 13, 7, 1, NULL, 107, NULL, '2025-10-09 08:41:40', '2025-10-09 08:41:40', NULL, NULL),
(87, 'Dareen', NULL, 'Rufo', NULL, NULL, 'darinroiss@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 85, NULL, '2025-10-11 07:06:49', '2025-10-11 07:15:51', NULL, NULL),
(88, 'Sean', NULL, 'Doroja', NULL, NULL, 'sean@gmail.com', NULL, NULL, 13, 7, 1, NULL, 74, 87, '2025-10-11 07:22:14', '2025-10-11 07:22:38', NULL, NULL),
(89, 'Mycole', NULL, 'Aguilar', '1997-10-22', NULL, 'mycole@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 90, NULL, '2025-10-17 04:10:34', '2025-10-17 04:10:34', NULL, NULL),
(90, 'Areej', NULL, 'Aji', NULL, NULL, 'areej@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 90, 89, '2025-10-17 04:13:47', '2025-10-19 22:21:47', NULL, NULL),
(91, 'Grace', NULL, 'Fernandez', NULL, NULL, 'sheilaballano2@gmail.com', NULL, NULL, 14, 7, 2, '2025-10-12', 98, 255, '2025-10-17 06:34:21', '2025-10-21 10:51:19', NULL, NULL),
(92, 'Vanessa', NULL, 'Arroyo', NULL, NULL, 'vanessaarroyo@gmail.com', NULL, NULL, 13, 7, 1, '2025-08-30', 100, 64, '2025-10-19 06:57:49', '2025-10-19 18:44:49', NULL, NULL),
(93, 'Jasmin', NULL, 'De Luna', NULL, NULL, 'jasmin@gmail.com', NULL, 'BGC', 14, 7, 1, '2025-04-17', 100, 64, '2025-10-19 06:59:06', '2025-10-19 06:59:06', NULL, NULL),
(94, 'Lyka', NULL, 'Bunuan', NULL, NULL, 'lyka@gmail.com', NULL, 'BGC', 13, 7, 1, '2025-04-17', 100, 64, '2025-10-19 07:01:05', '2025-10-19 07:01:05', NULL, NULL),
(216, 'Jeriesh', NULL, 'Segismundo', NULL, NULL, 'jeriesh@gmail.com', NULL, 'BGC', 13, 7, 1, '2025-05-14', 100, 64, '2025-10-19 07:43:28', '2025-10-19 07:43:28', NULL, NULL),
(234, 'Aliah', NULL, 'Mayor', NULL, NULL, 'aliah@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 97, 237, '2025-10-19 19:10:47', '2025-10-21 10:51:04', NULL, NULL),
(236, 'Phoebe Chiara', NULL, 'Millora', NULL, NULL, 'phoebe@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 97, 237, '2025-10-19 19:17:31', '2025-10-21 10:51:45', NULL, NULL),
(237, 'Regine', NULL, 'Catapang', NULL, NULL, 'regine@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 97, NULL, '2025-10-19 22:10:33', '2025-10-19 22:10:33', NULL, NULL),
(238, 'Akija', NULL, 'Rabina', NULL, NULL, 'rabina@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 92, 262, '2025-10-19 22:16:15', '2025-10-21 10:50:16', NULL, NULL),
(239, 'Crisamona Jane', NULL, 'Cejane', NULL, NULL, 'crisamona@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 92, 262, '2025-10-19 22:17:33', '2025-10-21 10:43:08', NULL, NULL),
(240, 'Alma ', NULL, 'Ignacio', NULL, NULL, 'alma@gmail.com', NULL, NULL, 14, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:18:51', '2025-10-21 10:52:14', NULL, NULL),
(241, 'Leslie ', NULL, 'Ignacio', NULL, NULL, 'leslie@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:20:16', '2025-10-21 10:54:13', NULL, NULL),
(242, 'Shen', NULL, 'Del rosario', NULL, NULL, 'shen@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:21:53', '2025-10-21 10:48:48', NULL, NULL),
(243, 'Joy', NULL, 'Alegre', NULL, NULL, 'joy@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:23:28', '2025-10-21 10:47:34', NULL, NULL),
(244, 'Anna', NULL, 'Estanislao', NULL, NULL, 'anna@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:24:54', '2025-10-21 10:49:00', NULL, NULL),
(245, 'Elsa', NULL, 'Javier', NULL, NULL, 'elsa@gmail.com', NULL, NULL, 14, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:28:54', '2025-10-21 10:54:27', NULL, NULL),
(246, 'Lina', NULL, 'Lantin', NULL, NULL, 'lina@gmail.com', NULL, NULL, 14, 7, 1, '2025-10-12', 98, 255, '2025-10-20 02:30:11', '2025-10-21 10:54:38', NULL, NULL),
(247, 'Maryann ', NULL, 'Roque', NULL, NULL, 'maryann@gmail.com', NULL, 'Lancaster Cavite', 14, 8, NULL, NULL, 98, NULL, '2025-10-20 02:31:20', '2025-10-20 02:31:20', NULL, NULL),
(248, 'Vivian ', NULL, 'Totto', NULL, NULL, 'vivian@gmail.com', NULL, 'La huerta Parañaque', 15, 8, NULL, NULL, 98, NULL, '2025-10-20 02:37:42', '2025-10-20 02:37:42', NULL, NULL),
(249, 'Katrina', NULL, 'Lantin', NULL, NULL, 'katrina@gmail.com', NULL, 'Lancaster Cavite', 14, 8, NULL, NULL, 98, NULL, '2025-10-20 02:38:42', '2025-10-20 02:38:42', NULL, NULL),
(250, 'Mutya', NULL, 'Manalo', NULL, NULL, 'mutya@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:23:32', '2025-10-20 13:23:32', NULL, NULL),
(252, 'Jenine', NULL, 'Jamero', NULL, NULL, 'jenine@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:25:37', '2025-10-20 13:25:37', NULL, NULL),
(253, 'Dia ', NULL, 'Enguerra', NULL, NULL, 'dia@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:26:37', '2025-10-20 13:26:37', NULL, NULL),
(254, 'Eezy', NULL, 'Escol', NULL, NULL, 'eezy@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:27:17', '2025-10-20 13:27:17', NULL, NULL),
(255, 'Sheila', NULL, 'Ballano', NULL, NULL, 'sheila@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 89, NULL, '2025-10-20 13:28:19', '2025-10-21 10:42:32', NULL, NULL),
(256, 'Kim', NULL, 'Baraquel', NULL, NULL, 'kim@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:29:03', '2025-10-20 13:29:03', NULL, NULL),
(257, 'Kimberly', NULL, 'Paragas', NULL, NULL, 'kimmy@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:29:29', '2025-10-20 13:29:29', NULL, NULL),
(258, 'Kayzee', NULL, 'Arquines', NULL, NULL, 'kayzee@gmail.com', NULL, NULL, 14, 8, NULL, NULL, 89, NULL, '2025-10-20 13:30:12', '2025-10-20 13:30:12', NULL, NULL),
(259, 'CJ', NULL, 'Gapi', NULL, NULL, 'chess@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:30:43', '2025-10-20 13:30:43', NULL, NULL),
(260, 'Stephanie', NULL, 'Collado', NULL, NULL, 'steph@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 89, NULL, '2025-10-20 13:31:16', '2025-10-20 13:31:16', NULL, NULL),
(262, 'April', NULL, 'Mendoza', NULL, NULL, 'april@gmail.com', NULL, NULL, 13, 8, NULL, NULL, 92, NULL, '2025-10-20 13:36:17', '2025-10-20 13:36:17', NULL, NULL),
(264, 'Aljon Matthew', NULL, 'Agao', NULL, NULL, 'agao@gmail.com', NULL, NULL, 13, 7, 1, '2025-10-26', 78, 36, '2025-10-26 09:34:46', '2025-10-26 09:34:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_types`
--

CREATE TABLE `member_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_types`
--

INSERT INTO `member_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(7, 'VIP', 'Very Important Person', NULL, NULL),
(8, 'Consolidator', 'Consolidator', NULL, NULL);

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
(1, '0000_01_01_000000_create_statuses_table', 1),
(2, '0000_01_01_000001_create_roles_table', 1),
(3, '0001_01_01_000000_create_users_table', 1),
(4, '0001_01_01_000001_create_cache_table', 1),
(5, '0001_01_01_000002_create_jobs_table', 1),
(6, '0001_01_01_000003_create_g12_leaders_table', 1),
(7, '0001_01_01_000004_create_member_types_table', 1),
(8, '2025_09_19_062113_create_role_user_table', 1),
(9, '2025_09_20_081643_create_members_table', 1),
(10, '2025_09_20_081645_create_start_up_your_new_life_table', 1),
(11, '2025_09_20_081646_create_sunday_services_table', 1),
(12, '2025_09_20_081647_create_start_up_your_new_life_lessons_table', 2),
(13, '2025_09_20_081648_create_cell_groups_table', 3),
(14, '2025_09_20_081649_create_lifeclass_candidates_table', 4),
(15, '2025_09_20_163239_add_lesson_completion_tracking_to_start_up_your_new_life_table', 5),
(16, '2025_09_20_164607_add_consolidator_to_members_table', 6),
(18, '2025_09_20_165941_update_consolidator_column_to_foreign_key', 7),
(19, '2025_09_20_172606_add_session_tracking_to_sunday_services_table', 8),
(20, '2025_09_20_172653_add_session_tracking_to_cell_groups_table', 8),
(21, '2025_09_20_221634_add_role_to_users_table', 9),
(22, '2025_09_21_020730_add_g12_leader_id_to_users_table', 10),
(23, '2025_09_21_161923_add_unique_constraint_to_members_table', 11),
(24, '2025_09_22_005450_fix_consolidator_foreign_key_cascade_rules', 12),
(25, '2025_09_22_005553_add_soft_deletes_to_members_table', 12),
(26, '2025_09_22_005648_create_audit_logs_table', 12),
(27, '2025_09_22_013933_fix_unique_constraint_for_soft_deletes_on_members_table', 13),
(30, '2025_09_22_034601_create_vip_statuses_table', 14),
(31, '2025_09_22_034700_add_vip_status_id_to_members_table', 14),
(32, '2025_09_22_045049_fix_unique_constraint_for_active_members_only', 15),
(34, '2025_09_22_051857_remove_soft_delete_from_members_table', 16),
(35, '2025_09_22_063618_add_user_id_to_g12_leaders_table', 17),
(39, '2025_09_22_074019_add_parent_id_to_g12_leaders_table', 18),
(40, '2025_09_22_075229_remove_lesson_number_from_start_up_your_new_life_table', 19),
(41, '2025_09_23_035551_add_search_indexes_to_database_tables', 20),
(42, '2025_01_20_000000_add_performance_indexes', 21),
(43, '2025_10_01_000001_add_consolidation_date_to_members_table', 22),
(44, '2025_10_07_221421_add_optimized_composite_indexes_for_queries', 23),
(45, '2025_10_08_113001_add_unique_constraints_to_training_modules', 24),
(46, '2025_10_10_103050_create_life_class_lessons_table', 25),
(47, '2025_10_10_103119_add_lesson_completion_dates_to_lifeclass_candidates_table', 25),
(48, '2025_10_11_000000_add_g12_leaders_hierarchy_indexes', 25),
(49, '2025_10_11_000002_create_sol_1_lessons_table', 26),
(50, '2025_10_11_000003_add_wedding_anniversary_date_to_members_table', 26),
(51, '2025_10_11_000010_create_sol_1_table', 26),
(52, '2025_10_11_000011_create_sol_1_candidates_table', 26),
(53, '2025_10_12_000001_create_sol_levels_table', 26),
(54, '2025_10_12_000002_rename_sol_1_to_sol_profiles', 26),
(55, '2025_10_12_000003_update_sol_1_candidates_foreign_key', 26),
(56, '2025_10_13_033515_update_lifeclass_candidates_rename_qualified_date_add_graduation', 26),
(57, '2025_10_13_103705_add_indexes_to_sol_tables', 26),
(58, '2025_10_14_000001_create_sol3_candidates_table', 26),
(59, '2025_10_14_033027_drop_unused_lesson_metadata_tables', 26),
(60, '2025_10_14_044518_create_sol_2_candidates_table', 26),
(61, '2025_10_14_084344_add_equipping_role_to_users_table', 26),
(62, '2025_10_14_100001_rename_sol3_candidates_to_sol_3_candidates', 26),
(63, '2025_10_14_100002_add_life_class_to_sol_levels', 26),
(64, '2025_10_14_150000_add_sol_profile_id_to_lifeclass_candidates', 26),
(65, '2025_10_14_200000_remove_life_class_from_sol_levels', 26);

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(9, 'admin', 'Administrator', NULL, NULL),
(10, 'g12 leader', 'G12 Leader', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3vLlUeqcS4dr0J8OZURoikd0jFyyZ7Dfm2kT1vjM', NULL, '182.130.22.49', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWNtckl2Wmd0WllSbEhoV2xBWm5XaGVlZnBGbDF3cVRQb1RaSFJveiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cHM6Ly83Mi42MC4xOTguOC9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwczovLzcyLjYwLjE5OC44L2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761539202),
('bHkWlP89z5ShyOPgykbyIK2cxfmf5HIiR2Z8YRPj', NULL, '43.153.10.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWlSdXU1NTZmWGJFdmZRY0pDdENJWG1XaktNRzdhWFJtdzdXSEtmdyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly93d3cudGtka29kZWUub3JnL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZy9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761536955),
('cuaNFhbMBTg4eecy6mPFdJH4d4HXHkusESuuWqGT', NULL, '35.203.211.245', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNkJtY3dHSXA5d0VWU0JRTEZHckVScjhhclJCdFlFcTh6cDdhV25kUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly93d3cudGtka29kZWUub3JnL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZy9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761541621),
('CvSV9UfJ7nkvuuulFou3R0Qyk6Nz3Yz3XKKe2OIS', NULL, '116.162.226.24', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR09MVldSYVhtUHJyN1ppMDNaQlRPZklPM1phblYxdlRGVW1NUTlXQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vNzIuNjAuMTk4LjgvYWRtaW4vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761538551),
('e7wERZ9IUKFXviWJGhxJZU7z1eK6ui1kddLMbzfq', NULL, '116.162.226.24', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmROYUpHUG15cW1Cb3ZDZzlreWx5NlAyZWphV0htWUZ2Z3ZZTkdodiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vNzIuNjAuMTk4LjgvYWRtaW4vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761538552),
('EixhqlOjOkFJYUiMKZEKrIDtsRPn7zotz5tVI9zj', NULL, '116.162.226.24', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXUzbUpMbTd3MjFYSDUwTXRKdm00Y1lYeWhoWnpJY3NmNWlGMjJxZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vNzIuNjAuMTk4LjgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761538551),
('KhB7PnNBIRH9fRxcEkomY0zV3KJgR3N4C57khzOm', NULL, '116.162.226.24', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWNObjRxSXpaVjRHNzh6N0pKTGtNNUNtMjhQRFdZV2JOak5MZ0VyNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cHM6Ly83Mi42MC4xOTguOC9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwczovLzcyLjYwLjE5OC44L2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761538550),
('mTwRi2ayl9diBLBRDWr4YSOXv6I9ExDCL0wGh45l', NULL, '182.130.22.49', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzluVlFPOUdOWXNTSEc2SkI3MXlJanBSSzJjQ3hnWjhGN3BDZXRNZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vNzIuNjAuMTk4LjgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761539202),
('MvrkYOWEYawWapexF72CH3kjUhMKNk4UgtnU1JHG', NULL, '116.162.226.24', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSmJwdkViNzh5cmxYZnVuZndLWFQ1NVpVbzg5VDl1amlNakZIQWRBTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cHM6Ly83Mi42MC4xOTguOC9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwczovLzcyLjYwLjE5OC44L2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761538552),
('qBTfeNA15pRkxXTj5TpMNujlSTvCHFsgovQXCvpN', NULL, '43.153.10.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXV2a29zaE9VZVNObWJIRmhGYVgwM0o5V2VYZ0RFaHk2M3pyUmY5UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761536954),
('qgfDPNOv8VU15d9EyAhiqpUmyGO9W4IapboFfcAX', NULL, '35.203.211.245', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHZjVjg5dGZTbDVId2VhNnQxam9pMEtxZDN6NGlucG1vY1dwNFRPMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761541621),
('rftKcx5gZI4OIQU27O7eVevC4JKxKqs3P6ukfPrO', NULL, '43.153.10.83', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnNYMWZEaUxKWU5najF4b0diWmswOUl4UEpYM1NqTWloS2ZZYWRYUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZy9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761536957),
('SC9jN037pN5TdcpA5hQ6OyWXa5DIplricrMTxKSJ', NULL, '182.130.22.49', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnJyZUtscXF0ekpFSkNkZjBqc09hUU1CMkRoWGdwRHU1TkI3MVdoZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vNzIuNjAuMTk4LjgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761539201),
('SjarGjVn0huWfnuWMgzBMaHK7CHnOvlg29sQv7mM', NULL, '35.203.211.245', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3BnQkx2YWtxZzF5WTZ3N2RKOTBxS3kya0hDT096RjZ1RG9FMVVIOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3LnRrZGtvZGVlLm9yZy9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761541622),
('sNXfqPaRJaUfmDQXDxKtW6RG9xVWbfFRETL9QlRI', 17, '116.50.203.116', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUTNCZlBpdjE4RzJzRHExclVuRGVENWtmZjhOemtnSXhiNnBlcUtpYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vdGtka29kZWUub3JnL2FkbWluIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTc7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiQyOHRWZjM2N3ZZNDdPaVY4Z1VPRlZPSnpsYjZabEVZT21HTjVRYi9ob292cGNWTkxsNGFxYSI7czoyNToidXNlcl9zZXNzaW9uX2ludGVncml0eV8xNyI7YTozOntzOjEwOiJ1c2VyX2FnZW50IjtzOjExMToiTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzE0MS4wLjAuMCBTYWZhcmkvNTM3LjM2IjtzOjEwOiJpcF9hZGRyZXNzIjtzOjE0OiIxMTYuNTAuMjAzLjExNiI7czoxMDoiY3JlYXRlZF9hdCI7TzoyNToiSWxsdW1pbmF0ZVxTdXBwb3J0XENhcmJvbiI6Mzp7czo0OiJkYXRlIjtzOjI2OiIyMDI1LTEwLTI3IDA1OjIxOjU2LjQxNDM4MCI7czoxMzoidGltZXpvbmVfdHlwZSI7aTozO3M6ODoidGltZXpvbmUiO3M6MzoiVVRDIjt9fX0=', 1761542998),
('tqd5UBtnw7pSJUKMh8hSCBwNtghKY82q4blul8bK', NULL, '182.130.22.49', '', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUFdBc2wxQUg5TXdHOHpCd3dYOUtmZ1dqMEZwdFBveWQxUFNuRjh4UyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNToiaHR0cHM6Ly83Mi42MC4xOTguOC9hZG1pbiI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI1OiJodHRwczovLzcyLjYwLjE5OC44L2FkbWluIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761539202),
('xMRwTQi7Gx38wDoph0Qrq11zTYjsU0V0cvVlKkeX', NULL, '116.162.226.24', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVdUNDUxYTUxRjVvQ1BoZnZTaE9SbHh5dzM5ODFrM1owTk96WFpPVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vNzIuNjAuMTk4LjgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1761538550);

-- --------------------------------------------------------

--
-- Table structure for table `sol_1_candidates`
--

CREATE TABLE `sol_1_candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `sol_profile_id` bigint UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL,
  `graduation_date` date DEFAULT NULL,
  `lesson_1_completion_date` date DEFAULT NULL,
  `lesson_2_completion_date` date DEFAULT NULL,
  `lesson_3_completion_date` date DEFAULT NULL,
  `lesson_4_completion_date` date DEFAULT NULL,
  `lesson_5_completion_date` date DEFAULT NULL,
  `lesson_6_completion_date` date DEFAULT NULL,
  `lesson_7_completion_date` date DEFAULT NULL,
  `lesson_8_completion_date` date DEFAULT NULL,
  `lesson_9_completion_date` date DEFAULT NULL,
  `lesson_10_completion_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sol_1_candidates`
--

INSERT INTO `sol_1_candidates` (`id`, `sol_profile_id`, `enrollment_date`, `graduation_date`, `lesson_1_completion_date`, `lesson_2_completion_date`, `lesson_3_completion_date`, `lesson_4_completion_date`, `lesson_5_completion_date`, `lesson_6_completion_date`, `lesson_7_completion_date`, `lesson_8_completion_date`, `lesson_9_completion_date`, `lesson_10_completion_date`, `notes`, `created_at`, `updated_at`) VALUES
(8, 12, '2025-10-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:07:11', '2025-10-26 09:07:11'),
(10, 15, '2025-10-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 10:54:03', '2025-10-26 10:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `sol_2_candidates`
--

CREATE TABLE `sol_2_candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `sol_profile_id` bigint UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL,
  `graduation_date` date DEFAULT NULL,
  `lesson_1_completion_date` date DEFAULT NULL,
  `lesson_2_completion_date` date DEFAULT NULL,
  `lesson_3_completion_date` date DEFAULT NULL,
  `lesson_4_completion_date` date DEFAULT NULL,
  `lesson_5_completion_date` date DEFAULT NULL,
  `lesson_6_completion_date` date DEFAULT NULL,
  `lesson_7_completion_date` date DEFAULT NULL,
  `lesson_8_completion_date` date DEFAULT NULL,
  `lesson_9_completion_date` date DEFAULT NULL,
  `lesson_10_completion_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sol_3_candidates`
--

CREATE TABLE `sol_3_candidates` (
  `id` bigint UNSIGNED NOT NULL,
  `sol_profile_id` bigint UNSIGNED NOT NULL,
  `enrollment_date` date DEFAULT NULL,
  `lesson_1_completion_date` date DEFAULT NULL,
  `lesson_2_completion_date` date DEFAULT NULL,
  `lesson_3_completion_date` date DEFAULT NULL,
  `lesson_4_completion_date` date DEFAULT NULL,
  `lesson_5_completion_date` date DEFAULT NULL,
  `lesson_6_completion_date` date DEFAULT NULL,
  `lesson_7_completion_date` date DEFAULT NULL,
  `lesson_8_completion_date` date DEFAULT NULL,
  `lesson_9_completion_date` date DEFAULT NULL,
  `lesson_10_completion_date` date DEFAULT NULL,
  `graduation_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sol_3_candidates`
--

INSERT INTO `sol_3_candidates` (`id`, `sol_profile_id`, `enrollment_date`, `lesson_1_completion_date`, `lesson_2_completion_date`, `lesson_3_completion_date`, `lesson_4_completion_date`, `lesson_5_completion_date`, `lesson_6_completion_date`, `lesson_7_completion_date`, `lesson_8_completion_date`, `lesson_9_completion_date`, `lesson_10_completion_date`, `graduation_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-10-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 11:05:37', '2025-10-21 11:05:37'),
(2, 2, '2025-10-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 11:15:23', '2025-10-21 11:15:23'),
(3, 3, '2025-10-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 11:57:04', '2025-10-21 11:57:04'),
(4, 4, '2025-10-23', '2025-09-21', '2025-09-28', '2025-10-05', '2025-10-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 14:14:42', '2025-10-23 14:15:19'),
(6, 6, '2025-10-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 14:28:21', '2025-10-23 14:28:21'),
(7, 13, '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', '2025-10-26', NULL, '2025-10-26 09:20:43', '2025-10-26 09:20:43'),
(8, 16, '2025-10-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-27 04:22:47', '2025-10-27 04:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `sol_levels`
--

CREATE TABLE `sol_levels` (
  `id` bigint UNSIGNED NOT NULL,
  `level_number` int NOT NULL COMMENT '1, 2, 3',
  `level_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SOL 1, SOL 2, SOL 3',
  `description` text COLLATE utf8mb4_unicode_ci,
  `lesson_count` int NOT NULL DEFAULT '10' COMMENT 'Number of lessons for this level',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sol_levels`
--

INSERT INTO `sol_levels` (`id`, `level_number`, `level_name`, `description`, `lesson_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'SOL 1', 'School of Leaders Level 1 - Foundation training with 10 core lessons', 10, '2025-10-26 09:05:42', '2025-10-26 09:05:42'),
(2, 2, 'SOL 2', 'School of Leaders Level 2 - Intermediate leadership training', 10, '2025-10-26 09:05:42', '2025-10-26 09:05:42'),
(3, 3, 'SOL 3', 'School of Leaders Level 3 - Advanced leadership and mentoring', 10, '2025-10-26 09:05:42', '2025-10-26 09:05:42');

-- --------------------------------------------------------

--
-- Table structure for table `sol_profiles`
--

CREATE TABLE `sol_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status_id` bigint UNSIGNED NOT NULL,
  `g12_leader_id` bigint UNSIGNED NOT NULL,
  `wedding_anniversary_date` date DEFAULT NULL,
  `is_cell_leader` tinyint(1) NOT NULL DEFAULT '0',
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `current_sol_level_id` bigint UNSIGNED DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sol_profiles`
--

INSERT INTO `sol_profiles` (`id`, `first_name`, `middle_name`, `last_name`, `birthday`, `email`, `phone`, `address`, `status_id`, `g12_leader_id`, `wedding_anniversary_date`, `is_cell_leader`, `member_id`, `current_sol_level_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Guillermo Arturo', NULL, 'Mondoñedo ', '1997-03-16', 'moyarturo@gmail.com', NULL, NULL, 14, 72, '2023-03-19', 0, NULL, 3, NULL, '2025-10-21 10:49:25', '2025-10-27 04:08:11'),
(2, 'John Paul', NULL, 'Maat', NULL, 'jpmaat@gmail.com', NULL, NULL, 14, 78, '2025-10-18', 0, NULL, 3, NULL, '2025-10-21 11:15:17', '2025-10-26 09:42:33'),
(3, 'Joemhel', NULL, 'Cabrera', NULL, 'joemelcabrera@gmail.com', NULL, NULL, 13, 81, NULL, 0, NULL, 3, NULL, '2025-10-21 11:56:58', '2025-10-27 04:07:58'),
(4, 'John Angel', NULL, 'Hinampas', NULL, 'johnangelhinampas@gmail.com', NULL, NULL, 13, 78, NULL, 0, NULL, 3, NULL, '2025-10-23 14:14:35', '2025-10-26 09:42:26'),
(6, 'Justin Dave', NULL, 'Manaytay', NULL, 'justindavemanaytay@gmail.com', NULL, NULL, 13, 108, NULL, 0, NULL, 3, NULL, '2025-10-23 14:28:12', '2025-10-26 10:42:59'),
(12, 'Justin Rain', NULL, 'Pio', NULL, 'donditorre@gmail.com', NULL, NULL, 13, 109, NULL, 0, NULL, 1, NULL, '2025-10-26 09:07:04', '2025-10-26 09:08:19'),
(13, 'Robin', NULL, 'Nombrado', NULL, 'robinnombrado@gmail.com', NULL, NULL, 13, 79, NULL, 0, NULL, 3, NULL, '2025-10-26 09:20:14', '2025-10-27 04:43:46'),
(15, 'Mart Kenly', NULL, 'Brodit', NULL, 'martkenlybrodit@gmail.com', NULL, NULL, 13, 84, NULL, 0, NULL, 1, NULL, '2025-10-26 10:53:55', '2025-10-26 10:53:55'),
(16, 'Michael John', NULL, 'Borabo', NULL, 'michaeljohnborabo@gmail.com', NULL, NULL, 13, 77, NULL, 0, NULL, 3, NULL, '2025-10-27 04:22:34', '2025-10-27 04:22:34'),
(17, 'Matias', NULL, 'Cancino', NULL, 'matiascancino@gmail.com', NULL, NULL, 13, 74, NULL, 0, NULL, 3, NULL, '2025-10-27 04:43:21', '2025-10-27 04:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `start_up_your_new_life`
--

CREATE TABLE `start_up_your_new_life` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lesson_1_completion_date` date DEFAULT NULL,
  `lesson_2_completion_date` date DEFAULT NULL,
  `lesson_3_completion_date` date DEFAULT NULL,
  `lesson_4_completion_date` date DEFAULT NULL,
  `lesson_5_completion_date` date DEFAULT NULL,
  `lesson_6_completion_date` date DEFAULT NULL,
  `lesson_7_completion_date` date DEFAULT NULL,
  `lesson_8_completion_date` date DEFAULT NULL,
  `lesson_9_completion_date` date DEFAULT NULL,
  `lesson_10_completion_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `start_up_your_new_life`
--

INSERT INTO `start_up_your_new_life` (`id`, `member_id`, `notes`, `lesson_1_completion_date`, `lesson_2_completion_date`, `lesson_3_completion_date`, `lesson_4_completion_date`, `lesson_5_completion_date`, `lesson_6_completion_date`, `lesson_7_completion_date`, `lesson_8_completion_date`, `lesson_9_completion_date`, `lesson_10_completion_date`, `created_at`, `updated_at`) VALUES
(3, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-20 08:18:51', '2025-09-27 03:21:01'),
(5, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-21 23:58:55', '2025-09-27 03:21:12'),
(11, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-28 12:11:30', '2025-10-04 12:40:38'),
(12, 51, NULL, '2025-09-18', '2025-09-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-04 13:22:58', '2025-10-04 13:22:58'),
(13, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 03:41:38', '2025-10-05 03:41:38'),
(15, 55, NULL, '2025-08-24', '2025-08-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 09:21:03', '2025-10-05 09:21:03'),
(16, 54, NULL, '2025-02-16', '2025-08-24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 09:23:34', '2025-10-05 09:23:34'),
(17, 56, NULL, '2025-05-18', '2025-05-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 09:25:48', '2025-10-05 09:25:48'),
(18, 58, NULL, '2025-09-13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-05 11:33:30', '2025-10-05 11:33:30'),
(23, 68, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 01:53:13', '2025-10-09 01:53:13'),
(28, 62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:54:58', '2025-10-09 03:54:58'),
(29, 63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 03:55:09', '2025-10-09 03:55:09'),
(31, 71, NULL, '2025-09-22', '2025-10-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:15:56', '2025-10-09 08:15:56'),
(32, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:27:31', '2025-10-09 08:27:31'),
(33, 74, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:27:36', '2025-10-09 08:27:36'),
(34, 83, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:38:44', '2025-10-09 08:38:44'),
(35, 82, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:38:47', '2025-10-09 08:38:47'),
(36, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:44:45', '2025-10-09 08:44:45'),
(37, 85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-09 08:44:51', '2025-10-09 08:44:51'),
(38, 90, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-19 15:49:28', '2025-10-19 15:49:28'),
(39, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-19 19:11:20', '2025-10-19 19:11:20'),
(40, 238, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:08:33', '2025-10-20 00:08:33'),
(41, 234, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:42:55', '2025-10-20 00:42:55'),
(42, 239, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:04', '2025-10-20 00:43:04'),
(43, 91, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:09', '2025-10-20 00:43:09'),
(44, 93, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:13', '2025-10-20 00:43:13'),
(45, 216, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:18', '2025-10-20 00:43:18'),
(46, 94, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:25', '2025-10-20 00:43:25'),
(47, 236, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 00:43:29', '2025-10-20 00:43:29'),
(48, 240, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 02:20:53', '2025-10-20 02:20:53'),
(49, 241, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 02:21:02', '2025-10-20 02:21:02'),
(50, 88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 02:21:07', '2025-10-20 02:21:07'),
(51, 242, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 02:23:14', '2025-10-20 02:23:14'),
(52, 244, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-20 09:58:05', '2025-10-20 09:58:05'),
(53, 245, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 10:23:34', '2025-10-21 10:23:34'),
(54, 243, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-21 10:23:41', '2025-10-21 10:23:41'),
(55, 246, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 13:35:19', '2025-10-23 13:35:19'),
(57, 264, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-26 09:34:56', '2025-10-26 09:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `start_up_your_new_life_lessons`
--

CREATE TABLE `start_up_your_new_life_lessons` (
  `id` bigint UNSIGNED NOT NULL,
  `lesson_number` tinyint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `start_up_your_new_life_lessons`
--

INSERT INTO `start_up_your_new_life_lessons` (`id`, `lesson_number`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lesson 1', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(2, 2, 'Lesson 2', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(3, 3, 'Lesson 3', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(4, 4, 'Lesson 4', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(5, 5, 'Lesson 5', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(6, 6, 'Lesson 6', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(7, 7, 'Lesson 7', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(8, 8, 'Lesson 8', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(9, 9, 'Lesson 9', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39'),
(10, 10, 'Lesson 10', NULL, '2025-09-20 03:39:39', '2025-09-20 03:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(13, 'single', NULL, NULL, NULL),
(14, 'married', NULL, NULL, NULL),
(15, 'widowed', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sunday_services`
--

CREATE TABLE `sunday_services` (
  `id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `sunday_service_1_date` date DEFAULT NULL,
  `sunday_service_2_date` date DEFAULT NULL,
  `sunday_service_3_date` date DEFAULT NULL,
  `sunday_service_4_date` date DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sunday_services`
--

INSERT INTO `sunday_services` (`id`, `member_id`, `sunday_service_1_date`, `sunday_service_2_date`, `sunday_service_3_date`, `sunday_service_4_date`, `service_date`, `completed`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-09-20 09:40:41', '2025-10-01 10:58:52'),
(2, 7, '2025-09-21', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-21 23:59:17', '2025-09-21 23:59:17'),
(7, 48, '2025-09-28', NULL, NULL, NULL, NULL, 0, NULL, '2025-09-28 12:11:48', '2025-09-28 12:11:54'),
(8, 51, '2025-09-20', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-04 13:23:23', '2025-10-04 13:23:30'),
(9, 50, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-05 03:41:22', '2025-10-05 03:41:22'),
(10, 58, '2025-10-05', NULL, NULL, NULL, NULL, 0, NULL, '2025-10-05 11:34:13', '2025-10-05 11:34:13'),
(11, 63, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:55:15', '2025-10-09 03:55:19'),
(12, 62, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:55:27', '2025-10-09 03:55:27'),
(13, 68, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:55:33', '2025-10-09 03:55:33'),
(14, 56, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:56:16', '2025-10-09 03:56:16'),
(15, 55, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:56:26', '2025-10-09 03:56:26'),
(16, 54, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 03:56:51', '2025-10-09 03:56:51'),
(18, 71, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:16:24', '2025-10-09 08:16:24'),
(19, 73, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:27:41', '2025-10-09 08:27:41'),
(20, 74, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:27:49', '2025-10-09 08:27:49'),
(21, 83, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:38:52', '2025-10-09 08:38:52'),
(22, 82, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:46:07', '2025-10-09 08:46:07'),
(23, 84, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:46:11', '2025-10-09 08:46:11'),
(24, 85, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-09 08:46:16', '2025-10-09 08:46:16'),
(25, 234, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 00:08:20', '2025-10-20 00:08:20'),
(26, 90, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 00:43:34', '2025-10-20 00:43:34'),
(27, 239, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 00:43:40', '2025-10-20 00:43:40'),
(28, 91, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:17:53', '2025-10-20 02:17:53'),
(29, 240, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:18:57', '2025-10-20 02:18:57'),
(30, 216, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:19:01', '2025-10-20 02:19:01'),
(31, 94, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:19:06', '2025-10-20 02:19:06'),
(32, 93, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:19:13', '2025-10-20 02:19:13'),
(33, 244, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 02:28:20', '2025-10-20 02:28:20'),
(34, 88, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-20 03:08:55', '2025-10-20 03:08:55'),
(35, 238, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-23 13:35:28', '2025-10-23 13:35:28'),
(37, 245, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-26 09:33:36', '2025-10-26 09:33:36'),
(38, 243, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-26 09:33:40', '2025-10-26 09:33:40'),
(39, 241, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-26 09:33:45', '2025-10-26 09:33:45'),
(40, 264, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-26 09:35:00', '2025-10-26 09:35:00'),
(41, 246, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-26 09:40:09', '2025-10-26 09:40:09'),
(42, 236, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-27 04:12:10', '2025-10-27 04:12:10'),
(43, 242, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-27 04:12:15', '2025-10-27 04:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','leader','equipping','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `g12_leader_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `g12_leader_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(11, 'Admin', 'rsedilla@gmail.com', 'admin', NULL, NULL, '$2y$12$3CrYRQmW9cK.Afq7bTlrsu38VX03ZYvvMTMmpEos9KapTr6vZRgjO', NULL, '2025-09-20 19:20:57', '2025-09-21 08:03:54'),
(12, 'Manuel Domingo', 'manny@gmail.com', 'leader', 85, NULL, '$2y$12$L.y5nlPux4A9kJaTmiTT.OvkBusJZoIvL2V4vw5cvSpFl3s4Qazje', NULL, '2025-09-20 19:20:57', '2025-10-04 14:36:34'),
(13, 'Bon Ryan Fran', 'bonryan@gmail.com', 'leader', 85, '2025-09-20 19:21:06', '$2y$12$kSdHMw2hQT6z.sfTXg494.HWSdW2UwgXzTHPlq/svtCnN1HSA8/di', 'MxgqH3vweUWLno1xhnqnwaJMUG45fKiYsJmJVZyTJpF59LVZ0cDGyOQHy6gs', '2025-09-20 19:21:06', '2025-10-08 07:30:50'),
(14, 'John Louie Arenal', 'johnlouie@gmail.com', 'leader', 85, NULL, '$2y$12$W0JOKNYuSjrNE.3p3TtpyeB.xsGk9EQSUYSMwpkcq9iS6eHtUbaWW', 'lE55qxKyRyIhXiVPBPxdWoZ0d0tqo7K1seWlmfWGM04j7g6smnntYPTtMqtK', '2025-09-21 08:03:54', '2025-10-26 09:41:49'),
(16, 'Lester De Vera', 'lester@gmail.com', 'leader', 85, NULL, '$2y$12$GYlbUiebnOMMXe4NJZlLXevGK717py8W2lrvii3ZrY7iCdKy3Hx2m', 'Ixgje10vP8r4YiseXQrWDajfJpnAjwrWqRKS7s2YAC3gwQxoBaQNxZ0qhEEP', '2025-09-21 08:13:27', '2025-10-08 07:31:19'),
(17, 'Raymond Sedilla', 'mon@gmail.com', 'leader', 104, NULL, '$2y$12$28tVf367vY47OiV8gUOFVOJzlb6ZlEYOmGN5Qb/hoovpcVNLl4aqa', NULL, '2025-09-21 23:47:01', '2025-10-26 03:28:51'),
(19, 'Jhoe Mar Alcantara', 'ramoejh@gmail.com', 'leader', 85, NULL, '$2y$12$bmdPMp6U/ZeFa2IwYpI8pOc9uoFJ6ynqv13grQAcvx8QXWZYtlViW', NULL, '2025-09-27 12:38:12', '2025-10-08 07:31:41'),
(20, 'Phillip Wilson Grande', 'phillipwilson.grande@gmail.com', 'leader', 85, NULL, '$2y$12$TX3JGN/DHWt3m3T64RJ86.FOVxfnWoev7o7q45L4aXXP64RBM3Xl2', NULL, '2025-09-27 13:23:32', '2025-10-05 12:50:29'),
(21, 'John Ramil Rabe', 'johnramilrabe@gmail.com', 'leader', 85, NULL, '$2y$12$HWVszjP5sTu21DdHd/i3tuLak3vOmeMNNDnih8mth4W5k7DX4oeGC', 'XsI8dHuPjFTnJt7O39SU6VvALymezqPe5x2LtQh05emyKkxRtdFjc9glXK0a', '2025-09-28 11:45:28', '2025-10-26 09:19:01'),
(22, 'John Dave Angeles', 'johndave@gmail.com', 'leader', 77, NULL, '$2y$12$aeg9NOYfi...c2tvOKMPxedfuY3jp2S/6OmSk3yEdQhNXQMC0Zdvy', NULL, '2025-10-02 13:21:58', '2025-10-02 13:21:58'),
(23, 'Ranee Nicole Sedilla', 'ranee@gmail.com', 'leader', 104, NULL, '$2y$12$qpORjYbE.gA0WIc1JVxk4u6clOdEMw1FSWn86VHxKh2EwAz83DHyO', 'rCIwflpnwQasar51rtwI47uImld46WRT2dhonPetIzsKItzD3B5p4k14xNlL', '2025-10-04 12:43:28', '2025-10-08 07:26:27'),
(24, 'Elis Umali', 'elis@gmail.com', 'leader', 89, NULL, '$2y$12$.zXmjvkU8iEuNVV6Q5H.NuDzHD2WiimWVlRbeD2Mpae6iqdEKI58a', NULL, '2025-10-04 13:18:26', '2025-10-04 13:18:26'),
(25, 'Francisco Hornilla', 'francis@gmail.com', 'leader', 85, NULL, '$2y$12$lBPJ/uCQTovF9DMXkDoZVOjMILed3pS05eEfK1GZGqE4SzWtHflEa', NULL, '2025-10-04 14:05:56', '2025-10-04 14:07:21'),
(26, 'Mark Filbert Valdez', 'pbmapagmahal@gmail.com', 'leader', 85, NULL, '$2y$12$g/H1A0Ex3uqOCzVoWOcR1OkA4TlSfjApFykfWu8ijEUIYBhAuAbF.', 'ivVYGRrQzpCYGetsWkFkUJ3quw1Iaa75a0r6OAOL4rMzJrfKZx5RCh5ZVXd2', '2025-10-05 08:58:39', '2025-10-08 07:32:35'),
(27, 'Justin John Flora', 'justinjohnflora@gmail.com', 'leader', 85, NULL, '$2y$12$PAx7L59huJat8chedwUf/OpHSmw4nFbDBIuWqKpJmf5j8Q0zR5mJ.', NULL, '2025-10-05 09:00:20', '2025-10-08 07:32:49'),
(28, 'Dareen Roy Rufo', 'darinroi@gmail.com', 'leader', 85, NULL, '$2y$12$RHjL2tSfOIbeVdT9fM.Q1Op5/uqIxsJ46HKuCM53aRveBHRoBk66a', NULL, '2025-10-05 09:02:41', '2025-10-11 07:21:27'),
(29, 'Ariel Katigbak', 'ajkatigbak@gmail.com', 'leader', 85, NULL, '$2y$12$eEcQ/rcGIfnhI39UxAFBRep8ohG9KGKyHnobV6JGDcmwTO0xqLzIq', 'DIbkSju0BRqETcbLX4t0n1EXo8xms2hK7KITYmAHZtcM9Ej8Mg1iE3vDIqCv', '2025-10-05 09:04:36', '2025-10-05 09:04:36'),
(30, 'Matias Cancino', 'mcancino@gmail.com', 'leader', 74, NULL, '$2y$12$VZbaa.SyK.0vyDnsK7rYWuU/stGU3628DeNL.Wy6Cd9I/cJw9DSjC', 'MRoFa3vD8mEuZ0bD0vOfT6GE3vAwNQkhX3BFMlrLN6Kdj3QnegizjgMiEkSN', '2025-10-05 09:06:07', '2025-10-05 09:06:07'),
(31, 'April Mendoza', 'april@gmail.com', 'leader', 89, NULL, '$2y$12$VBjhKl5v1TKmEvTMMhqcHO5SDz68fT1rA8cOwlnL9X3rVH8oerni.', NULL, '2025-10-05 10:55:41', '2025-10-05 10:55:41'),
(32, 'CJ Gapi', 'chess@gmail.com', 'leader', 89, NULL, '$2y$12$eg6rxodUFGWzLfvnTs5ZKeL6hydkerFpac1Su08Y6B/g/jorhVua6', NULL, '2025-10-05 10:56:53', '2025-10-05 10:56:53'),
(33, 'Dia Enguerra', 'dia@gmail.com', 'leader', 89, NULL, '$2y$12$L.fUNOQex8X/PLaTqtCCL.eGRdmY/JWgyX9bOyGoqBwXwGJw/JQTC', NULL, '2025-10-05 10:57:50', '2025-10-05 10:57:50'),
(34, 'Kim Baraquel', 'kim@gmail.com', 'leader', 89, NULL, '$2y$12$Ch2qGBf5Vs75HkkCW4X4rOSJW/Wx/ERmsPp3IJ.1vDtdE.41TdHuG', NULL, '2025-10-05 11:00:43', '2025-10-05 11:00:43'),
(35, 'Kimberly Paragas', 'kimmy@gmail.com', 'leader', 89, NULL, '$2y$12$ITCf3INUUE5278OK4cJuf.3z.JLxHl2Hk2AebOwjYAYil3Z8Dx5FG', 'CmHx4rUWPBt79d4lvGM0LwaZkch7KTtMSXpzCFFQ4n6PKJMy7ps0PPqM50E5', '2025-10-05 11:01:26', '2025-10-05 11:01:26'),
(36, 'Mutya Manalo', 'mutya@gmail.com', 'leader', 89, NULL, '$2y$12$mvGUt29XZyRAqpfOTEfEXOh6A00FnoJ60yoKoYdwZ/nQ0aU9IiNG2', NULL, '2025-10-05 11:02:01', '2025-10-21 10:43:22'),
(37, 'Sheila Ballano', 'sheila@gmail.com', 'leader', 89, NULL, '$2y$12$2EmoDNuIOiv4VKtdq.12p.DyDBXzahjkvlEVHbik4Co6aPycbVye6', 'ehSBcy4o7EBXiRyWV2swYnIkUzcHKuLn5sb8K0h0CzOV0gPFhjwgsFx4Iuah', '2025-10-05 11:02:54', '2025-10-05 11:03:14'),
(38, 'Stephanie Collado', 'steph@gmail.com', 'leader', 89, NULL, '$2y$12$NGGjili9otdDHBdAMUdPSOoFeSy9m.e.m8VZdC.YQmJlLp0m2av0O', 'y2xkdpXrIVkcGujJTieJ5yVCVvlgRv34yFXYGXkknAjjKEwa1GWytI7nWNs7', '2025-10-05 11:04:13', '2025-10-05 11:04:13'),
(39, 'Jade Ann Dulin', 'jade@gmail.com', 'leader', 89, NULL, '$2y$12$9aJ1jPuq.xuYYiErpjIIzuvYrdQr2VcmbRJGJKF8Yi6tZ6Bsxi/9S', 'BTy3GV4I24WgajEUXid6Krf1buN5xiB9lRYyhoG8dnIHFszpyCsTtJnkLEQi', '2025-10-05 11:05:08', '2025-10-05 16:01:49'),
(40, 'Eezy Escol', 'eezy@gmail.com', 'leader', 89, NULL, '$2y$12$/LjQ4NjbMbGxDs6nEzdwOewWvWmAhy8t0qt7IWf78UTbwbM1/XVf.', NULL, '2025-10-05 12:13:56', '2025-10-05 12:13:56'),
(41, 'Alex Genotiva', 'jaojaolex@gmail.com', 'leader', 82, NULL, '$2y$12$P2Fl6DtqpWGkC8JDrTr6rufVeUkuDUFTF0r01iI0fwg3RtRwkOyMS', NULL, '2025-10-05 12:46:58', '2025-10-05 12:48:43'),
(42, 'John Paul De Jesus', 'jp@gmail.com', 'leader', 103, NULL, '$2y$12$9ugv/qLf89..iF0uPkN7VOjdOMhO7Ru7uKvZCelyfdHDLnHSwJDOi', 'IMlHnI0mKURJSog4nfDFrqRpbdbckLHIQFZpM4qGtkTtO3uxthES7FuxnkMK', '2025-10-06 09:35:10', '2025-10-07 01:21:53'),
(43, 'Oriel Ballano', 'oriel@gmail.com', 'leader', 104, NULL, '$2y$12$82WR2DYO/UmC23V70RyLwOuL6Mo.eLmoxP/u1OQ4bgySp9lHVcSxi', NULL, '2025-10-08 07:23:52', '2025-10-09 02:20:59'),
(45, 'Mark Joseph Sedilla', 'mj@gmail.com', 'leader', 106, NULL, '$2y$12$LDNKY.B8p.OHN8O3c2448eCL/FJuUwvTE3H1pbeMGIgwXr9vwo99G', 'rrUTFjeRTuaro0sqyY2PUYaD3wJoZVTWWVdlhBw1zisGC8PiHQWP1YjmSAKd', '2025-10-09 08:10:39', '2025-10-09 08:11:48'),
(46, 'Daniel Oriel Ballano', 'daniel@gmail.com', 'leader', 104, NULL, '$2y$12$Ydgn6n8KlFeOiYa.Twqs.O2hg5U4oVjQ9dG1qP.glpsgR96F9lvdy', NULL, '2025-10-09 08:10:58', '2025-10-09 08:10:58'),
(47, 'Dondi Torre', 'donditorre@gmail.com', 'leader', 78, NULL, '$2y$12$zoqNJszpGKjPe4xeAyMlze3YgDNrXKkLNbtjmXl1NYuUbXAfrA9mq', NULL, '2025-10-26 05:57:35', '2025-10-26 06:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `vip_statuses`
--

CREATE TABLE `vip_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vip_statuses`
--

INSERT INTO `vip_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'New Believer', NULL, NULL),
(2, 'Recommitment', NULL, NULL),
(3, 'Other Church', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_model_model_id_index` (`model`,`model_id`),
  ADD KEY `audit_logs_user_id_index` (`user_id`),
  ADD KEY `audit_logs_created_at_index` (`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cell_groups`
--
ALTER TABLE `cell_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_member_cell_group` (`member_id`),
  ADD KEY `cell_groups_member_id_foreign` (`member_id`),
  ADD KEY `idx_cell_groups_member_id` (`member_id`),
  ADD KEY `idx_cell_groups_attendance_date` (`attendance_date`),
  ADD KEY `idx_cell_groups_member_attendance_date` (`member_id`,`attendance_date`),
  ADD KEY `idx_cell_member_sessions` (`member_id`,`cell_group_1_date`,`cell_group_4_date`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `g12_leaders`
--
ALTER TABLE `g12_leaders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `g12_leaders_name_unique` (`name`),
  ADD KEY `g12_leaders_user_id_foreign` (`user_id`),
  ADD KEY `g12_leaders_name_index` (`name`),
  ADD KEY `g12_leaders_parent_id_index` (`parent_id`),
  ADD KEY `idx_g12_leaders_name` (`name`),
  ADD KEY `idx_g12_leaders_parent_id` (`parent_id`),
  ADD KEY `idx_g12_leaders_user_parent` (`user_id`,`parent_id`),
  ADD KEY `idx_g12_parent_id` (`parent_id`),
  ADD KEY `idx_g12_parent_user` (`parent_id`,`user_id`),
  ADD KEY `idx_g12_user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lifeclass_candidates`
--
ALTER TABLE `lifeclass_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_member_lifeclass_candidate` (`member_id`),
  ADD KEY `lifeclass_candidates_member_id_foreign` (`member_id`),
  ADD KEY `idx_lifeclass_member_id` (`member_id`),
  ADD KEY `idx_lifeclass_member_leader` (`member_id`),
  ADD KEY `lifeclass_candidates_sol_profile_id_index` (`sol_profile_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_email_unique` (`email`),
  ADD UNIQUE KEY `members_name_unique` (`first_name`,`last_name`),
  ADD UNIQUE KEY `members_active_name_unique` (`active_name_key`),
  ADD KEY `members_first_name_index` (`first_name`),
  ADD KEY `members_last_name_index` (`last_name`),
  ADD KEY `members_email_index` (`email`),
  ADD KEY `members_phone_index` (`phone`),
  ADD KEY `members_g12_leader_id_index` (`g12_leader_id`),
  ADD KEY `members_consolidator_id_index` (`consolidator_id`),
  ADD KEY `members_member_type_id_index` (`member_type_id`),
  ADD KEY `members_status_id_index` (`status_id`),
  ADD KEY `members_vip_status_id_index` (`vip_status_id`),
  ADD KEY `members_full_name_index` (`first_name`,`last_name`),
  ADD KEY `idx_members_search_name` (`first_name`,`last_name`),
  ADD KEY `idx_members_email` (`email`),
  ADD KEY `idx_members_phone` (`phone`),
  ADD KEY `idx_members_status_id` (`status_id`),
  ADD KEY `idx_members_member_type_id` (`member_type_id`),
  ADD KEY `idx_members_g12_leader_id` (`g12_leader_id`),
  ADD KEY `idx_members_consolidator_id` (`consolidator_id`),
  ADD KEY `idx_members_vip_status_id` (`vip_status_id`),
  ADD KEY `idx_members_type_status` (`member_type_id`,`status_id`),
  ADD KEY `idx_members_leader_type` (`g12_leader_id`,`member_type_id`),
  ADD KEY `idx_members_leader_type_status` (`g12_leader_id`,`member_type_id`,`status_id`),
  ADD KEY `idx_members_consolidation_date` (`consolidation_date`),
  ADD KEY `idx_members_consolidator_leader` (`consolidator_id`,`g12_leader_id`),
  ADD KEY `idx_members_names` (`first_name`,`last_name`);

--
-- Indexes for table `member_types`
--
ALTER TABLE `member_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_types_name_unique` (`name`),
  ADD KEY `idx_member_types_name` (`name`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_user_user_id_role_id_unique` (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sol_1_candidates`
--
ALTER TABLE `sol_1_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_sol1_candidate` (`sol_profile_id`),
  ADD KEY `sol_1_candidates_sol_1_id_index` (`sol_profile_id`),
  ADD KEY `sol_1_candidates_enrollment_date_index` (`enrollment_date`),
  ADD KEY `sol_1_candidates_graduation_date_index` (`graduation_date`),
  ADD KEY `idx_sol1_sol_profile_id` (`sol_profile_id`),
  ADD KEY `idx_sol1_enrollment_date` (`enrollment_date`),
  ADD KEY `idx_sol1_graduation_date` (`graduation_date`);

--
-- Indexes for table `sol_2_candidates`
--
ALTER TABLE `sol_2_candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_sol2_candidate` (`sol_profile_id`),
  ADD KEY `sol_2_candidates_sol_profile_id_index` (`sol_profile_id`),
  ADD KEY `sol_2_candidates_enrollment_date_index` (`enrollment_date`),
  ADD KEY `sol_2_candidates_graduation_date_index` (`graduation_date`);

--
-- Indexes for table `sol_3_candidates`
--
ALTER TABLE `sol_3_candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sol3_candidates_sol_profile_id_foreign` (`sol_profile_id`);

--
-- Indexes for table `sol_levels`
--
ALTER TABLE `sol_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sol_levels_level_number_unique` (`level_number`),
  ADD UNIQUE KEY `sol_levels_level_name_unique` (`level_name`);

--
-- Indexes for table `sol_profiles`
--
ALTER TABLE `sol_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_sol1_email` (`email`),
  ADD KEY `sol_1_status_id_index` (`status_id`),
  ADD KEY `sol_1_g12_leader_id_index` (`g12_leader_id`),
  ADD KEY `sol_1_member_id_index` (`member_id`),
  ADD KEY `sol_1_is_cell_leader_index` (`is_cell_leader`),
  ADD KEY `sol_1_first_name_last_name_index` (`first_name`,`last_name`),
  ADD KEY `sol_profiles_current_sol_level_id_index` (`current_sol_level_id`),
  ADD KEY `idx_sol_profiles_member_id` (`member_id`),
  ADD KEY `idx_sol_profiles_current_level` (`current_sol_level_id`),
  ADD KEY `idx_sol_profiles_g12_leader` (`g12_leader_id`),
  ADD KEY `idx_sol_profiles_leader_level` (`g12_leader_id`,`current_sol_level_id`);

--
-- Indexes for table `start_up_your_new_life`
--
ALTER TABLE `start_up_your_new_life`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_member_new_life_training` (`member_id`),
  ADD KEY `start_up_your_new_life_member_id_foreign` (`member_id`),
  ADD KEY `idx_suynl_member_id` (`member_id`),
  ADD KEY `idx_suynl_member_lessons` (`member_id`,`lesson_1_completion_date`,`lesson_10_completion_date`);

--
-- Indexes for table `start_up_your_new_life_lessons`
--
ALTER TABLE `start_up_your_new_life_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `start_up_your_new_life_lessons_lesson_number_unique` (`lesson_number`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statuses_name_unique` (`name`),
  ADD KEY `idx_statuses_name` (`name`);

--
-- Indexes for table `sunday_services`
--
ALTER TABLE `sunday_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_member_sunday_service` (`member_id`),
  ADD KEY `sunday_services_member_id_foreign` (`member_id`),
  ADD KEY `idx_sunday_services_member_id` (`member_id`),
  ADD KEY `idx_sunday_services_service_date` (`service_date`),
  ADD KEY `idx_sunday_services_member_service_date` (`member_id`,`service_date`),
  ADD KEY `idx_sunday_member_sessions` (`member_id`,`sunday_service_1_date`,`sunday_service_4_date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_name_index` (`name`),
  ADD KEY `users_email_index` (`email`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_g12_leader_id_index` (`g12_leader_id`),
  ADD KEY `idx_users_name` (`name`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_g12_leader_id` (`g12_leader_id`);

--
-- Indexes for table `vip_statuses`
--
ALTER TABLE `vip_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vip_statuses_name_unique` (`name`),
  ADD KEY `idx_vip_statuses_name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cell_groups`
--
ALTER TABLE `cell_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `g12_leaders`
--
ALTER TABLE `g12_leaders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lifeclass_candidates`
--
ALTER TABLE `lifeclass_candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `member_types`
--
ALTER TABLE `member_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sol_1_candidates`
--
ALTER TABLE `sol_1_candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sol_2_candidates`
--
ALTER TABLE `sol_2_candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sol_3_candidates`
--
ALTER TABLE `sol_3_candidates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sol_levels`
--
ALTER TABLE `sol_levels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sol_profiles`
--
ALTER TABLE `sol_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `start_up_your_new_life`
--
ALTER TABLE `start_up_your_new_life`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `start_up_your_new_life_lessons`
--
ALTER TABLE `start_up_your_new_life_lessons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sunday_services`
--
ALTER TABLE `sunday_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `vip_statuses`
--
ALTER TABLE `vip_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cell_groups`
--
ALTER TABLE `cell_groups`
  ADD CONSTRAINT `cell_groups_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `g12_leaders`
--
ALTER TABLE `g12_leaders`
  ADD CONSTRAINT `g12_leaders_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `g12_leaders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lifeclass_candidates`
--
ALTER TABLE `lifeclass_candidates`
  ADD CONSTRAINT `lifeclass_candidates_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lifeclass_candidates_sol_profile_id_foreign` FOREIGN KEY (`sol_profile_id`) REFERENCES `sol_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_consolidator_id_foreign` FOREIGN KEY (`consolidator_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_g12_leader_id_foreign` FOREIGN KEY (`g12_leader_id`) REFERENCES `g12_leaders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_member_type_id_foreign` FOREIGN KEY (`member_type_id`) REFERENCES `member_types` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `members_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_vip_status_id_foreign` FOREIGN KEY (`vip_status_id`) REFERENCES `vip_statuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sol_1_candidates`
--
ALTER TABLE `sol_1_candidates`
  ADD CONSTRAINT `sol_1_candidates_sol_profile_id_foreign` FOREIGN KEY (`sol_profile_id`) REFERENCES `sol_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sol_2_candidates`
--
ALTER TABLE `sol_2_candidates`
  ADD CONSTRAINT `sol_2_candidates_sol_profile_id_foreign` FOREIGN KEY (`sol_profile_id`) REFERENCES `sol_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sol_3_candidates`
--
ALTER TABLE `sol_3_candidates`
  ADD CONSTRAINT `sol3_candidates_sol_profile_id_foreign` FOREIGN KEY (`sol_profile_id`) REFERENCES `sol_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sol_profiles`
--
ALTER TABLE `sol_profiles`
  ADD CONSTRAINT `sol_1_g12_leader_id_foreign` FOREIGN KEY (`g12_leader_id`) REFERENCES `g12_leaders` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `sol_1_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sol_1_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `sol_profiles_current_sol_level_id_foreign` FOREIGN KEY (`current_sol_level_id`) REFERENCES `sol_levels` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `start_up_your_new_life`
--
ALTER TABLE `start_up_your_new_life`
  ADD CONSTRAINT `start_up_your_new_life_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sunday_services`
--
ALTER TABLE `sunday_services`
  ADD CONSTRAINT `sunday_services_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_g12_leader_id_foreign` FOREIGN KEY (`g12_leader_id`) REFERENCES `g12_leaders` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
