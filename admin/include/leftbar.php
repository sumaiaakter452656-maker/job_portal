<?php
// Admin sidebar। সব admin পেজ এই ফাইলটা include করে।
// $base দিয়ে ঠিক করা হয় পেজটা admin/ নাকি admin/categories/ ফোল্ডারে আছে
$adminPage = basename($_SERVER['PHP_SELF']);
$inSub = basename(dirname($_SERVER['PHP_SELF'])) != 'admin';
$base = $inSub ? '../' : '';

// না-পড়া contact message কয়টা (টেবিল না থাকলে 0)
$unread = 0;
if (isset($conn)) {
  try {
    $unread = (int)$conn->query("SELECT COUNT(*) AS c FROM contact_messages WHERE is_read = 0")->fetch_assoc()['c'];
  } catch (Exception $e) {
    $unread = 0;
  }
}
?>
<aside class="sidebar">
  <a href="<?php echo $base; ?>../index.php" class="logo"><span class="logo-mark">J</span>JobHub<span class="dot">.</span></a>
  <div class="sidebar-label">Admin menu</div>
  <ul class="sidebar-menu">
    <li><a href="<?php echo $base; ?>dashboard.php" class="<?php if ($adminPage == 'dashboard.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg> Dashboard</a></li>
    <li><a href="<?php echo $base; ?>users.php" class="<?php if ($adminPage == 'users.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Users</a></li>
    <li><a href="<?php echo $base; ?>jobs.php" class="<?php if ($adminPage == 'jobs.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> Jobs</a></li>
    <li><a href="<?php echo $base; ?>companies.php" class="<?php if ($adminPage == 'companies.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="6" x2="15" y2="6"/><line x1="9" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="15" y2="14"/></svg> Companies</a></li>
    <li><a href="<?php echo $base; ?>applications.php" class="<?php if ($adminPage == 'applications.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> Applicants</a></li>
    <li><a href="<?php echo $base; ?>payments.php" class="<?php if ($adminPage == 'payments.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg> Payments</a></li>
    <li><a href="<?php echo $base; ?>messages.php" class="<?php if ($adminPage == 'messages.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v12H5.17L4 17.17V4z"/></svg> Messages<?php if ($unread > 0) echo ' <span class="badge badge-warning">' . $unread . '</span>'; ?></a></li>
    <li><a href="<?php echo $base; ?>reports.php" class="<?php if ($adminPage == 'reports.php') echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><line x1="6" y1="20" x2="6" y2="12"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="18" y1="20" x2="18" y2="9"/></svg> Reports</a></li>
    <li><a href="<?php echo $base; ?>categories/index.php" class="<?php if ($inSub) echo 'active'; ?>"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg> Categories</a></li>
    <li><a href="<?php echo $base; ?>../index.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/></svg> View Website</a></li>
  </ul>
  <div class="sidebar-foot">
    <ul class="sidebar-menu">
      <li><a href="<?php echo $base; ?>../logout.php"><svg class="ic" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg> Logout</a></li>
    </ul>
  </div>
</aside>
<div class="sidebar-backdrop"></div>

<div class="dash-main">
