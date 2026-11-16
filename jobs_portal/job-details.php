<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Senior PHP Developer | JobPortal BD</title>
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
        <li class="nav-item"><a class="nav-link active" href="jobs.php">Find Jobs</a></li>
        <li class="nav-item"><a class="nav-link" href="companies.php">Companies</a></li>
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
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item"><a href="jobs.php">Jobs</a></li><li class="breadcrumb-item active">Senior PHP Developer</li></ol></nav>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <!-- Header card -->
    <div class="detail-header mb-4">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <div class="d-flex flex-column flex-sm-row gap-4">
            <div class="company-logo lg bg-primary-subtle text-primary">TN</div>
            <div>
              <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                <h1 class="h3 fw-800 mb-0">Senior PHP Developer</h1>
                <span class="badge badge-featured"><i class="bi bi-star-fill"></i> Featured</span>
              </div>
              <p class="mb-2"><a href="company-details.php" class="fw-semibold">TechNova Ltd</a> <i class="bi bi-patch-check-fill text-primary" data-bs-toggle="tooltip" title="Verified employer"></i></p>
              <div class="job-meta mt-0"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-clock"></i>Full Time</span><span><i class="bi bi-tag"></i>IT / Software</span><span><i class="bi bi-people"></i>2 applicants</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex gap-2 justify-content-lg-end">
            <button class="btn btn-light btn-icon btn-lg btn-save" type="button" data-bs-toggle="tooltip" title="Save job"><i class="bi bi-bookmark"></i></button>
            <button class="btn btn-light btn-icon btn-lg" type="button" data-bs-toggle="tooltip" title="Share"><i class="bi bi-share"></i></button>
            <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#applyModal"><i class="bi bi-send me-1"></i> Apply Now</button>
          </div>
          <small class="text-danger d-block mt-2"><i class="bi bi-hourglass-split"></i> Application closes on 19 Nov 2026</small>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Main content -->
      <div class="col-lg-8">
        <div class="card-jp p-4 content-block">
          <h5 class="mt-0">Job Description</h5>
          <p class="text-muted">Build and maintain PHP/MySQL applications. You will work closely with our product and design teams to ship high quality web applications used by thousands of customers across Bangladesh.</p>

          <h5>Responsibilities</h5>
          <ul class="text-muted">
            <li>Develop, test and maintain PHP / Laravel based web applications</li>
            <li>Design normalized MySQL database schemas and write optimized queries</li>
            <li>Build secure REST APIs and integrate third-party services</li>
            <li>Review code and mentor junior developers</li>
          </ul>

          <h5>Requirements</h5>
          <ul class="text-muted">
            <li>3+ years of professional experience with PHP &amp; MySQL</li>
            <li>Strong knowledge of Laravel, OOP and MVC</li>
            <li>Familiar with Git, HTML, CSS and JavaScript</li>
          </ul>

          <h5>Required Skills</h5>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge badge-soft-primary fs-6">PHP</span>
            <span class="badge badge-soft-primary fs-6">MySQL</span>
            <span class="badge badge-soft-primary fs-6">Laravel</span>
          </div>

          <h5>Benefits</h5>
          <div class="row g-3">
            <div class="col-sm-6"><div class="d-flex gap-2"><i class="bi bi-check-circle-fill text-accent"></i> Festival bonus (2x yearly)</div></div>
            <div class="col-sm-6"><div class="d-flex gap-2"><i class="bi bi-check-circle-fill text-accent"></i> Lunch facility</div></div>
            <div class="col-sm-6"><div class="d-flex gap-2"><i class="bi bi-check-circle-fill text-accent"></i> Yearly salary review</div></div>
            <div class="col-sm-6"><div class="d-flex gap-2"><i class="bi bi-check-circle-fill text-accent"></i> Flexible working hours</div></div>
          </div>
        </div>

        <!-- Related jobs -->
        <h4 class="fw-bold mt-5 mb-3">Similar Jobs</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="job-card">
              <div class="d-flex gap-3">
                <div class="company-logo bg-primary-subtle text-primary">TN</div>
                <div><h3 class="h6 fw-bold mb-1"><a href="job-details.php" class="stretched-link">Laravel Intern</a></h3><p class="small text-muted mb-0">TechNova Ltd &middot; Dhaka</p></div>
              </div>
              <div class="job-card-footer"><span class="salary">৳10,000</span><span class="badge badge-soft-info">Internship</span></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="job-card">
              <div class="d-flex gap-3">
                <div class="company-logo bg-primary-subtle text-primary">TN</div>
                <div><h3 class="h6 fw-bold mb-1"><a href="job-details.php" class="stretched-link">UI/UX Designer</a></h3><p class="small text-muted mb-0">TechNova Ltd &middot; Remote</p></div>
              </div>
              <div class="job-card-footer"><span class="salary">৳40k - 60k</span><span class="badge badge-soft-accent">Remote</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="card-jp p-4 mb-4">
          <h5 class="fw-bold mb-2">Job Overview</h5>
          <ul class="info-list">
            <li><span class="ic"><i class="bi bi-cash-stack"></i></span><div><small>Salary</small><strong>৳60,000 - ৳90,000 / month</strong></div></li>
            <li><span class="ic"><i class="bi bi-briefcase"></i></span><div><small>Job Type</small><strong>Full Time</strong></div></li>
            <li><span class="ic"><i class="bi bi-tag"></i></span><div><small>Category</small><strong>IT / Software</strong></div></li>
            <li><span class="ic"><i class="bi bi-geo-alt"></i></span><div><small>Location</small><strong>Dhaka</strong></div></li>
            <li><span class="ic"><i class="bi bi-calendar-event"></i></span><div><small>Deadline</small><strong>19 November 2026</strong></div></li>
          </ul>
        </div>

        <div class="card-jp p-4">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="company-logo bg-primary-subtle text-primary">TN</div>
            <div><h6 class="fw-bold mb-0">TechNova Ltd</h6><small class="text-muted">Software development company</small></div>
          </div>
          <ul class="list-unstyled small text-muted mb-3">
            <li class="mb-2"><i class="bi bi-geo-alt me-2 text-primary"></i>Banani, Dhaka</li>
            <li class="mb-2"><i class="bi bi-globe me-2 text-primary"></i><a href="https://technova.example.com" target="_blank">technova.example.com</a></li>
            <li><i class="bi bi-briefcase me-2 text-primary"></i>3 open positions</li>
          </ul>
          <a href="company-details.php" class="btn btn-soft-primary w-100">View Company Profile</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Apply Modal (table: job_applications) ===== -->
<div class="modal fade" id="applyModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4" action="#" method="post" enctype="multipart/form-data">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="modal-title fw-bold">Apply for this job</h5>
          <small class="text-muted">Senior PHP Developer &middot; TechNova Ltd</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="job_id" value="8">
        <div class="mb-3">
          <label class="form-label">Choose Resume</label>
          <div class="form-check border rounded-3 p-3 ps-5 mb-2">
            <input class="form-check-input" type="radio" name="resume_option" id="r1" value="profile" checked>
            <label class="form-check-label" for="r1"><strong>Use my profile CV</strong><br><small class="text-muted">Generated from your JobPortal profile</small></label>
          </div>
          <div class="form-check border rounded-3 p-3 ps-5">
            <input class="form-check-input" type="radio" name="resume_option" id="r2" value="upload">
            <label class="form-check-label" for="r2"><strong>Upload a new resume</strong></label>
          </div>
        </div>
        <div class="upload-zone">
          <input type="file" name="resume_file" accept=".pdf,.doc,.docx" hidden>
          <i class="bi bi-cloud-arrow-up fs-1 text-primary"></i>
          <p class="mb-0 fw-semibold file-name">Click to upload your CV</p>
          <small class="text-muted">PDF, DOC up to 2MB</small>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Submit Application</button>
      </div>
    </form>
  </div>
</div>

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
