<?php
include('include/check.php');
$pageTitle = 'Applicants';

// ===== Status বদলানো (Shortlist / Interview / Hire / Reject) =====
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $appId  = (int)$_POST['app_id'];
  $status = $_POST['status'];

  if (isset($statusLabel[$status])) {
    // application টা আমার company-র job-এর কিনা যাচাই
    $app = $conn->query("SELECT job_applications.*, jobs.title, seekers.user_id AS seeker_user
                         FROM job_applications
                         JOIN jobs ON jobs.id = job_applications.job_id
                         JOIN seekers ON seekers.id = job_applications.seeker_id
                         WHERE job_applications.id = $appId AND jobs.company_id = $companyId")->fetch_assoc();
    if ($app) {
      $conn->query("UPDATE job_applications SET status = '$status' WHERE id = $appId");

      // Seeker-কে notification
      $messages = array(
        'viewed'      => $company['name'] . ' viewed your application for ' . $app['title'],
        'shortlisted' => $company['name'] . ' shortlisted you for ' . $app['title'],
        'interview'   => $company['name'] . ' invited you for an interview for ' . $app['title'],
        'hired'       => 'Congratulations! ' . $company['name'] . ' hired you for ' . $app['title'],
        'rejected'    => 'Your application for ' . $app['title'] . ' was not selected',
      );
      if (isset($messages[$status])) {
        $msg = $conn->real_escape_string($messages[$status]);
        $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$app['seeker_user']}, '$msg')");
      }
    }
  }
  header("Location: applicants.php?" . ($_SERVER['QUERY_STRING'] ?? ''));
  exit;
}

// ===== Filter: কোন job, কোন status =====
$jobFilter = isset($_GET['job']) ? (int)$_GET['job'] : 0;
$status    = isset($_GET['status']) ? $_GET['status'] : '';

$where = "WHERE jobs.company_id = $companyId";
if ($jobFilter) {
  $where .= " AND jobs.id = $jobFilter";
}
if ($status == 'shortlisted') {
  $where .= " AND job_applications.status IN ('shortlisted','interview','hired')";
} else if (isset($statusLabel[$status])) {
  $where .= " AND job_applications.status = '$status'";
}

$apps = $conn->query("SELECT job_applications.*, jobs.title,
                             users.name, users.email, users.phone,
                             seekers.headline, seekers.experience_years, seekers.expected_salary, cities.name AS city_name
                      FROM job_applications
                      JOIN jobs ON jobs.id = job_applications.job_id
                      JOIN seekers ON seekers.id = job_applications.seeker_id
                      JOIN users ON users.id = seekers.user_id
                      LEFT JOIN cities ON cities.id = seekers.city_id
                      $where
                      ORDER BY job_applications.applied_at DESC");

$myJobs = $conn->query("SELECT id, title FROM jobs WHERE company_id = $companyId ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applicants | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Applicants</h2><p>Review candidates, shortlist them and send emails.</p></div>
    <form action="" method="get" class="flex gap-2">
      <select class="form-control" name="job" style="width:auto" onchange="this.form.submit()">
        <option value="">All jobs</option>
        <?php while ($j = $myJobs->fetch_assoc()) { ?>
          <option value="<?php echo $j['id']; ?>" <?php if ($jobFilter == $j['id']) echo 'selected'; ?>><?php echo $j['title']; ?></option>
        <?php } ?>
      </select>
      <select class="form-control" name="status" style="width:auto" onchange="this.form.submit()">
        <option value="">All status</option>
        <?php foreach ($statusLabel as $key => $label) { ?>
          <option value="<?php echo $key; ?>" <?php if ($status == $key) echo 'selected'; ?>><?php echo $label; ?></option>
        <?php } ?>
      </select>
    </form>
  </div>

  <?php if (isset($_GET['sent'])) { ?>
    <div class="alert alert-success"><span>Email sent and the candidate got a notification.</span></div>
  <?php } ?>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>Candidate</th><th>Applied for</th><th>Date</th><th>Status</th><th>Change status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($apps->num_rows == 0) { ?>
          <tr><td colspan="6" class="muted">No applicants found.</td></tr>
        <?php } ?>
        <?php while ($a = $apps->fetch_assoc()) { ?>
          <tr>
            <td>
              <div class="cell-user"><span class="avatar sm"><?php echo strtoupper(substr($a['name'], 0, 2)); ?></span>
                <div><strong><?php echo $a['name']; ?></strong><small><?php echo $a['email']; ?><?php if ($a['phone']) echo ' · ' . $a['phone']; ?></small></div></div>
              <small class="muted">
                <?php echo $a['headline'] ? $a['headline'] : 'No headline'; ?>
                · <?php echo $a['experience_years']; ?> yrs exp
                <?php if ($a['expected_salary']) echo ' · expects ৳' . number_format($a['expected_salary']); ?>
                <?php if ($a['city_name']) echo ' · ' . $a['city_name']; ?>
              </small>
            </td>
            <td><?php echo $a['title']; ?></td>
            <td><?php echo date('d M Y', strtotime($a['applied_at'])); ?></td>
            <td><span class="badge badge-dot <?php echo $statusColor[$a['status']]; ?>"><?php echo $statusLabel[$a['status']]; ?></span></td>
            <td>
              <form action="" method="post" class="flex gap-1">
                <input type="hidden" name="app_id" value="<?php echo $a['id']; ?>">
                <select class="form-control" name="status" style="width:auto">
                  <?php foreach ($statusLabel as $key => $label) { ?>
                    <option value="<?php echo $key; ?>" <?php if ($a['status'] == $key) echo 'selected'; ?>><?php echo $label; ?></option>
                  <?php } ?>
                </select>
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
              </form>
            </td>
            <td>
              <div class="actions">
                <a class="btn btn-sm btn-light" href="../<?php echo $a['resume_file']; ?>" target="_blank" download>CV</a>
                <a class="btn btn-sm btn-outline" href="email.php?app=<?php echo $a['id']; ?>">Email</a>
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
