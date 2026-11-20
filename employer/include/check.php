<?php
session_start();
include('../dbconfig.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  header("Location: ../login.php");
  exit;
}

$userId = (int)$_SESSION['user_id'];

$company = $conn->query("SELECT companies.*, cities.name AS city_name FROM companies
                         LEFT JOIN cities ON cities.id = companies.city_id
                         WHERE companies.user_id = $userId")->fetch_assoc();

if (!$company) {
  $cname = $conn->real_escape_string($_SESSION['name']);
  $conn->query("INSERT INTO companies (user_id, name) VALUES ($userId, '$cname')");
  header("Location: dashboard.php");
  exit;
}

$companyId = (int)$company['id'];

$sub = $conn->query("SELECT subscriptions.*, packages.name AS package_name FROM subscriptions
                     JOIN packages ON packages.id = subscriptions.package_id
                     WHERE subscriptions.user_id = $userId AND subscriptions.status = 'active'
                       AND subscriptions.end_date >= CURDATE()
                     ORDER BY subscriptions.id DESC LIMIT 1")->fetch_assoc();

// Application status-name & colour
$statusLabel = array('applied' => 'New', 'viewed' => 'Viewed', 'shortlisted' => 'Shortlisted',
                     'interview' => 'Interview', 'hired' => 'Hired', 'rejected' => 'Rejected');
$statusColor = array('applied' => 'badge-gray', 'viewed' => 'badge-info', 'shortlisted' => 'badge-primary',
                     'interview' => 'badge-warning', 'hired' => 'badge-success', 'rejected' => 'badge-danger');
$jobColor    = array('pending' => 'badge-warning', 'approved' => 'badge-success', 'rejected' => 'badge-danger', 'closed' => 'badge-gray');
