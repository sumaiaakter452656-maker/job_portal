<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {

  $up = basename(dirname($_SERVER['PHP_SELF'])) == 'admin' ? '../' : '../../';
  header("Location: " . $up . "login.php");
  exit;
}
