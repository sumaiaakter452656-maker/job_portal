<?php
include('include/check.php');
$pageTitle = 'CV Builder';

// লেখা নিরাপদে দেখানোর ছোট function
function e($text) {
  return htmlspecialchars((string)$text);
}

// ===== নতুন template গুলো database-এ না থাকলে যোগ করা =====
$extra = array('Minimal' => 'templates/minimal.php', 'Executive' => 'templates/executive.php');
foreach ($extra as $tname => $tfile) {
  if ($conn->query("SELECT id FROM cv_templates WHERE layout_file = '$tfile'")->num_rows == 0) {
    $conn->query("INSERT INTO cv_templates (name, layout_file, is_premium, status) VALUES ('$tname', '$tfile', 0, 'active')");
  }
}
$templates = $conn->query("SELECT * FROM cv_templates WHERE status = 'active' ORDER BY id");
$list = array();
while ($t = $templates->fetch_assoc()) { $list[$t['id']] = $t; }

// ===== Template বাছাই করে save (?choose=ID) =====
if (isset($_GET['choose']) && isset($list[(int)$_GET['choose']])) {
  $tid = (int)$_GET['choose'];
  $conn->query("UPDATE seekers SET cv_template_id = $tid WHERE id = $seekerId");
  header("Location: cv.php");
  exit;
}

// কোন template দেখাবো: ?preview=ID (ছোট ছবির জন্য), না হলে নিজের বাছাই করা, না হলে প্রথমটা
$currentId = isset($list[(int)$me['cv_template_id']]) ? (int)$me['cv_template_id'] : (int)key($list);
$showId = isset($_GET['preview']) && isset($list[(int)$_GET['preview']]) ? (int)$_GET['preview'] : $currentId;

// ===== CV-এর সব তথ্য profile থেকে =====
$cv = array(
  'name'     => $me['name'],
  'headline' => $me['headline'],
  'email'    => $me['email'],
  'phone'    => $me['phone'],
  'city'     => $me['city_name'],
  'summary'  => $me['summary'],
  'years'    => (int)$me['experience_years'],
  'skills' => array(), 'educations' => array(), 'experiences' => array(),
  'projects' => array(), 'certificates' => array(), 'languages' => array(),
);
$r = $conn->query("SELECT skills.name FROM seeker_skills JOIN skills ON skills.id = seeker_skills.skill_id WHERE seeker_skills.seeker_id = $seekerId");
while ($x = $r->fetch_assoc()) { $cv['skills'][] = $x['name']; }
$r = $conn->query("SELECT * FROM seeker_educations WHERE seeker_id = $seekerId ORDER BY year DESC");
while ($x = $r->fetch_assoc()) { $cv['educations'][] = $x; }
$r = $conn->query("SELECT * FROM seeker_experiences WHERE seeker_id = $seekerId ORDER BY is_current DESC, start_date DESC");
while ($x = $r->fetch_assoc()) { $cv['experiences'][] = $x; }
$r = $conn->query("SELECT * FROM seeker_cv_items WHERE seeker_id = $seekerId ORDER BY start_date DESC");
while ($x = $r->fetch_assoc()) {
  if ($x['type'] == 'project') $cv['projects'][] = $x;
  if ($x['type'] == 'certificate') $cv['certificates'][] = $x;
  if ($x['type'] == 'language') $cv['languages'][] = $x;
}

// তারিখ সুন্দর করে লেখা (যেমন Jan 2024 – Present)
function cv_dates($start, $end, $current = 0) {
  $s = $start ? date('M Y', strtotime($start)) : '';
  $t = $current ? 'Present' : ($end ? date('M Y', strtotime($end)) : '');
  return trim($s . ($s && $t ? ' – ' : '') . $t);
}

// ===== শুধু CV (print / PDF / ছোট ছবির জন্য) =====
// ?preview=ID ছোট ছবি, ?view=1 শুধু CV, ?pdf=1 নিজে থেকে PDF download, ?print=1 নিজে থেকে print
$fullView = isset($_GET['print']) || isset($_GET['pdf']) || isset($_GET['view']);
if ($fullView || isset($_GET['preview'])) {
  $file = 'templates/' . basename($list[$showId]['layout_file']);
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo e($cv['name']); ?> - CV</title>
  <style>
    @page { size: A4; margin: 0; }
    * { box-sizing: border-box; }
    body { margin: 0; background: #e2e8f0; font-family: "Segoe UI", Arial, sans-serif; color: #1e293b; }
    .cv-page { width: 210mm; min-height: 297mm; margin: 0 auto; background: #fff; }
    @media print { body { background: #fff; } }
    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    .cv-toolbar { text-align: center; padding: 14px; }
    .cv-toolbar button { font: inherit; font-weight: 600; padding: 10px 18px; margin: 0 4px; border: 0; border-radius: 8px; cursor: pointer; }
    .btn-pdf { background: #0369a1; color: #fff; }
    .btn-print { background: #fff; color: #0f172a; border: 1px solid #cbd5e1 !important; }
    @media print { .cv-toolbar { display: none; } }
  </style>
</head>
<body>
  <?php if ($fullView) { ?>
    <div class="cv-toolbar">
      <button class="btn-pdf" onclick="downloadPdf()">⬇ Download PDF</button>
      <button class="btn-print" onclick="window.print()">🖨 Print</button>
    </div>
  <?php } ?>
  <div class="cv-page" id="cv">
    <?php if (file_exists($file)) { include($file); } else { echo '<p style="padding:40px">Template file not found.</p>'; } ?>
  </div>
  <?php if ($fullView) { ?>
    <!-- html2pdf: পেজটাকে সরাসরি PDF ফাইল বানায় (internet লাগবে) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
      function downloadPdf() {
        html2pdf().set({
          margin: 0,
          filename: <?php echo json_encode(preg_replace('/[^A-Za-z0-9]+/', '-', $cv['name']) . '-CV.pdf'); ?>,
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: { scale: 2, useCORS: true },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        }).from(document.getElementById('cv')).save();
      }
      <?php if (isset($_GET['pdf'])) { ?>window.onload = downloadPdf;<?php } ?>
      <?php if (isset($_GET['print'])) { ?>window.onload = function () { window.print(); };<?php } ?>
    </script>
  <?php } ?>
</body>
</html>
  <?php
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CV Builder | JobHub</title>
  <link rel="stylesheet" href="../assets/css/style.css?v=2">
  <style>
    .tpl-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 14px; }
    .tpl-card { border: 2px solid var(--border); border-radius: 12px; overflow: hidden; background: #fff; text-align: center; }
    .tpl-card.active { border-color: var(--primary); box-shadow: var(--shadow); }
    .tpl-thumb { height: 200px; overflow: hidden; position: relative; background: #f1f5f9; }
    .tpl-thumb iframe { width: 794px; height: 1123px; border: 0; transform: scale(0.19); transform-origin: 0 0; position: absolute; left: 0; top: 0; pointer-events: none; }
    .tpl-card .tpl-name { padding: 8px; font-weight: 600; }
    .cv-preview { width: 100%; height: 1150px; border: 1px solid var(--border); border-radius: 12px; background: #e2e8f0; }
  </style>
</head>
<body class="dash-body">
<?php include('include/menu.php'); ?>
<main class="dash-content">

  <div class="page-actions">
    <div><h2>CV Builder</h2><p>Your CV is made from your profile. Pick a template and download it as PDF.</p></div>
    <div class="flex gap-2">
      <a class="btn btn-light" href="profile.php">Edit profile</a>
      <a class="btn btn-light" href="cv.php?print=1" target="_blank">🖨 Print</a>
      <a class="btn btn-primary" href="cv.php?pdf=1" target="_blank">⬇ Download PDF</a>
    </div>
  </div>

  <?php if (count($cv['experiences']) == 0 || count($cv['educations']) == 0 || count($cv['skills']) == 0) { ?>
    <div class="alert alert-warning"><span>Your CV looks better with education, experience and skills. <a href="profile.php">Complete your profile</a>.</span></div>
  <?php } ?>

  <div class="card mb-3">
    <div class="card-header"><h3>Choose a template</h3></div>
    <div class="card-body">
      <div class="tpl-grid">
        <?php foreach ($list as $tid => $t) { ?>
          <a class="tpl-card <?php if ($tid == $currentId) echo 'active'; ?>" href="cv.php?choose=<?php echo $tid; ?>">
            <div class="tpl-thumb"><iframe src="cv.php?preview=<?php echo $tid; ?>" loading="lazy" tabindex="-1"></iframe></div>
            <div class="tpl-name"><?php echo e($t['name']); ?><?php if ($tid == $currentId) echo ' ✓'; ?></div>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h3>Preview — <?php echo e($list[$currentId]['name']); ?></h3>
      <span class="small muted">"Download PDF" saves the file directly.</span></div>
    <div class="card-body">
      <iframe class="cv-preview" src="cv.php?preview=<?php echo $currentId; ?>"></iframe>
    </div>
  </div>
</main>
<footer class="dash-footer">&copy; 2026 JobHub — Dashboard</footer>
</div>
<script src="../assets/js/main.js"></script>
</body>
</html>
