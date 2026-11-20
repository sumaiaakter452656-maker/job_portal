<?php
// Employer-এর বাঁ দিকের menu আর উপরের bar
$page = basename($_SERVER['PHP_SELF']);
$newApps = $conn->query("SELECT COUNT(*) AS c FROM job_applications
                          JOIN jobs ON jobs.id = job_applications.job_id
                          WHERE jobs.company_id = $companyId AND job_applications.status = 'applied'")->fetch_assoc()['c'];
?>
<aside class="sidebar">
  <a href="../index.php" class="logo"><span class="logo-mark">J</span>JobHub<span class="dot">.</span></a>
  <div class="sidebar-label">Employer menu</div>
  <ul class="sidebar-menu">
    <li><a href="dashboard.php" class="<?php if ($page == 'dashboard.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a></li>
    <li><a href="post-job.php" class="<?php if ($page == 'post-job.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Post a Job</a></li>
    <li><a href="manage-jobs.php" class="<?php if ($page == 'manage-jobs.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>Manage Jobs</a></li>
    <li><a href="applicants.php" class="<?php if ($page == 'applicants.php' || $page == 'email.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Applicants<?php if ($newApps > 0) { ?><span class="count"><?php echo $newApps; ?></span><?php } ?></a></li>
    <li><a href="company-profile.php" class="<?php if ($page == 'company-profile.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg>Company Profile</a></li>
    <li><a href="../index.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg>View Website</a></li>
  </ul>
  <div class="sidebar-foot">
    <ul class="sidebar-menu">
      <li><a href="../logout.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Logout</a></li>
    </ul>
  </div>
</aside>
<div class="sidebar-backdrop"></div>

<div class="dash-main">
  <header class="topbar">
    <button class="icon-btn sidebar-toggle" data-sidebar-toggle aria-label="Menu"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
    <h1 class="topbar-title"><?php echo $pageTitle; ?></h1>
    <div class="dropdown" style="margin-left:auto">
      <button class="dropdown-toggle">
        <span class="avatar sm"><?php echo strtoupper(substr($company['name'], 0, 2)); ?></span>
        <span class="user-meta"><strong><?php echo $_SESSION['name']; ?></strong><small><?php echo $company['name']; ?></small></span>
      </button>
      <div class="dropdown-menu">
        <a href="company-profile.php">Company Profile</a>
        <hr>
        <a href="../logout.php">Logout</a>
      </div>
    </div>
  </header>
