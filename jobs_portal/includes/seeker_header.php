<!-- Seeker dashboard header: <head> + sidebar + topbar (paths for files inside seeker/) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | JobPortal BD</title>
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="dash-body">
<div class="dash-wrapper">

  <!-- ===================== SIDEBAR (Job Seeker) ===================== -->
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between">
        <a href="../index.html" class="sidebar-brand flex-grow-1"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal</a>
        <button type="button" class="btn-close btn-close-white d-lg-none me-3" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
      </div>

      <div class="sidebar-heading">Main</div>
      <ul class="sidebar-nav">
        <li><a href="../seeker/dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
        <li><a href="../jobs.php"><i class="bi bi-search"></i> Browse Jobs</a></li>
        <li><a href="../crud/job_applications/index.php"><i class="bi bi-send-check"></i> Applied Jobs</a></li>
        <li><a href="../crud/saved_jobs/index.php"><i class="bi bi-bookmark-heart"></i> Saved Jobs</a></li>
      </ul>

      <div class="sidebar-heading">My CV</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/seekers/edit.php"><i class="bi bi-person-vcard"></i> Basic Profile</a></li>
        <li><a href="../crud/seeker_educations/index.php"><i class="bi bi-mortarboard"></i> Education</a></li>
        <li><a href="../crud/seeker_experiences/index.php"><i class="bi bi-briefcase"></i> Experience</a></li>
        <li><a href="../crud/seeker_skills/index.php"><i class="bi bi-lightning-charge"></i> Skills</a></li>
        <li><a href="../crud/seeker_cv_items/index.php"><i class="bi bi-award"></i> Projects &amp; Certificates</a></li>
        <li><a href="../seeker/cv-preview.php"><i class="bi bi-file-earmark-pdf"></i> CV Preview</a></li>
      </ul>

      <div class="sidebar-heading">Account</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/notifications/index.php"><i class="bi bi-bell"></i> Notifications <span class="badge bg-danger">1</span></a></li>
        <li><a href="../crud/users/edit.php"><i class="bi bi-gear"></i> Account Settings</a></li>
        <li><a href="../login.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>

      <div class="sidebar-footer">
        <div class="sidebar-upgrade">
          <div class="small text-white-50">Profile strength</div>
          <div class="fw-bold mb-2">85% complete</div>
          <div class="progress mb-3" style="height:6px"><div class="progress-bar bg-accent" style="width:85%"></div></div>
          <a href="../crud/seekers/edit.php" class="btn btn-accent btn-sm w-100">Complete Profile</a>
        </div>
      </div>
    </div>
  </aside>

  <!-- ===================== MAIN ===================== -->
  <div class="dash-main">

    <!-- Topbar -->
    <header class="topbar">
      <button class="topbar-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
      <form class="search position-relative d-none d-md-block" action="#" method="get">
        <i class="bi bi-search"></i>
        <input type="search" class="form-control" placeholder="Search anything...">
      </form>
      <div class="ms-auto d-flex align-items-center gap-2">
        <a href="../index.html" class="topbar-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Website"><i class="bi bi-globe2"></i></a>

        <!-- Notifications (table: notifications) -->
        <div class="dropdown">
          <button class="topbar-btn" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="bi bi-bell"></i><span class="dot"></span></button>
          <div class="dropdown-menu dropdown-menu-end notif-dropdown">
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
              <strong>Notifications</strong>
              <a href="#" class="small">Mark all as read</a>
            </div>
            <a href="#" class="dropdown-item notif-item unread">
              <span class="ic bg-success-subtle text-success"><i class="bi bi-calendar-check"></i></span>
              <span><span class="d-block small fw-semibold">You have been invited to an interview for Senior PHP Developer</span><small class="text-muted">04 Nov 2026</small></span>
            </a>
            <a href="#" class="dropdown-item notif-item">
              <span class="ic bg-danger-subtle text-danger"><i class="bi bi-x-circle"></i></span>
              <span><span class="d-block small fw-semibold">Your application for Junior Accountant was not selected</span><small class="text-muted">05 Sep 2026</small></span>
            </a>
            <a href="../crud/notifications/index.php" class="d-block text-center py-2 small fw-semibold">View all notifications</a>
          </div>
        </div>

        <!-- User menu -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center gap-2 text-reset ms-1" data-bs-toggle="dropdown">
            <span class="avatar">RU</span>
            <span class="d-none d-sm-block lh-sm">
              <span class="fw-bold d-block">Rahim Uddin</span>
              <small class="text-muted">Job Seeker</small>
            </span>
            <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2">
            <li><a class="dropdown-item rounded-3" href="../crud/users/edit.php"><i class="bi bi-person me-2"></i>My Account</a></li>
            <li><a class="dropdown-item rounded-3" href="../crud/notifications/index.php"><i class="bi bi-bell me-2"></i>Notifications</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded-3 text-danger" href="../login.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="dash-content">
