<?php
// ব্রাউজারে একবার খুলুন: http://localhost/job_portal/Database/seed.php
// এটা demo_data.sql ফাইলের সব query database-এ চালিয়ে দেয়।
include('../dbconfig.php');

$sql = file_get_contents('demo_data.sql');

if ($conn->multi_query($sql)) {
  // সব query শেষ না হওয়া পর্যন্ত অপেক্ষা
  do {
    if ($result = $conn->store_result()) {
      $result->free();
    }
  } while ($conn->more_results() && $conn->next_result());
}

if ($conn->error) {
  echo "<h3 style='color:red'>Error: " . $conn->error . "</h3>";
} else {
  $total = $conn->query("SELECT COUNT(*) AS c FROM jobs WHERE status = 'approved' AND deadline >= CURDATE()")->fetch_assoc()['c'];
  echo "<h3 style='color:green'>Demo data added! Live jobs now: $total</h3>";
  echo "<a href='../index.php'>Go to homepage</a>";
}
