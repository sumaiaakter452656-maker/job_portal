<?php
session_start();
include('dbconfig.php');

// ?id= থাকলে একটা company-র profile দেখাবো, না থাকলে সব company-র list
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
  // ===== একটা Company-র Profile =====
  $company = $conn->query("SELECT companies.*, cities.name AS city_name
                           FROM companies
                           LEFT JOIN cities ON cities.id = companies.city_id
                           WHERE companies.id = $id")->fetch_assoc();

  if (!$company) {
    header("Location: companies.php");
    exit;
  }

  // এই company-র approved job গুলো
  $jobs = $conn->query("SELECT jobs.*, companies.name AS company_name, companies.logo,
                               cities.name AS city_name, categories.name AS category_name
                        FROM jobs
                        JOIN companies ON companies.id = jobs.company_id
                        LEFT JOIN cities ON cities.id = jobs.city_id
                        LEFT JOIN categories ON categories.id = jobs.category_id
                        WHERE jobs.company_id = $id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()
                        ORDER BY jobs.id DESC");
} else {
  // ===== সব Company (search সহ) =====
  $q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

  $sql = "SELECT companies.*, cities.name AS city_name, COUNT(jobs.id) AS total_jobs
          FROM companies
          LEFT JOIN cities ON cities.id = companies.city_id
          LEFT JOIN jobs ON jobs.company_id = companies.id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()";
  if ($q != '') {
    $sql .= " WHERE companies.name LIKE '%$q%'";
  }
  $sql .= " GROUP BY companies.id ORDER BY total_jobs DESC";

  $companies = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Companies | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<?php if ($id > 0) { ?>
<!-- ================= COMPANY PROFILE ================= -->
<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li><a href="companies.php">Companies</a></li><li><?php echo $company['name']; ?></li></ul>
    <div class="job-hero mt-2">
      <div class="company-logo lg" style="background:#2563eb"><?php echo strtoupper(substr($company['name'], 0, 2)); ?></div>
      <div class="job-hero-info">
        <h1><?php echo $company['name']; ?></h1>
        <div class="job-meta">
          <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><?php echo $company['address'] ? $company['address'] : $company['city_name']; ?></span>
          <?php if ($company['website']) { ?>
            <span><a href="<?php echo $company['website']; ?>" target="_blank"><?php echo $company['website']; ?></a></span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <div class="card mb-3"><div class="card-body">
      <h3>About</h3>
      <p class="mb-0"><?php echo nl2br($company['description']); ?></p>
    </div></div>

    <h2 class="mb-2">Open jobs (<?php echo $jobs->num_rows; ?>)</h2>
    <div class="grid grid-3">
      <?php
      if ($jobs->num_rows == 0) {
        echo '<p class="muted">No open jobs right now.</p>';
      }
      while ($row = $jobs->fetch_assoc()) {
        include('job-card.php');
      }
      ?>
    </div>
  </div>
</section>

<?php } else { ?>
<!-- ================= COMPANY LIST ================= -->
<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li>Companies</li></ul>
    <h1>Top Companies</h1><p class="muted mb-0 mt-1">Explore employers that are hiring right now</p>
  </div>
</section>

<section class="section-sm">
  <div class="container">
    <form class="listing-toolbar" action="companies.php" method="get">
      <div class="input-icon" style="flex:1;max-width:380px"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input class="form-control" style="width:100%" name="q" placeholder="Search company" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>"></div>
      <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <div class="grid grid-4">
      <?php
      if ($companies->num_rows == 0) {
        echo '<p class="muted">No company found.</p>';
      }
      while ($co = $companies->fetch_assoc()) {
      ?>
        <div class="card company-card">
          <div class="company-logo lg" style="background:#2563eb"><?php echo strtoupper(substr($co['name'], 0, 2)); ?></div>
          <h3><?php echo $co['name']; ?></h3>
          <p class="muted small"><?php echo $co['city_name']; ?></p>
          <span class="badge badge-primary"><?php echo $co['total_jobs']; ?> open jobs</span>
          <a href="companies.php?id=<?php echo $co['id']; ?>" class="btn btn-light btn-block mt-2">View profile</a>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php } ?>

</main>
<?php include('footer.php'); ?>
