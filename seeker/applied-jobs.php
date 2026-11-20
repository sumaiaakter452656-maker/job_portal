<?php
include('include/check.php');
$pageTitle = 'Applied Jobs';

// Filter by status (e.g. ?status=shortlisted)
$status = isset($_GET['status']) ? $_GET['status'] : '';

$where = "WHERE job_applications.seeker_id = $seekerId";
if ($status == 'shortlisted') {
  // "shortlisted" also shows interview and hired
  $where .= " AND job_applications.status IN ('shortlisted','interview','hired')";
} else if (isset($statusLabel[$status])) {
  $where .= " AND job_applications.status = '$status'";
}

$apps = $conn->query("SELECT job_applications.*, jobs.id AS job_id, jobs.title, jobs.deadline,
                             companies.id AS company_id, companies.name AS company_name, cities.name AS city_name
                      FROM job_applications
                      JOIN jobs ON jobs.id = job_applications.job_id
                      JOIN companies ON companies.id = jobs.company_id
                      LEFT JOIN cities ON cities.id = jobs.city_id
                      $where
                      ORDER BY job_applications.applied_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applied Jobs | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Applied jobs</h2><p>Where you applied and what the employer decided.</p></div>
    <form action="" method="get">
      <select class="form-control" name="status" style="width:auto" onchange="this.form.submit()">
        <option value="">All status</option>
        <?php foreach ($statusLabel as $key => $label) { ?>
          <option value="<?php echo $key; ?>" <?php if ($status == $key) echo 'selected'; ?>><?php echo $label; ?></option>
        <?php } ?>
      </select>
    </form>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Job</th><th>Company</th><th>Applied on</th><th>Status</th><th>What it means</th></tr></thead>
        <tbody>
        <?php if ($apps->num_rows == 0) { ?>
          <tr><td colspan="5" class="muted">No applications found. <a href="../jobs.php">Find jobs</a></td></tr>
        <?php } ?>
        <?php while ($a = $apps->fetch_assoc()) { ?>
          <tr>
            <td><strong><a href="../job-details.php?id=<?php echo $a['job_id']; ?>"><?php echo $a['title']; ?></a></strong><br><small class="muted"><?php echo $a['city_name']; ?></small></td>
            <td><a href="../companies.php?id=<?php echo $a['company_id']; ?>"><?php echo $a['company_name']; ?></a></td>
            <td><?php echo date('d M Y', strtotime($a['applied_at'])); ?></td>
            <td><span class="badge badge-dot <?php echo $statusColor[$a['status']]; ?>"><?php echo $statusLabel[$a['status']]; ?></span></td>
            <td class="small">
              <?php
              if ($a['status'] == 'applied')     echo 'Waiting for the employer to check your CV.';
              if ($a['status'] == 'viewed')      echo $a['company_name'] . ' has viewed your CV.';
              if ($a['status'] == 'shortlisted') echo '<b>' . $a['company_name'] . ' shortlisted you!</b>';
              if ($a['status'] == 'interview')   echo '<b>' . $a['company_name'] . ' invited you for an interview.</b>';
              if ($a['status'] == 'hired')       echo '<b>Congratulations! ' . $a['company_name'] . ' hired you.</b>';
              if ($a['status'] == 'rejected')    echo 'Not selected this time.';
              ?>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
