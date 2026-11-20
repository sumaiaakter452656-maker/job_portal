-- =========================================================
-- Demo data (JobHub)
-- HeidiSQL/phpMyAdmin-এ jobs_portal select করে চালান,
-- অথবা ব্রাউজারে খুলুন: http://localhost/job_portal/Database/seed.php
-- টেবিলের structure বদলায় না। যতবার চালান, একই demo job একবারই থাকবে।
-- =========================================================

-- আগের demo job থাকলে মুছে ফেলা (job_skills নিজে থেকেই মুছে যাবে)
DELETE FROM jobs WHERE slug IN ('junior-php-developer','frontend-developer','web-designer-part-time','area-sales-manager','accounts-intern','sales-representative','senior-accountant','laravel-developer','python-developer-expired');

-- পুরনো approved job গুলোর deadline সামনে নেওয়া
UPDATE jobs SET deadline = DATE_ADD(CURDATE(), INTERVAL 20 DAY) WHERE id = 8;
UPDATE jobs SET deadline = DATE_ADD(CURDATE(), INTERVAL 25 DAY) WHERE id = 12;
UPDATE jobs SET deadline = DATE_ADD(CURDATE(), INTERVAL 15 DAY) WHERE id = 13;

-- নতুন demo job (company 3 = TechNova Ltd, company 4 = GreenLeaf Traders)
INSERT INTO jobs (company_id, category_id, city_id, subscription_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured) VALUES
(3, 1, 1, 3, 'Junior PHP Developer', 'junior-php-developer', 'full_time', 25000, 35000,
'TechNova Ltd is looking for a Junior PHP Developer to join our web team in Banani.\n\nResponsibilities:\n- Build and update websites using PHP and MySQL\n- Create admin panels with CRUD features\n- Fix bugs and improve page speed\n- Work with the design team to turn mockups into pages\n\nRequirements:\n- Good knowledge of PHP, MySQL, HTML, CSS\n- Basic JavaScript and Bootstrap\n- 0-1 year experience (freshers with good projects can apply)\n- Git knowledge is a plus\n\nBenefits:\n- Two festival bonuses\n- Lunch facility\n- Yearly salary review',
DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'approved', 1),

(3, 1, 1, 3, 'Frontend Developer', 'frontend-developer', 'remote', 30000, 50000,
'Work from home and build modern, responsive web pages for our clients.\n\nResponsibilities:\n- Convert Figma designs into HTML/CSS pages\n- Make pages mobile friendly\n- Connect pages with backend APIs using JavaScript (fetch/AJAX)\n\nRequirements:\n- Strong HTML5, CSS3, JavaScript\n- Experience with Bootstrap or Tailwind\n- 1+ year experience\n- Stable internet connection\n\nBenefits:\n- Fully remote\n- Flexible working hours\n- Internet bill support',
DATE_ADD(CURDATE(), INTERVAL 18 DAY), 'approved', 0),

(3, 4, 1, 3, 'Web Designer (Part-time)', 'web-designer-part-time', 'part_time', 15000, 20000,
'We need a creative part-time web designer (4 hours/day).\n\nResponsibilities:\n- Design landing pages and website banners\n- Create social media post designs\n- Prepare simple UI mockups in Figma\n\nRequirements:\n- Figma, Photoshop or Illustrator\n- Good sense of colour and typography\n- Portfolio is required\n\nBenefits:\n- Flexible time\n- Can work alongside study',
DATE_ADD(CURDATE(), INTERVAL 10 DAY), 'approved', 0),

(3, 1, 1, 3, 'Laravel Developer', 'laravel-developer', 'full_time', 45000, 65000,
'Join our backend team to build SaaS products with Laravel.\n\nResponsibilities:\n- Develop REST APIs with Laravel\n- Design database tables and write optimised queries\n- Write clean, reusable code\n- Review code of junior developers\n\nRequirements:\n- 2+ years PHP/Laravel experience\n- Good knowledge of MySQL and Eloquent\n- Understanding of MVC and OOP\n- Git and basic Linux commands\n\nBenefits:\n- Hybrid work (3 days office)\n- Health insurance\n- Learning budget',
DATE_ADD(CURDATE(), INTERVAL 40 DAY), 'approved', 1),

(4, 2, 2, NULL, 'Area Sales Manager', 'area-sales-manager', 'full_time', 40000, 55000,
'GreenLeaf Traders is hiring an Area Sales Manager for the Chattogram region.\n\nResponsibilities:\n- Lead a team of 8-10 sales representatives\n- Achieve monthly sales targets\n- Build relationships with dealers and retailers\n- Send weekly sales reports\n\nRequirements:\n- Bachelor degree in any subject (BBA preferred)\n- 3+ years sales experience, 1 year as team leader\n- Must have a motorcycle and driving licence\n\nBenefits:\n- Sales commission\n- Fuel and mobile allowance\n- Two festival bonuses',
DATE_ADD(CURDATE(), INTERVAL 22 DAY), 'approved', 1),

(4, 3, 2, NULL, 'Accounts Intern', 'accounts-intern', 'internship', 8000, NULL,
'A 6-month internship for fresh graduates who want to start a career in accounts.\n\nResponsibilities:\n- Help with daily voucher entry\n- Keep bills and receipts in order\n- Prepare simple Excel reports\n\nRequirements:\n- BBA/MBA (Accounting or Finance) student or fresh graduate\n- Good MS Excel skills\n\nBenefits:\n- Monthly allowance\n- Internship certificate\n- Chance of full-time job after internship',
DATE_ADD(CURDATE(), INTERVAL 12 DAY), 'approved', 0),

(4, 2, 3, NULL, 'Sales Representative', 'sales-representative', 'contract', 18000, 25000,
'1-year contract job for field sales in the Sylhet region.\n\nResponsibilities:\n- Visit shops and take orders\n- Introduce new products to retailers\n- Collect payments and keep records\n\nRequirements:\n- HSC or above\n- Good communication skills\n- Knows the Sylhet area well\n\nBenefits:\n- Daily travel allowance\n- Monthly sales incentive',
DATE_ADD(CURDATE(), INTERVAL 28 DAY), 'approved', 0),

(4, 3, 4, NULL, 'Senior Accountant', 'senior-accountant', 'full_time', 45000, 60000,
'We are looking for an experienced Senior Accountant for our Rajshahi branch.\n\nResponsibilities:\n- Prepare monthly and yearly financial statements\n- Handle VAT and income tax returns\n- Manage payroll and bank reconciliation\n- Guide junior accounts staff\n\nRequirements:\n- M.Com/MBA in Accounting; CA (CC) preferred\n- 4+ years experience\n- Tally/ERP and advanced Excel\n\nBenefits:\n- Provident fund\n- Gratuity\n- Two festival bonuses',
DATE_ADD(CURDATE(), INTERVAL 35 DAY), 'approved', 0),

(3, 1, 1, 3, 'Python Developer (Expired demo)', 'python-developer-expired', 'full_time', 50000, 70000,
'This job deadline is over, so it will NOT be shown on the website.',
DATE_SUB(CURDATE(), INTERVAL 3 DAY), 'approved', 0);

-- Job-এর skill (skills: 1 PHP, 2 MySQL, 3 Laravel, 4 JavaScript, 5 HTML, 6 CSS, 7 Excel)
INSERT INTO job_skills (job_id, skill_id) SELECT id, 1 FROM jobs WHERE slug = 'junior-php-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 2 FROM jobs WHERE slug = 'junior-php-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 5 FROM jobs WHERE slug = 'junior-php-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 4 FROM jobs WHERE slug = 'frontend-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 5 FROM jobs WHERE slug = 'frontend-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 6 FROM jobs WHERE slug = 'frontend-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 5 FROM jobs WHERE slug = 'web-designer-part-time';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 6 FROM jobs WHERE slug = 'web-designer-part-time';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 1 FROM jobs WHERE slug = 'laravel-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 2 FROM jobs WHERE slug = 'laravel-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 3 FROM jobs WHERE slug = 'laravel-developer';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 7 FROM jobs WHERE slug = 'area-sales-manager';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 7 FROM jobs WHERE slug = 'accounts-intern';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 7 FROM jobs WHERE slug = 'senior-accountant';

-- Rahim Uddin (seeker id 4)-এর জন্য demo application: একটায় shortlisted, একটায় viewed
INSERT INTO job_applications (job_id, seeker_id, resume_file, status) SELECT id, 4, 'uploads/cv/rahim.pdf', 'shortlisted' FROM jobs WHERE slug = 'junior-php-developer';
INSERT INTO job_applications (job_id, seeker_id, resume_file, status) SELECT id, 4, 'uploads/cv/rahim.pdf', 'viewed' FROM jobs WHERE slug = 'frontend-developer';
-- Rahim একটা নতুন job save করেছে
INSERT INTO saved_jobs (seeker_id, job_id) SELECT 4, id FROM jobs WHERE slug = 'laravel-developer';
-- Rahim-এর notification
DELETE FROM notifications WHERE message = 'TechNova Ltd shortlisted you for Junior PHP Developer';
INSERT INTO notifications (user_id, message) VALUES (10, 'TechNova Ltd shortlisted you for Junior PHP Developer');

-- =========================================================
-- আরও demo company (logo সহ)। প্রতিটার একজন employer user আছে, password: 123
-- =========================================================

-- আগের দুই company-কে logo দেওয়া
UPDATE companies SET logo = 'technova.png' WHERE id = 3;
UPDATE companies SET logo = 'greenleaf.png' WHERE id = 4;

-- আগে চালানো থাকলে মুছে ফেলা (company আর তাদের job নিজে থেকে মুছে যাবে)
DELETE FROM users WHERE email IN ('hr@cloudnest.test','hr@pixelcraft.test','hr@meghnafoods.test','hr@padmafinance.test','hr@surmalogistics.test','hr@brightpath.test');

-- Employer user (sha1('123'))
INSERT INTO users (name, email, phone, password, role, status) VALUES
('Arif Hasan',    'hr@cloudnest.test',      '01711000001', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active'),
('Mitu Akter',    'hr@pixelcraft.test',     '01711000002', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active'),
('Jamal Uddin',   'hr@meghnafoods.test',    '01711000003', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active'),
('Farhana Islam', 'hr@padmafinance.test',   '01711000004', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active'),
('Shahin Alam',   'hr@surmalogistics.test', '01711000005', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active'),
('Nadia Rahman',  'hr@brightpath.test',     '01711000006', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'employer', 'active');

-- Company (city: 1 Dhaka, 2 Chattogram, 3 Sylhet, 4 Rajshahi)
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 1, 'CloudNest Technologies', 'cloudnest.png', 'https://cloudnest.example.com', 'Gulshan 2, Dhaka', 'Cloud hosting and SaaS products for small businesses in Bangladesh.' FROM users WHERE email = 'hr@cloudnest.test';
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 1, 'PixelCraft Studio', 'pixelcraft.png', 'https://pixelcraft.example.com', 'Dhanmondi 27, Dhaka', 'A creative agency for branding, UI/UX and digital marketing.' FROM users WHERE email = 'hr@pixelcraft.test';
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 2, 'Meghna Foods Ltd', 'meghnafoods.png', NULL, 'Halishahar, Chattogram', 'Food processing and distribution company with 40+ dealers across the country.' FROM users WHERE email = 'hr@meghnafoods.test';
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 4, 'Padma Finance', 'padmafinance.png', 'https://padmafinance.example.com', 'Shaheb Bazar, Rajshahi', 'Micro-finance and accounting services for SMEs.' FROM users WHERE email = 'hr@padmafinance.test';
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 3, 'Surma Logistics', 'surmalogistics.png', NULL, 'Zindabazar, Sylhet', 'Courier and logistics network covering the Sylhet division.' FROM users WHERE email = 'hr@surmalogistics.test';
INSERT INTO companies (user_id, city_id, name, logo, website, address, description)
SELECT id, 1, 'BrightPath Education', 'brightpath.png', 'https://brightpath.example.com', 'Mirpur 10, Dhaka', 'Online learning platform for school and university students.' FROM users WHERE email = 'hr@brightpath.test';

-- প্রতিটা company-র job (category: 1 IT, 2 Sales, 3 Accounts, 4 Design)
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 1, 1, 'Backend Developer (PHP)', 'cloudnest-backend-php', 'full_time', 40000, 60000,
'Build APIs for our cloud hosting panel.\n\nResponsibilities:\n- Write PHP/MySQL APIs\n- Improve server performance\n\nRequirements:\n- 2+ years PHP experience\n- Good MySQL knowledge',
DATE_ADD(CURDATE(), INTERVAL 25 DAY), 'approved', 1 FROM companies WHERE name = 'CloudNest Technologies';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 1, 1, 'IT Support Executive', 'cloudnest-it-support', 'full_time', 20000, 28000,
'Help our customers with hosting and email problems.\n\nRequirements:\n- Basic networking and Linux\n- Good communication in Bangla and English',
DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'approved', 0 FROM companies WHERE name = 'CloudNest Technologies';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 4, 1, 'UI/UX Designer', 'pixelcraft-ui-ux', 'full_time', 35000, 50000,
'Design websites and mobile apps for our clients.\n\nRequirements:\n- Figma expert\n- Strong portfolio\n- 2+ years experience',
DATE_ADD(CURDATE(), INTERVAL 20 DAY), 'approved', 1 FROM companies WHERE name = 'PixelCraft Studio';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 4, 1, 'Graphic Design Intern', 'pixelcraft-design-intern', 'internship', 10000, NULL,
'3-month paid internship for design students.\n\nRequirements:\n- Photoshop and Illustrator basics\n- Eagerness to learn',
DATE_ADD(CURDATE(), INTERVAL 10 DAY), 'approved', 0 FROM companies WHERE name = 'PixelCraft Studio';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 2, 2, 'Sales Officer', 'meghna-sales-officer', 'full_time', 22000, 30000,
'Grow our product sales in the Chattogram region.\n\nRequirements:\n- Bachelor degree\n- 1+ year FMCG sales experience',
DATE_ADD(CURDATE(), INTERVAL 18 DAY), 'approved', 0 FROM companies WHERE name = 'Meghna Foods Ltd';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 3, 4, 'Junior Accountant', 'padma-junior-accountant', 'full_time', 20000, 26000,
'Daily accounts and bank entries.\n\nRequirements:\n- BBA/MBA in Accounting\n- Tally and Excel',
DATE_ADD(CURDATE(), INTERVAL 21 DAY), 'approved', 0 FROM companies WHERE name = 'Padma Finance';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 2, 3, 'Delivery Hub Supervisor', 'surma-hub-supervisor', 'contract', 18000, 24000,
'Manage daily parcel delivery at our Sylhet hub.\n\nRequirements:\n- HSC or above\n- Team handling experience',
DATE_ADD(CURDATE(), INTERVAL 16 DAY), 'approved', 0 FROM companies WHERE name = 'Surma Logistics';
INSERT INTO jobs (company_id, category_id, city_id, title, slug, job_type, salary_min, salary_max, description, deadline, status, is_featured)
SELECT id, 1, 1, 'Content Developer (Remote)', 'brightpath-content-dev', 'remote', 25000, 35000,
'Create online lessons and quizzes.\n\nRequirements:\n- Good writing skills\n- Basic HTML is a plus',
DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'approved', 1 FROM companies WHERE name = 'BrightPath Education';

-- কয়েকটা job-এর skill
INSERT INTO job_skills (job_id, skill_id) SELECT id, 1 FROM jobs WHERE slug = 'cloudnest-backend-php';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 2 FROM jobs WHERE slug = 'cloudnest-backend-php';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 6 FROM jobs WHERE slug = 'pixelcraft-ui-ux';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 5 FROM jobs WHERE slug = 'brightpath-content-dev';
INSERT INTO job_skills (job_id, skill_id) SELECT id, 7 FROM jobs WHERE slug = 'padma-junior-accountant';

-- CV Builder-এর নতুন দুটো template (আগে থেকে থাকলে আবার যোগ হবে না)
INSERT INTO cv_templates (name, thumbnail, layout_file, is_premium, status)
SELECT 'Minimal', NULL, 'templates/minimal.php', 0, 'active' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM cv_templates WHERE layout_file = 'templates/minimal.php');
INSERT INTO cv_templates (name, thumbnail, layout_file, is_premium, status)
SELECT 'Executive', NULL, 'templates/executive.php', 0, 'active' FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM cv_templates WHERE layout_file = 'templates/executive.php');
