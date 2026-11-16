<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard | JobPortal BD</title>
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

  <!-- ===================== SIDEBAR (Admin) ===================== -->
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between">
        <a href="../index.html" class="sidebar-brand flex-grow-1"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal</a>
        <button type="button" class="btn-close btn-close-white d-lg-none me-3" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
      </div>

      <div class="sidebar-heading">Main</div>
      <ul class="sidebar-nav">
        <li><a href="../admin/dashboard.php" class="active"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
      </ul>

      <div class="sidebar-heading">People</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/users/index.php"><i class="bi bi-people"></i> Users <span class="badge bg-warning text-dark">1</span></a></li>
        <li><a href="../crud/companies/index.php"><i class="bi bi-buildings"></i> Companies</a></li>
        <li><a href="../crud/seekers/index.php"><i class="bi bi-person-badge"></i> Job Seekers</a></li>
      </ul>

      <div class="sidebar-heading">Jobs</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/jobs/index.php"><i class="bi bi-briefcase"></i> All Jobs <span class="badge bg-danger">3</span></a></li>
        <li><a href="../crud/job_applications/index.php"><i class="bi bi-file-earmark-person"></i> Applications</a></li>
        <li><a href="../crud/job_skills/index.php"><i class="bi bi-diagram-3"></i> Job Skills</a></li>
        <li><a href="../crud/saved_jobs/index.php"><i class="bi bi-bookmark"></i> Saved Jobs</a></li>
      </ul>

      <div class="sidebar-heading">Master Data</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/categories/index.php"><i class="bi bi-tags"></i> Categories</a></li>
        <li><a href="../crud/cities/index.php"><i class="bi bi-geo-alt"></i> Cities</a></li>
        <li><a href="../crud/skills/index.php"><i class="bi bi-lightning-charge"></i> Skills</a></li>
        <li><a href="../crud/cv_templates/index.php"><i class="bi bi-file-earmark-richtext"></i> CV Templates</a></li>
      </ul>

      <div class="sidebar-heading">Billing</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/packages/index.php"><i class="bi bi-box-seam"></i> Packages</a></li>
        <li><a href="../crud/subscriptions/index.php"><i class="bi bi-arrow-repeat"></i> Subscriptions</a></li>
        <li><a href="../crud/payment_methods/index.php"><i class="bi bi-wallet2"></i> Payment Methods</a></li>
        <li><a href="../crud/payment_transactions/index.php"><i class="bi bi-receipt"></i> Transactions <span class="badge bg-warning text-dark">1</span></a></li>
      </ul>

      <div class="sidebar-heading">System</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/notifications/index.php"><i class="bi bi-bell"></i> Notifications</a></li>
        <li><a href="../admin/sample-table.php"><i class="bi bi-table"></i> Sample: Table Page</a></li>
        <li><a href="../admin/sample-form.php"><i class="bi bi-ui-checks"></i> Sample: Form Page</a></li>
        <li><a href="../login.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
      <div class="sidebar-footer"></div>
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
              <span class="ic bg-primary-subtle text-primary"><i class="bi bi-building-add"></i></span>
              <span><span class="d-block small fw-semibold">New employer "GreenLeaf Traders" is waiting for approval</span><small class="text-muted">04 Nov 2026</small></span>
            </a>
            <a href="#" class="dropdown-item notif-item unread">
              <span class="ic bg-warning-subtle text-warning"><i class="bi bi-receipt"></i></span>
              <span><span class="d-block small fw-semibold">Payment INV-DEMO-0002 submitted via Nagad</span><small class="text-muted">04 Nov 2026</small></span>
            </a>
            <a href="#" class="dropdown-item notif-item">
              <span class="ic bg-success-subtle text-success"><i class="bi bi-briefcase"></i></span>
              <span><span class="d-block small fw-semibold">Job "UI/UX Designer" needs review</span><small class="text-muted">03 Nov 2026</small></span>
            </a>
            <a href="../crud/notifications/index.php" class="d-block text-center py-2 small fw-semibold">View all notifications</a>
          </div>
        </div>

        <!-- User menu -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center gap-2 text-reset ms-1" data-bs-toggle="dropdown">
            <span class="avatar">SA</span>
            <span class="d-none d-sm-block lh-sm">
              <span class="fw-bold d-block">Site Admin</span>
              <small class="text-muted">Administrator</small>
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

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-title">
        <div>
          <h1>Dashboard</h1>
          <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="#">Admin</a></li><li class="breadcrumb-item active">Overview</li></ol></nav>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-light border"><i class="bi bi-calendar3 me-1"></i> Nov 2026</button>
          <a href="../crud/jobs/index.php" class="btn btn-primary"><i class="bi bi-check2-square me-1"></i> Review Jobs</a>
        </div>
      </div>

      <!-- Stat cards -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-primary">
            <div class="d-flex justify-content-between"><div class="ic bg-primary-subtle"><i class="bi bi-people"></i></div><span class="trend text-success"><i class="bi bi-arrow-up"></i> 12%</span></div>
            <h3>6</h3><p>Total Users</p>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-success">
            <div class="d-flex justify-content-between"><div class="ic bg-success-subtle"><i class="bi bi-briefcase"></i></div><span class="trend text-success"><i class="bi bi-arrow-up"></i> 4</span></div>
            <h3>8</h3><p>Total Jobs <small>(3 pending)</small></p>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-warning">
            <div class="d-flex justify-content-between"><div class="ic bg-warning-subtle"><i class="bi bi-file-earmark-person"></i></div><span class="trend text-success"><i class="bi bi-arrow-up"></i> 8%</span></div>
            <h3>7</h3><p>Applications</p>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="stat-card text-info">
            <div class="d-flex justify-content-between"><div class="ic bg-info-subtle"><i class="bi bi-cash-stack"></i></div><span class="trend text-warning">৳4,000 pending</span></div>
            <h3>৳1,500</h3><p>Revenue (completed)</p>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <!-- Chart -->
        <div class="col-xl-8">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span>Applications Overview</span>
              <select class="form-select form-select-sm w-auto"><option>Last 6 months</option><option>This year</option></select>
            </div>
            <div class="card-body"><canvas id="appChart" height="120"></canvas></div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card-jp h-100">
            <div class="card-header">Application Status</div>
            <div class="card-body">
              <canvas id="statusChart" height="200"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4 mb-4">
        <!-- Pending approvals -->
        <div class="col-xl-8">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <span><i class="bi bi-hourglass-split text-warning me-1"></i> Pending Job Approvals</span>
              <a href="../crud/jobs/index.php" class="small">View all</a>
            </div>
            <div class="table-responsive">
              <table class="table table-jp">
                <thead><tr><th>Job</th><th>Company</th><th>Type</th><th>Deadline</th><th class="text-end">Action</th></tr></thead>
                <tbody>
                  <tr>
                    <td><strong>UI/UX Designer</strong><br><small class="text-muted">Design &middot; Dhaka</small></td>
                    <td>TechNova Ltd</td>
                    <td><span class="badge badge-soft-accent">Remote</span></td>
                    <td>24 Nov 2026</td>
                    <td class="text-end text-nowrap">
                      <button class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Approve"><i class="bi bi-check-lg"></i></button>
                      <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Reject"><i class="bi bi-x-lg"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Accounts Officer</strong><br><small class="text-muted">Accounts &middot; Rajshahi</small></td>
                    <td>GreenLeaf Traders</td>
                    <td><span class="badge badge-soft-primary">Full Time</span></td>
                    <td>04 Dec 2026</td>
                    <td class="text-end text-nowrap">
                      <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i></button>
                      <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>fthg</strong><br><small class="text-muted">Design &middot; Sylhet</small></td>
                    <td>TechNova Ltd</td>
                    <td><span class="badge badge-soft-primary">Full Time</span></td>
                    <td><span class="text-danger">11 Nov 2026</span></td>
                    <td class="text-end text-nowrap">
                      <button class="btn btn-sm btn-success"><i class="bi bi-check-lg"></i></button>
                      <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Pending employer + payment -->
        <div class="col-xl-4">
          <div class="card-jp mb-4">
            <div class="card-header"><i class="bi bi-person-check text-primary me-1"></i> Employer Approval</div>
            <div class="card-body">
              <div class="d-flex align-items-center gap-3">
                <span class="avatar bg-success-subtle text-success">SD</span>
                <div class="flex-grow-1"><strong>Sumon Das</strong><br><small class="text-muted">GreenLeaf Traders</small></div>
                <span class="badge badge-soft-warning">Pending</span>
              </div>
              <div class="d-flex gap-2 mt-3">
                <button class="btn btn-sm btn-success flex-fill"><i class="bi bi-check-lg"></i> Approve</button>
                <button class="btn btn-sm btn-outline-danger flex-fill"><i class="bi bi-slash-circle"></i> Block</button>
              </div>
            </div>
          </div>
          <div class="card-jp">
            <div class="card-header"><i class="bi bi-receipt text-warning me-1"></i> Payment Verification</div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Invoice</span><strong>INV-DEMO-0002</strong></div>
              <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Employer</span><span>Sumon Das</span></div>
              <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Package</span><span>Premium</span></div>
              <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Method</span><span class="fw-semibold" style="color:#f6921e">Nagad</span></div>
              <div class="d-flex justify-content-between mb-1"><span class="text-muted small">TxID</span><code>NGDEMO88AA</code></div>
              <div class="d-flex justify-content-between mb-3"><span class="text-muted small">Amount</span><strong class="text-success">৳4,000.00</strong></div>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-success flex-fill"><i class="bi bi-patch-check"></i> Verify</button>
                <button class="btn btn-sm btn-outline-danger flex-fill"><i class="bi bi-x-circle"></i> Fail</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row g-4">
        <!-- Recent users -->
        <div class="col-xl-7">
          <div class="card-jp h-100">
            <div class="card-header d-flex justify-content-between align-items-center"><span>Recent Users</span><a href="../crud/users/index.php" class="small">Manage users</a></div>
            <div class="table-responsive">
              <table class="table table-jp">
                <thead><tr><th>User</th><th>Role</th><th>Status</th><th>Joined</th></tr></thead>
                <tbody>
                  <tr><td><div class="d-flex align-items-center gap-2"><span class="avatar sm">TA</span><div><strong>Tanvir Ahmed</strong><br><small class="text-muted">seeker3@jobportal.com</small></div></div></td><td><span class="badge badge-soft-info">Seeker</span></td><td><span class="badge badge-soft-success">Active</span></td><td>30 Oct 2026</td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-success-subtle text-success">SD</span><div><strong>Sumon Das</strong><br><small class="text-muted">employer2@jobportal.com</small></div></div></td><td><span class="badge badge-soft-primary">Employer</span></td><td><span class="badge badge-soft-warning">Pending</span></td><td>15 Oct 2026</td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-danger-subtle text-danger">NJ</span><div><strong>Nusrat Jahan</strong><br><small class="text-muted">seeker2@jobportal.com</small></div></div></td><td><span class="badge badge-soft-info">Seeker</span></td><td><span class="badge badge-soft-success">Active</span></td><td>21 Aug 2026</td></tr>
                  <tr><td><div class="d-flex align-items-center gap-2"><span class="avatar sm bg-warning-subtle text-warning">RU</span><div><strong>Rahim Uddin</strong><br><small class="text-muted">seeker@jobportal.com</small></div></div></td><td><span class="badge badge-soft-info">Seeker</span></td><td><span class="badge badge-soft-success">Active</span></td><td>07 Jul 2026</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Jobs by category -->
        <div class="col-xl-5">
          <div class="card-jp h-100">
            <div class="card-header">Jobs by Category</div>
            <div class="card-body">
              <div class="mb-3"><div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">Design</span><span>3 jobs</span></div><div class="progress" style="height:8px"><div class="progress-bar bg-danger" style="width:37.5%"></div></div></div>
              <div class="mb-3"><div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">IT / Software</span><span>2 jobs</span></div><div class="progress" style="height:8px"><div class="progress-bar" style="width:25%"></div></div></div>
              <div class="mb-3"><div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">Accounts</span><span>2 jobs</span></div><div class="progress" style="height:8px"><div class="progress-bar bg-warning" style="width:25%"></div></div></div>
              <div class="mb-3"><div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">Sales</span><span>1 job</span></div><div class="progress" style="height:8px"><div class="progress-bar bg-success" style="width:12.5%"></div></div></div>
              <div><div class="d-flex justify-content-between small mb-1"><span class="fw-semibold">Developer</span><span>0 jobs</span></div><div class="progress" style="height:8px"><div class="progress-bar bg-info" style="width:0%"></div></div></div>
              <hr>
              <h6 class="fw-bold mb-3">Active Subscriptions</h6>
              <div class="d-flex align-items-center gap-3">
                <span class="avatar bg-primary-subtle text-primary">KH</span>
                <div class="flex-grow-1"><strong>Karim Hossain</strong> <span class="badge badge-soft-primary">Standard</span><br><small class="text-muted">2 posts left &middot; ends 24 Nov 2026</small></div>
              </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
  // Demo chart data — replace with values from your database
  document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('appChart'), {
      type: 'line',
      data: {
        labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
        datasets: [
          { label: 'Applications', data: [0, 1, 1, 1, 1, 3], borderColor: '#4f46e5', backgroundColor: 'rgba(79,70,229,.1)', fill: true, tension: .4 },
          { label: 'Jobs Posted', data: [0, 0, 1, 2, 3, 2], borderColor: '#14b8a6', backgroundColor: 'transparent', tension: .4 }
        ]
      },
      options: { plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
    new Chart(document.getElementById('statusChart'), {
      type: 'doughnut',
      data: {
        labels: ['Applied', 'Viewed', 'Shortlisted', 'Interview', 'Hired', 'Rejected'],
        datasets: [{ data: [2, 1, 1, 1, 1, 1], backgroundColor: ['#94a3b8', '#4f46e5', '#f59e0b', '#0ea5e9', '#22c55e', '#ef4444'], borderWidth: 0 }]
      },
      options: { cutout: '68%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } } }
    });
  });
</script>
<script src="../assets/js/main.js"></script>
</body>
</html>
