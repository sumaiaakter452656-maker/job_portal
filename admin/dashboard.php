<?php
include('include/check.php');
include('../dbconfig.php');

// দিনে একবার মেয়াদ শেষ job/package বন্ধ; "Run now" চাপলে এখনই
include('../auto-expire.php');
$expireResult = run_auto_expire($conn, isset($_GET['run_expire']));


// ===== সংখ্যাগুলো database থেকে =====
$totalSeekers   = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role = 'seeker'")->fetch_assoc()['c'];
$totalEmployers = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role = 'employer'")->fetch_assoc()['c'];
$liveJobs       = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()")->fetch_assoc()['c'];
$totalApps      = $conn->query("SELECT COUNT(*) AS c FROM job_applications")->fetch_assoc()['c'];
$pendingJobs    = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE status = 'pending'")->fetch_assoc()['c'];

// সর্বশেষ ৬টা job
$latestJobs = $conn->query("SELECT jobs.*, companies.name AS company_name FROM jobs
                            JOIN companies ON companies.id = jobs.company_id
                            ORDER BY jobs.id DESC LIMIT 6");

// নতুন ৫ জন user
$newUsers = $conn->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");

$jobColor = array('pending' => 'badge-warning', 'approved' => 'badge-success', 'rejected' => 'badge-danger', 'closed' => 'badge-gray');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<!-- ================= SIDEBAR (Admin) ================= -->
 <?php include('include/leftbar.php'); ?>

  <!-- ================= TOPBAR ================= -->
   <?php include('include/header.php'); ?>
  <main class="dash-content">
    <div class="page-actions"><div><h2>Admin overview</h2><p>Platform activity at a glance.</p></div>
      <a class="btn btn-light" href="dashboard.php?run_expire=1">⟳ Run expiry check now</a></div>
    <?php if ($expireResult !== null) { ?>
      <div class="alert alert-info"><span>Expiry check done: <?php echo $expireResult['jobs']; ?> job(s) closed, <?php echo $expireResult['packages']; ?> package(s) expired.</span><button class="alert-close">&times;</button></div>
    <?php } ?>

    <div class="grid grid-4 mb-3">
      <div class="stat-card"><div class="stat-icon teal"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><div><h3><?php echo $totalSeekers; ?></h3><p>Job seekers</p></div></div>
      <div class="stat-card"><div class="stat-icon blue"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg></div><div><h3><?php echo $totalEmployers; ?></h3><p>Employers</p></div></div>
      <div class="stat-card"><div class="stat-icon amber"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div><div><h3><?php echo $liveJobs; ?></h3><p>Live jobs</p></div></div>
      <div class="stat-card"><div class="stat-icon rose"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div><div><h3><?php echo $totalApps; ?></h3><p>Applications</p></div></div>
    </div>

    <div class="dash-grid">
      <!-- সর্বশেষ job -->
      <div class="card">
        <div class="card-header"><h3>Latest jobs</h3><a href="jobs.php?status=pending" class="badge badge-warning"><?php echo $pendingJobs; ?> pending</a></div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Job</th><th>Deadline</th><th>Status</th></tr></thead>
            <tbody>
            <?php while ($j = $latestJobs->fetch_assoc()) { ?>
              <tr>
                <td><div class="cell-user"><span class="company-logo sm" style="background:#0f766e"><?php echo strtoupper(substr($j['company_name'], 0, 2)); ?></span>
                  <div><strong><?php echo $j['title']; ?></strong><small><?php echo $j['company_name']; ?></small></div></div></td>
                <td><?php echo date('d M Y', strtotime($j['deadline'])); ?></td>
                <td><span class="badge <?php echo $jobColor[$j['status']]; ?>"><?php echo ucfirst($j['status']); ?></span></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- নতুন user -->
      <div class="card">
        <div class="card-header"><h3>New users</h3><a href="users.php" class="btn btn-sm btn-light">All users</a></div>
        <div class="card-body">
          <?php while ($u = $newUsers->fetch_assoc()) { ?>
            <div class="list-item">
              <span class="avatar sm"><?php echo strtoupper(substr($u['name'], 0, 2)); ?></span>
              <div class="list-item-body"><strong><?php echo $u['name']; ?></strong><br><small class="muted"><?php echo ucfirst($u['role']); ?> · <?php echo $u['email']; ?></small></div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </main>
  <footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
