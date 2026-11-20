<?php
include('include/check.php');
$pageTitle = 'Employer Dashboard';

// ===== সংখ্যাগুলো (শুধু আমার company-র) =====
$activeJobs  = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE company_id = $companyId AND status = 'approved' AND deadline >= CURDATE()")->fetch_assoc()['c'];
$pendingJobs = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE company_id = $companyId AND status = 'pending'")->fetch_assoc()['c'];
$totalApps   = $conn->query("SELECT COUNT(*) AS c FROM job_applications JOIN jobs ON jobs.id = job_applications.job_id WHERE jobs.company_id = $companyId")->fetch_assoc()['c'];
$shortApps   = $conn->query("SELECT COUNT(*) AS c FROM job_applications JOIN jobs ON jobs.id = job_applications.job_id WHERE jobs.company_id = $companyId AND job_applications.status IN ('shortlisted','interview','hired')")->fetch_assoc()['c'];

// সাম্প্রতিক ৫ জন applicant
$recent = $conn->query("SELECT job_applications.*, jobs.title, users.name, users.email
                        FROM job_applications
                        JOIN jobs ON jobs.id = job_applications.job_id
                        JOIN seekers ON seekers.id = job_applications.seeker_id
                        JOIN users ON users.id = seekers.user_id
                        WHERE jobs.company_id = $companyId
                        ORDER BY job_applications.applied_at DESC LIMIT 5");

// আমার সর্বশেষ ৫টা job
$myJobs = $conn->query("SELECT jobs.*, (SELECT COUNT(*) FROM job_applications WHERE job_applications.job_id = jobs.id) AS total_apps
                        FROM jobs WHERE company_id = $companyId ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employer Dashboard | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Welcome back, <?php echo $company['name']; ?> 👋</h2><p>Here's what's happening with your jobs.</p></div>
    <div class="flex gap-2">
      <a href="subscription.php" class="btn btn-light">💳 Buy Package</a>
      <a href="post-job.php" class="btn btn-primary">+ Post a Job</a>
    </div>
  </div>

  <div class="grid grid-4 mb-3">
    <a href="manage-jobs.php" class="stat-card"><div class="stat-icon teal"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div><div><h3><?php echo $activeJobs; ?></h3><p>Live jobs</p><?php if ($pendingJobs > 0) { ?><span class="stat-trend"><?php echo $pendingJobs; ?> waiting for approval</span><?php } ?></div></a>
    <a href="applicants.php" class="stat-card"><div class="stat-icon blue"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><div><h3><?php echo $totalApps; ?></h3><p>Total applicants</p></div></a>
    <a href="applicants.php?status=shortlisted" class="stat-card"><div class="stat-icon amber"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.89"/></svg></div><div><h3><?php echo $shortApps; ?></h3><p>Shortlisted</p></div></a>
    <a href="subscription.php" class="stat-card"><div class="stat-icon rose"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
      <div>
        <?php if ($sub) { ?>
          <h3><?php echo $sub['posts_left']; ?></h3><p>Posts left (<?php echo $sub['package_name']; ?>)</p>
          <span class="stat-trend">Valid till <?php echo date('d M Y', strtotime($sub['end_date'])); ?></span>
        <?php } else { ?>
          <h3>0</h3><p>No active package</p><span class="stat-trend">Buy a package →</span>
        <?php } ?>
      </div>
    </a>
  </div>

  <div class="dash-grid">
    <div class="card">
      <div class="card-header"><h3>Recent applicants</h3><a href="applicants.php" class="btn btn-sm btn-light">View all</a></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Candidate</th><th>Applied for</th><th>Date</th><th>Status</th></tr></thead>
          <tbody>
          <?php if ($recent->num_rows == 0) { ?>
            <tr><td colspan="4" class="muted">No applicants yet.</td></tr>
          <?php } ?>
          <?php while ($a = $recent->fetch_assoc()) { ?>
            <tr>
              <td><div class="cell-user"><span class="avatar sm"><?php echo strtoupper(substr($a['name'], 0, 2)); ?></span><div><strong><?php echo $a['name']; ?></strong><small><?php echo $a['email']; ?></small></div></div></td>
              <td><?php echo $a['title']; ?></td>
              <td><?php echo date('d M Y', strtotime($a['applied_at'])); ?></td>
              <td><span class="badge badge-dot <?php echo $statusColor[$a['status']]; ?>"><?php echo $statusLabel[$a['status']]; ?></span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3>My jobs</h3><a href="manage-jobs.php" class="btn btn-sm btn-light">Manage</a></div>
      <div class="card-body">
        <?php if ($myJobs->num_rows == 0) { ?><p class="muted mb-0">No jobs yet. <a href="post-job.php">Post your first job</a></p><?php } ?>
        <?php while ($j = $myJobs->fetch_assoc()) { ?>
          <div class="list-item">
            <div class="list-item-body">
              <strong><?php echo $j['title']; ?></strong><br>
              <small class="muted"><?php echo $j['total_apps']; ?> applicants · Deadline <?php echo date('d M', strtotime($j['deadline'])); ?></small>
            </div>
            <span class="badge <?php echo $jobColor[$j['status']]; ?>"><?php echo ucfirst($j['status']); ?></span>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
