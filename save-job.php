<?php
// Save / unsave a job (click once to save, click again to remove)
session_start();
include('dbconfig.php');

$jobId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If the seeker is not logged in, log in first, then come back to this job
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

// Go back to the page the user came from
$back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'job-details.php?id=' . $jobId;
header("Location: " . $back);
exit;
