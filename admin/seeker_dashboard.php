<?php

require_once __DIR__ . '/../dashboard_config.php';

$userId = require_role('seeker');
$me = row("SELECT id, name, email, phone, created_at FROM users WHERE id = ?", [$userId])
    ?? ['name' => 'Job Seeker', 'email' => '', 'phone' => null, 'created_at' => null];

/* ---------------- Seeker profile ---------------- */
$seeker = row("SELECT s.*, ci.name AS city, cat.name AS category, t.name AS template
               FROM seekers s
               LEFT JOIN cities ci       ON ci.id = s.city_id
               LEFT JOIN categories cat  ON cat.id = s.category_id
               LEFT JOIN cv_templates t  ON t.id = s.cv_template_id
               WHERE s.user_id = ?", [$userId]) ?? [];
$seekerId = (int) ($seeker['id'] ?? 0);

/* ---------------- Statistics ---------------- */
$totalApps   = (int) scalar("SELECT COUNT(*) FROM job_applications WHERE seeker_id = ?", [$seekerId]);
$viewedApps  = (int) scalar("SELECT COUNT(*) FROM job_applications WHERE seeker_id = ? AND status <> 'applied'", [$seekerId]);
$shortlisted = (int) scalar("SELECT COUNT(*) FROM job_applications WHERE seeker_id = ? AND status IN ('shortlisted','interview','hired')", [$seekerId]);
$savedCount  = (int) scalar("SELECT COUNT(*) FROM saved_jobs WHERE seeker_id = ?", [$seekerId]);
$openJobs    = (int) scalar("SELECT COUNT(*) FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()");

/* Application pipeline */
$pipeMeta = [
    'applied'     => ['bi-send', 'orange'],
    'viewed'      => ['bi-eye', 'cyan'],
    'shortlisted' => ['bi-list-check', 'blue'],
    'interview'   => ['bi-camera-video', 'purple'],
    'hired'       => ['bi-trophy', 'green'],
    'rejected'    => ['bi-x-circle', 'red'],
];
$pipeCounts = array_column(
    rows("SELECT status, COUNT(*) c FROM job_applications WHERE seeker_id = ? GROUP BY status", [$seekerId]),
    'c', 'status'
);

/* Chart */
$months   = last_months(6);
$appsData = rows("SELECT DATE_FORMAT(applied_at, '%Y-%m') ym, COUNT(*) c
                  FROM job_applications
                  WHERE seeker_id = ? AND applied_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 5 MONTH)
                  GROUP BY ym", [$seekerId]);
$chartSeries = [['name' => 'My Applications', 'color' => '#0ea5e9', 'values' => fill_months($months, $appsData)]];

/* ---------------- CV data ---------------- */
$skills      = rows("SELECT sk.name FROM seeker_skills ss JOIN skills sk ON sk.id = ss.skill_id WHERE ss.seeker_id = ? ORDER BY sk.name", [$seekerId]);
$educations  = rows("SELECT level, degree_title, institution, result, year FROM seeker_educations WHERE seeker_id = ? ORDER BY year DESC LIMIT 3", [$seekerId]);
$experiences = rows("SELECT company_name, designation, start_date, end_date, is_current FROM seeker_experiences WHERE seeker_id = ? ORDER BY is_current DESC, start_date DESC LIMIT 3", [$seekerId]);
$cvItemCount = (int) scalar("SELECT COUNT(*) FROM seeker_cv_items WHERE seeker_id = ?", [$seekerId]);
$templates   = rows("SELECT id, name, is_premium FROM cv_templates WHERE status = 'active' ORDER BY is_premium, name");

/* Profile completeness checklist */
$checks = [
    'Basic info & phone'      => !empty($me['phone']),
    'Professional headline'   => !empty($seeker['headline']),
    'Career summary'          => !empty($seeker['summary']),
    'Preferred category/city' => !empty($seeker['category_id']) && !empty($seeker['city_id']),
    'Education added'         => count($educations) > 0,
    'Experience added'        => count($experiences) > 0,
    'Skills added'            => count($skills) > 0,
    'Resume / CV uploaded'    => !empty($seeker['resume_file']),
];
$completeness = (int) round(count(array_filter($checks)) / count($checks) * 100);

/* ---------------- Lists ---------------- */
$recentApps = rows("SELECT a.id, a.status AS app_status, a.applied_at,
                           j.title, j.job_type, j.deadline,
                           c.name AS company, c.logo, ci.name AS city
                    FROM job_applications a
                    JOIN jobs j       ON j.id = a.job_id
                    JOIN companies c  ON c.id = j.company_id
                    LEFT JOIN cities ci ON ci.id = j.city_id
                    WHERE a.seeker_id = ?
                    ORDER BY a.applied_at DESC
                    LIMIT 6", [$seekerId]);

$recommended = rows("SELECT j.id, j.title, j.job_type, j.salary_min, j.salary_max, j.deadline, j.is_featured,
                            c.name AS company, c.logo, ci.name AS city, cat.name AS category,
                            (SELECT COUNT(*) FROM saved_jobs sv WHERE sv.job_id = j.id AND sv.seeker_id = ?) AS is_saved
                     FROM jobs j
                     JOIN companies c         ON c.id = j.company_id
                     LEFT JOIN cities ci      ON ci.id = j.city_id
                     LEFT JOIN categories cat ON cat.id = j.category_id
                     WHERE j.status = 'approved'
                       AND j.deadline >= CURDATE()
                       AND j.id NOT IN (SELECT job_id FROM job_applications WHERE seeker_id = ?)
                     ORDER BY (j.category_id <=> ?) DESC, j.is_featured DESC, j.id DESC
                     LIMIT 6", [$seekerId, $seekerId, $seeker['category_id'] ?? null]);

$savedJobs = rows("SELECT j.title, j.deadline, c.name AS company, c.logo, ci.name AS city
                   FROM saved_jobs sv
                   JOIN jobs j       ON j.id = sv.job_id
                   JOIN companies c  ON c.id = j.company_id
                   LEFT JOIN cities ci ON ci.id = j.city_id
                   WHERE sv.seeker_id = ?
                   ORDER BY sv.id DESC
                   LIMIT 5", [$seekerId]);

$categories = rows("SELECT id, name FROM categories ORDER BY name");
$cities     = rows("SELECT id, name FROM cities ORDER BY name");

/* Notifications */
$notifs      = rows("SELECT message, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5", [$userId]);
$unreadCount = (int) scalar("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0", [$userId]);

$firstName = explode(' ', $me['name'])[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Dashboard · Jobs Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="theme-seeker">

<!-- ================= SIDEBAR ================= -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-briefcase-fill"></i></div>
        <div class="brand-text">Jobs<span>Portal</span><small class="brand-role">Job Seeker</small></div>
        <button class="btn btn-sm text-white ms-auto d-lg-none" id="sidebarClose" aria-label="Close menu"><i class="bi bi-x-lg"></i></button>
    </div>

    <nav class="sidebar-menu">
        <div class="nav-section">Main</div>
        <a href="seeker_dashboard.php" class="side-link active"><i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span></a>
        <a href="#" class="side-link"><i class="bi bi-search"></i><span>Find Jobs</span></a>
        <a href="#recommended" class="side-link"><i class="bi bi-stars"></i><span>Recommended</span></a>

        <div class="nav-section">My Jobs</div>
        <a href="#applications" class="side-link"><i class="bi bi-send-check"></i><span>Applied Jobs</span>
            <?php if ($totalApps): ?><em class="side-badge"><?= $totalApps ?></em><?php endif; ?></a>
        <a href="#saved" class="side-link"><i class="bi bi-bookmark-heart"></i><span>Saved Jobs</span></a>
        <a href="#pipeline" class="side-link"><i class="bi bi-kanban"></i><span>Application Status</span></a>

        <div class="nav-section">My CV</div>
        <a href="#profile" class="side-link"><i class="bi bi-person-vcard"></i><span>My Profile</span></a>
        <a href="#cv" class="side-link"><i class="bi bi-file-earmark-richtext"></i><span>CV Builder</span></a>
        <a href="#cv" class="side-link"><i class="bi bi-mortarboard"></i><span>Education</span></a>
        <a href="#cv" class="side-link"><i class="bi bi-building"></i><span>Experience</span></a>
        <a href="#profile" class="side-link"><i class="bi bi-lightning-charge"></i><span>Skills</span></a>
        <a href="#" class="side-link"><i class="bi bi-award"></i><span>Projects &amp; Certificates</span></a>

        <div class="nav-section">Account</div>
        <a href="#" class="side-link"><i class="bi bi-bell"></i><span>Notifications</span>
            <?php if ($unreadCount): ?><em class="side-badge"><?= $unreadCount ?></em><?php endif; ?></a>
        <a href="#update-profile" class="side-link"><i class="bi bi-gear"></i><span>Settings</span></a>
        <a href="logout.php" class="side-link"><i class="bi bi-box-arrow-left"></i><span>Logout</span></a>
    </nav>

    <div class="sidebar-footer">
        <div class="upgrade-box">
            <h6><i class="bi bi-rocket-takeoff me-1"></i> Profile <?= $completeness ?>% done</h6>
            <p>A complete profile gets noticed by employers more often.</p>
            <a href="#profile" class="btn btn-light btn-sm w-100">Complete Profile</a>
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
            <input type="search" id="globalSearch" placeholder="Search your applications… (press Enter)">
        </div>

        <div class="topbar-right">
            <a href="#" class="btn btn-accent btn-sm d-none d-md-inline-flex align-items-center gap-1"><i class="bi bi-search"></i> Browse Jobs</a>

            <a href="#saved" class="icon-btn d-none d-sm-inline-grid" aria-label="Saved jobs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Saved Jobs">
                <i class="bi bi-bookmark"></i><?php if ($savedCount): ?><span class="dot"><?= $savedCount ?></span><?php endif; ?>
            </a>

            <div class="dropdown">
                <button class="icon-btn" data-bs-toggle="dropdown" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                    <?php if ($unreadCount): ?><span class="dot"><?= $unreadCount ?></span><?php endif; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-end notif-menu">
                    <div class="notif-head"><strong>Notifications</strong><span class="tag tag-accent"><?= $unreadCount ?> new</span></div>
                    <?php if ($notifs): foreach ($notifs as $n): ?>
                        <a href="#" class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>">
                            <span class="ico"><i class="bi bi-briefcase"></i></span>
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
                        <span class="role"><?= e($seeker['headline'] ?? 'Job Seeker') ?></span>
                    </span>
                    <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2"><strong class="d-block"><?= e($me['name']) ?></strong><small class="text-muted"><?= e($me['email']) ?></small></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#profile"><i class="bi bi-person"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="#cv"><i class="bi bi-file-earmark-pdf"></i> My CV</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-key"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right text-danger"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="content">

        <!-- Hero -->
        <div class="hero-card mb-4 reveal">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="tag mb-2" style="background:rgba(255,255,255,.18);color:#fff;border:0"><span data-greeting>Hello</span> 👋</span>
                    <h2>Welcome back, <?= e($firstName) ?>!</h2>
                    <p>There are <strong><?= $openJobs ?></strong> open jobs on the portal right now. You've applied to <strong><?= $totalApps ?></strong> job(s) and <strong><?= $shortlisted ?></strong> of them moved forward.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#recommended" class="btn btn-hero"><i class="bi bi-stars me-1"></i> Recommended Jobs</a>
                        <a href="#cv" class="btn btn-hero-outline"><i class="bi bi-file-earmark-arrow-down me-1"></i> My CV</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 justify-content-lg-end">
                        <div class="ring" data-progress="<?= $completeness ?>"><span>0%</span></div>
                        <div>
                            <div class="fw-bold">Profile Strength</div>
                            <small style="opacity:.85"><?= count(array_filter($checks)) ?> of <?= count($checks) ?> steps done</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-blue">
                    <div class="stat-top">
                        <div><div class="stat-label">Applied Jobs</div><div class="stat-value" data-count="<?= $totalApps ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-send-fill"></i></div>
                    </div>
                    <div class="stat-foot">Total applications sent</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-cyan">
                    <div class="stat-top">
                        <div><div class="stat-label">Viewed by Employers</div><div class="stat-value" data-count="<?= $viewedApps ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-eye-fill"></i></div>
                    </div>
                    <div class="stat-foot"><span class="trend-up"><?= $totalApps ? round($viewedApps / $totalApps * 100) : 0 ?>%</span> view rate</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-green">
                    <div class="stat-top">
                        <div><div class="stat-label">Shortlisted</div><div class="stat-value" data-count="<?= $shortlisted ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-patch-check-fill"></i></div>
                    </div>
                    <div class="stat-foot">Shortlisted, interview or hired</div>
                </div>
            </div>
            <div class="col-6 col-xl-3 reveal">
                <div class="stat-card tone-orange">
                    <div class="stat-top">
                        <div><div class="stat-label">Saved Jobs</div><div class="stat-value" data-count="<?= $savedCount ?>">0</div></div>
                        <div class="stat-icon"><i class="bi bi-bookmark-heart-fill"></i></div>
                    </div>
                    <div class="stat-foot">Bookmarked for later</div>
                </div>
            </div>
        </div>

        <!-- Pipeline + chart -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-7 reveal" id="pipeline">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Application Status</h5><p>Where your applications currently stand</p></div></div>
                    <div class="card-x-body">
                        <div class="pipeline">
                            <?php foreach ($pipeMeta as $st => [$icon, $tone]): ?>
                                <div class="pipe-step tone-<?= $tone ?>">
                                    <i class="bi <?= $icon ?>"></i>
                                    <strong data-count="<?= (int) ($pipeCounts[$st] ?? 0) ?>">0</strong>
                                    <small><?= label($st) ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="bar-chart mt-4"
                             data-labels='<?= e(json_encode(array_values($months))) ?>'
                             data-series='<?= e(json_encode($chartSeries)) ?>'></div>
                    </div>
                </div>
            </div>

            <!-- Profile card -->
            <div class="col-xl-5 reveal" id="profile">
                <div class="card-x profile-card">
                    <div class="profile-cover"></div>
                    <div class="px-4 pb-1">
                        <span class="avatar xl avatar-accent"><?= e(initials($me['name'])) ?></span>
                        <h5 class="fw-bold mt-2 mb-0"><?= e($me['name']) ?></h5>
                        <div class="text-muted small"><?= e($seeker['headline'] ?? 'Add a professional headline') ?></div>
                        <div class="d-flex justify-content-center flex-wrap gap-2 mt-2 small text-muted">
                            <span><i class="bi bi-geo-alt"></i> <?= e($seeker['city'] ?? 'City not set') ?></span>
                            <span><i class="bi bi-tag"></i> <?= e($seeker['category'] ?? 'Category not set') ?></span>
                        </div>
                        <div class="d-flex justify-content-center flex-wrap gap-1 mt-3">
                            <?php if ($skills): foreach ($skills as $s): ?>
                                <span class="tag tag-accent"><?= e($s['name']) ?></span>
                            <?php endforeach; else: ?>
                                <span class="tag">No skills added yet</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="profile-stats">
                        <div><strong><?= (int) ($seeker['experience_years'] ?? 0) ?>+</strong><small>Years Exp.</small></div>
                        <div><strong><?= !empty($seeker['expected_salary']) ? taka($seeker['expected_salary']) : '—' ?></strong><small>Expected</small></div>
                        <div><strong><?= $cvItemCount ?></strong><small>Projects/Certs</small></div>
                    </div>
                    <div class="text-start px-4 pb-4 pt-2 border-top">
                        <div class="d-flex justify-content-between align-items-center mt-2 mb-1">
                            <strong class="small">Profile checklist</strong><span class="small text-muted"><?= $completeness ?>%</span>
                        </div>
                        <ul class="check-list row row-cols-1 row-cols-sm-2 g-0">
                            <?php foreach ($checks as $lbl => $done): ?>
                                <li class="col <?= $done ? 'done' : 'todo' ?>"><i class="bi <?= $done ? 'bi-check-circle-fill' : 'bi-circle' ?>"></i><?= e($lbl) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent applications -->
        <div class="row g-3 g-xl-4 mb-4">
            <div class="col-xl-8 reveal" id="applications">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>My Applications</h5><p>Track every job you've applied to</p></div>
                        <div class="table-tools">
                            <select class="form-select form-select-sm" style="width:auto" data-status-filter="#appsTable">
                                <option value="">All Status</option>
                                <?php foreach (array_keys($pipeMeta) as $st): ?><option value="<?= $st ?>"><?= label($st) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern" id="appsTable">
                            <thead><tr><th>Job</th><th>Type</th><th>Applied</th><th>Status</th><th class="text-end">Action</th></tr></thead>
                            <tbody>
                            <?php if ($recentApps): foreach ($recentApps as $a): ?>
                                <tr data-status="<?= e($a['app_status']) ?>">
                                    <td>
                                        <div class="cell-main">
                                            <?= logo_or_avatar($a['logo'], $a['company']) ?>
                                            <div><div class="t"><?= e($a['title']) ?></div><div class="s"><?= e($a['company']) ?> · <i class="bi bi-geo-alt"></i> <?= e($a['city'] ?: 'N/A') ?></div></div>
                                        </div>
                                    </td>
                                    <td><span class="tag"><?= e(label($a['job_type'])) ?></span></td>
                                    <td class="text-nowrap"><?= nice_date($a['applied_at']) ?><br><small class="text-muted"><?= time_ago($a['applied_at']) ?></small></td>
                                    <td><?= badge($a['app_status']) ?></td>
                                    <td class="text-end"><a href="#" class="action-btn" data-bs-toggle="tooltip" title="View Job"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr class="no-filter"><td colspan="5"><div class="empty-state"><i class="bi bi-send"></i>You haven't applied to any job yet.<br><a href="#recommended" class="fw-semibold">Explore recommended jobs</a></div></td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-x-foot"><a href="#">View all applications <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="col-xl-4 reveal" id="saved">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Saved Jobs</h5><p>Don't miss the deadlines</p></div><span class="tag tag-accent"><?= $savedCount ?></span></div>
                    <ul class="list-x">
                        <?php if ($savedJobs): foreach ($savedJobs as $s):
                            $daysLeft = (int) floor((strtotime($s['deadline']) - strtotime('today')) / 86400); ?>
                            <li>
                                <?= logo_or_avatar($s['logo'], $s['company'], 'sm') ?>
                                <div class="info"><div class="t"><?= e($s['title']) ?></div><div class="s"><?= e($s['company']) ?> · <?= e($s['city'] ?: 'N/A') ?></div></div>
                                <?php if ($daysLeft < 0): ?>
                                    <span class="badge-soft badge-soft-secondary">Expired</span>
                                <?php else: ?>
                                    <span class="badge-soft <?= $daysLeft <= 3 ? 'badge-soft-danger' : 'badge-soft-info' ?>"><?= $daysLeft ?>d left</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; else: ?>
                            <li class="d-block"><div class="empty-state"><i class="bi bi-bookmark"></i>No saved jobs yet</div></li>
                        <?php endif; ?>
                    </ul>
                    <div class="card-x-foot"><a href="#">All saved jobs <i class="bi bi-arrow-right"></i></a></div>
                </div>
            </div>
        </div>

        <!-- Recommended jobs -->
        <div class="card-x mb-4 reveal" id="recommended" style="height:auto">
            <div class="card-x-head">
                <div><h5>Recommended for You</h5><p>Open jobs<?= !empty($seeker['category']) ? ' in <strong>' . e($seeker['category']) . '</strong>' : '' ?> you haven't applied to yet</p></div>
                <a href="#" class="btn btn-light-accent btn-sm">Browse all <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="card-x-body">
                <div class="row g-3">
                    <?php if ($recommended): foreach ($recommended as $j): ?>
                        <div class="col-md-6 col-xxl-4">
                            <div class="job-card">
                                <div class="d-flex gap-3 align-items-start">
                                    <?= logo_or_avatar($j['logo'], $j['company'], 'lg') ?>
                                    <div class="flex-grow-1 min-w-0">
                                        <h6 class="jt"><?= e($j['title']) ?></h6>
                                        <div class="jc"><?= e($j['company']) ?></div>
                                    </div>
                                    <button type="button" class="bookmark <?= !empty($j['is_saved']) ? 'on' : '' ?>" aria-label="Save job">
                                        <i class="bi <?= !empty($j['is_saved']) ? 'bi-bookmark-fill' : 'bi-bookmark' ?>"></i>
                                    </button>
                                </div>
                                <div class="meta">
                                    <span class="tag tag-accent"><?= e(label($j['job_type'])) ?></span>
                                    <span class="tag"><i class="bi bi-geo-alt"></i> <?= e($j['city'] ?: 'N/A') ?></span>
                                    <?php if ($j['category']): ?><span class="tag"><?= e($j['category']) ?></span><?php endif; ?>
                                    <?php if ($j['is_featured']): ?><span class="tag tag-featured"><i class="bi bi-star-fill"></i> Featured</span><?php endif; ?>
                                </div>
                                <div class="foot">
                                    <div><div class="sal"><?= salary_range($j['salary_min'], $j['salary_max']) ?></div><small class="text-muted"><i class="bi bi-clock"></i> Deadline <?= nice_date($j['deadline']) ?></small></div>
                                    <a href="#" class="btn btn-accent btn-sm">Apply</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="col-12"><div class="empty-state"><i class="bi bi-stars"></i>No recommendations right now. Check back soon!</div></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- CV + Update profile form -->
        <div class="row g-3 g-xl-4 mb-2">
            <div class="col-xl-5 reveal" id="cv">
                <div class="card-x">
                    <div class="card-x-head">
                        <div><h5>My CV</h5><p>Template: <strong><?= e($seeker['template'] ?? 'Not selected') ?></strong></p></div>
                        <a href="#" class="btn btn-light-accent btn-sm"><i class="bi bi-pencil me-1"></i> Edit CV</a>
                    </div>
                    <div class="card-x-body">
                        <h6 class="fw-bold small text-uppercase text-muted mb-3"><i class="bi bi-building me-1"></i> Experience</h6>
                        <?php if ($experiences): ?>
                            <ul class="timeline mb-4">
                                <?php foreach ($experiences as $x): ?>
                                    <li>
                                        <span class="tl-dot tone-blue"><i class="bi bi-briefcase"></i></span>
                                        <p class="fw-bold"><?= e($x['designation']) ?></p>
                                        <small><?= e($x['company_name']) ?> · <?= date('M Y', strtotime($x['start_date'])) ?> – <?= $x['is_current'] ? 'Present' : ($x['end_date'] ? date('M Y', strtotime($x['end_date'])) : '—') ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted small mb-4">No experience added. <a href="#">Add experience</a></p>
                        <?php endif; ?>

                        <h6 class="fw-bold small text-uppercase text-muted mb-3"><i class="bi bi-mortarboard me-1"></i> Education</h6>
                        <?php if ($educations): ?>
                            <ul class="timeline mb-4">
                                <?php foreach ($educations as $ed): ?>
                                    <li>
                                        <span class="tl-dot tone-purple"><i class="bi bi-mortarboard"></i></span>
                                        <p class="fw-bold"><?= e($ed['degree_title']) ?> <span class="tag ms-1"><?= e($ed['level']) ?></span></p>
                                        <small><?= e($ed['institution']) ?><?= $ed['year'] ? ' · ' . e($ed['year']) : '' ?><?= $ed['result'] ? ' · ' . e($ed['result']) : '' ?></small>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted small mb-4">No education added. <a href="#">Add education</a></p>
                        <?php endif; ?>

                        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:var(--accent-soft)">
                            <i class="bi bi-file-earmark-pdf-fill fs-2" style="color:var(--accent)"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold small"><?= !empty($seeker['resume_file']) ? e(basename($seeker['resume_file'])) : 'No resume uploaded' ?></div>
                                <small class="text-muted">Available templates: <?= e(implode(', ', array_column($templates, 'name')) ?: '—') ?></small>
                            </div>
                            <?php if (!empty($seeker['resume_file'])): ?>
                                <a href="<?= e($seeker['resume_file']) ?>" class="action-btn" target="_blank" title="Download"><i class="bi bi-download"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 reveal" id="update-profile">
                <div class="card-x">
                    <div class="card-x-head"><div><h5>Career Preferences</h5><p>Keep these updated to get better recommendations</p></div></div>
                    <div class="card-x-body">
                        <form data-demo="Preferences form ready (design preview)" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <div class="input-icon"><i class="bi bi-person"></i><input type="text" class="form-control" value="<?= e($me['name']) ?>" required></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <div class="input-icon"><i class="bi bi-telephone"></i><input type="tel" class="form-control" value="<?= e($me['phone']) ?>" placeholder="01XXXXXXXXX"></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Professional Headline</label>
                                    <div class="input-icon"><i class="bi bi-type"></i><input type="text" class="form-control" value="<?= e($seeker['headline'] ?? '') ?>" placeholder="e.g. Junior PHP Developer" required></div>
                                    <div class="invalid-feedback">Headline is required.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Preferred Category</label>
                                    <div class="input-icon"><i class="bi bi-tag"></i>
                                        <select class="form-select">
                                            <option value="">Select category</option>
                                            <?php foreach ($categories as $c): ?>
                                                <option value="<?= (int) $c['id'] ?>" <?= ($seeker['category_id'] ?? null) == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Preferred City</label>
                                    <div class="input-icon"><i class="bi bi-geo-alt"></i>
                                        <select class="form-select">
                                            <option value="">Select city</option>
                                            <?php foreach ($cities as $c): ?>
                                                <option value="<?= (int) $c['id'] ?>" <?= ($seeker['city_id'] ?? null) == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Experience (years)</label>
                                    <div class="input-icon"><i class="bi bi-bar-chart-steps"></i><input type="number" min="0" max="50" class="form-control" value="<?= (int) ($seeker['experience_years'] ?? 0) ?>"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Expected Salary (৳)</label>
                                    <div class="input-icon"><i class="bi bi-cash"></i><input type="number" min="0" class="form-control" value="<?= e($seeker['expected_salary'] ?? '') ?>" placeholder="e.g. 35000"></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Upload Resume (PDF)</label>
                                    <label class="upload-zone d-block">
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span class="upload-name fw-semibold">Click to choose your CV file</span>
                                        <small class="d-block">PDF only, max 2 MB</small>
                                        <input type="file" accept="application/pdf" hidden>
                                    </label>
                                </div>
                                <div class="col-12 d-flex gap-2 justify-content-end">
                                    <button type="reset" class="btn btn-white">Reset</button>
                                    <button type="submit" class="btn btn-accent"><i class="bi bi-check2 me-1"></i> Save Preferences</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <span>© <span id="year"><?= date('Y') ?></span> Jobs Portal. All rights reserved.</span>
        <span>Member since <?= $me['created_at'] ? date('M Y', strtotime($me['created_at'])) : '—' ?></span>
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
