<?php
include('include/check.php');
$pageTitle = 'Saved Jobs';

// Saved list থেকে একটা job সরানো (?remove=job_id)
if (isset($_GET['remove'])) {
  $jobId = (int)$_GET['remove'];
  $conn->query("DELETE FROM saved_jobs WHERE seeker_id = $seekerId AND job_id = $jobId");
  header("Location: saved-jobs.php");
  exit;
}

$saved = $conn->query("SELECT jobs.*, companies.name AS company_name, cities.name AS city_name
                       FROM saved_jobs
                       JOIN jobs ON jobs.id = saved_jobs.job_id
                       JOIN companies ON companies.id = jobs.company_id
                       LEFT JOIN cities ON cities.id = jobs.city_id
                       WHERE saved_jobs.seeker_id = $seekerId
                       ORDER BY saved_jobs.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saved Jobs | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions"><div><h2>Saved jobs</h2><p>Jobs you bookmarked to apply later.</p></div></div>

  <?php if ($saved->num_rows == 0) { ?>
    <div class="card"><div class="card-body">You have no saved jobs. <a href="../jobs.php">Browse jobs</a></div></div>
  <?php } ?>

  <div class="grid grid-2">
    <?php while ($row = $saved->fetch_assoc()) {
      // deadline পার হয়ে গেছে কিনা
      $expired = strtotime($row['deadline']) < strtotime(date('Y-m-d'));
    ?>
      <div class="job-card">
        <div class="job-card-head">
          <div class="company-logo" style="background:#0f766e"><?php echo strtoupper(substr($row['company_name'], 0, 2)); ?></div>
          <div class="job-card-info">
            <h3>
              <?php if ($expired || $row['status'] != 'approved') { ?>
                <?php echo $row['title']; ?>
              <?php } else { ?>
                <a href="../job-details.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a>
              <?php } ?>
            </h3>
            <p class="muted"><?php echo $row['company_name']; ?> · <?php echo $row['city_name']; ?></p>
          </div>
        </div>
        <div class="job-card-foot">
          <?php if ($expired || $row['status'] != 'approved') { ?>
            <span class="badge badge-gray">Closed</span>
          <?php } else { ?>
            <small class="muted">Deadline: <?php echo date('d M Y', strtotime($row['deadline'])); ?></small>
          <?php } ?>
          <div>
            <a class="btn btn-sm btn-light" href="saved-jobs.php?remove=<?php echo $row['id']; ?>" onclick="return confirm('Remove from saved?')">Remove</a>
            <?php if (!$expired && $row['status'] == 'approved') { ?>
              <a class="btn btn-sm btn-outline" href="../job-details.php?id=<?php echo $row['id']; ?>">Apply Now</a>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</main>
<footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
