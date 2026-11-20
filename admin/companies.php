<?php
include('include/check.php');
include('../dbconfig.php');

$companies = $conn->query("SELECT companies.*, users.name AS owner, users.email, cities.name AS city_name,
                                  COUNT(jobs.id) AS total_jobs
                           FROM companies
                           JOIN users ON users.id = companies.user_id
                           LEFT JOIN cities ON cities.id = companies.city_id
                           LEFT JOIN jobs ON jobs.company_id = companies.id
                           GROUP BY companies.id
                           ORDER BY companies.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Companies | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions"><div><h2>Companies</h2><p>All employer company profiles.</p></div></div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>#</th><th>Company</th><th>Owner</th><th>City</th><th>Website</th><th>Jobs</th><th>Action</th></tr></thead>
        <tbody>
        <?php while ($row = $companies->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><strong><?php echo $row['name']; ?></strong><br><small class="muted"><?php echo $row['address']; ?></small></td>
            <td><?php echo $row['owner']; ?><br><small class="muted"><?php echo $row['email']; ?></small></td>
            <td><?php echo $row['city_name']; ?></td>
            <td><?php echo $row['website'] ? $row['website'] : '-'; ?></td>
            <td><span class="badge badge-primary"><?php echo $row['total_jobs']; ?></span></td>
            <td><a class="btn btn-sm btn-light" href="../companies.php?id=<?php echo $row['id']; ?>" target="_blank">View profile</a></td>
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
