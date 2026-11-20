<?php
include('include/check.php');
$pageTitle = 'Manage Jobs';

// ===== Close / Delete (শুধু নিজের company-র job) =====
if (isset($_GET['close'])) {
  $jid = (int)$_GET['close'];
  $conn->query("UPDATE jobs SET status = 'closed' WHERE id = $jid AND company_id = $companyId");
  header("Location: manage-jobs.php");
  exit;
}
if (isset($_GET['delete'])) {
  $jid = (int)$_GET['delete'];
  $conn->query("DELETE FROM jobs WHERE id = $jid AND company_id = $companyId");
  header("Location: manage-jobs.php");
  exit;
}

// আমার সব job, সাথে কতজন apply করেছে
$jobs = $conn->query("SELECT jobs.*, cities.name AS city_name,
                             (SELECT COUNT(*) FROM job_applications WHERE job_applications.job_id = jobs.id) AS total_apps
                      FROM jobs
                      LEFT JOIN cities ON cities.id = jobs.city_id
                      WHERE jobs.company_id = $companyId
                      ORDER BY jobs.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Jobs | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>My jobs</h2><p>All jobs posted by <?php echo $company['name']; ?>.</p></div>
    <a href="post-job.php" class="btn btn-primary">+ Post a Job</a>
  </div>

  <?php if (isset($_GET['posted'])) { ?>
    <div class="alert alert-success"><span>Job submitted! It will be shown on the website after admin approval.</span></div>
  <?php } ?>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Job</th><th>Applicants</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($jobs->num_rows == 0) { ?>
          <tr><td colspan="5" class="muted">You have not posted any job yet. <a href="post-job.php">Post a job</a></td></tr>
        <?php } ?>
        <?php while ($j = $jobs->fetch_assoc()) {
          $expired = strtotime($j['deadline']) < strtotime(date('Y-m-d'));
        ?>
          <tr>
            <td><strong><?php echo $j['title']; ?></strong><br>
              <small class="muted"><?php echo $j['city_name']; ?> · <?php echo ucwords(str_replace('_', ' ', $j['job_type'])); ?></small></td>
            <td><a href="applicants.php?job=<?php echo $j['id']; ?>"><?php echo $j['total_apps']; ?> applicants</a></td>
            <td><?php echo date('d M Y', strtotime($j['deadline'])); ?><?php if ($expired) echo '<br><small class="muted">Expired</small>'; ?></td>
            <td><span class="badge <?php echo $jobColor[$j['status']]; ?>"><?php echo ucfirst($j['status']); ?></span></td>
            <td>
              <div class="actions">
                <?php if ($j['status'] == 'approved' && !$expired) { ?>
                  <a class="btn btn-sm btn-light" href="../job-details.php?id=<?php echo $j['id']; ?>" target="_blank">View</a>
                <?php } ?>
                <a class="btn btn-sm btn-light" href="post-job.php?id=<?php echo $j['id']; ?>">Edit</a>
                <?php if ($j['status'] != 'closed') { ?>
                  <a class="btn btn-sm btn-light" href="manage-jobs.php?close=<?php echo $j['id']; ?>" onclick="return confirm('Close this job? It will be hidden from the website.')">Close</a>
                <?php } ?>
                <a class="btn btn-sm btn-light" href="manage-jobs.php?delete=<?php echo $j['id']; ?>" onclick="return confirm('Delete this job and all its applications?')">Delete</a>
              </div>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
