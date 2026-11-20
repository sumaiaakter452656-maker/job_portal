<?php
include('include/check.php');
include('../dbconfig.php');

// ===== Approve / Reject / Close =====
$actions = array('approve' => 'approved', 'reject' => 'rejected', 'close' => 'closed');
foreach ($actions as $key => $newStatus) {
  if (isset($_GET[$key])) {
    $jid = (int)$_GET[$key];
    $conn->query("UPDATE jobs SET status = '$newStatus' WHERE id = $jid");

   
    $j = $conn->query("SELECT jobs.title, companies.user_id FROM jobs JOIN companies ON companies.id = jobs.company_id WHERE jobs.id = $jid")->fetch_assoc();
    if ($j) {
      $msg = $conn->real_escape_string('Your job "' . $j['title'] . '" was ' . $newStatus . ' by admin');
      $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$j['user_id']}, '$msg')");
    }
    header("Location: jobs.php?status=" . (isset($_GET['status']) ? $_GET['status'] : ''));
    exit;
  }
}


$status = isset($_GET['status']) ? $_GET['status'] : '';
$where = '';
if ($status == 'pending' || $status == 'approved' || $status == 'rejected' || $status == 'closed') {
  $where = "WHERE jobs.status = '$status'";
}

$jobs = $conn->query("SELECT jobs.*, companies.name AS company_name,
                             (SELECT COUNT(*) FROM job_applications WHERE job_applications.job_id = jobs.id) AS total_apps
                      FROM jobs JOIN companies ON companies.id = jobs.company_id
                      $where ORDER BY jobs.id DESC");

$jobColor = array('pending' => 'badge-warning', 'approved' => 'badge-success', 'rejected' => 'badge-danger', 'closed' => 'badge-gray');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jobs | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions"><div><h2>Jobs</h2><p>Approve new jobs before they appear on the website.</p></div></div>

  <div class="tabs mb-2">
    <a class="tab-btn <?php if ($status == '') echo 'active'; ?>" href="jobs.php">All</a>
    <a class="tab-btn <?php if ($status == 'pending') echo 'active'; ?>" href="jobs.php?status=pending">Pending</a>
    <a class="tab-btn <?php if ($status == 'approved') echo 'active'; ?>" href="jobs.php?status=approved">Approved</a>
    <a class="tab-btn <?php if ($status == 'rejected') echo 'active'; ?>" href="jobs.php?status=rejected">Rejected</a>
    <a class="tab-btn <?php if ($status == 'closed') echo 'active'; ?>" href="jobs.php?status=closed">Closed</a>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Job</th><th>Company</th><th>Deadline</th><th>Applicants</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($jobs->num_rows == 0) { ?><tr><td colspan="6" class="muted">No jobs found.</td></tr><?php } ?>
        <?php while ($j = $jobs->fetch_assoc()) { ?>
          <tr>
            <td><strong><?php echo $j['title']; ?></strong></td>
            <td><?php echo $j['company_name']; ?></td>
            <td><?php echo date('d M Y', strtotime($j['deadline'])); ?></td>
            <td><?php echo $j['total_apps']; ?></td>
            <td><span class="badge <?php echo $jobColor[$j['status']]; ?>"><?php echo ucfirst($j['status']); ?></span></td>
            <td><div class="actions">
              <?php if ($j['status'] != 'approved') { ?><a class="btn btn-sm btn-primary" href="jobs.php?approve=<?php echo $j['id']; ?>&status=<?php echo $status; ?>">Approve</a><?php } ?>
              <?php if ($j['status'] == 'pending') { ?><a class="btn btn-sm btn-light" href="jobs.php?reject=<?php echo $j['id']; ?>&status=<?php echo $status; ?>">Reject</a><?php } ?>
              <?php if ($j['status'] == 'approved') { ?><a class="btn btn-sm btn-light" href="jobs.php?close=<?php echo $j['id']; ?>&status=<?php echo $status; ?>">Close</a><?php } ?>
            </div></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
