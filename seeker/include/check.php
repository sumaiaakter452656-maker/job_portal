<?php
// This file is included at the very top of every seeker page.
// If the user is not logged in, or is not a seeker, it sends them to the login page.
session_start();
include('../dbconfig.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seeker') {
  header("Location: ../login.php");
  exit;
}

$userId = (int)$_SESSION['user_id'];

// This user's seeker profile (from the seekers table)
$me = $conn->query("SELECT seekers.*, users.name, users.email, users.phone,
                           cities.name AS city_name, categories.name AS category_name
                    FROM seekers
                    JOIN users ON users.id = seekers.user_id
                    LEFT JOIN cities ON cities.id = seekers.city_id
                    LEFT JOIN categories ON categories.id = seekers.category_id
                    WHERE seekers.user_id = $userId")->fetch_assoc();

// If there is no row in the seekers table, create an empty one
if (!$me) {
  $conn->query("INSERT INTO seekers (user_id) VALUES ($userId)");
  header("Location: dashboard.php");
  exit;
}

$seekerId = (int)$me['id'];

// Initials of the name (e.g. Rahim Uddin -> RU)
$parts = explode(' ', $me['name']);
$initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

// Application status names and badge colours
$statusLabel = array('applied' => 'Applied', 'viewed' => 'Viewed', 'shortlisted' => 'Shortlisted',
                     'interview' => 'Interview', 'hired' => 'Hired', 'rejected' => 'Not selected');
$statusColor = array('applied' => 'badge-gray', 'viewed' => 'badge-info', 'shortlisted' => 'badge-primary',
                     'interview' => 'badge-warning', 'hired' => 'badge-success', 'rejected' => 'badge-danger');
