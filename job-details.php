<?php
session_start();
include('dbconfig.php');

// Get the job id from the URL ((int) stops anyone sending something harmful)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = $conn->query("SELECT jobs.*, companies.id AS company_id, companies.name AS company_name,
                               companies.logo, companies.user_id AS employer_user, companies.address, companies.website, companies.description AS company_desc,
                               cities.name AS city_name, categories.name AS category_name
                        FROM jobs
                        JOIN companies ON companies.id = jobs.company_id
                        LEFT JOIN cities ON cities.id = jobs.city_id
                        LEFT JOIN categories ON categories.id = jobs.category_id
                        WHERE jobs.id = $id AND jobs.status = 'approved' AND jobs.deadline >= CURDATE()");

$job = $result->fetch_assoc();

// If the job is not found (or the deadline has passed), go back to the Jobs page
if (!$job) {
  header("Location: jobs.php");
  exit;
}

// ===== If logged in as a seeker: apply/save state =====
$isSeeker = isset($_SESSION['role']) && $_SESSION['role'] == 'seeker';
$applied  = null;    // the application, if the seeker already applied
$isSaved  = false;
$applyError = '';
if ($isSeeker) {
  $uid = (int)$_SESSION['user_id'];
  $seeker = $conn->query("SELECT * FROM seekers WHERE user_id = $uid")->fetch_assoc();
  $seekerId = (int)$seeker['id'];
  $applied = $conn->query("SELECT * FROM job_applications WHERE job_id = $id AND seeker_id = $seekerId")->fetch_assoc();
  $isSaved = $conn->query("SELECT id FROM saved_jobs WHERE job_id = $id AND seeker_id = $seekerId")->num_rows > 0;
}

// ===== Apply form submit =====
if (isset($_POST['apply'])) {
  if (!$isSeeker) {
    header("Location: login.php?next=" . urlencode('job-details.php?id=' . $id));
    exit;
  }
  if (!$applied) {
    $resume = '';

    // Use the newly uploaded CV, otherwise the CV from the profile
    if (isset($_FILES['resume']) && $_FILES['resume']['name'] != '') {
      $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
      if ($ext != 'pdf') {
        $applyError = 'CV must be a PDF file.';
      } else if ($_FILES['resume']['size'] > 2 * 1024 * 1024) {
        $applyError = 'CV must be smaller than 2MB.';
      } else {
        if (!is_dir('uploads/cv')) {
          mkdir('uploads/cv', 0777, true);
        }
        $resume = 'uploads/cv/seeker_' . $seekerId . '_' . time() . '.pdf';
        move_uploaded_file($_FILES['resume']['tmp_name'], $resume);
        // If the profile has no CV yet, make this the profile CV
        if (!$seeker['resume_file']) {
          $conn->query("UPDATE seekers SET resume_file = '$resume' WHERE id = $seekerId");
        }
      }
    } else if ($seeker['resume_file']) {
      $resume = $seeker['resume_file'];
    } else {
      $applyError = 'Please upload your CV (PDF) to apply.';
    }

    if ($applyError == '') {
      $conn->query("INSERT INTO job_applications (job_id, seeker_id, resume_file, status)
                    VALUES ($id, $seekerId, '$resume', 'applied')");

      // Notify the employer
      $msg = $conn->real_escape_string($_SESSION['name'] . ' applied for ' . $job['title']);
      $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$job['employer_user']}, '$msg')");

      header("Location: job-details.php?id=$id&applied=1");
      exit;
    }
  } else {
    header("Location: job-details.php?id=$id");
    exit;
  }
}

// This job's skills
$skills = $conn->query("SELECT skills.name FROM job_skills
                        JOIN skills ON skills.id = job_skills.skill_id
                        WHERE job_skills.job_id = $id");

// Similar Jobs: other jobs in the same category
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
$statusLabel = array('applied' => 'Applied', 'viewed' => 'Viewed by employer', 'shortlisted' => 'Shortlisted', 'interview' => 'Interview', 'hired' => 'Hired', 'rejected' => 'Not selected');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $job['title']; ?> | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body>
<?php include('navber.php'); ?>
<main>

<section class="page-header">
  <div class="container">
    <ul class="breadcrumb"><li><a href="index.php">Home</a></li><li><a href="jobs.php">Jobs</a></li><li><?php echo $job['title']; ?></li></ul>
    <div class="job-hero mt-2">
      <?php if ($job['logo']) { ?><img class="company-logo lg" src="uploads/logos/<?php echo $job['logo']; ?>" alt="" style="object-fit:cover"><?php } else { ?><div class="company-logo lg" style="background:#0f766e"><?php echo $short; ?></div><?php } ?>
      <div class="job-hero-info">
        <h1><?php echo $job['title']; ?></h1>
        <div class="job-meta">
          <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><?php echo $job['address'] ? $job['address'] : $job['city_name']; ?></span>
          <span><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Deadline: <?php echo date('d M Y', strtotime($job['deadline'])); ?></span>
        </div>
      </div>
      <div class="job-hero-actions">
        <a class="icon-btn <?php if ($isSaved) echo 'saved'; ?>" href="save-job.php?id=<?php echo $id; ?>" title="<?php echo $isSaved ? 'Remove from saved' : 'Save job'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg></a>
        <?php if ($applied) { ?>
          <a class="btn btn-light" href="seeker/applied-jobs.php">✓ Applied — <?php echo $statusLabel[$applied['status']]; ?></a>
        <?php } else if ($isSeeker) { ?>
          <button class="btn btn-primary btn-lg" data-modal-open="applyModal">Apply Now</button>
        <?php } else if (isset($_SESSION['role'])) { ?>
          <span class="muted small">Log in as a job seeker to apply</span>
        <?php } else { ?>
          <a class="btn btn-primary btn-lg" href="login.php?next=<?php echo urlencode('job-details.php?id=' . $id); ?>">Login to Apply</a>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<?php if (isset($_GET['applied']) || $applyError != '') { ?>
<div class="container mt-2">
  <?php if (isset($_GET['applied'])) { ?><div class="alert alert-success"><span>Application sent! Track it in <a href="seeker/applied-jobs.php">Applied Jobs</a>.</span></div><?php } ?>
  <?php if ($applyError != '') { ?><div class="alert alert-danger"><span><?php echo $applyError; ?></span></div><?php } ?>
</div>
<?php } ?>
<section class="section-sm">
  <div class="container details-layout">
    <article class="card">
      <div class="card-body content-block">
        <h3>Job Description</h3>
        <p><?php echo nl2br($job['description'] ?? ''); ?></p>

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
          <?php if ($applied) { ?>
          <a class="btn btn-light" href="seeker/applied-jobs.php">✓ Applied — <?php echo $statusLabel[$applied['status']]; ?></a>
        <?php } else if ($isSeeker) { ?>
          <button class="btn btn-primary " data-modal-open="applyModal">Apply for this job</button>
        <?php } else if (isset($_SESSION['role'])) { ?>
          <span class="muted small">Log in as a job seeker to apply</span>
        <?php } else { ?>
          <a class="btn btn-primary " href="login.php?next=<?php echo urlencode('job-details.php?id=' . $id); ?>">Login to Apply</a>
        <?php } ?>
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
          <?php if ($job['logo']) { ?><img class="company-logo lg" src="uploads/logos/<?php echo $job['logo']; ?>" alt="" style="object-fit:cover;margin:0 auto 12px;display:block"><?php } else { ?><div class="company-logo lg" style="background:#0f766e;margin:0 auto 12px"><?php echo $short; ?></div><?php } ?>
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

<!-- APPLY MODAL: when a seeker is logged in -->
<?php if ($isSeeker && !$applied) { ?>
<div class="modal" id="applyModal">
  <div class="modal-dialog">
    <form action="job-details.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header"><h3>Apply for <?php echo $job['title']; ?></h3><button type="button" class="modal-close" data-modal-close>&times;</button></div>
      <div class="modal-body">
        <p class="small muted">Your profile (name, phone, education, experience, skills) will be shared with <?php echo $job['company_name']; ?>.
          <a href="seeker/profile.php">Update profile</a></p>
        <?php if ($seeker['resume_file']) { ?>
          <p>Your profile CV: <a href="<?php echo $seeker['resume_file']; ?>" target="_blank"><?php echo basename($seeker['resume_file']); ?></a> will be sent.</p>
          <label class="form-label">Or upload a different CV (optional)</label>
        <?php } else { ?>
          <label class="form-label">Resume / CV (PDF) <span class="req">*</span></label>
        <?php } ?>
        <label class="file-drop"><span class="file-name">Click to upload PDF (max 2MB)</span><input type="file" name="resume" accept=".pdf"></label>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-modal-close>Cancel</button><button class="btn btn-primary" type="submit" name="apply">Submit Application</button></div>
    </form>
  </div>
</div>
<?php } ?>
</main>
<?php include('footer.php'); ?>
