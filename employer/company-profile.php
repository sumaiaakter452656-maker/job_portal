<?php
include('include/check.php');
$pageTitle = 'Company Profile';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name        = $conn->real_escape_string(trim($_POST['name']));
  $city_id     = (int)$_POST['city_id'];
  $website     = $conn->real_escape_string(trim($_POST['website']));
  $address     = $conn->real_escape_string(trim($_POST['address']));
  $description = $conn->real_escape_string(trim($_POST['description']));

  if ($name == '') {
    $error = 'Company name is required.';
  }

  // ===== Logo upload (jpg/png, max 2MB) =====
  $logoSql = '';
  if ($error == '' && isset($_FILES['logo']) && $_FILES['logo']['name'] != '') {
    $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, array('jpg', 'jpeg', 'png'))) {
      $error = 'Logo must be a JPG or PNG image.';
    } else if ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
      $error = 'Logo must be smaller than 2MB.';
    } else {
      if (!is_dir('../uploads/logos')) {
        mkdir('../uploads/logos', 0777, true);
      }
      $fileName = 'company_' . $companyId . '_' . time() . '.' . $ext;
      move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/logos/' . $fileName);
      $logoSql = ", logo = '$fileName'";
    }
  }

  if ($error == '') {
    $cityValue = $city_id ? $city_id : 'NULL';
    $conn->query("UPDATE companies SET name = '$name', city_id = $cityValue, website = '$website',
                  address = '$address', description = '$description' $logoSql
                  WHERE id = $companyId");
    $success = 'Company profile updated.';
    // new information
    $company = $conn->query("SELECT * FROM companies WHERE id = $companyId")->fetch_assoc();
  }
}

$cities = $conn->query("SELECT * FROM cities ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Profile | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>Company profile</h2><p>This information is shown on your job posts and company page.</p></div>
    <a href="../companies.php?id=<?php echo $companyId; ?>" class="btn btn-light" target="_blank">View public page</a>
  </div>

  <?php if ($error != '') { ?><div class="alert alert-danger"><span><?php echo $error; ?></span></div><?php } ?>
  <?php if ($success != '') { ?><div class="alert alert-success"><span><?php echo $success; ?></span></div><?php } ?>

  <form class="card" action="" method="post" enctype="multipart/form-data">
    <div class="card-body">
      <div class="flex items-center gap-2 mb-3 wrap">
        <?php if ($company['logo']) { ?>
          <img class="company-logo lg" src="../uploads/logos/<?php echo $company['logo']; ?>" alt="logo">
        <?php } else { ?>
          <div class="company-logo lg" style="background:#0f766e"><?php echo strtoupper(substr($company['name'], 0, 2)); ?></div>
        <?php } ?>
        <div>
          <input type="file" name="logo" accept=".jpg,.jpeg,.png" class="form-control">
          <div class="form-hint">JPG or PNG, max 2MB.</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Company name <span class="req">*</span></label><input class="form-control" name="name" value="<?php echo htmlspecialchars($company['name'] ?? ''); ?>" required></div>
        <div class="form-group"><label class="form-label">City</label>
          <select class="form-control" name="city_id">
            <option value="">Select</option>
            <?php while ($c = $cities->fetch_assoc()) { ?>
              <option value="<?php echo $c['id']; ?>" <?php if ($company['city_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
            <?php } ?>
          </select></div>
        <div class="form-group"><label class="form-label">Website</label><input class="form-control" type="url" name="website" placeholder="https://" value="<?php echo htmlspecialchars($company['website'] ?? ''); ?>"></div>
        <div class="form-group"><label class="form-label">Address</label><input class="form-control" name="address" value="<?php echo htmlspecialchars($company['address'] ?? ''); ?>"></div>
      </div>
      <div class="form-group"><label class="form-label">About the company</label><textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($company['description'] ?? ''); ?></textarea></div>
      <div class="form-actions"><button class="btn btn-primary" type="submit">Save changes</button></div>
    </div>
  </form>
</main>
<?php include('include/footer.php'); ?>
