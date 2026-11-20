<?php
session_start();
include('dbconfig.php');

// ===== সব job query-তে একই JOIN লাগে, তাই একবার লিখে রাখলাম =====
$jobSql = "SELECT jobs.*, companies.name AS company_name, companies.logo,
                  cities.name AS city_name, categories.name AS category_name
           FROM jobs
           JOIN companies ON companies.id = jobs.company_id
           LEFT JOIN cities ON cities.id = jobs.city_id
           LEFT JOIN categories ON categories.id = jobs.category_id
           WHERE jobs.status = 'approved' AND jobs.deadline >= CURDATE()";

// Featured Jobs (সর্বোচ্চ ৩টা)
$featured = $conn->query($jobSql . " AND jobs.is_featured = 1 ORDER BY jobs.id DESC LIMIT 3");

// Latest Jobs (সর্বোচ্চ ৬টা)
$latest = $conn->query($jobSql . " ORDER BY jobs.id DESC LIMIT 6");

// Popular Categories: প্রতিটা category-তে কয়টা approved job আছে
$categories = $conn->query("SELECT categories.id, categories.name, COUNT(jobs.id) AS total
                            FROM categories
                            LEFT JOIN jobs ON jobs.category_id = categories.id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()
                            GROUP BY categories.id
                            ORDER BY total DESC
                            LIMIT 8");

// Top Companies: যাদের সবচেয়ে বেশি job আছে
$companies = $conn->query("SELECT companies.id, companies.name, companies.logo, COUNT(jobs.id) AS total
                           FROM companies
                           LEFT JOIN jobs ON jobs.company_id = companies.id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()
                           GROUP BY companies.id
                           ORDER BY total DESC
                           LIMIT 6");

// Search box-এর জন্য city list
$cities = $conn->query("SELECT * FROM cities ORDER BY name");

// উপরের সংখ্যাগুলো
$totalJobs      = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()")->fetch_assoc()['c'];
$totalCompanies = $conn->query("SELECT COUNT(*) AS c FROM companies")->fetch_assoc()['c'];
$totalSeekers   = $conn->query("SELECT COUNT(*) AS c FROM seekers")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<!-- HERO -->
<section class="hero">
  <div class="container hero-inner">
    <span class="eyebrow"><?php echo $totalJobs; ?> live jobs across Bangladesh</span>
    <h1>Find a job that fits your <span class="hl">life</span></h1>
    <p class="lead">Search verified openings from top employers, apply in one click and track every application from your dashboard.</p>
    <form class="search-bar" action="jobs.php" method="get">
      <div class="search-field"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" name="q" placeholder="Job title, skill or company"></div>
      <div class="search-field"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <select name="city">
          <option value="">All locations</option>
          <?php while ($c = $cities->fetch_assoc()) { ?>
            <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
          <?php } ?>
        </select>
      </div>
      <button class="btn btn-primary btn-lg" type="submit">Search Jobs</button>
    </form>
    <div class="hero-stats">
      <div><strong><?php echo $totalJobs; ?></strong><span>Live jobs</span></div>
      <div><strong><?php echo $totalCompanies; ?></strong><span>Companies</span></div>
      <div><strong><?php echo $totalSeekers; ?></strong><span>Job seekers</span></div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <div><h2>Browse by category</h2><p>Find jobs in the field you love.</p></div>
      <a href="jobs.php" class="btn btn-light">All jobs</a>
    </div>
    <div class="grid grid-4">
      <?php while ($cat = $categories->fetch_assoc()) { ?>
        <a href="jobs.php?category=<?php echo $cat['id']; ?>" class="category-card">
          <div class="category-icon"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
          <div><h4><?php echo $cat['name']; ?></h4><span><?php echo $cat['total']; ?> open jobs</span></div>
        </a>
      <?php } ?>
    </div>
  </div>
</section>

<?php if ($featured->num_rows > 0) { ?>
<!-- FEATURED JOBS -->
<section class="section bg-white">
  <div class="container">
    <div class="section-head">
      <div><h2>Featured jobs</h2><p>Hand-picked openings from our employers.</p></div>
      <a href="jobs.php" class="btn btn-outline">View all jobs</a>
    </div>
    <div class="grid grid-3">
      <?php while ($row = $featured->fetch_assoc()) { include('job-card.php'); } ?>
    </div>
  </div>
</section>
<?php } ?>

<!-- LATEST JOBS -->
<section class="section">
  <div class="container">
    <div class="section-head">
      <div><h2>Latest jobs</h2><p>Newest openings posted on JobHub.</p></div>
      <a href="jobs.php" class="btn btn-outline">View all jobs</a>
    </div>
    <div class="grid grid-3">
      <?php
      if ($latest->num_rows == 0) {
        echo '<p class="muted">No jobs yet.</p>';
      }
      while ($row = $latest->fetch_assoc()) {
        include('job-card.php');
      }
      ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section">
  <div class="container">
    <div class="text-center mb-3"><h2>How it works</h2><p class="muted">Three simple steps to your next job.</p></div>
    <div class="grid grid-3">
      <div class="step"><div class="step-num">1</div><h3>Create an account</h3><p class="muted">Sign up as a job seeker or employer in less than a minute.</p></div>
      <div class="step"><div class="step-num">2</div><h3>Build your profile</h3><p class="muted">Add your education, experience and upload your CV.</p></div>
      <div class="step"><div class="step-num">3</div><h3>Apply &amp; get hired</h3><p class="muted">Apply with one click and follow your status live.</p></div>
    </div>
  </div>
</section>

<!-- TOP COMPANIES -->
<section class="section-sm bg-white">
  <div class="container">
    <p class="text-center muted fw-600 mb-2">Top companies hiring now</p>
    <div class="company-strip">
      <?php while ($co = $companies->fetch_assoc()) { ?>
        <a class="company-chip" href="companies.php?id=<?php echo $co['id']; ?>">
          <span class="company-logo sm" style="background:#2563eb"><?php echo strtoupper(substr($co['name'], 0, 2)); ?></span>
          <?php echo $co['name']; ?> (<?php echo $co['total']; ?>)
        </a>
      <?php } ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="section">
  <div class="container">
    <div class="cta-band">
      <div><h2>Hiring? Post a job in minutes.</h2><p>Reach thousands of qualified candidates today.</p></div>
      <a href="employer/post-job.php" class="btn btn-accent btn-lg">Post a Job — It's Free</a>
    </div>
  </div>
</section>
</main>
<?php include('footer.php'); ?>
