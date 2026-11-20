<?php
include('../include/check.php');
include('../../dbconfig.php');

$id = (int)$_GET['id'];

$conn->query("DELETE FROM categories WHERE id = '$id'");

header("Location: index.php");
exit;
