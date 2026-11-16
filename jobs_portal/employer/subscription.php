<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscription & Payment | JobPortal BD</title>
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
        <li><a href="../employer/dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
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
        <li><a href="../employer/subscription.php" class="active"><i class="bi bi-gem"></i> Subscription</a></li>
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

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-title">
        <div>
          <h1>Subscription &amp; Payment</h1>
          <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li><li class="breadcrumb-item active">Subscription</li></ol></nav>
        </div>
      </div>

      <!-- Current plan (table: subscriptions) -->
      <div class="card-jp mb-4">
        <div class="card-body">
          <div class="row align-items-center g-3">
            <div class="col-md-4 d-flex align-items-center gap-3">
              <div class="avatar bg-primary-subtle text-primary" style="width:56px;height:56px;font-size:1.4rem"><i class="bi bi-lightning-charge"></i></div>
              <div><small class="text-muted">Current Plan</small><h5 class="fw-800 mb-0">Standard <span class="badge badge-soft-success fs-6 align-middle">Active</span></h5></div>
            </div>
            <div class="col-6 col-md-2"><small class="text-muted d-block">Posts left</small><strong class="fs-5">2</strong></div>
            <div class="col-6 col-md-2"><small class="text-muted d-block">Start</small><strong>25 Oct 2026</strong></div>
            <div class="col-6 col-md-2"><small class="text-muted d-block">Expires</small><strong class="text-danger">24 Nov 2026</strong></div>
            <div class="col-6 col-md-2 text-md-end"><a href="#choose" class="btn btn-soft-primary btn-sm">Renew</a></div>
          </div>
        </div>
      </div>

      <h5 class="fw-bold mb-3" id="choose">Choose a Package</h5>
      <form action="" method="post">
        <div class="row g-4 mb-4">
          <div class="col-md-4">
            <input type="radio" class="btn-check" name="package_id" value="1" id="pk1">
            <label class="card-jp p-4 w-100 h-100 d-block" for="pk1" style="cursor:pointer">
              <div class="d-flex justify-content-between"><h5 class="fw-bold">Free</h5><i class="bi bi-circle text-muted"></i></div>
              <div class="fs-2 fw-800">৳0</div><small class="text-muted">1 job &middot; 30 days</small>
            </label>
          </div>
          <div class="col-md-4">
            <input type="radio" class="btn-check" name="package_id" value="2" id="pk2">
            <label class="card-jp p-4 w-100 h-100 d-block" for="pk2" style="cursor:pointer">
              <div class="d-flex justify-content-between"><h5 class="fw-bold">Standard</h5><i class="bi bi-circle text-muted"></i></div>
              <div class="fs-2 fw-800">৳1,500</div><small class="text-muted">5 jobs &middot; 30 days</small>
            </label>
          </div>
          <div class="col-md-4">
            <input type="radio" class="btn-check" name="package_id" value="3" id="pk3" checked>
            <label class="card-jp p-4 w-100 h-100 d-block border-primary border-2" for="pk3" style="cursor:pointer">
              <div class="d-flex justify-content-between"><h5 class="fw-bold">Premium <span class="badge badge-featured">Best</span></h5><i class="bi bi-check-circle-fill text-primary"></i></div>
              <div class="fs-2 fw-800 text-primary">৳4,000</div><small class="text-muted">20 jobs &middot; 60 days &middot; featured</small>
            </label>
          </div>
        </div>

        <!-- Payment (table: payment_transactions) -->
        <div class="row g-4 mb-4">
          <div class="col-xl-8">
            <div class="card-jp h-100">
              <div class="card-header">Payment Details</div>
              <div class="card-body">
                <label class="form-label">Payment Method</label>
                <div class="row g-2 mb-4">
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="2" id="pm2" checked><label for="pm2" style="color:#e2136e">bKash</label></div>
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="3" id="pm3"><label for="pm3" style="color:#f6921e">Nagad</label></div>
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="4" id="pm4"><label for="pm4" style="color:#8c3494">Rocket</label></div>
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="5" id="pm5"><label for="pm5">Bank</label></div>
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="6" id="pm6"><label for="pm6">Card</label></div>
                  <div class="col-4 col-md-2 pay-method"><input type="radio" name="payment_method_id" value="1" id="pm1"><label for="pm1">Cash</label></div>
                </div>
                <div class="alert alert-info border-0 rounded-3 small"><i class="bi bi-info-circle me-1"></i> Send money to <strong>01700-000001</strong> (Merchant) and enter the Transaction ID below. Admin will verify your payment.</div>
                <div class="row g-3">
                  <div class="col-md-6"><label class="form-label">Transaction ID (TxID) <span class="text-danger">*</span></label><input type="text" name="tx_id" class="form-control" placeholder="e.g. BKDEMO7X92"></div>
                  <div class="col-md-6"><label class="form-label">Amount</label><div class="input-group"><span class="input-group-text">৳</span><input type="text" name="total_amount" class="form-control" value="4000.00" readonly></div></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="card-jp h-100">
              <div class="card-header">Order Summary</div>
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Package</span><strong>Premium</strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Duration</span><span>60 days</span></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">Job posts</span><span>20</span></div>
                <hr>
                <div class="d-flex justify-content-between mb-4"><span class="fw-bold">Total</span><span class="fw-800 fs-4 text-primary">৳4,000</span></div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-auto"><i class="bi bi-shield-check me-1"></i> Submit Payment</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- History -->
      <div class="card-jp">
        <div class="card-header">Payment History</div>
        <div class="table-responsive">
          <table class="table table-jp">
            <thead><tr><th>Invoice</th><th>Package</th><th>Method</th><th>TxID</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
              <tr><td><strong>INV-DEMO-0001</strong></td><td>Standard</td><td style="color:#e2136e" class="fw-semibold">bKash</td><td><code>BKDEMO7X92</code></td><td>৳1,500.00</td><td><span class="badge badge-soft-success">Completed</span></td></tr>
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
