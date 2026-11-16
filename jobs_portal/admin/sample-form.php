<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add / Edit Job | JobPortal BD</title>
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
        <li><a href="../admin/dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
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
        <li><a href="../admin/sample-form.php" class="active"><i class="bi bi-ui-checks"></i> Sample: Form Page</a></li>
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

      <!--
        SAMPLE FORM PAGE — copy this layout into your crud/<table>/create.php & edit.php files.
        Fields match the `jobs` table.
      -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-title">
        <div>
          <h1>Add New Job</h1>
          <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li><li class="breadcrumb-item"><a href="sample-table.php">Jobs</a></li><li class="breadcrumb-item active">Add New</li></ol></nav>
        </div>
        <a href="sample-table.php" class="btn btn-light border"><i class="bi bi-arrow-left me-1"></i> Back to list</a>
      </div>

      <!-- Validation error example -->
      <div class="alert alert-danger border-0 rounded-3">
        <strong><i class="bi bi-exclamation-triangle me-1"></i> Please fix the following:</strong>
        <ul class="mb-0 mt-1 small"><li>Job title is required.</li></ul>
      </div>

      <form action="" method="post">
        <div class="row g-4">
          <div class="col-xl-8">
            <div class="card-jp mb-4">
              <div class="card-header">Job Information</div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-8">
                    <label class="form-label">Job Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control is-invalid" placeholder="e.g. Senior PHP Developer">
                    <div class="invalid-feedback">Job title is required.</div>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="auto-generated">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Company <span class="text-danger">*</span></label>
                    <select name="company_id" class="form-select"><option value="">Select company</option><option value="3">TechNova Ltd</option><option value="4">GreenLeaf Traders</option></select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select"><option value="">Select category</option><option value="1">IT / Software</option><option value="2">Sales</option><option value="3">Accounts</option><option value="4">Design</option><option value="6">Developer</option></select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">City</label>
                    <select name="city_id" class="form-select"><option value="">Select city</option><option value="1">Dhaka</option><option value="2">Chattogram</option><option value="3">Sylhet</option><option value="4">Rajshahi</option></select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                    <select name="job_type" class="form-select"><option value="full_time">Full Time</option><option value="part_time">Part Time</option><option value="contract">Contract</option><option value="internship">Internship</option><option value="remote">Remote</option></select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Minimum Salary (৳)</label>
                    <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01" name="salary_min" class="form-control" placeholder="25000"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Maximum Salary (৳)</label>
                    <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01" name="salary_max" class="form-control" placeholder="35000"></div>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Job Description</label>
                    <textarea name="description" rows="7" class="form-control" placeholder="Responsibilities, requirements, benefits..."></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-jp">
              <div class="card-header">Required Skills <small class="text-muted fw-normal">(table: job_skills)</small></div>
              <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                  <input type="checkbox" class="btn-check" name="skills[]" value="1" id="sk1" checked><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk1">PHP</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="2" id="sk2" checked><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk2">MySQL</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="3" id="sk3"><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk3">Laravel</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="4" id="sk4"><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk4">JavaScript</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="5" id="sk5"><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk5">HTML</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="6" id="sk6"><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk6">CSS</label>
                  <input type="checkbox" class="btn-check" name="skills[]" value="7" id="sk7"><label class="btn btn-outline-primary btn-sm rounded-pill" for="sk7">Excel</label>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4">
            <div class="card-jp mb-4">
              <div class="card-header">Publish</div>
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label">Application Deadline <span class="text-danger">*</span></label>
                  <input type="date" name="deadline" class="form-control">
                </div>
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-select"><option value="pending">Pending</option><option value="approved">Approved</option><option value="rejected">Rejected</option><option value="closed">Closed</option></select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Subscription</label>
                  <select name="subscription_id" class="form-select"><option value="">None</option><option value="3">#3 — Standard (2 posts left)</option></select>
                </div>
                <div class="form-check form-switch mb-4">
                  <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="feat">
                  <label class="form-check-label" for="feat">Mark as featured job</label>
                </div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Job</button>
                  <button type="reset" class="btn btn-light border">Reset</button>
                </div>
              </div>
            </div>
            <div class="card-jp">
              <div class="card-body small text-muted">
                <i class="bi bi-lightbulb text-warning me-1"></i> Tip: Jobs posted by employers stay <strong>pending</strong> until an admin approves them.
              </div>
            </div>
          </div>
        </div>
      </form>
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
