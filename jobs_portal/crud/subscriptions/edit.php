<?php include_once("../../config/dbconfig.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscription Update | JobPortal BD</title>
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body class="dash-body">
<div class="dash-wrapper">

  <!-- ===================== SIDEBAR (Admin) ===================== -->
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between">
        <a href="../../index.html" class="sidebar-brand flex-grow-1"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal</a>
        <button type="button" class="btn-close btn-close-white d-lg-none me-3" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
      </div>

      <div class="sidebar-heading">Main</div>
      <ul class="sidebar-nav">
        <li><a href="../../admin/dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
      </ul>

      <div class="sidebar-heading">People</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/users/index.php"><i class="bi bi-people"></i> Users <span class="badge bg-warning text-dark">1</span></a></li>
        <li><a href="../../crud/companies/index.php"><i class="bi bi-buildings"></i> Companies</a></li>
        <li><a href="../../crud/seekers/index.php"><i class="bi bi-person-badge"></i> Job Seekers</a></li>
      </ul>

      <div class="sidebar-heading">Seeker CV</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/seeker_educations/index.php"><i class="bi bi-mortarboard"></i> Educations</a></li>
        <li><a href="../../crud/seeker_experiences/index.php"><i class="bi bi-briefcase"></i> Experiences</a></li>
        <li><a href="../../crud/seeker_skills/index.php"><i class="bi bi-lightning-charge"></i> Seeker Skills</a></li>
        <li><a href="../../crud/seeker_cv_items/index.php"><i class="bi bi-award"></i> Projects &amp; Certificates</a></li>
      </ul>

      <div class="sidebar-heading">Jobs</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/jobs/index.php"><i class="bi bi-briefcase"></i> All Jobs <span class="badge bg-danger">3</span></a></li>
        <li><a href="../../crud/job_applications/index.php"><i class="bi bi-file-earmark-person"></i> Applications</a></li>
        <li><a href="../../crud/job_skills/index.php"><i class="bi bi-diagram-3"></i> Job Skills</a></li>
        <li><a href="../../crud/saved_jobs/index.php"><i class="bi bi-bookmark"></i> Saved Jobs</a></li>
      </ul>

      <div class="sidebar-heading">Master Data</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/categories/index.php"><i class="bi bi-tags"></i> Categories</a></li>
        <li><a href="../../crud/cities/index.php"><i class="bi bi-geo-alt"></i> Cities</a></li>
        <li><a href="../../crud/skills/index.php"><i class="bi bi-lightning-charge"></i> Skills</a></li>
        <li><a href="../../crud/cv_templates/index.php"><i class="bi bi-file-earmark-richtext"></i> CV Templates</a></li>
      </ul>

      <div class="sidebar-heading">Billing</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/packages/index.php"><i class="bi bi-box-seam"></i> Packages</a></li>
        <li><a href="../../crud/subscriptions/index.php" class="active"><i class="bi bi-arrow-repeat"></i> Subscriptions</a></li>
        <li><a href="../../crud/payment_methods/index.php"><i class="bi bi-wallet2"></i> Payment Methods</a></li>
        <li><a href="../../crud/payment_transactions/index.php"><i class="bi bi-receipt"></i> Transactions <span class="badge bg-warning text-dark">1</span></a></li>
      </ul>

      <div class="sidebar-heading">System</div>
      <ul class="sidebar-nav">
        <li><a href="../../crud/notifications/index.php"><i class="bi bi-bell"></i> Notifications</a></li>
        <li><a href="../../admin/sample-table.php"><i class="bi bi-table"></i> Sample: Table Page</a></li>
        <li><a href="../../admin/sample-form.php"><i class="bi bi-ui-checks"></i> Sample: Form Page</a></li>
        <li><a href="../../login.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
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
        <a href="../../index.html" class="topbar-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Website"><i class="bi bi-globe2"></i></a>

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
            <a href="../../crud/notifications/index.php" class="d-block text-center py-2 small fw-semibold">View all notifications</a>
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
            <li><a class="dropdown-item rounded-3" href="../../crud/users/index.php"><i class="bi bi-person me-2"></i>My Account</a></li>
            <li><a class="dropdown-item rounded-3" href="../../crud/notifications/index.php"><i class="bi bi-bell me-2"></i>Notifications</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded-3 text-danger" href="../../login.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="dash-content">

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-title">
        <div>
          <h1>Subscription Update Form</h1>
          <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="../../admin/dashboard.php">Dashboard</a></li><li class="breadcrumb-item"><a href="index.php">Subscriptions</a></li><li class="breadcrumb-item active">Update</li></ol></nav>
        </div>
        <a href="index.php" class="btn btn-light border"><i class="bi bi-arrow-left me-1"></i> Back to Subscription List</a>
      </div>

      <?php
          // Display Subscription Record
          $id = $_GET['id'];

          // Update Subscription Record
          if($_SERVER['REQUEST_METHOD']=='POST'){

              $user_id = $_POST['user_id'];
              $package_id = $_POST['package_id'];
              $posts_left = $_POST['posts_left'];
              $status = $_POST['status'];
              $start_date = $_POST['start_date'] == '' ? "NULL" : "'".$_POST['start_date']."'";
              $end_date = $_POST['end_date'] == '' ? "NULL" : "'".$_POST['end_date']."'";

              try {
                  // Update Query
                  $conn->query("UPDATE subscriptions SET
              user_id = '$user_id',
              package_id = '$package_id',
              posts_left = '$posts_left',
              status = '$status',
              start_date = $start_date,
              end_date = $end_date
                  WHERE id = '$id'");

                  if($conn->affected_rows){
                      echo "<div class='alert alert-success border-0 rounded-3'>Update Success</div>";
                  }
              } catch (Exception $e) {
                  echo "<div class='alert alert-danger border-0 rounded-3'>Error: ".$e->getMessage()."</div>";
              }

          }

          // Query for select one record
          $data = $conn->query("SELECT * FROM subscriptions WHERE id = '$id'");
          $row = $data->fetch_object();
      ?>

      <form action="" method="post">
        <div class="card-jp">
          <div class="card-header">Subscription Update Form</div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Employer <span class="text-danger">*</span></label>
                <select name="user_id" class="form-select" required>
                  <option value="">Select Employer</option>
                  <?php
                  $list = $conn->query("SELECT id, name FROM users WHERE role = 'employer'");
                  while($item = $list->fetch_assoc()){
                  ?>
                  <option value="<?php echo $item['id']; ?>" <?php if($row->user_id == $item['id']) echo 'selected'; ?>><?php echo $item['name']; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Package <span class="text-danger">*</span></label>
                <select name="package_id" class="form-select" required>
                  <option value="">Select Package</option>
                  <?php
                  $list = $conn->query("SELECT id, name FROM packages");
                  while($item = $list->fetch_assoc()){
                  ?>
                  <option value="<?php echo $item['id']; ?>" <?php if($row->package_id == $item['id']) echo 'selected'; ?>><?php echo $item['name']; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Posts Left <span class="text-danger">*</span></label>
                <input type="number" name="posts_left" class="form-control" min="0" placeholder="Enter Posts Left" value="<?php echo $row->posts_left; ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="pending" <?php if($row->status == 'pending') echo 'selected'; ?>>Pending</option>
                  <option value="active" <?php if($row->status == 'active') echo 'selected'; ?>>Active</option>
                  <option value="expired" <?php if($row->status == 'expired') echo 'selected'; ?>>Expired</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?php echo $row->start_date; ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo $row->end_date; ?>">
              </div>

              <div class="col-12">
                <input type="submit" name="submit" value="UPDATE" class="btn btn-primary px-4">
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
<script src="../../assets/js/main.js"></script>
</body>
</html>
