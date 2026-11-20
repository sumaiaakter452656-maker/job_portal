<?php
// =========================================================
// Job Expiry Automation
// Runs automatically once a day:
//   - jobs past their deadline   -> closed
//   - packages past their end date -> expired
// Checked when the Homepage or Admin Dashboard is opened. Admin can also run it with "Run now".
// =========================================================
function run_auto_expire($conn, $force = false) {
  $flag = __DIR__ . '/uploads/last_expire_check.txt';
  $today = date('Y-m-d');

  // Skip if it has already run today
  if (!$force && file_exists($flag) && trim(file_get_contents($flag)) == $today) {
    return null;
  }

  // 1. Close jobs past their deadline, notify the employer
  $jobs = $conn->query("SELECT jobs.id, jobs.title, companies.user_id FROM jobs
                        JOIN companies ON companies.id = jobs.company_id
                        WHERE jobs.status IN ('approved', 'pending') AND jobs.deadline < CURDATE()");
  $closedJobs = 0;
  while ($j = $jobs->fetch_assoc()) {
    $conn->query("UPDATE jobs SET status = 'closed' WHERE id = {$j['id']}");
    $msg = $conn->real_escape_string('Your job "' . $j['title'] . '" was closed automatically because the deadline passed.');
    $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$j['user_id']}, '$msg')");
    $closedJobs++;
  }

  // 2. Expire finished packages, notify the employer
  $subs = $conn->query("SELECT subscriptions.id, subscriptions.user_id, packages.name FROM subscriptions
                        JOIN packages ON packages.id = subscriptions.package_id
                        WHERE subscriptions.status = 'active' AND subscriptions.end_date < CURDATE()");
  $expiredSubs = 0;
  while ($s = $subs->fetch_assoc()) {
    $conn->query("UPDATE subscriptions SET status = 'expired' WHERE id = {$s['id']}");
    $msg = $conn->real_escape_string('Your ' . $s['name'] . ' package has expired. Buy a new package to post more jobs.');
    $conn->query("INSERT INTO notifications (user_id, message) VALUES ({$s['user_id']}, '$msg')");
    $expiredSubs++;
  }

  // Save today's date
  if (!is_dir(__DIR__ . '/uploads')) {
    mkdir(__DIR__ . '/uploads', 0777, true);
  }
  file_put_contents($flag, $today);

  return array('jobs' => $closedJobs, 'packages' => $expiredSubs);
}
