<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Companies | JobPortal BD</title>
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

<section class="page-header">
  <div class="container position-relative" style="z-index:1">
    <h1>Top Companies</h1>
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active">Companies</li></ol></nav>
  </div>
</section>

<section class="section pt-5">
  <div class="container">
    <form class="card-jp p-3 mb-5" action="companies.php" method="get">
      <div class="row g-2">
        <div class="col-md-6"><input type="text" name="q" class="form-control" placeholder="Search company name..."></div>
        <div class="col-md-4">
          <select name="city" class="form-select">
            <option value="">All Cities</option>
            <option value="1">Dhaka</option><option value="2">Chattogram</option><option value="3">Sylhet</option><option value="4">Rajshahi</option>
          </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary" type="submit"><i class="bi bi-search me-1"></i> Search</button></div>
      </div>
    </form>

    <div class="row g-4">
      <div class="col-sm-6 col-lg-4">
        <div class="company-card text-start">
          <div class="d-flex gap-3 align-items-center mb-3">
            <div class="company-logo lg bg-primary-subtle text-primary m-0">TN</div>
            <div><h5 class="fw-bold mb-1">TechNova Ltd</h5><span class="small text-muted"><i class="bi bi-geo-alt"></i> Banani, Dhaka</span></div>
          </div>
          <p class="text-muted small">Software development company.</p>
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="badge badge-soft-primary">3 Open Jobs</span>
            <a href="company-details.php" class="fw-semibold small">View Profile <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="company-card text-start">
          <div class="d-flex gap-3 align-items-center mb-3">
            <div class="company-logo lg bg-success-subtle text-success m-0">GL</div>
            <div><h5 class="fw-bold mb-1">GreenLeaf Traders</h5><span class="small text-muted"><i class="bi bi-geo-alt"></i> Agrabad, Chattogram</span></div>
          </div>
          <p class="text-muted small">Trading and distribution company.</p>
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="badge badge-soft-primary">3 Open Jobs</span>
            <a href="company-details.php" class="fw-semibold small">View Profile <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="company-card text-start">
          <div class="d-flex gap-3 align-items-center mb-3">
            <div class="company-logo lg bg-warning-subtle text-warning m-0">WP</div>
            <div><h5 class="fw-bold mb-1">WebPoint IT</h5><span class="small text-muted"><i class="bi bi-geo-alt"></i> Mirpur, Dhaka</span></div>
          </div>
          <p class="text-muted small">Web development and IT solutions agency.</p>
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="badge badge-soft-secondary">No open jobs</span>
            <a href="company-details.php" class="fw-semibold small">View Profile <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="company-card text-start">
          <div class="d-flex gap-3 align-items-center mb-3">
            <div class="company-logo lg bg-danger-subtle text-danger m-0">PH</div>
            <div><h5 class="fw-bold mb-1">PixelHouse</h5><span class="small text-muted"><i class="bi bi-geo-alt"></i> Zindabazar, Sylhet</span></div>
          </div>
          <p class="text-muted small">Creative branding and design studio.</p>
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="badge badge-soft-secondary">No open jobs</span>
            <a href="company-details.php" class="fw-semibold small">View Profile <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="company-card text-start">
          <div class="d-flex gap-3 align-items-center mb-3">
            <div class="company-logo lg bg-info-subtle text-info m-0">CB</div>
            <div><h5 class="fw-bold mb-1">CodeCamp BD</h5><span class="small text-muted"><i class="bi bi-geo-alt"></i> Uttara, Dhaka</span></div>
          </div>
          <p class="text-muted small">Coding bootcamp and training center.</p>
          <div class="d-flex justify-content-between align-items-center pt-3 border-top">
            <span class="badge badge-soft-secondary">No open jobs</span>
            <a href="company-details.php" class="fw-semibold small">View Profile <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="company-card d-flex flex-column justify-content-center align-items-center border-dashed" style="border-style:dashed">
          <i class="bi bi-building-add fs-1 text-primary mb-2"></i>
          <h5 class="fw-bold">Are you hiring?</h5>
          <p class="text-muted small">Create your company profile for free.</p>
          <a href="register-employer.php" class="btn btn-primary btn-sm">Register as Employer</a>
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
