<?php
include('../include/check.php');
include('../../dbconfig.php');

// All categories, with how many jobs each has
$rawData = $conn->query("SELECT categories.*, COUNT(jobs.id) AS total_jobs
                         FROM categories LEFT JOIN jobs ON jobs.category_id = categories.id
                         GROUP BY categories.id ORDER BY categories.name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories | Admin | JobHub</title>
  <link rel="stylesheet" href="../../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include("../include/leftbar.php"); ?>
<?php include("../include/header.php"); ?>
<main class="dash-content">
  <div class="page-actions">
    <div><h2>Categories</h2><p>Job categories used in job posts and search.</p></div>
    <a class="btn btn-primary" href="create.php">+ New Category</a>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead><tr><th>ID</th><th>Category Name</th><th>Slug</th><th>Jobs</th><th>Action</th></tr></thead>
        <tbody>
        <?php while ($row = $rawData->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><strong><?php echo $row['name']; ?></strong></td>
            <td><?php echo $row['slug']; ?></td>
            <td><span class="badge badge-primary"><?php echo $row['total_jobs']; ?></span></td>
            <td><div class="actions">
              <a class="btn btn-sm btn-light" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
              <a class="btn btn-sm btn-light" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
            </div></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>
<?php include("../include/footer.php"); ?>
</div>
<script src="../../assets/js/main.js"></script>
</body>
</html>
