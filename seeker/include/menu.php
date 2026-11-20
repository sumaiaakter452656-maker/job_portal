<?php
// Seeker's left menu and top bar. Every seeker page includes this.
$page = basename($_SERVER['PHP_SELF']);

// Number of saved jobs (to show in the menu)
$savedCount = $conn->query("SELECT COUNT(*) AS c FROM saved_jobs WHERE seeker_id = $seekerId")->fetch_assoc()['c'];
?>
<aside class="sidebar">
  <a href="../index.php" class="logo"><span class="logo-mark">J</span>JobHub<span class="dot">.</span></a>
  <div class="sidebar-label">Job Seeker menu</div>
  <ul class="sidebar-menu">
    <li><a href="dashboard.php" class="<?php if ($page == 'dashboard.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a></li>
    <li><a href="applied-jobs.php" class="<?php if ($page == 'applied-jobs.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Applied Jobs</a></li>
    <li><a href="saved-jobs.php" class="<?php if ($page == 'saved-jobs.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>Saved Jobs<?php if ($savedCount > 0) { ?><span class="count"><?php echo $savedCount; ?></span><?php } ?></a></li>
    <li><a href="profile.php" class="<?php if ($page == 'profile.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>My Profile</a></li>
    <li><a href="cv.php" class="<?php if ($page == 'cv.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>CV Builder</a></li>
    <li><a href="../jobs.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Find Jobs</a></li>
    <li><a href="../index.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>View Website</a></li>
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
        <span class="avatar sm"><?php echo $initials; ?></span>
        <span class="user-meta"><strong><?php echo $me['name']; ?></strong><small>Job Seeker</small></span>
      </button>
      <div class="dropdown-menu">
        <a href="profile.php">My Profile</a>
        <hr>
        <a href="../logout.php">Logout</a>
      </div>
    </div>
  </header>
