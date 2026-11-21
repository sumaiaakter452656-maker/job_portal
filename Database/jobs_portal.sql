-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2026 at 04:22 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobs_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'IT / Software', 'it-/-software'),
(2, 'Sales', 'sales'),
(3, 'Accounts', 'accounts'),
(4, 'Design', 'design'),
(6, 'developer', 'developer');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `division` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `division`) VALUES
(2, 'Chattogram', 'Chattogram'),
(1, 'Dhaka', 'Dhaka'),
(4, 'Rajshahi', 'Rajshahi'),
(3, 'Sylhet', 'Sylhet');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `city_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `city_id`, `name`, `logo`, `website`, `address`, `description`) VALUES
(3, 8, 1, 'TechNova Ltd', 'technova.png', 'https://technova.example.com', 'Banani, Dhaka', 'Software development company.'),
(4, 9, 2, 'GreenLeaf Traders', 'greenleaf.png', NULL, 'Agrabad, Chattogram', 'Trading and distribution company.'),
(5, 14, NULL, 'LG', NULL, NULL, NULL, NULL),
(6, 15, 1, 'CloudNest Technologies', 'cloudnest.png', 'https://cloudnest.example.com', 'Gulshan 2, Dhaka', 'Cloud hosting and SaaS products for small businesses in Bangladesh.'),
(7, 16, 1, 'PixelCraft Studio', 'pixelcraft.png', 'https://pixelcraft.example.com', 'Dhanmondi 27, Dhaka', 'A creative agency for branding, UI/UX and digital marketing.'),
(8, 17, 2, 'Meghna Foods Ltd', 'meghnafoods.png', NULL, 'Halishahar, Chattogram', 'Food processing and distribution company with 40+ dealers across the country.'),
(9, 18, 4, 'Padma Finance', 'padmafinance.png', 'https://padmafinance.example.com', 'Shaheb Bazar, Rajshahi', 'Micro-finance and accounting services for SMEs.'),
(10, 19, 3, 'Surma Logistics', 'surmalogistics.png', NULL, 'Zindabazar, Sylhet', 'Courier and logistics network covering the Sylhet division.'),
(11, 20, 1, 'BrightPath Education', 'brightpath.png', 'https://brightpath.example.com', 'Mirpur 10, Dhaka', 'Online learning platform for school and university students.');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 'Test User', 'test@example.com', 'Phase 5 test', 'Hello from the test.', 1, '2026-11-20 09:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `cv_templates`
--

CREATE TABLE `cv_templates` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layout_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_premium` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cv_templates`
--

INSERT INTO `cv_templates` (`id`, `name`, `thumbnail`, `layout_file`, `is_premium`, `status`) VALUES
(1, 'Classic', NULL, 'templates/classic.php', 0, 'active'),
(2, 'Modern', NULL, 'templates/modern.php', 0, 'active'),
(3, 'Minimal', NULL, 'templates/minimal.php', 0, 'active'),
(4, 'Executive', NULL, 'templates/executive.php', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `demo_gateway`
--

CREATE TABLE `demo_gateway` (
  `id` int UNSIGNED NOT NULL,
  `payment_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `account` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tx_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('initiated','completed','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'initiated',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `demo_gateway`
--

INSERT INTO `demo_gateway` (`id`, `payment_id`, `invoice_no`, `method`, `amount`, `account`, `tx_id`, `status`, `created_at`) VALUES
(1, 'PAYB1CF0425AAFC', 'INV-20261120-26CF12', 'bKash', 1500.00, NULL, NULL, 'initiated', '2026-11-20 04:47:48'),
(2, 'PAY826184A59FEB', 'INV-20261120-FA3A23', 'bKash', 1500.00, NULL, NULL, 'cancelled', '2026-11-20 04:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int UNSIGNED NOT NULL,
  `company_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `city_id` int UNSIGNED DEFAULT NULL,
  `subscription_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_type` enum('full_time','part_time','contract','internship','remote') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full_time',
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deadline` date NOT NULL,
  `status` enum('pending','approved','rejected','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `company_id`, `category_id`, `city_id`, `subscription_id`, `title`, `slug`, `job_type`, `salary_min`, `salary_max`, `description`, `deadline`, `status`, `is_featured`) VALUES
(8, 3, 1, 1, 3, 'Senior PHP Developer', 'demo-senior-php-developer', 'full_time', 60000.00, 90000.00, 'Build and maintain PHP/MySQL applications.', '2026-12-10', 'approved', 1),
(9, 3, 1, 1, 3, 'Laravel Intern', 'demo-laravel-intern', 'internship', 10000.00, NULL, 'Learn and work with our Laravel team.', '2026-11-29', 'approved', 0),
(10, 3, 4, 1, 3, 'UI/UX Designer', 'demo-ui-ux-designer', 'remote', 40000.00, 60000.00, 'Design web and mobile interfaces.', '2026-11-24', 'pending', 0),
(11, 3, 3, 2, NULL, 'Junior Accountant', 'demo-junior-accountant', 'contract', NULL, NULL, 'Bookkeeping and reports.', '2026-10-30', 'closed', 0),
(12, 4, 2, 2, NULL, 'Sales Executive', 'demo-sales-executive', 'full_time', 25000.00, 35000.00, 'Grow sales in the Chattogram region.', '2026-12-15', 'approved', 0),
(13, 4, 4, 3, NULL, 'Graphic Designer', 'demo-graphic-designer', 'part_time', 20000.00, 30000.00, 'Create marketing materials.', '2026-12-05', 'approved', 1),
(14, 4, 3, 4, NULL, 'Accounts Officer', 'demo-accounts-officer', 'full_time', 30000.00, 40000.00, 'Manage accounts and payroll.', '2026-12-04', 'pending', 0),
(17, 3, 4, 3, 3, 'fthg', 'fthg', 'full_time', 6787.00, 66677.00, 'sdzxr', '2026-11-11', 'closed', 0),
(19, 3, 4, 3, 4, 'we', 'we', 'full_time', NULL, NULL, '', '2026-03-31', 'closed', 0),
(20, 3, 2, 2, 3, 'tyt', 'tyt', 'full_time', NULL, NULL, 'uye5y', '2026-05-05', 'closed', 0),
(30, 3, 1, 1, 3, 'Junior PHP Developer', 'junior-php-developer', 'full_time', 25000.00, 35000.00, 'TechNova Ltd is looking for a Junior PHP Developer to join our web team in Banani.\n\nResponsibilities:\n- Build and update websites using PHP and MySQL\n- Create admin panels with CRUD features\n- Fix bugs and improve page speed\n- Work with the design team to turn mockups into pages\n\nRequirements:\n- Good knowledge of PHP, MySQL, HTML, CSS\n- Basic JavaScript and Bootstrap\n- 0-1 year experience (freshers with good projects can apply)\n- Git knowledge is a plus\n\nBenefits:\n- Two festival bonuses\n- Lunch facility\n- Yearly salary review', '2026-12-20', 'approved', 1),
(31, 3, 1, 1, 3, 'Frontend Developer', 'frontend-developer', 'remote', 30000.00, 50000.00, 'Work from home and build modern, responsive web pages for our clients.\n\nResponsibilities:\n- Convert Figma designs into HTML/CSS pages\n- Make pages mobile friendly\n- Connect pages with backend APIs using JavaScript (fetch/AJAX)\n\nRequirements:\n- Strong HTML5, CSS3, JavaScript\n- Experience with Bootstrap or Tailwind\n- 1+ year experience\n- Stable internet connection\n\nBenefits:\n- Fully remote\n- Flexible working hours\n- Internet bill support', '2026-12-08', 'approved', 0),
(32, 3, 4, 1, 3, 'Web Designer (Part-time)', 'web-designer-part-time', 'part_time', 15000.00, 20000.00, 'We need a creative part-time web designer (4 hours/day).\n\nResponsibilities:\n- Design landing pages and website banners\n- Create social media post designs\n- Prepare simple UI mockups in Figma\n\nRequirements:\n- Figma, Photoshop or Illustrator\n- Good sense of colour and typography\n- Portfolio is required\n\nBenefits:\n- Flexible time\n- Can work alongside study', '2026-11-30', 'approved', 0),
(33, 3, 1, 1, 3, 'Laravel Developer', 'laravel-developer', 'full_time', 45000.00, 65000.00, 'Join our backend team to build SaaS products with Laravel.\n\nResponsibilities:\n- Develop REST APIs with Laravel\n- Design database tables and write optimised queries\n- Write clean, reusable code\n- Review code of junior developers\n\nRequirements:\n- 2+ years PHP/Laravel experience\n- Good knowledge of MySQL and Eloquent\n- Understanding of MVC and OOP\n- Git and basic Linux commands\n\nBenefits:\n- Hybrid work (3 days office)\n- Health insurance\n- Learning budget', '2026-12-30', 'approved', 1),
(34, 4, 2, 2, NULL, 'Area Sales Manager', 'area-sales-manager', 'full_time', 40000.00, 55000.00, 'GreenLeaf Traders is hiring an Area Sales Manager for the Chattogram region.\n\nResponsibilities:\n- Lead a team of 8-10 sales representatives\n- Achieve monthly sales targets\n- Build relationships with dealers and retailers\n- Send weekly sales reports\n\nRequirements:\n- Bachelor degree in any subject (BBA preferred)\n- 3+ years sales experience, 1 year as team leader\n- Must have a motorcycle and driving licence\n\nBenefits:\n- Sales commission\n- Fuel and mobile allowance\n- Two festival bonuses', '2026-12-12', 'approved', 1),
(35, 4, 3, 2, NULL, 'Accounts Intern', 'accounts-intern', 'internship', 8000.00, NULL, 'A 6-month internship for fresh graduates who want to start a career in accounts.\n\nResponsibilities:\n- Help with daily voucher entry\n- Keep bills and receipts in order\n- Prepare simple Excel reports\n\nRequirements:\n- BBA/MBA (Accounting or Finance) student or fresh graduate\n- Good MS Excel skills\n\nBenefits:\n- Monthly allowance\n- Internship certificate\n- Chance of full-time job after internship', '2026-12-02', 'approved', 0),
(36, 4, 2, 3, NULL, 'Sales Representative', 'sales-representative', 'contract', 18000.00, 25000.00, '1-year contract job for field sales in the Sylhet region.\n\nResponsibilities:\n- Visit shops and take orders\n- Introduce new products to retailers\n- Collect payments and keep records\n\nRequirements:\n- HSC or above\n- Good communication skills\n- Knows the Sylhet area well\n\nBenefits:\n- Daily travel allowance\n- Monthly sales incentive', '2026-12-18', 'approved', 0),
(37, 4, 3, 4, NULL, 'Senior Accountant', 'senior-accountant', 'full_time', 45000.00, 60000.00, 'We are looking for an experienced Senior Accountant for our Rajshahi branch.\n\nResponsibilities:\n- Prepare monthly and yearly financial statements\n- Handle VAT and income tax returns\n- Manage payroll and bank reconciliation\n- Guide junior accounts staff\n\nRequirements:\n- M.Com/MBA in Accounting; CA (CC) preferred\n- 4+ years experience\n- Tally/ERP and advanced Excel\n\nBenefits:\n- Provident fund\n- Gratuity\n- Two festival bonuses', '2026-12-25', 'approved', 0),
(38, 3, 1, 1, 3, 'Python Developer (Expired demo)', 'python-developer-expired', 'full_time', 50000.00, 70000.00, 'This job deadline is over, so it will NOT be shown on the website.', '2026-11-17', 'closed', 0),
(39, 6, 1, 1, NULL, 'Backend Developer (PHP)', 'cloudnest-backend-php', 'full_time', 40000.00, 60000.00, 'Build APIs for our cloud hosting panel.\n\nResponsibilities:\n- Write PHP/MySQL APIs\n- Improve server performance\n\nRequirements:\n- 2+ years PHP experience\n- Good MySQL knowledge', '2026-12-15', 'approved', 1),
(40, 6, 1, 1, NULL, 'IT Support Executive', 'cloudnest-it-support', 'full_time', 20000.00, 28000.00, 'Help our customers with hosting and email problems.\n\nRequirements:\n- Basic networking and Linux\n- Good communication in Bangla and English', '2026-12-04', 'approved', 0),
(41, 7, 4, 1, NULL, 'UI/UX Designer', 'pixelcraft-ui-ux', 'full_time', 35000.00, 50000.00, 'Design websites and mobile apps for our clients.\n\nRequirements:\n- Figma expert\n- Strong portfolio\n- 2+ years experience', '2026-12-10', 'approved', 1),
(42, 7, 4, 1, NULL, 'Graphic Design Intern', 'pixelcraft-design-intern', 'internship', 10000.00, NULL, '3-month paid internship for design students.\n\nRequirements:\n- Photoshop and Illustrator basics\n- Eagerness to learn', '2026-11-30', 'approved', 0),
(43, 8, 2, 2, NULL, 'Sales Officer', 'meghna-sales-officer', 'full_time', 22000.00, 30000.00, 'Grow our product sales in the Chattogram region.\n\nRequirements:\n- Bachelor degree\n- 1+ year FMCG sales experience', '2026-12-08', 'approved', 0),
(44, 9, 3, 4, NULL, 'Junior Accountant', 'padma-junior-accountant', 'full_time', 20000.00, 26000.00, 'Daily accounts and bank entries.\n\nRequirements:\n- BBA/MBA in Accounting\n- Tally and Excel', '2026-12-11', 'approved', 0),
(45, 10, 2, 3, NULL, 'Delivery Hub Supervisor', 'surma-hub-supervisor', 'contract', 18000.00, 24000.00, 'Manage daily parcel delivery at our Sylhet hub.\n\nRequirements:\n- HSC or above\n- Team handling experience', '2026-12-06', 'approved', 0),
(46, 11, 1, 1, NULL, 'Content Developer (Remote)', 'brightpath-content-dev', 'remote', 25000.00, 35000.00, 'Create online lessons and quizzes.\n\nRequirements:\n- Good writing skills\n- Basic HTML is a plus', '2026-12-20', 'approved', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int UNSIGNED NOT NULL,
  `job_id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `resume_file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('applied','viewed','shortlisted','interview','hired','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'applied',
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `seeker_id`, `resume_file`, `status`, `applied_at`) VALUES
(8, 8, 4, 'uploads/cv/rahim.pdf', 'interview', '2026-11-01 14:51:36'),
(9, 9, 4, 'uploads/cv/rahim.pdf', 'applied', '2026-11-03 14:51:36'),
(10, 11, 4, 'uploads/cv/rahim.pdf', 'rejected', '2026-08-26 14:51:36'),
(11, 13, 5, 'uploads/cv/nusrat.pdf', 'shortlisted', '2026-10-27 14:51:36'),
(12, 8, 5, 'uploads/cv/nusrat.pdf', 'viewed', '2026-09-25 14:51:36'),
(13, 12, 6, 'uploads/cv/tanvir.pdf', 'hired', '2026-07-27 14:51:36'),
(14, 9, 6, 'uploads/cv/tanvir.pdf', 'applied', '2026-11-02 14:51:36'),
(16, 30, 4, 'uploads/cv/rahim.pdf', 'shortlisted', '2026-11-20 04:30:36'),
(17, 31, 4, 'uploads/cv/rahim.pdf', 'viewed', '2026-11-20 04:30:36'),
(18, 46, 8, 'uploads/cv/seeker_8_1795167066.pdf', 'applied', '2026-11-20 09:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `job_skills`
--

CREATE TABLE `job_skills` (
  `id` int UNSIGNED NOT NULL,
  `job_id` int UNSIGNED NOT NULL,
  `skill_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_skills`
--

INSERT INTO `job_skills` (`id`, `job_id`, `skill_id`) VALUES
(10, 8, 1),
(11, 8, 2),
(12, 8, 3),
(13, 9, 1),
(14, 9, 3),
(15, 10, 5),
(16, 10, 6),
(17, 11, 7),
(18, 14, 7),
(33, 30, 1),
(34, 30, 2),
(35, 30, 5),
(36, 31, 4),
(37, 31, 5),
(38, 31, 6),
(39, 32, 5),
(40, 32, 6),
(41, 33, 1),
(42, 33, 2),
(43, 33, 3),
(44, 34, 7),
(45, 35, 7),
(46, 37, 7),
(47, 39, 1),
(48, 39, 2),
(49, 41, 6),
(51, 44, 7),
(50, 46, 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(8, 7, 'New employer \"GreenLeaf Traders\" is waiting for approval', 0, '2026-11-04 14:21:36'),
(9, 7, 'Payment INV-DEMO-0002 submitted via Nagad', 0, '2026-11-04 11:51:36'),
(10, 7, 'Job \"UI/UX Designer\" needs review', 1, '2026-11-03 14:51:36'),
(11, 8, 'Rahim Uddin applied for Laravel Intern', 0, '2026-11-03 14:51:36'),
(12, 8, 'Your Standard package payment was approved', 1, '2026-10-25 14:51:36'),
(13, 10, 'You have been invited to an interview for Senior PHP Developer', 0, '2026-11-04 12:51:36'),
(14, 10, 'Your application for Junior Accountant was not selected', 1, '2026-09-05 14:51:36'),
(15, 9, 'Rahim Uddin applied for Area Sales Manager', 0, '2026-11-20 02:51:05'),
(16, 10, 'TechNova Ltd shortlisted you for Junior PHP Developer', 0, '2026-11-20 04:30:36'),
(17, 8, 'Payment INV-20261120-2842BB completed. Standard package is active.', 0, '2026-11-20 05:08:34'),
(18, 7, 'TechNova Ltd paid ৳1500.00 for Standard (INV-20261120-2842BB)', 0, '2026-11-20 05:08:34'),
(19, 8, 'Payment INV-20261120-27E4AA completed. Premium package is active.', 0, '2026-11-20 05:11:18'),
(20, 7, 'TechNova Ltd paid ৳4000.00 for Premium (INV-20261120-27E4AA)', 0, '2026-11-20 05:11:18'),
(21, 8, 'Payment INV-20261120-7EDCBC completed. Standard package is active.', 0, '2026-11-20 05:22:59'),
(22, 7, 'TechNova Ltd paid ৳1500.00 for Standard (INV-20261120-7EDCBC)', 0, '2026-11-20 05:22:59'),
(23, 20, 'shahin applied for Content Developer (Remote)', 0, '2026-11-20 09:31:06'),
(24, 8, 'Your job \"we\" was closed automatically because the deadline passed.', 0, '2026-11-20 09:42:34'),
(25, 8, 'Your job \"tyt\" was closed automatically because the deadline passed.', 0, '2026-11-20 09:42:34'),
(26, 8, 'Your job \"fthg\" was closed automatically because the deadline passed.', 0, '2026-11-20 09:42:34'),
(27, 8, 'Your job \"Python Developer (Expired demo)\" was closed automatically because the deadline passed.', 0, '2026-11-20 09:42:34'),
(28, 14, 'Payment INV-20261120-FA743A completed. Standard package is active.', 0, '2026-11-20 17:54:48'),
(29, 7, 'LG paid ৳1500.00 for Standard (INV-20261120-FA743A)', 0, '2026-11-20 17:54:48'),
(30, 14, 'Payment INV-20261120-B68ED7 completed. Standard package is active (5 unused posts carried over).', 0, '2026-11-20 17:55:16'),
(31, 7, 'LG paid ৳1500.00 for Standard (INV-20261120-B68ED7)', 0, '2026-11-20 17:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `duration_days` smallint UNSIGNED NOT NULL,
  `job_post_limit` smallint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `price`, `duration_days`, `job_post_limit`, `description`) VALUES
(1, 'Free', 0.00, 30, 1, 'Post 1 job for 30 days'),
(2, 'Standard', 1500.00, 30, 5, 'Post 5 jobs for 30 days'),
(3, 'Premium', 4000.00, 60, 20, 'Post 20 jobs for 60 days, featured listing');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `account_no`, `status`) VALUES
(1, 'Cash', NULL, 'active'),
(2, 'bKash', NULL, 'active'),
(3, 'Nagad', NULL, 'active'),
(4, 'Rocket', NULL, 'active'),
(5, 'Bank Transfer', NULL, 'active'),
(6, 'Card', NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` int UNSIGNED NOT NULL,
  `transaction_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `subscription_id` int UNSIGNED NOT NULL,
  `payment_method_id` int UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `tx_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `verified_by` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_transactions`
--

INSERT INTO `payment_transactions` (`id`, `transaction_no`, `user_id`, `subscription_id`, `payment_method_id`, `total_amount`, `tx_id`, `status`, `verified_by`) VALUES
(3, 'INV-DEMO-0001', 8, 3, 2, 1500.00, 'BKDEMO7X92', 'completed', 7),
(4, 'INV-DEMO-0002', 9, 4, 3, 4000.00, 'NGDEMO88AA', 'pending', NULL),
(5, 'INV-20261120-26CF12', 8, 5, 2, 1500.00, NULL, 'pending', NULL),
(6, 'INV-20261120-FA3A23', 8, 6, 2, 1500.00, NULL, 'failed', NULL),
(7, 'INV-20261120-6EE579', 8, 7, 2, 1500.00, NULL, 'pending', NULL),
(8, 'INV-20261120-259C5A', 8, 8, 2, 1500.00, NULL, 'pending', NULL),
(9, 'INV-20261120-13ED87', 8, 9, 2, 1500.00, NULL, 'pending', NULL),
(10, 'INV-20261120-E459D9', 8, 10, 2, 1500.00, NULL, 'pending', NULL),
(11, 'INV-20261120-2842BB', 8, 11, 2, 1500.00, 'DKK30PXQ77', 'completed', NULL),
(12, 'INV-20261120-DF5EB7', 8, 12, 2, 1500.00, NULL, 'pending', NULL),
(13, 'INV-20261120-E55B24', 8, 13, 2, 1500.00, NULL, 'pending', NULL),
(14, 'INV-20261120-720B54', 8, 14, 2, 4000.00, NULL, 'pending', NULL),
(15, 'INV-20261120-27E4AA', 8, 15, 2, 4000.00, 'DKK20PXQ7Q', 'completed', NULL),
(16, 'INV-20261120-7EDCBC', 8, 16, 3, 1500.00, 'AAM1795152076118253', 'completed', NULL),
(17, 'INV-20261120-FA743A', 14, 17, 3, 1500.00, 'AAM1795197293118005', 'completed', NULL),
(18, 'INV-20261120-B68ED7', 14, 18, 6, 1500.00, 'AAM1795197323118146', 'completed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `job_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`id`, `seeker_id`, `job_id`) VALUES
(5, 4, 12),
(4, 4, 13),
(7, 4, 33),
(6, 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `seekers`
--

CREATE TABLE `seekers` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `city_id` int UNSIGNED DEFAULT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `cv_template_id` int UNSIGNED DEFAULT NULL,
  `headline` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `experience_years` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `expected_salary` decimal(10,2) DEFAULT NULL,
  `resume_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seekers`
--

INSERT INTO `seekers` (`id`, `user_id`, `city_id`, `category_id`, `cv_template_id`, `headline`, `summary`, `experience_years`, `expected_salary`, `resume_file`) VALUES
(4, 10, 1, 1, 4, 'PHP Developer', 'PHP/MySQL developer who loves building web apps.', 2, 35000.00, 'uploads/cv/seeker_4_1795143065.pdf'),
(5, 11, 1, 4, NULL, 'UI/UX Designer', NULL, 3, 45000.00, NULL),
(6, 12, 2, 2, NULL, 'Sales Executive', 'Field sales professional.', 1, 22000.00, NULL),
(7, 13, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, 21, 1, NULL, 2, 'PHP Developer', 'ewgftaetfrweafrtweferwftrefertfetg fcvgsdfszgv dfvsefcv fgvrdgxdth ftghdr', 0, NULL, 'uploads/cv/seeker_8_1795167066.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `seeker_cv_items`
--

CREATE TABLE `seeker_cv_items` (
  `id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `type` enum('project','certificate','language') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seeker_cv_items`
--

INSERT INTO `seeker_cv_items` (`id`, `seeker_id`, `type`, `title`, `organization`, `level`, `link`, `start_date`, `end_date`) VALUES
(4, 4, 'project', 'Online Job Portal', 'Personal Project', NULL, NULL, '2024-03-01', '2024-06-30'),
(5, 4, 'certificate', 'PHP & MySQL Web Development', 'IsDB-BISEW', NULL, NULL, '2023-01-01', '2023-06-30'),
(6, 4, 'language', 'English', NULL, 'Good', NULL, NULL, NULL),
(7, 8, 'project', 'JOB PORTAL', 'IsDB-BISEW', 'HINDI/ENGLISH/BANGLA', NULL, '2026-11-20', '2027-01-20');

-- --------------------------------------------------------

--
-- Table structure for table `seeker_educations`
--

CREATE TABLE `seeker_educations` (
  `id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `level` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree_title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seeker_educations`
--

INSERT INTO `seeker_educations` (`id`, `seeker_id`, `level`, `degree_title`, `institution`, `result`, `year`) VALUES
(4, 4, 'Bachelor', 'BSc in CSE', 'Daffodil International University', 'CGPA 3.60', '2023'),
(5, 4, 'HSC', 'Science', 'Dhaka College', 'GPA 5.00', '2018'),
(6, 5, 'Bachelor', 'BFA in Graphic Design', 'University of Dhaka', 'CGPA 3.45', '2021'),
(7, 8, 'SSC', 'diploma in electronics', 'DMPI', 'CGPA 3.53', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `seeker_experiences`
--

CREATE TABLE `seeker_experiences` (
  `id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `company_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seeker_experiences`
--

INSERT INTO `seeker_experiences` (`id`, `seeker_id`, `company_name`, `designation`, `start_date`, `end_date`, `is_current`) VALUES
(4, 4, 'WebPoint IT', 'Junior Web Developer', '2024-01-01', NULL, 1),
(5, 4, 'CodeCamp BD', 'Intern', '2023-06-01', '2023-12-31', 0),
(6, 5, 'PixelHouse', 'Graphic Designer', '2021-08-01', '2024-07-31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `seeker_skills`
--

CREATE TABLE `seeker_skills` (
  `id` int UNSIGNED NOT NULL,
  `seeker_id` int UNSIGNED NOT NULL,
  `skill_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seeker_skills`
--

INSERT INTO `seeker_skills` (`id`, `seeker_id`, `skill_id`) VALUES
(10, 4, 1),
(11, 4, 2),
(12, 4, 3),
(13, 4, 4),
(14, 4, 5),
(15, 4, 6),
(16, 5, 5),
(17, 5, 6),
(18, 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(6, 'CSS'),
(7, 'Excel'),
(5, 'HTML'),
(4, 'JavaScript'),
(3, 'Laravel'),
(2, 'MySQL'),
(1, 'PHP');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `package_id` int UNSIGNED NOT NULL,
  `posts_left` smallint UNSIGNED NOT NULL DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('pending','active','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `package_id`, `posts_left`, `start_date`, `end_date`, `status`) VALUES
(3, 8, 2, 2, '2026-10-25', '2026-11-24', 'expired'),
(4, 9, 3, 20, NULL, NULL, 'pending'),
(5, 8, 2, 0, NULL, NULL, 'pending'),
(6, 8, 2, 0, NULL, NULL, 'pending'),
(7, 8, 2, 0, NULL, NULL, 'pending'),
(8, 8, 2, 0, NULL, NULL, 'pending'),
(9, 8, 2, 0, NULL, NULL, 'pending'),
(10, 8, 2, 0, NULL, NULL, 'pending'),
(11, 8, 2, 5, '2026-11-20', '2026-12-20', 'expired'),
(12, 8, 2, 0, NULL, NULL, 'pending'),
(13, 8, 2, 0, NULL, NULL, 'pending'),
(14, 8, 3, 0, NULL, NULL, 'pending'),
(15, 8, 3, 20, '2026-11-20', '2027-01-19', 'expired'),
(16, 8, 2, 5, '2026-11-20', '2026-12-20', 'active'),
(17, 14, 2, 5, '2026-11-20', '2026-12-20', 'expired'),
(18, 14, 2, 10, '2026-11-20', '2027-01-19', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','employer','seeker') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','pending','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `created_at`) VALUES
(7, 'Site Admin', 'admin@jobportal.com', '01700000001', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin', 'active', '2026-05-28 14:51:36'),
(8, 'Karim Hossain', 'employer@jobportal.com', '01700000002', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-06-17 14:51:36'),
(9, 'Sumon Das', 'employer2@jobportal.com', '01700000003', '$2y$10$TywG3oVIX0cgOuljkbbQCu9GXrI/vHNBrYRvFoUeSg5FQYRchXQ5G', 'employer', 'pending', '2026-10-15 14:51:36'),
(10, 'Rahim Uddin', 'seeker@jobportal.com', '01700000004', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'seeker', 'active', '2026-07-07 14:51:36'),
(11, 'Nusrat Jahan', 'seeker2@jobportal.com', NULL, '$2y$10$TywG3oVIX0cgOuljkbbQCu9GXrI/vHNBrYRvFoUeSg5FQYRchXQ5G', 'seeker', 'active', '2026-08-21 14:51:36'),
(12, 'Tanvir Ahmed', 'seeker3@jobportal.com', '01700000006', '$2y$10$TywG3oVIX0cgOuljkbbQCu9GXrI/vHNBrYRvFoUeSg5FQYRchXQ5G', 'seeker', 'active', '2026-10-30 14:51:36'),
(13, 'sumaia akter', 'abc@gmail.com', '01758546710', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'seeker', 'active', '2026-11-20 02:20:31'),
(14, 'SHAHIN', 'shahin@gmail.com', '01710667839', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'employer', 'active', '2026-11-20 02:41:59'),
(15, 'Arif Hasan', 'arif@gmail.com\r\n', '01711000001', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(16, 'Mitu Akter', 'mitu@gmail.com\r\n', '01711000002', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(17, 'Jamal Uddin', 'hrjamal@gmail.com\r\n', '01711000003', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(18, 'Farhana Islam', 'Farhana@gmail.com\r\n', '01711000004', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(19, 'Shahin Alam', 'hr@gmail.com\r\n', '01711000005', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(20, 'Nadia Rahman', 'nadia@gmail.com', '01711000006', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active', '2026-11-20 04:30:36'),
(21, 'shahin', 'afradi@gmail.com', '01758546710', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'seeker', 'active', '2026-11-20 09:29:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_city` (`name`,`division`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `fk_companies_city` (`city_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cv_templates`
--
ALTER TABLE `cv_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_gateway`
--
ALTER TABLE `demo_gateway`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_jobs_company` (`company_id`),
  ADD KEY `fk_jobs_category` (`category_id`),
  ADD KEY `fk_jobs_city` (`city_id`),
  ADD KEY `fk_jobs_sub` (`subscription_id`),
  ADD KEY `idx_jobs_search` (`status`,`deadline`,`is_featured`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_apply_once` (`job_id`,`seeker_id`),
  ADD KEY `fk_app_seeker` (`seeker_id`);

--
-- Indexes for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_job_skill` (`job_id`,`skill_id`),
  ADD KEY `fk_js_skill` (`skill_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notif_unread` (`user_id`,`is_read`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_no` (`transaction_no`),
  ADD UNIQUE KEY `tx_id` (`tx_id`),
  ADD KEY `fk_pay_user` (`user_id`),
  ADD KEY `fk_pay_sub` (`subscription_id`),
  ADD KEY `fk_pay_method` (`payment_method_id`),
  ADD KEY `fk_pay_verifier` (`verified_by`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_saved` (`seeker_id`,`job_id`),
  ADD KEY `fk_saved_job` (`job_id`);

--
-- Indexes for table `seekers`
--
ALTER TABLE `seekers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `fk_seekers_city` (`city_id`),
  ADD KEY `fk_seekers_category` (`category_id`),
  ADD KEY `fk_seekers_template` (`cv_template_id`);

--
-- Indexes for table `seeker_cv_items`
--
ALTER TABLE `seeker_cv_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_items_type` (`seeker_id`,`type`);

--
-- Indexes for table `seeker_educations`
--
ALTER TABLE `seeker_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_edu_seeker` (`seeker_id`);

--
-- Indexes for table `seeker_experiences`
--
ALTER TABLE `seeker_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exp_seeker` (`seeker_id`);

--
-- Indexes for table `seeker_skills`
--
ALTER TABLE `seeker_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_seeker_skill` (`seeker_id`,`skill_id`),
  ADD KEY `fk_ss_skill` (`skill_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_user` (`user_id`),
  ADD KEY `fk_sub_package` (`package_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cv_templates`
--
ALTER TABLE `cv_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demo_gateway`
--
ALTER TABLE `demo_gateway`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `job_skills`
--
ALTER TABLE `job_skills`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seekers`
--
ALTER TABLE `seekers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seeker_cv_items`
--
ALTER TABLE `seeker_cv_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seeker_educations`
--
ALTER TABLE `seeker_educations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seeker_experiences`
--
ALTER TABLE `seeker_experiences`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `seeker_skills`
--
ALTER TABLE `seeker_skills`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_companies_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_companies_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_jobs_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_jobs_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_jobs_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_jobs_sub` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `fk_app_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD CONSTRAINT `fk_js_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_js_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `fk_pay_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `fk_pay_sub` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pay_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pay_verifier` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `fk_saved_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_saved_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seekers`
--
ALTER TABLE `seekers`
  ADD CONSTRAINT `fk_seekers_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_seekers_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_seekers_template` FOREIGN KEY (`cv_template_id`) REFERENCES `cv_templates` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_seekers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seeker_cv_items`
--
ALTER TABLE `seeker_cv_items`
  ADD CONSTRAINT `fk_items_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seeker_educations`
--
ALTER TABLE `seeker_educations`
  ADD CONSTRAINT `fk_edu_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seeker_experiences`
--
ALTER TABLE `seeker_experiences`
  ADD CONSTRAINT `fk_exp_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seeker_skills`
--
ALTER TABLE `seeker_skills`
  ADD CONSTRAINT `fk_ss_seeker` FOREIGN KEY (`seeker_id`) REFERENCES `seekers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ss_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `fk_sub_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `fk_sub_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
