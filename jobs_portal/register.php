<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Account | JobPortal BD</title>
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

<div class="auth-wrapper">
  <div class="col-lg-5 auth-side d-none d-lg-flex">
    <a class="navbar-brand text-white position-relative" href="index.html" style="z-index:1"><span class="brand-icon bg-white text-primary"><i class="bi bi-briefcase-fill"></i></span>JobPortal BD</a>
    <div class="position-relative" style="z-index:1">
      <h2 class="fw-800 display-6 mb-4">Start your journey today</h2>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-check-circle-fill fs-4 text-white"></i><div><strong>Free for job seekers</strong><br><small class="text-white-50">Build your CV and apply to unlimited jobs.</small></div></div>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-check-circle-fill fs-4 text-white"></i><div><strong>Flexible employer plans</strong><br><small class="text-white-50">Start with a free job post, upgrade anytime.</small></div></div>
      <div class="d-flex gap-3"><i class="bi bi-check-circle-fill fs-4 text-white"></i><div><strong>Real-time notifications</strong><br><small class="text-white-50">Never miss an interview call or new applicant.</small></div></div>
    </div>
    <small class="text-white-50 position-relative" style="z-index:1">&copy; 2026 JobPortal BD</small>
  </div>

  <div class="col-12 col-lg-7 auth-form">
    <div class="inner" style="max-width:520px">
      <a class="navbar-brand d-lg-none mb-4" href="index.html"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal<span class="text-primary">BD</span></a>
      <h1 class="h2 fw-800 mb-1">Join JobPortal BD</h1>
      <p class="text-muted mb-4">Already registered? <a href="login.php" class="fw-semibold">Sign in</a></p>

      <p class="fw-semibold mb-3">How do you want to use JobPortal?</p>
      <div class="row g-3">
        <div class="col-sm-6">
          <a href="register-seeker.php" class="category-card text-center">
            <div class="cat-icon bg-primary-subtle text-primary mx-auto"><i class="bi bi-person-badge"></i></div>
            <h3>I'm a Job Seeker</h3>
            <p class="small text-muted mb-3">Build your CV, apply for jobs and track applications.</p>
            <span class="btn btn-primary btn-sm w-100">Register as Seeker <i class="bi bi-arrow-right"></i></span>
          </a>
        </div>
        <div class="col-sm-6">
          <a href="register-employer.php" class="category-card text-center">
            <div class="cat-icon bg-success-subtle text-success mx-auto"><i class="bi bi-building"></i></div>
            <h3>I'm an Employer</h3>
            <p class="small text-muted mb-3">Create your company profile, post jobs and hire talent.</p>
            <span class="btn btn-accent btn-sm w-100">Register as Employer <i class="bi bi-arrow-right"></i></span>
          </a>
        </div>
      </div>
      <p class="small text-muted mt-4 mb-0"><i class="bi bi-info-circle"></i> Employer accounts are activated after admin approval.</p>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
