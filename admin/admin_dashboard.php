<?php
require_once __DIR__ . '/../dashboard_config.php';

$adminId = require_role('admin');
$me = row("SELECT id, name, email FROM users WHERE id = ?", [$adminId]) ?? ['name' => 'Admin', 'email' => ''];

/* ---------------- Statistics ---------------- */
$totalJobs      = (int) scalar("SELECT COUNT(*) FROM jobs");
$pendingJobs    = (int) scalar("SELECT COUNT(*) FROM jobs WHERE status = 'pending'");
$liveJobs       = (int) scalar("SELECT COUNT(*) FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()");
$featuredJobs   = (int) scalar("SELECT COUNT(*) FROM jobs WHERE is_featured = 1");
$totalSeekers   = (int) scalar("SELECT COUNT(*) FROM users WHERE role = 'seeker'");
$totalEmployers = (int) scalar("SELECT COUNT(*) FROM users WHERE role = 'employer'");
$totalCompanies = (int) scalar("SELECT COUNT(*) FROM companies");
$totalApps      = (int) scalar("SELECT COUNT(*) FROM job_applications");
$appsThisMonth  = (int) scalar("SELECT COUNT(*) FROM job_applications WHERE applied_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')");
$newUsersMonth  = (int) scalar("SELECT COUNT(*) FROM users WHERE created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')");
$pendingUsers   = (int) scalar("SELECT COUNT(*) FROM users WHERE status = 'pending'");
$revenue        = (float) scalar("SELECT COALESCE(SUM(total_amount),0) FROM payment_transactions WHERE status = 'completed'");
$pendingPay     = (int) scalar("SELECT COUNT(*) FROM payment_transactions WHERE status = 'pending'");
$activeSubs     = (int) scalar("SELECT COUNT(*) FROM subscriptions WHERE status = 'active'");

/* ---------------- Chart: last 6 months ---------------- */
$months   = last_months(6);
$appsData = rows("SELECT DATE_FORMAT(applied_at, '%Y-%m') ym, COUNT(*) c
                  FROM job_applications
                  WHERE applied_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
                  GROUP BY ym");
$userData = rows("SELECT DATE_FORMAT(created_at, '%Y-%m') ym, COUNT(*) c
                  FROM users
                  WHERE created_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
                  GROUP BY ym");
$chartSeries = [
    ['name' => 'Applications',   'color' => '#6366f1', 'values' => fill_months($months, $appsData)],
    ['name' => 'New Registrations', 'color' => '#22d3ee', 'values' => fill_months($months, $userData)],
];

/* ---------------- Donut: application status ---------------- */
$statusColors = [
    'applied' => '#f59e0b', 'viewed' => '#06b6d4', 'shortlisted' => '#3b82f6',
    'interview' => '#8b5cf6', 'hired' => '#10b981', 'rejected' => '#ef4444',
];
$statusCounts = array_column(rows("SELECT status, COUNT(*) c FROM job_applications GROUP BY status"), 'c', 'status');
$donut = [];
foreach ($statusColors as $st => $color) {
    $donut[] = ['label' => label($st), 'value' => (int) ($statusCounts[$st] ?? 0), 'color' => $color];
}

/* ---------------- Tables / lists ---------------- */
$recentJobs = rows("SELECT j.id, j.title, j.job_type, j.status, j.deadline, j.is_featured,
                           c.name AS company, c.logo, cat.name AS category, ci.name AS city,
                           (SELECT COUNT(*) FROM job_applications a WHERE a.job_id = j.id) AS apps
                    FROM jobs j
                    JOIN companies c       ON c.id = j.company_id
                    LEFT JOIN categories cat ON cat.id = j.category_id
                    LEFT JOIN cities ci      ON ci.id = j.city_id
                    ORDER BY j.id DESC
                    LIMIT 7");

$jobsByCategory = rows("SELECT cat.name, COUNT(j.id) AS total
                        FROM categories cat
                        LEFT JOIN jobs j ON j.category_id = cat.id
                        GROUP BY cat.id, cat.name
                        ORDER BY total DESC, cat.name
                        LIMIT 6");
$maxCat = max(array_merge([1], array_map('intval', array_column($jobsByCategory, 'total'))));

$recentPayments = rows("SELECT p.id, p.transaction_no, p.total_amount, p.tx_id, p.status,
                               u.name, u.email, m.name AS method, pk.name AS package
                        FROM payment_transactions p
                        JOIN users u            ON u.id = p.user_id
                        JOIN payment_methods m  ON m.id = p.payment_method_id
                        JOIN subscriptions s    ON s.id = p.subscription_id
                        JOIN packages pk        ON pk.id = s.package_id
                        ORDER BY (p.status = 'pending') DESC, p.id DESC
                        LIMIT 6");

$recentUsers = rows("SELECT id, name, email, role, status, created_at
                     FROM users
                     ORDER BY created_at DESC
                     LIMIT 6");

$packages = rows("SELECT pk.*,
                         (SELECT COUNT(*) FROM subscriptions s WHERE s.package_id = pk.id AND s.status = 'active') AS active_subs
                  FROM packages pk
                  ORDER BY pk.price");

$topCompanies = rows("SELECT c.name, c.logo, ci.name AS city, COUNT(j.id) AS jobs
                      FROM companies c
                      LEFT JOIN jobs j   ON j.company_id = c.id
                      LEFT JOIN cities ci ON ci.id = c.city_id
                      GROUP BY c.id, c.name, c.logo, ci.name
                      ORDER BY jobs DESC
                      LIMIT 5");

$categories = rows("SELECT id, name FROM categories ORDER BY name");

/* ---------------- Notifications ---------------- */
$notifs      = rows("SELECT message, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5", [$adminId]);
$unreadCount = (int) scalar("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0", [$adminId]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard · Jobs Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    
</head>
<body class="theme-admin">

<!-- ================= SIDEBAR ================= -->
<?php include('includes/leftbar.php');
?>

<!-- ================= MAIN ================= -->
<div class="main">

    <!-- Topbar -->
    <header class="topbar">
        <button class="icon-btn" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>

        <div class="top-search">
            <i class="bi bi-search"></i>
            <input type="search" id="globalSearch" placeholder="Search jobs, users, payments… (press Enter)">
        </div>

        <div class="topbar-right">
            <a href="index.php" class="btn btn-white btn-sm d-none d-md-inline-flex align-items-center gap-1" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>

            <div class="dropdown">
                <button class="icon-btn" data-bs-toggle="dropdown" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <?php if ($unreadCount): ?><span class="dot"><?= $unreadCount ?></span><?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-menu">
                    <div class="notif-head">
                        <strong>Notifications</strong>
                        <span class="tag tag-accent"><?= $unreadCount ?> new</span>
                    </div>
                    <?php if ($notifs): foreach ($notifs as $n): ?>
                        <a href="#" class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>">
                            <span class="ico"><i class="bi bi-bell"></i></span>
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
                    <span class="avatar avatar-accent round"><?= e(initials($me['name'])) ?></span>
                    <span class="meta text-start d-none d-sm-block">
                        <span class="name d-block"><?= e($me['name']) ?></span>
                        <span class="role">Administrator</span>
                    </span>
                    <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2"><strong class="d-block"><?= e($me['name']) ?></strong><small class="text-muted"><?= e($me['email']) ?></small></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <div class="page-head">
            <div>
                <h1><span data-greeting>Welcome</span>, <?= e(explode(' ', $me['name'])[0]) ?> 👋</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin_dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
            <!-- <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="btn btn-white btn-sm pe-none"><i class="bi bi-calendar3 me-1"></i> <span id="liveDate"><?= date('l, d F Y') ?></span></span>
                <a href="#recent-jobs" class="btn btn-accent btn-sm"><i class="bi bi-check2-circle me-1"></i> Review Jobs</a>
            </div> -->
        </div>

        <!-- Stat cards -->
        <!-- <div class="row g-3 g-xl-4 mb-4">
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-blue">
                    <div class="stat-top">
                        <div><div class="stat-label">Total Jobs</div><div class="stat-value" data-count="<?= $totalJobs ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-briefcase-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><i class="bi bi-broadcast"></i> <?= $liveJobs ?></span> live now</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-green">
                    <div class="stat-top">
                        <div><div class="stat-label">Job Seekers</div><div class="stat-value" data-count="<?= $totalSeekers ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><i class="bi bi-arrow-up-right"></i> <?= $newUsersMonth ?></span> new users this month</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-orange">
                    <div class="stat-top">
                        <div><div class="stat-label">Employers</div><div class="stat-value" data-count="<?= $totalEmployers ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-buildings-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-warn"><i class="bi bi-building"></i> <?= $totalCompanies ?></span> company profiles</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-purple">
                    <div class="stat-top">
                        <div><div class="stat-label">Applications</div><div class="stat-value" data-count="<?= $totalApps ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-file-earmark-person-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><i class="bi bi-arrow-up-right"></i> <?= $appsThisMonth ?></span> this month</div>
                </div>
            </div>
        </div> -->

        <!-- Mini stats -->
        <!-- <div class="row g-3 g-xl-4 mb-4">
            <div class="col-6 col-xl-3 reveal">
                <div class="mini-stat tone-green"><span class="ico"><i class="bi bi-cash-coin"></i></span>
                    <div><h6 data-count="<?= (int) $revenue ?>" data-prefix="৳">৳0</h6><small>Total Revenue</small></div></div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="mini-stat tone-red"><span class="ico"><i class="bi bi-hourglass-split"></i></span>
                    <div><h6 data-count="<?= $pendingJobs ?>">0</h6><small>Pending Jobs</small></div></div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="mini-stat tone-cyan"><span class="ico"><i class="bi bi-arrow-repeat"></i></span>
                    <div><h6 data-count="<?= $activeSubs ?>">0</h6><small>Active Subscriptions</small></div></div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="mini-stat tone-pink"><span class="ico"><i class="bi bi-star-fill"></i></span>
                    <div><h6 data-count="<?= $featuredJobs ?>">0</h6><small>Featured Jobs</small></div></div>
            </div>
        </div> -->

        <!-- Charts -->
        <!-- <div class="row g-3 g-xl-4 mb-4" id="analytics">
            <div class="col-xl-8 reveal">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Platform Activity</h5><p>Applications vs new registrations – last 6 months</p></div>
                        <div class="chart-legend">
                            <?php foreach ($chartSeries as $s): ?>
                                <span><i style="background:<?= $s['color'] ?>"></i><?= e($s['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-x-body">
                        <div class="bar-chart"
                             data-labels='<?= e(json_encode(array_values($months))) ?>'
                             data-series='<?= e(json_encode($chartSeries)) ?>'></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 reveal">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Application Status</h5><p>Overall hiring pipeline</p></div></div>
                    <div class="card-x-body">
                        <div class="donut-wrap">
                            <div class="donut" data-segments='<?= e(json_encode($donut)) ?>' data-legend="#appLegend">
                                <div class="donut-center"><div><strong><?= $totalApps ?></strong><small>Total</small></div></div>
                            </div>
                            <div class="donut-legend" id="appLegend"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Recent jobs + categories -->
        <!-- <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-8 reveal" id="recent-jobs">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Recent Job Posts</h5><p>Latest jobs submitted by employers</p></div>
                        <div class="table-tools">
                            <select class="form-select form-select-sm" style="width:auto" data-status-filter="#jobsTable">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="closed">Closed</option>
                            </select>
                            <div class="table-search d-none d-sm-block">
                                <i class="bi bi-search"></i>
                                <input type="search" placeholder="Search…" data-table-filter="#jobsTable">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern" id="jobsTable">
                            <thead>
                            <tr><th>Job</th><th>Category</th><th class="d-none d-xxl-table-cell">Type</th><th>Applicants</th><th>Deadline</th><th>Status</th><th class="text-end">Action</th></tr>
                            </thead>
                            <tbody>
                            <?php if ($recentJobs): foreach ($recentJobs as $j): ?>
                                <tr data-status="<?= e($j['status']) ?>">
                                    <td>
                                        <div class="cell-main">
                                            <?= logo_or_avatar($j['logo'], $j['company']) ?>
                                            <div>
                                                <div class="t"><?= e($j['title']) ?>
                                                    <?php if ($j['is_featured']): ?><i class="bi bi-star-fill text-warning small" title="Featured"></i><?php endif; ?>
                                                </div>
                                                <div class="s"><?= e($j['company']) ?> · <i class="bi bi-geo-alt"></i> <?= e($j['city'] ?: 'N/A') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="tag"><?= e($j['category'] ?: '—') ?></span></td>
                                    <td class="text-nowrap d-none d-xxl-table-cell"><?= e(label($j['job_type'])) ?></td>
                                    <td><span class="fw-semibold"><?= (int) $j['apps'] ?></span></td>
                                    <td class="text-nowrap <?= strtotime($j['deadline']) < strtotime('today') ? 'text-danger' : '' ?>"><?= nice_date($j['deadline']) ?></td>
                                    <td><?= badge($j['status']) ?></td>
                                    <td class="text-end text-nowrap">
                                        <a href="#" class="action-btn" data-bs-toggle="tooltip" title="View"><i class="bi bi-eye"></i></a>
                                        <a href="#" class="action-btn" data-bs-toggle="tooltip" title="Approve"><i class="bi bi-check2"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr class="no-filter"><td colspan="7"><div class="empty-state"><i class="bi bi-briefcase"></i>No jobs posted yet</div></td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-x-foot"><a href="#">View all jobs <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="col-xl-4 reveal">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Jobs by Category</h5><p>Where employers are hiring</p></div></div>
                    <div class="card-x-body">
                        <?php if ($jobsByCategory): foreach ($jobsByCategory as $c): ?>
                            <div class="progress-item">
                                <div class="lbl"><span><?= e($c['name']) ?></span><span><?= (int) $c['total'] ?> jobs</span></div>
                                <div class="progress"><div class="progress-bar" data-width="<?= round($c['total'] / $maxCat * 100) ?>"></div></div>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="empty-state"><i class="bi bi-tags"></i>No categories</div>
                        <?php endif; ?>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3" id="top-companies">Top Companies</h6>
                        <ul class="list-x" style="margin:0 -1.35rem">
                            <?php if ($topCompanies): foreach ($topCompanies as $c): ?>
                                <li>
                                    <?= logo_or_avatar($c['logo'], $c['name'], 'sm') ?>
                                    <div class="info"><div class="t"><?= e($c['name']) ?></div><div class="s"><i class="bi bi-geo-alt"></i> <?= e($c['city'] ?: 'N/A') ?></div></div>
                                    <span class="tag tag-accent"><?= (int) $c['jobs'] ?> jobs</span>
                                </li>
                            <?php endforeach; else: ?>
                                <li class="justify-content-center text-muted small">No companies yet</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Payments + Users -->
        <!-- <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-7 reveal" id="payments">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Recent Payments</h5><p>Pending payments are shown first for verification</p></div>
                        <div class="table-search">
                            <i class="bi bi-search"></i>
                            <input type="search" placeholder="Invoice / TrxID…" data-table-filter="#payTable">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern" id="payTable">
                            <thead><tr><th>Invoice</th><th>Employer</th><th>Package</th><th>Method</th><th>Amount</th><th>Status</th></tr></thead>
                            <tbody>
                            <?php if ($recentPayments): foreach ($recentPayments as $p): ?>
                                <tr>
                                    <td class="text-nowrap"><div class="fw-bold">#<?= e($p['transaction_no']) ?></div><small class="text-muted"><?= $p['tx_id'] ? 'TrxID: ' . e($p['tx_id']) : 'No TrxID' ?></small></td>
                                    <td><div class="fw-semibold"><?= e($p['name']) ?></div><small class="text-muted"><?= e($p['email']) ?></small></td>
                                    <td><span class="tag tag-accent"><?= e($p['package']) ?></span></td>
                                    <td class="text-nowrap"><?= e($p['method']) ?></td>
                                    <td class="fw-bold text-nowrap"><?= taka($p['total_amount']) ?></td>
                                    <td><?= badge($p['status']) ?></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr class="no-filter"><td colspan="6"><div class="empty-state"><i class="bi bi-credit-card"></i>No payments yet</div></td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-x-foot"><a href="#">View all transactions <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="col-xl-5 reveal" id="recent-users">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>New Users</h5><p>Recently registered accounts</p></div>
                        <span class="tag tag-accent"><?= $newUsersMonth ?> this month</span>
                    </div>
                    <ul class="list-x">
                        <?php if ($recentUsers): foreach ($recentUsers as $u): ?>
                            <li>
                                <span class="avatar round avatar-<?= avatar_color($u['name']) ?>"><?= e(initials($u['name'])) ?></span>
                                <div class="info">
                                    <div class="t"><?= e($u['name']) ?></div>
                                    <div class="s"><?= e($u['email']) ?> · <?= time_ago($u['created_at']) ?></div>
                                </div>
                                <div class="text-end d-flex flex-column gap-1 align-items-end">
                                    <?= badge($u['role']) ?>
                                    <?php if ($u['status'] !== 'active'): ?><?= badge($u['status']) ?><?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; else: ?>
                            <li class="justify-content-center text-muted">No users yet</li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-x-foot"><a href="#">Manage users <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>
        </div> -->

        <!-- Quick add form + Packages -->
        <!-- <div class="row g-3 g-xl-4 mb-2">
            <div class="col-xl-5 reveal" id="quick-add">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Quick Add</h5><p>Add master data in seconds</p></div>
                        <ul class="nav nav-pills-x" role="tablist">
                            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tabCategory" type="button">Category</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tabCity" type="button">City</button></li>
                            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tabSkill" type="button">Skill</button></li>
                        </ul>
                    </div>
                    <div class="card-x-body tab-content"> -->
                        <!-- Category -->
                        <!-- <form class="tab-pane fade show active" id="tabCategory" data-demo="Category form ready (design preview)" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <div class="input-icon"><i class="bi bi-tag"></i><input type="text" name="name" class="form-control" placeholder="e.g. Marketing" required></div>
                                <div class="invalid-feedback">Please enter a category name.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <div class="input-icon"><i class="bi bi-link-45deg"></i><input type="text" name="slug" class="form-control" placeholder="e.g. marketing" required></div>
                                <div class="invalid-feedback">Slug is required.</div>
                            </div>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                <small class="text-muted me-1">Existing:</small>
                                <?php foreach ($categories as $c): ?><span class="tag"><?= e($c['name']) ?></span><?php endforeach; ?>
                            </div>
                            <button class="btn btn-accent w-100"><i class="bi bi-plus-lg me-1"></i> Add Category</button>
                        </form> -->
                        <!-- City -->
                        <!-- <form class="tab-pane fade" id="tabCity" data-demo="City form ready (design preview)" novalidate>
                            <div class="mb-3">
                                <label class="form-label">City Name</label>
                                <div class="input-icon"><i class="bi bi-geo-alt"></i><input type="text" name="name" class="form-control" placeholder="e.g. Khulna" required></div>
                                <div class="invalid-feedback">Please enter a city name.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Division</label>
                                <div class="input-icon"><i class="bi bi-map"></i>
                                    <select name="division" class="form-select" required>
                                        <option value="">Select division</option>
                                        <?php foreach (['Dhaka','Chattogram','Rajshahi','Khulna','Barishal','Sylhet','Rangpur','Mymensingh'] as $d): ?>
                                            <option><?= $d ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="invalid-feedback">Select a division.</div>
                            </div>
                            <button class="btn btn-accent w-100"><i class="bi bi-plus-lg me-1"></i> Add City</button>
                        </form> -->
                        <!-- Skill -->
                        <!-- <form class="tab-pane fade" id="tabSkill" data-demo="Skill form ready (design preview)" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Skill Name</label>
                                <div class="input-icon"><i class="bi bi-lightning-charge"></i><input type="text" name="name" class="form-control" placeholder="e.g. React" required></div>
                                <div class="invalid-feedback">Please enter a skill.</div>
                            </div>
                            <button class="btn btn-accent w-100"><i class="bi bi-plus-lg me-1"></i> Add Skill</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 reveal" id="packages">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>Subscription Packages</h5><p>Plans available to employers</p></div>
                        <a href="#" class="btn btn-light-accent btn-sm"><i class="bi bi-pencil-square me-1"></i> Manage</a>
                    </div>
                    <div class="card-x-body">
                        <div class="row g-3">
                            <?php if ($packages): foreach ($packages as $i => $pk): ?>
                                <div class="col-md-4">
                                    <div class="pkg <?= $i === 1 ? 'popular' : '' ?>">
                                        <?php if ($i === 1): ?><span class="ribbon">Popular</span><?php endif; ?>
                                        <div class="pkg-name"><?= e($pk['name']) ?></div>
                                        <div class="pkg-price"><?= (float) $pk['price'] > 0 ? taka($pk['price']) : 'Free' ?> <small>/ <?= (int) $pk['duration_days'] ?> days</small></div>
                                        <span class="tag tag-accent"><i class="bi bi-people me-1"></i><?= (int) $pk['active_subs'] ?> active</span>
                                        <ul>
                                            <li><i class="bi bi-check-circle-fill"></i><?= (int) $pk['job_post_limit'] ?> job post(s)</li>
                                            <li><i class="bi bi-check-circle-fill"></i><?= (int) $pk['duration_days'] ?> days validity</li>
                                            <?php if ($pk['description']): ?><li><i class="bi bi-check-circle-fill"></i><?= e($pk['description']) ?></li><?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; else: ?>
                                <div class="col-12"><div class="empty-state"><i class="bi bi-box-seam"></i>No packages</div></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </main>

    <footer class="footer">
        <span>© <span id="year"><?= date('Y') ?></span> Jobs Portal. All rights reserved.</span>
        <span>Admin Panel · v1.0</span>
    </footer>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="appToast" class="toast toast-x" role="status" aria-live="polite">
        <div class="toast-body"><i class="bi bi-check-circle-fill"></i><span class="toast-msg">Saved</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../script.js"></script>
</body>
</html>
