<?php
// প্রতিটা seeker পেজের একদম উপরে এই ফাইলটা include হয়।
// Login না করলে, বা seeker না হলে, login পেজে পাঠিয়ে দেয়।
session_start();
include('../dbconfig.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seeker') {
  header("Location: ../login.php");
  exit;
}

$userId = (int)$_SESSION['user_id'];

// এই user-এর seeker profile (seekers টেবিল থেকে)
$me = $conn->query("SELECT seekers.*, users.name, users.email, users.phone,
                           cities.name AS city_name, categories.name AS category_name
                    FROM seekers
                    JOIN users ON users.id = seekers.user_id
                    LEFT JOIN cities ON cities.id = seekers.city_id
                    LEFT JOIN categories ON categories.id = seekers.category_id
                    WHERE seekers.user_id = $userId")->fetch_assoc();

// seekers টেবিলে row না থাকলে একটা খালি row বানিয়ে দেই
if (!$me) {
  $conn->query("INSERT INTO seekers (user_id) VALUES ($userId)");
  header("Location: dashboard.php");
  exit;
}

$seekerId = (int)$me['id'];

// নামের প্রথম অক্ষরগুলো (যেমন Rahim Uddin -> RU)
$parts = explode(' ', $me['name']);
$initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

// Application status-এর নাম আর badge-এর রং
$statusLabel = array('applied' => 'Applied', 'viewed' => 'Viewed', 'shortlisted' => 'Shortlisted',
                     'interview' => 'Interview', 'hired' => 'Hired', 'rejected' => 'Not selected');
$statusColor = array('applied' => 'badge-gray', 'viewed' => 'badge-info', 'shortlisted' => 'badge-primary',
                     'interview' => 'badge-warning', 'hired' => 'badge-success', 'rejected' => 'badge-danger');
