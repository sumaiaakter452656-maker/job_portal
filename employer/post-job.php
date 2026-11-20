<?php
include('include/check.php');

// With ?id= edit an existing job, otherwise post a new job
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pageTitle = $id ? 'Edit Job' : 'Post a Job';
$error = '';
$success = '';

// When editing, load the old data (only my company's jobs)
$job = array('title' => '', 'category_id' => '', 'city_id' => '', 'job_type' => 'full_time',
             'salary_min' => '', 'salary_max' => '', 'description' => '', 'deadline' => '');
$jobSkills = '';
if ($id) {
  $job = $conn->query("SELECT * FROM jobs WHERE id = $id AND company_id = $companyId")->fetch_assoc();
  if (!$job) {
    header("Location: manage-jobs.php");
    exit;
  }
  // The job's skills, separated by commas
  $sk = $conn->query("SELECT skills.name FROM job_skills JOIN skills ON skills.id = job_skills.skill_id WHERE job_skills.job_id = $id");
  $names = array();
  while ($s = $sk->fetch_assoc()) { $names[] = $s['name']; }
  $jobSkills = implode(', ', $names);
}

// ===== Form submit =====
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title       = $conn->real_escape_string(trim($_POST['title']));
  $category_id = (int)$_POST['category_id'];
  $city_id     = (int)$_POST['city_id'];
  $job_type    = in_array($_POST['job_type'], array('full_time','part_time','contract','internship','remote')) ? $_POST['job_type'] : 'full_time';
  $salary_min  = !empty($_POST['salary_min']) ? (int)$_POST['salary_min'] : 'NULL';
  $salary_max  = !empty($_POST['salary_max']) ? (int)$_POST['salary_max'] : 'NULL';
  $description = $conn->real_escape_string(trim($_POST['description']));
  $deadline    = $conn->real_escape_string($_POST['deadline']);

  if ($title == '' || $description == '' || $deadline == '' || $category_id == 0 || $city_id == 0) {
    $error = 'Please fill in all required fields.';
  } else if ($deadline < date('Y-m-d')) {
    $error = 'Deadline must be today or a future date.';
  }

  // For a new job, check the package limit
  if ($error == '' && !$id) {
    if (!$sub) {
      // Never had a package? Then give the Free package (id 1) once
      $hadPackage = $conn->query("SELECT COUNT(*) AS c FROM subscriptions WHERE user_id = $userId")->fetch_assoc()['c'];
      if ($hadPackage == 0) {
        $free = $conn->query("SELECT * FROM packages WHERE price = 0 ORDER BY id LIMIT 1")->fetch_assoc();
        $end  = date('Y-m-d', strtotime('+' . $free['duration_days'] . ' days'));
        $conn->query("INSERT INTO subscriptions (user_id, package_id, posts_left, start_date, end_date, status)
                      VALUES ($userId, {$free['id']}, {$free['job_post_limit']}, CURDATE(), '$end', 'active')");
        $sub = $conn->query("SELECT subscriptions.*, packages.name AS package_name FROM subscriptions
                             JOIN packages ON packages.id = subscriptions.package_id
                             WHERE subscriptions.id = " . $conn->insert_id)->fetch_assoc();
      }
    }
    if (!$sub || $sub['posts_left'] <= 0) {
      $error = 'Your job post limit is over. <a href="subscription.php">Buy a new package</a> to post more jobs.';
    }
  }

  if ($error == '') {
    if ($id) {
      // ===== Update =====
      $conn->query("UPDATE jobs SET title = '$title', category_id = $category_id, city_id = $city_id, job_type = '$job_type',
                    salary_min = $salary_min, salary_max = $salary_max, description = '$description', deadline = '$deadline'
                    WHERE id = $id AND company_id = $companyId");
      $jobId = $id;
      $success = 'Job updated successfully.';
    } else {
      // ===== Insert (shown on the site after admin approval) =====
      $slug = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $_POST['title'])) . '-' . time();
      $subId = (int)$sub['id'];
      $conn->query("INSERT INTO jobs (company_id, category_id, city_id, subscription_id, title, slug, job_type,
                                      salary_min, salary_max, description, deadline, status, is_featured)
                    VALUES ($companyId, $category_id, $city_id, $subId, '$title', '$slug', '$job_type',
                            $salary_min, $salary_max, '$description', '$deadline', 'pending', 0)");
      $jobId = $conn->insert_id;

      // Use 1 post from the package
      $conn->query("UPDATE subscriptions SET posts_left = posts_left - 1 WHERE id = $subId");

      // Notify all admins
      $admins = $conn->query("SELECT id FROM users WHERE role = 'admin'");
      $msg = $conn->real_escape_string('New job "' . $_POST['title'] . '" by ' . $company['name'] . ' needs approval');
      while ($ad = $admins->fetch_assoc()) {
        $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$ad['id']}, '$msg')");
      }
    }

    // ===== Skills: comma-separated names -> skills table -> job_skills =====
    $conn->query("DELETE FROM job_skills WHERE job_id = $jobId");
    foreach (explode(',', $_POST['skills']) as $name) {
      $name = $conn->real_escape_string(trim($name));
      if ($name == '') continue;
      $found = $conn->query("SELECT id FROM skills WHERE name = '$name'")->fetch_assoc();
      if ($found) {
        $skillId = $found['id'];
      } else {
        $conn->query("INSERT INTO skills (name) VALUES ('$name')");
        $skillId = $conn->insert_id;
      }
      $conn->query("INSERT INTO job_skills (job_id, skill_id) VALUES ($jobId, $skillId)");
    }

    // For a new job, go back to the My Jobs page
    if (!$id) {
      header("Location: manage-jobs.php?posted=1");
      exit;
    }
  }

  // Keep the typed data in the form when there is an error
  $job = array_merge($job, $_POST);
  $jobSkills = $_POST['skills'];
}

$categories = $conn->query("SELECT * FROM categories ORDER BY name");
$cities     = $conn->query("SELECT * FROM cities ORDER BY name");
$types      = array('full_time' => 'Full Time', 'part_time' => 'Part Time', 'remote' => 'Remote', 'contract' => 'Contract', 'internship' => 'Internship');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2><?php echo $id ? 'Edit job' : 'Post a new job'; ?></h2><p>Fields marked * are required.</p></div>
    <?php if (!$id) { ?>
      <span class="badge badge-primary">
        <?php echo $sub ? $sub['posts_left'] . ' posts left (' . $sub['package_name'] . ')' : 'Free package will start with your first post'; ?>
      </span>
    <?php } ?>
  </div>

  <?php if ($error != '') { ?><div class="alert alert-danger"><span><?php echo $error; ?></span></div><?php } ?>
  <?php if ($success != '') { ?><div class="alert alert-success"><span><?php echo $success; ?> <a href="manage-jobs.php">Back to my jobs</a></span></div><?php } ?>

  <form class="card" action="" method="post">
    <div class="card-body">
      <h3 class="form-section-title">Basic information</h3>
      <div class="form-group"><label class="form-label">Job title <span class="req">*</span></label>
        <input class="form-control" name="title" placeholder="e.g. Senior PHP Developer" value="<?php echo htmlspecialchars($job['title'] ?? ''); ?>" required></div>
      <div class="form-row cols-3">
        <div class="form-group"><label class="form-label">Category <span class="req">*</span></label>
          <select class="form-control" name="category_id" required>
            <option value="">Select</option>
            <?php while ($c = $categories->fetch_assoc()) { ?>
              <option value="<?php echo $c['id']; ?>" <?php if ($job['category_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
            <?php } ?>
          </select></div>
        <div class="form-group"><label class="form-label">Job type <span class="req">*</span></label>
          <select class="form-control" name="job_type">
            <?php foreach ($types as $key => $label) { ?>
              <option value="<?php echo $key; ?>" <?php if ($job['job_type'] == $key) echo 'selected'; ?>><?php echo $label; ?></option>
            <?php } ?>
          </select></div>
        <div class="form-group"><label class="form-label">Location <span class="req">*</span></label>
          <select class="form-control" name="city_id" required>
            <option value="">Select</option>
            <?php while ($c = $cities->fetch_assoc()) { ?>
              <option value="<?php echo $c['id']; ?>" <?php if ($job['city_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
            <?php } ?>
          </select></div>
      </div>
      <div class="form-row cols-3">
        <div class="form-group"><label class="form-label">Minimum salary (৳)</label><input class="form-control" type="number" name="salary_min" value="<?php echo $job['salary_min'] ? (int)$job['salary_min'] : ''; ?>"></div>
        <div class="form-group"><label class="form-label">Maximum salary (৳)</label><input class="form-control" type="number" name="salary_max" value="<?php echo $job['salary_max'] ? (int)$job['salary_max'] : ''; ?>"></div>
        <div class="form-group"><label class="form-label">Deadline <span class="req">*</span></label><input class="form-control" type="date" name="deadline" value="<?php echo $job['deadline']; ?>" required></div>
      </div>

      <h3 class="form-section-title mt-2">Job details</h3>
      <div class="form-group"><label class="form-label">Description <span class="req">*</span></label>
        <textarea class="form-control" name="description" rows="10" placeholder="About the role&#10;&#10;Responsibilities:&#10;- ...&#10;&#10;Requirements:&#10;- ..." required><?php echo htmlspecialchars($job['description'] ?? ''); ?></textarea>
        <div class="form-hint">Write responsibilities, requirements and benefits here. New lines are kept.</div></div>
      <div class="form-group"><label class="form-label">Skills</label>
        <input class="form-control" name="skills" placeholder="PHP, MySQL, Laravel" value="<?php echo htmlspecialchars($jobSkills); ?>">
        <div class="form-hint">Separate skills with commas.</div></div>
      <div class="form-actions">
        <a class="btn btn-light" href="manage-jobs.php">Cancel</a>
        <button class="btn btn-primary" type="submit"><?php echo $id ? 'Save changes' : 'Submit for approval'; ?></button>
      </div>
    </div>
  </form>
</main>
<?php include('include/footer.php'); ?>
