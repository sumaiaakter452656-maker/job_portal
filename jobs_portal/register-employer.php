<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employer Registration | JobPortal BD</title>
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
      <span class="badge bg-white text-success mb-3"><i class="bi bi-building me-1"></i> Employer</span>
      <h2 class="fw-800 display-6 mb-4">Hire the right talent, faster</h2>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-megaphone fs-4"></i><div><strong>Post jobs in minutes</strong><br><small class="text-white-50">Your first job post is free for 30 days.</small></div></div>
      <div class="d-flex gap-3 mb-3"><i class="bi bi-people fs-4"></i><div><strong>Manage applicants</strong><br><small class="text-white-50">View CVs, shortlist and invite to interview.</small></div></div>
      <div class="d-flex gap-3"><i class="bi bi-phone fs-4"></i><div><strong>Easy local payment</strong><br><small class="text-white-50">Upgrade with bKash, Nagad, Rocket, Card or Bank.</small></div></div>
    </div>
    <small class="text-white-50 position-relative" style="z-index:1">&copy; 2026 JobPortal BD</small>
  </div>

  <div class="col-12 col-lg-7 auth-form">
    <div class="inner" style="max-width:600px">
      <a href="register.php" class="small text-muted d-inline-block mb-3"><i class="bi bi-arrow-left"></i> Back</a>
      <h1 class="h2 fw-800 mb-1">Create Employer Account</h1>
      <p class="text-muted mb-4">Looking for a job? <a href="register-seeker.php" class="fw-semibold">Register as job seeker</a></p>

      <!-- users (role = employer, status = pending) + companies -->
      <form action="#" method="post" enctype="multipart/form-data">
        <input type="hidden" name="role" value="employer">

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-circle me-1"></i> Contact Person</h6>
        <div class="row g-3 mb-4">
          <div class="col-12"><label class="form-label">Full Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" placeholder="e.g. Karim Hossain" required></div>
          <div class="col-md-6"><label class="form-label">Email <span class="text-danger">*</span></label><input type="email" name="email" class="form-control" placeholder="hr@company.com" required></div>
          <div class="col-md-6"><label class="form-label">Phone <span class="text-danger">*</span></label><input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" required></div>
          <div class="col-md-6">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group"><input type="password" name="password" class="form-control" placeholder="Min 6 characters" required><button class="btn btn-light border toggle-password" type="button"><i class="bi bi-eye"></i></button></div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <div class="input-group"><input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required><button class="btn btn-light border toggle-password" type="button"><i class="bi bi-eye"></i></button></div>
          </div>
        </div>

        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-building me-1"></i> Company Information</h6>
        <div class="row g-3">
          <div class="col-md-7"><label class="form-label">Company Name <span class="text-danger">*</span></label><input type="text" name="company_name" class="form-control" placeholder="e.g. TechNova Ltd" required></div>
          <div class="col-md-5">
            <label class="form-label">City</label>
            <select name="city_id" class="form-select">
              <option value="">Select city</option>
              <option value="1">Dhaka</option><option value="2">Chattogram</option><option value="3">Sylhet</option><option value="4">Rajshahi</option>
            </select>
          </div>
          <div class="col-md-6"><label class="form-label">Website</label><input type="url" name="website" class="form-control" placeholder="https://company.com"></div>
          <div class="col-md-6"><label class="form-label">Address</label><input type="text" name="address" class="form-control" placeholder="e.g. Banani, Dhaka"></div>
          <div class="col-12"><label class="form-label">About Company</label><textarea name="description" rows="3" class="form-control" placeholder="What does your company do?"></textarea></div>
          <div class="col-12">
            <label class="form-label">Company Logo</label>
            <div class="upload-zone py-3">
              <input type="file" name="logo" accept="image/*" hidden>
              <i class="bi bi-image fs-3 text-primary"></i>
              <p class="mb-0 fw-semibold small file-name">Click to upload logo</p>
              <small class="text-muted">PNG, JPG up to 1MB</small>
            </div>
          </div>
          <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" id="terms" required><label class="form-check-label small" for="terms">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a></label></div></div>
          <div class="col-12"><button type="submit" class="btn btn-primary btn-lg w-100">Create Employer Account <i class="bi bi-arrow-right ms-1"></i></button></div>
        </div>
      </form>
      <div class="alert alert-warning border-0 rounded-3 small mt-3 mb-0"><i class="bi bi-hourglass-split me-1"></i> Your account will be <strong>pending</strong> until an admin approves it. You'll get a notification once approved.</div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
