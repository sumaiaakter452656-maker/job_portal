# Jobs Portal (JobHub)

A web-based job portal that connects job seekers with employers.
Employers create company profiles, buy a posting package and publish
job vacancies. Job seekers build a profile and CV, search and save jobs,
apply online and track their applications. An admin approves jobs and
manages users, companies, categories, payments, contact messages and
reports.

> **Project type:** Database Design Project\
> **Programme:** IsDB-BISEW IT Scholarship Programme --- Round 73\
> **Technology:** PHP 8, MySQL 8, HTML, CSS, JavaScript (no framework)

The code is written to be easy for beginners to read: plain PHP with
`mysqli`, one page per file, and comments in Bengali.

## User Roles

| Role           | Main responsibilities |
| -------------- | --------------------- |
| **Job Seeker** | Profile, CV builder, search/save/apply for jobs, track status. |
| **Employer**   | Company profile, buy a package, post jobs, manage applicants, shortlist by email. |
| **Admin**      | Approve jobs, manage users, companies, categories, payments, messages and reports. |

## Main Features

### Public website (no login needed)

- Home page with featured and latest jobs.
- **Find Jobs** with search and filters (keyword, city, category, job type, salary range) and sorting.
- Job details page, company list, pricing page and contact form.
- Only jobs that are **approved** and whose **deadline has not passed** are shown.

### Job Seeker (`seeker/`)

- Register and log in; edit personal info, education, experience,
  projects, certificates, languages and skills; change password.
- **Apply** with an uploaded CV or the CV saved in the profile.
- **Save** jobs (♥) and see them in *Saved Jobs*.
- *Applied Jobs* with a status filter.
- Dashboard shows **who shortlisted you**, notifications and recommended jobs.
- **CV Builder** with 4 templates (Classic, Modern, Minimal, Executive),
  built from the profile. The CV can be printed or **downloaded as a PDF**
  (PDF download uses html2pdf.js from a CDN, so it needs internet).

### Employer (`employer/`)

- Company profile with logo.
- Post a job; new jobs wait for admin approval. Each post uses one job
  post from the active package.
- Manage jobs and see applicants for each job.
- Change application status: `applied` → `viewed` → `shortlisted` →
  `interview` → `hired` / `rejected`.
- **Shortlist by email:** sends an email (PHP `mail()`, visible in
  Laragon's Mail Catcher) and a notification to the job seeker.
- Buy a package and see subscription and payment history.

### Admin (`admin/`)

- Dashboard with real counts.
- Users, companies, applications and payments lists.
- Jobs: **approve / reject / close**.
- Job categories CRUD.
- **Messages:** messages sent from the Contact page (open, reply by email,
  delete); the menu shows the unread count.
- **Reports:** total income, income for the last 6 months, new users and
  applications per month, jobs by category, applications by status, top
  companies and package sales. Can be printed or saved as PDF.

### Automatic expiry

`auto-expire.php` runs once a day (when the home page or admin dashboard
is opened):

- Jobs whose deadline has passed become `closed`.
- Packages whose end date has passed become `expired`.
- The employer gets a notification for each.

The admin can also run it any time with **Run expiry check now** on the
dashboard.

## Packages and Payments

| Package  | Price  | Job posts | Duration |
| -------- | ------ | --------- | -------- |
| Free     | ৳0     | 1         | 30 days  |
| Standard | ৳1,500 | 5         | 30 days  |
| Premium  | ৳4,000 | 20        | 60 days  |

- A new employer automatically gets the Free package on their first post.
- **Stacking:** when a new package is bought while an old one is still
  active, the remaining job posts and days of the old one are added to
  the new one.

### Payment workflow

All payments are **sandbox (test) payments --- no real money is charged.**

1. The employer chooses a package and a payment method.
2. The system creates a pending subscription and a pending transaction.
3. The employer pays on the gateway's sandbox page:
   - **bKash** → official bKash Tokenized Checkout sandbox.
   - **Nagad / Card** → aamarPay sandbox.
4. When the employer returns, the server **verifies the payment with the
   gateway's own API** (amount, invoice and status). The browser's
   "success" message alone is never trusted.
5. Only after verification is the transaction marked `completed` and the
   package activated.

If the browser does not return to the site (some browsers block a public
site from redirecting to `localhost`), the employer can press **Check** on
the *Subscription* page to verify the payment manually.

Sandbox test details:

- **bKash wallet:** `01929918378` (others: `01770618576`, `01877722345`),
  **OTP:** `123456`, **PIN:** `12121`
- **aamarPay:** choose any test method on the sandbox page.

Gateway settings are in `payment/bkash_config.php` and
`payment/aamarpay_config.php`.

## Getting Started (Laragon)

1. Install [Laragon](https://laragon.org/) and start **Apache** and **MySQL**.
2. Copy the project folder to `C:\laragon\www\job_portal`
   (or `D:\laragon\www\job_portal`).
3. Open phpMyAdmin or HeidiSQL, create a database named **`jobs_portal`**
   and import **`Database/jobs_portal.sql`**.
   - The import also moves the demo jobs' deadlines forward from today,
     so they show on the website on any PC.
4. Check the database settings in **`dbconfig.php`** (host, user, password,
   database name).
5. Open <http://localhost/job_portal/> in a browser.

### Demo accounts

The demo companies below have an employer account with password `123`:

`hr@cloudnest.test`, `hr@pixelcraft.test`, `hr@meghnafoods.test`,
`hr@padmafinance.test`, `hr@surmalogistics.test`, `hr@brightpath.test`

Admin, employer and seeker accounts can also be created from the
**Register** page (admin accounts are created directly in the `users`
table with `role = 'admin'`).

## Folder Structure

```
job_portal/
├── index.php, jobs.php, job-details.php, companies.php,
│   packages.php, contact.php          Public pages
├── login.php, register.php, logout.php
├── navber.php, footer.php, job-card.php   Shared parts
├── auto-expire.php                    Daily job/package expiry
├── dbconfig.php                       Database connection
├── admin/                             Admin panel (+ categories/)
├── employer/                          Employer dashboard and checkout
├── seeker/                            Job seeker dashboard, profile, CV
│   └── templates/                     4 CV templates
├── payment/                           bKash and aamarPay helpers
├── assets/                            CSS, JS, images
├── uploads/                           Logos and CV files
└── Database/jobs_portal.sql           Full database (schema + data)
```

## Database Design

The database has **22 tables**.

| Group | Tables |
| ----- | ------ |
| Users and profiles | `users`, `companies`, `seekers` |
| Lookup lists | `cities`, `categories`, `skills`, `cv_templates` |
| Job seeker CV details | `seeker_educations`, `seeker_experiences`, `seeker_skills`, `seeker_cv_items` |
| Jobs | `jobs`, `job_skills` |
| Applications | `job_applications`, `saved_jobs` |
| Packages | `packages`, `subscriptions` |
| Payments | `payment_methods`, `payment_transactions`, `demo_gateway` (old practice gateway, not used now) |
| Communication | `notifications`, `contact_messages` |

All users log in through the `users` table; the `role` column
(`admin`, `employer`, `seeker`) decides which dashboard they see.
`seeker_cv_items` stores projects, certificates and languages in one
table using a `type` column. When a seeker applies, the CV file is saved
in `job_applications.resume_file`, so the submitted version is kept.

### Table relationships

- **One-to-one:** `users` → `companies`, `users` → `seekers`.
- **One-to-many:** `companies` → `jobs`, `jobs` → `job_applications`,
  `users` → `subscriptions` → `payment_transactions`.
- **Many-to-many:** `jobs` ↔ `skills` (through `job_skills`),
  `seekers` ↔ `skills` (through `seeker_skills`),
  `seekers` ↔ `jobs` (through `saved_jobs`).

## Security Note

This is a learning project. Passwords are stored with **sha1** to keep
the code simple, and queries use `real_escape_string`. For a real
website, use `password_hash()` / `password_verify()`, prepared
statements and CSRF tokens.

## Future Improvements

- Candidate search for employers.
- Forgot password by email.
- Job alerts by category.
- Chat between employers and job seekers.
- Mobile application and multiple languages.

## Project Information

- **Project name:** Jobs Portal
- **Project category:** Database Design Project
- **Programme:** IsDB-BISEW IT Scholarship Programme
- **Round:** 73
- **Batch:** PWAD/USSL-M/73/01

------------------------------------------------------------------------

*Jobs Portal --- making job searching and recruitment simpler, faster,
and clearer.*
