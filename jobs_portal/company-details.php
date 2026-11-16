<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TechNova Ltd | JobPortal BD</title>
  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- ===================== NAVBAR ===================== -->
<nav class="navbar navbar-expand-lg navbar-jp sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.html"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal<span class="text-primary">BD</span></a>
    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><i class="bi bi-list fs-2"></i></button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto gap-lg-1 my-3 my-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="jobs.php">Find Jobs</a></li>
        <li class="nav-item"><a class="nav-link active" href="companies.php">Companies</a></li>
        <li class="nav-item"><a class="nav-link" href="packages.php">Pricing</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <div class="d-flex gap-2">
        <a href="login.php" class="btn btn-soft-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        <a href="register-employer.php" class="btn btn-primary">Post a Job</a>
      </div>
    </div>
  </div>
</nav>

<section class="page-header pb-5">
  <div class="container position-relative pb-5" style="z-index:1">
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item"><a href="companies.php">Companies</a></li><li class="breadcrumb-item active">TechNova Ltd</li></ol></nav>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="detail-header mb-4">
      <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
        <div class="company-logo lg bg-primary-subtle text-primary">TN</div>
        <div class="flex-grow-1">
          <h1 class="h3 fw-800 mb-1">TechNova Ltd <i class="bi bi-patch-check-fill text-primary fs-5"></i></h1>
          <div class="job-meta mt-0"><span><i class="bi bi-geo-alt"></i>Banani, Dhaka</span><span><i class="bi bi-globe"></i><a href="https://technova.example.com" target="_blank">technova.example.com</a></span><span><i class="bi bi-briefcase"></i>3 open jobs</span></div>
        </div>
        <a href="#open-jobs" class="btn btn-primary">See Open Jobs</a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card-jp p-4 mb-4 content-block">
          <h5 class="mt-0">About Company</h5>
          <p class="text-muted">Software development company. TechNova builds custom web applications, ERP solutions and mobile apps for local and international clients. Our team of passionate engineers focuses on clean code, modern technologies and great user experiences.</p>
        </div>

        <h4 class="fw-bold mb-3" id="open-jobs">Open Positions (3)</h4>
        <div class="d-flex flex-column gap-3">
          <div class="job-card featured">
            <div class="d-flex flex-wrap justify-content-between gap-2">
              <div><h3 class="h6 fw-bold mb-1"><a href="job-details.php" class="stretched-link">Senior PHP Developer</a></h3>
                <div class="job-meta mt-0"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-clock"></i>Full Time</span><span><i class="bi bi-calendar-event"></i>19 Nov 2026</span></div></div>
              <span class="salary">৳60k - 90k</span>
            </div>
          </div>
          <div class="job-card">
            <div class="d-flex flex-wrap justify-content-between gap-2">
              <div><h3 class="h6 fw-bold mb-1"><a href="job-details.php" class="stretched-link">Laravel Intern</a></h3>
                <div class="job-meta mt-0"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-mortarboard"></i>Internship</span><span><i class="bi bi-calendar-event"></i>29 Nov 2026</span></div></div>
              <span class="salary">৳10,000</span>
            </div>
          </div>
          <div class="job-card">
            <div class="d-flex flex-wrap justify-content-between gap-2">
              <div><h3 class="h6 fw-bold mb-1"><a href="job-details.php" class="stretched-link">UI/UX Designer</a></h3>
                <div class="job-meta mt-0"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-wifi"></i>Remote</span><span><i class="bi bi-calendar-event"></i>24 Nov 2026</span></div></div>
              <span class="salary">৳40k - 60k</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card-jp p-4">
          <h5 class="fw-bold mb-2">Company Info</h5>
          <ul class="info-list">
            <li><span class="ic"><i class="bi bi-building"></i></span><div><small>Industry</small><strong>IT / Software</strong></div></li>
            <li><span class="ic"><i class="bi bi-geo-alt"></i></span><div><small>City</small><strong>Dhaka</strong></div></li>
            <li><span class="ic"><i class="bi bi-pin-map"></i></span><div><small>Address</small><strong>Banani, Dhaka</strong></div></li>
            <li><span class="ic"><i class="bi bi-globe"></i></span><div><small>Website</small><strong><a href="https://technova.example.com" target="_blank">technova.example.com</a></strong></div></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <a class="navbar-brand mb-3" href="index.html"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal<span class="text-accent">BD</span></a>
        <p class="pe-lg-5">Bangladesh's smart job portal connecting talented job seekers with trusted employers across Dhaka, Chattogram, Sylhet, Rajshahi and beyond.</p>
        <div class="social-links mt-3">
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h6>For Job Seekers</h6>
        <ul>
          <li><a href="jobs.php">Browse Jobs</a></li>
          <li><a href="register-seeker.php">Create Account</a></li>
          <li><a href="seeker/cv-preview.php">CV Builder</a></li>
          <li><a href="seeker/dashboard.php">Dashboard</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <h6>For Employers</h6>
        <ul>
          <li><a href="register-employer.php">Post a Job</a></li>
          <li><a href="packages.php">Pricing Plans</a></li>
          <li><a href="companies.php">Companies</a></li>
          <li><a href="employer/dashboard.php">Dashboard</a></li>
        </ul>
      </div>
      <div class="col-lg-4">
        <h6>Get Job Alerts</h6>
        <p>Subscribe and get the latest jobs straight to your inbox.</p>
        <form class="d-flex gap-2" action="#" method="post">
          <input type="email" class="form-control bg-transparent text-white border-secondary" placeholder="Your email address">
          <button class="btn btn-primary" type="submit"><i class="bi bi-send"></i></button>
        </form>
        <p class="mt-3 mb-1"><i class="bi bi-geo-alt me-2"></i>Banani, Dhaka 1213</p>
        <p class="mb-0"><i class="bi bi-envelope me-2"></i>support@jobportal.com</p>
      </div>
    </div>
    <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
      <span>&copy; 2026 JobPortal BD. All rights reserved.</span>
      <span><a href="#">Privacy Policy</a> &middot; <a href="#">Terms</a> &middot; <a href="contact.php">Help</a></span>
    </div>
  </div>
</footer>

<button class="back-to-top" type="button"><i class="bi bi-arrow-up"></i></button>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
