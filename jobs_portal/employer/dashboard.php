<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employer Dashboard | JobPortal BD</title>
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

  <!-- ===================== SIDEBAR (Employer) ===================== -->
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between">
        <a href="../index.html" class="sidebar-brand flex-grow-1"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal</a>
        <button type="button" class="btn-close btn-close-white d-lg-none me-3" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
      </div>

      <div class="sidebar-heading">Main</div>
      <ul class="sidebar-nav">
        <li><a href="../employer/dashboard.php" class="active"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
        <li><a href="../crud/companies/edit.php"><i class="bi bi-building"></i> Company Profile</a></li>
      </ul>

      <div class="sidebar-heading">Jobs</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/jobs/create.php"><i class="bi bi-plus-circle"></i> Post a Job</a></li>
        <li><a href="../crud/jobs/index.php"><i class="bi bi-briefcase"></i> My Jobs</a></li>
        <li><a href="../crud/job_applications/index.php"><i class="bi bi-people"></i> Applicants <span class="badge bg-danger">2</span></a></li>
      </ul>

      <div class="sidebar-heading">Billing</div>
      <ul class="sidebar-nav">
        <li><a href="../employer/subscription.php"><i class="bi bi-gem"></i> Subscription</a></li>
        <li><a href="../crud/payment_transactions/index.php"><i class="bi bi-receipt"></i> Payment History</a></li>
      </ul>

      <div class="sidebar-heading">Account</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/notifications/index.php"><i class="bi bi-bell"></i> Notifications</a></li>
        <li><a href="../crud/users/edit.php"><i class="bi bi-gear"></i> Account Settings</a></li>
        <li><a href="../login.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>

      <div class="sidebar-footer">
        <div class="sidebar-upgrade">
          <div class="small text-white-50">Standard Plan</div>
          <div class="fw-bold mb-2">2 of 5 posts left</div>
          <div class="progress mb-3" style="height:6px"><div class="progress-bar bg-accent" style="width:60%"></div></div>
          <a href="../employer/subscription.php" class="btn btn-accent btn-sm w-100">Upgrade Plan</a>
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
              <span class="ic bg-primary-subtle text-primary"><i class="bi bi-person-plus"></i></span>
              <span><span class="d-block small fw-semibold">Rahim Uddin applied for Laravel Intern</span><small class="text-muted">03 Nov 2026</small></span>
            </a>
            <a href="#" class="dropdown-item notif-item">
              <span class="ic bg-success-subtle text-success"><i class="bi bi-patch-check"></i></span>
              <span><span class="d-block small fw-semibold">Your Standard package payment was approved</span><small class="text-muted">25 Oct 2026</small></span>
            </a>
            <a href="../crud/notifications/index.php" class="d-block text-center py-2 small fw-semibold">View all notifications</a>
          </div>
        </div>

        <!-- User menu -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center gap-2 text-reset ms-1" data-bs-toggle="dropdown">
            <span class="avatar">KH</span>
            <span class="d-none d-sm-block lh-sm">
              <span class="fw-bold d-block">Karim Hossain</span>
              <small class="text-muted">TechNova Ltd</small>
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

      <!-- Welcome -->
      <div class="welcome-card mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index:1">
          <div class="col-md-8">
            <h2 class="fw-800 mb-1">Welcome back, Karim! 👋</h2>
            <p class="mb-0 text-white-50">TechNova Ltd has <strong class="text-white">2 new applicants</strong> waiting for review.</p>
          </div>
          <div class="col-md-4 text-md-end">
            <a href="../crud/jobs/create.php" class="btn btn-light text-primary"><i class="bi bi-plus-circle me-1"></i> Post a New Job</a>
          </div>
        </div>
      </div>

      <!-- Stats -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-primary"><div class="ic bg-primary-subtle"><i class="bi bi-briefcase"></i></div><h3>5</h3><p>Total Jobs Posted</p></div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-success"><div class="ic bg-success-subtle"><i class="bi bi-check2-circle"></i></div><h3>2</h3><p>Active (Approved)</p></div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-warning"><div class="ic bg-warning-subtle"><i class="bi bi-people"></i></div><h3>5</h3><p>Total Applicants</p></div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-info"><div class="ic bg-info-subtle"><i class="bi bi-calendar-check"></i></div><h3>1</h3><p>Interviews Scheduled</p></div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <!-- Recent applicants -->
        <div class="col-xl-8">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><span>Recent Applicants</span><a href="../crud/job_applications/index.php" class="small">View all</a></div>
            <div class="table-responsive">
              <table class="table table-jp">
                <thead><tr><th>Candidate</th><th>Applied For</th><th>Date</th><th>Status</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                  <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-warning-subtle text-warning">RU</span><div><strong>Rahim Uddin</strong><br><small class="text-muted">Junior PHP Developer</small></div></div></td>
                    <td>Laravel Intern</td><td>03 Nov 2026</td>
                    <td><span class="badge badge-soft-secondary">Applied</span></td>
                    <td class="text-end text-nowrap">
                      <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Download CV"><i class="bi bi-download"></i></a>
                      <div class="dropdown d-inline-block">
                        <button class="btn btn-sm btn-soft-primary dropdown-toggle" data-bs-toggle="dropdown">Status</button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                          <li><a class="dropdown-item" href="#">Viewed</a></li><li><a class="dropdown-item" href="#">Shortlisted</a></li><li><a class="dropdown-item" href="#">Interview</a></li><li><a class="dropdown-item" href="#">Hired</a></li><li><a class="dropdown-item text-danger" href="#">Rejected</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="avatar sm">TA</span><div><strong>Tanvir Ahmed</strong><br><small class="text-muted">Sales Executive</small></div></div></td>
                    <td>Laravel Intern</td><td>02 Nov 2026</td>
                    <td><span class="badge badge-soft-secondary">Applied</span></td>
                    <td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a> <a href="../crud/job_applications/edit.php" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-square"></i> Status</a></td>
                  </tr>
                  <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-warning-subtle text-warning">RU</span><div><strong>Rahim Uddin</strong><br><small class="text-muted">Junior PHP Developer</small></div></div></td>
                    <td>Senior PHP Developer</td><td>01 Nov 2026</td>
                    <td><span class="badge badge-soft-info">Interview</span></td>
                    <td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a> <a href="../crud/job_applications/edit.php" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-square"></i> Status</a></td>
                  </tr>
                  <tr>
                    <td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-danger-subtle text-danger">NJ</span><div><strong>Nusrat Jahan</strong><br><small class="text-muted">UI/UX Designer</small></div></div></td>
                    <td>Senior PHP Developer</td><td>25 Sep 2026</td>
                    <td><span class="badge badge-soft-primary">Viewed</span></td>
                    <td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a> <a href="../crud/job_applications/edit.php" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil-square"></i> Status</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Subscription -->
        <div class="col-xl-4">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><span>My Subscription</span><span class="badge badge-soft-success">Active</span></div>
            <div class="card-body">
              <div class="d-flex align-items-center gap-3 mb-4">
                <div class="avatar xl bg-primary-subtle text-primary" style="width:64px;height:64px;font-size:1.5rem"><i class="bi bi-lightning-charge"></i></div>
                <div><h4 class="fw-800 mb-0">Standard</h4><small class="text-muted">৳1,500 / 30 days</small></div>
              </div>
              <div class="d-flex justify-content-between small mb-1"><span>Job posts used</span><strong>3 / 5</strong></div>
              <div class="progress mb-3" style="height:10px"><div class="progress-bar" style="width:60%"></div></div>
              <div class="d-flex justify-content-between small mb-1"><span>Days remaining</span><strong>7 / 30</strong></div>
              <div class="progress mb-4" style="height:10px"><div class="progress-bar bg-warning" style="width:23%"></div></div>
              <ul class="list-unstyled small text-muted mb-4">
                <li class="mb-2"><i class="bi bi-calendar-check text-primary me-2"></i>Started: 25 Oct 2026</li>
                <li><i class="bi bi-calendar-x text-danger me-2"></i>Expires: 24 Nov 2026</li>
              </ul>
              <a href="subscription.php" class="btn btn-primary w-100"><i class="bi bi-gem me-1"></i> Upgrade to Premium</a>
            </div>
          </div>
        </div>
      </div>

      <!-- My jobs -->
      <div class="card-jp">
        <div class="card-header d-flex justify-content-between align-items-center"><span>My Job Posts</span><a href="../crud/jobs/index.php" class="small">Manage jobs</a></div>
        <div class="table-responsive">
          <table class="table table-jp">
            <thead><tr><th>Job Title</th><th>Type</th><th>City</th><th>Applicants</th><th>Deadline</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
              <tr><td><strong>Senior PHP Developer</strong> <i class="bi bi-star-fill text-warning small"></i></td><td>Full Time</td><td>Dhaka</td><td><span class="badge badge-soft-primary">2</span></td><td>19 Nov 2026</td><td><span class="badge badge-soft-success">Approved</span></td><td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil"></i></a> <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a></td></tr>
              <tr><td><strong>Laravel Intern</strong></td><td>Internship</td><td>Dhaka</td><td><span class="badge badge-soft-primary">2</span></td><td>29 Nov 2026</td><td><span class="badge badge-soft-success">Approved</span></td><td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil"></i></a> <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a></td></tr>
              <tr><td><strong>UI/UX Designer</strong></td><td>Remote</td><td>Dhaka</td><td><span class="badge badge-soft-secondary">0</span></td><td>24 Nov 2026</td><td><span class="badge badge-soft-warning">Pending</span></td><td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil"></i></a> <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a></td></tr>
              <tr><td><strong>Junior Accountant</strong></td><td>Contract</td><td>Chattogram</td><td><span class="badge badge-soft-primary">1</span></td><td>30 Oct 2026</td><td><span class="badge badge-soft-secondary">Closed</span></td><td class="text-end text-nowrap"><a href="#" class="btn btn-sm btn-soft-primary"><i class="bi bi-pencil"></i></a> <a href="#" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a></td></tr>
            </tbody>
          </table>
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
