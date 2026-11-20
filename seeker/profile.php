<?php
include('include/check.php');
$pageTitle = 'My Profile';
$error = '';

// কোন tab খোলা থাকবে (save করার পর একই tab-এ ফেরত আসার জন্য)
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'personal';

// ===== ১. Personal info save =====
if (isset($_POST['save_personal'])) {
  $name     = $conn->real_escape_string(trim($_POST['name']));
  $phone    = $conn->real_escape_string(trim($_POST['phone']));
  $headline = $conn->real_escape_string(trim($_POST['headline']));
  $summary  = $conn->real_escape_string(trim($_POST['summary']));
  $city     = (int)$_POST['city_id'] ? (int)$_POST['city_id'] : 'NULL';
  $category = (int)$_POST['category_id'] ? (int)$_POST['category_id'] : 'NULL';
  $years    = (int)$_POST['experience_years'];
  $salary   = !empty($_POST['expected_salary']) ? (int)$_POST['expected_salary'] : 'NULL';

  if ($name == '') {
    $error = 'Name is required.';
  } else {
    $conn->query("UPDATE users SET name = '$name', phone = '$phone' WHERE id = $userId");
    $conn->query("UPDATE seekers SET headline = '$headline', summary = '$summary', city_id = $city,
                  category_id = $category, experience_years = $years, expected_salary = $salary
                  WHERE id = $seekerId");
    $_SESSION['name'] = $_POST['name'];
    header("Location: profile.php?tab=personal&saved=1");
    exit;
  }
}

// ===== ২. Education যোগ / মুছে ফেলা =====
if (isset($_POST['add_education'])) {
  $level  = $conn->real_escape_string(trim($_POST['level']));
  $degree = $conn->real_escape_string(trim($_POST['degree_title']));
  $inst   = $conn->real_escape_string(trim($_POST['institution']));
  $result = $conn->real_escape_string(trim($_POST['result']));
  $year   = (int)$_POST['year'] ? (int)$_POST['year'] : 'NULL';
  if ($level == '' || $degree == '' || $inst == '') {
    $error = 'Level, degree and institution are required.';
    $tab = 'education';
  } else {
    $conn->query("INSERT INTO seeker_educations (seeker_id, level, degree_title, institution, result, year)
                  VALUES ($seekerId, '$level', '$degree', '$inst', '$result', $year)");
    header("Location: profile.php?tab=education&saved=1");
    exit;
  }
}
if (isset($_GET['del_edu'])) {
  $eid = (int)$_GET['del_edu'];
  $conn->query("DELETE FROM seeker_educations WHERE id = $eid AND seeker_id = $seekerId");
  header("Location: profile.php?tab=education");
  exit;
}

// ===== ৩. Experience যোগ / মুছে ফেলা =====
if (isset($_POST['add_experience'])) {
  $cname   = $conn->real_escape_string(trim($_POST['company_name']));
  $desig   = $conn->real_escape_string(trim($_POST['designation']));
  $start   = $conn->real_escape_string($_POST['start_date']);
  $current = isset($_POST['is_current']) ? 1 : 0;
  $end     = ($current || $_POST['end_date'] == '') ? 'NULL' : "'" . $conn->real_escape_string($_POST['end_date']) . "'";
  if ($cname == '' || $desig == '' || $start == '') {
    $error = 'Company, designation and start date are required.';
    $tab = 'experience';
  } else {
    $conn->query("INSERT INTO seeker_experiences (seeker_id, company_name, designation, start_date, end_date, is_current)
                  VALUES ($seekerId, '$cname', '$desig', '$start', $end, $current)");
    header("Location: profile.php?tab=experience&saved=1");
    exit;
  }
}
if (isset($_GET['del_exp'])) {
  $xid = (int)$_GET['del_exp'];
  $conn->query("DELETE FROM seeker_experiences WHERE id = $xid AND seeker_id = $seekerId");
  header("Location: profile.php?tab=experience");
  exit;
}

// ===== ৪. Skills আর CV =====
if (isset($_POST['save_skills'])) {
  // পুরনো skill মুছে নতুন করে বসানো
  $conn->query("DELETE FROM seeker_skills WHERE seeker_id = $seekerId");
  foreach (explode(',', $_POST['skills']) as $sname) {
    $sname = $conn->real_escape_string(trim($sname));
    if ($sname == '') continue;
    $found = $conn->query("SELECT id FROM skills WHERE name = '$sname'")->fetch_assoc();
    if ($found) {
      $skillId = $found['id'];
    } else {
      $conn->query("INSERT INTO skills (name) VALUES ('$sname')");
      $skillId = $conn->insert_id;
    }
    $conn->query("INSERT INTO seeker_skills (seeker_id, skill_id) VALUES ($seekerId, $skillId)");
  }

  // CV upload (শুধু PDF, সর্বোচ্চ 2MB)
  if (isset($_FILES['resume']) && $_FILES['resume']['name'] != '') {
    $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    if ($ext != 'pdf') {
      $error = 'CV must be a PDF file.';
    } else if ($_FILES['resume']['size'] > 2 * 1024 * 1024) {
      $error = 'CV must be smaller than 2MB.';
    } else {
      if (!is_dir('../uploads/cv')) {
        mkdir('../uploads/cv', 0777, true);
      }
      $file = 'uploads/cv/seeker_' . $seekerId . '_' . time() . '.pdf';
      move_uploaded_file($_FILES['resume']['tmp_name'], '../' . $file);
      $conn->query("UPDATE seekers SET resume_file = '$file' WHERE id = $seekerId");
    }
  }
  if ($error == '') {
    header("Location: profile.php?tab=resume&saved=1");
    exit;
  }
  $tab = 'resume';
}

// ===== ৫ক. Project / Certificate / Language যোগ / মুছে ফেলা (seeker_cv_items) =====
if (isset($_POST['add_item'])) {
  $type  = in_array($_POST['type'], array('project', 'certificate', 'language')) ? $_POST['type'] : 'project';
  $title = $conn->real_escape_string(trim($_POST['title']));
  $org   = $conn->real_escape_string(trim($_POST['organization']));
  $level = $conn->real_escape_string(trim($_POST['level']));
  $start = $_POST['start_date'] != '' ? "'" . $conn->real_escape_string($_POST['start_date']) . "'" : 'NULL';
  $end   = $_POST['end_date'] != '' ? "'" . $conn->real_escape_string($_POST['end_date']) . "'" : 'NULL';
  if ($title == '') {
    $error = 'Title is required.';
    $tab = 'items';
  } else {
    $conn->query("INSERT INTO seeker_cv_items (seeker_id, type, title, organization, level, start_date, end_date)
                  VALUES ($seekerId, '$type', '$title', '$org', '$level', $start, $end)");
    header("Location: profile.php?tab=items&saved=1");
    exit;
  }
}
if (isset($_GET['del_item'])) {
  $iid = (int)$_GET['del_item'];
  $conn->query("DELETE FROM seeker_cv_items WHERE id = $iid AND seeker_id = $seekerId");
  header("Location: profile.php?tab=items");
  exit;
}

// ===== ৫. Password বদলানো =====
if (isset($_POST['change_password'])) {
  $old = sha1($_POST['old_password']);
  $check = $conn->query("SELECT id FROM users WHERE id = $userId AND password = '$old'");
  if ($check->num_rows == 0) {
    $error = 'Current password is wrong.';
  } else if ($_POST['new_password'] == '' || $_POST['new_password'] != $_POST['confirm_password']) {
    $error = 'New passwords do not match.';
  } else {
    $new = sha1($_POST['new_password']);
    $conn->query("UPDATE users SET password = '$new' WHERE id = $userId");
    header("Location: profile.php?tab=password&saved=1");
    exit;
  }
  $tab = 'password';
}

// ===== পেজে দেখানোর জন্য নতুন করে তথ্য আনা =====
$me = $conn->query("SELECT seekers.*, users.name, users.email, users.phone FROM seekers
                    JOIN users ON users.id = seekers.user_id WHERE seekers.id = $seekerId")->fetch_assoc();
$educations  = $conn->query("SELECT * FROM seeker_educations WHERE seeker_id = $seekerId ORDER BY year DESC");
$experiences = $conn->query("SELECT * FROM seeker_experiences WHERE seeker_id = $seekerId ORDER BY start_date DESC");
$items       = $conn->query("SELECT * FROM seeker_cv_items WHERE seeker_id = $seekerId ORDER BY type, start_date DESC");
$mySkills    = $conn->query("SELECT skills.name FROM seeker_skills JOIN skills ON skills.id = seeker_skills.skill_id WHERE seeker_skills.seeker_id = $seekerId");
$skillNames = array();
while ($s = $mySkills->fetch_assoc()) { $skillNames[] = $s['name']; }
$cities     = $conn->query("SELECT * FROM cities ORDER BY name");
$categories = $conn->query("SELECT * FROM categories ORDER BY name");

// Profile কতটা পূর্ণ (সহজ হিসাব)
$done = 0;
if ($me['headline']) $done++;
if ($me['summary']) $done++;
if ($me['city_id']) $done++;
if ($me['resume_file']) $done++;
if ($educations->num_rows > 0) $done++;
if ($experiences->num_rows > 0) $done++;
if (count($skillNames) > 0) $done++;
$percent = round($done / 7 * 100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>My profile</h2><p>Employers see this information when you apply.</p></div>
    <span class="badge <?php echo $percent == 100 ? 'badge-success' : 'badge-warning'; ?>">Profile <?php echo $percent; ?>% complete</span>
  </div>

  <?php if (isset($_GET['saved'])) { ?><div class="alert alert-success"><span>Saved successfully.</span></div><?php } ?>
  <?php if ($error != '') { ?><div class="alert alert-danger"><span><?php echo $error; ?></span></div><?php } ?>

  <div class="card" data-tabs>
    <div class="card-body">
      <div class="tabs">
        <button class="tab-btn <?php if ($tab == 'personal') echo 'active'; ?>" data-tab="p-personal">Personal info</button>
        <button class="tab-btn <?php if ($tab == 'education') echo 'active'; ?>" data-tab="p-edu">Education</button>
        <button class="tab-btn <?php if ($tab == 'experience') echo 'active'; ?>" data-tab="p-exp">Experience</button>
        <button class="tab-btn <?php if ($tab == 'items') echo 'active'; ?>" data-tab="p-items">Projects &amp; More</button>
        <button class="tab-btn <?php if ($tab == 'resume') echo 'active'; ?>" data-tab="p-resume">Skills &amp; CV</button>
        <button class="tab-btn <?php if ($tab == 'password') echo 'active'; ?>" data-tab="p-pass">Password</button>
      </div>

      <!-- ===== Personal info ===== -->
      <div class="tab-pane <?php if ($tab == 'personal') echo 'active'; ?>" id="p-personal">
        <form action="" method="post">
          <div class="form-row">
            <div class="form-group"><label class="form-label">Full name <span class="req">*</span></label><input class="form-control" name="name" value="<?php echo htmlspecialchars($me['name']); ?>" required></div>
            <div class="form-group"><label class="form-label">Professional title</label><input class="form-control" name="headline" placeholder="e.g. Junior PHP Developer" value="<?php echo htmlspecialchars($me['headline']); ?>"></div>
            <div class="form-group"><label class="form-label">Email (login)</label><input class="form-control" value="<?php echo $me['email']; ?>" readonly></div>
            <div class="form-group"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?php echo htmlspecialchars($me['phone']); ?>"></div>
            <div class="form-group"><label class="form-label">City</label>
              <select class="form-control" name="city_id">
                <option value="">Select</option>
                <?php while ($c = $cities->fetch_assoc()) { ?>
                  <option value="<?php echo $c['id']; ?>" <?php if ($me['city_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
                <?php } ?>
              </select></div>
            <div class="form-group"><label class="form-label">Job category</label>
              <select class="form-control" name="category_id">
                <option value="">Select</option>
                <?php while ($c = $categories->fetch_assoc()) { ?>
                  <option value="<?php echo $c['id']; ?>" <?php if ($me['category_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['name']; ?></option>
                <?php } ?>
              </select></div>
            <div class="form-group"><label class="form-label">Experience (years)</label><input class="form-control" type="number" min="0" name="experience_years" value="<?php echo (int)$me['experience_years']; ?>"></div>
            <div class="form-group"><label class="form-label">Expected salary (৳)</label><input class="form-control" type="number" name="expected_salary" value="<?php echo $me['expected_salary'] ? (int)$me['expected_salary'] : ''; ?>"></div>
          </div>
          <div class="form-group"><label class="form-label">About me</label><textarea class="form-control" name="summary" rows="4"><?php echo htmlspecialchars($me['summary']); ?></textarea></div>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="save_personal">Save changes</button></div>
        </form>
      </div>

      <!-- ===== Education ===== -->
      <div class="tab-pane <?php if ($tab == 'education') echo 'active'; ?>" id="p-edu">
        <ul class="timeline mb-3">
          <?php if ($educations->num_rows == 0) { ?><li><p class="muted mb-0">No education added yet.</p></li><?php } ?>
          <?php while ($e = $educations->fetch_assoc()) { ?>
            <li>
              <h4><?php echo $e['level']; ?> — <?php echo $e['degree_title']; ?></h4>
              <p class="muted mb-0"><?php echo $e['institution']; ?><?php if ($e['year']) echo ' · ' . $e['year']; ?><?php if ($e['result']) echo ' · ' . $e['result']; ?>
                · <a href="profile.php?del_edu=<?php echo $e['id']; ?>" onclick="return confirm('Delete this education?')">Delete</a></p>
            </li>
          <?php } ?>
        </ul>
        <form action="" method="post" class="card"><div class="card-body">
          <h4>Add education</h4>
          <div class="form-row">
            <div class="form-group"><label class="form-label">Level <span class="req">*</span></label><input class="form-control" name="level" placeholder="SSC / HSC / Bachelor / Masters"></div>
            <div class="form-group"><label class="form-label">Degree <span class="req">*</span></label><input class="form-control" name="degree_title" placeholder="e.g. BSc in CSE"></div>
            <div class="form-group"><label class="form-label">Institution <span class="req">*</span></label><input class="form-control" name="institution"></div>
            <div class="form-group"><label class="form-label">Passing year</label><input class="form-control" type="number" name="year" placeholder="2023"></div>
            <div class="form-group"><label class="form-label">Result</label><input class="form-control" name="result" placeholder="CGPA 3.50"></div>
          </div>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="add_education">+ Add</button></div>
        </div></form>
      </div>

      <!-- ===== Experience ===== -->
      <div class="tab-pane <?php if ($tab == 'experience') echo 'active'; ?>" id="p-exp">
        <ul class="timeline mb-3">
          <?php if ($experiences->num_rows == 0) { ?><li><p class="muted mb-0">No experience added yet.</p></li><?php } ?>
          <?php while ($x = $experiences->fetch_assoc()) { ?>
            <li>
              <h4><?php echo $x['designation']; ?></h4>
              <p class="muted mb-0"><?php echo $x['company_name']; ?> ·
                <?php echo date('M Y', strtotime($x['start_date'])); ?> –
                <?php echo $x['is_current'] ? 'Present' : ($x['end_date'] ? date('M Y', strtotime($x['end_date'])) : ''); ?>
                · <a href="profile.php?del_exp=<?php echo $x['id']; ?>" onclick="return confirm('Delete this experience?')">Delete</a></p>
            </li>
          <?php } ?>
        </ul>
        <form action="" method="post" class="card"><div class="card-body">
          <h4>Add experience</h4>
          <div class="form-row">
            <div class="form-group"><label class="form-label">Designation <span class="req">*</span></label><input class="form-control" name="designation"></div>
            <div class="form-group"><label class="form-label">Company <span class="req">*</span></label><input class="form-control" name="company_name"></div>
            <div class="form-group"><label class="form-label">From <span class="req">*</span></label><input class="form-control" type="date" name="start_date"></div>
            <div class="form-group"><label class="form-label">To</label><input class="form-control" type="date" name="end_date"></div>
          </div>
          <label class="check mb-2"><input type="checkbox" name="is_current"> I currently work here</label>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="add_experience">+ Add</button></div>
        </div></form>
      </div>

      <!-- ===== Projects, Certificates, Languages ===== -->
      <div class="tab-pane <?php if ($tab == 'items') echo 'active'; ?>" id="p-items">
        <ul class="timeline mb-3">
          <?php if ($items->num_rows == 0) { ?><li><p class="muted mb-0">No projects, certificates or languages added yet.</p></li><?php } ?>
          <?php while ($it = $items->fetch_assoc()) { ?>
            <li>
              <h4><span class="badge badge-primary"><?php echo ucfirst($it['type']); ?></span> <?php echo htmlspecialchars($it['title']); ?></h4>
              <p class="muted mb-0">
                <?php echo htmlspecialchars(trim($it['organization'] . ' ' . ($it['level'] ? '· ' . $it['level'] : ''))); ?>
                <?php if ($it['start_date']) echo ' · ' . date('M Y', strtotime($it['start_date'])) . ($it['end_date'] ? ' – ' . date('M Y', strtotime($it['end_date'])) : ''); ?>
                · <a href="profile.php?del_item=<?php echo $it['id']; ?>" onclick="return confirm('Delete this item?')">Delete</a></p>
            </li>
          <?php } ?>
        </ul>
        <form action="" method="post" class="card"><div class="card-body">
          <h4>Add project, certificate or language</h4>
          <div class="form-row">
            <div class="form-group"><label class="form-label">Type</label>
              <select class="form-control" name="type"><option value="project">Project</option><option value="certificate">Certificate</option><option value="language">Language</option></select></div>
            <div class="form-group"><label class="form-label">Title <span class="req">*</span></label><input class="form-control" name="title" placeholder="e.g. Job Portal / PHP Course / English"></div>
            <div class="form-group"><label class="form-label">Organization</label><input class="form-control" name="organization" placeholder="e.g. Personal project / IsDB-BISEW"></div>
            <div class="form-group"><label class="form-label">Level (for language)</label><input class="form-control" name="level" placeholder="e.g. Fluent / Good"></div>
            <div class="form-group"><label class="form-label">From</label><input class="form-control" type="date" name="start_date"></div>
            <div class="form-group"><label class="form-label">To</label><input class="form-control" type="date" name="end_date"></div>
          </div>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="add_item">+ Add</button></div>
        </div></form>
      </div>

      <!-- ===== Skills & CV ===== -->
      <div class="tab-pane <?php if ($tab == 'resume') echo 'active'; ?>" id="p-resume">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group"><label class="form-label">Skills</label>
            <input class="form-control" name="skills" placeholder="PHP, MySQL, JavaScript" value="<?php echo htmlspecialchars(implode(', ', $skillNames)); ?>">
            <div class="form-hint">Separate with commas.</div></div>
          <div class="tags mb-3">
            <?php foreach ($skillNames as $sn) { ?><span class="tag"><?php echo $sn; ?></span><?php } ?>
          </div>
          <div class="form-group">
            <label class="form-label">Resume / CV</label>
            <?php if ($me['resume_file']) { ?>
              <p>Current CV: <a href="../<?php echo $me['resume_file']; ?>" target="_blank"><?php echo basename($me['resume_file']); ?></a></p>
            <?php } else { ?>
              <p class="muted">No CV uploaded yet.</p>
            <?php } ?>
            <label class="file-drop"><span class="file-name">Upload a new CV (PDF, max 2MB)</span><input type="file" name="resume" accept=".pdf"></label>
          </div>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="save_skills">Save</button></div>
        </form>
      </div>

      <!-- ===== Password ===== -->
      <div class="tab-pane <?php if ($tab == 'password') echo 'active'; ?>" id="p-pass">
        <form action="" method="post" style="max-width:420px">
          <div class="form-group"><label class="form-label">Current password</label><input class="form-control" type="password" name="old_password" required></div>
          <div class="form-group"><label class="form-label">New password</label><input class="form-control" type="password" name="new_password" required></div>
          <div class="form-group"><label class="form-label">Confirm new password</label><input class="form-control" type="password" name="confirm_password" required></div>
          <div class="form-actions"><button class="btn btn-primary" type="submit" name="change_password">Change password</button></div>
        </form>
      </div>
    </div>
  </div>
</main>
<footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
