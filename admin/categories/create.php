<?php
include('../include/check.php');
include('../../dbconfig.php');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string(trim($_POST['name']));
  $slug = strtolower(str_replace(" ", "-", $name));

  if ($name != '') {
    $conn->query("INSERT INTO categories (name, slug) VALUES ('$name', '$slug')");
    if ($conn->affected_rows > 0) {
      $msg = 'Category Created Successfully';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Category | Admin | JobHub</title>
  <link rel="stylesheet" href="../../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include("../include/leftbar.php"); ?>
<?php include("../include/header.php"); ?>
<main class="dash-content">
  <div class="page-actions">
    <div><h2>New category</h2><p>Add a job category.</p></div>
    <a class="btn btn-light" href="index.php">Back</a>
  </div>

  <?php if ($msg != '') { ?><div class="alert alert-success"><span><?php echo $msg; ?></span></div><?php } ?>

  <form class="card" action="" method="post" style="max-width:520px">
    <div class="card-body">
      <div class="form-group"><label class="form-label">Category Name <span class="req">*</span></label><input class="form-control" type="text" name="name" required></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Save</button></div>
    </div>
  </form>
</main>
<?php include("../include/footer.php"); ?>
</div>
<script src="../../assets/js/main.js"></script>
</body>
</html>
