<?php
include('../include/check.php');
include('../../dbconfig.php');

$id = (int)$_GET['id'];
$msg = '';

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $conn->real_escape_string(trim($_POST['name']));
  $slug = strtolower(str_replace(" ", "-", $name));
  $conn->query("UPDATE categories SET name = '$name', slug = '$slug' WHERE id = $id");
  if ($conn->affected_rows) {
    $msg = 'Update Success';
  }
}

// Load one record
$row = $conn->query("SELECT * FROM categories WHERE id = $id")->fetch_object();
if (!$row) {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Category | Admin | JobHub</title>
  <link rel="stylesheet" href="../../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include("../include/leftbar.php"); ?>
<?php include("../include/header.php"); ?>
<main class="dash-content">
  <div class="page-actions">
    <div><h2>Edit category</h2><p>Change the category name.</p></div>
    <a class="btn btn-light" href="index.php">Back to Category List</a>
  </div>

  <?php if ($msg != '') { ?><div class="alert alert-success"><span><?php echo $msg; ?></span></div><?php } ?>

  <form class="card" action="" method="post" style="max-width:520px">
    <div class="card-body">
      <div class="form-group"><label class="form-label">Category Name</label><input class="form-control" type="text" name="name" value="<?php echo htmlspecialchars($row->name); ?>" required></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit" name="submit">Update</button></div>
    </div>
  </form>
</main>
<?php include("../include/footer.php"); ?>
</div>
<script src="../../assets/js/main.js"></script>
</body>
</html>
