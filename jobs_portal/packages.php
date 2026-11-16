<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pricing Packages | JobPortal BD</title>
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
        <li class="nav-item"><a class="nav-link" href="companies.php">Companies</a></li>
        <li class="nav-item"><a class="nav-link active" href="packages.php">Pricing</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <div class="d-flex gap-2">
        <a href="login.php" class="btn btn-soft-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
        <a href="register-employer.php" class="btn btn-primary">Post a Job</a>
      </div>
    </div>
  </div>
</nav>

<section class="page-header text-center">
  <div class="container position-relative" style="z-index:1">
    <h1>Pricing Packages</h1>
    <p class="text-white-50 mb-0">Pick a plan that fits your hiring needs. Pay easily with bKash, Nagad, Rocket, Card or Bank.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="row g-4 justify-content-center align-items-center">
      <div class="col-md-6 col-lg-4">
        <div class="pricing-card">
          <div class="cat-icon bg-secondary-subtle text-secondary rounded-3 d-inline-flex p-3 mb-3"><i class="bi bi-rocket fs-4"></i></div>
          <h5 class="fw-bold">Free</h5>
          <p class="text-muted small">Post 1 job for 30 days</p>
          <div class="price">৳0 <small>/ 30 days</small></div>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> 1 job post</li>
            <li><i class="bi bi-check-circle-fill"></i> 30 days duration</li>
            <li><i class="bi bi-check-circle-fill"></i> Manage applicants</li>
            <li class="text-muted"><i class="bi bi-x-circle text-muted"></i> Featured listing</li>
          </ul>
          <a href="employer/subscription.php" class="btn btn-outline-primary w-100">Start Free</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="pricing-card popular">
          <span class="popular-ribbon">Most Popular</span>
          <div class="rounded-3 d-inline-flex p-3 mb-3" style="background:rgba(255,255,255,.15)"><i class="bi bi-lightning-charge fs-4"></i></div>
          <h5 class="fw-bold">Standard</h5>
          <p class="text-muted small">Post 5 jobs for 30 days</p>
          <div class="price">৳1,500 <small>/ 30 days</small></div>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> 5 job posts</li>
            <li><i class="bi bi-check-circle-fill"></i> 30 days duration</li>
            <li><i class="bi bi-check-circle-fill"></i> Manage applicants</li>
            <li><i class="bi bi-check-circle-fill"></i> Applicant notifications</li>
          </ul>
          <a href="employer/subscription.php" class="btn btn-light w-100 text-primary">Choose Standard</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="pricing-card">
          <div class="cat-icon bg-warning-subtle text-warning rounded-3 d-inline-flex p-3 mb-3"><i class="bi bi-gem fs-4"></i></div>
          <h5 class="fw-bold">Premium</h5>
          <p class="text-muted small">Post 20 jobs for 60 days, featured listing</p>
          <div class="price">৳4,000 <small>/ 60 days</small></div>
          <ul>
            <li><i class="bi bi-check-circle-fill"></i> 20 job posts</li>
            <li><i class="bi bi-check-circle-fill"></i> 60 days duration</li>
            <li><i class="bi bi-check-circle-fill"></i> Featured listing</li>
            <li><i class="bi bi-check-circle-fill"></i> Priority support</li>
          </ul>
          <a href="employer/subscription.php" class="btn btn-outline-primary w-100">Choose Premium</a>
        </div>
      </div>
    </div>

    <!-- Payment methods (table: payment_methods) -->
    <div class="text-center mt-5 pt-4">
      <h5 class="fw-bold mb-4">Accepted Payment Methods</h5>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <span class="card-jp px-4 py-3 fw-bold"><i class="bi bi-cash-coin text-success me-1"></i> Cash</span>
        <span class="card-jp px-4 py-3 fw-bold" style="color:#e2136e"><i class="bi bi-phone me-1"></i> bKash</span>
        <span class="card-jp px-4 py-3 fw-bold" style="color:#f6921e"><i class="bi bi-phone me-1"></i> Nagad</span>
        <span class="card-jp px-4 py-3 fw-bold" style="color:#8c3494"><i class="bi bi-phone me-1"></i> Rocket</span>
        <span class="card-jp px-4 py-3 fw-bold text-primary"><i class="bi bi-bank me-1"></i> Bank Transfer</span>
        <span class="card-jp px-4 py-3 fw-bold text-dark"><i class="bi bi-credit-card me-1"></i> Card</span>
      </div>
    </div>

    <!-- FAQ -->
    <div class="row justify-content-center mt-5 pt-4">
      <div class="col-lg-8">
        <h3 class="section-title text-center mb-4">Frequently Asked Questions</h3>
        <div class="accordion accordion-flush card-jp overflow-hidden" id="faq">
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#f1">How do I activate a package?</button></h2>
            <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#faq"><div class="accordion-body text-muted">Choose a package, pay with your preferred method and submit the transaction ID. Our admin will verify the payment and your subscription will be activated.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#f2">What happens when my posts run out?</button></h2>
            <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body text-muted">You can upgrade or renew your package at any time from your employer dashboard.</div></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header"><button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#f3">Are job posts reviewed?</button></h2>
            <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body text-muted">Yes. Every job is reviewed by our admin team before it goes live to keep the platform safe.</div></div>
          </div>
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
