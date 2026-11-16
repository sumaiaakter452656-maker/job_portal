<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CV Preview | JobPortal BD</title>
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="dash-body">
<div class="dash-wrapper">

  <!-- ===================== SIDEBAR (Job Seeker) ===================== -->
  <aside class="sidebar offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar">
    <div class="offcanvas-body">
      <div class="d-flex align-items-center justify-content-between">
        <a href="../index.html" class="sidebar-brand flex-grow-1"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal</a>
        <button type="button" class="btn-close btn-close-white d-lg-none me-3" data-bs-dismiss="offcanvas" data-bs-target="#sidebar"></button>
      </div>

      <div class="sidebar-heading">Main</div>
      <ul class="sidebar-nav">
        <li><a href="../seeker/dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
        <li><a href="../jobs.php"><i class="bi bi-search"></i> Browse Jobs</a></li>
        <li><a href="../crud/job_applications/index.php"><i class="bi bi-send-check"></i> Applied Jobs</a></li>
        <li><a href="../crud/saved_jobs/index.php"><i class="bi bi-bookmark-heart"></i> Saved Jobs</a></li>
      </ul>

      <div class="sidebar-heading">My CV</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/seekers/edit.php"><i class="bi bi-person-vcard"></i> Basic Profile</a></li>
        <li><a href="../crud/seeker_educations/index.php"><i class="bi bi-mortarboard"></i> Education</a></li>
        <li><a href="../crud/seeker_experiences/index.php"><i class="bi bi-briefcase"></i> Experience</a></li>
        <li><a href="../crud/seeker_skills/index.php"><i class="bi bi-lightning-charge"></i> Skills</a></li>
        <li><a href="../crud/seeker_cv_items/index.php"><i class="bi bi-award"></i> Projects &amp; Certificates</a></li>
        <li><a href="../seeker/cv-preview.php" class="active"><i class="bi bi-file-earmark-pdf"></i> CV Preview</a></li>
      </ul>

      <div class="sidebar-heading">Account</div>
      <ul class="sidebar-nav">
        <li><a href="../crud/notifications/index.php"><i class="bi bi-bell"></i> Notifications <span class="badge bg-danger">1</span></a></li>
        <li><a href="../crud/users/edit.php"><i class="bi bi-gear"></i> Account Settings</a></li>
        <li><a href="../login.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>

      <div class="sidebar-footer">
        <div class="sidebar-upgrade">
          <div class="small text-white-50">Profile strength</div>
          <div class="fw-bold mb-2">85% complete</div>
          <div class="progress mb-3" style="height:6px"><div class="progress-bar bg-accent" style="width:85%"></div></div>
          <a href="../crud/seekers/edit.php" class="btn btn-accent btn-sm w-100">Complete Profile</a>
        </div>
      </div>
    </div>
  </aside>

  <!-- ===================== MAIN ===================== -->
  <div class="dash-main">

    <!-- Topbar -->
    <header class="topbar">
      <button class="topbar-btn d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"><i class="bi bi-list"></i></button>
      <form class="search position-relative d-none d-md-block" action="#" method="get">
        <i class="bi bi-search"></i>
        <input type="search" class="form-control" placeholder="Search anything...">
      </form>
      <div class="ms-auto d-flex align-items-center gap-2">
        <a href="../index.html" class="topbar-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Website"><i class="bi bi-globe2"></i></a>

        <!-- Notifications (table: notifications) -->
        <div class="dropdown">
          <button class="topbar-btn" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"><i class="bi bi-bell"></i><span class="dot"></span></button>
          <div class="dropdown-menu dropdown-menu-end notif-dropdown">
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
              <strong>Notifications</strong>
              <a href="#" class="small">Mark all as read</a>
            </div>
            <a href="#" class="dropdown-item notif-item unread">
              <span class="ic bg-success-subtle text-success"><i class="bi bi-calendar-check"></i></span>
              <span><span class="d-block small fw-semibold">You have been invited to an interview for Senior PHP Developer</span><small class="text-muted">04 Nov 2026</small></span>
            </a>
            <a href="#" class="dropdown-item notif-item">
              <span class="ic bg-danger-subtle text-danger"><i class="bi bi-x-circle"></i></span>
              <span><span class="d-block small fw-semibold">Your application for Junior Accountant was not selected</span><small class="text-muted">05 Sep 2026</small></span>
            </a>
            <a href="../crud/notifications/index.php" class="d-block text-center py-2 small fw-semibold">View all notifications</a>
          </div>
        </div>

        <!-- User menu -->
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center gap-2 text-reset ms-1" data-bs-toggle="dropdown">
            <span class="avatar">RU</span>
            <span class="d-none d-sm-block lh-sm">
              <span class="fw-bold d-block">Rahim Uddin</span>
              <small class="text-muted">Job Seeker</small>
            </span>
            <i class="bi bi-chevron-down small text-muted d-none d-sm-block"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2">
            <li><a class="dropdown-item rounded-3" href="../crud/users/edit.php"><i class="bi bi-person me-2"></i>My Account</a></li>
            <li><a class="dropdown-item rounded-3" href="../crud/notifications/index.php"><i class="bi bi-bell me-2"></i>Notifications</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded-3 text-danger" href="../login.php"><i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="dash-content">

      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 page-title no-print">
        <div>
          <h1>CV Preview</h1>
          <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li><li class="breadcrumb-item active">CV Preview</li></ol></nav>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <!-- table: cv_templates -->
          <div class="btn-group">
            <button type="button" class="btn btn-light border active" data-cv-template="modern"><i class="bi bi-layout-sidebar me-1"></i> Modern</button>
            <button type="button" class="btn btn-light border" data-cv-template="classic"><i class="bi bi-file-text me-1"></i> Classic</button>
          </div>
          <button type="button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print / PDF</button>
        </div>
      </div>

      <!-- ========== MODERN TEMPLATE ========== -->
      <div id="cv-modern" class="cv-layout cv-paper cv-modern">
        <div class="cv-side">
          <div class="avatar xl bg-primary text-white mb-3">RU</div>
          <h3 class="text-white fw-800 mb-0">Rahim Uddin</h3>
          <p class="text-accent fw-semibold">Junior PHP Developer</p>

          <h6>Contact</h6>
          <p class="small mb-2"><i class="bi bi-envelope me-2"></i>seeker@jobportal.com</p>
          <p class="small mb-2"><i class="bi bi-telephone me-2"></i>01700000004</p>
          <p class="small mb-0"><i class="bi bi-geo-alt me-2"></i>Dhaka, Bangladesh</p>

          <h6>Skills</h6>
          <div class="d-flex flex-wrap gap-1">
            <span class="badge bg-secondary bg-opacity-25 text-light">PHP</span><span class="badge bg-secondary bg-opacity-25 text-light">MySQL</span><span class="badge bg-secondary bg-opacity-25 text-light">Laravel</span><span class="badge bg-secondary bg-opacity-25 text-light">JavaScript</span><span class="badge bg-secondary bg-opacity-25 text-light">HTML</span><span class="badge bg-secondary bg-opacity-25 text-light">CSS</span>
          </div>

          <h6>Languages</h6>
          <div class="d-flex justify-content-between small"><span>English</span><span class="text-accent">Good</span></div>

          <h6>Details</h6>
          <p class="small mb-1">Experience: <strong class="text-white">2 years</strong></p>
          <p class="small mb-0">Expected salary: <strong class="text-white">৳35,000</strong></p>
        </div>

        <div class="cv-mainc">
          <div class="cv-section-title mt-0"><i class="bi bi-person"></i> Profile</div>
          <p class="text-muted">PHP/MySQL developer who loves building web apps.</p>

          <div class="cv-section-title"><i class="bi bi-briefcase"></i> Experience</div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>Junior Web Developer</h6><span class="badge badge-soft-success">Jan 2024 – Present</span></div>
            <small class="text-primary fw-semibold">WebPoint IT</small>
          </div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>Intern</h6><span class="badge badge-soft-secondary">Jun 2023 – Dec 2023</span></div>
            <small class="text-primary fw-semibold">CodeCamp BD</small>
          </div>

          <div class="cv-section-title"><i class="bi bi-mortarboard"></i> Education</div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>BSc in CSE <small class="text-muted fw-normal">(Bachelor)</small></h6><span class="text-muted small">2023</span></div>
            <small>Daffodil International University &middot; <strong>CGPA 3.60</strong></small>
          </div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>Science <small class="text-muted fw-normal">(HSC)</small></h6><span class="text-muted small">2018</span></div>
            <small>Dhaka College &middot; <strong>GPA 5.00</strong></small>
          </div>

          <div class="cv-section-title"><i class="bi bi-kanban"></i> Projects</div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>Online Job Portal</h6><span class="text-muted small">Mar 2024 – Jun 2024</span></div>
            <small class="text-muted">Personal Project</small>
          </div>

          <div class="cv-section-title"><i class="bi bi-award"></i> Certificates</div>
          <div class="cv-item">
            <div class="d-flex justify-content-between flex-wrap"><h6>PHP &amp; MySQL Web Development</h6><span class="text-muted small">Jan 2023 – Jun 2023</span></div>
            <small class="text-muted">IsDB-BISEW</small>
          </div>
        </div>
      </div>

      <!-- ========== CLASSIC TEMPLATE ========== -->
      <div id="cv-classic" class="cv-layout cv-paper p-4 p-md-5 d-none">
        <div class="text-center border-bottom pb-3 mb-3">
          <h2 class="fw-800 mb-0">RAHIM UDDIN</h2>
          <p class="mb-1 fw-semibold text-primary">Junior PHP Developer</p>
          <small class="text-muted">seeker@jobportal.com &nbsp;|&nbsp; 01700000004 &nbsp;|&nbsp; Dhaka, Bangladesh</small>
        </div>
        <h6 class="fw-bold text-uppercase border-bottom pb-1">Career Summary</h6>
        <p class="small">PHP/MySQL developer who loves building web apps. 2 years of experience. Expected salary ৳35,000.</p>

        <h6 class="fw-bold text-uppercase border-bottom pb-1 mt-4">Employment History</h6>
        <table class="table table-sm table-borderless small mb-0">
          <tr><td style="width:180px" class="text-muted">Jan 2024 – Present</td><td><strong>Junior Web Developer</strong>, WebPoint IT</td></tr>
          <tr><td class="text-muted">Jun 2023 – Dec 2023</td><td><strong>Intern</strong>, CodeCamp BD</td></tr>
        </table>

        <h6 class="fw-bold text-uppercase border-bottom pb-1 mt-4">Academic Qualification</h6>
        <table class="table table-sm table-bordered small">
          <thead class="table-light"><tr><th>Level</th><th>Degree</th><th>Institution</th><th>Result</th><th>Year</th></tr></thead>
          <tbody>
            <tr><td>Bachelor</td><td>BSc in CSE</td><td>Daffodil International University</td><td>CGPA 3.60</td><td>2023</td></tr>
            <tr><td>HSC</td><td>Science</td><td>Dhaka College</td><td>GPA 5.00</td><td>2018</td></tr>
          </tbody>
        </table>

        <h6 class="fw-bold text-uppercase border-bottom pb-1 mt-4">Skills</h6>
        <p class="small">PHP, MySQL, Laravel, JavaScript, HTML, CSS</p>

        <h6 class="fw-bold text-uppercase border-bottom pb-1 mt-4">Projects &amp; Certificates</h6>
        <ul class="small">
          <li><strong>Online Job Portal</strong> — Personal Project (Mar 2024 – Jun 2024)</li>
          <li><strong>PHP &amp; MySQL Web Development</strong> — IsDB-BISEW (2023)</li>
        </ul>

        <h6 class="fw-bold text-uppercase border-bottom pb-1 mt-4">Language Proficiency</h6>
        <p class="small mb-0">English — Good</p>
      </div>
    </main>

    <footer class="dash-footer d-flex flex-column flex-sm-row justify-content-between gap-1">
      <span>&copy; 2026 JobPortal BD. All rights reserved.</span>
      <span>Made with <i class="bi bi-heart-fill text-danger"></i> in Bangladesh</span>
    </footer>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
