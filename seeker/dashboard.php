<?php
include('include/check.php');
$pageTitle = 'My Dashboard';

// ===== সংখ্যাগুলো =====
$totalApplied = $conn->query("SELECT COUNT(*) AS c FROM job_applications WHERE seeker_id = $seekerId")->fetch_assoc()['c'];
$totalShort   = $conn->query("SELECT COUNT(*) AS c FROM job_applications WHERE seeker_id = $seekerId AND status IN ('shortlisted','interview','hired')")->fetch_assoc()['c'];
$totalSaved   = $conn->query("SELECT COUNT(*) AS c FROM saved_jobs WHERE seeker_id = $seekerId")->fetch_assoc()['c'];

// ===== কে কে shortlist করেছে (shortlisted / interview / hired) =====
$shortlisted = $conn->query("SELECT job_applications.*, jobs.id AS job_id, jobs.title, companies.name AS company_name
                             FROM job_applications
                             JOIN jobs ON jobs.id = job_applications.job_id
                             JOIN companies ON companies.id = jobs.company_id
                             WHERE job_applications.seeker_id = $seekerId
                               AND job_applications.status IN ('shortlisted','interview','hired')
                             ORDER BY job_applications.applied_at DESC");

// ===== সাম্প্রতিক ৫টা application =====
$recent = $conn->query("SELECT job_applications.*, jobs.id AS job_id, jobs.title, companies.name AS company_name
                        FROM job_applications
                        JOIN jobs ON jobs.id = job_applications.job_id
                        JOIN companies ON companies.id = jobs.company_id
                        WHERE job_applications.seeker_id = $seekerId
                        ORDER BY job_applications.applied_at DESC LIMIT 5");

// ===== Notification =====
$notes = $conn->query("SELECT * FROM notifications WHERE user_id = $userId ORDER BY created_at DESC LIMIT 5");

// ===== Recommended Jobs: আমার category-র job, যেগুলোতে এখনো apply করিনি =====
$myCat = (int)$me['category_id'];
$recommended = $conn->query("SELECT jobs.*, companies.name AS company_name, companies.logo,
                                    cities.name AS city_name, categories.name AS category_name
                             FROM jobs
                             JOIN companies ON companies.id = jobs.company_id
                             LEFT JOIN cities ON cities.id = jobs.city_id
                             LEFT JOIN categories ON categories.id = jobs.category_id
                             WHERE jobs.status = 'approved' AND jobs.deadline >= CURDATE()
                               AND jobs.category_id = $myCat
                               AND jobs.id NOT IN (SELECT job_id FROM job_applications WHERE seeker_id = $seekerId)
                             ORDER BY jobs.id DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Dashboard | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Hello, <?php echo $parts[0]; ?> 👋</h2><p>Let's find your next opportunity.</p></div>
    <a href="../jobs.php" class="btn btn-primary">Browse Jobs</a>
  </div>

  <!-- সংখ্যা -->
  <div class="grid grid-3 mb-3">
    <a href="applied-jobs.php" class="stat-card"><div class="stat-icon teal">📄</div><div><h3><?php echo $totalApplied; ?></h3><p>Applied jobs</p></div></a>
    <a href="applied-jobs.php?status=shortlisted" class="stat-card"><div class="stat-icon amber">⭐</div><div><h3><?php echo $totalShort; ?></h3><p>Shortlisted</p></div></a>
    <a href="saved-jobs.php" class="stat-card"><div class="stat-icon rose">♥</div><div><h3><?php echo $totalSaved; ?></h3><p>Saved jobs</p></div></a>
  </div>

  <!-- কে কে shortlist করেছে -->
  <div class="card mb-3">
    <div class="card-header"><h3>Who shortlisted you</h3></div>
    <div class="card-body">
      <?php if ($shortlisted->num_rows == 0) { ?>
        <p class="muted mb-0">No one has shortlisted you yet. Keep applying!</p>
      <?php } ?>
      <?php while ($s = $shortlisted->fetch_assoc()) { ?>
        <div class="list-item">
          <span class="avatar sm"><?php echo strtoupper(substr($s['company_name'], 0, 2)); ?></span>
          <div class="list-item-body">
            <strong><?php echo $s['company_name']; ?></strong>
            <?php if ($s['status'] == 'interview') { ?>
              invited you for an <b>interview</b> for
            <?php } else if ($s['status'] == 'hired') { ?>
              <b>hired</b> you for
            <?php } else { ?>
              <b>shortlisted</b> you for
            <?php } ?>
            <a href="../job-details.php?id=<?php echo $s['job_id']; ?>"><?php echo $s['title']; ?></a>
          </div>
          <span class="badge <?php echo $statusColor[$s['status']]; ?>"><?php echo $statusLabel[$s['status']]; ?></span>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="dash-grid mb-3">
    <!-- সাম্প্রতিক application -->
    <div class="card">
      <div class="card-header"><h3>Recent applications</h3><a href="applied-jobs.php" class="btn btn-sm btn-light">View all</a></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Job</th><th>Applied</th><th>Status</th></tr></thead>
          <tbody>
          <?php if ($recent->num_rows == 0) { ?>
            <tr><td colspan="3" class="muted">You have not applied to any job yet.</td></tr>
          <?php } ?>
          <?php while ($a = $recent->fetch_assoc()) { ?>
            <tr>
              <td><div class="cell-user"><span class="company-logo sm" style="background:#0f766e"><?php echo strtoupper(substr($a['company_name'], 0, 2)); ?></span>
                <div><strong><?php echo $a['title']; ?></strong><small><?php echo $a['company_name']; ?></small></div></div></td>
              <td><?php echo date('d M Y', strtotime($a['applied_at'])); ?></td>
              <td><span class="badge badge-dot <?php echo $statusColor[$a['status']]; ?>"><?php echo $statusLabel[$a['status']]; ?></span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Notification -->
    <div class="card">
      <div class="card-header"><h3>Notifications</h3></div>
      <div class="card-body">
        <?php if ($notes->num_rows == 0) { ?><p class="muted mb-0">No notifications.</p><?php } ?>
        <?php while ($n = $notes->fetch_assoc()) { ?>
          <div class="list-item">
            <div class="list-item-body">
              <?php if (!$n['is_read']) echo '<b>'; ?><?php echo $n['message']; ?><?php if (!$n['is_read']) echo '</b>'; ?>
              <br><small class="muted"><?php echo date('d M Y', strtotime($n['created_at'])); ?></small>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- Recommended -->
  <?php if ($recommended->num_rows > 0) { ?>
    <div class="section-head"><div><h2>Recommended for you</h2><p class="muted">Jobs in <?php echo $me['category_name']; ?> you have not applied to yet.</p></div></div>
    <div class="grid grid-3">
      <?php while ($row = $recommended->fetch_assoc()) { ?>
        <div class="job-card" style="cursor:pointer" onclick="location.href='../job-details.php?id=<?php echo $row['id']; ?>'">
          <div class="job-card-head">
            <div class="company-logo" style="background:#0f766e"><?php echo strtoupper(substr($row['company_name'], 0, 2)); ?></div>
            <div class="job-card-info">
              <h3><a href="../job-details.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h3>
              <p class="muted"><?php echo $row['company_name']; ?> · <?php echo $row['city_name']; ?></p>
            </div>
          </div>
          <div class="job-card-foot">
            <small class="muted">Deadline: <?php echo date('d M Y', strtotime($row['deadline'])); ?></small>
            <a class="btn btn-sm btn-outline" href="../job-details.php?id=<?php echo $row['id']; ?>">View</a>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

</main>
<footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
