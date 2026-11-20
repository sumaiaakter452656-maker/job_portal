<?php
include('include/check.php');
include('../dbconfig.php');

// সব job application: কে, কোন job-এ, কোন company-তে apply করেছে
$apps = $conn->query("SELECT job_applications.*, jobs.id AS job_id, jobs.title, companies.name AS company_name,
                             users.name AS seeker_name, users.email AS seeker_email
                      FROM job_applications
                      JOIN jobs ON jobs.id = job_applications.job_id
                      JOIN companies ON companies.id = jobs.company_id
                      JOIN seekers ON seekers.id = job_applications.seeker_id
                      JOIN users ON users.id = seekers.user_id
                      ORDER BY job_applications.id DESC");

// status অনুযায়ী badge-এর রং
$colors = array('applied' => 'badge-gray', 'viewed' => 'badge-info', 'shortlisted' => 'badge-primary',
                'interview' => 'badge-warning', 'hired' => 'badge-success', 'rejected' => 'badge-danger');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applicants | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions"><div><h2>Applicants</h2><p>Every job application on the portal.</p></div></div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>#</th><th>Applicant</th><th>Job</th><th>Company</th><th>Applied on</th><th>Status</th><th>CV</th></tr></thead>
        <tbody>
        <?php
        if ($apps->num_rows == 0) {
          echo '<tr><td colspan="7" class="muted">No applications yet.</td></tr>';
        }
        while ($row = $apps->fetch_assoc()) {
        ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><strong><?php echo $row['seeker_name']; ?></strong><br><small class="muted"><?php echo $row['seeker_email']; ?></small></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['company_name']; ?></td>
            <td><?php echo date('d M Y', strtotime($row['applied_at'])); ?></td>
            <td><span class="badge <?php echo $colors[$row['status']]; ?>"><?php echo ucfirst($row['status']); ?></span></td>
            <td><a href="../uploads/cv/<?php echo $row['resume_file']; ?>" target="_blank"><?php echo $row['resume_file']; ?></a></td>
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
