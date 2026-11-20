<?php
// Job save / unsave করা (একবার চাপলে save, আবার চাপলে বাদ)
session_start();
include('dbconfig.php');

$jobId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Seeker login না করলে আগে login, তারপর এই job-এ ফেরত
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'seeker') {
  header("Location: login.php?next=" . urlencode('job-details.php?id=' . $jobId));
  exit;
}

$uid = (int)$_SESSION['user_id'];
$seeker = $conn->query("SELECT id FROM seekers WHERE user_id = $uid")->fetch_assoc();
$seekerId = (int)$seeker['id'];

$already = $conn->query("SELECT id FROM saved_jobs WHERE seeker_id = $seekerId AND job_id = $jobId");
if ($already->num_rows > 0) {
  $conn->query("DELETE FROM saved_jobs WHERE seeker_id = $seekerId AND job_id = $jobId");
} else {
  $conn->query("INSERT INTO saved_jobs (seeker_id, job_id) VALUES ($seekerId, $jobId)");
}

// যে পেজ থেকে এসেছিল সেখানে ফেরত
$back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'job-details.php?id=' . $jobId;
header("Location: " . $back);
exit;
