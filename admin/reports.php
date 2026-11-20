<?php
include('include/check.php');
include('../dbconfig.php');

//  function
function one($conn, $sql) {
  $row = $conn->query($sql)->fetch_assoc();
  return $row ? (float)$row['c'] : 0;
}

// ===== total =====
$income      = one($conn, "SELECT SUM(total_amount) AS c FROM payment_transactions WHERE status = 'completed'");
$paidCount   = one($conn, "SELECT COUNT(*) AS c FROM payment_transactions WHERE status = 'completed'");
$totalJobs   = one($conn, "SELECT COUNT(*) AS c FROM jobs");
$liveJobs    = one($conn, "SELECT COUNT(*) AS c FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()");
$totalApps   = one($conn, "SELECT COUNT(*) AS c FROM job_applications");
$hired       = one($conn, "SELECT COUNT(*) AS c FROM job_applications WHERE status = 'hired'");
$hireRate    = $totalApps > 0 ? round($hired / $totalApps * 100) : 0;

// ===== last 6 month: income, new user, application =====
$months = array();
for ($i = 5; $i >= 0; $i--) {
  $key = date('Y-m', strtotime("first day of -$i month"));
  $months[$key] = array('label' => date('M Y', strtotime($key . '-01')), 'income' => 0, 'users' => 0, 'apps' => 0);
}
$from = array_key_first($months) . '-01';
$r = $conn->query("SELECT DATE_FORMAT(subscriptions.start_date, '%Y-%m') AS m, SUM(payment_transactions.total_amount) AS c
                   FROM payment_transactions JOIN subscriptions ON subscriptions.id = payment_transactions.subscription_id
                   WHERE payment_transactions.status = 'completed' AND subscriptions.start_date >= '$from' GROUP BY m");
while ($x = $r->fetch_assoc()) { if (isset($months[$x['m']])) $months[$x['m']]['income'] = (float)$x['c']; }
$r = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS m, COUNT(*) AS c FROM users WHERE created_at >= '$from' GROUP BY m");
while ($x = $r->fetch_assoc()) { if (isset($months[$x['m']])) $months[$x['m']]['users'] = (int)$x['c']; }
$r = $conn->query("SELECT DATE_FORMAT(applied_at, '%Y-%m') AS m, COUNT(*) AS c FROM job_applications WHERE applied_at >= '$from' GROUP BY m");
while ($x = $r->fetch_assoc()) { if (isset($months[$x['m']])) $months[$x['m']]['apps'] = (int)$x['c']; }
$maxIncome = max(1, max(array_column($months, 'income')));

// ===== Category job =====
$byCategory = $conn->query("SELECT categories.name, COUNT(jobs.id) AS total,
                                   SUM(CASE WHEN jobs.status = 'approved' AND jobs.deadline >= CURDATE() THEN 1 ELSE 0 END) AS live
                            FROM categories LEFT JOIN jobs ON jobs.category_id = categories.id
                            GROUP BY categories.id ORDER BY total DESC");

// ===== Application status =====
$byStatus = $conn->query("SELECT status, COUNT(*) AS c FROM job_applications GROUP BY status ORDER BY c DESC");

// ===== maximum application  company =====
$topCompanies = $conn->query("SELECT companies.name, COUNT(job_applications.id) AS apps, COUNT(DISTINCT jobs.id) AS jobs
                              FROM companies
                              JOIN jobs ON jobs.company_id = companies.id
                              LEFT JOIN job_applications ON job_applications.job_id = jobs.id
                              GROUP BY companies.id ORDER BY apps DESC LIMIT 5");

// ===== max sold package  =====
$byPackage = $conn->query("SELECT packages.name, COUNT(payment_transactions.id) AS sold, SUM(payment_transactions.total_amount) AS income
                           FROM packages
                           LEFT JOIN subscriptions ON subscriptions.package_id = packages.id
                           LEFT JOIN payment_transactions ON payment_transactions.subscription_id = subscriptions.id AND payment_transactions.status = 'completed'
                           WHERE packages.price > 0
                           GROUP BY packages.id ORDER BY packages.price");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports | Admin | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
  <style>
    .bar-row { display: grid; grid-template-columns: 80px 1fr 90px; gap: 10px; align-items: center; margin-bottom: 10px; font-size: .9rem; }
    .bar-track { background: var(--primary-light); border-radius: 6px; height: 14px; overflow: hidden; }
    .bar-fill { background: linear-gradient(90deg, var(--primary), #06b6d4); height: 14px; border-radius: 6px; }
    @media print { .sidebar, .topbar, .no-print { display: none !important; } .dash-main { margin: 0 !important; } }
  </style>
</head>
<body class="dash-body">
<?php include('include/leftbar.php'); ?>
<?php include('include/header.php'); ?>
<main class="dash-content">
  <div class="page-actions">
    <div><h2>Reports &amp; Analytics</h2><p>Business overview of JobHub.</p></div>
    <button class="btn btn-light no-print" onclick="window.print()">🖨 Print / Save PDF</button>
  </div>

  <div class="grid grid-4 mb-3">
    <div class="stat-card"><div><h3>৳<?php echo number_format($income); ?></h3><p>Total income (<?php echo (int)$paidCount; ?> payments)</p></div></div>
    <div class="stat-card"><div><h3><?php echo (int)$liveJobs; ?> / <?php echo (int)$totalJobs; ?></h3><p>Live jobs / all jobs</p></div></div>
    <div class="stat-card"><div><h3><?php echo (int)$totalApps; ?></h3><p>Applications</p></div></div>
    <div class="stat-card"><div><h3><?php echo $hireRate; ?>%</h3><p>Hire rate (<?php echo (int)$hired; ?> hired)</p></div></div>
  </div>

  <div class="dash-grid mb-3">
    <div class="card">
      <div class="card-header"><h3>Income — last 6 months</h3></div>
      <div class="card-body">
        <?php foreach ($months as $m) { ?>
          <div class="bar-row">
            <span><?php echo $m['label']; ?></span>
            <div class="bar-track"><div class="bar-fill" style="width:<?php echo round($m['income'] / $maxIncome * 100); ?>%"></div></div>
            <b>৳<?php echo number_format($m['income']); ?></b>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>Growth — last 6 months</h3></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Month</th><th>New users</th><th>Applications</th></tr></thead>
          <tbody>
          <?php foreach ($months as $m) { ?>
            <tr><td><?php echo $m['label']; ?></td><td><?php echo $m['users']; ?></td><td><?php echo $m['apps']; ?></td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="dash-grid mb-3">
    <div class="card">
      <div class="card-header"><h3>Jobs by category</h3></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Category</th><th>Live</th><th>Total</th></tr></thead>
          <tbody>
          <?php while ($c = $byCategory->fetch_assoc()) { ?>
            <tr><td><?php echo htmlspecialchars($c['name']); ?></td><td><?php echo (int)$c['live']; ?></td><td><?php echo (int)$c['total']; ?></td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>Applications by status</h3></div>
      <div class="card-body">
        <?php while ($s = $byStatus->fetch_assoc()) { $pct = $totalApps > 0 ? round($s['c'] / $totalApps * 100) : 0; ?>
          <div class="bar-row">
            <span><?php echo ucfirst($s['status']); ?></span>
            <div class="bar-track"><div class="bar-fill" style="width:<?php echo $pct; ?>%"></div></div>
            <b><?php echo $s['c']; ?> (<?php echo $pct; ?>%)</b>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="dash-grid">
    <div class="card">
      <div class="card-header"><h3>Top companies by applications</h3></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Company</th><th>Jobs</th><th>Applications</th></tr></thead>
          <tbody>
          <?php while ($c = $topCompanies->fetch_assoc()) { ?>
            <tr><td><?php echo htmlspecialchars($c['name']); ?></td><td><?php echo $c['jobs']; ?></td><td><?php echo $c['apps']; ?></td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <div class="card-header"><h3>Package sales</h3></div>
      <div class="table-wrap">
        <table class="table">
          <thead><tr><th>Package</th><th>Sold</th><th>Income</th></tr></thead>
          <tbody>
          <?php while ($p = $byPackage->fetch_assoc()) { ?>
            <tr><td><?php echo htmlspecialchars($p['name']); ?></td><td><?php echo $p['sold']; ?></td><td>৳<?php echo number_format((float)$p['income']); ?></td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<?php include('include/footer.php'); ?>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
