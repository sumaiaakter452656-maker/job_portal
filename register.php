<?php
session_start();
include('dbconfig.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ===== ১. Form-এর তথ্য নেওয়া =====
  $role         = $_POST['role'] == 'employer' ? 'employer' : 'seeker';
  $name         = $conn->real_escape_string(trim($_POST['name']));
  $email        = $conn->real_escape_string(trim($_POST['email']));
  $phone        = $conn->real_escape_string(trim($_POST['phone']));
  $company_name = $conn->real_escape_string(trim($_POST['company_name']));

  // ===== ২. যাচাই (Validation) =====
  if ($name == '' || $email == '' || $_POST['password'] == '') {
    $error = 'Please fill in all required fields.';
  } else if ($_POST['password'] != $_POST['password_confirm']) {
    $error = 'Passwords do not match.';
  } else if ($role == 'employer' && $company_name == '') {
    $error = 'Please enter your company name.';
  } else {
    // একই email দিয়ে আগে account আছে কিনা
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
      $error = 'This email is already registered. Please log in.';
    }
  }

  // ===== ৩. সব ঠিক থাকলে database-এ save =====
  if ($error == '') {
    $password = sha1($_POST['password']);

    // users টেবিলে নতুন user
    $conn->query("INSERT INTO users (name, email, phone, password, role, status)
                  VALUES ('$name', '$email', '$phone', '$password', '$role', 'active')");
    $userId = $conn->insert_id;   // নতুন user-এর id

    if ($role == 'seeker') {
      // seekers টেবিলে খালি profile
      $conn->query("INSERT INTO seekers (user_id) VALUES ($userId)");
    } else {
      // companies টেবিলে company
      $conn->query("INSERT INTO companies (user_id, name) VALUES ($userId, '$company_name')");
    }

    // Login পেজে পাঠানো, সেখানে success message দেখাবে
    header("Location: login.php?registered=1");
    exit;
  }
}

// Error হলে form-এ আগের লেখা রেখে দেওয়ার জন্য
function old($field) {
  return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : '';
}
$isEmployer = isset($_POST['role']) && $_POST['role'] == 'employer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>
<body class="auth-body">

<div class="auth-wrap">
  <aside class="auth-side">
    <a href="index.php" class="logo"><span class="logo-mark">J</span>JobHub</a>
    <div>
      <h2>Your next career move starts here.</h2>
      <ul>
        <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg> 12,000+ verified jobs</li>
        <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg> One-click apply with your saved CV</li>
        <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg> Track every application live</li>
      </ul>
    </div>
    <p class="small mb-0">&copy; 2026 JobHub</p>
  </aside>
  <main class="auth-main">
    <div class="auth-card">

      <h1>Create your account</h1>
      <p class="sub">Choose how you want to use JobHub.</p>
      <?php if ($error != '') { ?>
        <div class="alert alert-danger"><span><?php echo $error; ?></span></div>
      <?php } ?>
      <form action="" method="post">
        <div class="role-switch">
          <div class="role-option"><input type="radio" name="role" value="seeker" id="r-seeker" <?php if (!$isEmployer) echo 'checked'; ?>>
            <label for="r-seeker"><strong><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Job Seeker</strong><small>I want to find a job</small></label></div>
          <div class="role-option"><input type="radio" name="role" value="employer" id="r-employer" <?php if ($isEmployer) echo 'checked'; ?>>
            <label for="r-employer"><strong><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg> Employer</strong><small>I want to hire</small></label></div>
        </div>
        <div class="form-group hidden" data-role-field="employer">
          <label class="form-label">Company name <span class="req">*</span></label>
          <input class="form-control" name="company_name" placeholder="e.g. TechVerse Ltd." value="<?php echo old('company_name'); ?>">
        </div>
        <div class="form-group"><label class="form-label">Full name <span class="req">*</span></label><input class="form-control" name="name" value="<?php echo old('name'); ?>" required></div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Email <span class="req">*</span></label><input class="form-control" type="email" name="email" value="<?php echo old('email'); ?>" required></div>
          <div class="form-group"><label class="form-label">Phone</label><input class="form-control" name="phone" placeholder="01XXXXXXXXX" value="<?php echo old('phone'); ?>"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label class="form-label">Password <span class="req">*</span></label><div class="password-wrap"><input class="form-control" type="password" name="password" required><button type="button" class="toggle-pass">Show</button></div></div>
          <div class="form-group"><label class="form-label">Confirm <span class="req">*</span></label><input class="form-control" type="password" name="password_confirm" required></div>
        </div>
        <label class="check mb-2"><input type="checkbox" name="terms" required> I agree to the <a href="#">Terms</a> &amp; <a href="#">Privacy Policy</a></label>
        <button class="btn btn-primary btn-block btn-lg" type="submit">Create Account</button>
      </form>
      <p class="auth-foot">Already have an account? <a href="login.php">Log in</a></p>
    </div>
  </main>
</div>
<script src="assets/js/main.js"></script>
</body>
</html>
