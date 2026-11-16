<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Job Seeker Registration | JobPortal BD</title>
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
      <span class="badge bg-white text-primary mb-3"><i class="bi bi-person-badge me-1"></i> Job Seeker</span>
      <h2 class="fw-800 display-6 mb-4">Your next job is one click away</h2>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-file-earmark-person fs-4"></i><div><strong>Free CV builder</strong><br><small class="text-white-50">Choose Modern or Classic template and download as PDF.</small></div></div>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-send-check fs-4"></i><div><strong>One-click apply</strong><br><small class="text-white-50">Apply with your profile CV or upload your own.</small></div></div>
      <div class="d-flex gap-3"><i class="bi bi-graph-up fs-4"></i><div><strong>Track every application</strong><br><small class="text-white-50">From viewed to shortlisted, interview and hired.</small></div></div>
    </div>
    <small class="text-white-50 position-relative" style="z-index:1">&copy; 2026 JobPortal BD</small>
  </div>

  <div class="col-12 col-lg-7 auth-form">
    <div class="inner" style="max-width:560px">
      <a href="register.php" class="small text-muted d-inline-block mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <h1 class="h2 fw-800 mb-1">Create Job Seeker Account</h1>
      <p class="text-muted mb-4">Hiring instead? <a href="register-employer.php" class="fw-semibold">Register as employer</a></p>

      <!-- users (role = seeker) + seekers -->
      <form action="#" method="post">
        <input type="hidden" name="role" value="seeker">

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-circle me-1"></i> Account Information</h6>
        <div class="row g-3 mb-4">
          <div class="col-12"><label class="form-label">Full Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" placeholder="e.g. Rahim Uddin" required></div>
          <div class="col-md-6"><label class="form-label">Email <span class="text-danger">*</span></label><input type="email" name="email" class="form-control" placeholder="you@example.com" required></div>
          <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX"></div>
          <div class="col-md-6">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group"><input type="password" name="password" class="form-control" placeholder="Min 6 characters" required><button class="btn btn-light border toggle-password" type="button"><i class="bi bi-eye"></i></button></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group"><input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required><button class="btn btn-light border toggle-password" type="button"><i class="bi bi-eye"></i></button></div>
          </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-briefcase me-1"></i> Career Information</h6>
        <div class="row g-3">
          <div class="col-12"><label class="form-label">Headline</label><input type="text" name="headline" class="form-control" placeholder="e.g. Junior PHP Developer"></div>
          <div class="col-md-6">
            <label class="form-label">Preferred Category</label>
            <select name="category_id" class="form-select">
              <option value="">Select category</option>
              <option value="1">IT / Software</option><option value="2">Sales</option><option value="3">Accounts</option><option value="4">Design</option><option value="6">Developer</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">City</label>
            <select name="city_id" class="form-select">
              <option value="">Select city</option>
              <option value="1">Dhaka</option><option value="2">Chattogram</option><option value="3">Sylhet</option><option value="4">Rajshahi</option>
            </select>
          </div>
          <div class="col-md-6"><label class="form-label">Experience (years)</label><input type="number" name="experience_years" class="form-control" min="0" max="50" value="0"></div>
          <div class="col-md-6">
            <label class="form-label">Expected Salary</label>
            <div class="input-group"><span class="input-group-text">৳</span><input type="number" step="0.01" name="expected_salary" class="form-control" placeholder="35000"></div>
          </div>
          <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" id="terms" required><label class="form-check-label small" for="terms">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a></label></div></div>
          <div class="col-12"><button type="submit" class="btn btn-primary btn-lg w-100">Create My Account <i class="bi bi-arrow-right ms-1"></i></button></div>
        </div>
      </form>
      <p class="small text-muted mt-3 mb-0"><i class="bi bi-lightbulb text-warning"></i> You can add education, experience, skills and projects from your dashboard after sign up.</p>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
