<?php
// প্রতিটা admin পেজের উপরে include হয়। Admin login না করলে login পেজে পাঠায়।
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  // admin/categories/ ফোল্ডার থেকে এলে এক ধাপ বেশি উপরে যেতে হয়
  $up = basename(dirname($_SERVER['PHP_SELF'])) == 'admin' ? '../' : '../../';
  header("Location: " . $up . "login.php");
  exit;
}
