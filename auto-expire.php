<?php
// =========================================================
// Job Expiry Automation
// দিনে একবার নিজে থেকে চলে:
//   - deadline পার হওয়া job      -> closed
//   - মেয়াদ শেষ হওয়া package    -> expired
// Homepage আর Admin Dashboard খুললে চেক হয়। Admin চাইলে "Run now" দিয়েও চালাতে পারে।
// =========================================================
function run_auto_expire($conn, $force = false) {
  $flag = __DIR__ . '/uploads/last_expire_check.txt';
  $today = date('Y-m-d');

  // আজ আগে চালানো হয়ে থাকলে আবার না
  if (!$force && file_exists($flag) && trim(file_get_contents($flag)) == $today) {
    return null;
  }

  // ১. Deadline পার হওয়া job বন্ধ, employer-কে notification
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

  // ২. মেয়াদ শেষ হওয়া package বন্ধ, employer-কে notification
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

  // আজকের তারিখ লিখে রাখা
  if (!is_dir(__DIR__ . '/uploads')) {
    mkdir(__DIR__ . '/uploads', 0777, true);
  }
  file_put_contents($flag, $today);

  return array('jobs' => $closedJobs, 'packages' => $expiredSubs);
}
