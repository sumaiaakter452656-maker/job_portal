<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us | JobPortal BD</title>
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
        <li class="nav-item"><a class="nav-link" href="packages.php">Pricing</a></li>
        <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
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
    <h1>Contact Us</h1>
    <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="index.html">Home</a></li><li class="breadcrumb-item active">Contact</li></ol></nav>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="card-jp p-4 h-100">
          <h4 class="fw-bold mb-3">Get in touch</h4>
          <p class="text-muted">Have a question about jobs, packages or payments? Our team is happy to help.</p>
          <ul class="info-list">
            <li><span class="ic"><i class="bi bi-geo-alt"></i></span><div><small>Office</small><strong>Banani, Dhaka 1213</strong></div></li>
            <li><span class="ic"><i class="bi bi-telephone"></i></span><div><small>Phone</small><strong>01700-000001</strong></div></li>
            <li><span class="ic"><i class="bi bi-envelope"></i></span><div><small>Email</small><strong>support@jobportal.com</strong></div></li>
            <li><span class="ic"><i class="bi bi-clock"></i></span><div><small>Hours</small><strong>Sun - Thu, 9 AM - 6 PM</strong></div></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-8">
        <form class="card-jp p-4 p-lg-5" action="#" method="post">
          <h4 class="fw-bold mb-4">Send us a message</h4>
          <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name</label><input type="text" name="name" class="form-control" placeholder="Your name"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" placeholder="you@example.com"></div>
            <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX"></div>
            <div class="col-md-6"><label class="form-label">Subject</label>
              <select name="subject" class="form-select"><option>General Inquiry</option><option>Job Posting</option><option>Payment Issue</option><option>Account Help</option></select>
            </div>
            <div class="col-12"><label class="form-label">Message</label><textarea name="message" rows="5" class="form-control" placeholder="Write your message..."></textarea></div>
            <div class="col-12"><button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send me-1"></i> Send Message</button></div>
          </div>
        </form>
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
