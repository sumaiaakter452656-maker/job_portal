<?php
session_start();
include('dbconfig.php');

$packages = $conn->query("SELECT * FROM packages ORDER BY price");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pricing | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li>Pricing</li></ul>
    <h1>Packages for Employers</h1><p class="muted mb-0 mt-1">Choose a package and start hiring today</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="grid grid-3">
      <?php while ($p = $packages->fetch_assoc()) { ?>
        <div class="card" style="text-align:center">
          <div class="card-body">
            <h3><?php echo $p['name']; ?></h3>
            <h2 style="font-size:2.4rem;margin:8px 0"><?php echo $p['price'] > 0 ? '৳' . number_format($p['price']) : 'Free'; ?></h2>
            <p class="muted"><?php echo $p['description']; ?></p>
            <ul class="overview-list" style="text-align:left">
              <li><div><small>Job posts</small><strong><?php echo $p['job_post_limit']; ?></strong></div></li>
              <li><div><small>Validity</small><strong><?php echo $p['duration_days']; ?> days</strong></div></li>
            </ul>
            <?php if ($p['price'] > 0) { ?>
              <a class="btn btn-primary btn-block mt-2" href="employer/checkout.php?package=<?php echo $p['id']; ?>">Buy <?php echo $p['name']; ?></a>
            <?php } else { ?>
              <a class="btn btn-light btn-block mt-2" href="employer/post-job.php">Given free with your first job post</a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
    <p class="text-center muted mt-3">Payments on this site are <b>demo only</b> — no real money is charged.</p>
  </div>
</section>
</main>
<?php include('footer.php'); ?>
