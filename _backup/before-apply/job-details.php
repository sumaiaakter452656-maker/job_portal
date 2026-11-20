<?php
include('dbconfig.php');

// URL থেকে job id নেওয়া (int করলে কেউ উল্টাপাল্টা কিছু পাঠাতে পারবে না)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = $conn->query("SELECT jobs.*, companies.id AS company_id, companies.name AS company_name,
                               companies.logo, companies.address, companies.website, companies.description AS company_desc,
                               cities.name AS city_name, categories.name AS category_name
                        FROM jobs
                        JOIN companies ON companies.id = jobs.company_id
                        LEFT JOIN cities ON cities.id = jobs.city_id
                        LEFT JOIN categories ON categories.id = jobs.category_id
                        WHERE jobs.id = $id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()");

$job = $result->fetch_assoc();

// Job না পেলে (বা deadline পার হয়ে গেলে) Jobs পেজে ফেরত
if (!$job) {
  header("Location: jobs.php");
  exit;
}

// এই job-এর skill গুলো
$skills = $conn->query("SELECT skills.name FROM job_skills
                        JOIN skills ON skills.id = job_skills.skill_id
                        WHERE job_skills.job_id = $id");

// Similar Jobs: একই category-র অন্য job
$catId = (int)$job['category_id'];
$similar = $conn->query("SELECT jobs.*, companies.name AS company_name, companies.logo,
                                cities.name AS city_name, categories.name AS category_name
                         FROM jobs
                         JOIN companies ON companies.id = jobs.company_id
                         LEFT JOIN cities ON cities.id = jobs.city_id
                         LEFT JOIN categories ON categories.id = jobs.category_id
                         WHERE jobs.status = 'approved' AND jobs.deadline >= CURDATE() AND jobs.category_id = $catId AND jobs.id != $id
                         ORDER BY jobs.id DESC LIMIT 3");

// Salary
if ($job['salary_min'] && $job['salary_max']) {
  $salary = '৳' . number_format($job['salary_min']) . ' – ' . number_format($job['salary_max']);
} else if ($job['salary_min']) {
  $salary = '৳' . number_format($job['salary_min']);
} else {
  $salary = 'Negotiable';
}
$type    = ucwords(str_replace('_', ' ', $job['job_type']));
$short   = strtoupper(substr($job['company_name'], 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $job['title']; ?> | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li><a href="jobs.php">Jobs</a></li><li><?php echo $job['title']; ?></li></ul>
    <div class="job-hero mt-2">
      <div class="company-logo lg" style="background:#0f766e"><?php echo $short; ?></div>
      <div class="job-hero-info">
        <h1><?php echo $job['title']; ?></h1>
        <div class="job-meta">
          <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><?php echo $job['address'] ? $job['address'] : $job['city_name']; ?></span>
          <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Deadline: <?php echo date('d M Y', strtotime($job['deadline'])); ?></span>
        </div>
      </div>
      <div class="job-hero-actions">
        <button class="icon-btn" data-toggle-save title="Save job"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg></button>
        <button class="btn btn-primary btn-lg" data-modal-open="applyModal">Apply Now</button>
      </div>
    </div>
  </div>
</section>

<section class="section-sm">
  <div class="container details-layout">
    <article class="card">
      <div class="card-body content-block">
        <h3>Job Description</h3>
        <p><?php echo nl2br($job['description']); ?></p>

        <?php if ($skills->num_rows > 0) { ?>
          <h3>Skills</h3>
          <div class="tags">
            <?php while ($s = $skills->fetch_assoc()) { ?>
              <span class="tag"><?php echo $s['name']; ?></span>
            <?php } ?>
          </div>
        <?php } ?>

        <hr class="divider">
        <div class="flex items-center justify-between wrap gap-2">
          <p class="mb-0 muted">Application deadline: <strong><?php echo date('d M Y', strtotime($job['deadline'])); ?></strong></p>
          <button class="btn btn-primary" data-modal-open="applyModal">Apply for this job</button>
        </div>
        <p class="small muted mt-2">Share: <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">Facebook</a>
          · <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">LinkedIn</a></p>
      </div>
    </article>

    <aside>
      <div class="card mb-3">
        <div class="card-header"><h3>Job Overview</h3></div>
        <div class="card-body">
          <ul class="overview-list">
            <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><div><small>Deadline</small><strong><?php echo date('d M Y', strtotime($job['deadline'])); ?></strong></div></li>
            <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg><div><small>Job type</small><strong><?php echo $type; ?></strong></div></li>
            <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg><div><small>Category</small><strong><?php echo $job['category_name']; ?></strong></div></li>
            <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg><div><small>Salary</small><strong><?php echo $salary; ?></strong></div></li>
            <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><div><small>Location</small><strong><?php echo $job['city_name']; ?></strong></div></li>
          </ul>
        </div>
      </div>
      <div class="card">
        <div class="card-body text-center">
          <div class="company-logo lg" style="background:#0f766e;margin:0 auto 12px"><?php echo $short; ?></div>
          <h3 class="mb-0"><?php echo $job['company_name']; ?></h3>
          <p class="small"><?php echo $job['company_desc']; ?></p>
          <a href="companies.php?id=<?php echo $job['company_id']; ?>" class="btn btn-light btn-block">View company</a>
        </div>
      </div>
    </aside>
  </div>
</section>

<?php if ($similar->num_rows > 0) { ?>
<section class="section-sm">
  <div class="container">
    <h2 class="mb-2">Similar jobs</h2>
    <div class="grid grid-3">
      <?php while ($row = $similar->fetch_assoc()) { include('job-card.php'); } ?>
    </div>
  </div>
</section>
<?php } ?>

<!-- Apply form টা Phase 3-এ কাজ করবে (login + CV upload) -->
<!-- APPLY MODAL -->
<div class="modal" id="applyModal">
  <div class="modal-dialog">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="modal-header"><h3>Apply for <?php echo $job['title']; ?></h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group"><label class="form-label">Full name <span class="req">*</span></label><input class="form-control" name="name" required></div>
          <div class="form-group"><label class="form-label">Phone <span class="req">*</span></label><input class="form-control" name="phone" required></div>
        </div>
        <div class="form-group"><label class="form-label">Expected salary</label><input class="form-control" type="number" name="expected_salary" placeholder="e.g. 90000"></div>
        <div class="form-group"><label class="form-label">Cover letter</label><textarea class="form-control" name="cover_letter" placeholder="Why are you a good fit?"></textarea></div>
        <div class="form-group">
          <label class="form-label">Resume / CV <span class="req">*</span></label>
          <label class="file-drop"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg><span class="file-name">Click to upload PDF (max 2MB)</span><input type="file" name="resume" accept=".pdf,.doc,.docx"></label>
        </div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit">Submit Application</button></div>
    </form>
  </div>
</div>
</main>
<?php include('footer.php'); ?>
