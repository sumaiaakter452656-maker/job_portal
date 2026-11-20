<?php
session_start();
include('dbconfig.php');

$error = '';

if (isset($_POST['login'])) {
  $email = $conn->real_escape_string($_POST['email']);
  $password = sha1($_POST['password']);

  $result = $conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
  $row = $result->fetch_assoc();

  if ($result->num_rows > 0) {
    // Store the user's info in the session. Other pages use it to know who is logged in.
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['email']   = $row['email'];
    $_SESSION['name']    = $row['name'];
    $_SESSION['role']    = $row['role'];

    // If ?next= is set (e.g. logged in to Apply/Save), send the seeker back to that page
    $next = isset($_GET['next']) ? $_GET['next'] : '';
    if ($row['role'] == 'seeker' && $next != '' && strpos($next, '://') === false && substr($next, 0, 2) != '//') {
      header("Location: " . $next);
    } else if ($row['role'] == 'admin') {
      header("Location: admin/dashboard.php");
    } else if ($row['role'] == 'employer') {
      header("Location: employer/dashboard.php");
    } else {
      header("Location: seeker/dashboard.php");
    }
    exit;
  } else {
    $error = 'Wrong email or password';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in | JobHub</title>
  <link rel="stylesheet" href="assets/css/style.css?v=2">
</head>

<body class="auth-body">

  <div class="auth-wrap">
    <aside class="auth-side">
      <a href="index.php" class="logo"><span class="logo-mark">J</span>JobHub</a>
      <div>
        <h2>Your next career move starts here.</h2>
        <ul>
          <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
              <polyline points="20 6 9 17 4 12" />
            </svg> 12,000+ verified jobs</li>
          <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
              <polyline points="20 6 9 17 4 12" />
            </svg> One-click apply with your saved CV</li>
          <li><svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
              <polyline points="20 6 9 17 4 12" />
            </svg> Track every application live</li>
        </ul>
      </div>
      <p class="small mb-0">&copy; 2026 JobHub</p>
    </aside>
    <main class="auth-main">
      <div class="auth-card">


        <?php if (isset($_GET['next'])) { ?>
          <div class="alert alert-info"><span>Please log in as a job seeker to continue.</span></div>
        <?php } ?>
        <?php if (isset($_GET['registered'])) { ?>
          <div class="alert alert-success"><span>Account created! Now log in with your email and password.</span></div>
        <?php } ?>
        <?php if ($error != '') { ?>
          <div class="alert alert-danger"><span><?php echo $error; ?></span></div>
        <?php } ?>



        <h1>Welcome back</h1>
        <p class="sub">Log in to continue to your dashboard.</p>
        <!-- <div class="alert alert-danger"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg><span>Invalid email or password. <em>(example error)</em></span><button class="alert-close">&times;</button></div> -->
        <form action="" method="post">
          <div class="form-group">
            <label class="form-label">Email address</label>
            <div class="input-icon"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                <polyline points="22,6 12,13 2,6" />
              </svg><input class="form-control" type="email" name="email" placeholder="you@example.com" required></div>
          </div>
          <div class="form-group">
            <div class="flex justify-between"><label class="form-label">Password</label><a href="forgot-password.php" class="small">Forgot password?</a></div>
            <div class="password-wrap"><input class="form-control" type="password" name="password" placeholder="••••••••" required><button type="button" class="toggle-pass">Show</button></div>
          </div>
          <label class="check mb-2"><input type="checkbox" name="remember"> Remember me</label>
          <button class="btn btn-primary btn-block btn-lg" name="login" type="submit">Log in</button>
        </form>
        <p class="auth-foot">Don't have an account? <a href="register.php">Create one</a></p>
        <!-- <div class="or-divider">Preview dashboards</div>
         <div class="flex gap-1 wrap" style="justify-content:center">
          <a class="btn btn-sm btn-light" href="seeker/dashboard.php">Job Seeker</a>
          <a class="btn btn-sm btn-light" href="employer/dashboard.php">Employer</a>
          <a class="btn btn-sm btn-light" href="admin/dashboard.php">Admin</a>
        </div>  -->
      </div>
    </main>
  </div>
  <script src="assets/js/main.js"></script>
</body>

</html>