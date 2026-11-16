<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Browse Jobs | JobPortal BD</title>
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

<!-- ===================== PAGE HEADER ===================== -->
<section class="page-header">
  <div class="container position-relative" style="z-index:1">
    <h1>Browse Jobs</h1>
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active">Jobs</li></ol></nav>
  </div>
</section>

<section class="section pt-5">
  <div class="container">
    <div class="row g-4">

      <!-- ===== Filter sidebar ===== -->
      <div class="col-lg-3">
        <button class="btn btn-primary w-100 d-lg-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filters"><i class="bi bi-funnel me-1"></i> Filters</button>
        <form id="filters" class="collapse d-lg-block card-jp p-4 filter-card" action="jobs.php" method="get">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="fw-bold mb-0">Filters</h5>
            <a href="jobs.php" class="small">Clear all</a>
          </div>

          <div class="filter-group">
            <h6>Keyword</h6>
            <div class="position-relative">
              <input type="text" name="q" class="form-control" placeholder="e.g. PHP Developer">
            </div>
          </div>

          <div class="filter-group">
            <h6>Category</h6>
            <select name="category" class="form-select">
              <option value="">All Categories</option>
              <option value="1">IT / Software</option>
              <option value="2">Sales</option>
              <option value="3">Accounts</option>
              <option value="4">Design</option>
              <option value="6">Developer</option>
            </select>
          </div>

          <div class="filter-group">
            <h6>City</h6>
            <select name="city" class="form-select">
              <option value="">All Cities</option>
              <option value="1">Dhaka</option>
              <option value="2">Chattogram</option>
              <option value="3">Sylhet</option>
              <option value="4">Rajshahi</option>
            </select>
          </div>

          <div class="filter-group">
            <h6>Job Type</h6>
            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="type[]" value="full_time" id="t1"><label class="form-check-label" for="t1">Full Time</label></div>
            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="type[]" value="part_time" id="t2"><label class="form-check-label" for="t2">Part Time</label></div>
            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="type[]" value="contract" id="t3"><label class="form-check-label" for="t3">Contract</label></div>
            <div class="form-check mb-2"><input class="form-check-input" type="checkbox" name="type[]" value="internship" id="t4"><label class="form-check-label" for="t4">Internship</label></div>
            <div class="form-check"><input class="form-check-input" type="checkbox" name="type[]" value="remote" id="t5"><label class="form-check-label" for="t5">Remote</label></div>
          </div>

          <div class="filter-group">
            <h6>Salary Range (৳)</h6>
            <div class="row g-2">
              <div class="col-6"><input type="number" name="salary_min" class="form-control" placeholder="Min"></div>
              <div class="col-6"><input type="number" name="salary_max" class="form-control" placeholder="Max"></div>
            </div>
          </div>

          <div class="filter-group">
            <h6>Skills</h6>
            <div class="d-flex flex-wrap gap-2">
              <input type="checkbox" class="btn-check" name="skill[]" value="1" id="s1"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s1">PHP</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="2" id="s2"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s2">MySQL</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="3" id="s3"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s3">Laravel</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="4" id="s4"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s4">JavaScript</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="5" id="s5"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s5">HTML</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="6" id="s6"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s6">CSS</label>
              <input type="checkbox" class="btn-check" name="skill[]" value="7" id="s7"><label class="btn btn-sm btn-outline-secondary rounded-pill" for="s7">Excel</label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-3"><i class="bi bi-funnel me-1"></i> Apply Filters</button>
        </form>
      </div>

      <!-- ===== Job list ===== -->
      <div class="col-lg-9">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
          <p class="mb-0 text-muted">Showing <strong class="text-dark">6</strong> of <strong class="text-dark">6</strong> jobs</p>
          <div class="d-flex align-items-center gap-2">
            <span class="small text-muted text-nowrap">Sort by:</span>
            <select class="form-select form-select-sm" style="width:auto">
              <option>Newest first</option>
              <option>Deadline (soonest)</option>
              <option>Salary (high to low)</option>
              <option>Featured first</option>
            </select>
          </div>
        </div>

        <div class="d-flex flex-column gap-3">
          <!-- Job row -->
          <div class="job-card featured">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-primary-subtle text-primary">TN</div>
              <div class="flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-2">
                  <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">Senior PHP Developer</a></h3>
                  <span class="badge badge-featured"><i class="bi bi-star-fill"></i> Featured</span>
                </div>
                <p class="small text-muted mb-0">TechNova Ltd</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-clock"></i>Full Time</span><span><i class="bi bi-tag"></i>IT / Software</span><span><i class="bi bi-calendar-event"></i>Deadline: 19 Nov 2026</span></div>
                <div class="d-flex flex-wrap gap-1 mt-2"><span class="skill-tag">PHP</span><span class="skill-tag">MySQL</span><span class="skill-tag">Laravel</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳60,000 - 90,000</span>
              </div>
            </div>
          </div>

          <div class="job-card">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-primary-subtle text-primary">TN</div>
              <div class="flex-grow-1">
                <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">Laravel Intern</a></h3>
                <p class="small text-muted mb-0">TechNova Ltd</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-mortarboard"></i>Internship</span><span><i class="bi bi-tag"></i>IT / Software</span><span><i class="bi bi-calendar-event"></i>Deadline: 29 Nov 2026</span></div>
                <div class="d-flex flex-wrap gap-1 mt-2"><span class="skill-tag">PHP</span><span class="skill-tag">Laravel</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳10,000</span>
              </div>
            </div>
          </div>

          <div class="job-card featured">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-success-subtle text-success">GL</div>
              <div class="flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-2">
                  <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">Graphic Designer</a></h3>
                  <span class="badge badge-featured"><i class="bi bi-star-fill"></i> Featured</span>
                </div>
                <p class="small text-muted mb-0">GreenLeaf Traders</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Sylhet</span><span><i class="bi bi-clock-history"></i>Part Time</span><span><i class="bi bi-tag"></i>Design</span><span class="text-danger"><i class="bi bi-calendar-x text-danger"></i>Expired</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save saved" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳20,000 - 30,000</span>
              </div>
            </div>
          </div>

          <div class="job-card">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-success-subtle text-success">GL</div>
              <div class="flex-grow-1">
                <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">Sales Executive</a></h3>
                <p class="small text-muted mb-0">GreenLeaf Traders</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Chattogram</span><span><i class="bi bi-clock"></i>Full Time</span><span><i class="bi bi-tag"></i>Sales</span><span><i class="bi bi-calendar-event"></i>Deadline: 16 Nov 2026</span></div>
                <div class="d-flex flex-wrap gap-1 mt-2"><span class="skill-tag">Excel</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save saved" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳25,000 - 35,000</span>
              </div>
            </div>
          </div>

          <div class="job-card">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-primary-subtle text-primary">TN</div>
              <div class="flex-grow-1">
                <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">UI/UX Designer</a></h3>
                <p class="small text-muted mb-0">TechNova Ltd</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Dhaka</span><span><i class="bi bi-wifi"></i>Remote</span><span><i class="bi bi-tag"></i>Design</span><span><i class="bi bi-calendar-event"></i>Deadline: 24 Nov 2026</span></div>
                <div class="d-flex flex-wrap gap-1 mt-2"><span class="skill-tag">HTML</span><span class="skill-tag">CSS</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳40,000 - 60,000</span>
              </div>
            </div>
          </div>

          <div class="job-card">
            <div class="d-flex flex-column flex-md-row gap-3">
              <div class="company-logo bg-warning-subtle text-warning">GL</div>
              <div class="flex-grow-1">
                <h3 class="h5 fw-bold mb-0"><a href="job-details.php" class="stretched-link">Accounts Officer</a></h3>
                <p class="small text-muted mb-0">GreenLeaf Traders</p>
                <div class="job-meta"><span><i class="bi bi-geo-alt"></i>Rajshahi</span><span><i class="bi bi-clock"></i>Full Time</span><span><i class="bi bi-tag"></i>Accounts</span><span><i class="bi bi-calendar-event"></i>Deadline: 04 Dec 2026</span></div>
                <div class="d-flex flex-wrap gap-1 mt-2"><span class="skill-tag">Excel</span></div>
              </div>
              <div class="text-md-end d-flex flex-md-column justify-content-between align-items-md-end gap-2">
                <button class="btn btn-light btn-icon btn-save" type="button"><i class="bi bi-bookmark"></i></button>
                <span class="salary">৳30,000 - 40,000</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <nav class="mt-5">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a></li>
          </ul>
        </nav>
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
