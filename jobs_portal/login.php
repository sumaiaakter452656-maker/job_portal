<?php
include('config/dbconfig.php');

if (isset($_POST['login'])) {
  extract($_POST);
  $password = sha1($password);

  $result = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");

  $row = $result->fetch_assoc();

  if ($result->num_rows > 0) {
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $row['name'];
    $_SESSION['role'] = $row['role'];

    if ($row['role'] == 'admin') {
      $_SESSION['url'] = 'dashboard.php';
      header("Location: admin/dashboard.php");
    } else if ($row['role'] == 'employer') {
      $_SESSION['url'] = 'dashboard.php';
      header("Location: employer/dashboard.php");
    } else if ($row['role'] == 'seeker') {
      $_SESSION['url'] = 'dashboard.php';
      header("Location: seeker/dashboard.php");
    }
  } else {
    $msg = '<div class="alert border-0 bg-danger-subtle alert-dismissible fade show"><div class="d-flex align-items-center gap-2 text-danger"><i class="bi bi-exclamation-circle"></i> Problem Login</div><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | JobPortal BD</title>
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
      <h2 class="fw-800 display-6 mb-3">Welcome back!</h2>
      <p class="text-white-50 fs-5">Log in to track your applications, manage your jobs and get hired faster.</p>
      <div class="d-flex gap-4 mt-4">
        <div><h3 class="fw-800 mb-0">8+</h3><small class="text-white-50">Live jobs</small></div>
        <div><h3 class="fw-800 mb-0">2+</h3><small class="text-white-50">Companies</small></div>
        <div><h3 class="fw-800 mb-0">4</h3><small class="text-white-50">Cities</small></div>
      </div>
    </div>
    <small class="text-white-50 position-relative" style="z-index:1">&copy; 2026 JobPortal BD</small>
  </div>

  <div class="col-12 col-lg-7 auth-form">
    <div class="inner">
      <a class="navbar-brand d-lg-none mb-4" href="index.html"><span class="brand-icon"><i class="bi bi-briefcase-fill"></i></span>JobPortal<span class="text-primary">BD</span></a>
      <h1 class="h2 fw-800 mb-1">Sign in</h1>
      <p class="text-muted mb-4">Don't have an account? <a href="register.php" class="fw-semibold">Create one</a></p>

      <?php if (isset($msg)) echo $msg; ?>

      <form action="" method="post">
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <div class="input-group"><span class="input-group-text"><i class="bi bi-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="you@example.com" required></div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between"><label class="form-label">Password</label><a href="#" class="small">Forgot password?</a></div>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            <button class="btn btn-light border toggle-password" type="button"><i class="bi bi-eye"></i></button>
          </div>
        </div>
        <div class="form-check mb-4"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
        <button type="submit" name="login" class="btn btn-primary btn-lg w-100">Sign In <i class="bi bi-arrow-right ms-1"></i></button>
      </form>

      <div class="divider-text my-4">Demo dashboards (design preview)</div>
      <div class="row g-2">
        <div class="col-4"><a href="admin/dashboard.php" class="btn btn-light border w-100 btn-sm"><i class="bi bi-shield-lock d-block fs-5"></i>Admin</a></div>
        <div class="col-4"><a href="employer/dashboard.php" class="btn btn-light border w-100 btn-sm"><i class="bi bi-building d-block fs-5"></i>Employer</a></div>
        <div class="col-4"><a href="seeker/dashboard.php" class="btn btn-light border w-100 btn-sm"><i class="bi bi-person d-block fs-5"></i>Seeker</a></div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>