<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Dashboard | JobPortal BD</title>
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
        <li><a href="../seeker/dashboard.php" class="active"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
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

      <div class="row g-4 mb-4">
        <!-- Profile card -->
        <div class="col-xl-4">
          <div class="card-jp h-100 text-center">
            <div class="card-body">
              <div class="avatar xl mx-auto mb-3 bg-warning-subtle text-warning">RU</div>
              <h4 class="fw-800 mb-0">Rahim Uddin</h4>
              <p class="text-muted mb-2">Junior PHP Developer</p>
              <div class="d-flex justify-content-center flex-wrap gap-2 small text-muted mb-3">
                <span><i class="bi bi-geo-alt text-primary"></i> Dhaka</span>
                <span><i class="bi bi-briefcase text-primary"></i> 2 yrs exp.</span>
                <span><i class="bi bi-cash text-primary"></i> ৳35,000</span>
              </div>
              <div class="text-start mb-3">
                <div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">Profile completeness</span><span>85%</span></div>
                <div class="progress" style="height:8px"><div class="progress-bar bg-accent" style="width:85%"></div></div>
                <small class="text-muted">Upload a resume file to reach 100%</small>
              </div>
              <div class="d-flex gap-2">
                <a href="../crud/seekers/edit.php" class="btn btn-soft-primary flex-fill"><i class="bi bi-pencil me-1"></i> Edit Profile</a>
                <a href="cv-preview.php" class="btn btn-primary flex-fill"><i class="bi bi-file-earmark-pdf me-1"></i> My CV</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Stats + recommended -->
        <div class="col-xl-8">
          <div class="row g-4 mb-4">
            <div class="col-sm-4"><div class="stat-card text-primary"><div class="ic bg-primary-subtle"><i class="bi bi-send-check"></i></div><h3>3</h3><p>Jobs Applied</p></div></div>
            <div class="col-sm-4"><div class="stat-card text-danger"><div class="ic bg-danger-subtle"><i class="bi bi-bookmark-heart"></i></div><h3>2</h3><p>Saved Jobs</p></div></div>
            <div class="col-sm-4"><div class="stat-card text-success"><div class="ic bg-success-subtle"><i class="bi bi-calendar-check"></i></div><h3>1</h3><p>Interview Calls</p></div></div>
          </div>
          <div class="card-jp">
            <div class="card-header d-flex justify-content-between align-items-center"><span><i class="bi bi-stars text-warning me-1"></i> Recommended for you</span><a href="../jobs.php" class="small">Browse all</a></div>
            <div class="card-body">
              <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
                <div class="company-logo bg-primary-subtle text-primary">TN</div>
                <div class="flex-grow-1"><a href="../job-details.php" class="fw-bold text-dark">Senior PHP Developer</a><br><small class="text-muted">TechNova Ltd &middot; Dhaka &middot; ৳60k-90k</small></div>
                <span class="badge badge-soft-success">3/3 skills match</span>
              </div>
              <div class="d-flex align-items-center gap-3">
                <div class="company-logo bg-primary-subtle text-primary">TN</div>
                <div class="flex-grow-1"><a href="../job-details.php" class="fw-bold text-dark">UI/UX Designer</a><br><small class="text-muted">TechNova Ltd &middot; Remote &middot; ৳40k-60k</small></div>
                <span class="badge badge-soft-success">2/2 skills match</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Application tracker -->
      <div class="card-jp mb-4">
        <div class="card-header d-flex justify-content-between align-items-center"><span>My Applications</span><a href="../crud/job_applications/index.php" class="small">View all</a></div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-lg-4">
              <div class="border rounded-4 p-3 h-100">
                <div class="d-flex justify-content-between mb-1"><strong>Senior PHP Developer</strong><span class="badge badge-soft-info">Interview</span></div>
                <small class="text-muted d-block mb-3">TechNova Ltd &middot; Applied 01 Nov 2026</small>
                <div class="app-steps">
                  <div class="st done"><div class="dot"><i class="bi bi-check"></i></div>Applied</div>
                  <div class="st done"><div class="dot"><i class="bi bi-check"></i></div>Viewed</div>
                  <div class="st done"><div class="dot"><i class="bi bi-check"></i></div>Shortlist</div>
                  <div class="st done"><div class="dot"><i class="bi bi-check"></i></div>Interview</div>
                  <div class="st"><div class="dot"></div>Hired</div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="border rounded-4 p-3 h-100">
                <div class="d-flex justify-content-between mb-1"><strong>Laravel Intern</strong><span class="badge badge-soft-secondary">Applied</span></div>
                <small class="text-muted d-block mb-3">TechNova Ltd &middot; Applied 03 Nov 2026</small>
                <div class="app-steps">
                  <div class="st done"><div class="dot"><i class="bi bi-check"></i></div>Applied</div>
                  <div class="st"><div class="dot"></div>Viewed</div>
                  <div class="st"><div class="dot"></div>Shortlist</div>
                  <div class="st"><div class="dot"></div>Interview</div>
                  <div class="st"><div class="dot"></div>Hired</div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="border rounded-4 p-3 h-100 bg-light">
                <div class="d-flex justify-content-between mb-1"><strong>Junior Accountant</strong><span class="badge badge-soft-danger">Rejected</span></div>
                <small class="text-muted d-block mb-3">TechNova Ltd &middot; Applied 26 Aug 2026</small>
                <p class="small text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Your application was not selected this time. Keep applying!</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4">
        <!-- Saved jobs -->
        <div class="col-xl-6">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><span>Saved Jobs</span><a href="../crud/saved_jobs/index.php" class="small">View all</a></div>
            <div class="table-responsive">
              <table class="table table-jp">
                <thead><tr><th>Job</th><th>Deadline</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                  <tr><td><strong>Sales Executive</strong><br><small class="text-muted">GreenLeaf Traders</small></td><td><span class="text-danger">16 Nov 2026</span></td><td class="text-end text-nowrap"><a href="../job-details.php" class="btn btn-sm btn-primary">Apply</a> <button class="btn btn-sm btn-outline-danger"><i class="bi bi-bookmark-x"></i></button></td></tr>
                  <tr><td><strong>Graphic Designer</strong><br><small class="text-muted">GreenLeaf Traders</small></td><td><span class="badge badge-soft-secondary">Expired</span></td><td class="text-end text-nowrap"><button class="btn btn-sm btn-light" disabled>Closed</button> <button class="btn btn-sm btn-outline-danger"><i class="bi bi-bookmark-x"></i></button></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Skills -->
        <div class="col-xl-6">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><span>My Skills</span><a href="../crud/seeker_skills/index.php" class="small"><i class="bi bi-plus"></i> Add</a></div>
            <div class="card-body">
              <div class="d-flex flex-wrap gap-2 mb-4">
                <span class="badge badge-soft-primary fs-6">PHP</span><span class="badge badge-soft-primary fs-6">MySQL</span><span class="badge badge-soft-primary fs-6">Laravel</span><span class="badge badge-soft-primary fs-6">JavaScript</span><span class="badge badge-soft-primary fs-6">HTML</span><span class="badge badge-soft-primary fs-6">CSS</span>
              </div>
              <h6 class="fw-bold">Recent Activity</h6>
              <ul class="timeline-mini small">
                <li><strong>Interview invitation</strong> for Senior PHP Developer<br><span class="text-muted">04 Nov 2026</span></li>
                <li><strong>Applied</strong> for Laravel Intern<br><span class="text-muted">03 Nov 2026</span></li>
                <li><strong>Not selected</strong> for Junior Accountant<br><span class="text-muted">05 Sep 2026</span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>

    <footer class="dash-footer d-flex flex-column flex-sm-row justify-content-between gap-1">
      <span>&copy; 2026 JobPortal BD. All rights reserved.</span>
      <span>Made with <i class="bi bi-heart-fill text-danger"></i> in Bangladesh</span>
    </footer>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
