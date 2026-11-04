<?php
/**
 * employer_dashboard.php – Employer Dashboard (design + read-only data)
 */
require_once __DIR__ . '/dashboard_config.php';

$userId = require_role('employer');
$me = row("SELECT id, name, email, phone, status, created_at FROM users WHERE id = ?", [$userId])
    ?? ['name' => 'Employer', 'email' => '', 'phone' => null, 'status' => 'active', 'created_at' => null];

/* ---------------- Company ---------------- */
$company = row("SELECT c.*, ci.name AS city
                FROM companies c
                LEFT JOIN cities ci ON ci.id = c.city_id
                WHERE c.user_id = ?", [$userId]) ?? [];
$companyId   = (int) ($company['id'] ?? 0);
$companyName = $company['name'] ?? $me['name'];

/* ---------------- Statistics ---------------- */
$totalJobs   = (int) scalar("SELECT COUNT(*) FROM jobs WHERE company_id = ?", [$companyId]);
$activeJobs  = (int) scalar("SELECT COUNT(*) FROM jobs WHERE company_id = ? AND status = 'approved' AND deadline >= CURDATE()", [$companyId]);
$pendingJobs = (int) scalar("SELECT COUNT(*) FROM jobs WHERE company_id = ? AND status = 'pending'", [$companyId]);
$totalApps   = (int) scalar("SELECT COUNT(*) FROM job_applications a JOIN jobs j ON j.id = a.job_id WHERE j.company_id = ?", [$companyId]);
$newApps     = (int) scalar("SELECT COUNT(*) FROM job_applications a JOIN jobs j ON j.id = a.job_id WHERE j.company_id = ? AND a.status = 'applied'", [$companyId]);
$shortlisted = (int) scalar("SELECT COUNT(*) FROM job_applications a JOIN jobs j ON j.id = a.job_id WHERE j.company_id = ? AND a.status IN ('shortlisted','interview')", [$companyId]);
$hired       = (int) scalar("SELECT COUNT(*) FROM job_applications a JOIN jobs j ON j.id = a.job_id WHERE j.company_id = ? AND a.status = 'hired'", [$companyId]);
$totalSpent  = (float) scalar("SELECT COALESCE(SUM(total_amount),0) FROM payment_transactions WHERE user_id = ? AND status = 'completed'", [$userId]);

/* ---------------- Subscription ---------------- */
$sub = row("SELECT s.*, pk.name AS package, pk.job_post_limit, pk.price, pk.duration_days
            FROM subscriptions s
            JOIN packages pk ON pk.id = s.package_id
            WHERE s.user_id = ? AND s.status = 'active'
            ORDER BY s.end_date DESC
            LIMIT 1", [$userId]);
$subDaysLeft = ($sub && $sub['end_date']) ? max(0, (int) floor((strtotime($sub['end_date']) - strtotime('today')) / 86400)) : 0;
$postsUsed   = $sub ? max(0, (int) $sub['job_post_limit'] - (int) $sub['posts_left']) : 0;
$usagePct    = ($sub && $sub['job_post_limit'] > 0) ? round($postsUsed / $sub['job_post_limit'] * 100) : 0;

/* ---------------- Charts ---------------- */
$months   = last_months(6);
$appsData = rows("SELECT DATE_FORMAT(a.applied_at, '%Y-%m') ym, COUNT(*) c
                  FROM job_applications a
                  JOIN jobs j ON j.id = a.job_id
                  WHERE j.company_id = ? AND a.applied_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
                  GROUP BY ym", [$companyId]);
$chartSeries = [['name' => 'Applications received', 'color' => '#10b981', 'values' => fill_months($months, $appsData)]];

$statusColors = [
    'applied' => '#f59e0b', 'viewed' => '#06b6d4', 'shortlisted' => '#3b82f6',
    'interview' => '#8b5cf6', 'hired' => '#10b981', 'rejected' => '#ef4444',
];
$statusCounts = array_column(rows("SELECT a.status, COUNT(*) c
                                   FROM job_applications a
                                   JOIN jobs j ON j.id = a.job_id
                                   WHERE j.company_id = ?
                                   GROUP BY a.status", [$companyId]), 'c', 'status');
$donut = [];
foreach ($statusColors as $st => $color) {
    $donut[] = ['label' => label($st), 'value' => (int) ($statusCounts[$st] ?? 0), 'color' => $color];
}

/* ---------------- Tables ---------------- */
$myJobs = rows("SELECT j.id, j.title, j.job_type, j.status, j.deadline, j.is_featured, j.salary_min, j.salary_max,
                       cat.name AS category, ci.name AS city,
                       (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.id) AS apps,
                       (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.id AND a.status IN ('shortlisted','interview','hired')) AS shortlisted
                FROM jobs j
                LEFT JOIN categories cat ON cat.id = j.category_id
                LEFT JOIN cities ci      ON ci.id = j.city_id
                WHERE j.company_id = ?
                ORDER BY j.id DESC
                LIMIT 6", [$companyId]);

$applicants = rows("SELECT a.id, a.status AS app_status, a.applied_at, a.resume_file,
                           j.title, u.name AS seeker_name, u.email AS seeker_email,
                           s.headline, s.experience_years, ci.name AS seeker_city
                    FROM job_applications a
                    JOIN jobs j       ON j.id = a.job_id
                    JOIN seekers s    ON s.id = a.seeker_id
                    JOIN users u      ON u.id = s.user_id
                    LEFT JOIN cities ci ON ci.id = s.city_id
                    WHERE j.company_id = ?
                    ORDER BY a.applied_at DESC
                    LIMIT 6", [$companyId]);

$payments = rows("SELECT p.transaction_no, p.total_amount, p.tx_id, p.status, m.name AS method, pk.name AS package
                  FROM payment_transactions p
                  JOIN payment_methods m ON m.id = p.payment_method_id
                  JOIN subscriptions s   ON s.id = p.subscription_id
                  JOIN packages pk       ON pk.id = s.package_id
                  WHERE p.user_id = ?
                  ORDER BY p.id DESC
                  LIMIT 5", [$userId]);

$packages   = rows("SELECT * FROM packages ORDER BY price");
$categories = rows("SELECT id, name FROM categories ORDER BY name");
$cities     = rows("SELECT id, name FROM cities ORDER BY name");
$skillList  = rows("SELECT id, name FROM skills ORDER BY name");

/* Notifications */
$notifs      = rows("SELECT message, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5", [$userId]);
$unreadCount = (int) scalar("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0", [$userId]);

$jobTypes = ['full_time', 'part_time', 'contract', 'internship', 'remote'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employer Dashboard · Jobs Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="theme-employer">

<!-- ================= SIDEBAR ================= -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-briefcase-fill"></i></div>
        <div class="brand-text">Jobs<span>Portal</span><small class="brand-role">Employer</small></div>
        <button class="btn btn-sm text-white ms-auto d-lg-none" id="sidebarClose" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav class="sidebar-menu">
        <div class="nav-section">Main</div>
        <a href="employer_dashboard.php" class="side-link active"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
        <a href="#analytics" class="side-link"><i class="bi bi-graph-up-arrow"></i><span>Hiring Analytics</span></a>

        <div class="nav-section">Jobs</div>
        <a href="#post-job" class="side-link"><i class="bi bi-plus-square"></i><span>Post a Job</span></a>
        <a href="#my-jobs" class="side-link"><i class="bi bi-briefcase"></i><span>Manage Jobs</span>
            <?php if ($totalJobs): ?><em class="side-badge"><?= $totalJobs ?></em><?php endif; ?></a>
        <a href="#applicants" class="side-link"><i class="bi bi-people"></i><span>Applicants</span>
            <?php if ($newApps): ?><em class="side-badge"><?= $newApps ?> new</em><?php endif; ?></a>
        <a href="#applicants" class="side-link"><i class="bi bi-person-check"></i><span>Shortlisted</span></a>

        <div class="nav-section">Company</div>
        <a href="#company" class="side-link"><i class="bi bi-buildings"></i><span>Company Profile</span></a>

        <div class="nav-section">Billing</div>
        <a href="#subscription" class="side-link"><i class="bi bi-box-seam"></i><span>Packages</span></a>
        <a href="#subscription" class="side-link"><i class="bi bi-arrow-repeat"></i><span>My Subscription</span></a>
        <a href="#payments" class="side-link"><i class="bi bi-receipt"></i><span>Payment History</span></a>

        <div class="nav-section">Account</div>
        <a href="#" class="side-link"><i class="bi bi-bell"></i><span>Notifications</span>
            <?php if ($unreadCount): ?><em class="side-badge"><?= $unreadCount ?></em><?php endif; ?></a>
        <a href="#" class="side-link"><i class="bi bi-key"></i><span>Change Password</span></a>
        <a href="logout.php" class="side-link"><i class="bi bi-box-arrow-left"></i><span>Logout</span></a>
    </nav>

    <div class="sidebar-footer">
        <div class="upgrade-box">
            <?php if ($sub): ?>
                <h6><i class="bi bi-gem me-1"></i> <?= e($sub['package']) ?> Plan</h6>
                <p><?= (int) $sub['posts_left'] ?> job post(s) left · <?= $subDaysLeft ?> day(s) remaining</p>
                <a href="#subscription" class="btn btn-light btn-sm w-100">Upgrade Plan</a>
            <?php else: ?>
                <h6><i class="bi bi-gem me-1"></i> No active plan</h6>
                <p>Choose a package to start posting jobs.</p>
                <a href="#subscription" class="btn btn-light btn-sm w-100">View Packages</a>
            <?php endif; ?>
        </div>
    </div>
</aside>
<div class="sidebar-overlay"></div>

<!-- ================= MAIN ================= -->
<div class="main">

    <header class="topbar">
        <button class="icon-btn" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>

        <div class="top-search">
            <i class="bi bi-search"></i>
            <input type="search" id="globalSearch" placeholder="Search jobs or applicants… (press Enter)">
        </div>

        <div class="topbar-right">
            <a href="#post-job" class="btn btn-accent btn-sm d-none d-md-inline-flex align-items-center gap-1"><i class="bi bi-plus-lg"></i> Post a Job</a>

            <div class="dropdown">
                <button class="icon-btn" data-bs-toggle="dropdown" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <?php if ($unreadCount): ?><span class="dot"><?= $unreadCount ?></span><?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-menu">
                    <div class="notif-head"><strong>Notifications</strong><span class="tag tag-accent"><?= $unreadCount ?> new</span></div>
                    <?php if ($notifs): foreach ($notifs as $n): ?>
                        <a href="#" class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>">
                            <span class="ico"><i class="bi bi-person-plus"></i></span>
                            <div><p><?= e($n['message']) ?></p><small class="text-muted"><?= time_ago($n['created_at']) ?></small></div>
                        </a>
                    <?php endforeach; else: ?>
                        <div class="empty-state py-4"><i class="bi bi-bell-slash"></i>No notifications yet</div>
                    <?php endif; ?>
                    <a href="#" class="d-block text-center py-2 small fw-semibold">View all</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="user-chip" data-bs-toggle="dropdown">
                    <?= logo_or_avatar($company['logo'] ?? null, $companyName) ?>
                    <span class="meta text-start d-none d-sm-block">
                        <span class="name d-block"><?= e($companyName) ?></span>
                        <span class="role"><?= e($me['name']) ?></span>
                    </span>
                    <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2"><strong class="d-block"><?= e($me['name']) ?></strong><small class="text-muted"><?= e($me['email']) ?></small></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#company"><i class="bi bi-buildings"></i> Company Profile</a></li>
                    <li><a class="dropdown-item" href="#subscription"><i class="bi bi-gem"></i> My Subscription</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="content">

        <?php if (($me['status'] ?? 'active') === 'pending'): ?>
            <div class="alert alert-warning d-flex align-items-center gap-2 rounded-4 border-0 mb-4">
                <i class="bi bi-hourglass-split fs-5"></i>
                <div>Your employer account is <strong>pending approval</strong>. Jobs you post will go live once an admin approves your account.</div>
            </div>
        <?php endif; ?>

        <!-- Hero -->
        <div class="hero-card mb-4 reveal" id="company">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <?php if (!empty($company['logo'])): ?>
                            <img src="<?= e($company['logo']) ?>" alt="" class="avatar lg avatar-img">
                        <?php else: ?>
                            <span class="avatar lg" style="background:rgba(255,255,255,.2)"><?= e(initials($companyName)) ?></span>
                        <?php endif; ?>
                        <div>
                            <small style="opacity:.85"><span data-greeting>Hello</span>, <?= e(explode(' ', $me['name'])[0]) ?> 👋</small>
                            <h2 class="mb-0"><?= e($companyName) ?></h2>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-geo-alt"></i> <?= e($company['city'] ?? 'Location not set') ?>
                        <?php if (!empty($company['website'])): ?> &nbsp;·&nbsp; <i class="bi bi-globe"></i> <?= e(preg_replace('#^https?://#', '', $company['website'])) ?><?php endif; ?>
                        <br>You have <strong><?= $newApps ?> new applicant(s)</strong> waiting for review and <strong><?= $activeJobs ?></strong> live job(s).
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#post-job" class="btn btn-hero"><i class="bi bi-plus-lg me-1"></i> Post a New Job</a>
                        <a href="#applicants" class="btn btn-hero-outline"><i class="bi bi-people me-1"></i> Review Applicants</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-2 text-center">
                        <div class="col-6"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-4 fw-bold"><?= $hired ?></div><small style="opacity:.85">Hired</small></div></div>
                        <div class="col-6"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-4 fw-bold"><?= $pendingJobs ?></div><small style="opacity:.85">Pending Jobs</small></div></div>
                        <div class="col-12"><div class="p-3 rounded-4" style="background:rgba(255,255,255,.14)"><div class="fs-5 fw-bold"><?= taka($totalSpent) ?></div><small style="opacity:.85">Total spent on packages</small></div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-blue">
                    <div class="stat-top">
                        <div><div class="stat-label">Posted Jobs</div><div class="stat-value" data-count="<?= $totalJobs ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-warn"><?= $pendingJobs ?></span> awaiting approval</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-green">
                    <div class="stat-top">
                        <div><div class="stat-label">Active Jobs</div><div class="stat-value" data-count="<?= $activeJobs ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-broadcast"></i></div>
                    </div>
                    <div class="stat-foot">Approved &amp; before deadline</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-purple">
                    <div class="stat-top">
                        <div><div class="stat-label">Total Applicants</div><div class="stat-value" data-count="<?= $totalApps ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><i class="bi bi-arrow-up-right"></i> <?= $newApps ?></span> new, not reviewed</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-orange">
                    <div class="stat-top">
                        <div><div class="stat-label">Shortlisted</div><div class="stat-value" data-count="<?= $shortlisted ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-person-check-fill"></i></div>
                    </div>
                    <div class="stat-foot">Shortlisted &amp; interview stage</div>
                </div>
            </div>
        </div>

        <!-- Analytics -->
        <div class="row g-3 g-xl-4 mb-4" id="analytics">
            <div class="col-xl-5 reveal">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Applications Received</h5><p>Last 6 months</p></div>
                        <div class="chart-legend"><span><i style="background:#10b981"></i>Applications</span></div>
                    </div>
                    <div class="card-x-body">
                        <div class="bar-chart" data-labels='<?= e(json_encode(array_values($months))) ?>' data-series='<?= e(json_encode($chartSeries)) ?>'></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 reveal">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Hiring Funnel</h5><p>Applicant status</p></div></div>
                    <div class="card-x-body">
                        <div class="donut-wrap">
                            <div class="donut" style="width:160px;height:160px" data-segments='<?= e(json_encode($donut)) ?>' data-legend="#empLegend">
                                <div class="donut-center"><div><strong><?= $totalApps ?></strong><small>Applicants</small></div></div>
                            </div>
                            <div class="donut-legend" id="empLegend"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4 reveal" id="subscription">
                <div class="sub-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="muted">Current Plan</div>
                            <h4 class="fw-bold mb-0 text-white"><?= $sub ? e($sub['package']) : 'No Active Plan' ?></h4>
                        </div>
                        <span class="badge-soft <?= $sub ? 'badge-soft-success' : 'badge-soft-secondary' ?>"><?= $sub ? 'Active' : 'Inactive' ?></span>
                    </div>
                    <?php if ($sub): ?>
                        <div class="d-flex justify-content-between small mb-2">
                            <span class="muted">Job posts used</span><strong><?= $postsUsed ?> / <?= (int) $sub['job_post_limit'] ?></strong>
                        </div>
                        <div class="progress mb-3"><div class="progress-bar" data-width="<?= $usagePct ?>"></div></div>
                        <div class="row g-2 text-center mb-3">
                            <div class="col-4"><div class="fw-bold fs-5"><?= (int) $sub['posts_left'] ?></div><div class="muted">Posts left</div></div>
                            <div class="col-4"><div class="fw-bold fs-5"><?= $subDaysLeft ?></div><div class="muted">Days left</div></div>
                            <div class="col-4"><div class="fw-bold fs-5"><?= (float) $sub['price'] > 0 ? taka($sub['price']) : 'Free' ?></div><div class="muted">Price</div></div>
                        </div>
                        <div class="muted mb-3"><i class="bi bi-calendar-event"></i> <?= nice_date($sub['start_date']) ?> – <?= nice_date($sub['end_date']) ?></div>
                    <?php else: ?>
                        <p class="muted mb-3">Subscribe to a package to start posting jobs and reach thousands of job seekers.</p>
                    <?php endif; ?>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($packages as $pk): ?>
                            <span class="tag" style="background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.12);color:#e2e8f0">
                                <?= e($pk['name']) ?> · <?= (float) $pk['price'] > 0 ? taka($pk['price']) : 'Free' ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" class="btn btn-accent w-100 mt-3"><i class="bi bi-gem me-1"></i> <?= $sub ? 'Upgrade Plan' : 'Choose a Package' ?></a>
                </div>
            </div>
        </div>

        <!-- My jobs -->
        <div class="card-x mb-4 reveal" id="my-jobs" style="height:auto">
            <div class="card-x-head">
                <div><h5>My Job Posts</h5><p>Manage your listings and see how they perform</p></div>
                <div class="table-tools">
                    <select class="form-select form-select-sm" style="width:auto" data-status-filter="#myJobsTable">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="closed">Closed</option>
                    </select>
                    <div class="table-search d-none d-sm-block"><i class="bi bi-search"></i><input type="search" placeholder="Search jobs…" data-table-filter="#myJobsTable"></div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-modern" id="myJobsTable">
                    <thead><tr><th>Job Title</th><th>Type</th><th>Salary</th><th>Applicants</th><th>Deadline</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                    <?php if ($myJobs): foreach ($myJobs as $j):
                        $expired = strtotime($j['deadline']) < strtotime('today'); ?>
                        <tr data-status="<?= e($j['status']) ?>">
                            <td>
                                <div class="t fw-bold"><?= e($j['title']) ?>
                                    <?php if ($j['is_featured']): ?><span class="tag tag-featured ms-1"><i class="bi bi-star-fill"></i> Featured</span><?php endif; ?>
                                </div>
                                <small class="text-muted"><?= e($j['category'] ?: '—') ?> · <i class="bi bi-geo-alt"></i> <?= e($j['city'] ?: 'N/A') ?></small>
                            </td>
                            <td><span class="tag tag-accent"><?= e(label($j['job_type'])) ?></span></td>
                            <td class="text-nowrap small fw-semibold"><?= salary_range($j['salary_min'], $j['salary_max']) ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <strong><?= (int) $j['apps'] ?></strong>
                                    <small class="text-muted text-nowrap">(<?= (int) $j['shortlisted'] ?> shortlisted)</small>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <?= nice_date($j['deadline']) ?>
                                <?php if ($expired): ?><br><small class="text-danger">Expired</small><?php endif; ?>
                            </td>
                            <td><?= badge($j['status']) ?></td>
                            <td class="text-end text-nowrap">
                                <a href="#" class="action-btn" data-bs-toggle="tooltip" title="View applicants"><i class="bi bi-people"></i></a>
                                <a href="#" class="action-btn" data-bs-toggle="tooltip" title="Edit"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr class="no-filter"><td colspan="7"><div class="empty-state"><i class="bi bi-briefcase"></i>You haven't posted any job yet.<br><a href="#post-job" class="fw-semibold">Post your first job</a></div></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-x-foot"><a href="#">Manage all jobs <i class="bi bi-arrow-right"></i></a></div>
        </div>

        <!-- Applicants + payments -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-7 reveal" id="applicants">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Recent Applicants</h5><p>Candidates who applied to your jobs</p></div>
                        <div class="table-search"><i class="bi bi-search"></i><input type="search" placeholder="Search candidate…" data-table-filter="#applicantsTable"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern" id="applicantsTable">
                            <thead><tr><th>Candidate</th><th>Applied For</th><th>Status</th><th class="text-end">CV</th></tr></thead>
                            <tbody>
                            <?php if ($applicants): foreach ($applicants as $a): ?>
                                <tr>
                                    <td>
                                        <div class="cell-main">
                                            <span class="avatar round avatar-<?= avatar_color($a['seeker_name']) ?>"><?= e(initials($a['seeker_name'])) ?></span>
                                            <div>
                                                <div class="t"><?= e($a['seeker_name']) ?></div>
                                                <div class="s"><?= e($a['headline'] ?: 'Job Seeker') ?> · <?= (int) $a['experience_years'] ?> yrs<?= $a['seeker_city'] ? ' · ' . e($a['seeker_city']) : '' ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="fw-semibold small"><?= e($a['title']) ?></div><small class="text-muted"><?= time_ago($a['applied_at']) ?></small></td>
                                    <td><?= badge($a['app_status']) ?></td>
                                    <td class="text-end text-nowrap">
                                        <a href="<?= e($a['resume_file']) ?>" target="_blank" class="action-btn" data-bs-toggle="tooltip" title="Download CV"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <a href="mailto:<?= e($a['seeker_email']) ?>" class="action-btn" data-bs-toggle="tooltip" title="Email"><i class="bi bi-envelope"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr class="no-filter"><td colspan="4"><div class="empty-state"><i class="bi bi-people"></i>No applicants yet</div></td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-x-foot"><a href="#">View all applicants <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="col-xl-5 reveal" id="payments">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Payment History</h5><p>Your package purchases</p></div><span class="tag tag-accent">Spent <?= taka($totalSpent) ?></span></div>
                    <ul class="list-x">
                        <?php if ($payments): foreach ($payments as $p): ?>
                            <li>
                                <span class="avatar sm avatar-accent"><i class="bi bi-receipt"></i></span>
                                <div class="info">
                                    <div class="t">#<?= e($p['transaction_no']) ?> · <?= e($p['package']) ?></div>
                                    <div class="s"><?= e($p['method']) ?><?= $p['tx_id'] ? ' · TrxID ' . e($p['tx_id']) : '' ?></div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold small"><?= taka($p['total_amount']) ?></div>
                                    <?= badge($p['status']) ?>
                                </div>
                            </li>
                        <?php endforeach; else: ?>
                            <li class="d-block"><div class="empty-state"><i class="bi bi-receipt"></i>No payments yet</div></li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-x-foot"><a href="#">Full payment history <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>
        </div>

        <!-- Post a job (design only) -->
        <div class="card-x mb-2 reveal" id="post-job" style="height:auto">
            <div class="card-x-head">
                <div><h5>Post a New Job</h5><p><?= $sub ? 'This post will use 1 of your ' . (int) $sub['posts_left'] . ' remaining post(s)' : 'You need an active package to publish jobs' ?></p></div>
                <span class="tag tag-accent"><i class="bi bi-info-circle"></i> Jobs are reviewed by admin before going live</span>
            </div>
            <div class="card-x-body">
                <form data-demo="Job post form ready (design preview)" novalidate>
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <label class="form-label">Job Title <span class="text-danger">*</span></label>
                            <div class="input-icon"><i class="bi bi-briefcase"></i><input type="text" class="form-control" placeholder="e.g. Senior Laravel Developer" required></div>
                            <div class="invalid-feedback">Job title is required.</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <div class="input-icon"><i class="bi bi-clock"></i>
                                <select class="form-select" required>
                                    <?php foreach ($jobTypes as $t): ?><option value="<?= $t ?>"><?= label($t) ?></option><?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">Category</label>
                            <div class="input-icon"><i class="bi bi-tag"></i>
                                <select class="form-select" required>
                                    <option value="">Select</option>
                                    <?php foreach ($categories as $c): ?><option value="<?= (int) $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?>
                                </select>
                            </div>
                            <div class="invalid-feedback">Choose a category.</div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <label class="form-label">City</label>
                            <div class="input-icon"><i class="bi bi-geo-alt"></i>
                                <select class="form-select" required>
                                    <option value="">Select</option>
                                    <?php foreach ($cities as $c): ?><option value="<?= (int) $c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?>
                                </select>
                            </div>
                            <div class="invalid-feedback">Choose a city.</div>
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Min Salary (৳)</label>
                            <input type="number" min="0" class="form-control" placeholder="30000">
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Max Salary (৳)</label>
                            <input type="number" min="0" class="form-control" placeholder="50000">
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label">Deadline <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                            <div class="invalid-feedback">Set a deadline.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Job Description</label>
                            <textarea class="form-control" rows="4" placeholder="Responsibilities, requirements, benefits…"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Required Skills</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($skillList as $s): ?>
                                    <input type="checkbox" class="btn-check" id="sk<?= (int) $s['id'] ?>" autocomplete="off">
                                    <label class="btn btn-white btn-sm" for="sk<?= (int) $s['id'] ?>"><?= e($s['name']) ?></label>
                                <?php endforeach; ?>
                                <?php if (!$skillList): ?><span class="text-muted small">No skills found</span><?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-3 pt-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featuredSwitch" <?= ($sub && stripos($sub['package'], 'premium') !== false) ? '' : 'disabled' ?>>
                                <label class="form-check-label small" for="featuredSwitch">Mark as <strong>Featured</strong> <span class="text-muted">(Premium plan)</span></label>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-white">Clear</button>
                                <button type="submit" class="btn btn-accent"><i class="bi bi-send me-1"></i> Submit for Review</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <span>© <span id="year"><?= date('Y') ?></span> Jobs Portal. All rights reserved.</span>
        <span>Employer Panel · v1.0</span>
    </footer>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="appToast" class="toast toast-x" role="status" aria-live="polite">
        <div class="toast-body"><i class="bi bi-check-circle-fill"></i><span class="toast-msg">Saved</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
