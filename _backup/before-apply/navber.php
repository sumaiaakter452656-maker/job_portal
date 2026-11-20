<?php
// কোন পেজ খোলা আছে, সেটা দেখে মেনুতে "active" class বসানো হবে
$page = basename($_SERVER['PHP_SELF']);
?>
<header class="navbar">
  <div class="container">
    <a href="index.php" class="logo"><span class="logo-mark">J</span>JobHub<span class="dot">.</span></a>
    <button class="icon-btn nav-toggle" data-nav-toggle aria-label="Menu"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
    <ul class="nav-links">
      <li><a href="index.php" class="<?php if ($page == 'index.php') echo 'active'; ?>">Home</a></li>
      <li><a href="jobs.php" class="<?php if ($page == 'jobs.php' || $page == 'job-details.php') echo 'active'; ?>">Find Jobs</a></li>
      <li><a href="companies.php" class="<?php if ($page == 'companies.php') echo 'active'; ?>">Companies</a></li>
      <li><a href="contact.php" class="<?php if ($page == 'contact.php') echo 'active'; ?>">Contact</a></li>
      <li><a href="components.php">UI Kit</a></li>
    </ul>
    <div class="nav-actions">
      <a href="login.php" class="btn btn-ghost">Log in</a>
      <a href="register.php" class="btn btn-light">Sign up</a>
      <a href="employer/post-job.php" class="btn btn-primary">Post a Job</a>
    </div>
  </div>
</header>
